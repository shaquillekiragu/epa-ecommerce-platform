<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 p-6 pb-16 pt-24 md:p-10">
		<div class="mx-auto max-w-4xl">
			<BreadcrumbsComponent
				class="mb-4"
				:items="[
					{ label: 'Overview', to: '/merchant' },
					{ label: 'My stores', to: '/merchant/stores' },
					{ label: 'Create store' },
				]"
			/>

			<header class="mb-8">
				<h1 class="text-3xl font-bold tracking-tight text-slate-900">Create store</h1>
				<p class="mt-2 text-base text-slate-600">Add a name and optional description. You can change these later.</p>
				<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
			</header>

			<form class="space-y-6" @submit.prevent="on_submit">
				<div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
					<div class="space-y-5">
						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-900" for="store-name">Store name</label>
							<input
								id="store-name"
								v-model="store_name"
								:disabled="submitting"
								class="w-full rounded-md border border-slate-300 bg-white p-2 text-base text-slate-900 focus:border-slate-900 focus:ring-0 disabled:opacity-60"
								placeholder="e.g. Blue Ribbon Boutique"
								type="text"
							/>
						</div>
						<div>
							<label class="mb-2 block text-sm font-semibold text-slate-900" for="store-description">Public description</label>
							<textarea
								id="store-description"
								v-model="description"
								:disabled="submitting"
								rows="5"
								class="w-full rounded-md border border-slate-300 bg-white p-2 text-base text-slate-900 focus:border-slate-900 focus:ring-0 disabled:opacity-60"
								placeholder="Optional — what you sell or what makes your store unique"
							></textarea>
							<p class="mt-2 text-xs text-slate-600">Shown on your store page when you add one.</p>
						</div>
					</div>
				</div>

				<div class="flex flex-wrap items-center justify-end gap-3">
					<NuxtLink
						to="/merchant/stores"
						class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-900 hover:bg-slate-50"
					>
						Cancel
					</NuxtLink>
					<button
						type="submit"
						:disabled="submitting || store_name.trim() === ''"
						class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-slate-800 disabled:pointer-events-none disabled:opacity-50"
					>
						{{ submitting ? 'Creating…' : 'Create store' }}
					</button>
				</div>
			</form>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { MerchantStore } from '~/types/merchant';

definePageMeta({
	middleware: ['role-merchant'],
});

const api = useApi();

const store_name = ref('');
const description = ref('');
const submitting = ref(false);
const error_message = ref<string | null>(null);

async function on_submit() {
	if (submitting.value) return;
	error_message.value = null;

	const name = store_name.value.trim();
	if (name === '') {
		error_message.value = 'Store name is required.';
		return;
	}

	submitting.value = true;
	try {
		const created = await api.post<MerchantStore>('/merchant/stores', {
			name,
			description: description.value.trim(),
		});

		if (!created?.id) {
			throw new Error('Store created but missing id.');
		}

		await navigateTo(`/merchant/stores/${created.id}`);
	} catch (e: unknown) {
		error_message.value =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to create store';
	} finally {
		submitting.value = false;
	}
}
</script>
