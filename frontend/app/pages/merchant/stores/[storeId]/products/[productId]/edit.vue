<template>
	<main class="min-h-screen w-full flex-1 overflow-y-auto bg-slate-50 px-4 py-16 lg:px-6">
		<div v-if="invalid_ids" class="mx-auto max-w-6xl rounded-xl border border-slate-200 bg-white p-10 text-center">
			<p class="font-medium text-slate-800">Invalid product link</p>
			<NuxtLink to="/merchant/stores" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to stores</NuxtLink>
		</div>

		<template v-else>
			<div class="mx-auto mb-6 max-w-6xl">
				<div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
					<div>
						<BreadcrumbsComponent class="mb-3" :items="edit_product_crumbs" />
						<h2 class="text-3xl font-bold leading-tight tracking-tight text-slate-900">
							{{ pending ? 'Edit product' : product?.name ?? 'Edit product' }}
						</h2>
						<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
					</div>
					<div class="flex flex-wrap items-center gap-2">
						<NuxtLink
							:to="`/merchant/stores/${store_id}/products/${product_id}`"
							class="rounded border border-slate-300 px-4 py-2 font-semibold text-slate-900 transition-colors hover:bg-slate-50"
						>
							Cancel
						</NuxtLink>
						<button
							type="button"
							class="rounded bg-slate-900 px-4 py-2 font-semibold text-white transition-opacity hover:opacity-90 disabled:opacity-50"
							:disabled="saving || pending || !product"
							@click="on_save"
						>
							{{ saving ? 'Saving…' : 'Save changes' }}
						</button>
					</div>
				</div>
			</div>

			<div v-if="pending" class="mx-auto max-w-6xl rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading…</div>

			<div v-else-if="not_found" class="mx-auto max-w-6xl rounded-xl border border-slate-200 bg-white p-10 text-center">
				<p class="font-medium text-slate-800">Product not found</p>
				<NuxtLink :to="`/merchant/stores/${store_id}/products`" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to products</NuxtLink>
			</div>

			<div v-else-if="wrong_store" class="mx-auto max-w-6xl rounded-xl border border-slate-200 bg-white p-10 text-center">
				<p class="font-medium text-slate-800">This product does not belong to this store.</p>
				<NuxtLink :to="`/merchant/stores/${store_id}/products`" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to products</NuxtLink>
			</div>

			<div v-else-if="product" class="mx-auto grid max-w-6xl grid-cols-1 gap-grid_gutter lg:grid-cols-12">
				<div class="space-y-grid_gutter lg:col-span-8">
					<section class="rounded border border-slate-400 bg-white p-4 shadow-sm">
						<h3 class="mb-4 text-xl font-semibold leading-snug tracking-tight">General information</h3>
						<div class="space-y-md">
							<div class="space-y-xs">
								<label class="text-sm font-semibold text-slate-600" for="edit-name">Product name</label>
								<input
									id="edit-name"
									v-model="form.name"
									:disabled="saving"
									class="w-full rounded border border-slate-400 bg-white p-2 text-base font-normal focus:border-slate-900"
									type="text"
								/>
							</div>
							<div class="space-y-xs">
								<label class="text-sm font-semibold text-slate-600" :for="`edit-desc-${product_id}`">Description</label>
								<textarea
									:id="`edit-desc-${product_id}`"
									:key="`edit-desc-${product_id}`"
									v-model="form.description"
									:disabled="saving"
									rows="5"
									class="w-full rounded border border-slate-400 bg-white p-2 text-base font-normal focus:border-slate-900"
								></textarea>
							</div>
							<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
								<div class="space-y-xs">
									<label class="text-sm font-semibold text-slate-600" for="edit-sku">SKU code</label>
									<input
										id="edit-sku"
										v-model="form.sku_code"
										:disabled="saving"
										class="w-full rounded border border-slate-400 bg-white p-2 text-base font-normal"
										type="text"
									/>
								</div>
								<div class="space-y-xs">
									<label class="text-sm font-semibold text-slate-600" for="edit-weight">Weight (grams)</label>
									<input
										id="edit-weight"
										v-model="form.weight_in_grams"
										:disabled="saving"
										class="w-full rounded border border-slate-400 bg-white p-2 text-base font-normal"
										inputmode="numeric"
										type="text"
									/>
								</div>
							</div>
						</div>
					</section>

					<section class="rounded border border-slate-400 bg-white p-4 shadow-sm">
						<h3 class="mb-4 text-xl font-semibold leading-snug tracking-tight">Pricing &amp; inventory</h3>
						<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
							<div class="space-y-xs">
								<label class="text-sm font-semibold text-slate-600" for="edit-price">Price (GBP)</label>
								<div class="relative">
									<span class="absolute left-3 top-1/2 -translate-y-1/2 font-semibold text-slate-600">£</span>
									<input
										id="edit-price"
										v-model="form.price_in_gbp"
										:disabled="saving"
										class="w-full rounded border border-slate-400 bg-white py-2 pl-7 pr-2 text-base font-normal"
										inputmode="decimal"
										type="text"
									/>
								</div>
							</div>
							<div class="space-y-xs">
								<label class="text-sm font-semibold text-slate-600" for="edit-stock">Stock quantity</label>
								<input
									id="edit-stock"
									v-model="form.number_in_stock"
									:disabled="saving"
									class="w-full rounded border border-slate-400 bg-white p-2 text-base font-normal"
									inputmode="numeric"
									type="text"
								/>
							</div>
						</div>
					</section>

					<section class="rounded border border-slate-400 bg-white p-4 shadow-sm">
						<div class="mb-4 flex items-center gap-2">
							<span class="material-symbols-outlined text-slate-600">search</span>
							<h3 class="text-xl font-semibold leading-snug tracking-tight">Search engine optimization</h3>
						</div>
						<div class="space-y-md">
							<div class="space-y-xs">
								<label class="text-sm font-semibold text-slate-600" for="edit-seo">SEO title</label>
								<input
									id="edit-seo"
									v-model="form.seo_title"
									:disabled="saving"
									class="w-full rounded border border-slate-400 bg-white p-2 text-base font-normal"
									type="text"
								/>
								<p class="text-xs text-slate-400">Characters: {{ form.seo_title.length }}/255</p>
								<p class="text-xs text-slate-500">The API may normalise SEO title from the product name when saving.</p>
							</div>
							<div class="rounded border border-dashed border-slate-400 bg-slate-50 p-2">
								<p class="mb-1 text-xs text-slate-700">Preview</p>
								<h4 class="cursor-pointer text-base font-medium text-blue-700 hover:underline">{{ preview_title }}</h4>
								<p class="text-xs text-green-700">/products/{{ product.slug }}</p>
								<p class="mt-1 line-clamp-3 text-xs text-slate-600">{{ preview_description }}</p>
							</div>
						</div>
					</section>
				</div>

				<div class="space-y-grid_gutter lg:col-span-4">
					<section class="rounded border border-slate-400 bg-white p-4 shadow-sm">
						<h3 class="mb-4 text-sm font-semibold uppercase tracking-wider text-slate-600">Status &amp; organization</h3>
						<div class="space-y-md">
							<div class="flex items-center justify-between rounded bg-slate-50 p-2">
								<div class="flex flex-col">
									<span class="font-semibold text-slate-900">Is live</span>
									<span class="text-xs text-slate-600">Visible in storefront</span>
								</div>
								<label class="relative inline-flex cursor-pointer items-center">
									<input v-model="form.is_active" :disabled="saving" class="peer sr-only" type="checkbox" />
									<div
										class="peer h-6 w-11 rounded-full bg-slate-200 after:absolute after:left-[2px] after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-slate-900 peer-checked:after:translate-x-full peer-checked:after:border-white"
									></div>
								</label>
							</div>
							<div class="space-y-xs">
								<label class="text-sm font-semibold text-slate-600" for="edit-cat">Category</label>
								<div class="relative">
									<select
										id="edit-cat"
										v-model.number="form.product_category_id"
										:disabled="saving || categories_pending"
										class="w-full appearance-none rounded border border-slate-400 bg-white p-2 pr-8 text-base font-normal"
									>
										<option :value="0">Select a category…</option>
										<option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
									</select>
									<span class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-400">expand_more</span>
								</div>
							</div>
						</div>
					</section>

					<section class="rounded border border-slate-400 bg-white p-4 shadow-sm">
						<div class="mb-4 flex items-center justify-between">
							<h3 class="text-sm font-semibold uppercase tracking-wider text-slate-600">Product thumbnail</h3>
						</div>
						<div class="space-y-md">
							<div class="relative aspect-square w-full overflow-hidden rounded border border-slate-400">
								<img :alt="product.name" class="size-full object-cover" :src="form.thumbnail || '/images/product-placeholder.svg'" />
							</div>
							<div class="space-y-xs">
								<label class="text-sm font-semibold text-slate-600" for="edit-thumb">Thumbnail URL or path</label>
								<input
									id="edit-thumb"
									v-model="form.thumbnail"
									:disabled="saving"
									class="w-full rounded border border-slate-400 bg-white p-2 text-sm font-normal"
									type="text"
								/>
							</div>
						</div>
					</section>

					<section class="rounded border border-red-100 bg-red-50/30 p-4">
						<h3 class="mb-2 text-sm font-semibold uppercase tracking-wider text-red-600">Danger zone</h3>
						<p class="mb-4 text-xs text-slate-600">Once deleted, this product cannot be recovered from the catalog.</p>
						<button
							type="button"
							class="w-full rounded border border-red-600 py-2 font-semibold text-red-600 transition-all hover:bg-red-600 hover:text-white disabled:opacity-50"
							:disabled="deleting || saving"
							@click="on_delete"
						>
							{{ deleting ? 'Deleting…' : 'Delete product' }}
						</button>
					</section>
				</div>
			</div>
		</template>

		<div class="sticky bottom-0 left-0 right-0 flex gap-2 border-t border-slate-400 bg-white p-4 md:hidden">
			<NuxtLink
				:to="`/merchant/stores/${store_id}/products/${product_id}`"
				class="flex-1 rounded border border-slate-300 py-3 text-center font-semibold text-slate-900"
			>
				Cancel
			</NuxtLink>
			<button
				type="button"
				class="flex-2 rounded bg-slate-900 px-6 py-3 font-semibold text-white disabled:opacity-50"
				:disabled="saving || pending || !product"
				@click="on_save"
			>
				{{ saving ? 'Saving…' : 'Update' }}
			</button>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';
import type { MerchantProduct } from '~/types/merchant';
import { merchantDeleteProduct, merchantFetchProduct, merchantFetchStore, merchantUpdateProduct } from '~/composables/useMerchant';
import { useCategories } from '~/composables/useCategories';

definePageMeta({ middleware: ['role-merchant'] });

const route = useRoute();

const store_id = computed(() => {
	const raw = route.params.storeId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const product_id = computed(() => {
	const raw = route.params.productId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const invalid_ids = computed(() => store_id.value === null || product_id.value === null);

const { categories, pending: categories_pending } = useCategories();

const pending = ref(true);
const saving = ref(false);
const deleting = ref(false);
const not_found = ref(false);
const wrong_store = ref(false);
const error_message = ref<string | null>(null);
const product = ref<MerchantProduct | null>(null);
const store_name = ref('Store');

const edit_product_crumbs = computed<BreadcrumbItem[]>(() => {
	const sid = store_id.value;
	const pid = product_id.value;
	if (sid == null || pid == null) return [];
	const product_label = product.value?.name?.trim() ? product.value.name : 'Product';
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: store_name.value, to: `/merchant/stores/${sid}` },
		{ label: 'Products', to: `/merchant/stores/${sid}/products` },
		{ label: product_label, to: `/merchant/stores/${sid}/products/${pid}` },
		{ label: 'Edit' },
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
	thumbnail: '',
	seo_title: '',
	is_active: true,
});

const preview_title = computed(() => (form.seo_title.trim() || form.name.trim() || 'Product title'));
const preview_description = computed(() => (form.description.trim() || '—'));

function description_from_product(p: MerchantProduct) {
	const raw = (p as { description?: unknown }).description;
	if (raw == null) return '';
	return typeof raw === 'string' ? raw : String(raw);
}

function set_form_from_product(p: MerchantProduct) {
	form.name = String(p.name ?? '');
	form.description = description_from_product(p);
	form.sku_code = String(p.sku_code ?? '');
	form.product_category_id = Number(p.product_category_id ?? 0);
	form.price_in_gbp = String(p.price_in_gbp ?? '');
	form.number_in_stock = String(p.number_in_stock ?? '');
	form.weight_in_grams = String(p.weight_in_grams ?? '');
	form.thumbnail = String(p.thumbnail ?? '').trim() || '/images/product-placeholder.svg';
	form.seo_title = String(p.seo_title ?? '');
	form.is_active = Boolean(p.is_active ?? true);
}

function parse_api_error(e: unknown): string {
	if (e && typeof e === 'object' && 'message' in e) return String((e as any).message);
	return 'Request failed';
}

async function load() {
	if (invalid_ids.value) {
		pending.value = false;
		return;
	}
	pending.value = true;
	not_found.value = false;
	wrong_store.value = false;
	error_message.value = null;
	product.value = null;
	try {
		const st = await merchantFetchStore(store_id.value!);
		store_name.value = st.name?.trim() ? st.name : 'Store';
		const p = await merchantFetchProduct(product_id.value!);
		if (p.store_id !== store_id.value) {
			wrong_store.value = true;
			return;
		}
		product.value = p;
		set_form_from_product(p);
	} catch (e: unknown) {
		const status = e && typeof e === 'object' && 'status' in e ? (e as { status?: number }).status : undefined;
		if (status === 404) {
			not_found.value = true;
		} else {
			error_message.value = parse_api_error(e);
		}
	} finally {
		pending.value = false;
	}
}

async function on_save() {
	if (product_id.value == null || saving.value || !product.value) return;
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

	saving.value = true;
	try {
		await merchantUpdateProduct(product_id.value, {
			name: form.name.trim(),
			description: form.description.trim(),
			sku_code: form.sku_code.trim(),
			product_category_id: form.product_category_id,
			price_in_gbp: price,
			number_in_stock: stock,
			weight_in_grams: weight,
			thumbnail: form.thumbnail.trim() || '/images/product-placeholder.svg',
			seo_title: form.seo_title.trim(),
			is_active: form.is_active,
		});
		await navigateTo(`/merchant/stores/${store_id.value}/products/${product_id.value}`);
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
	} finally {
		saving.value = false;
	}
}

async function on_delete() {
	if (product_id.value == null || deleting.value) return;
	if (!confirm('Delete this product? This cannot be undone.')) return;
	deleting.value = true;
	error_message.value = null;
	try {
		await merchantDeleteProduct(product_id.value);
		await navigateTo(`/merchant/stores/${store_id.value}/products`);
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
	} finally {
		deleting.value = false;
	}
}

watch(
	() => [route.params.storeId, route.params.productId],
	() => load(),
);

onMounted(() => load());
</script>
