<template>
	<div class="flex-1 w-full relative">
		<!-- Bento Grid Style Hero Images -->
		<div class="grid grid-cols-2 gap-4 h-100">
			<div class="col-span-1 row-span-2 rounded-xl overflow-hidden relative group">
				<img
					:alt="card0Alt"
					class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
					data-alt="High-end red running shoe floating against a dark background with dramatic studio lighting and sharp details"
					:src="card0Src"
				/>
				<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
				<div class="absolute bottom-4 left-4 text-white">
					<span class="font-label-md text-label-md block">{{ card0Label }}</span>
				</div>
			</div>

			<div class="col-span-1 row-span-1 rounded-xl overflow-hidden relative group">
				<img
					:alt="card1Alt"
					class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
					data-alt="Sleek white over-ear premium headphones resting on a minimalist concrete surface with soft natural light"
					:src="card1Src"
				/>
				<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
				<div class="absolute bottom-4 left-4 text-white">
					<span class="font-label-md text-label-md block">{{ card1Label }}</span>
				</div>
			</div>

			<div class="col-span-1 row-span-1 rounded-xl overflow-hidden relative group">
				<img
					:alt="card2Alt"
					class="size-full object-cover transition-transform duration-700 group-hover:scale-105"
					data-alt="Close up of a classic silver mechanical watch face with intricate details against a dark tailored suit sleeve"
					:src="card2Src"
				/>
				<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
				<div class="absolute bottom-4 left-4 text-white">
					<span class="font-label-md text-label-md block">{{ card2Label }}</span>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { PropType } from 'vue'
import type { ProductCard } from '~/types/product'

const { cards, is_large } = defineProps({
	cards: {
		type: Array as PropType<ProductCard[]>,
		required: true,
		default: () => [],
	},
	is_large: {
		type: Boolean,
		required: true
	}
})

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

const sliced_cards: ProductCard[] = cards.slice(0, 3)

const getCard = (index: 0 | 1 | 2): ProductCard | null => {
	const value = sliced_cards[index]
	return value && typeof value === 'object' ? value : null
}

const card0Label = computed(() => getCard(0)?.name ?? fallback[0].name)
const card1Label = computed(() => getCard(1)?.name ?? fallback[1].name)
const card2Label = computed(() => getCard(2)?.name ?? fallback[2].name)

const card0Alt = computed(() => getCard(0)?.name ?? fallback[0].name)
const card1Alt = computed(() => getCard(1)?.name ?? fallback[1].name)
const card2Alt = computed(() => getCard(2)?.name ?? fallback[2].name)

const card0Src = computed(() => getCard(0)?.thumbnail || fallback[0].src)
const card1Src = computed(() => getCard(1)?.thumbnail || fallback[1].src)
const card2Src = computed(() => getCard(2)?.thumbnail || fallback[2].src)

</script>
