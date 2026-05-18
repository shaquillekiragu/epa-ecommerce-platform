import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vitest/config';

export default defineConfig({
	test: {
		environment: 'node',
		include: ['app/**/*.test.ts'],
		env: {
			TZ: 'UTC',
		},
	},
	resolve: {
		alias: {
			'~': fileURLToPath(new URL('./app', import.meta.url)),
		},
	},
});
