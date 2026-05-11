<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 pb-16 pt-24">
		<header
			class="sticky top-0 z-30 flex h-16 items-center justify-between border-b border-slate-200 bg-white px-6"
		>
			<h1 class="truncate text-xl font-semibold text-slate-900">{{ store?.name ?? 'Store' }}</h1>
		</header>

		<div class="mx-auto max-w-5xl space-y-8 p-6 md:p-8">
			<div v-if="invalid_id" class="rounded-xl border border-slate-200 bg-white p-8 text-center">
				<p class="text-slate-700">Invalid store link.</p>
				<NuxtLink to="/merchant/stores" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to my stores</NuxtLink>
			</div>

			<template v-else>
				<nav class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
					<NuxtLink class="hover:text-slate-900" to="/merchant">Overview</NuxtLink>
					<span class="material-symbols-outlined text-sm">chevron_right</span>
					<NuxtLink class="hover:text-slate-900" to="/merchant/stores">My stores</NuxtLink>
					<span class="material-symbols-outlined text-sm">chevron_right</span>
					<span class="font-semibold text-slate-900">{{ store?.name ?? 'Store' }}</span>
				</nav>

				<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading…</div>

				<template v-else-if="not_found">
					<div class="rounded-xl border border-slate-200 bg-white p-10 text-center">
						<p class="font-medium text-slate-800">Store not found</p>
						<NuxtLink to="/merchant/stores" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to my stores</NuxtLink>
					</div>
				</template>

				<template v-else-if="store">
					<div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
						<div>
							<h2 class="text-3xl font-bold tracking-tight text-slate-900">{{ store.name }}</h2>
							<p v-if="store.description" class="mt-2 max-w-2xl text-slate-600">{{ store.description }}</p>
						</div>
						<div class="flex flex-wrap gap-3">
							<NuxtLink
								:to="`/products?store_id=${store.id}`"
								class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-white"
							>
								View catalogue (store)
							</NuxtLink>
							<NuxtLink
								:to="`/merchant/stores/${store.id}/edit`"
								class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
							>
								Edit store
							</NuxtLink>
						</div>
					</div>

					<div class="grid gap-4 sm:grid-cols-3">
						<NuxtLink
							:to="`/merchant/stores/${store.id}/orders`"
							class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-colors hover:border-slate-900"
						>
							<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Orders</p>
							<p class="mt-2 text-2xl font-bold text-slate-900">{{ order_count }}</p>
							<p class="mt-2 text-sm font-semibold text-slate-900">Manage →</p>
						</NuxtLink>
						<NuxtLink
							:to="`/merchant/stores/${store.id}/products`"
							class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-colors hover:border-slate-900 sm:col-span-2"
						>
							<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Products</p>
							<p class="mt-2 text-sm text-slate-600">View and manage products in this store (same catalogue flow as customers, scoped to your store).</p>
							<p class="mt-3 text-sm font-semibold text-slate-900">Open products →</p>
						</NuxtLink>
					</div>

					<section class="rounded-xl border border-slate-200 bg-white shadow-sm">
						<div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
							<h3 class="text-lg font-semibold text-slate-900">Recent orders</h3>
							<NuxtLink :to="`/merchant/stores/${store.id}/orders`" class="text-sm font-semibold text-slate-900 hover:underline">
								View all
							</NuxtLink>
						</div>
						<div v-if="orders_pending" class="p-8 text-center text-slate-600">Loading…</div>
						<div v-else-if="preview_orders.length === 0" class="p-8 text-center text-slate-600">No orders yet.</div>
						<ul v-else class="divide-y divide-slate-100">
							<li v-for="o in preview_orders" :key="o.id">
								<NuxtLink
									:to="`/merchant/stores/${store.id}/orders/${o.id}`"
									class="flex flex-col gap-1 px-4 py-4 hover:bg-slate-50 sm:flex-row sm:items-center sm:justify-between"
								>
									<div>
										<span class="font-semibold text-slate-900">#{{ o.id }}</span>
										<span class="ml-2 text-sm text-slate-600">{{ o.customer_display_name || 'Customer' }}</span>
									</div>
									<div class="flex flex-wrap items-center gap-3 text-sm">
										<span class="text-slate-600">{{ format_order_date(o.placed_at) }}</span>
										<span class="font-bold text-slate-900">{{ format_money(o.price_total) }}</span>
										<span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-700">
											{{ humanize_status(o.status) }}
										</span>
									</div>
								</NuxtLink>
							</li>
						</ul>
					</section>
				</template>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { MerchantOrderRow, MerchantStore } from '~/types/merchant';
import { merchantFetchOrders, merchantFetchStore } from '~/composables/useMerchant';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-merchant'],
});

const route = useRoute();

const store_numeric_id = computed(() => {
	const raw = route.params.storeId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const invalid_id = computed(() => store_numeric_id.value === null);

const pending = ref(true);
const orders_pending = ref(false);
const not_found = ref(false);
const store = ref<MerchantStore | null>(null);
const orders = ref<MerchantOrderRow[]>([]);

const order_count = computed(() => orders.value.length);
const preview_orders = computed(() => orders.value.slice(0, 6));

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

async function load() {
	if (invalid_id.value) {
		pending.value = false;
		return;
	}
	pending.value = true;
	not_found.value = false;
	store.value = null;
	try {
		store.value = await merchantFetchStore(store_numeric_id.value!);
		orders_pending.value = true;
		try {
			orders.value = await merchantFetchOrders(store_numeric_id.value!);
		} finally {
			orders_pending.value = false;
		}
	} catch (e: unknown) {
		const status = e && typeof e === 'object' && 'status' in e ? (e as { status?: number }).status : undefined;
		if (status === 404) {
			not_found.value = true;
		}
		store.value = null;
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
