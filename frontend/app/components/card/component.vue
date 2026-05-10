<template>
	<NuxtLink class="group hover:cursor-pointer! transition" :class="[wrapper_class, has_border]" :to="resolved_url">
		<template v-if="layout === 'portrait'">
			<div class="relative aspect-4/5 overflow-hidden">
				<img
					:alt="label"
					class="size-full object-cover transition-transform duration-500 group-hover:scale-105"
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
			
			<div v-if="variant === 'catalogue-product'" class="flex flex-col gap-1 p-4">
				<h4 class="line-clamp-2 leading-tight">
					{{ label }}
				</h4>

				<p class="text-sm">{{ category_label }}</p>
				<p class="truncate">{{ description }}</p>

				<div class="flex justify-between mt-4 items-center gap-2">
					<span class="font-bold whitespace-nowrap">
						{{ price_label }}
					</span>

					<ButtonActionComponent
						:text="adding_to_basket ? 'Adding…' : 'Add'"
						button_type="button"
						:is_dark="true"
						icon="i-ic:baseline-add-shopping-cart"
						class="shrink-0 px-3 py-1"
						:disabled="adding_to_basket"
						@click="add_to_basket"
					/>
				</div>
				<p v-if="add_error" class="text-xs text-red-600 mt-1">{{ add_error }}</p>
			</div>
		</template>

		<template v-else-if="layout === 'landscape'">
			<img
				:alt="label"
				class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
				:data-alt="data_alt"
				:src="src"
			/>

			<div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>

			<div class="absolute bottom-4 left-4 text-white">
				<p class="text-lg font-semibold">{{ label }}</p>

				<p v-if="description" class="font-medium opacity-90 mt-1 block line-clamp-2 max-w-md">
					{{ description }}
				</p>
			</div>
		</template>

		<template v-else>
			<img
				:alt="label"
				class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
				:data-alt="data_alt"
				:src="src"
			/>

			<div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent"></div>

			<p class="absolute bottom-4 left-4 font-medium text-white" :class="variant === 'default' ? 'text-xl' : 'text-lg'" >
				{{ label }}
			</p>
		</template>
	</NuxtLink>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue'
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
        required: true
    }
})

const label = computed(() => card.name)
const src = computed(() => card.thumbnail)
const description = computed(() => 'description' in card ? card.description : '')

const price_label = computed(() => { 
	if ('price_in_gbp' in card && variant === 'trending-product') {
		return `£${card.price_in_gbp}`
	} else if ('price_in_gbp' in card) {
		return getPoundAndPenceFormat(card.price_in_gbp)
	} else {
		return ''
	}
})

const category_label = computed(() =>
	'product_category_name' in card ? card.product_category_name : '',
)

const has_border = computed(() =>
	variant === 'trending-product' || variant === 'catalogue-product' ? 'border border-slate-400' : ''
)

const resolved_url = computed(() => {
	if ('slug' in card) {
		return `/products/${card.slug}`
	}

	return `/products?category=${card.name}`
})

const wrapper_class = computed(() => {
	if (layout === 'portrait') {
		return 'bg-white rounded-lg overflow-hidden hover:shadow-sm transition-shadow'
	}

	else if (layout === 'landscape') {
		return 'relative rounded-xl overflow-hidden aspect-[16/9]'
	}

	return is_first_large
		? 'col-span-1 row-span-2 relative rounded-xl overflow-hidden'
		: 'col-span-1 row-span-1 relative rounded-xl overflow-hidden'
})

const api = useApi()
const { is_logged_in, role } = useAuth()
const { refresh_basket_item_count } = useBasketItemCount()

const adding_to_basket = ref(false)
const add_error = ref<string | null>(null)

const is_product_card = computed(() => 'id' in card && typeof (card as { id?: number }).id === 'number')

async function add_to_basket() {
	add_error.value = null

	if (!is_product_card.value) {
		return
	}

	const product_id = (card as { id: number }).id

	if (!is_logged_in.value) {
		await navigateTo('/auth/login')
		return
	}

	if (role.value === 'merchant') {
		add_error.value = 'Switch to a customer account to shop.'
		return
	}

	if (role.value !== 'customer') {
		await navigateTo('/auth/login')
		return
	}

	adding_to_basket.value = true
	try {
		await api.post('/basket/add', { product_id, quantity: 1 })
		await refresh_basket_item_count()
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Could not add to basket.'
		add_error.value = msg
	} finally {
		adding_to_basket.value = false
	}
}

</script>
