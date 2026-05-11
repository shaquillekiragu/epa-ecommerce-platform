<template>
	<main class="min-h-screen w-full flex-1 p-4 pb-16 pt-24 lg:p-6">
		<div class="max-w-4xl mx-auto">
			<!-- Breadcrumbs -->
			<nav class="flex items-center gap-2 mb-2 text-slate-500">
				<span class="font-medium text-xs">Dashboard</span>
				<span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
				<span class="font-medium text-xs">My Stores</span>
				<span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
				<span class="font-medium text-xs text-slate-900">Create New Store</span>
			</nav>
			<div class="mb-6">
				<h2 class="font-bold tracking-tight text-3xl leading-tight text-slate-900 mb-2">Build Your Presence</h2>
				<p class="font-normal text-base text-slate-600 max-w-2xl">
					Launch your digital storefront in seconds. Provide the essential details below to begin your
					merchant journey on MerchFlow.
				</p>
			</div>
			<!-- Asymmetric Bento-style Form Layout -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-start">
				<!-- Left: Primary Form Column -->
				<div class="md:col-span-7 space-y-md">
					<section
						class="bg-white border border-slate-400 p-4 rounded-xl shadow-sm">
						<form action="#" class="space-y-md">
							<div class="space-y-2">
								<label class="font-semibold text-sm text-slate-900 block" for="store-name">Store
									Name</label>
								<input
									class="w-full bg-white border border-slate-400 rounded p-2 focus:border-2 focus:border-slate-900 focus:ring-0 transition-all font-normal text-base"
									id="store-name" name="store_name" placeholder="e.g. Blue Ribbon Boutique"
									type="text" />
								<div
									class="flex items-start gap-2 p-3 bg-slate-50 rounded border-l-4 border-slate-700 mt-2">
									<span class="material-symbols-outlined text-slate-700 text-sm mt-0.5"
										data-icon="info">info</span>
									<p
										class="font-medium text-xs text-slate-700 leading-relaxed">
										The store name is used to generate your permanent URL slug (e.g.,
										merchflow.com/stores/your-store-name). Choose a name that is concise and
										professional.
									</p>
								</div>
							</div>
							<div class="space-y-2">
								<label class="font-semibold text-sm text-slate-900 block" for="description">Store
									Description</label>
								<textarea
									class="w-full bg-white border border-slate-400 rounded p-2 focus:border-2 focus:border-slate-900 focus:ring-0 transition-all font-normal text-base"
									id="description" name="description"
									placeholder="Tell customers what makes your store unique..." rows="5"></textarea>
							</div>
							<div class="pt-2">
								<button
									class="w-full md:w-auto px-6 py-2 bg-slate-900 text-white font-semibold text-sm rounded-lg hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
									type="submit">
									Create Store
									<span class="material-symbols-outlined"
										data-icon="arrow_forward">arrow_forward</span>
								</button>
							</div>
						</form>
					</section>
				</div>
				<!-- Right: Visual Context & Support -->
				<div class="md:col-span-5 space-y-md">
					<!-- Preview Card -->
					<div class="bg-slate-900 text-white p-4 rounded-xl shadow-lg relative overflow-hidden">
						<div class="relative z-10">
							<span class="material-symbols-outlined text-4xl mb-4"
								data-icon="auto_awesome">auto_awesome</span>
							<h3 class="font-semibold tracking-tight text-xl leading-snug mb-2">Merchant Preview</h3>
							<p class="font-medium text-xs opacity-80 mb-6">Your store will be optimized for
								search engines and high-conversion shopping experiences instantly.</p>
							<div class="p-2 bg-white/10 rounded border border-white/20 backdrop-blur-sm">
								<div class="flex items-center gap-3 mb-2">
									<div class="size-10 bg-white/20 rounded-full animate-pulse"></div>
									<div class="space-y-1">
										<div class="h-3 w-24 bg-white/30 rounded"></div>
										<div class="h-2 w-16 bg-white/10 rounded"></div>
									</div>
								</div>
								<div class="h-24 w-full bg-white/5 rounded mt-3"></div>
							</div>
						</div>
						<!-- Abstract texture using Tailwind gradients -->
						<div
							class="absolute inset-0 bg-linear-to-br from-transparent via-white/5 to-white/10 pointer-events-none">
						</div>
					</div>
					<!-- Secondary Guidance -->
					<div class="bg-slate-100 border border-slate-400 p-4 rounded-xl">
						<h4 class="font-semibold text-sm text-slate-900 mb-4 flex items-center gap-2">
							<span class="material-symbols-outlined" data-icon="verified_user">verified_user</span>
							Why MerchFlow?
						</h4>
						<ul class="space-y-4">
							<li class="flex items-start gap-3">
								<span class="material-symbols-outlined text-slate-900 text-lg"
									data-icon="bolt">bolt</span>
								<p class="font-medium text-xs text-slate-600">Ultra-fast global edge delivery
									for your product images and listings.</p>
							</li>
							<li class="flex items-start gap-3">
								<span class="material-symbols-outlined text-slate-900 text-lg"
									data-icon="security">security</span>
								<p class="font-medium text-xs text-slate-600">Enterprise-grade security and
									fraud protection for every transaction.</p>
							</li>
							<li class="flex items-start gap-3">
								<span class="material-symbols-outlined text-slate-900 text-lg"
									data-icon="insights">insights</span>
								<p class="font-medium text-xs text-slate-600">Deep analytics integration to
									track your store's growth performance.</p>
							</li>
						</ul>
					</div>
					<!-- Brand Visual -->
					<div
						class="h-48 rounded-xl overflow-hidden border border-slate-400 grayscale hover:grayscale-0 transition-all duration-500">
						<img alt="Store Interior" class="size-full object-cover"
							data-alt="A minimalist and high-end boutique interior with clean lines, soft recessed lighting, and a palette of warm greys and ivory. The scene features marble surfaces and modern architectural details that convey a sense of premium quality and luxury commerce. The lighting is balanced and artistic, creating an aspirational merchant environment."
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuAapD6o2qZSRK-NbGnk5uT9cBMw6prkPlo3wtEd6dBj6EDIsfL1OWUoCZ46XrUiGE9cyUoqp48GP8Mi05APwvMW3wBHrAX6r0ACbOE3vxvGbG7qQE6OseMDqGjeZITGRhm5dUtc03YI4rmtghSUXnDeh2x_eZ_6V8_dU98Tm3wlmYPmd-A7-F2HFjGHHm8RPHPirdjMxKEzCJYakpDjdi_5Rl66npqva6c93VZdr888LPk7D-2u0H51k1sM53m40udymHej2_brn5QZ" />
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
