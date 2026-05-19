/// <reference types="node" />

import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
	compatibilityDate: '2025-07-15',
	devtools: { enabled: true },
	css: ['./app/assets/css/main.css'],
	modules: ['@nuxt/ui'],
	runtimeConfig: {
		public: {
			// Should include /api/v1 (e.g. https://api.example.com/api/v1).
			// Set NUXT_PUBLIC_API_BASE_URL in .env or the build environment (Amplify, CI).
			apiBaseUrl: process.env.NUXT_PUBLIC_API_BASE_URL ?? '',
			// Stripe publishable key only (pk_test_… / pk_live_…).
			stripePublishableKey: process.env.NUXT_PUBLIC_STRIPE_PUBLISHABLE_KEY ?? '',
		},
	},
	vite: {
		plugins: [tailwindcss()],

		optimizeDeps: {
			include: ['@vue/devtools-core', '@vue/devtools-kit'],
		},
	},
})
