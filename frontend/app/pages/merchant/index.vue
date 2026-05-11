<template>
	<main class="flex min-h-screen w-full flex-1 flex-col bg-slate-50 py-16">
		<div class="mx-auto w-full max-w-5xl flex-1 space-y-8 p-6">
			<div>
				<h2 class="text-3xl font-bold tracking-tight text-slate-900">
					Welcome back<span v-if="first_name">, {{ first_name }}</span>
				</h2>
				<p class="mt-1 text-base text-slate-600">Manage your stores and customer orders from here.</p>
				<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
			</div>

			<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-10 text-center text-slate-600">
				Loading…
			</div>

			<template v-else>
				<section class="grid gap-4 sm:grid-cols-3">
					<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Stores</p>
						<p class="mt-2 text-3xl font-bold text-slate-900">{{ stores.length }}</p>
						<NuxtLink to="/merchant/stores" class="mt-3 inline-block text-sm font-semibold text-slate-900 underline">
							View all stores
						</NuxtLink>
					</div>
					<div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2">
						<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Quick actions</p>
						<div class="mt-4 flex flex-wrap gap-3">
							<NuxtLink
								to="/merchant/stores"
								class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
							>
								My stores
							</NuxtLink>
							<NuxtLink
								v-if="stores[0]"
								to="/merchant/orders"
								class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50"
							>
								All orders
							</NuxtLink>
						</div>
					</div>
				</section>

				<section v-if="stores.length === 0" class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center">
					<p class="font-medium text-slate-800">No stores yet</p>
					<p class="mt-2 text-sm text-slate-600">Create a store to start selling and receive orders.</p>
					<NuxtLink
						to="/merchant/stores/new"
						class="mt-6 inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800"
					>
						Add a store
					</NuxtLink>
				</section>

				<section v-else class="rounded-xl border border-slate-200 bg-white shadow-sm">
					<div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
						<h3 class="text-lg font-semibold text-slate-900">Recent orders</h3>
						<NuxtLink
							v-if="stores[0]"
							to="/merchant/orders"
							class="text-sm font-semibold text-slate-900 hover:underline"
						>
							View all
						</NuxtLink>
					</div>
					<div v-if="orders_pending" class="p-8 text-center text-slate-600">Loading orders…</div>
					<div v-else-if="recent_orders.length === 0" class="p-8 text-center text-slate-600">No orders for your first store yet.</div>
					<div v-else class="overflow-x-auto">
						<table class="w-full min-w-[640px] border-collapse text-left">
							<thead>
								<tr class="border-b border-slate-100 bg-slate-50">
									<th class="p-4 text-sm font-semibold text-slate-600">Order</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Customer</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Date</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Total</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Status</th>
									<th class="p-4 text-sm font-semibold text-slate-600"></th>
								</tr>
							</thead>
							<tbody class="divide-y divide-slate-100">
								<tr v-for="o in recent_orders" :key="o.id" class="hover:bg-slate-50/80">
									<td class="p-4 text-sm font-semibold text-slate-900">#{{ o.id }}</td>
									<td class="p-4 text-sm text-slate-600">{{ o.customer_display_name || '—' }}</td>
									<td class="p-4 text-sm text-slate-600">{{ formatOrderPlacedAt(o.placed_at, 'list') }}</td>
									<td class="p-4 text-sm font-bold text-slate-900">{{ format_money(o.price_total) }}</td>
									<td class="p-4">
										<OrdersStatusBadgeComponent :status="o.status" />
									</td>
									<td class="p-4">
										<NuxtLink
											v-if="stores[0]"
											:to="`/merchant/stores/${stores[0].id}/orders/${o.id}`"
											class="text-sm font-semibold text-slate-900 hover:underline"
										>
											View
										</NuxtLink>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { MerchantOrderRow, MerchantStore } from '~/types/merchant';
import { merchantFetchOrders, merchantFetchStores } from '~/composables/useMerchant';
import { formatOrderPlacedAt } from '~/utils/order-display';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-merchant'],
});

const { user, refresh_me } = useAuth();

const pending = ref(true);
const orders_pending = ref(false);
const error_message = ref<string | null>(null);
const stores = ref<MerchantStore[]>([]);
const recent_orders = ref<MerchantOrderRow[]>([]);

const first_name = computed(() => (user.value?.first_name ?? '').trim());

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

onMounted(async () => {
	error_message.value = null;
	pending.value = true;
	try {
		await refresh_me();
		stores.value = await merchantFetchStores();
		const first_store = stores.value[0];
		if (first_store) {
			orders_pending.value = true;
			try {
				const all = await merchantFetchOrders(first_store.id);
				recent_orders.value = all.slice(0, 8);
			} catch {
				recent_orders.value = [];
			} finally {
				orders_pending.value = false;
			}
		}
	} catch (e: unknown) {
		error_message.value =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load';
		stores.value = [];
	} finally {
		pending.value = false;
	}
});
</script>
