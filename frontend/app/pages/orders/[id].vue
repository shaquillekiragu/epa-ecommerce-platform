<template>
	<main class="grow pt-24 pb-16 px-4 md:px-6 max-w-4xl mx-auto w-full">
		<div v-if="invalid_id" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
			<p class="text-slate-700 font-medium mb-4">Invalid order link</p>
			<NuxtLink to="/orders" class="font-semibold text-slate-900 underline">Back to my orders</NuxtLink>
		</div>

		<template v-else>
			<nav class="flex items-center gap-2 text-xs text-slate-600 mb-4">
				<NuxtLink class="hover:text-slate-900" to="/orders">My orders</NuxtLink>
				<span class="material-symbols-outlined text-sm">chevron_right</span>
				<span class="text-slate-900 font-semibold">Order #{{ order_id }}</span>
			</nav>

			<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
				Loading order…
			</div>

			<div v-else-if="not_found" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
				<p class="text-slate-700 font-medium mb-2">We could not find this order</p>
				<p class="text-slate-600 text-sm mb-6">It may belong to another account or the link is wrong.</p>
				<NuxtLink
					to="/orders"
					class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white hover:bg-slate-800 transition-colors"
				>
					Back to my orders
				</NuxtLink>
			</div>

			<template v-else-if="order">
				<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
					<div>
						<h1 class="font-bold tracking-tight text-3xl text-slate-900">Order #{{ order.id }}</h1>
						<p class="text-slate-600 text-sm mt-2">
							Placed {{ format_order_date(order.placed_at) }} · Store {{ order.store_id }}
						</p>
					</div>
					<div class="flex flex-wrap items-center gap-2">
						<span
							class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-800"
						>
							{{ humanize_status(order.status) }}
						</span>
						<button
							v-if="order.status === 'pending_payment'"
							type="button"
							class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition-colors"
							@click="go_pay"
						>
							Pay now
						</button>
						<button
							v-if="order.status === 'paid'"
							type="button"
							:disabled="cancelling"
							class="inline-flex items-center justify-center rounded-lg border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50 transition-colors disabled:opacity-50 disabled:pointer-events-none"
							@click="confirm_cancel_order"
						>
							{{ cancelling ? 'Cancelling…' : 'Cancel order' }}
						</button>
					</div>
				</div>

				<p
					v-if="order.status === 'paid'"
					class="text-sm text-slate-600 mb-4 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3"
				>
					You can cancel before the store ships. If you paid by card, we will refund this order’s total to your
					payment method (allow a few days for your bank to show it).
				</p>

				<p v-if="error_message" class="text-sm text-red-600 mb-4">{{ error_message }}</p>

				<section class="rounded-xl border border-slate-200 bg-white overflow-hidden mb-8">
					<div class="px-4 py-3 border-b border-slate-100 bg-slate-50/80">
						<h2 class="font-semibold text-sm uppercase tracking-wide text-slate-600">Items</h2>
					</div>
					<ul class="divide-y divide-slate-100">
						<li
							v-for="line in order.items"
							:key="`${line.product_id}-${line.quantity}`"
							class="p-4 flex gap-4 items-start"
						>
							<div class="size-20 bg-slate-100 rounded-lg overflow-hidden shrink-0 border border-slate-200/60">
								<img
									:alt="line.product_name"
									class="size-full object-cover"
									:src="line.thumbnail || placeholder_image"
								/>
							</div>
							<div class="grow min-w-0">
								<NuxtLink
									:to="productDetailRoute(line.product_id, slug_from_name(line.product_name))"
									class="font-semibold text-slate-900 hover:underline line-clamp-2"
								>
									{{ line.product_name }}
								</NuxtLink>
								<p class="text-xs text-slate-500 mt-1">
									{{ format_money(line.price_at_purchase_in_gbp) }} each · Qty {{ line.quantity }}
								</p>
							</div>
							<p class="font-semibold text-slate-900 shrink-0">{{ format_money(line.line_total) }}</p>
						</li>
					</ul>
					<div class="px-4 py-4 border-t border-slate-100 bg-slate-50/50 flex justify-between items-center">
						<span class="font-semibold text-slate-900">Total</span>
						<span class="text-xl font-bold text-slate-900">{{ format_money(order.price_total) }}</span>
					</div>
				</section>

				<div class="flex flex-wrap gap-3">
					<NuxtLink
						to="/orders"
						class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50 transition-colors"
					>
						All orders
					</NuxtLink>
					<NuxtLink
						to="/products"
						class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 transition-colors"
					>
						Continue shopping
					</NuxtLink>
				</div>
			</template>
		</template>
	</main>
</template>

<script setup lang="ts">
import type { CustomerOrderDetail } from '~/types/customer';
import { productDetailRoute } from '~/composables/useProducts';
import { slugify } from '~/utils/strings';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const CHECKOUT_PENDING_KEY = 'checkout_pending_order_ids';

const route = useRoute();
const api = useApi();

const pending = ref(true);
const cancelling = ref(false);
const not_found = ref(false);
const error_message = ref<string | null>(null);
const order = ref<CustomerOrderDetail | null>(null);

const { refresh: refresh_order_notifications } = useOrderNotifications();

const placeholder_image = '/images/product-placeholder.svg';

const order_id = computed(() => {
	const raw = route.params.id;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const invalid_id = computed(() => order_id.value === null);

function slug_from_name(name: string) {
	const s = slugify(name);
	return s || 'product';
}

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

function format_order_date(raw: string) {
	try {
		const d = new Date(raw);
		if (Number.isNaN(d.getTime())) return raw;
		return new Intl.DateTimeFormat('en-GB', { dateStyle: 'long', timeStyle: 'short' }).format(d);
	} catch {
		return raw;
	}
}

function humanize_status(s: string) {
	return s.replaceAll('_', ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}

function go_pay() {
	if (!order.value || typeof sessionStorage === 'undefined') {
		return;
	}
	sessionStorage.setItem(CHECKOUT_PENDING_KEY, JSON.stringify([order.value.id]));
	return navigateTo('/checkout/pay');
}

function parse_api_error(e: unknown): string {
	if (e && typeof e === 'object' && 'message' in e) {
		const raw = String((e as { message?: string }).message);
		try {
			const parsed = JSON.parse(raw) as Record<string, string[]>;
			const first = Object.values(parsed)[0];
			if (Array.isArray(first) && first[0]) {
				return first[0]!;
			}
		} catch {
			return raw;
		}
		return raw;
	}
	return 'Request failed';
}

async function confirm_cancel_order() {
	if (!order.value || order_id.value == null || cancelling.value) {
		return;
	}
	const ok = window.confirm(
		'Cancel this order? If you paid by card, the order total will be refunded. This cannot be undone.',
	);
	if (!ok) {
		return;
	}
	cancelling.value = true;
	error_message.value = null;
	try {
		await api.post(`/customer/orders/${order_id.value}/cancel`);
		await load();
		refresh_order_notifications();
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
	} finally {
		cancelling.value = false;
	}
}

async function load() {
	if (invalid_id.value) {
		pending.value = false;
		return;
	}

	pending.value = true;
	not_found.value = false;
	error_message.value = null;
	order.value = null;

	try {
		order.value = await api.get<CustomerOrderDetail>(`/customer/orders/${order_id.value}`);
	} catch (e: unknown) {
		const status = e && typeof e === 'object' && 'status' in e ? (e as { status?: number }).status : undefined;
		if (status === 404) {
			not_found.value = true;
		} else {
			error_message.value =
				e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load order';
		}
	} finally {
		pending.value = false;
	}
}

watch(
	() => route.params.id,
	() => {
		load();
	},
);

onMounted(() => {
	load();
});
</script>
