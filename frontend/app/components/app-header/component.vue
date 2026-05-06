<template>
	<header
		class="bg-white dark:bg-slate-900 docked full-width top-0 z-50 border-b border-slate-200 dark:border-slate-800 shadow-sm sticky">
		<div class="flex items-center justify-between w-full px-16 h-20 overflow-x-hidden">
			<NuxtLink class="text-2xl font-extrabold tracking-tighter text-slate-900 dark:text-white" to="/">
				MerchFlow
			</NuxtLink>

			<nav class="hidden md:flex items-center gap-12 text-sm font-medium">
				<NuxtLink
					v-for="link in nav_links"
					:key="link.text"
					class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition active:scale-95"
					active-class="text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-slate-100 pb-1"
					exact-active-class="text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-slate-100 pb-1"
					:to="link.url"
				>
					{{ link.text }}
				</NuxtLink>
			</nav>

			<div class="flex items-center gap-6 text-slate-900 dark:text-slate-50">
				<NuxtLink
					class="hover:text-slate-900 dark:hover:text-white transition active:scale-95 relative"
					to="/basket">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">shopping_cart</span>
					<span
						class="absolute -top-1 -right-1 bg-slate-900 text-white text-[10px] font-bold size-4 rounded-full flex items-center justify-center">3</span>
				</NuxtLink>
				
				<button
					class="hover:text-slate-900 dark:hover:text-white hover:cursor-pointer transition active:scale-95">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">notifications</span>
				</button>

				<NuxtLink
					class="hover:text-slate-900 dark:hover:text-white transition active:scale-95"
					to="/account">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">account_circle</span>
				</NuxtLink>
			</div>
		</div>
	</header>
</template>

<script setup lang="ts">
import type { NavLink } from '~/types/miscellaneous';

const nav_links: NavLink[] = [
	{ text: 'Home', url: '/', is_primary: false },
	{ text: 'Shop', url: '/products', is_primary: false },
	{ text: 'Categories', url: '/categories', is_primary: false },
	{ text: 'Merchant Portal', url: '/merchant', is_primary: false },
]

</script>
