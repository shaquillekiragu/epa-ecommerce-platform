<template>
	<header
		class="bg-white dark:bg-slate-900 docked full-width top-0 z-50 border-b border-slate-200 dark:border-slate-800 shadow-sm sticky">
		<div class="flex items-center justify-between w-full px-6 h-16 max-w-[1280px] mx-auto">
			<!-- Brand -->
			<NuxtLink class="text-xl font-extrabold tracking-tighter text-slate-900 dark:text-white" to="/">
				LuxCommerce
			</NuxtLink>

			<!-- Search (Left aligned relative to nav as per 'on_left') -->
			<div class="hidden md:flex flex-1 mx-8 max-w-md relative items-center">
				<span class="material-symbols-outlined absolute left-3 text-outline"
					style="font-variation-settings: 'FILL' 0">search</span>
				<input
					class="w-full bg-surface-container-lowest border border-outline-variant rounded-full py-2 pl-10 pr-4 text-on-surface font-body-md text-body-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
					placeholder="Search for luxury goods..." type="text" />
			</div>

			<!-- Navigation Links -->
			<nav class="hidden md:flex items-center gap-6 font-['Manrope'] text-sm font-medium">
				<NuxtLink
					class="text-slate-900 dark:text-white border-b-2 border-slate-900 dark:border-slate-100 pb-1 hover:text-slate-900 dark:hover:text-white transition active:scale-95"
					to="#">Shop</NuxtLink>
				<NuxtLink
					class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition active:scale-95"
					to="#">Categories</NuxtLink>
				<NuxtLink
					class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition active:scale-95"
					to="#">Deals</NuxtLink>
				<NuxtLink
					class="text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition active:scale-95"
					to="#">Merchant Portal</NuxtLink>
			</nav>

			<!-- Trailing Icons -->
			<div class="flex items-center gap-4 text-slate-900 dark:text-slate-50">
				<button
					class="hover:text-slate-900 dark:hover:text-white transition active:scale-95 relative">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">shopping_cart</span>
					<span
						class="absolute -top-1 -right-1 bg-primary text-on-primary text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center">3</span>
				</button>
				<button
					class="hover:text-slate-900 dark:hover:text-white transition active:scale-95">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">notifications</span>
				</button>
				<button
					class="hover:text-slate-900 dark:hover:text-white transition active:scale-95">
					<span class="material-symbols-outlined"
						style="font-variation-settings: 'FILL' 0">account_circle</span>
				</button>
			</div>
		</div>
	</header>
</template>
