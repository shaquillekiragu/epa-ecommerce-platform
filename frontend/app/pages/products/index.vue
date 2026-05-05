<template>
	<main class="w-screen flex px-24 py-16">
		<FilterSidePanelComponent />

		<section class="grow flex flex-col items-center gap-10 px-12">
			<article class="w-full flex flex-col items-stretch sm:flex-row sm:justify-between sm:items-center gap-4">
				<h1 class="text-4xl font-medium">Premium Collection</h1>

				<div class="flex items-center gap-4 w-full sm:w-auto">
					<div class="relative w-full sm:w-64">
						<span
							class="absolute left-3 top-1/2 -translate-y-1/2">search</span>
						<input
							class="w-full border pl-10 pr-4 focus:ring-0"
							placeholder="Search products..." type="text" />
					</div>

					<select
						class="border focus:ring-0 cursor-pointer hidden sm:block">
						<option>Recommended</option>
						<option>Price: Low to High</option>
						<option>Price: High to Low</option>
						<option>Newest Arrivals</option>
					</select>
				</div>
			</article>

			<section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-10">
				<CardListComponent :cards="paged_products" :has_limit="false" layout="portrait" variant="catalogue-product" />
			</section>

			<UPagination v-model:page="page" active-color="neutral" size="xl" :items-per-page="items_per_page" :total="products.length" class="mt-4" />
		</section>
	</main>
</template>

<script setup lang="ts">
import { getProductCards } from '~/composables/useProducts';

const products = getProductCards()
const page = ref(1)

const items_per_page = 5

const paged_products = computed(() => {
	const start = (page.value - 1) * items_per_page
	return products.slice(start, start + items_per_page)
})

</script>
