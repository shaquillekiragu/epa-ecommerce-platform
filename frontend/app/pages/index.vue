<template>
	<main class="flex w-screen flex-1 flex-col items-center overflow-x-hidden py-16">
		<section class="w-full max-w-7xl flex flex-col md:flex-row items-center gap-12 px-6 py-16 md:py-24 border-b overflow-hidden">
			<article class="flex flex-col flex-1 gap-6 z-10">
				<p class="uppercase font-medium opacity-60">New Collection</p>
				
				<h1 class="text-5xl font-bold">Elevate Your Everyday.</h1>

				<p class="text-lg opacity-70">
					Discover curated collections of premium electronics, timeless fashion, and elegant home
					essentials designed for those who demand excellence.
				</p>

				<div class="mt-4">
					<ButtonLinkComponent text="Shop Now" url="/products" :is_dark="true" class="px-16" />
				</div>
			</article>

			<TriCardComponent :cards="cards" :is_section_large="false" variant="default-sm" fallback_type="product" />
		</section>

		<section class="w-full max-w-7xl px-6 py-16">
			<article class="flex justify-between items-end mb-8">
				<div class="flex flex-col gap-2">
					<h2 class="text-4xl font-medium">Curated Categories</h2>
					
					<p class="opacity-75">
						Explore our finest selections across domains.
					</p>
				</div>

				<NuxtLink class="flex items-center gap-1 font-semibold hover:underline" to="/categories">
					View All
					<UIcon name="i-ic:round-arrow-forward" class="size-5" />
				</NuxtLink>
			</article>

			<TriCardComponent :cards="category_cards" :is_section_large="true" variant="default" fallback_type="category" />
		</section>

		<section class="w-full max-w-7xl flex flex-col justify-center items-center px-6 py-16 border-t">
			<article class="flex flex-col gap-3 text-center mb-12">
				<h2 class="text-4xl">Trending Now</h2>

				<p class="max-w-2xl">
					Items currently capturing the attention of our discerning shoppers.
				</p>
			</article>

			<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
				<CardListComponent :cards="cards" :has_limit="true" layout="portrait" variant="trending-product" />
			</section>

			<ButtonLinkComponent text="Explore More Products..." url="/products" :is_dark="false" class="mt-12 px-8" />
		</section>
	</main>
</template>

<script setup lang="ts">
import { useProducts } from '#imports';
import { useCategories } from '#imports';

const { product_cards } = useProducts();
const cards = computed(() => product_cards.value);

const { categories } = useCategories();
const category_cards = computed(() => categories.value);

</script>
