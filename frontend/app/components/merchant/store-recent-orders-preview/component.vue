<template>
	<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
			<h3 class="text-lg font-semibold text-slate-900">Recent orders</h3>
			<NuxtLink :to="`/merchant/stores/${store_id}/orders`" class="text-sm font-semibold text-slate-900 hover:underline">
				View all
			</NuxtLink>
		</div>
		<div v-if="pending" class="p-8 text-center text-slate-600">Loading…</div>
		<div v-else-if="orders.length === 0" class="p-8 text-center text-slate-600">No orders yet.</div>
		<ul v-else class="divide-y divide-slate-100">
			<li v-for="o in orders" :key="o.id">
				<NuxtLink
					:to="`/merchant/stores/${store_id}/orders/${o.id}`"
					class="flex flex-col gap-1 px-4 py-4 hover:bg-slate-50 sm:flex-row sm:items-center sm:justify-between"
				>
					<div>
						<span class="font-semibold text-slate-900">#{{ o.id }}</span>
						<span class="ml-2 text-sm text-slate-600">{{ o.customer_display_name || 'Customer' }}</span>
					</div>
					<div class="flex flex-wrap items-center gap-3 text-sm">
						<span class="text-slate-600">{{ formatOrderPlacedAt(o.placed_at, 'list') }}</span>
						<span class="font-bold text-slate-900">{{ getPoundAndPenceFormat(o.price_total) }}</span>
						<OrdersStatusBadgeComponent :status="o.status" />
					</div>
				</NuxtLink>
			</li>
		</ul>
	</section>
</template>

<script setup lang="ts">
import type { MerchantOrderRow } from '~/types/merchant';
import { formatOrderPlacedAt } from '~/utils/order-display';
import { getPoundAndPenceFormat } from '~/utils/money';

defineProps<{
	store_id: number;
	orders: MerchantOrderRow[];
	pending: boolean;
}>();
</script>
