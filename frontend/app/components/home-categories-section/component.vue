<template>
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
				<!-- <span class="material-symbols-outlined text-lg">arrow_forward</span> -->
			</NuxtLink>
		</article>

		<TriCardComponent :cards="cards" :is_section_large="true" variant="default" />
	</section>
</template>

<script setup lang="ts">
import { useCategories } from '#imports';

const { categories } = useCategories();
const cards = computed(() => categories.value);

</script>
