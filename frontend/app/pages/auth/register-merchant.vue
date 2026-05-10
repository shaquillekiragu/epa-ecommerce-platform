<template>
	<main class="min-h-screen flex items-center justify-center px-6 py-16">
		<section class="w-full max-w-md bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
			<h1 class="text-2xl font-bold text-slate-900 mb-2">Create merchant account</h1>
			<p class="text-sm text-slate-600 mb-6">
				Register to manage your store on the platform. (Demo: no approval workflow — production would add verification.)
			</p>

			<form class="space-y-4" @submit.prevent="on_submit">
				<div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
					<div class="space-y-1">
						<label class="text-sm font-medium text-slate-700">First name</label>
						<input v-model="first_name" type="text"
							class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900" />
					</div>
					<div class="space-y-1">
						<label class="text-sm font-medium text-slate-700">Last name</label>
						<input v-model="last_name" type="text"
							class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900" />
					</div>
				</div>

				<div class="space-y-1">
					<label class="text-sm font-medium text-slate-700">Email</label>
					<input v-model="email" type="email"
						class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900"
						placeholder="you@example.com" />
				</div>

				<FormsPasswordFieldComponent
					v-model="password"
					autocomplete="new-password"
					placeholder="At least 8 chars, letters + numbers"
					:disabled="loading"
				/>

				<div class="space-y-1">
					<label class="text-sm font-medium text-slate-700">Date of birth</label>
					<input v-model="date_of_birth" type="date"
						class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900" />
				</div>

				<div class="space-y-1">
					<label class="text-sm font-medium text-slate-700">Country</label>
					<input v-model="country" type="text"
						class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900" />
				</div>

				<div class="space-y-1">
					<label class="text-sm font-medium text-slate-700">Mobile number</label>
					<input v-model="mobile_number" type="tel"
						class="w-full border rounded-lg p-3 outline-none focus:ring-2 focus:ring-slate-900" />
				</div>

				<p v-if="error" class="text-sm text-red-600">{{ error }}</p>

				<button type="submit"
					class="w-full bg-slate-900 text-white rounded-lg py-3 font-semibold hover:bg-slate-800 transition-colors"
					:disabled="loading">
					{{ loading ? 'Creating...' : 'Create merchant account' }}
				</button>
			</form>

			<div class="mt-6 space-y-2 text-sm text-slate-600">
				<p>
					Shopping only?
					<NuxtLink to="/auth/register" class="text-slate-900 font-semibold hover:underline">Register as a customer</NuxtLink>
				</p>
				<p>
					Already have an account?
					<NuxtLink to="/auth/login" class="text-slate-900 font-semibold hover:underline">Sign in</NuxtLink>
				</p>
			</div>
		</section>
	</main>
</template>

<script setup lang="ts">
import type { ApiError } from '~/composables/useApi';

const first_name = ref('');
const last_name = ref('');
const email = ref('');
const password = ref('');
const date_of_birth = ref('');
const country = ref('');
const mobile_number = ref('');

const error = ref<string | null>(null);
const loading = ref(false);

const { register } = useAuth();

function to_friendly_error(e: unknown): string {
	const err = e as Partial<ApiError> | null;

	if (err?.status === 400) {
		return 'Please check your details and try again.';
	}

	if (err?.status === 401) {
		return 'Please sign in again and retry.';
	}

	if (err?.status === 0) {
		return 'Could not reach the server. Please try again.';
	}

	return 'We could not create your account. Please try again.';
}

async function on_submit() {
	error.value = null;
	loading.value = true;
	try {
		await register({
			account_type: 'merchant',
			first_name: first_name.value,
			last_name: last_name.value,
			email: email.value.trim().toLowerCase(),
			password: password.value,
			date_of_birth: date_of_birth.value,
			country: country.value,
			mobile_number: mobile_number.value,
			is_active: true,
			allow_update: true,
			allow_delete: true,
		});
		await navigateTo('/auth/login');
	} catch (e: any) {
		error.value = to_friendly_error(e);
	} finally {
		loading.value = false;
	}
}
</script>
