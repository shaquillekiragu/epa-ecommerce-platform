<template>
	<section class="w-full max-w-7xl mx-auto px-6 py-16">
		<div class="flex items-end justify-between mb-8">
			<div>
				<h2 class="font-headline-lg text-headline-lg text-on-surface">Curated Categories</h2>
				<p class="font-body-md text-body-md text-on-surface-variant mt-2">
					Explore our finest selections across domains.
				</p>
			</div>
			<a class="font-label-md text-label-md text-primary flex items-center gap-1 hover:underline" href="#">
				View All <span class="material-symbols-outlined text-lg">arrow_forward</span>
			</a>
		</div>

		<TriCardComponent :cards="card_array" :is_large="false" />
	</section>
</template>

<script setup lang="ts">
import type { ProductCard } from '~/types/product'

const card_array: ProductCard[] = [
	{
		id: 1,
		name: 'High-Fidelity Electronics',
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuCYqVG1bPAuaot8LZjYQTGUGL7oCrcQsxP2RydaWYvyg6YBL0FOqWIKaW5lyIKIeGtJ3ZO1dfiyNFgjtbOyaLbj_deHKdq6sbtyRuQt3-RQWl6BEveEPC7bZyssMLOtHl3NHTYEIeiYKFTUfzrM6QvZfp0SiEKv1jSvcpkHQ0XeJ7rM38Bv5uG4YJU7-JxRJrPjjgKiCuiHO3xYWlBgICpGgsps0H9TJXlN2d-DZl0zmyfjlAXcMQfy0rJ4INk3cdGwD-qJO4tjNYvK',
	},
	{
		id: 2,
		name: 'Avant-Garde Fashion',
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuAYUS08R0Szh5Jx0wduYqRBT7Ki1k-wqfD9tMcvIlbxUrx7PywOmg5RsgyRGzVFMO5DhkARb1pbPx0tKm1oK9NGdbhSwpvK3tZ0LPlJ4VDloxyyMLavnqHsQbpGxsKJBohTF_wmQ9NQovfAxoeqaimXa2bKKaAFSXFseiFhsgnEoBfdb4GVVpS6UpPptgIYpYqN5PKoRZY8K9g_UyNC_aa1z2k-Do7T_Ux9qzmTAjQvISS9xoX4JuH_hhqdlveQPYgAjbh1lpl8E5Nm',
	},
	{
		id: 3,
		name: 'Bespoke Home',
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuCcZEI8yj9rt0ybIkNT0SInlRxsF48NCt-ZIMWyZSfS43VFNAqq9_MfZ9tfChxa9i631_REBy-tIwIxG4Gr96og_oNtAoNdZBTiD9P7Wa4bHS4tGAd0CYjawDrb8Jpp0Bf7xdC5_PGxzzeOeC8WgSOJdOavxqJtGAnOZmGjuNSPBvsun1OpRc5O2SrgFzWIxLGTbS39SuwGlni3_FghJxObu8G5_vYozactK4uJtYtUOF5AlBmSCeFiV0IREsSNIyei2W1kFyiiP9WV',
	},
]

</script>
