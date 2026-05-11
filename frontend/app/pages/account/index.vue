<template>
	<main class="flex-1 md:ml-64 bg-slate-50 p-6 md:p-12 overflow-y-auto">
		<div class="max-w-5xl mx-auto">
			<header class="mb-12">
				<BreadcrumbsComponent
					class="mb-6"
					:items="[
						{ label: 'Home', to: '/' },
						{ label: 'Account' },
					]"
				/>
				<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900 mb-2">
					Welcome back<span v-if="display_first_name">, {{ display_first_name }}</span>
				</h1>
				<p class="font-normal text-base text-slate-600">
					Here is a summary of your recent orders and account shortcuts.
				</p>
				<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
			</header>

			<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-8 text-slate-600">Loading…</div>

			<template v-else>
				<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
					<div
						class="md:col-span-2 bg-white p-6 border border-slate-400 rounded shadow-sm flex flex-col justify-between"
					>
						<div>
							<span class="font-semibold text-sm text-slate-600 uppercase tracking-wider mb-4 block"
								>Primary Profile</span
							>
							<div class="flex items-center gap-4 mb-6">
								<div
									class="size-16 rounded-full overflow-hidden bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xl"
								>
									{{ initials }}
								</div>
								<div>
									<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">
										{{ full_name }}
									</h3>
									<p class="font-normal text-base text-slate-600">{{ email_display }}</p>
								</div>
							</div>
						</div>
						<div class="flex gap-3">
							<NuxtLink
								to="/account/addresses"
								class="bg-slate-900 text-white px-4 py-2 font-semibold text-sm rounded transition-all active:scale-95 inline-flex items-center justify-center"
							>
								Addresses
							</NuxtLink>
							<NuxtLink
								to="/account/payment"
								class="border border-slate-900 text-slate-900 px-4 py-2 font-semibold text-sm rounded hover:bg-slate-50 transition-all inline-flex items-center justify-center"
							>
								Payment
							</NuxtLink>
						</div>
					</div>
					<div class="bg-slate-800 text-slate-50 p-6 rounded shadow-sm flex flex-col justify-between">
						<div>
							<span class="font-semibold text-sm text-slate-50 opacity-60 uppercase tracking-wider mb-2 block"
								>Quick tip</span
							>
							<h3 class="font-semibold tracking-tight text-xl leading-snug text-white mb-2">
								Saved addresses
							</h3>
							<p class="font-normal text-base text-slate-50 opacity-80">
								You have {{ address_count }} saved {{ address_count === 1 ? 'address' : 'addresses' }} for faster
								checkout.
							</p>
						</div>
						<NuxtLink
							to="/account/addresses"
							class="mt-4 text-sm font-semibold text-white underline underline-offset-4 hover:opacity-90"
						>
							Manage addresses
						</NuxtLink>
					</div>
				</div>

				<section class="mb-12">
					<div class="flex items-center justify-between mb-6">
						<h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Recent Orders</h2>
					</div>
					<div v-if="orders_pending" class="rounded-lg border border-slate-200 bg-white p-8 text-slate-600">
						Loading orders…
					</div>
					<div
						v-else-if="orders.length === 0"
						class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600"
					>
						No orders yet. When you place an order, it will appear here.
					</div>
					<div v-else class="bg-white border border-slate-400 rounded overflow-hidden shadow-sm">
						<table class="w-full text-left border-collapse">
							<thead>
								<tr class="bg-slate-50 border-b border-slate-400">
									<th class="p-4 font-semibold text-sm text-slate-600">Order ID</th>
									<th class="p-4 font-semibold text-sm text-slate-600">Date</th>
									<th class="p-4 font-semibold text-sm text-slate-600">Items</th>
									<th class="p-4 font-semibold text-sm text-slate-600">Total</th>
									<th class="p-4 font-semibold text-sm text-slate-600">Status</th>
								</tr>
							</thead>
							<tbody class="divide-y divide-slate-200">
								<tr v-for="order in orders_preview" :key="order.id" class="hover:bg-slate-50 transition-colors">
									<td class="p-4 font-semibold text-sm text-slate-900">#{{ order.id }}</td>
									<td class="p-4 font-normal text-base text-slate-600">{{ formatOrderPlacedAt(order.placed_at, 'account_date') }}</td>
									<td class="p-4 font-normal text-base text-slate-600">
										{{ order.item_count ?? '—' }}
									</td>
									<td class="p-4 text-base font-bold text-slate-900">{{ format_money(order.price_total) }}</td>
									<td class="p-4">
										<OrdersStatusBadgeComponent :status="order.status" />
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</section>

				<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
					<NuxtLink
						to="/account/addresses"
						class="bg-white p-6 border border-slate-400 rounded shadow-sm hover:shadow-md transition-all group block"
					>
						<div class="flex items-center gap-4 mb-4">
							<div
								class="size-10 bg-slate-100 rounded flex items-center justify-center text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-colors"
							>
								<span class="material-symbols-outlined">location_on</span>
							</div>
							<h3 class="font-semibold tracking-tight text-lg">Shipping Addresses</h3>
						</div>
						<p class="font-normal text-base text-slate-600 mb-4">
							Manage your saved delivery locations.
						</p>
						<span class="text-slate-900 font-semibold text-sm"
							>{{ address_count }} saved {{ address_count === 1 ? 'address' : 'addresses' }}</span
						>
					</NuxtLink>
					<NuxtLink
						to="/account/payment"
						class="bg-white p-6 border border-slate-400 rounded shadow-sm hover:shadow-md transition-all group block"
					>
						<div class="flex items-center gap-4 mb-4">
							<div
								class="size-10 bg-slate-100 rounded flex items-center justify-center text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-colors"
							>
								<span class="material-symbols-outlined">payments</span>
							</div>
							<h3 class="font-semibold tracking-tight text-lg">Payment Methods</h3>
						</div>
						<p class="font-normal text-base text-slate-600 mb-4">
							Payment details are confirmed at checkout.
						</p>
						<span class="text-slate-900 font-semibold text-sm">Manage preferences</span>
					</NuxtLink>
					<button
						type="button"
						class="text-left bg-white p-6 border border-slate-400 rounded shadow-sm hover:shadow-md transition-all group cursor-pointer w-full"
						@click="on_sign_out"
					>
						<div class="flex items-center gap-4 mb-4">
							<div
								class="size-10 bg-slate-100 rounded flex items-center justify-center text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-colors"
							>
								<span class="material-symbols-outlined">logout</span>
							</div>
							<h3 class="font-semibold tracking-tight text-lg">Sign out</h3>
						</div>
						<p class="font-normal text-base text-slate-600 mb-4">End your session on this device.</p>
						<span class="text-slate-900 font-semibold text-sm">Log out</span>
					</button>
				</section>
			</template>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { CustomerAddress, CustomerOrder } from '~/types/customer';
import { formatOrderPlacedAt } from '~/utils/order-display';
import { getPoundAndPenceFormat } from '~/utils/money';

definePageMeta({
	middleware: ['role-customer'],
});

const api = useApi();
const { user, logout, refresh_me } = useAuth();

const pending = ref(true);
const orders_pending = ref(true);
const error_message = ref<string | null>(null);
const orders = ref<CustomerOrder[]>([]);
const addresses = ref<CustomerAddress[]>([]);

const display_first_name = computed(() => (user.value?.first_name ?? '').trim());
const full_name = computed(() => (user.value?.full_name ?? 'Your account').trim());
const email_display = computed(() => user.value?.email ?? '');

const initials = computed(() => {
	const u = user.value;
	if (!u) return '?';
	const a = (u.first_name ?? '').trim().charAt(0);
	const b = (u.last_name ?? '').trim().charAt(0);
	const s = `${a}${b}`.toUpperCase();
	return s || '?';
});

const address_count = computed(() => addresses.value.length);

const orders_preview = computed(() => orders.value.slice(0, 5));

function format_money(n: number) {
	return getPoundAndPenceFormat(n);
}

async function load_orders() {
	orders_pending.value = true;
	try {
		orders.value = await api.get<CustomerOrder[]>('/customer/orders');
	} catch {
		orders.value = [];
	} finally {
		orders_pending.value = false;
	}
}

async function load_addresses() {
	try {
		addresses.value = await api.get<CustomerAddress[]>('/customer/addresses');
	} catch {
		addresses.value = [];
	}
}

async function on_sign_out() {
	await logout();
	await navigateTo('/');
}

onMounted(async () => {
	error_message.value = null;
	pending.value = true;
	try {
		await refresh_me();
		await Promise.all([load_orders(), load_addresses()]);
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load account';
		error_message.value = msg;
	} finally {
		pending.value = false;
	}
});
</script>
