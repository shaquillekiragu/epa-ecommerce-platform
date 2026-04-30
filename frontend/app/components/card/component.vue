<template>
	<NuxtLink
		v-if="is_internal_link"
		class="relative rounded-xl overflow-hidden group hover:!cursor-pointer"
		:class="wrapper_class"
		:to="resolved_url"
	>
		<img
			:alt="label"
			class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
			:data-alt="data_alt"
			:src="src"
		/>
		<div :class="overlay_class"></div>
		<div :class="content_class">
			<span :class="title_class">{{ label }}</span>
		</div>
	</NuxtLink>

	<a
		v-else-if="is_external_link"
		class="relative rounded-xl overflow-hidden group hover:!cursor-pointer"
		:class="wrapper_class"
		:href="resolved_url"
		rel="noopener noreferrer"
		target="_blank"
	>
		<img
			:alt="label"
			class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
			:data-alt="data_alt"
			:src="src"
		/>
		<div :class="overlay_class"></div>
		<div :class="content_class">
			<span :class="title_class">{{ label }}</span>
		</div>
	</a>
	
	<div v-else class="relative rounded-xl overflow-hidden group hover:!cursor-pointer" :class="wrapper_class">
		<img
			:alt="label"
			class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
			:data-alt="data_alt"
			:src="src"
		/>
		<div :class="overlay_class"></div>
		<div :class="content_class">
			<span :class="title_class">{{ label }}</span>
		</div>
	</div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { PropType } from 'vue'
import type { ProductCard } from '~/types/product'
import type { ProductCategory } from '~/types/product-category'

type CardItem = ProductCard | ProductCategory;

const {
	card,
	data_alt,
	is_first_large,
	variant,
} = defineProps({
	card: {
		type: Object as PropType<CardItem>,
		required: true,
	},
	data_alt: {
		type: String,
		default: '',
	},
	is_first_large: {
		type: Boolean,
		default: false,
	},
	variant: {
		type: String as PropType<'tri' | 'list'>,
		default: 'tri',
	},
})

const label = computed(() => ('name' in card ? card.name : card.category_name))
const src = computed(() => card.thumbnail)

const resolved_url = computed(() => {
	if ('product_url' in card) {
		return card.product_url
	}
	return ''
})

const is_external_link = computed(() => /^https?:\/\//i.test(resolved_url.value))
const is_internal_link = computed(() => Boolean(resolved_url.value) && !is_external_link.value)

const wrapper_class = computed(() => {
	if (variant === 'list') {
		return is_first_large
			? 'md:col-span-2 bg-surface-container-highest border border-surface-variant'
			: 'flex-1 bg-surface-container-highest border border-surface-variant'
	}

	return is_first_large
		? 'col-span-1 row-span-2'
		: 'col-span-1 row-span-1'
})

const overlay_class = computed(() => {
	if (variant === 'list') {
		return is_first_large
			? 'absolute inset-0 bg-black/30 group-hover:bg-black/40 transition-colors'
			: 'absolute inset-0 bg-black/20 group-hover:bg-black/30 transition-colors'
	}

	return 'absolute inset-0 bg-gradient-to-t from-black/60 to-transparent'
})

const content_class = computed(() => {
	if (variant === 'list') {
		return is_first_large
			? 'absolute bottom-0 left-0 p-8 w-full bg-gradient-to-t from-black/80 to-transparent text-white'
			: 'absolute bottom-0 left-0 p-6 w-full bg-gradient-to-t from-black/70 to-transparent text-white'
	}

	return 'absolute bottom-4 left-4 text-white'
})

const title_class = computed(() => {
	if (variant === 'list') {
		return is_first_large
			? 'font-headline-md text-headline-md text-white mb-2 block'
			: 'font-headline-md text-headline-md text-white block'
	}

	return 'font-label-md text-label-md block'
})

</script>
