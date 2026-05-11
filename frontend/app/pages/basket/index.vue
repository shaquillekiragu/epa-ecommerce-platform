<template>
	<main class="grow pt-20 md:py-25 md:pb-20 px-4 max-w-7xl mx-auto w-full">
		<div class="mb-6">
			<h1 class="font-bold tracking-tight text-4xl leading-tight text-slate-900">Your Basket</h1>
			<p class="font-normal text-base text-slate-600 mt-2">
				<span v-if="pending">Loading basket…</span>
				<span v-else>{{ item_count }} {{ item_count === 1 ? 'item' : 'items' }} in your basket.</span>
			</p>
			<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
		</div>

		<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
			Loading…
		</div>

		<div v-else-if="lines.length === 0" class="rounded-xl border border-slate-200 bg-white p-12 text-center">
			<p class="text-slate-700 font-medium mb-2">Your basket is empty</p>
			<p class="text-slate-600 text-sm mb-6">Browse products and add something you like.</p>
			<NuxtLink
				to="/products"
				class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white hover:bg-slate-800 transition-colors"
			>
				Continue shopping
			</NuxtLink>
		</div>

		<section v-else class="grid grid-cols-1 lg:grid-cols-12 gap-6">
			<article class="lg:col-span-8 flex flex-col gap-4">
				<div
					v-for="line in lines"
					:key="line.product_id"
					class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row gap-4 items-start sm:items-center"
				>
					<div
						class="w-full sm:size-40 bg-slate-100 shrink-0 rounded-lg overflow-hidden border border-slate-400/30"
					>
						<img
							:alt="line.product_name"
							class="size-full object-cover"
							:src="line.thumbnail || placeholder_image"
						/>
					</div>
					<div class="grow flex flex-col gap-2 w-full">
						<div class="flex justify-between items-start w-full">
							<div>
								<NuxtLink
									:to="productDetailRoute(line.product_id, line.product_slug ?? '')"
									class="font-semibold tracking-tight text-xl leading-snug text-slate-900 hover:underline"
								>
									{{ line.product_name }}
								</NuxtLink>
							</div>
							<span class="text-lg font-bold text-slate-900 ml-4 whitespace-nowrap">{{
								format_money(line.line_total)
							}}</span>
						</div>
						<div class="flex items-center justify-between mt-auto pt-2">
							<div class="flex items-center border border-slate-400 rounded-lg h-10 w-fit">
								<button
									type="button"
									aria-label="Decrease quantity"
									class="w-10 h-full flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors rounded-l-lg disabled:opacity-40"
									:disabled="updating_id === line.product_id || line.quantity <= 1"
									@click="change_qty(line.product_id, line.quantity - 1)"
								>
									<span class="material-symbols-outlined text-lg">remove</span>
								</button>
								<span
									class="w-10 text-center font-semibold text-sm text-slate-900 flex items-center justify-center"
									>{{ line.quantity }}</span
								>
								<button
									type="button"
									aria-label="Increase quantity"
									class="w-10 h-full flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors rounded-r-lg disabled:opacity-40"
									:disabled="updating_id === line.product_id"
									@click="change_qty(line.product_id, line.quantity + 1)"
								>
									<span class="material-symbols-outlined text-lg">add</span>
								</button>
							</div>
							<button
								type="button"
								class="flex items-center gap-1 text-red-600 hover:text-red-600/80 transition-colors font-semibold text-sm group disabled:opacity-40"
								:disabled="updating_id === line.product_id"
								@click="remove_line(line.product_id)"
							>
								<span
									class="material-symbols-outlined text-lg group-hover:scale-110 transition-transform"
									>delete</span
								>
								<span>Remove</span>
							</button>
						</div>
					</div>
				</div>
			</article>

			<article class="lg:col-span-4">
				<div class="bg-white border border-slate-200 rounded-xl p-4 sticky top-30">
					<h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-4">Order Summary</h2>
					<div class="flex flex-col gap-2 border-b border-slate-200 pb-4 mb-4">
						<div class="flex justify-between items-center font-normal text-base text-slate-600">
							<span>Subtotal</span>
							<span class="text-slate-900 font-medium">{{ format_money(subtotal) }}</span>
						</div>
						<div class="flex justify-between items-center font-normal text-base text-slate-600">
							<span>Estimated Shipping</span>
							<span class="text-slate-900 font-medium">At checkout</span>
						</div>
					</div>
					<div
						class="flex justify-between items-center font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-6"
					>
						<span>Total</span>
						<span>{{ format_money(subtotal) }}</span>
					</div>
					<NuxtLink
						to="/checkout"
						class="w-full bg-slate-900 text-white py-2 px-4 rounded-lg font-semibold text-sm hover:bg-slate-900/90 transition-colors shadow-sm flex items-center justify-center gap-2"
					>
						Proceed to Checkout
						<span class="material-symbols-outlined text-lg">arrow_forward</span>
					</NuxtLink>
					<div class="mt-2 text-center">
						<p class="font-medium text-xs text-slate-600 flex items-center justify-center gap-1">
							<span class="material-symbols-outlined text-sm">lock</span>
							Secure Checkout Guarantee
						</p>
					</div>
				</div>
			</article>
		</section>
	</main>
</template>

<script setup lang="ts">
import type { BasketLine, BasketResponse } from '~/types/basket';
import { productDetailRoute } from '~/composables/useProducts';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const api = useApi();
const { apply_from_basket } = useBasketItemCount();

const pending = ref(true);
const error_message = ref<string | null>(null);
const basket = ref<BasketResponse | null>(null);
const updating_id = ref<number | null>(null);

const placeholder_image = '/images/product-placeholder.svg';

const lines = computed<BasketLine[]>(() => basket.value?.items ?? []);

const item_count = computed(() =>
	lines.value.reduce((sum, l) => sum + l.quantity, 0),
);

const subtotal = computed(() => basket.value?.price_total ?? 0);

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

async function load_basket() {
	error_message.value = null;
	pending.value = true;
	try {
		basket.value = await api.get<BasketResponse>('/basket');
		apply_from_basket(basket.value);
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load basket';
		error_message.value = msg;
		basket.value = null;
		apply_from_basket(null);
	} finally {
		pending.value = false;
	}
}

async function change_qty(product_id: number, quantity: number) {
	updating_id.value = product_id;
	error_message.value = null;
	try {
		basket.value = await api.patch<BasketResponse>(`/basket/item/${product_id}`, { quantity });
		apply_from_basket(basket.value);
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Could not update quantity';
		error_message.value = msg;
	} finally {
		updating_id.value = null;
	}
}

async function remove_line(product_id: number) {
	await change_qty(product_id, 0);
}

onMounted(() => {
	load_basket();
});
</script>
