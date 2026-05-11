<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 p-6 pb-16 pt-24 md:p-10">
		<div class="mx-auto max-w-4xl">
			<div v-if="invalid_ids" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
				<p class="font-medium text-slate-800">Invalid link</p>
				<NuxtLink v-if="store_id" :to="`/merchant/stores/${store_id}/orders`" class="mt-4 inline-block font-semibold underline">
					Back to store orders
				</NuxtLink>
			</div>

			<template v-else>
				<BreadcrumbsComponent class="mb-4" :items="order_detail_crumbs" />

				<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading order…</div>

				<div v-else-if="not_found" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
					<p class="font-medium text-slate-800">We could not find this order</p>
					<NuxtLink
						:to="`/merchant/stores/${store_id}/orders`"
						class="mt-6 inline-flex rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800"
					>
						Back to orders
					</NuxtLink>
				</div>

				<div v-else-if="wrong_store" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
					<p class="font-medium text-slate-800">This order does not belong to this store.</p>
					<NuxtLink :to="`/merchant/stores/${store_id}/orders`" class="mt-4 inline-block font-semibold underline">Back to orders</NuxtLink>
				</div>

				<template v-else-if="order">
					<div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
						<div>
							<h1 class="text-3xl font-bold text-slate-900">Order #{{ order.id }}</h1>
							<p class="mt-2 text-sm text-slate-600">
								Placed {{ formatOrderPlacedAt(order.placed_at, 'detail') }} · {{ order.customer_display_name || 'Customer' }}
							</p>
							<p v-if="order.customer_email" class="text-sm text-slate-500">{{ order.customer_email }}</p>
						</div>
						<div class="flex flex-wrap items-center gap-2">
							<OrdersStatusBadgeComponent variant="header" :status="order.status" />
							<button
								v-if="order.status === 'paid'"
								type="button"
								:disabled="shipping"
								class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 disabled:pointer-events-none disabled:opacity-50"
								@click="mark_shipped"
							>
								{{ shipping ? 'Updating…' : 'Mark as shipped' }}
							</button>
						</div>
					</div>

					<p v-if="order.status === 'paid'" class="mb-4 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
						When you ship, the customer sees the same status progression as on their order detail page.
					</p>

					<p v-if="error_message" class="mb-4 text-sm text-red-600">{{ error_message }}</p>

					<section class="mb-8 overflow-hidden rounded-xl border border-slate-200 bg-white">
						<div class="border-b border-slate-100 bg-slate-50/80 px-4 py-3">
							<h2 class="text-sm font-semibold uppercase tracking-wide text-slate-600">Items</h2>
						</div>
						<ul class="divide-y divide-slate-100">
							<li v-for="line in order.items" :key="`${line.product_id}-${line.quantity}`" class="flex items-start gap-4 p-4">
								<div class="size-20 shrink-0 overflow-hidden rounded-lg border border-slate-200/60 bg-slate-100">
									<img :alt="line.product_name" class="size-full object-cover" :src="line.thumbnail || placeholder_image" />
								</div>
								<div class="min-w-0 flex-1">
									<p class="font-semibold text-slate-900">{{ line.product_name }}</p>
									<p class="mt-1 text-xs text-slate-500">
										{{ format_money(line.price_at_purchase_in_gbp) }} each · Qty {{ line.quantity }}
									</p>
								</div>
								<p class="shrink-0 font-semibold text-slate-900">{{ format_money(line.line_total) }}</p>
							</li>
						</ul>
						<div class="flex items-center justify-between border-t border-slate-100 bg-slate-50/50 px-4 py-4">
							<span class="font-semibold text-slate-900">Total</span>
							<span class="text-xl font-bold text-slate-900">{{ format_money(order.price_total) }}</span>
						</div>
					</section>

					<div class="flex flex-wrap gap-3">
						<NuxtLink
							:to="`/merchant/stores/${store_id}/orders`"
							class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50"
						>
							All store orders
						</NuxtLink>
						<NuxtLink
							:to="`/merchant/stores/${store_id}`"
							class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
						>
							Store home
						</NuxtLink>
					</div>
				</template>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';
import type { MerchantOrderDetail } from '~/types/merchant';
import { merchantFetchOrder, merchantFetchStore, merchantMarkOrderShipped } from '~/composables/useMerchant';
import { formatOrderPlacedAt } from '~/utils/order-display';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-merchant'],
});

const route = useRoute();

const store_id = computed(() => {
	const raw = route.params.storeId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const order_id = computed(() => {
	const raw = route.params.orderId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const invalid_ids = computed(() => store_id.value === null || order_id.value === null);

const pending = ref(true);
const shipping = ref(false);
const not_found = ref(false);
const wrong_store = ref(false);
const error_message = ref<string | null>(null);
const order = ref<MerchantOrderDetail | null>(null);
const store_name = ref('Store');

const order_detail_crumbs = computed<BreadcrumbItem[]>(() => {
	const sid = store_id.value;
	const oid = order_id.value;
	if (sid == null || oid == null) return [];
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: store_name.value, to: `/merchant/stores/${sid}` },
		{ label: 'Orders', to: `/merchant/stores/${sid}/orders` },
		{ label: `Order #${oid}` },
	];
});

const placeholder_image = '/images/product-placeholder.svg';

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

function parse_api_error(e: unknown): string {
	if (e && typeof e === 'object' && 'message' in e) {
		return String((e as { message?: string }).message);
	}
	return 'Request failed';
}

async function mark_shipped() {
	if (!order.value || order_id.value == null || shipping.value) return;
	shipping.value = true;
	error_message.value = null;
	try {
		await merchantMarkOrderShipped(order_id.value);
		await load();
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
	} finally {
		shipping.value = false;
	}
}

async function load() {
	if (invalid_ids.value) {
		pending.value = false;
		return;
	}
	pending.value = true;
	not_found.value = false;
	wrong_store.value = false;
	error_message.value = null;
	order.value = null;
	try {
		const st = await merchantFetchStore(store_id.value!);
		store_name.value = st.name?.trim() ? st.name : 'Store';
		const o = await merchantFetchOrder(order_id.value!);
		if (o.store_id !== store_id.value) {
			wrong_store.value = true;
			return;
		}
		order.value = o;
	} catch (e: unknown) {
		const status = e && typeof e === 'object' && 'status' in e ? (e as { status?: number }).status : undefined;
		if (status === 404) {
			not_found.value = true;
		} else {
			error_message.value = parse_api_error(e);
		}
	} finally {
		pending.value = false;
	}
}

watch(
	() => [route.params.storeId, route.params.orderId],
	() => {
		load();
	},
);

onMounted(() => {
	load();
});
</script>
