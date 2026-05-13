<template>
	<main class="mx-auto w-full max-w-6xl grow px-4 py-16 md:px-6">
		<div class="mb-8">
			<BreadcrumbsComponent
				class="mb-3"
				:items="[
					{ label: 'Home', to: '/' },
					{ label: 'Order History' },
				]"
			/>
			<h1 class="font-bold tracking-tight text-3xl md:text-4xl text-slate-900">Order History</h1>
			<p class="font-normal text-base text-slate-600 mt-2">
				<span v-if="pending">Loading your orders…</span>
				<span v-else>{{ orders.length }} {{ orders.length === 1 ? 'order' : 'orders' }} on your account.</span>
			</p>
			<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
		</div>

		<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
			Loading…
		</div>

		<div
			v-else-if="orders.length === 0"
			class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center"
		>
			<p class="text-slate-700 font-medium mb-2">You have not placed any orders yet</p>
			<p class="text-slate-600 text-sm mb-6">When you check out, your purchases will appear here.</p>
			<NuxtLink
				to="/products"
				class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white hover:bg-slate-800 transition-colors"
			>
				Browse products
			</NuxtLink>
		</div>

		<div v-else>
			<div class="md:hidden flex flex-col gap-4">
				<NuxtLink
					v-for="order in orders"
					:key="order.id"
					:to="`/orders/${order.id}`"
					class="block rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-slate-900 transition-colors"
				>
					<div class="flex justify-between items-start gap-3 mb-2">
						<span class="font-semibold text-slate-900">#{{ order.id }}</span>
						<OrdersStatusBadgeComponent :status="order.status" />
					</div>
					<p class="text-sm text-slate-600">{{ formatOrderPlacedAt(order.placed_at, 'list') }}</p>
					<p class="text-sm text-slate-600 mt-1">
						{{ order.item_count ?? '—' }} {{ (order.item_count ?? 0) === 1 ? 'item' : 'items' }} · Store
						{{ order.store_id }}
					</p>
					<p class="text-lg font-bold text-slate-900 mt-3">{{ format_money(order.price_total) }}</p>
				</NuxtLink>
			</div>

			<div class="hidden md:block rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
			<div class="overflow-x-auto">
				<table class="w-full text-left border-collapse min-w-[640px]">
					<thead>
						<tr class="bg-slate-50 border-b border-slate-200">
							<th class="p-4 font-semibold text-sm text-slate-600">Order</th>
							<th class="p-4 font-semibold text-sm text-slate-600">Date</th>
							<th class="p-4 font-semibold text-sm text-slate-600">Store</th>
							<th class="p-4 font-semibold text-sm text-slate-600">Items</th>
							<th class="p-4 font-semibold text-sm text-slate-600">Total</th>
							<th class="p-4 font-semibold text-sm text-slate-600">Status</th>
							<th class="p-4 font-semibold text-sm text-slate-600 w-28"></th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-100">
						<tr v-for="order in orders" :key="order.id" class="hover:bg-slate-50/80 transition-colors">
							<td class="p-4 font-semibold text-sm text-slate-900">#{{ order.id }}</td>
							<td class="p-4 text-sm text-slate-600">{{ formatOrderPlacedAt(order.placed_at, 'list') }}</td>
							<td class="p-4 text-sm text-slate-600">{{ order.store_id }}</td>
							<td class="p-4 text-sm text-slate-600">{{ order.item_count ?? '—' }}</td>
							<td class="p-4 text-sm font-bold text-slate-900">{{ format_money(order.price_total) }}</td>
							<td class="p-4">
								<OrdersStatusBadgeComponent :status="order.status" />
							</td>
							<td class="p-4">
								<NuxtLink
									:to="`/orders/${order.id}`"
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
	</main>
</template>

<script setup lang="ts">
import type { CustomerOrder } from '~/types/customer';
import { formatOrderPlacedAt } from '~/utils/order-display';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const api = useApi();

const pending = ref(true);
const error_message = ref<string | null>(null);
const orders = ref<CustomerOrder[]>([]);

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

async function load() {
	error_message.value = null;
	pending.value = true;
	try {
		orders.value = await api.get<CustomerOrder[]>('/customer/orders');
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load orders';
		error_message.value = msg;
		orders.value = [];
	} finally {
		pending.value = false;
	}
}

onMounted(() => {
	load();
});
</script>
