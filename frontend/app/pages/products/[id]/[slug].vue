<template>
	<main class="flex w-screen pl-16 pr-4 py-16">
		<section class="lg:grid-cols-12 w-full grid grid-cols-1 gap-8">
			<div class="w-full flex flex-col lg:col-span-7">
				<div
					class="aspect-square rounded-xl overflow-hidden relative border flex items-center justify-center bg-slate-100"
				>
					<img
						v-if="product?.thumbnail"
						class="size-full object-cover"
						:alt="product?.name ?? 'Product'"
						:src="product.thumbnail"
					/>
					<img
						v-else
						class="size-full object-contain p-12 opacity-60"
						alt=""
						src="/images/product-placeholder.svg"
					/>
				</div>
			</div>

			<div class="lg:col-span-5 w-full flex flex-col pl-12 pr-6">
				<p v-if="pending" class="text-slate-600">Loading product…</p>
				<template v-else-if="product">
					<h1 class="text-5xl font-bold">{{ product.name }}</h1>

					<div class="flex flex-wrap items-center gap-3 mt-4">
						<span class="text-slate-900 text-xl font-semibold">{{ format_money(product.price_in_gbp) }}</span>
						<span
							class="px-2 py-1 text-slate-700 rounded-full flex items-center gap-1 border border-slate-400 text-sm"
						>
							<span class="material-symbols-outlined text-base text-emerald-600" style="font-variation-settings: 'FILL' 1"
								>check_circle</span
							>
							{{ product.number_in_stock > 0 ? 'In stock' : 'Out of stock' }}
						</span>
						<span v-if="product.product_category_name" class="text-sm text-slate-600">{{
							product.product_category_name
						}}</span>
					</div>

					<p v-if="product.description" class="font-normal text-lg mb-6 mt-4 text-slate-700 whitespace-pre-line">
						{{ product.description }}
					</p>
					<p v-else class="font-normal text-slate-500 mb-6 mt-4 italic">No description available.</p>

					<p v-if="error_message" class="text-sm text-red-600 mb-4">{{ error_message }}</p>

					<div class="border-t pt-6 flex flex-col mb-6">
						<div class="font-semibold text-sm mb-2">Quantity</div>
						<div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
							<div class="flex items-center border border-slate-300 rounded-lg h-14 w-36 shrink-0">
								<button
									type="button"
									class="flex-1 flex items-center justify-center hover:text-slate-900 transition-colors active:bg-slate-50 rounded-l-lg disabled:opacity-40"
									:disabled="qty <= 1 || product.number_in_stock <= 0"
									@click="qty = Math.max(1, qty - 1)"
								>
									<span class="material-symbols-outlined">remove</span>
								</button>
								<span class="font-semibold text-sm w-10 text-center">{{ qty }}</span>
								<button
									type="button"
									class="flex-1 flex items-center justify-center hover:text-slate-900 transition-colors active:bg-slate-50 rounded-r-lg disabled:opacity-40"
									:disabled="product.number_in_stock <= 0 || qty >= product.number_in_stock"
									@click="qty = Math.min(product.number_in_stock, qty + 1)"
								>
									<span class="material-symbols-outlined">add</span>
								</button>
							</div>
							<button
								type="button"
								class="flex-1 h-14 bg-slate-900 text-white rounded-lg font-semibold text-sm flex items-center justify-center gap-2 hover:bg-slate-800 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed"
								:disabled="adding || product.number_in_stock <= 0"
								@click="add_to_basket"
							>
								<span class="material-symbols-outlined">shopping_bag</span>
								{{ product.number_in_stock <= 0 ? 'Unavailable' : adding ? 'Adding…' : 'Add to Basket' }}
							</button>
						</div>
						<p v-if="product.number_in_stock > 0" class="text-xs text-slate-500 mt-2">
							{{ product.number_in_stock }} available
						</p>
					</div>
				</template>
			</div>
		</section>
	</main>
</template>

<script setup lang="ts">
import type { Product } from '~/types/product';
import { fetchProductById } from '~/composables/useProducts';
import { getPoundAndPenceFormat } from '~/utils/money';

const route = useRoute();
const api = useApi();
const { refresh_basket_item_count } = useBasketItemCount();

const product_id_param = computed(() => {
	const raw = route.params.id;
	const n = typeof raw === 'string' ? parseInt(raw, 10) : Array.isArray(raw) ? parseInt(raw[0] ?? '', 10) : NaN;
	return Number.isFinite(n) && n > 0 ? n : NaN;
});

const pending = ref(true);
const product = ref<Product | null>(null);
const error_message = ref<string | null>(null);
const qty = ref(1);
const adding = ref(false);

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

async function load_product() {
	pending.value = true;
	error_message.value = null;
	try {
		const id = product_id_param.value;
		if (!Number.isFinite(id)) {
			throw createError({ statusCode: 404, statusMessage: 'Product not found' });
		}
		const p = await fetchProductById(id);
		product.value = p;
		qty.value = 1;
		if (!p) {
			throw createError({ statusCode: 404, statusMessage: 'Product not found' });
		}
	} catch (e: unknown) {
		const code =
			e && typeof e === 'object' && 'statusCode' in e ? (e as { statusCode?: number }).statusCode : undefined;
		if (code === 404) throw e;
		error_message.value = 'Could not load this product. Please try again.';
		product.value = null;
	} finally {
		pending.value = false;
	}
}

watch(product_id_param, () => load_product(), { immediate: true });

async function add_to_basket() {
	const p = product.value;
	if (!p || p.number_in_stock <= 0) return;

	error_message.value = null;
	adding.value = true;
	try {
		await api.post('/basket/add', {
			product_id: p.id,
			quantity: qty.value,
		});
		await refresh_basket_item_count();
		await navigateTo('/basket');
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e
				? String((e as { message?: string }).message)
				: 'Could not add to basket. Sign in as a customer and try again.';
		error_message.value = msg;
	} finally {
		adding.value = false;
	}
}
</script>
