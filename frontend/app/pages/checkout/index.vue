<template>
	<main class="grow pt-24 pb-12 px-6 max-w-7xl mx-auto w-full">
		<div class="mb-8">
			<h1 class="font-bold text-3xl leading-tight text-slate-900 tracking-tight">
				Checkout: Shipping
			</h1>
			<p class="font-normal text-base text-slate-600 mt-2">
				<span v-if="pending">Loading checkout…</span>
				<span v-else>Choose where we should send your order.</span>
			</p>
			<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
		</div>

		<div class="mb-12 w-full max-w-3xl mx-auto">
			<div class="flex items-center justify-between relative">
				<div class="absolute top-1/2 left-0 w-full h-0.5 bg-slate-100 -translate-y-1/2 z-0"></div>
				<div class="absolute top-1/2 left-0 w-1/3 h-0.5 bg-slate-900 -translate-y-1/2 z-0"></div>
				<div class="relative z-10 flex flex-col items-center">
					<div
						class="size-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm ring-4 ring-background"
					>
						1
					</div>
					<span class="mt-2 font-medium text-xs text-slate-900">Shipping</span>
				</div>
				<div class="relative z-10 flex flex-col items-center">
					<div
						class="size-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm ring-4 ring-background"
					>
						2
					</div>
					<span class="mt-2 font-medium text-xs text-slate-600">Review</span>
				</div>
				<div class="relative z-10 flex flex-col items-center">
					<div
						class="size-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm ring-4 ring-background"
					>
						3
					</div>
					<span class="mt-2 font-medium text-xs text-slate-600">Done</span>
				</div>
			</div>
		</div>

		<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
			Loading…
		</div>

		<div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-12">
			<div class="lg:col-span-8 space-y-8">
				<section class="bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
					<div class="flex items-center justify-between mb-6">
						<h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Shipping address</h2>
						<NuxtLink
							to="/account/addresses"
							class="flex items-center text-slate-700 font-semibold hover:underline text-sm"
						>
							<span class="material-symbols-outlined mr-1 text-xl">edit_location</span>
							Manage addresses
						</NuxtLink>
					</div>

					<div v-if="addresses.length === 0" class="rounded-lg border border-dashed border-slate-300 bg-slate-50 p-8 text-center">
						<p class="text-slate-700 font-medium mb-2">No saved addresses yet</p>
						<p class="text-slate-600 text-sm mb-4">Add an address in your account before you can complete checkout.</p>
						<NuxtLink
							to="/account/addresses"
							class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 font-semibold text-white hover:bg-slate-800 transition-colors"
						>
							Go to addresses
						</NuxtLink>
					</div>

					<div v-else class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<label
							v-for="addr in addresses"
							:key="addr.id"
							class="relative cursor-pointer group"
						>
							<input
								v-model="selected_address_id"
								class="peer sr-only"
								name="checkout_address"
								type="radio"
								:value="addr.id"
							/>
							<div
								class="p-6 border-2 border-slate-100 rounded-xl bg-slate-50 transition-all peer-checked:border-slate-900 peer-checked:bg-white group-hover:bg-white h-full"
							>
								<div class="flex justify-between items-start mb-2">
									<span class="font-semibold text-slate-900">{{ addr.address_type }}</span>
									<span
										class="material-symbols-outlined text-slate-900 invisible peer-checked:visible"
										style="font-variation-settings: 'FILL' 1"
									>
										check_circle
									</span>
								</div>
								<p class="text-base font-normal text-slate-600 whitespace-pre-line">{{ format_address(addr) }}</p>
							</div>
						</label>
					</div>

					<p class="mt-6 text-sm text-slate-600">
						Billing will match your shipping address unless your payment provider asks for something different at
						future checkout steps.
					</p>
				</section>

				<div class="flex justify-end">
					<button
						type="button"
						:disabled="!can_continue"
						class="bg-slate-900 text-white font-semibold px-12 py-4 rounded-xl hover:bg-slate-800 transition-all flex items-center space-x-2 active:scale-95 disabled:opacity-50 disabled:pointer-events-none"
						@click="continue_to_review"
					>
						<span>Continue to review</span>
						<span class="material-symbols-outlined">arrow_forward</span>
					</button>
				</div>
			</div>

			<aside class="lg:col-span-4">
				<div class="bg-white border border-slate-200 rounded-xl p-8 shadow-sm sticky top-28">
					<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-6">Order summary</h3>

					<div v-if="lines.length === 0" class="text-slate-600 text-sm mb-8">Your basket is empty.</div>

					<div v-else class="space-y-6 mb-8">
						<div v-for="line in lines" :key="line.product_id" class="flex space-x-4">
							<div class="w-20 h-24 bg-slate-100 rounded-lg overflow-hidden shrink-0">
								<img
									:alt="line.product_name"
									class="size-full object-cover"
									:src="line.thumbnail || placeholder_image"
								/>
							</div>
							<div class="flex flex-col justify-between min-w-0">
								<div>
									<h4 class="font-semibold text-slate-900 truncate">{{ line.product_name }}</h4>
									<p class="text-xs text-slate-500">Qty {{ line.quantity }}</p>
								</div>
								<span class="font-normal text-slate-900">{{ format_money(line.line_total) }}</span>
							</div>
						</div>
					</div>

					<div class="border-t border-slate-100 pt-6 space-y-4">
						<div class="flex justify-between font-normal text-slate-600">
							<span>Subtotal</span>
							<span>{{ format_money(subtotal) }}</span>
						</div>
						<div class="flex justify-between font-normal text-slate-600">
							<span>Shipping</span>
							<span class="text-slate-700">Free</span>
						</div>
						<div class="flex justify-between border-t border-slate-100 pt-6">
							<span class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Total</span>
							<span class="font-semibold tracking-tight text-xl leading-snug text-slate-900">{{
								format_money(subtotal)
							}}</span>
						</div>
					</div>
				</div>
			</aside>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { BasketLine, BasketResponse } from '~/types/basket';
import type { CustomerAddress } from '~/types/customer';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const api = useApi();
const { apply_from_basket } = useBasketItemCount();

const checkout_selected_address_id = useState<number | null>('checkout_selected_address_id', () => null);

const pending = ref(true);
const error_message = ref<string | null>(null);
const basket = ref<BasketResponse | null>(null);
const addresses = ref<CustomerAddress[]>([]);
const selected_address_id = ref<number | null>(null);

const placeholder_image = '/images/product-placeholder.svg';

const lines = computed<BasketLine[]>(() => basket.value?.items ?? []);
const subtotal = computed(() => basket.value?.price_total ?? 0);

const can_continue = computed(
	() => !pending.value && addresses.value.length > 0 && selected_address_id.value != null && lines.value.length > 0,
);

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

function format_address(a: CustomerAddress) {
	const line1 = `${a.building_number} ${a.street_name}`.trim();
	const parts = [line1, a.city, a.region, a.post_code, a.country].filter(Boolean);
	return parts.join('\n');
}

async function load() {
	error_message.value = null;
	pending.value = true;
	try {
		const [b, addr_list] = await Promise.all([
			api.get<BasketResponse>('/basket'),
			api.get<CustomerAddress[]>('/customer/addresses'),
		]);
		basket.value = b;
		apply_from_basket(b);
		addresses.value = addr_list;

		const preferred = checkout_selected_address_id.value;
		if (preferred != null && addr_list.some((a) => a.id === preferred)) {
			selected_address_id.value = preferred;
		} else if (addr_list.length > 0) {
			selected_address_id.value = addr_list[0]!.id;
		} else {
			selected_address_id.value = null;
		}
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load checkout';
		error_message.value = msg;
		basket.value = null;
		addresses.value = [];
		apply_from_basket(null);
	} finally {
		pending.value = false;
	}
}

function continue_to_review() {
	if (!can_continue.value || selected_address_id.value == null) {
		return;
	}
	checkout_selected_address_id.value = selected_address_id.value;
	return navigateTo('/checkout/review');
}

onMounted(() => {
	load();
});
</script>
