<template>
	<div class="grid gap-4 sm:grid-cols-3">
		<NuxtLink
			:to="`/merchant/stores/${store_id}/orders`"
			class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-colors hover:border-slate-900"
		>
			<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Orders</p>
			<p class="mt-2 text-2xl font-bold text-slate-900">{{ order_count }}</p>
			<p class="mt-2 text-sm font-semibold text-slate-900">Manage →</p>
		</NuxtLink>
		<NuxtLink
			:to="`/merchant/stores/${store_id}/products`"
			class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-colors hover:border-slate-900 sm:col-span-2"
		>
			<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Products</p>
			<p class="mt-2 text-sm text-slate-600">
				View and manage products in this store (same catalogue flow as customers, scoped to your store).
			</p>
			<p class="mt-3 text-sm font-semibold text-slate-900">Open products →</p>
		</NuxtLink>
	</div>
</template>

<script setup lang="ts">
defineProps<{
	store_id: number;
	order_count: number;
}>();
</script>
