<template>
	<NuxtLink class="group hover:cursor-pointer! transition" :class="wrapper_class" :to="resolved_url">
		<template v-if="layout === 'portrait'">
			<div class="relative aspect-4/5 overflow-hidden">
				<img
					:alt="label"
					class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
					:data-alt="data_alt"
					:src="src"
				/>
			</div>

			<div v-if="variant === 'trending-product'" class="p-4">
				<div class="flex justify-between gap-2">
					<h4 class="line-clamp-2 leading-tight">
						{{ label }}
					</h4>

					<span class="font-bold whitespace-nowrap">
						{{ price_label }}
					</span>
				</div>

				<p class="text-sm mt-1">{{ category_label }}</p>
			</div>
			
			<div v-if="variant === 'catalogue-product'" class="flex flex-col gap-1">
				<h4 class="line-clamp-2 leading-tight">
					{{ label }}
				</h4>

				<p class="text-sm">{{ category_label }}</p>
				<p class="truncate">{{ description }}</p>

				<div class="">
					<span class="font-bold whitespace-nowrap">
						{{ price_label }}
					</span>

					<button class="bg-black text-white">Add</button>
				</div>
			</div>
		</template>

		<template v-else-if="layout === 'landscape'">
			<img
				:alt="label"
				class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
				:data-alt="data_alt"
				:src="src"
			/>

			<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

			<div class="absolute bottom-4 left-4 text-white">
				<span class="font-label-md text-label-md block">{{ label }}</span>
				<span v-if="description" class="text-sm opacity-90 mt-1 block line-clamp-2 max-w-md">
					{{ description }}
				</span>
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
import type { CardLayout, CardVariant } from '~/types/card-component';
import type { ProductCard } from '~/types/product'
import type { ProductCategory } from '~/types/product-category'

type CardItem = ProductCard | ProductCategory; // will also take stores in the future

const {
	card,
	data_alt,
	is_first_large,
	layout,
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
	layout: {
        type: String as PropType<CardLayout>,
        required: true,
    },
	variant: {
        type: String as PropType<CardVariant>,
        default: 'default'
    }
})

const label = computed(() => ('name' in card ? card.name : card.category_name))
const src = computed(() => card.thumbnail)
const price_label = computed(() => ('price_in_gbp' in card ? `£${card.price_in_gbp}` : ''))
const category_label = computed(() =>
	'product_category_name' in card ? card.product_category_name : '',
)
const description = computed(() =>
	'description' in card ? card.description : '',
)

const resolved_url = computed(() => {
	if ('product_url' in card) {
		return card.product_url
	}
	return card.products_by_category_url
})

const wrapper_class = computed(() => {
	if (layout === 'portrait') {
		return 'bg-white border border-surface-layout rounded-lg overflow-hidden hover:shadow-sm transition-shadow'
	}

	if (layout === 'landscape') {
		return 'relative rounded-xl overflow-hidden aspect-[16/9]'
	}

	return is_first_large
		? 'col-span-1 row-span-2 relative rounded-xl overflow-hidden'
		: 'col-span-1 row-span-1 relative rounded-xl overflow-hidden'
})

const overlay_class = computed(() => {
	if (layout === 'tri') {
		return 'absolute inset-0 bg-gradient-to-t from-black/60 to-transparent'
	}

	return ''
})

const content_class = computed(() => {
	if (layout === 'tri') {
		return variant === 'default'
		? 'text-xl font-medium absolute bottom-4 left-4 text-white'
		: 'text-lg font-medium absolute bottom-4 left-4 text-white'
	}

	return ''
})

const title_class = computed(() => {
	if (layout === 'tri') {
		return 'font-label-md text-label-md block'
	}

	return ''
})

</script>
