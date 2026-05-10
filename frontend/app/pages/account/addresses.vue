<template>
	<main class="grow ml-0 md:ml-64 p-6 lg:p-12">
		<div class="max-w-5xl mx-auto">
			<header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
				<div>
					<nav class="flex items-center gap-2 text-xs text-slate-700 mb-4">
						<NuxtLink class="hover:text-slate-900" to="/account">Account</NuxtLink>
						<span class="material-symbols-outlined text-sm">chevron_right</span>
						<span class="text-slate-900 font-bold">Addresses</span>
					</nav>
					<h1 class="font-bold text-slate-900 tracking-tight">Saved Addresses</h1>
					<p class="font-normal text-slate-600 mt-2">
						Manage your default shipping and billing information for faster checkout.
					</p>
					<p v-if="error_message" class="text-sm text-red-600 mt-2">{{ error_message }}</p>
				</div>
				<button
					type="button"
					disabled
					class="bg-slate-900 text-white font-semibold px-6 py-3 rounded-full flex items-center gap-2 opacity-50 cursor-not-allowed shadow-lg shadow-black/5"
					title="Address editing via API is not enabled yet"
				>
					<span class="material-symbols-outlined text-xl" data-icon="add_location_alt">add_location_alt</span>
					Add New Address
				</button>
			</header>

			<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
				Loading addresses…
			</div>

			<div
				v-else-if="addresses.length === 0"
				class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center"
			>
				<p class="text-slate-700 font-medium mb-2">No saved addresses yet</p>
				<p class="text-slate-600 text-sm">
					Addresses you add at checkout or in your profile will show here when the API supports listing them.
				</p>
			</div>

			<div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-6">
				<div
					v-for="(addr, index) in addresses"
					:key="addr.id"
					class="bg-white border border-slate-400 p-8 rounded-xl relative group hover:border-slate-900 transition-colors"
					:class="index === 0 ? 'lg:col-span-7' : 'lg:col-span-5'"
				>
					<div class="flex justify-between items-start mb-6">
						<span
							class="px-3 py-1 rounded-full text-xs flex items-center gap-1"
							:class="badge_class(addr.address_type)"
						>
							<span v-if="index === 0" class="material-symbols-outlined text-base" style="font-variation-settings: 'FILL' 1"
								>star</span
							>
							{{ type_label(addr.address_type, index) }}
						</span>
					</div>
					<h3 class="font-semibold tracking-tight text-slate-900 mb-2">{{ addr.city }}, {{ addr.country }}</h3>
					<p class="font-normal text-slate-900 leading-relaxed whitespace-pre-line">{{ format_address(addr) }}</p>
					<div class="mt-8 flex flex-wrap items-center gap-4 pt-6 border-t border-slate-100">
						<div class="flex items-center gap-2 text-slate-600">
							<span class="material-symbols-outlined text-lg">markunread_mailbox</span>
							<span class="text-sm">{{ addr.post_code }}</span>
						</div>
					</div>
				</div>

				<div
					class="lg:col-span-12 bg-slate-50 border border-slate-400 rounded-xl overflow-hidden relative min-h-40 flex items-center justify-center p-8"
				>
					<p class="text-sm text-slate-600 text-center">
						<span class="font-semibold text-slate-900">{{ addresses.length }}</span>
						saved {{ addresses.length === 1 ? 'address' : 'addresses' }}
					</p>
				</div>
			</div>

			<div
				class="mt-12 border-2 border-dashed border-slate-400 rounded-xl p-12 flex flex-col items-center justify-center text-center"
			>
				<div class="bg-slate-100 size-16 rounded-full flex items-center justify-center mb-4">
					<span class="material-symbols-outlined text-slate-600" data-icon="add_location">add_location</span>
				</div>
				<h4 class="font-semibold tracking-tight text-slate-900">More addresses</h4>
				<p class="font-normal text-slate-600 mt-2 max-w-md">
					Add shipping and billing addresses during checkout; they will appear in this list automatically.
				</p>
			</div>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { CustomerAddress } from '~/types/customer';

definePageMeta({
	middleware: ['role-customer'],
});

const api = useApi();

const pending = ref(true);
const error_message = ref<string | null>(null);
const addresses = ref<CustomerAddress[]>([]);

function format_address(a: CustomerAddress) {
	const lines = [
		`${a.building_number} ${a.street_name}`.trim(),
		a.city,
		[a.region, a.post_code].filter(Boolean).join(', '),
		a.country,
	];
	return lines.filter((x) => x && String(x).trim() !== '').join('\n');
}

function type_label(type: string, index: number) {
	if (index === 0) return 'Primary';
	if (type === 'billing') return 'Billing';
	if (type === 'shipping') return 'Shipping';
	if (type === 'both') return 'Shipping & Billing';
	return type;
}

function badge_class(type: string) {
	if (type === 'billing') return 'bg-slate-200 text-slate-900';
	if (type === 'shipping') return 'bg-slate-100 text-slate-700';
	return 'bg-slate-100 text-slate-700';
}

onMounted(async () => {
	error_message.value = null;
	pending.value = true;
	try {
		addresses.value = await api.get<CustomerAddress[]>('/customer/addresses');
	} catch (e: unknown) {
		const msg =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load addresses';
		error_message.value = msg;
		addresses.value = [];
	} finally {
		pending.value = false;
	}
});
</script>
