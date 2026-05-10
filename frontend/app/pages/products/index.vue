<template>
	<main class="w-screen flex px-24 py-16">
		<FilterSidePanelComponent />

		<section class="grow flex flex-col items-center gap-10 px-12">
			<article class="w-full flex flex-col items-stretch sm:flex-row sm:justify-between sm:items-center gap-4">
				<h1 class="text-4xl font-medium">Premium Collection</h1>

				<select
					class="border focus:ring-0 cursor-pointer hidden sm:block w-1/3">
					<option>Recommended</option>
					<option>Price: Low to High</option>
					<option>Price: High to Low</option>
					<option>Newest Arrivals</option>
				</select>
			</article>

			<section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-10">
				<CardListComponent :cards="paged_products" :has_limit="false" layout="portrait" variant="catalogue-product" />
			</section>

			<UPagination v-model:page="page" active-color="neutral" size="xl" :items-per-page="items_per_page" :total="products.length" class="mt-4" />
		</section>
	</main>
</template>

<script setup lang="ts">
import { useProducts } from '~/composables/useProducts';

const { product_cards } = useProducts();
const products = computed(() => product_cards.value);
const page = ref(1)

const items_per_page = 5

const paged_products = computed(() => {
	const start = (page.value - 1) * items_per_page
	return products.value.slice(start, start + items_per_page)
})

</script>
