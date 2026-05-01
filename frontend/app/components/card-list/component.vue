<template>
    <CardComponent v-for="card in displayed_cards" :key="card.id" :card="card" variant="list" />
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { PropType } from 'vue'
import type { ProductCard } from '~/types/product'
import type { ProductCategory } from '~/types/product-category'

type CardItem = ProductCard | ProductCategory; // will also take stores in the future

const { cards, has_limit } = defineProps({
	cards: {
		type: Array as PropType<CardItem[]>,
		required: true,
		default: () => [],
	},
    has_limit: {
        type: Boolean,
        required: true,
    }
})

const fallback = [
	{
		name: 'Series X Chronograph Smartwatch',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDfH9wPMTMr_wD6yLx_pbGR6aMEcyawkhlpBGqHTlqE7dfxFrDibbI3hWtqLMRNQb70Tgqh33_-ROtzqWhLXr95jGm021_GcKRxhX6NLTGbhAieM-0eKwFsAZMoaYNCgmRMshclnPnz7cPPOA7kXut6O_gvBQiv_4_rUlGtRWBMtptWuVX88bgb1K2cyRZPw2TD3r_AR3lLOAGBavsZ6EFLnhHtBlyKBo3gCjkduy2SmnbWFOgLpQpvysNuOUxrIdzk4veMMC2oWfPs',
	},
	{
		name: 'Artisan Leather Tote',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDAo9Zgpjz_whssbG4qQcGf5T85N0DH5FzylFdl1fPE_lN33BSswwMU0zIBuxe8tpH84kEj3etgBVkhOsfVRlHKzg6tcn_6Pd4UJ8mDG8ppijFEEP_vEKnlJhniZv0RcXZzk4-0W8IKhofhN5D0vWhw0eOcHo7005biU8aORsJPTLze12r0F_CH2eVQKmHdEePg4aIYzXefT4zhtj3LYjUyOvhn1f1NnaQ7UpFyupqa5xOvkLrHBKdXK6w1k7e-gDo5kXq1Vx617dgZ',
	},
	{
		name: 'Aura Pro Noise-Cancelling Audio',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDQ8j7F5WmQ1NqAfnkqK_2mxo6km14ozRgXsgjrSjfYpsKHY68xoF-ga7ZfSjuUDSaZ7VTzsBEQq3SJ32eh_zw6Zncozn68FcbyCenan0LWG2URk07fHOevaUx0vHwRuCQN80VHboALXrFcuAl0dkltyxNE0M2MHd7vswGQhOhZY4NfWAYZafq7qmxgcd0MDzn1OjDWm8zUdPIWGgZmdkeFXDlDFyTUV0JQZyvmnYgaJeQYckiCkEpX-ko7V9Xx_yRcGeDjX34cnK5v',
	},
	{
		name: 'Sculptural Ceramic Vase',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCWXKImU18UrDzp-uX3wf3_EL77Ub7FUZ27zkJp-RHc5A9dsSbv4377VF6lpmjdrvjXW9PZkQdiX9wv02xC_-tdi3jXcy1VuwnoVGFrgRC31OnL4mg5jGrReSDiGl839-KoxZfbTpOXWtO8HcaLA1qXE6gVtJlyCi1554Q6HGH_HpJAnvhzeJG3iqaHgTgyfXb1CuTIBGQJsKA93Qu3YJSbHKTHsHgnX2eTry5RLyh6oEEndmYC_0a--t-YD10CSbW2XsY0uSr0tYSG',
	},
] as const

const normalized_cards = computed<CardItem[]>(() => {
	const incoming = cards.slice(0, 4)
	return [0, 1, 2, 3].map((idx) => incoming[idx] ?? {
		id: -(idx + 1),
		name: fallback[idx]?.name ?? '',
		product_category_name: '',
		price_in_gbp: 0,
		thumbnail: fallback[idx]?.src ?? '',
		product_url: '#',
	})
})

const displayed_cards = computed(() => (has_limit ? normalized_cards.value : cards))

</script>
