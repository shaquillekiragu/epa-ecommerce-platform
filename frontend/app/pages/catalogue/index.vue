<template>
	<main class="w-screen flex flex-1 px-24 py-16">
		<FilterSidePanelComponent />

		<section class="grow flex flex-col gap-10 px-12">
			<article class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
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

			<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
				<CardListComponent :cards="products" :has_limit="false" layout="portrait" variant="catalogue-product" />
			</section>

			<!-- Pagination (Simple implementation for design) -->
			<article class="flex justify-center items-center space-x-2 mt-6">
				<button
					class="px-4 py-2 border transition-colors disabled:opacity-50"
					disabled>Previous</button>
				<button
					class="size-10 flex items-center justify-center border">1</button>
				<button
					class="size-10 flex items-center justify-center border transition-colors">2</button>
				<button
					class="size-10 flex items-center justify-center border transition-colors">3</button>
				<button
					class="px-4 py-2 border transition-colors">Next</button>
			</article>
		</section>
	</main>
</template>

<script setup lang="ts">
import { getProductCards } from '~/composables/useCatalogue';

const products = getProductCards()

</script>
