<template>
	<main class="pt-24 pb-8 px-6 max-w-2xl mx-auto min-h-screen">
		<div class="mb-6">
			<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900">Pay with card</h1>
			<p class="font-normal text-base text-slate-600 mt-2">
				Test mode: use card <code class="text-sm bg-slate-100 px-1 rounded">4242 4242 4242 4242</code>, any future
				expiry, any CVC.
			</p>
			<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
		</div>

		<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
			Loading payment…
		</div>

		<div v-else-if="stripe_ready" class="space-y-6">
			<div class="bg-white border border-slate-400 rounded-xl p-4">
				<p class="text-sm text-slate-600 mb-1">Total</p>
				<p class="text-2xl font-bold text-slate-900">{{ format_money(total_gbp) }}</p>
				<p class="text-xs text-slate-500 mt-2">Orders: {{ order_ids.join(', ') }}</p>
			</div>

			<div id="payment-element" class="min-h-[200px]" />

			<button
				type="button"
				:disabled="paying || !elements_ready"
				class="w-full bg-slate-900 text-white py-4 font-semibold text-sm uppercase tracking-widest rounded-lg hover:bg-slate-800 disabled:opacity-50 disabled:pointer-events-none"
				@click="submit_payment"
			>
				{{ paying ? 'Processing…' : 'Pay now' }}
			</button>

			<NuxtLink to="/account/payment" class="block text-center text-sm text-slate-600 hover:underline">
				Skip to account (order stays pending until paid)
			</NuxtLink>
		</div>

		<div
			v-else-if="!error_message"
			class="rounded-xl border border-amber-200 bg-amber-50 p-6 text-amber-900 text-sm"
		>
			Stripe is not configured. Set <code class="font-mono">NUXT_PUBLIC_STRIPE_PUBLISHABLE_KEY</code> in
			<code class="font-mono">frontend/.env</code> and add <code class="font-mono">stripe.secretKey</code> in
			<code class="font-mono">backend/api/config/params-local.php</code>.
		</div>

		<div v-else class="rounded-xl border border-slate-200 bg-white p-8 text-center text-slate-600 text-sm">
			<p class="mb-4">Payment could not be started.</p>
			<NuxtLink to="/checkout/review" class="font-semibold text-slate-900 underline">Back to review</NuxtLink>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { Stripe, StripeElements, StripePaymentElement } from '@stripe/stripe-js';
import { useStripeClient } from '~/composables/useStripeClient';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const CHECKOUT_PENDING_KEY = 'checkout_pending_order_ids';

const route = useRoute();
const router = useRouter();

type CreateIntentResponse = {
	client_secret: string;
	payment_intent_id: string;
	amount_pence: number;
	currency: string;
	order_ids: number[];
};

const api = useApi();

const pending = ref(true);
const paying = ref(false);
const error_message = ref<string | null>(null);
const stripe_ready = ref(false);
const elements_ready = ref(false);
const order_ids = ref<number[]>([]);
const total_gbp = ref(0);

let stripe: Stripe | null = null;
let elements: StripeElements | null = null;
let payment_element: StripePaymentElement | null = null;

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

function load_pending_ids(): number[] | null {
	if (typeof sessionStorage === 'undefined') {
		return null;
	}
	const raw = sessionStorage.getItem(CHECKOUT_PENDING_KEY);
	if (!raw) {
		return null;
	}
	try {
		const ids = JSON.parse(raw) as unknown;
		if (!Array.isArray(ids) || !ids.every((x) => typeof x === 'number')) {
			return null;
		}
		return ids as number[];
	} catch {
		return null;
	}
}

/** e.g. notification link `/checkout/pay?order_ids=12` or `12,34` */
function parse_order_ids_query(raw: unknown): number[] | null {
	if (raw == null) {
		return null;
	}
	const s = Array.isArray(raw) ? raw[0] : raw;
	if (typeof s !== 'string' || !s.trim()) {
		return null;
	}
	const parts = s.split(',').map((p) => Number.parseInt(p.trim(), 10));
	const ids = parts.filter((n) => Number.isFinite(n) && n > 0);
	return ids.length > 0 ? ids : null;
}

/**
 * Mount Payment Element after the template branch that contains `#payment-element` is visible.
 * While `pending` is true, only the loading block is rendered — mounting earlier hits a missing node.
 */
async function mount_payment_element(client_secret: string, amount_pence: number) {
	stripe = await useStripeClient();
	stripe_ready.value = Boolean(stripe);
	total_gbp.value = amount_pence / 100;

	pending.value = false;
	await nextTick();

	if (!stripe) {
		return;
	}

	elements = stripe.elements({ clientSecret: client_secret, appearance: { theme: 'stripe' } });
	payment_element = elements.create('payment');
	payment_element.mount('#payment-element');
	elements_ready.value = true;
}

async function submit_payment() {
	if (!stripe || !elements || !payment_element) {
		return;
	}
	paying.value = true;
	error_message.value = null;
	try {
		const { error, paymentIntent } = await stripe.confirmPayment({
			elements,
			redirect: 'if_required',
		});

		if (error) {
			error_message.value = error.message ?? 'Payment failed';
			return;
		}

		const pi_id = paymentIntent?.id;
		if (!pi_id || paymentIntent?.status !== 'succeeded') {
			error_message.value = 'Payment did not complete. Please try again.';
			return;
		}

		await api.post('/customer/payments/sync', { payment_intent_id: pi_id });

		if (typeof sessionStorage !== 'undefined') {
			sessionStorage.removeItem(CHECKOUT_PENDING_KEY);
		}

		const ids = order_ids.value.map(String).join(',');
		await navigateTo({ path: '/checkout/success', query: { ids } });
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Payment failed';
		error_message.value = msg;
	} finally {
		paying.value = false;
	}
}

onMounted(async () => {
	pending.value = true;
	error_message.value = null;

	let ids = load_pending_ids();
	if (!ids || ids.length === 0) {
		const from_query = parse_order_ids_query(route.query.order_ids);
		if (from_query?.length) {
			ids = from_query;
			if (typeof sessionStorage !== 'undefined') {
				sessionStorage.setItem(CHECKOUT_PENDING_KEY, JSON.stringify(ids));
			}
			await router.replace({ path: '/checkout/pay' });
		}
	}

	if (!ids || ids.length === 0) {
		await navigateTo('/checkout/review');
		return;
	}

	order_ids.value = ids;

	try {
		const intent = await api.post<CreateIntentResponse>('/customer/payments/create-intent', {
			order_ids: ids,
		});
		await mount_payment_element(intent.client_secret, intent.amount_pence);
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Could not start payment';
		error_message.value = msg;
		pending.value = false;
	}
});

onBeforeUnmount(() => {
	try {
		payment_element?.unmount();
	} catch {
		// ignore
	}
	payment_element = null;
	elements = null;
	stripe = null;
});
</script>
