<template>
	<component :is="tag" class="hover:!cursor-pointer" :class="wrapperClass" :href="href">
		<img
			:alt="alt"
			class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
			:data-alt="dataAlt"
			:src="src"
		/>
		<div :class="overlayClass"></div>
		<div :class="contentClass">
			<span :class="titleClass">{{ label }}</span>
			<p v-if="description" :class="descriptionClass">{{ description }}</p>
		</div>
	</component>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { PropType } from 'vue'
import type { ProductCard } from '~/types/product'
import type { ProductCategory } from '~/types/product-category'

type CardItem = ProductCard | ProductCategory

const props = defineProps({
	card: {
		type: Object as PropType<CardItem | null>,
		default: null,
	},
	href: {
		type: String,
		default: undefined,
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
	description: {
		type: String,
		default: '',
	},
	is_first_large: {
		type: Boolean,
		default: false,
	},
	variant: {
		type: String as PropType<'tri' | 'categories'>,
		default: 'tri',
	},
})

const getCardLabel = (card: CardItem | null): string | null => {
	if (!card) {
		return null
	}

	if ('name' in card) {
		return card.name
	}
	
	return card.category_name
}

const label = computed(() => getCardLabel(props.card) ?? props.fallback_label)
const alt = computed(() => getCardLabel(props.card) ?? props.fallback_label)
const src = computed(() => props.card?.thumbnail || props.fallback_src)
const dataAlt = computed(() => props.data_alt)

const tag = computed(() => (props.href ? 'a' : 'div'))

const wrapperClass = computed(() => {
	if (props.variant === 'categories') {
		return props.is_first_large
			? 'md:col-span-2 relative rounded-xl overflow-hidden group bg-surface-container-highest border border-surface-variant'
			: 'flex-1 relative rounded-xl overflow-hidden group bg-surface-container-highest border border-surface-variant'
	}

	return props.is_first_large
		? 'col-span-1 row-span-2 rounded-xl overflow-hidden relative group'
		: 'col-span-1 row-span-1 rounded-xl overflow-hidden relative group'
})

const overlayClass = computed(() => {
	if (props.variant === 'categories') {
		return props.is_first_large
			? 'absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors'
			: 'absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors'
	}

	return 'absolute inset-0 bg-gradient-to-t from-black/60 to-transparent'
})

const contentClass = computed(() => {
	if (props.variant === 'categories') {
		return props.is_first_large
			? 'absolute bottom-0 left-0 p-8 w-full bg-gradient-to-t from-black/80 to-transparent text-white'
			: 'absolute bottom-0 left-0 p-6 w-full bg-gradient-to-t from-black/70 to-transparent text-white'
	}

	return 'absolute bottom-4 left-4 text-white'
})

const titleClass = computed(() => {
	if (props.variant === 'categories') {
		return props.is_first_large
			? 'font-headline-md text-headline-md text-white mb-2 block'
			: 'font-headline-md text-headline-md text-white block'
	}

	return 'font-label-md text-label-md block'
})

const descriptionClass = computed(() => 'font-body-md text-body-md text-white/80 max-w-md')
</script>
