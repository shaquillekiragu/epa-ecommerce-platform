<template>
	<main class="mx-auto min-h-screen w-full max-w-5xl flex-1 px-4 py-16 md:px-6">
		<BreadcrumbsComponent class="mb-6" :items="edit_store_crumbs" />

		<header class="mb-8">
			<h1 class="text-3xl font-bold tracking-tight text-slate-900">Store settings</h1>
			<p class="mt-2 text-base text-slate-600">Update your store name and public description.</p>
			<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
		</header>

		<section v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">
			Loading…
		</section>

		<form v-else class="space-y-6" @submit.prevent="on_save">
			<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
				<div class="space-y-5">
					<div>
						<label class="mb-2 block text-sm font-semibold text-slate-900" for="store-name">Store name</label>
						<input
							id="store-name"
							v-model="form.name"
							:disabled="saving"
							class="w-full rounded-md border border-slate-300 bg-white p-2 text-base text-slate-900 focus:border-slate-900 focus:ring-0 disabled:opacity-60"
							placeholder="Enter your store name"
							type="text"
						/>
					</div>

					<div>
						<label class="mb-2 block text-sm font-semibold text-slate-900" for="store-description">Public description</label>
						<textarea
							id="store-description"
							v-model="form.description"
							:disabled="saving"
							class="w-full rounded-md border border-slate-300 bg-white p-2 text-base text-slate-900 focus:border-slate-900 focus:ring-0 disabled:opacity-60"
							placeholder="Describe what makes your store unique…"
							rows="5"
						></textarea>
						<p class="mt-2 text-xs text-slate-600">Visible to customers on your store page.</p>
					</div>
				</div>
			</div>

			<div class="flex flex-wrap items-center justify-end gap-3">
				<NuxtLink
					:to="store_id ? `/merchant/stores/${store_id}` : '/merchant/stores'"
					class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50"
				>
					Cancel
				</NuxtLink>
				<button
					type="submit"
					:disabled="saving || form.name.trim() === ''"
					class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 disabled:pointer-events-none disabled:opacity-50"
				>
					{{ saving ? 'Saving…' : 'Save changes' }}
				</button>
			</div>
		</form>
	</main>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';
import type { MerchantStore } from '~/types/merchant';
import { merchantFetchStore, merchantUpdateStore } from '~/composables/useMerchant';

definePageMeta({
	middleware: ['role-merchant'],
});

const route = useRoute();

const store_id = computed(() => {
	const raw = route.params.storeId;
	const s = Array.isArray(raw) ? raw[0] : raw;
	const n = typeof s === 'string' ? Number.parseInt(s, 10) : Number.NaN;
	return Number.isFinite(n) && n > 0 ? n : null;
});

const pending = ref(true);
const saving = ref(false);
const error_message = ref<string | null>(null);

const store = ref<MerchantStore | null>(null);
const form = reactive<{ name: string; description: string }>({ name: '', description: '' });

const edit_store_crumbs = computed<BreadcrumbItem[]>(() => {
	const id = store_id.value;
	if (id == null) return [];
	const hub = store.value?.name?.trim() ? store.value.name : 'Store';
	return [
		{ label: 'Overview', to: '/merchant' },
		{ label: 'My stores', to: '/merchant/stores' },
		{ label: hub, to: `/merchant/stores/${id}` },
		{ label: 'Edit store' },
	];
});

function parse_api_error(e: unknown): string {
	if (e && typeof e === 'object' && 'message' in e) {
		return String((e as { message?: string }).message);
	}
	return 'Request failed';
}

async function load() {
	if (store_id.value == null) {
		pending.value = false;
		error_message.value = 'Invalid store link.';
		return;
	}
	pending.value = true;
	error_message.value = null;
	try {
		store.value = await merchantFetchStore(store_id.value);
		form.name = store.value.name ?? '';
		form.description = (store.value.description ?? '') as string;
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
		store.value = null;
	} finally {
		pending.value = false;
	}
}

async function on_save() {
	if (store_id.value == null || saving.value) return;
	error_message.value = null;

	const name = form.name.trim();
	if (name === '') {
		error_message.value = 'Store name is required.';
		return;
	}

	saving.value = true;
	try {
		const updated = await merchantUpdateStore(store_id.value, {
			name,
			description: form.description.trim(),
		});
		store.value = updated;
		await navigateTo(`/merchant/stores/${store_id.value}`);
	} catch (e: unknown) {
		error_message.value = parse_api_error(e);
	} finally {
		saving.value = false;
	}
}

watch(
	() => route.params.storeId,
	() => {
		load();
	},
);

onMounted(() => {
	load();
});
</script>
