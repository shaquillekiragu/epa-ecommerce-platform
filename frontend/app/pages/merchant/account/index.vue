<template>
	<main class="min-h-screen w-full flex-1 bg-slate-50 py-16">
		<section class="mx-auto max-w-5xl p-6 md:p-12">
			<div v-if="pending" class="rounded-xl border border-slate-200 bg-white p-8 text-slate-600">Loading…</div>

			<template v-else>
				<BreadcrumbsComponent
					class="mb-6"
					:items="[
						{ label: 'Overview', to: '/merchant' },
						{ label: 'Account' },
					]"
				/>
				<header class="mb-10">
					<h2 class="text-3xl font-bold tracking-tight text-slate-900">
						Welcome back<span v-if="display_first_name">, {{ display_first_name }}</span>
					</h2>
					<p class="mt-2 text-base text-slate-600">Merchant profile and shortcuts (mirrors the customer account hub).</p>
					<p v-if="error_message" class="mt-2 text-sm text-red-600">{{ error_message }}</p>
				</header>

				<div class="mb-10 grid gap-6 md:grid-cols-3">
					<div class="md:col-span-2 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
						<span class="mb-4 block text-sm font-semibold uppercase tracking-wider text-slate-600">Profile</span>
						<div class="mb-6 flex items-center gap-4">
							<div
								class="flex size-16 items-center justify-center overflow-hidden rounded-full bg-slate-100 text-xl font-bold text-slate-500"
							>
								{{ initials }}
							</div>
							<div>
								<h3 class="text-xl font-semibold text-slate-900">{{ full_name }}</h3>
								<p class="text-slate-600">{{ email_display }}</p>
							</div>
						</div>
						<div class="flex flex-wrap gap-3">
							<NuxtLink
								to="/merchant/stores"
								class="inline-flex items-center justify-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800"
							>
								My stores
							</NuxtLink>
							<NuxtLink
								to="/merchant"
								class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-slate-50"
							>
								Overview
							</NuxtLink>
						</div>
					</div>
					<div class="rounded-xl border border-slate-800 bg-slate-800 p-6 text-slate-50 shadow-sm">
						<span class="mb-2 block text-sm font-semibold uppercase tracking-wider text-slate-300">Tip</span>
						<h3 class="text-lg font-semibold text-white">Orders &amp; fulfilment</h3>
						<p class="mt-2 text-sm text-slate-300">Pick a store, open Orders, then an order — same list → detail flow customers use under “Order History”.</p>
					</div>
				</div>

				<section class="grid gap-6 sm:grid-cols-2">
					<NuxtLink
						to="/merchant/stores"
						class="block rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md"
					>
						<div class="mb-3 flex items-center gap-3">
							<span class="material-symbols-outlined text-slate-900">storefront</span>
							<h3 class="text-lg font-semibold text-slate-900">Stores</h3>
						</div>
						<p class="text-sm text-slate-600">Create and manage stores, then handle orders for each.</p>
					</NuxtLink>
					<button
						type="button"
						class="block w-full rounded-xl border border-slate-200 bg-white p-6 text-left shadow-sm transition-shadow hover:shadow-md"
						@click="on_sign_out"
					>
						<div class="mb-3 flex items-center gap-3">
							<span class="material-symbols-outlined text-slate-900">logout</span>
							<h3 class="text-lg font-semibold text-slate-900">Sign out</h3>
						</div>
						<p class="text-sm text-slate-600">End your session on this device.</p>
					</button>
				</section>
			</template>
		</section>
	</main>
</template>

<script setup lang="ts">
definePageMeta({
	middleware: ['role-merchant'],
});

const { user, logout, refresh_me } = useAuth();

const pending = ref(true);
const error_message = ref<string | null>(null);

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

async function on_sign_out() {
	await logout();
	await navigateTo('/');
}

onMounted(async () => {
	error_message.value = null;
	pending.value = true;
	try {
		await refresh_me();
	} catch (e: unknown) {
		error_message.value =
			e && typeof e === 'object' && 'message' in e ? String((e as { message?: string }).message) : 'Failed to load account';
	} finally {
		pending.value = false;
	}
});
</script>
