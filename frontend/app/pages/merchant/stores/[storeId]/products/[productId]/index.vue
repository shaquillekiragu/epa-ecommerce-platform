<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 p-6 pb-16 pt-24 md:p-10">
		<div class="mx-auto max-w-6xl">
			<BreadcrumbsComponent class="mb-4" :items="product_view_crumbs" />

			<div v-if="invalid_ids" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
				<p class="font-medium text-slate-800">Invalid product link</p>
				<NuxtLink to="/merchant/stores" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to stores</NuxtLink>
			</div>

			<template v-else>
				<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading…</div>

				<div v-else-if="not_found" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
					<p class="font-medium text-slate-800">Product not found</p>
					<NuxtLink :to="`/merchant/stores/${store_id}/products`" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to products</NuxtLink>
				</div>

				<div v-else-if="wrong_store" class="rounded-xl border border-slate-200 bg-white p-10 text-center">
					<p class="font-medium text-slate-800">This product does not belong to this store.</p>
					<NuxtLink :to="`/merchant/stores/${store_id}/products`" class="mt-4 inline-block font-semibold text-slate-900 underline">Back to products</NuxtLink>
				</div>

				<template v-else-if="product">
					<header class="mb-8 flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
						<div class="min-w-0">
							<div class="flex flex-wrap items-center gap-3">
								<h1 class="truncate text-3xl font-bold tracking-tight text-slate-900">{{ product.name }}</h1>
								<span
									class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold"
									:class="product.is_active ? 'bg-green-100 text-green-700' : 'bg-slate-200 text-slate-700'"
								>
									<span class="size-1.5 rounded-full" :class="product.is_active ? 'bg-green-600' : 'bg-slate-500'"></span>
									{{ product.is_active ? 'Live' : 'Hidden' }}
								</span>
							</div>
							<p class="mt-2 text-slate-600">
								{{ product.product_category_name }} · SKU {{ product.sku_code }}
							</p>
							<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
						</div>

						<div class="flex flex-wrap gap-3">
							<button
								type="button"
								:disabled="toggling_live"
								class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 font-semibold text-slate-700 hover:bg-slate-50 disabled:opacity-50"
								@click="toggle_live"
							>
								<span class="material-symbols-outlined text-sm">{{ product.is_active ? 'visibility_off' : 'visibility' }}</span>
								{{ toggling_live ? 'Updating…' : product.is_active ? 'Hide product' : 'Make live' }}
							</button>
							<NuxtLink
								:to="`/merchant/stores/${store_id}/products/${product_id}/edit`"
								class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-6 py-2 font-semibold text-white hover:bg-slate-800"
							>
								<span class="material-symbols-outlined text-sm">edit</span>
								Edit
							</NuxtLink>
						</div>
					</header>

					<div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
						<section class="space-y-6 lg:col-span-8">
							<div class="overflow-hidden rounded-xl border border-slate-200 bg-white">
								<div class="aspect-video w-full bg-slate-100">
									<img
										:alt="product.name"
										class="size-full object-cover"
										:src="product.thumbnail || placeholder_image"
									/>
								</div>
								<div class="p-6">
									<h2 class="mb-3 text-xl font-semibold text-slate-900">Description</h2>
									<p class="whitespace-pre-wrap text-slate-700">{{ product.description || '—' }}</p>
								</div>
							</div>

							<div class="rounded-xl border border-slate-200 bg-white p-6">
								<h2 class="mb-4 text-xl font-semibold text-slate-900">SEO</h2>
								<div class="space-y-3 text-sm">
									<div>
										<p class="font-semibold text-slate-600">SEO title</p>
										<p class="text-slate-900">{{ product.seo_title || '—' }}</p>
									</div>
									<div>
										<p class="font-semibold text-slate-600">Slug</p>
										<p class="text-slate-900">{{ product.slug || '—' }}</p>
									</div>
								</div>
							</div>
						</section>

						<aside class="space-y-6 lg:col-span-4">
							<div class="rounded-xl border border-slate-200 bg-white p-6">
								<h2 class="mb-4 text-xl font-semibold text-slate-900">Inventory</h2>
								<div class="grid grid-cols-2 gap-4">
									<div>
										<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Price</p>
										<p class="mt-1 text-lg font-bold text-slate-900">{{ format_money(product.price_in_gbp) }}</p>
									</div>
									<div>
										<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Stock</p>
										<p class="mt-1 text-lg font-bold text-slate-900">{{ product.number_in_stock }}</p>
									</div>
									<div>
										<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Weight</p>
										<p class="mt-1 text-sm font-semibold text-slate-900">{{ product.weight_in_grams }} g</p>
									</div>
									<div>
										<p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Store</p>
										<p class="mt-1 text-sm font-semibold text-slate-900">#{{ product.store_id }}</p>
									</div>
								</div>
							</div>

							<div class="rounded-xl border border-slate-200 bg-white p-6">
								<h2 class="mb-4 text-lg font-semibold text-slate-900">Shopper view</h2>
								<p class="text-sm text-slate-600">Open this product as customers see it.</p>
								<NuxtLink
									:to="{ path: '/products', query: { store_id: String(product.store_id) } }"
									class="mt-4 inline-flex w-full items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50"
								>
									View store catalogue
								</NuxtLink>
							</div>
						</aside>
					</div>
				</template>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';
import type { MerchantProduct } from '~/types/merchant';
import { merchantFetchProduct, merchantFetchStore, merchantUpdateProduct } from '~/composables/useMerchant';
import { getPoundAndPenceFormat } from '~/utils/money';

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

const pending = ref(true);
const toggling_live = ref(false);
const not_found = ref(false);
const wrong_store = ref(false);
const error_message = ref<string | null>(null);
const product = ref<MerchantProduct | null>(null);
const store_name = ref('Store');

const product_view_crumbs = computed<BreadcrumbItem[]>(() => {
	const sid = store_id.value;
	const pid = product_id.value;
	if (sid == null || pid == null) return [];
	const product_label = product.value?.name?.trim() ? product.value.name : 'Product';
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: store_name.value, to: `/merchant/stores/${sid}` },
		{ label: 'Products', to: `/merchant/stores/${sid}/products` },
		{ label: product_label },
	];
});

const placeholder_image = '/images/product-placeholder.svg';

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
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

async function toggle_live() {
	if (!product.value || product_id.value == null || toggling_live.value) return;
	toggling_live.value = true;
	error_message.value = null;
	try {
		const updated = await merchantUpdateProduct(product_id.value, {
			is_active: !product.value.is_active,
		});
		product.value = updated;
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
	} finally {
		toggling_live.value = false;
	}
}

watch(
	() => [route.params.storeId, route.params.productId],
	() => load(),
);

onMounted(() => load());
</script>
