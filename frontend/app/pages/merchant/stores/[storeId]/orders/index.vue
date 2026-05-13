<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 px-6 py-16 md:px-10">
		<div class="mx-auto max-w-6xl">
			<BreadcrumbsComponent class="mb-4" :items="store_orders_crumbs" />

			<div v-if="invalid_id" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
				<p class="text-slate-700">Invalid store.</p>
				<NuxtLink to="/merchant/stores" class="mt-4 inline-block font-semibold underline">Back to my stores</NuxtLink>
			</div>

			<template v-else>
				<header class="mb-8">
					<h1 class="text-3xl font-bold tracking-tight text-slate-900">Store orders</h1>
					<p class="mt-2 text-base text-slate-600">
						<span v-if="pending">Loading orders…</span>
						<span v-else>{{ orders.length }} {{ orders.length === 1 ? 'order' : 'orders' }} for {{ store_name }}.</span>
					</p>
					<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
				</header>

				<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading…</div>

				<div
					v-else-if="orders.length === 0"
					class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center"
				>
					<p class="font-medium text-slate-800">No orders yet</p>
					<p class="mt-2 text-sm text-slate-600">When customers check out from this store, orders appear here (same journey as “Order History” for customers).</p>
					<NuxtLink
						v-if="store_id"
						:to="`/merchant/stores/${store_id}`"
						class="mt-6 inline-flex rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800"
					>
						Back to store
					</NuxtLink>
				</div>

				<div v-else>
					<div class="flex flex-col gap-4 md:hidden">
						<NuxtLink
							v-for="order in orders"
							:key="order.id"
							:to="`/merchant/stores/${store_id}/orders/${order.id}`"
							class="block rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-slate-900"
						>
							<div class="mb-2 flex justify-between gap-2">
								<span class="font-semibold text-slate-900">#{{ order.id }}</span>
								<OrdersStatusBadgeComponent :status="order.status" />
							</div>
							<p class="text-sm text-slate-600">{{ order.customer_display_name || '—' }}</p>
							<p class="mt-1 text-sm text-slate-600">{{ formatOrderPlacedAt(order.placed_at, 'list') }}</p>
							<p class="mt-3 text-lg font-bold text-slate-900">{{ format_money(order.price_total) }}</p>
						</NuxtLink>
					</div>

					<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm md:block">
						<div class="overflow-x-auto">
							<table class="w-full min-w-[720px] border-collapse text-left">
								<thead>
									<tr class="border-b border-slate-200 bg-slate-50">
										<th class="p-4 text-sm font-semibold text-slate-600">Order</th>
										<th class="p-4 text-sm font-semibold text-slate-600">Customer</th>
										<th class="p-4 text-sm font-semibold text-slate-600">Date</th>
										<th class="p-4 text-sm font-semibold text-slate-600">Items</th>
										<th class="p-4 text-sm font-semibold text-slate-600">Total</th>
										<th class="p-4 text-sm font-semibold text-slate-600">Status</th>
										<th class="w-24 p-4 text-sm font-semibold text-slate-600"></th>
									</tr>
								</thead>
								<tbody class="divide-y divide-slate-100">
									<tr v-for="order in orders" :key="order.id" class="hover:bg-slate-50/80">
										<td class="p-4 text-sm font-semibold text-slate-900">#{{ order.id }}</td>
										<td class="p-4 text-sm text-slate-600">{{ order.customer_display_name || '—' }}</td>
										<td class="p-4 text-sm text-slate-600">{{ formatOrderPlacedAt(order.placed_at, 'list') }}</td>
										<td class="p-4 text-sm text-slate-600">{{ order.item_count ?? '—' }}</td>
										<td class="p-4 text-sm font-bold text-slate-900">{{ format_money(order.price_total) }}</td>
										<td class="p-4">
											<OrdersStatusBadgeComponent :status="order.status" />
										</td>
										<td class="p-4">
											<NuxtLink
												:to="`/merchant/stores/${store_id}/orders/${order.id}`"
												class="text-sm font-semibold text-slate-900 hover:underline"
											>
												View
											</NuxtLink>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';
import type { MerchantOrderRow, MerchantStore } from '~/types/merchant';
import { merchantFetchOrders, merchantFetchStore } from '~/composables/useMerchant';
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

const invalid_id = computed(() => store_id.value === null);

const pending = ref(true);
const error_message = ref<string | null>(null);
const orders = ref<MerchantOrderRow[]>([]);
const store_name = ref('Store');

const store_orders_crumbs = computed<BreadcrumbItem[]>(() => {
	const id = store_id.value;
	if (id == null) return [];
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: store_name.value, to: `/merchant/stores/${id}` },
		{ label: 'Orders' },
	];
});

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

async function load() {
	if (store_id.value == null) {
		pending.value = false;
		return;
	}
	pending.value = true;
	error_message.value = null;
	try {
		const store: MerchantStore = await merchantFetchStore(store_id.value);
		store_name.value = store.name;
		orders.value = await merchantFetchOrders(store_id.value);
	} catch (e: unknown) {
		error_message.value =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load';
		orders.value = [];
	} finally {
		pending.value = false;
	}
}

watch(
	() => route.params.storeId,
	() => {
		load();
	},
);

onMounted(() => {
	load();
});
</script>
