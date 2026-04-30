<template>
	<NuxtLink class="group hover:cursor-pointer! transition" :class="wrapper_class" :to="resolved_url">
		<template v-if="variant === 'list'">
			<div class="relative aspect-[4/5] bg-surface-container-lowest overflow-hidden">
				<img
					:alt="label"
					class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
					:data-alt="data_alt"
					:src="src"
				/>
			</div>
			<div class="p-4">
				<div class="flex items-start justify-between gap-2">
					<h4 class="font-headline-md text-headline-md text-base text-on-surface line-clamp-2 leading-tight">
						{{ label }}
					</h4>
					<span class="font-body-lg text-body-lg font-bold text-primary whitespace-nowrap">{{
						price_label
					}}</span>
				</div>
				<p class="font-body-md text-body-md text-sm text-on-surface-variant mt-1">{{ category_label }}</p>
			</div>
		</template>
		<template v-else>
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
		</template>
	</NuxtLink>
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
const price_label = computed(() => ('price_in_gbp' in card ? `£${card.price_in_gbp}` : ''))
const category_label = computed(() =>
	'product_category_name' in card ? card.product_category_name : '',
)

const resolved_url = computed(() => {
	if ('product_url' in card) {
		return card.product_url
	}
	return card.products_by_category_url
})

const wrapper_class = computed(() => {
	if (variant === 'list') {
		return 'bg-white border border-surface-variant rounded-lg overflow-hidden hover:shadow-sm transition-shadow'
	}

	return is_first_large
		? 'col-span-1 row-span-2 relative rounded-xl overflow-hidden'
		: 'col-span-1 row-span-1 relative rounded-xl overflow-hidden'
})

const overlay_class = computed(() => {
	if (variant === 'tri') {
		return 'absolute inset-0 bg-gradient-to-t from-black/60 to-transparent'
	}

	return ''
})

const content_class = computed(() => {
	if (variant === 'tri') {
		return 'absolute bottom-4 left-4 text-white'
	}

	return ''
})

const title_class = computed(() => {
	if (variant === 'tri') {
		return 'font-label-md text-label-md block'
	}

	return ''
})

</script>
