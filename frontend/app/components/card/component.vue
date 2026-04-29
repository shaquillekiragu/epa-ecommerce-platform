<template>
	<div :class="wrapperClass">
		<img
			:alt="alt"
			class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
			:data-alt="dataAlt"
			:src="src"
		/>
		<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
		<div class="absolute bottom-4 left-4 text-white">
			<span class="font-label-md text-label-md block">{{ label }}</span>
		</div>
	</div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { PropType } from 'vue'
import type { ProductCard } from '~/types/product'

const props = defineProps({
	card: {
		type: Object as PropType<ProductCard | null>,
		default: null,
	},
	fallback_label: {
		type: String,
		required: true,
	},
	fallback_src: {
		type: String,
		required: true,
	},
	data_alt: {
		type: String,
		required: true,
	},
	is_first_large: {
		type: Boolean,
		default: false,
	},
})

const label = computed(() => props.card?.name ?? props.fallback_label)
const alt = computed(() => props.card?.name ?? props.fallback_label)
const src = computed(() => props.card?.thumbnail || props.fallback_src)
const dataAlt = computed(() => props.data_alt)

const wrapperClass = computed(() =>
	props.is_first_large
		? 'col-span-1 row-span-2 rounded-xl overflow-hidden relative group'
		: 'col-span-1 row-span-1 rounded-xl overflow-hidden relative group',
)
</script>
