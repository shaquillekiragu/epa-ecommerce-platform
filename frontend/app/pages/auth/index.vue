<template>
	<main class="w-screen flex items-center justify-center px-6 py-16 bg-slate-50">
		<section class="w-full flex flex-col gap-5 max-w-xl p-8 text-center bg-white border border-slate-200 rounded-2xl shadow-sm">
			<h1 class="text-3xl font-bold tracking-tight text-slate-900">Welcome</h1>

			<p class="my-4 text-slate-600">
				Discover curated finds, track orders in real time, and check out faster with saved details. Sign in to
				pick up where you left off, or create an account in seconds.
			</p>

			<p class="text-slate-600">
				Sign in to your account or create a new one to continue.
			</p>

			<div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
				<NuxtLink
					to="/auth/login"
					class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-5 py-3 font-semibold text-white hover:bg-slate-800 transition-colors"
				>
					Log in
				</NuxtLink>
				<NuxtLink
					to="/auth/register"
					class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-5 py-3 font-semibold text-slate-900 hover:bg-slate-50 transition-colors"
				>
					Create account
				</NuxtLink>
			</div>
		</section>
	</main>
</template>
