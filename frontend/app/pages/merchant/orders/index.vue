<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 p-6 pb-16 pt-24 md:p-10">
		<div class="mx-auto max-w-6xl">
			<nav class="mb-4 flex flex-wrap items-center gap-2 text-xs text-slate-600">
				<NuxtLink class="hover:text-slate-900" to="/merchant">Overview</NuxtLink>
				<span class="material-symbols-outlined text-sm">chevron_right</span>
				<span class="font-semibold text-slate-900">All orders</span>
			</nav>

			<header class="mb-8">
				<h1 class="text-3xl font-bold tracking-tight text-slate-900">All orders</h1>
				<p class="mt-2 text-base text-slate-600">
					<span v-if="pending">Loading orders…</span>
					<span v-else>{{ orders.length }} {{ orders.length === 1 ? 'order' : 'orders' }} across your stores.</span>
				</p>
				<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
			</header>

			<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading…</div>

			<div
				v-else-if="orders.length === 0"
				class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center"
			>
				<p class="font-medium text-slate-800">No orders yet</p>
				<p class="mt-2 text-sm text-slate-600">When customers buy from any of your stores, orders will appear here.</p>
				<NuxtLink to="/merchant/stores" class="mt-6 inline-flex rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">
					View my stores
				</NuxtLink>
			</div>

			<div v-else>
				<div class="hidden overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm md:block">
					<div class="overflow-x-auto">
						<table class="w-full min-w-[720px] border-collapse text-left">
							<thead>
								<tr class="border-b border-slate-200 bg-slate-50">
									<th class="p-4 text-sm font-semibold text-slate-600">Order</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Store</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Customer</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Date</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Items</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Total</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Status</th>
									<th class="w-24 p-4 text-sm font-semibold text-slate-600"></th>
								</tr>
							</thead>
							<tbody class="divide-y divide-slate-100">
								<tr v-for="o in orders" :key="o.id" class="hover:bg-slate-50/80">
									<td class="p-4 text-sm font-semibold text-slate-900">#{{ o.id }}</td>
									<td class="p-4 text-sm text-slate-600">#{{ o.store_id }}</td>
									<td class="p-4 text-sm text-slate-600">{{ o.customer_display_name || '—' }}</td>
									<td class="p-4 text-sm text-slate-600">{{ format_order_date(o.placed_at) }}</td>
									<td class="p-4 text-sm text-slate-600">{{ o.item_count ?? '—' }}</td>
									<td class="p-4 text-sm font-bold text-slate-900">{{ format_money(o.price_total) }}</td>
									<td class="p-4">
										<span class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
											{{ humanize_status(o.status) }}
										</span>
									</td>
									<td class="p-4">
										<NuxtLink
											:to="`/merchant/stores/${o.store_id}/orders/${o.id}`"
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

				<div class="md:hidden flex flex-col gap-4">
					<NuxtLink
						v-for="o in orders"
						:key="o.id"
						:to="`/merchant/stores/${o.store_id}/orders/${o.id}`"
						class="block rounded-xl border border-slate-200 bg-white p-4 shadow-sm hover:border-slate-900"
					>
						<div class="mb-2 flex justify-between gap-2">
							<span class="font-semibold text-slate-900">#{{ o.id }}</span>
							<span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700">
								{{ humanize_status(o.status) }}
							</span>
						</div>
						<p class="text-sm text-slate-600">Store #{{ o.store_id }} · {{ o.customer_display_name || '—' }}</p>
						<p class="mt-1 text-sm text-slate-600">{{ format_order_date(o.placed_at) }}</p>
						<p class="mt-3 text-lg font-bold text-slate-900">{{ format_money(o.price_total) }}</p>
					</NuxtLink>
				</div>
			</div>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { MerchantOrderRow } from '~/types/merchant';
import { merchantFetchAllOrders } from '~/composables/useMerchant';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-merchant'],
});

const pending = ref(true);
const error_message = ref<string | null>(null);
const orders = ref<MerchantOrderRow[]>([]);

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

function format_order_date(raw: string) {
	try {
		const d = new Date(raw);
		if (Number.isNaN(d.getTime())) return raw;
		return new Intl.DateTimeFormat('en-GB', { dateStyle: 'medium', timeStyle: 'short' }).format(d);
	} catch {
		return raw;
	}
}

function humanize_status(s: string) {
	return s.replaceAll('_', ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}

onMounted(async () => {
	pending.value = true;
	error_message.value = null;
	try {
		orders.value = await merchantFetchAllOrders();
	} catch (e: unknown) {
		error_message.value =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load orders';
		orders.value = [];
	} finally {
		pending.value = false;
	}
});
</script>

