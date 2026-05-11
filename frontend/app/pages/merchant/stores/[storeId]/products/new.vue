<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 px-6 py-16 md:px-10">
		<div class="mx-auto max-w-4xl">
			<BreadcrumbsComponent class="mb-4" :items="new_product_crumbs" />

			<header class="mb-8">
				<h1 class="text-3xl font-bold tracking-tight text-slate-900">Create product</h1>
				<p class="mt-2 text-base text-slate-600">Add a new product to this store.</p>
				<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
			</header>

			<form class="space-y-6" @submit.prevent="on_submit">
				<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="space-y-5">
						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-900" for="p-name">Name</label>
							<input id="p-name" v-model="form.name" :disabled="submitting" class="w-full rounded-md border border-slate-300 p-2" type="text" />
						</div>

						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-900" for="p-desc">Description</label>
							<textarea id="p-desc" v-model="form.description" :disabled="submitting" class="w-full rounded-md border border-slate-300 p-2" rows="5"></textarea>
						</div>

						<div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
							<div>
								<label class="mb-2 block text-sm font-semibold text-slate-900" for="p-sku">SKU</label>
								<input id="p-sku" v-model="form.sku_code" :disabled="submitting" class="w-full rounded-md border border-slate-300 p-2" type="text" />
							</div>
							<div>
								<label class="mb-2 block text-sm font-semibold text-slate-900" for="p-cat">Category</label>
								<select id="p-cat" v-model.number="form.product_category_id" :disabled="submitting || categories_pending" class="w-full rounded-md border border-slate-300 p-2">
									<option :value="0">Select a category…</option>
									<option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
								</select>
							</div>
						</div>

						<div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
							<div>
								<label class="mb-2 block text-sm font-semibold text-slate-900" for="p-price">Price (GBP)</label>
								<input id="p-price" v-model="form.price_in_gbp" :disabled="submitting" class="w-full rounded-md border border-slate-300 p-2" inputmode="decimal" type="text" />
							</div>
							<div>
								<label class="mb-2 block text-sm font-semibold text-slate-900" for="p-stock">Stock</label>
								<input id="p-stock" v-model="form.number_in_stock" :disabled="submitting" class="w-full rounded-md border border-slate-300 p-2" inputmode="numeric" type="text" />
							</div>
							<div>
								<label class="mb-2 block text-sm font-semibold text-slate-900" for="p-weight">Weight (grams)</label>
								<input id="p-weight" v-model="form.weight_in_grams" :disabled="submitting" class="w-full rounded-md border border-slate-300 p-2" inputmode="numeric" type="text" />
							</div>
						</div>

						<div class="flex items-center gap-3">
							<input id="p-live" v-model="form.is_active" :disabled="submitting" class="size-4 rounded border-slate-300 text-slate-900" type="checkbox" />
							<label for="p-live" class="text-sm font-semibold text-slate-900">Live (visible to customers)</label>
						</div>
					</div>
				</div>

				<div class="flex flex-wrap items-center justify-end gap-3">
					<NuxtLink :to="`/merchant/stores/${store_id}/products`" class="rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50">
						Cancel
					</NuxtLink>
					<button type="submit" :disabled="submitting" class="rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 disabled:opacity-50">
						{{ submitting ? 'Creating…' : 'Create product' }}
					</button>
				</div>
			</form>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';
import { merchantCreateProduct, merchantFetchStore } from '~/composables/useMerchant';
import { useCategories } from '~/composables/useCategories';

definePageMeta({ middleware: ['role-merchant'] });

const route = useRoute();

const store_id = computed(() => {
	const raw = route.params.storeId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const { categories, pending: categories_pending } = useCategories();

const store_name = ref('Store');
const submitting = ref(false);
const error_message = ref<string | null>(null);

const new_product_crumbs = computed<BreadcrumbItem[]>(() => {
	const id = store_id.value;
	if (id == null) return [];
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: store_name.value, to: `/merchant/stores/${id}` },
		{ label: 'Products', to: `/merchant/stores/${id}/products` },
		{ label: 'New product' },
	];
});

const form = reactive({
	name: '',
	description: '',
	sku_code: '',
	product_category_id: 0,
	price_in_gbp: '',
	number_in_stock: '',
	weight_in_grams: '',
	is_active: true,
});

function parse_api_error(e: unknown): string {
	if (e && typeof e === 'object' && 'message' in e) return String((e as any).message);
	return 'Request failed';
}

async function on_submit() {
	if (store_id.value == null || submitting.value) return;
	error_message.value = null;

	const price = Number.parseFloat(form.price_in_gbp);
	const stock = Number.parseInt(form.number_in_stock, 10);
	const weight = Number.parseInt(form.weight_in_grams, 10);

	if (form.name.trim() === '') return (error_message.value = 'Name is required.');
	if (form.sku_code.trim() === '') return (error_message.value = 'SKU is required.');
	if (!Number.isFinite(form.product_category_id) || form.product_category_id <= 0) return (error_message.value = 'Category is required.');
	if (!Number.isFinite(price)) return (error_message.value = 'Valid price is required.');
	if (!Number.isFinite(stock)) return (error_message.value = 'Valid stock quantity is required.');
	if (!Number.isFinite(weight)) return (error_message.value = 'Valid weight (grams) is required.');

	submitting.value = true;
	try {
		const created = await merchantCreateProduct({
			store_id: store_id.value,
			name: form.name.trim(),
			description: form.description.trim(),
			sku_code: form.sku_code.trim(),
			product_category_id: form.product_category_id,
			price_in_gbp: price,
			number_in_stock: stock,
			weight_in_grams: weight,
			thumbnail: '/images/product-placeholder.svg',
			is_active: form.is_active,
		});

		await navigateTo(`/merchant/stores/${store_id.value}/products/${created.id}/edit`);
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
	} finally {
		submitting.value = false;
	}
}

async function load_store_name() {
	if (store_id.value == null) return;
	try {
		const s = await merchantFetchStore(store_id.value);
		store_name.value = s.name?.trim() ? s.name : 'Store';
	} catch {
		store_name.value = 'Store';
	}
}

onMounted(() => {
	load_store_name();
});
</script>
