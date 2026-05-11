<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 p-6 pb-16 pt-24 md:p-10">
		<div class="mx-auto max-w-6xl">
			<BreadcrumbsComponent class="mb-4" :items="products_crumbs" />

			<div v-if="invalid_id" class="rounded-xl border border-slate-200 bg-white p-8 text-center text-slate-700">Invalid store.</div>

			<template v-else>
				<header class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
					<div>
						<h1 class="text-3xl font-bold text-slate-900">Products</h1>
						<p class="mt-1 text-slate-600">Catalogue for {{ store_name }} — same product data customers see, filtered by store.</p>
					</div>
					<div class="flex flex-wrap gap-3">
						<!-- <NuxtLink
							:to="`/products?store_id=${store_id}`"
							class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-white"
						>
							View as shopper
						</NuxtLink> -->
						<NuxtLink
							:to="`/merchant/stores/${store_id}/products/new`"
							class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
						>
							Add product
						</NuxtLink>
					</div>
				</header>

				<p v-if="error_message" class="mb-4 text-sm text-red-600">{{ error_message }}</p>

				<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading products…</div>

				<div
					v-else-if="products.length === 0"
					class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-600"
				>
					No active products for this store yet.
				</div>

				<div v-else class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
					<div class="overflow-x-auto">
						<table class="w-full min-w-[640px] border-collapse text-left">
							<thead>
								<tr class="border-b border-slate-200 bg-slate-50">
									<th class="p-4 text-sm font-semibold text-slate-600">Product</th>
									<th class="p-4 text-sm font-semibold text-slate-600">SKU</th>
									<th class="p-4 text-sm font-semibold text-slate-600">Category</th>
									<th class="p-4 text-right text-sm font-semibold text-slate-600">Price</th>
									<th class="p-4 text-right text-sm font-semibold text-slate-600">Stock</th>
									<th class="p-4 text-sm font-semibold text-slate-600"></th>
								</tr>
							</thead>
							<tbody class="divide-y divide-slate-100">
								<tr v-for="p in products" :key="p.id" class="hover:bg-slate-50/80">
									<td class="p-4">
										<NuxtLink
											:to="`/merchant/stores/${store_id}/products/${p.id}`"
											class="flex items-center gap-3 hover:underline"
										>
											<div class="size-12 shrink-0 overflow-hidden rounded-md border border-slate-200 bg-slate-100">
												<img
													:alt="p.name"
													class="size-full object-cover"
													:src="p.thumbnail || '/images/product-placeholder.svg'"
												/>
											</div>
											<span class="font-semibold text-slate-900">{{ p.name }}</span>
										</NuxtLink>
									</td>
									<td class="p-4 text-sm text-slate-600">{{ p.sku_code }}</td>
									<td class="p-4 text-sm text-slate-600">{{ p.product_category_name }}</td>
									<td class="p-4 text-right text-sm font-bold text-slate-900">{{ format_money(p.price_in_gbp) }}</td>
									<td class="p-4 text-right text-sm text-slate-600">{{ p.number_in_stock }}</td>
									<td class="p-4">
										<NuxtLink
											:to="`/merchant/stores/${store_id}/products/${p.id}/edit`"
											class="text-sm font-semibold text-slate-900 hover:underline"
										>
											Edit
										</NuxtLink>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';
import type { MerchantProduct, MerchantStore } from '~/types/merchant';
import { merchantFetchStore, merchantFetchStoreProducts } from '~/composables/useMerchant';
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

const store_name = ref('Store');
const error_message = ref<string | null>(null);

const products = ref<MerchantProduct[]>([]);
const pending = ref(true);

const products_crumbs = computed<BreadcrumbItem[]>(() => {
	const id = store_id.value;
	if (id == null) return [];
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: store_name.value, to: `/merchant/stores/${id}` },
		{ label: 'Products' },
	];
});

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

async function load() {
	if (store_id.value == null) return;
	error_message.value = null;
	try {
		const s: MerchantStore = await merchantFetchStore(store_id.value);
		store_name.value = s.name;
		pending.value = true;
		products.value = await merchantFetchStoreProducts(store_id.value);
	} catch (e: unknown) {
		error_message.value =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load';
		products.value = [];
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
