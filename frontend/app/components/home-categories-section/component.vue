<template>
	<section class="w-full max-w-7xl mx-auto px-6 py-16">
		<div class="flex items-end justify-between mb-8">
			<div>
				<h2 class="font-headline-lg text-headline-lg text-on-surface">Curated Categories</h2>
				<p class="font-body-md text-body-md text-on-surface-variant mt-2">
					Explore our finest selections across domains.
				</p>
			</div>
			<NuxtLink class="font-label-md text-label-md text-primary flex items-center gap-1 hover:underline" to="#">
				View All <span class="material-symbols-outlined text-lg">arrow_forward</span>
			</NuxtLink>
		</div>

		<TriCardComponent :cards="cards" :is_section_large="true" />
	</section>
</template>

<script setup lang="ts">
import { getProductCategories } from '#imports';

const cards = getProductCategories()

</script>
