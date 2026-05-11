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
					<p v-if="form_success" class="text-sm text-emerald-700 mt-2">{{ form_success }}</p>
				</div>
				<button
					type="button"
					class="bg-slate-900 text-white font-semibold px-6 py-3 rounded-full flex items-center gap-2 shadow-lg shadow-black/5 hover:bg-slate-800 transition-colors"
					@click="scroll_to_add_form"
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
				class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center mb-8"
			>
				<p class="text-slate-700 font-medium mb-2">No saved addresses yet</p>
				<p class="text-slate-600 text-sm max-w-md mx-auto">
					Use the form below to add your first address. It will be available at checkout.
				</p>
			</div>

			<div v-else class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
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
							<span
								v-if="index === 0"
								class="material-symbols-outlined text-base"
								style="font-variation-settings: 'FILL' 1"
							>star</span>
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

			<section
				id="add-address-form"
				ref="add_form_section"
				class="mt-12 rounded-xl border border-slate-200 bg-white p-8 md:p-10 shadow-sm"
			>
				<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
					<div class="flex gap-4">
						<div class="bg-slate-100 size-14 rounded-full flex items-center justify-center shrink-0">
							<span class="material-symbols-outlined text-slate-700 text-2xl" data-icon="add_location">add_location</span>
						</div>
						<div>
							<h2 class="font-semibold tracking-tight text-xl text-slate-900">Add a new address</h2>
							<p class="font-normal text-slate-600 text-sm mt-1 max-w-xl">
								We save this to your account so you can pick it at checkout. Postcode must use letters, numbers,
								spaces, or hyphens only.
							</p>
						</div>
					</div>
				</div>

				<form class="space-y-6" @submit.prevent="submit_new_address">
					<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
						<div class="space-y-2 md:col-span-2">
							<label class="font-medium text-slate-700 text-sm" for="addr-type">Address type</label>
							<select
								id="addr-type"
								v-model="form.address_type"
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 outline-none"
							>
								<option value="shipping">Shipping</option>
								<option value="billing">Billing</option>
								<option value="both">Shipping &amp; billing</option>
							</select>
						</div>
						<div class="space-y-2">
							<label class="font-medium text-slate-700 text-sm" for="addr-building">Building number / name</label>
							<input
								id="addr-building"
								v-model="form.building_number"
								type="text"
								required
								autocomplete="address-line2"
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 outline-none"
								placeholder="e.g. 42 or Flat 3"
							/>
						</div>
						<div class="space-y-2">
							<label class="font-medium text-slate-700 text-sm" for="addr-street">Street</label>
							<input
								id="addr-street"
								v-model="form.street_name"
								type="text"
								required
								autocomplete="address-line1"
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 outline-none"
								placeholder="Road name"
							/>
						</div>
						<div class="space-y-2">
							<label class="font-medium text-slate-700 text-sm" for="addr-city">City</label>
							<input
								id="addr-city"
								v-model="form.city"
								type="text"
								required
								autocomplete="address-level2"
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 outline-none"
							/>
						</div>
						<div class="space-y-2">
							<label class="font-medium text-slate-700 text-sm" for="addr-region">Region / county (optional)</label>
							<input
								id="addr-region"
								v-model="form.region"
								type="text"
								autocomplete="address-level1"
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 outline-none"
							/>
						</div>
						<div class="space-y-2">
							<label class="font-medium text-slate-700 text-sm" for="addr-post">Postcode</label>
							<input
								id="addr-post"
								v-model="form.post_code"
								type="text"
								required
								autocomplete="postal-code"
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 outline-none uppercase"
								placeholder="e.g. SW1A 1AA"
							/>
						</div>
						<div class="space-y-2">
							<label class="font-medium text-slate-700 text-sm" for="addr-country">Country</label>
							<input
								id="addr-country"
								v-model="form.country"
								type="text"
								required
								autocomplete="country-name"
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-slate-900/20 focus:border-slate-900 outline-none"
								placeholder="e.g. United Kingdom"
							/>
						</div>
					</div>

					<p v-if="form_error" class="text-sm text-red-600">{{ form_error }}</p>

					<div class="flex flex-wrap items-center gap-3 pt-2">
						<button
							type="submit"
							:disabled="submitting"
							class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-8 py-3 font-semibold text-white hover:bg-slate-800 transition-colors disabled:opacity-50 disabled:pointer-events-none"
						>
							{{ submitting ? 'Saving…' : 'Save address' }}
						</button>
						<button
							type="button"
							class="text-slate-700 font-medium text-sm hover:underline"
							:disabled="submitting"
							@click="reset_form"
						>
							Clear form
						</button>
					</div>
				</form>
			</section>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { CustomerAddress } from '~/types/customer';

definePageMeta({
	middleware: ['role-customer'],
});

const api = useApi();

const add_form_section = ref<HTMLElement | null>(null);

const pending = ref(true);
const submitting = ref(false);
const error_message = ref<string | null>(null);
const form_error = ref<string | null>(null);
const form_success = ref<string | null>(null);
const addresses = ref<CustomerAddress[]>([]);

const default_form = () => ({
	address_type: 'shipping',
	building_number: '',
	street_name: '',
	city: '',
	region: '',
	post_code: '',
	country: '',
});

const form = reactive(default_form());

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

function reset_form() {
	Object.assign(form, default_form());
	form_error.value = null;
}

function scroll_to_add_form() {
	add_form_section.value?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function parse_api_error(e: unknown): string {
	if (e && typeof e === 'object' && 'message' in e) {
		const raw = String((e as { message?: string }).message);
		try {
			const parsed = JSON.parse(raw) as Record<string, string[]>;
			const first = Object.values(parsed)[0];
			if (Array.isArray(first) && first[0]) {
				return first[0]!;
			}
		} catch {
			return raw;
		}
		return raw;
	}
	return 'Something went wrong';
}

async function load_addresses() {
	error_message.value = null;
	pending.value = true;
	try {
		addresses.value = await api.get<CustomerAddress[]>('/customer/addresses');
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
		addresses.value = [];
	} finally {
		pending.value = false;
	}
}

async function submit_new_address() {
	form_error.value = null;
	form_success.value = null;
	submitting.value = true;
	try {
		const created = await api.post<CustomerAddress>('/customer/addresses', {
			address_type: form.address_type,
			building_number: form.building_number.trim(),
			street_name: form.street_name.trim(),
			city: form.city.trim(),
			region: form.region.trim(),
			post_code: form.post_code.trim(),
			country: form.country.trim(),
		});
		addresses.value = [...addresses.value, created];
		reset_form();
		form_success.value = 'Address saved.';
		setTimeout(() => {
			form_success.value = null;
		}, 4000);
	} catch (e: unknown) {
		form_error.value = parse_api_error(e);
	} finally {
		submitting.value = false;
	}
}

onMounted(() => {
	load_addresses();
});
</script>
