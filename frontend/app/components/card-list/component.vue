<template>
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <CardComponent v-for="card in cards" :key="card.id" :card="card" variant="list" />
    </section>
</template>

<script setup lang="ts">
import type { ProductCard } from '~/types/product';

const { cards } = defineProps({
	cards: {
		type: Array as PropType<ProductCard[]>,
		required: true,
		default: () => [],
	},
})

</script>
