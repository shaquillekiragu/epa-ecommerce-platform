<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 p-6 pb-16 pt-24 md:p-10">
		<div class="mx-auto max-w-4xl">
			<BreadcrumbsComponent
				class="mb-4"
				:items="[
					{ label: 'Overview', to: '/merchant' },
					{ label: 'My stores' },
				]"
			/>

			<header class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
				<div class="min-w-0">
					<h1 class="text-3xl font-bold tracking-tight text-slate-900">My stores</h1>
					<p class="mt-2 text-base text-slate-600">
						<span v-if="pending">Loading your stores…</span>
						<span v-else>{{ stores.length }} {{ stores.length === 1 ? 'store' : 'stores' }} on your account.</span>
					</p>
					<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
				</div>

				<NuxtLink
					to="/merchant/stores/new"
					class="inline-flex shrink-0 items-center justify-center self-start rounded-lg bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-slate-800 sm:self-auto"
				>
					Create store
				</NuxtLink>
			</header>

			<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-12 text-center text-slate-600">Loading…</div>

			<div
				v-else-if="stores.length === 0"
				class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center"
			>
				<p class="font-medium text-slate-800">You have no stores yet</p>
				<p class="mt-2 text-sm text-slate-600">Create a store to add products and receive customer orders.</p>
				<NuxtLink
					to="/merchant/stores/new"
					class="mt-6 inline-flex items-center justify-center rounded-lg bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800"
				>
					Add a store
				</NuxtLink>
			</div>

			<ul v-else class="flex flex-col gap-4">
				<li v-for="s in stores" :key="s.id">
					<NuxtLink
						:to="`/merchant/stores/${s.id}`"
						class="block rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition-colors hover:border-slate-900"
					>
						<h2 class="text-xl font-semibold text-slate-900">{{ s.name }}</h2>
						<p v-if="s.description" class="mt-2 line-clamp-2 text-sm text-slate-600">{{ s.description }}</p>
						<div class="mt-4 flex flex-wrap gap-3 text-sm font-semibold text-slate-900">
							<span class="rounded-md bg-slate-100 px-3 py-1">Store #{{ s.id }}</span>
							<span class="text-slate-500">Open dashboard →</span>
						</div>
					</NuxtLink>
				</li>
			</ul>
		</div>
	</main>
</template>

<script setup lang="ts">
import type { MerchantStore } from '~/types/merchant';
import { merchantFetchStores } from '~/composables/useMerchant';

definePageMeta({
	middleware: ['role-merchant'],
});

const pending = ref(true);
const error_message = ref<string | null>(null);
const stores = ref<MerchantStore[]>([]);

onMounted(async () => {
	pending.value = true;
	error_message.value = null;
	try {
		stores.value = await merchantFetchStores();
	} catch (e: unknown) {
		error_message.value =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load stores';
		stores.value = [];
	} finally {
		pending.value = false;
	}
});
</script>
