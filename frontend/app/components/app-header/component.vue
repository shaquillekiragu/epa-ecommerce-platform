<template>
	<header
		class="bg-white dark:bg-slate-900 docked full-width top-0 z-50 border-b border-slate-200 dark:border-slate-800 shadow-sm sticky">
		<div class="flex items-center justify-between w-full px-16 h-20 overflow-x-hidden">
			<NuxtLink
				class="text-2xl font-extrabold tracking-tighter text-slate-900 dark:text-white"
				:to="brand_link_url"
			>
				MerchFlow
			</NuxtLink>

			<nav class="hidden md:flex items-center gap-14 font-medium">
				<NuxtLink
					v-for="link in nav_links"
					:key="link.text"
					class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition active:scale-95 hover:cursor-pointer!"
					active-class="text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-slate-100 pb-1"
					exact-active-class="text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-slate-100 pb-1"
					:to="link.url"
				>
					{{ link.text }}
				</NuxtLink>
			</nav>

			<div class="flex items-center gap-6 text-slate-900 dark:text-slate-50 **:hover:cursor-pointer!">
				<NuxtLink
					v-if="show_basket_link"
					class="hover:text-slate-900 dark:hover:text-white transition active:scale-95 relative"
					:to="basket_link_url">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">shopping_cart</span>
					<span
						v-if="show_basket_count_badge"
						class="absolute -top-1 -right-1 min-w-4 h-4 min-h-4 px-0.5 bg-slate-900 text-white text-[10px] font-bold rounded-full flex items-center justify-center leading-none"
					>
						{{ basket_badge_label }}
					</span>
				</NuxtLink>
				
				<NuxtLink
					:to="notifications_link_url"
					class="hover:text-slate-900 dark:hover:text-white hover:cursor-pointer transition active:scale-95"
				>
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">notifications</span>
				</NuxtLink>

				<NuxtLink
					class="hover:text-slate-900 dark:hover:text-white transition active:scale-95"
					:to="account_link_url">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">account_circle</span>
				</NuxtLink>

				<button
					v-if="is_logged_in"
					class="hidden md:inline-flex items-center gap-2 rounded-lg border border-slate-200 dark:border-slate-700 ml-8 px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-800 transition active:scale-95"
					type="button"
					@click="on_logout"
				>
					<span class="material-symbols-outlined text-[18px]" style="font-variation-settings: 'FILL' 0">logout</span>
					Logout
				</button>
			</div>
		</div>
	</header>
</template>

<script setup lang="ts">
import type { NavLink } from '~/types/miscellaneous';

const { is_logged_in, role, logout } = useAuth();
const { basket_item_count, refresh_basket_item_count } = useBasketItemCount();

const show_basket_count_badge = computed(
	() => is_logged_in.value && role.value === 'customer' && basket_item_count.value > 0,
);

const basket_badge_label = computed(() => {
	const n = basket_item_count.value;
	if (n > 99) return '99+';
	return String(n);
});

const nav_links = computed<NavLink[]>(() => {
	const customer_links: NavLink[] = [
		{ text: 'Home', url: '/', is_primary: false },
		{ text: 'Shop', url: '/products', is_primary: false },
		{ text: 'Categories', url: '/categories', is_primary: false },
	];

	const merchant_links: NavLink[] = [
		{ text: 'Dashboard', url: '/merchant', is_primary: false },
		{ text: 'Stores', url: '/merchant/stores', is_primary: false },
	];

	if (role.value === 'merchant') {
		return merchant_links
	}
	return customer_links
});

const account_link_url = computed(() => {
	if (!is_logged_in.value) return '/auth';
	return role.value === 'merchant' ? '/merchant/account' : '/account';
});

const brand_link_url = computed(() => (role.value === 'merchant' ? '/merchant' : '/'));
const show_basket_link = computed(() => role.value !== 'merchant');
const basket_link_url = computed(() => (!is_logged_in.value ? '/auth' : '/basket'));
const notifications_link_url = computed(() => (!is_logged_in.value ? '/auth' : '/account'));

async function on_logout() {
	await logout();
	await navigateTo('/auth');
}

watch(
	() => [is_logged_in.value, role.value] as const,
	() => {
		refresh_basket_item_count();
	},
	{ immediate: true },
);

</script>
