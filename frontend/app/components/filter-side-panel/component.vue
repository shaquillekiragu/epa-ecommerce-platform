<template>
	<aside class="w-full md:w-64">
		<div class="sticky top-24">
			<h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-4">Filters</h2>
			<div class="space-y-md">
				<div class="border-b border-slate-200 pb-4">
					<h3 class="font-semibold text-sm text-slate-900 mb-2">Category</h3>
					<p v-if="categories_pending" class="text-sm text-slate-500">Loading categories…</p>
					<p v-else-if="categories_error" class="text-sm text-red-600">Could not load categories.</p>
					<div v-else class="space-y-sm max-h-64 overflow-y-auto pr-1">
						<label
							v-for="c in categories"
							:key="c.id"
							class="flex items-center space-x-3 cursor-pointer"
						>
							<input
								:checked="isCategoryChecked(c.id)"
								class="form-checkbox size-4 text-slate-900 border-slate-200 rounded-md focus:ring-primary"
								type="checkbox"
								@change="toggleCategory(c.id)"
							/>
							<span class="font-normal text-base text-slate-900">{{ c.name }}</span>
						</label>
						<p v-if="categories.length === 0" class="text-sm text-slate-500">No categories yet.</p>
					</div>
				</div>

				<div class="border-b border-slate-200 pb-4">
					<h3 class="font-semibold text-sm text-slate-900 mb-2">Price range (GBP)</h3>
					<div class="flex items-center space-x-2">
						<input
							v-model="filters.priceMin"
							class="w-full bg-white border border-slate-200 rounded-md p-2 font-normal text-base text-slate-900 focus:border-slate-900 focus:ring-0"
							inputmode="decimal"
							placeholder="Min"
							type="text"
						/>
						<span class="text-slate-900">-</span>
						<input
							v-model="filters.priceMax"
							class="w-full bg-white border border-slate-200 rounded-md p-2 font-normal text-base text-slate-900 focus:border-slate-900 focus:ring-0"
							inputmode="decimal"
							placeholder="Max"
							type="text"
						/>
					</div>
				</div>

				<div>
					<h3 class="font-semibold text-sm text-slate-900 mb-2">Availability</h3>
					<div class="space-y-sm">
						<label class="flex items-center space-x-3 cursor-pointer">
							<input
								v-model="filters.stock"
								class="form-radio size-4 text-slate-900 border-slate-200 focus:ring-primary"
								name="stock"
								type="radio"
								value="all"
							/>
							<span class="font-normal text-base text-slate-900">All</span>
						</label>
						<label class="flex items-center space-x-3 cursor-pointer">
							<input
								v-model="filters.stock"
								class="form-radio size-4 text-slate-900 border-slate-200 focus:ring-primary"
								name="stock"
								type="radio"
								value="in"
							/>
							<span class="font-normal text-base text-slate-900">In stock</span>
						</label>
						<label class="flex items-center space-x-3 cursor-pointer">
							<input
								v-model="filters.stock"
								class="form-radio size-4 text-slate-900 border-slate-200 focus:ring-primary"
								name="stock"
								type="radio"
								value="out"
							/>
							<span class="font-normal text-base text-slate-900">Out of stock</span>
						</label>
					</div>
				</div>
			</div>
		</div>
	</aside>
</template>

<script setup lang="ts">
import type { ProductListFilters } from '~/types/product-list-filters';
import { useCategories } from '~/composables/useCategories';

const filters = defineModel<ProductListFilters>({ required: true });

const { categories, pending: categories_pending, error: categories_error } = useCategories();

function isCategoryChecked(id: number): boolean {
	return filters.value.categoryIds.includes(id);
}

function toggleCategory(id: number): void {
	const next = new Set(filters.value.categoryIds);
	if (next.has(id)) {
		next.delete(id);
	} else {
		next.add(id);
	}
	filters.value = { ...filters.value, categoryIds: [...next] };
}
</script>
