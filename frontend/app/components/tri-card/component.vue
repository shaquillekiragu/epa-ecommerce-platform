<template>
	<section class="w-full relative flex-1">
		<div class="grid grid-cols-2 gap-4" :class="grid_height_class">
			<CardComponent
				v-for="(card, idx) in normalized_cards"
				:key="card.id"
				:card="card"
				:data_alt="data_alt[idx] ?? ''"
				:is_first_large="idx === 0"
				variant="tri"
			/>
		</div>
	</section>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { PropType } from 'vue'
import type { ProductCard } from '~/types/product'
import type { ProductCategory } from '~/types/product-category'

type CardItem = ProductCard | ProductCategory; // will also take stores in the future

const { cards, is_section_large } = defineProps({
	cards: {
		type: Array as PropType<CardItem[]>,
		required: true,
		default: () => [],
	},
	is_section_large: {
		type: Boolean,
		required: true
	}
})

const grid_height_class = computed(() => (is_section_large ? 'h-125' : 'h-100'))

const fallback = [
	{
		name: 'Sneakers',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAlxnrWt_gMa7UF15hTXAen0wNOxGpFHbQ5fNZwF37f4in-0UQ5NnUoLKa7NJFAmzSYarAUK7G8Omq5nLGKCtkX5bMIT0ehkncGhL_LqeHk3aaNtziNFsGVpagutbkLCIJYne409JH7HUMEZlD0PJ7g9YCB0IvfFh2itfCdUUc6B__4UuQr8Jsh7xF3relYOmDznwYvcoHMGb_xRhazEO_iEJU60QhbJPwfpMEikqWoorYAzVinvpCpw4_glRR_fzCIQByP8GUVdXhB',
	},
	{
		name: 'Audio',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDAzUpBqQ-Bh3LcO7H9qydum8LaCWKG_VRcixf0RQmtfJJx6VFVtjtAoJsCVxsaub81rPxkEslhLIfrw7UTUPpr6-ztepNya5N5yAlPr2t4JMm7UMgW7V6Jhjh0enzrolb2YIkjt0gNAQnFwWf-451fiwIlZnLdySnp99FhtKuBlqhWT2_FCkGALUDCo_6Xv8udrnbdk9OrqkaSr_fp9emVDIJqLmm6sZ8GT7HU4kBkcjizWoiPJdQUVspgFvdU8qHDDtg-EpdNdVQC',
	},
	{
		name: 'Watches',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCPg5T2Q__xF4ZKGG7YG6x-vd1f27QP0r6gX54rsYW5T-rta_0X9K9zP6TeoibTptJmx31PkOdMK_7kA7sNFaXA_l5XP9t68VdVvVAjr2ubD9uW1-IFcr11H1MaP7xqW_Ad1e8hakxuakwRo2oduQbubIgFZ2LR4csfbYHlE6bc6L8QaooZ9w9nzVbBVoObD3beUyjVmht0KsbXc6dRf68ScZCPiKM-sdwfCKAJVT6Zx1L6O54FrLiTW20KVLk35eTnwrM7UrCldDUQ',
	},
] as const

const normalized_cards = computed<CardItem[]>(() => {
	const incoming = cards.slice(0, 3)
	return [0, 1, 2].map((idx) => incoming[idx] ?? {
		id: -(idx + 1),
		name: fallback[idx]?.name ?? '',
		product_category_name: '',
		price_in_gbp: 0,
		thumbnail: fallback[idx]?.src ?? '',
		product_url: '#',
	})
})

const data_alt = [
	'High-end red running shoe floating against a dark background with dramatic studio lighting and sharp details',
	'Sleek white over-ear premium headphones resting on a minimalist concrete surface with soft natural light',
	'Close up of a classic silver mechanical watch face with intricate details against a dark tailored suit sleeve',
] as const

</script>
