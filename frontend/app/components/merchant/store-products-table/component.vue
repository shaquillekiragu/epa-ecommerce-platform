<template>
	<div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
		<div class="overflow-x-auto">
			<table class="w-full min-w-[640px] border-collapse text-left">
				<thead>
					<tr class="border-b border-slate-200 bg-slate-50">
						<th class="p-4 text-sm font-semibold text-slate-600">Product</th>
						<th class="p-4 text-sm font-semibold text-slate-600">SKU</th>
						<th class="p-4 text-sm font-semibold text-slate-600">Category</th>
						<th class="p-4 text-right text-sm font-semibold text-slate-600">Price</th>
						<th class="p-4 text-right text-sm font-semibold text-slate-600">Stock</th>
						<th class="p-4 text-sm font-semibold text-slate-600"></th>
					</tr>
				</thead>
				<tbody class="divide-y divide-slate-100">
					<tr v-for="p in products" :key="p.id" class="hover:bg-slate-50/80">
						<td class="p-4">
							<NuxtLink
								:to="`/merchant/stores/${store_id}/products/${p.id}`"
								class="flex items-center gap-3 hover:underline"
							>
								<div class="size-12 shrink-0 overflow-hidden rounded-md border border-slate-200 bg-slate-100">
									<img
										:alt="p.name"
										class="size-full object-cover"
										:src="p.thumbnail || '/images/product-placeholder.svg'"
									/>
								</div>
								<span class="font-semibold text-slate-900">{{ p.name }}</span>
							</NuxtLink>
						</td>
						<td class="p-4 text-sm text-slate-600">{{ p.sku_code }}</td>
						<td class="p-4 text-sm text-slate-600">{{ p.product_category_name }}</td>
						<td class="p-4 text-right text-sm font-bold text-slate-900">{{ getPoundAndPenceFormat(p.price_in_gbp) }}</td>
						<td class="p-4 text-right text-sm text-slate-600">{{ p.number_in_stock }}</td>
						<td class="p-4">
							<NuxtLink
								:to="`/merchant/stores/${store_id}/products/${p.id}/edit`"
								class="text-sm font-semibold text-slate-900 hover:underline"
							>
								Edit
							</NuxtLink>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</template>

<script setup lang="ts">
import type { MerchantProduct } from '~/types/merchant';
import { getPoundAndPenceFormat } from '~/utils/money';

defineProps<{
	store_id: number;
	products: MerchantProduct[];
}>();
</script>
