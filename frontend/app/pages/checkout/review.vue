<template>
	<main class="pt-24 pb-8 px-6 max-w-7xl mx-auto min-h-screen">
		<div class="mb-6">
			<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900">Checkout: Review</h1>
			<p class="font-normal text-base text-slate-600 mt-2">
				<span v-if="pending">Loading your order…</span>
				<span v-else>Verify your basket and shipping details before confirming.</span>
			</p>
			<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
		</div>

		<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
			Loading…
		</div>

		<div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-grid_gutter">
			<div class="lg:col-span-8 space-y-grid_gutter">
				<div class="grid grid-cols-1 md:grid-cols-2 gap-grid_gutter">
					<div class="bg-white border border-slate-400 p-4">
						<div class="flex items-center justify-between mb-2">
							<h2 class="font-semibold text-sm uppercase text-slate-600">Shipping address</h2>
							<NuxtLink to="/checkout" class="text-slate-700 hover:underline font-medium text-xs">Change</NuxtLink>
						</div>
						<div v-if="shipping_address" class="font-normal text-base text-slate-900">
							<p class="font-bold">{{ customer_name }}</p>
							<p class="whitespace-pre-line">{{ format_address(shipping_address) }}</p>
							<p class="mt-3 text-slate-600 text-sm">Standard shipping — fulfilment times vary by seller.</p>
						</div>
						<p v-else class="text-slate-600 text-sm">No address selected. Go back to shipping to choose one.</p>
					</div>

					<div class="bg-white border border-slate-400 p-4">
						<div class="flex items-center justify-between mb-2">
							<h2 class="font-semibold text-sm uppercase text-slate-600">Billing address</h2>
							<NuxtLink to="/checkout" class="text-slate-700 hover:underline font-medium text-xs">Change</NuxtLink>
						</div>
						<div v-if="shipping_address" class="font-normal text-base text-slate-900">
							<p class="font-bold">{{ customer_name }}</p>
							<p class="whitespace-pre-line">{{ format_address(shipping_address) }}</p>
						</div>
					</div>
				</div>

				<div class="bg-white border border-slate-400 p-4">
					<div class="flex items-center justify-between mb-2">
						<h2 class="font-semibold text-sm uppercase text-slate-600">Payment</h2>
					</div>
					<div class="flex items-start gap-3">
						<div class="w-12 h-8 bg-slate-100 rounded-sm flex items-center justify-center shrink-0">
							<span class="material-symbols-outlined text-slate-600">payments</span>
						</div>
						<div class="font-normal text-base text-slate-900">
							<p class="font-semibold">Stripe (test mode)</p>
							<p class="text-sm text-slate-600 mt-1">
								After you confirm, you will be taken to a secure card step. Orders stay
								<strong>pending payment</strong> until the charge succeeds.
							</p>
						</div>
					</div>
				</div>

				<div class="bg-white border border-slate-400 overflow-hidden">
					<div class="p-4 border-b border-slate-400">
						<h2 class="font-semibold text-sm uppercase text-slate-600">
							Your basket ({{ item_count }} {{ item_count === 1 ? 'item' : 'items' }})
						</h2>
					</div>
					<div class="divide-y divide-slate-300">
						<div v-for="line in lines" :key="line.product_id" class="p-4 flex items-start gap-4">
							<div class="w-24 h-32 bg-slate-100 shrink-0 overflow-hidden">
								<img
									:alt="line.product_name"
									class="size-full object-cover"
									:src="line.thumbnail || placeholder_image"
								/>
							</div>
							<div class="grow min-w-0">
								<div class="flex justify-between items-start gap-4">
									<div class="min-w-0">
										<h3 class="font-semibold tracking-tight text-lg text-slate-900 truncate">
											{{ line.product_name }}
										</h3>
										<p class="font-normal text-xs text-slate-600 mt-1">{{ format_money(line.price_in_gbp) }} each</p>
									</div>
									<span class="text-lg font-bold text-slate-900 shrink-0">{{ format_money(line.line_total) }}</span>
								</div>
								<p class="mt-2 font-medium text-xs text-slate-600">Qty: {{ line.quantity }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="lg:col-span-4">
				<div class="sticky top-24 space-y-md">
					<div class="bg-slate-200 border border-slate-400 p-4">
						<h2 class="font-semibold tracking-tight text-xl leading-snug mb-4">Order summary</h2>
						<div class="space-y-sm">
							<div class="flex justify-between font-normal text-base text-slate-600">
								<span>Subtotal</span>
								<span>{{ format_money(subtotal) }}</span>
							</div>
							<div class="flex justify-between font-normal text-base text-slate-600">
								<span>Shipping</span>
								<span class="text-slate-700 font-medium">Free</span>
							</div>
							<div
								class="pt-2 border-t border-slate-400 mt-2 flex justify-between font-bold tracking-tight text-[24px] text-slate-900"
							>
								<span>Total</span>
								<span>{{ format_money(subtotal) }}</span>
							</div>
						</div>
						<div class="mt-4">
							<button
								type="button"
								:disabled="submitting || !can_submit"
								class="w-full bg-slate-900 text-white py-4 font-semibold text-sm uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-[0.98] duration-200 disabled:opacity-50 disabled:pointer-events-none"
								@click="confirm_checkout"
							>
								{{ submitting ? 'Placing order…' : 'Confirm & pay' }}
							</button>
						</div>
						<p class="mt-4 font-medium text-xs text-slate-600 text-center">
							By placing this order you agree to our terms of sale with each participating store.
						</p>
						<div class="flex flex-col gap-2 px-3 items-center mt-3">
							<div class="flex items-center gap-1 text-slate-600">
								<span class="material-symbols-outlined text-xl">shield</span>
								<span class="font-medium text-xs">Your session is protected with HTTPS.</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BasketLine, BasketResponse } from '~/types/basket';
import type { CustomerAddress } from '~/types/customer';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

type CheckoutOrdersPayload = {
	orders: Array<{
		id: number;
		store_id: number;
		status: string;
		price_total: number;
		placed_at: string;
	}>;
};

const LAST_CHECKOUT_STORAGE_KEY = 'last_checkout_orders';

const api = useApi();
const { user, refresh_me } = useAuth();
const { refresh_basket_item_count } = useBasketItemCount();

const checkout_selected_address_id = useState<number | null>('checkout_selected_address_id', () => null);

const pending = ref(true);
const submitting = ref(false);
const error_message = ref<string | null>(null);
const basket = ref<BasketResponse | null>(null);
const addresses = ref<CustomerAddress[]>([]);

const placeholder_image = '/images/category-placeholder.svg';

const lines = computed<BasketLine[]>(() => basket.value?.items ?? []);
const subtotal = computed(() => basket.value?.price_total ?? 0);
const item_count = computed(() => lines.value.reduce((sum, l) => sum + l.quantity, 0));

const shipping_address = computed(() => {
	const id = checkout_selected_address_id.value;
	if (id == null) {
		return null;
	}
	return addresses.value.find((a) => a.id === id) ?? null;
});

const customer_name = computed(() => user.value?.full_name ?? 'Customer');

const can_submit = computed(() => lines.value.length > 0 && shipping_address.value != null);

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

function format_address(a: CustomerAddress) {
	const line1 = `${a.building_number} ${a.street_name}`.trim();
	const parts = [line1, a.city, a.region, a.post_code, a.country].filter(Boolean);
	return parts.join('\n');
}

async function load() {
	error_message.value = null;
	pending.value = true;
	try {
		if (!user.value) {
			await refresh_me();
		}
		const [b, addr_list] = await Promise.all([
			api.get<BasketResponse>('/basket'),
			api.get<CustomerAddress[]>('/customer/addresses'),
		]);
		basket.value = b;
		addresses.value = addr_list;

		const sel = checkout_selected_address_id.value;
		if (sel != null && !addr_list.some((a) => a.id === sel)) {
			checkout_selected_address_id.value = addr_list[0]?.id ?? null;
		}
		if (checkout_selected_address_id.value == null && addr_list.length > 0) {
			checkout_selected_address_id.value = addr_list[0]!.id;
		}
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load checkout';
		error_message.value = msg;
	} finally {
		pending.value = false;
	}
}

async function confirm_checkout() {
	if (!can_submit.value) {
		return;
	}
	submitting.value = true;
	error_message.value = null;
	try {
		const res = await api.post<CheckoutOrdersPayload>('/checkout');
		if (typeof sessionStorage !== 'undefined') {
			sessionStorage.setItem(LAST_CHECKOUT_STORAGE_KEY, JSON.stringify(res.orders));
			sessionStorage.setItem(
				'checkout_pending_order_ids',
				JSON.stringify(res.orders.map((o) => o.id)),
			);
		}
		await refresh_basket_item_count();
		await navigateTo('/checkout/pay');
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Checkout failed';
		error_message.value = msg;
	} finally {
		submitting.value = false;
	}
}

onMounted(() => {
	load();
});
</script>
