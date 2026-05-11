<template>
	<main class="grow pt-32 pb-24 px-6">
		<div class="max-w-4xl mx-auto">
			<div v-if="pending" class="text-center text-slate-600 py-16">Loading your order…</div>

			<template v-else>
				<div class="text-center mb-12">
					<div class="inline-flex items-center justify-center size-20 bg-slate-900 text-white rounded-full mb-6">
						<span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1">check_circle</span>
					</div>
					<h1 class="font-bold tracking-tight text-4xl leading-tight text-slate-900 mb-2">Order confirmed</h1>
					<p class="font-normal text-slate-600 max-w-lg mx-auto">
						Thank you for your purchase. Your basket has been cleared and your seller orders are on file.
					</p>
					<div v-if="order_ids_display.length" class="mt-4 flex flex-wrap justify-center gap-2">
						<span
							v-for="oid in order_ids_display"
							:key="oid"
							class="inline-block bg-slate-100 px-4 py-2 rounded-xl text-sm"
						>
							<span class="font-semibold text-slate-600 uppercase tracking-widest">Order #</span>
							<span class="text-slate-900 ml-1 font-bold">{{ oid }}</span>
						</span>
					</div>
				</div>

				<div v-if="load_error" class="rounded-xl border border-amber-200 bg-amber-50 p-6 text-amber-900 text-center mb-8">
					{{ load_error }}
				</div>

				<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
					<div
						class="md:col-span-1 bg-white border border-slate-200 p-8 rounded-xl shadow-[0_4px_12px_rgba(15,23,42,0.05)]"
					>
						<h3 class="font-semibold text-sm mb-8 uppercase tracking-widest text-slate-600">What happens next</h3>
						<div class="relative space-y-12">
							<div class="absolute left-4 top-2 bottom-2 w-0.5 bg-slate-100"></div>
							<div class="relative flex items-center gap-6">
								<div class="z-10 size-8 rounded-full bg-slate-900 flex items-center justify-center text-white">
									<span class="material-symbols-outlined text-sm">check</span>
								</div>
								<div>
									<p class="font-semibold text-slate-900">Order placed</p>
									<p class="text-[10px] text-slate-600 uppercase">Recorded</p>
								</div>
							</div>
							<div class="relative flex items-center gap-6">
								<div
									class="z-10 size-8 rounded-full bg-slate-900 flex items-center justify-center text-white ring-4 ring-primary/10"
								>
									<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1"
										>payments</span
									>
								</div>
								<div>
									<p class="font-semibold text-slate-900">Payment pending</p>
									<p class="text-[10px] text-slate-600 uppercase">Awaiting PSP / merchant</p>
								</div>
							</div>
							<div class="relative flex items-center gap-6 opacity-40">
								<div class="z-10 size-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
									<span class="material-symbols-outlined text-sm">inventory_2</span>
								</div>
								<div>
									<p class="font-semibold text-slate-500">Fulfilment</p>
									<p class="text-[10px] uppercase">When payment clears</p>
								</div>
							</div>
						</div>
					</div>

					<div
						class="md:col-span-2 bg-white border border-slate-200 rounded-xl shadow-[0_4px_12px_rgba(15,23,42,0.05)] overflow-hidden flex flex-col"
					>
						<div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
							<h3 class="font-semibold text-sm uppercase tracking-widest text-slate-600">Order summary</h3>
							<span class="font-medium text-slate-600">{{ total_line_count }} items</span>
						</div>
						<div class="grow overflow-y-auto max-h-[320px]">
							<div class="divide-y divide-slate-100">
								<template v-for="group in order_groups" :key="group.order_id">
									<div v-if="order_groups.length > 1" class="px-6 py-2 bg-slate-50 text-xs font-semibold text-slate-600">
										Store order #{{ group.order_id }} · {{ format_money(group.subtotal) }}
									</div>
									<div
										v-for="row in group.rows"
										:key="`${group.order_id}-${row.product_id}`"
										class="p-6 flex items-center gap-4 hover:bg-slate-50 transition-colors"
									>
										<div class="size-16 bg-slate-100 rounded overflow-hidden shrink-0">
											<img
												:alt="row.product_name"
												class="size-full object-cover"
												:src="row.thumbnail || placeholder_image"
											/>
										</div>
										<div class="grow min-w-0">
											<p class="font-semibold text-slate-900 truncate">{{ row.product_name }}</p>
											<p class="text-xs text-slate-600">Qty {{ row.quantity }}</p>
										</div>
										<p class="font-semibold text-slate-900 shrink-0">{{ format_money(row.line_total) }}</p>
									</div>
								</template>
							</div>
						</div>
						<div class="p-6 bg-slate-50/50 border-t border-slate-100">
							<div class="flex justify-between items-center mb-4">
								<span class="text-slate-900 font-bold">Total</span>
								<span class="font-semibold tracking-tight text-slate-900">{{ format_money(grand_total) }}</span>
							</div>
						</div>
					</div>

					<div class="md:col-span-3 mt-4 flex flex-col md:flex-row gap-4 justify-center items-center">
						<NuxtLink
							to="/account"
							class="w-full md:w-auto px-10 py-4 bg-slate-900 text-white font-semibold rounded-xl hover:opacity-90 transition-all active:scale-95 duration-200 flex items-center justify-center gap-2 text-center"
						>
							View account
							<span class="material-symbols-outlined text-sm">person</span>
						</NuxtLink>
						<NuxtLink
							to="/products"
							class="w-full md:w-auto px-10 py-4 border-2 border-slate-900 text-slate-900 font-semibold rounded-xl hover:bg-slate-50 transition-all active:scale-95 duration-200 text-center"
						>
							Continue shopping
						</NuxtLink>
					</div>
				</div>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { CustomerOrderDetail, CustomerOrderLine } from '~/types/customer';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const LAST_CHECKOUT_STORAGE_KEY = 'last_checkout_orders';

const route = useRoute();
const api = useApi();

const pending = ref(true);
const load_error = ref<string | null>(null);
const order_details = ref<CustomerOrderDetail[]>([]);

const placeholder_image = '/images/category-placeholder.svg';

const order_ids_display = computed(() => order_details.value.map((o) => o.id));

type Row = CustomerOrderLine & { order_id: number };

const order_groups = computed(() => {
	const groups: { order_id: number; subtotal: number; rows: Row[] }[] = [];
	for (const o of order_details.value) {
		const rows = o.items.map((item) => ({
			...item,
			order_id: o.id,
		}));
		groups.push({
			order_id: o.id,
			subtotal: o.price_total,
			rows,
		});
	}
	return groups;
});

const total_line_count = computed(() =>
	order_details.value.reduce((sum, o) => sum + o.items.reduce((s, i) => s + i.quantity, 0), 0),
);

const grand_total = computed(() => order_details.value.reduce((sum, o) => sum + o.price_total, 0));

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

async function load() {
	pending.value = true;
	load_error.value = null;
	order_details.value = [];

	const q = route.query.ids;
	const from_query = typeof q === 'string' && q.length > 0 ? q.split(',').map((s) => Number.parseInt(s, 10)).filter(Boolean) : [];

	let ids = [...from_query];

	if (ids.length === 0 && typeof sessionStorage !== 'undefined') {
		const raw = sessionStorage.getItem(LAST_CHECKOUT_STORAGE_KEY);
		if (raw) {
			try {
				const parsed = JSON.parse(raw) as Array<{ id: number }>;
				ids = parsed.map((p) => p.id).filter(Boolean);
			} catch {
				/* ignore */
			}
		}
	}

	if (ids.length === 0) {
		load_error.value = 'No recent order reference was found. Open your account to see past orders.';
		pending.value = false;
		return;
	}

	try {
		const details = await Promise.all(ids.map((id) => api.get<CustomerOrderDetail>(`/customer/orders/${id}`)));
		order_details.value = details;
		if (typeof sessionStorage !== 'undefined') {
			sessionStorage.removeItem(LAST_CHECKOUT_STORAGE_KEY);
		}
	} catch {
		load_error.value = 'We could not load order details. Your orders may still be visible under your account.';
	} finally {
		pending.value = false;
	}
}

onMounted(() => {
	load();
});
</script>
