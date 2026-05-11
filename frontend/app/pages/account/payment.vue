<template>
	<main class="flex-1 md:ml-64 p-6 md:p-12">
		<div class="max-w-4xl mx-auto">
			<header class="mb-10">
				<BreadcrumbsComponent
					class="mb-4"
					:items="[
						{ label: 'Account', to: '/account' },
						{ label: 'Payment' },
					]"
				/>
				<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900 mb-2">Payment &amp; billing</h1>
				<p class="font-normal text-base text-slate-600">
					Saved cards are not stored by this demo. Your real purchase history appears below from completed checkouts.
				</p>
				<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
			</header>

			<div
				class="mb-8 p-6 bg-slate-100 rounded-xl border border-slate-400 flex items-start gap-4"
			>
				<span class="material-symbols-outlined text-slate-700 mt-1">shield</span>
				<div>
					<h3 class="font-semibold text-sm text-slate-700 mb-1 uppercase tracking-wider">Security first</h3>
					<p class="font-normal text-base text-slate-700 opacity-80">
						A production deployment would tokenise cards with your PSP and never hold full card details on this app.
					</p>
				</div>
			</div>

			<section class="mb-12">
				<h2 class="font-semibold text-lg text-slate-900 mb-4">Saved payment methods</h2>
				<div
					class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center text-slate-600"
				>
					<span class="material-symbols-outlined text-4xl text-slate-400 mb-3 block mx-auto">credit_card_off</span>
					<p class="font-medium text-slate-800 mb-1">No saved cards</p>
					<p class="text-sm max-w-md mx-auto">
						Payment methods are collected at checkout when you connect a payments provider. Nothing is stored here yet.
					</p>
				</div>
			</section>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="md:col-span-2 bg-white border border-slate-400 p-6 rounded-xl">
					<h4 class="font-semibold text-sm text-slate-900 mb-4 uppercase tracking-widest">Recent billing activity</h4>
					<div v-if="pending" class="py-8 text-center text-slate-600">Loading orders…</div>
					<div v-else-if="orders.length === 0" class="py-8 text-center text-slate-600 border border-dashed border-slate-200 rounded-lg">
						No orders yet. When you place an order, it will show here with amount and status.
					</div>
					<div v-else class="space-y-4">
						<div
							v-for="o in orders"
							:key="o.id"
							class="flex justify-between items-center py-3 border-b border-slate-200 last:border-0 gap-4"
						>
							<div class="flex gap-3 items-center min-w-0">
								<span class="material-symbols-outlined text-slate-600 shrink-0">shopping_bag</span>
								<div class="min-w-0">
									<p class="font-semibold text-sm text-slate-900 truncate">Order #{{ o.id }}</p>
									<p class="text-xs text-slate-600">{{ format_datetime(o.placed_at) }} · {{ status_label(o.status) }}</p>
								</div>
							</div>
							<p class="font-bold text-slate-900 shrink-0">{{ format_money(o.price_total) }}</p>
						</div>
					</div>
				</div>
				<div class="relative overflow-hidden rounded-xl bg-slate-800 text-white p-6 flex flex-col justify-between">
					<div class="z-10">
						<h4 class="font-semibold text-sm mb-2 uppercase tracking-widest text-white/90">Orders on file</h4>
						<p class="font-bold tracking-tight text-4xl leading-tight">{{ orders.length }}</p>
					</div>
					<NuxtLink to="/account" class="z-10 text-sm font-semibold underline underline-offset-4 hover:opacity-90 mt-4 inline-block">
						View account overview
					</NuxtLink>
					<div class="absolute top-0 right-0 size-32 bg-slate-600 opacity-20 blur-3xl -mr-16 -mt-16"></div>
					<div class="absolute bottom-0 left-0 size-24 bg-slate-200 opacity-10 blur-2xl -ml-8 -mb-8"></div>
				</div>
			</div>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { CustomerOrder } from '~/types/customer';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const api = useApi();

const pending = ref(true);
const error_message = ref<string | null>(null);
const orders = ref<CustomerOrder[]>([]);

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

function format_datetime(iso: string) {
	try {
		const date = new Date(iso);
		return date.toLocaleString(undefined, { dateStyle: 'medium', timeStyle: 'short' });
	} catch {
		return iso;
	}
}

function status_label(s: string) {
	return s.replace(/_/g, ' ');
}

async function load() {
	error_message.value = null;
	pending.value = true;
	try {
		const list = await api.get<CustomerOrder[]>('/customer/orders');
		orders.value = Array.isArray(list) ? list.slice(0, 12) : [];
	} catch (err: unknown) {
		const msg =
			err && typeof err === 'object' && 'message' in err ? String((err as { message?: string }).message) : 'Could not load orders';
		error_message.value = msg;
		orders.value = [];
	} finally {
		pending.value = false;
	}
}

onMounted(() => {
	load();
});
</script>
