<template>
	<main class="w-screen flex px-24 py-16">
		<FilterSidePanelComponent v-model="list_filters" />

		<section class="grow flex flex-col items-center gap-10 px-12">
			<article class="w-full flex flex-col items-stretch sm:flex-row sm:justify-between sm:items-center gap-4">
				<h1 class="text-4xl font-medium">Premium Collection</h1>

				<select
					v-model="sort_key"
					class="border focus:ring-0 cursor-pointer hidden sm:block w-1/3"
				>
					<option value="recommended">Recommended</option>
					<option value="price_asc">Price: Low to High</option>
					<option value="price_desc">Price: High to Low</option>
					<option value="newest">Newest Arrivals</option>
				</select>
			</article>

			<p v-if="pending" class="text-slate-600 w-full text-center">Loading products…</p>
			<p v-else-if="fetch_error" class="text-red-600 w-full text-center">Could not load products.</p>

			<section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-10">
				<CardListComponent :cards="paged_products" :has_limit="false" layout="portrait" variant="catalogue-product" />
			</section>

			<UPagination v-model:page="page" active-color="neutral" size="xl" :items-per-page="items_per_page" :total="products.length" class="mt-4" />
		</section>
	</main>
</template>

<script setup lang="ts">
import { useProducts, type ProductsQuery } from '~/composables/useProducts';
import type { ProductListFilters } from '~/types/product-list-filters';

const list_filters = ref<ProductListFilters>({
	categoryIds: [],
	priceMin: '',
	priceMax: '',
	stock: 'all',
});

const sort_key = ref<'recommended' | 'price_asc' | 'price_desc' | 'newest'>('recommended');

const { product_cards, refresh, pending, error } = useProducts({}, { disableAutoload: true, stateKey: 'catalog' });

const products = computed(() => product_cards.value);
const fetch_error = computed(() => error.value);
const page = ref(1);

const items_per_page = 5;

function buildProductsQuery(): ProductsQuery {
	const q: ProductsQuery = {};

	if (list_filters.value.categoryIds.length > 0) {
		q.categories = list_filters.value.categoryIds.join(',');
	}

	const minRaw = list_filters.value.priceMin.trim();
	if (minRaw !== '') {
		const min = Number.parseFloat(minRaw);
		if (Number.isFinite(min)) {
			q.price_min = min;
		}
	}

	const maxRaw = list_filters.value.priceMax.trim();
	if (maxRaw !== '') {
		const max = Number.parseFloat(maxRaw);
		if (Number.isFinite(max)) {
			q.price_max = max;
		}
	}

	if (list_filters.value.stock === 'in' || list_filters.value.stock === 'out') {
		q.stock = list_filters.value.stock;
	}

	const sortMap: Record<typeof sort_key.value, string> = {
		recommended: '',
		price_asc: 'price_in_gbp',
		price_desc: '-price_in_gbp',
		newest: '-created_at',
	};
	const sort = sortMap[sort_key.value];
	if (sort) {
		q.sort = sort;
	}

	return q;
}

async function loadProducts(): Promise<void> {
	await refresh(buildProductsQuery());
}

function resetPageAndLoad(): void {
	page.value = 1;
	loadProducts().catch(() => {});
}

watch(list_filters, resetPageAndLoad, { deep: true });
watch(sort_key, resetPageAndLoad);

onMounted(() => {
	loadProducts().catch(() => {});
});

const paged_products = computed(() => {
	const start = (page.value - 1) * items_per_page;
	return products.value.slice(start, start + items_per_page);
});
</script>
