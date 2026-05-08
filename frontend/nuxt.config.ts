import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
	compatibilityDate: '2025-07-15',
	devtools: { enabled: true },

	css: ['./app/assets/css/main.css'],

	modules: ['@nuxt/ui'],

	runtimeConfig: {
		public: {
			// Should include /api/v1
			// Example: https://api.example.com/api/v1
			apiBaseUrl: process.env.NUXT_PUBLIC_API_BASE_URL || '',
		},
	},

	vite: {
		plugins: [tailwindcss()],

		optimizeDeps: {
			include: ['@vue/devtools-core', '@vue/devtools-kit'],
		},
	},

	nitro: {
		preset: 'aws-amplify',
	},
})
