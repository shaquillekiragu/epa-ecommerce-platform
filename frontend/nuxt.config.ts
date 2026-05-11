import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
	compatibilityDate: '2025-07-15',
	devtools: { enabled: true },
	css: ['./app/assets/css/main.css'],
	modules: ['@nuxt/ui'],
	runtimeConfig: {
		public: {
			// Should include /api/v1 (e.g. https://api.example.com/api/v1).
			// Override with NUXT_PUBLIC_API_BASE_URL — Nuxt merges it automatically.
			apiBaseUrl: '',
			// Stripe publishable key only (pk_test_… / pk_live_…). Set NUXT_PUBLIC_STRIPE_PUBLISHABLE_KEY in .env
			stripePublishableKey: '',
		},
	},
	vite: {
		plugins: [tailwindcss()],

		optimizeDeps: {
			include: ['@vue/devtools-core', '@vue/devtools-kit'],
		},
	},
})
