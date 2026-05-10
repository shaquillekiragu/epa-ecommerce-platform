<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 flex-1 min-h-screen flex flex-col bg-slate-50">
		<header class="h-16 px-4 flex items-center justify-between border-b border-slate-400 bg-white sticky top-0 z-30">
			<h1 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Account</h1>
		</header>

		<section class="w-full p-6 md:p-12 max-w-4xl">
			<div class="bg-white border border-slate-200 rounded-lg p-6 shadow-sm">
				<p class="text-slate-700">
					Merchant account details page.
				</p>
			</div>
		</section>
	</main>
</template>

<script setup lang="ts">
definePageMeta({
	middleware: ['role-merchant'],
});

</script>
