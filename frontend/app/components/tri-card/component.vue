<template>
	<section class="w-full relative flex-1">
		<div class="grid grid-cols-2 gap-4" :class="grid_height_class">
			<CardComponent
				v-for="(card, idx) in normalized_cards"
				:key="card.id"
				:card="card"
				:data_alt="data_alt[idx] ?? ''"
				:is_first_large="idx === 0"
				layout="tri"
				:variant="variant"
			/>
		</div>
	</section>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { PropType } from 'vue'
import type { CardVariant } from '~/types/card-component';
import type { ProductCard } from '~/types/product'
import type { ProductCategory } from '~/types/product-category'

type CardItem = ProductCard | ProductCategory; // will also take stores in the future

const { cards, is_section_large, variant } = defineProps({
	cards: {
		type: Array as PropType<CardItem[]>,
		required: true,
		default: () => [],
	},
	is_section_large: {
		type: Boolean,
		required: true
	},
	variant: {
		type: String as PropType<CardVariant>,
		default: 'default'
	}
})

const grid_height_class = computed(() => (is_section_large ? 'h-125' : 'h-100'))

const category_fallback = [
	{
		name: 'Electronics',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCYqVG1bPAuaot8LZjYQTGUGL7oCrcQsxP2RydaWYvyg6YBL0FOqWIKaW5lyIKIeGtJ3ZO1dfiyNFgjtbOyaLbj_deHKdq6sbtyRuQt3-RQWl6BEveEPC7bZyssMLOtHl3NHTYEIeiYKFTUfzrM6QvZfp0SiEKv1jSvcpkHQ0XeJ7rM38Bv5uG4YJU7-JxRJrPjjgKiCuiHO3xYWlBgICpGgsps0H9TJXlN2d-DZl0zmyfjlAXcMQfy0rJ4INk3cdGwD-qJO4tjNYvK',
	},
	{
		name: 'Fashion',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAYUS08R0Szh5Jx0wduYqRBT7Ki1k-wqfD9tMcvIlbxUrx7PywOmg5RsgyRGzVFMO5DhkARb1pbPx0tKm1oK9NGdbhSwpvK3tZ0LPlJ4VDloxyyMLavnqHsQbpGxsKJBohTF_wmQ9NQovfAxoeqaimXa2bKKaAFSXFseiFhsgnEoBfdb4GVVpS6UpPptgIYpYqN5PKoRZY8K9g_UyNC_aa1z2k-Do7T_Ux9qzmTAjQvISS9xoX4JuH_hhqdlveQPYgAjbh1lpl8E5Nm',
	},
	{
		name: 'Home',
		src: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCcZEI8yj9rt0ybIkNT0SInlRxsF48NCt-ZIMWyZSfS43VFNAqq9_MfZ9tfChxa9i631_REBy-tIwIxG4Gr96og_oNtAoNdZBTiD9P7Wa4bHS4tGAd0CYjawDrb8Jpp0Bf7xdC5_PGxzzeOeC8WgSOJdOavxqJtGAnOZmGjuNSPBvsun1OpRc5O2SrgFzWIxLGTbS39SuwGlni3_FghJxObu8G5_vYozactK4uJtYtUOF5AlBmSCeFiV0IREsSNIyei2W1kFyiiP9WV',
	},
] as const

const product_fallback = [
	{
		name: 'Velocity Runner X1',
		slug: 'velocity-runner-x1',
		product_category_name: 'Shoes',
		price_in_gbp: 180,
		thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCsP0brIpa6RGliR_LnX4sKRoU5eofeW1Zk-j5zSAUHJHWywKONN3xutvNBjQpCbpTzsdzDjaodtQdAobDg5IdvQHpgtfq3FaqvjCSCFj3Qmj4MD2IWh16tSuPlEesIixtZ25WnDiKO_itfhOglNTyzQluQspQP4th8BOtniEuiiwHRvCBCnyaD58107jfhA16-4ZfqVBw65LPFjiXh8ym2fz-UqwxHxyjnIO9_cCZgZlMGXadqHIXuXb6bSgGfuCHtzqQsA3W0B0EL',
	},
	{
		name: 'Core Chronograph',
		slug: 'core-chronograph',
		product_category_name: 'Watches',
		price_in_gbp: 320,
		thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAfAjzhD8IU1hWkHsvqBsDKhVYKRzeaPsQZw6Ksx4OK20eyklJ2SgIB2hQBUsikftc4iAck2LsyhcdhRwHT1iw_MYG8sb3afvCeIRfYx7I3LkZ-zQ5lEPo8q39XdWeBVDZK8d5JOzIeHUFCvvP8Txcpva7_HLVh4Yv8Hc8VixszV-zV6MjI3x3FcYhBKichpNVsYrHcsoyp3lvhFtD2-hTMTwNCZSQo8-zwFpxRwq2Z0C5d24UzjTLP9wPYXdk37OKiPP5FdogM37yj',
	},
	{
		name: 'Architectural Tote Bag',
		slug: 'architectural-tote-bag',
		product_category_name: 'Bags',
		price_in_gbp: 1450,
		thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCCyKOFXi6VKg0c_zdB-u1ZLnOZWHR4MZjld5fuxZfCmhkGXW48AItm-HvAFPS5B1_YNMdylohgiW6KbOyoWhsSfX-DTiLYS9XVOkcmgEMarQyqao7oLhKIws4ycPhW3SI_clfK6GnzKHfiFFxcV7MCyNlZHymMu1RliJyvDVPqiJ-kg_T5FMPiKEuyHstIzEHwVK9v5dHQECrGL8JkbK2roNDClfrQdnAC_AKL2_j9IRvHsdd3epHdnjXJWzg45-2QYxxxpjFhjmzP',
	},
] as const

const is_products_fallback = computed(() => cards.some((c) => c && typeof c === 'object' && 'slug' in c))
const fallback = computed(() => (is_products_fallback.value ? product_fallback : category_fallback))

const normalized_cards = computed<CardItem[]>(() => {
	const incoming = cards.slice(0, 3)
	return [0, 1, 2].map((idx) => incoming[idx] ?? {
		id: -(idx + 1),
		name: fallback.value[idx]?.name ?? '',
		description: '',
		thumbnail: (is_products_fallback.value
			? (fallback.value[idx] as typeof product_fallback[number] | undefined)?.thumbnail
			: (fallback.value[idx] as typeof category_fallback[number] | undefined)?.src) ?? '',
		...(is_products_fallback.value
			? {
				slug: (fallback.value[idx] as typeof product_fallback[number] | undefined)?.slug ?? '',
				product_category_name: (fallback.value[idx] as typeof product_fallback[number] | undefined)?.product_category_name ?? '',
				price_in_gbp: (fallback.value[idx] as typeof product_fallback[number] | undefined)?.price_in_gbp ?? 0,
				product_url: '',
			}
			: {}),
	})
})

const data_alt = [
	'High-end red running shoe floating against a dark background with dramatic studio lighting and sharp details',
	'Sleek white over-ear premium headphones resting on a minimalist concrete surface with soft natural light',
	'Close up of a classic silver mechanical watch face with intricate details against a dark tailored suit sleeve',
] as const

</script>
