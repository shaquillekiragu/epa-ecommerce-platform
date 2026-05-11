<template>
	<main class="w-screen flex px-24 py-16">
		<FilterSidePanelComponent v-model="list_filters" />

		<section class="grow flex flex-col items-center gap-10 px-12">
			<article class="w-full flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-end">
				<h1 class="text-4xl font-medium shrink-0">Premium Collection</h1>

				<div class="flex w-full flex-col gap-1.5 sm:w-auto sm:min-w-56 sm:max-w-xs">
					<label for="catalog-sort" class="text-sm font-medium text-slate-700">Sort by</label>
					<select
						id="catalog-sort"
						v-model="sort_key"
						class="w-full cursor-pointer rounded-md border border-slate-200 bg-white px-3 py-2 text-base text-slate-900 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/15"
					>
						<option value="default">Default</option>
						<option value="price_asc">Price: Low to High</option>
						<option value="price_desc">Price: High to Low</option>
						<option value="newest">Newest Arrivals</option>
					</select>
				</div>
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

const SORT_KEYS = ['default', 'price_asc', 'price_desc', 'newest'] as const;
type SortKey = (typeof SORT_KEYS)[number];

function normalizeSortQueryParam(raw: unknown): string | undefined {
	if (raw === undefined || raw === null) return undefined;
	if (Array.isArray(raw)) return typeof raw[0] === 'string' ? raw[0] : undefined;
	return typeof raw === 'string' ? raw : undefined;
}

function isSortKey(value: string): value is SortKey {
	return (SORT_KEYS as readonly string[]).includes(value);
}

const route = useRoute();
const router = useRouter();

function sortFromRouteQuery(): SortKey {
	const raw = normalizeSortQueryParam(route.query.sort);
	if (raw !== undefined && isSortKey(raw)) return raw;
	return 'default';
}

const list_filters = ref<ProductListFilters>({
	categoryIds: [],
	priceMin: '',
	priceMax: '',
	stock: 'all',
});

const sort_key = ref<SortKey>(sortFromRouteQuery());

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

	const sortMap: Record<SortKey, string> = {
		default: '',
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

watch(sort_key, (value) => {
	const next_query = { ...route.query } as Record<string, string | string[] | undefined>;
	if (value === 'default') {
		delete next_query.sort;
	} else {
		next_query.sort = value;
	}
	void router.replace({ query: next_query });
	page.value = 1;
	loadProducts().catch(() => {});
});

watch(
	() => route.query.sort,
	() => {
		const next = sortFromRouteQuery();
		if (next === sort_key.value) return;
		sort_key.value = next;
	},
);

onMounted(() => {
	loadProducts().catch(() => {});
});

const paged_products = computed(() => {
	const start = (page.value - 1) * items_per_page;
	return products.value.slice(start, start + items_per_page);
});
</script>
