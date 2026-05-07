<template>
	<footer class="bg-white dark:bg-slate-900 full-width border-t border-slate-100 dark:border-slate-800">
		<div
			class="w-full py-12 px-6 flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto gap-6">
			<div class="flex flex-col items-center md:items-start gap-2">
				<span class="text-lg font-black text-slate-900 dark:text-white">LuxCommerce</span>
				<p class="text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
					© 2026 MerchFlow Inc. Engineered for efficiency.
				</p>
			</div>
			<nav
				class="flex flex-wrap justify-center gap-6 text-xs uppercase tracking-widest text-slate-400 dark:text-slate-500">
				<NuxtLink
				v-for="link_text in footer_link_texts"
				class="hover:text-slate-900 dark:hover:text-white underline underline-offset-4 opacity-100 transition-colors"
				to="#">
					{{ link_text }}
				</NuxtLink>
			</nav>
		</div>
	</footer>
</template>

<script setup lang="ts">
const footer_link_texts: string[] = [
	'Privacy Policy',
	'Terms of Service',
	'Shipping Info',
	'Returns',
	'Contact Us'
]
</script>
