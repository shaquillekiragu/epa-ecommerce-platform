<template>
	<main class="min-h-screen flex items-center justify-center px-6 py-16">
		<section class="w-full max-w-md bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
			<h1 class="text-2xl font-bold text-slate-900 mb-2">Sign in</h1>
			<p class="text-sm text-slate-600 mb-6">Use your email and password.</p>

			<form class="space-y-4" @submit.prevent="on_submit">
				<div class="space-y-1">
					<label class="text-sm font-medium text-slate-700">Email</label>
					<input v-model="email" type="email"
						class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900"
						placeholder="you@example.com" />
				</div>

				<div class="space-y-1">
					<label class="text-sm font-medium text-slate-700">Password</label>
					<input v-model="password" type="password"
						class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900"
						placeholder="••••••••" />
				</div>

				<p v-if="error" class="text-sm text-red-600">{{ error }}</p>

				<button type="submit"
					class="w-full bg-slate-900 text-white rounded-lg py-3 font-semibold hover:bg-slate-800 transition-colors"
					:disabled="loading">
					{{ loading ? 'Signing in...' : 'Sign in' }}
				</button>
			</form>

			<div class="mt-6 text-sm text-slate-600">
				No account?
				<NuxtLink to="/auth/register" class="text-slate-900 font-semibold hover:underline">Create one</NuxtLink>
			</div>
		</section>
	</main>
</template>

<script setup lang="ts">
import type { ApiError } from '~/composables/useApi';

const email = ref('');
const password = ref('');
const error = ref<string | null>(null);
const loading = ref(false);

const { login, role } = useAuth();

function to_friendly_error(e: unknown): string {
	const err = e as Partial<ApiError> | null;

	if (err?.status === 401) {
		return 'Incorrect email or password.';
	}

	if (err?.status === 403) {
		return 'This account cannot sign in here. Use the correct sign-in page for your account type.';
	}

	if (err?.status === 0) {
		return 'Could not reach the server. Please try again.';
	}

	return 'We could not sign you in. Please try again.';
}

async function on_submit() {
	error.value = null;
	loading.value = true;
	
	try {
		await login(email.value, password.value);
		if (role.value === 'merchant') {
			await navigateTo('/merchant/stores');
		} else {
			await navigateTo('/');
		}
	} catch (e: any) {
		error.value = to_friendly_error(e);
	} finally {
		loading.value = false;
	}
}
</script>
