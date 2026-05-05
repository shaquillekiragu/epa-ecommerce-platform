<template>
	<main class="flex-1 md:ml-64 p-6 md:p-12">
		<div class="max-w-4xl mx-auto">
			<header class="mb-10">
				<h1 class="font-headline-lg text-headline-lg text-primary mb-2">Payment Methods</h1>
				<p class="font-body-md text-body-md text-on-surface-variant">Manage your saved credit cards and billing
					preferences securely.</p>
			</header>
			<!-- Status Banner (Glassmorphism inspired) -->
			<div
				class="mb-8 p-6 bg-secondary-container rounded-xl border border-outline-variant flex items-start gap-4">
				<span class="material-symbols-outlined text-on-secondary-container mt-1">shield</span>
				<div>
					<h3 class="font-label-md text-label-md text-on-secondary-container mb-1 uppercase tracking-wider">
						Security First</h3>
					<p class="font-body-md text-body-md text-on-secondary-container opacity-80">Your payment data is
						encrypted and stored according to PCI-DSS standards. LuxCommerce never stores your full CVV or
						card number.</p>
				</div>
			</div>
			<!-- Payment Methods Grid -->
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
				<!-- Card 1: Visa -->
				<div
					class="bg-white border border-outline-variant rounded-xl overflow-hidden group hover:shadow-md transition-all">
					<div class="p-6">
						<div class="flex justify-between items-start mb-8">
							<div class="bg-slate-100 p-2 rounded">
								<span class="font-bold text-slate-800 tracking-tighter">VISA</span>
							</div>
							<span
								class="bg-surface-container-highest px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Primary</span>
						</div>
						<div class="mb-6">
							<p class="text-xs font-label-md text-on-surface-variant mb-1">Card Number</p>
							<p class="font-headline-md text-headline-md tracking-widest text-primary">•••• •••• ••••
								4242</p>
						</div>
						<div class="flex justify-between items-end">
							<div>
								<p class="text-[10px] font-label-md text-on-surface-variant mb-1 uppercase">Expiry</p>
								<p class="font-label-md text-label-md text-primary">12 / 26</p>
							</div>
							<div class="flex gap-2">
								<button class="p-2 text-on-surface-variant hover:text-primary transition-colors"><span
										class="material-symbols-outlined">edit</span></button>
								<button class="p-2 text-on-surface-variant hover:text-error transition-colors"><span
										class="material-symbols-outlined">delete</span></button>
							</div>
						</div>
					</div>
					<div class="h-1 w-full bg-primary"></div>
				</div>
				<!-- Card 2: Mastercard -->
				<div
					class="bg-white border border-outline-variant rounded-xl overflow-hidden group hover:shadow-md transition-all">
					<div class="p-6">
						<div class="flex justify-between items-start mb-8">
							<div class="bg-slate-100 p-2 rounded">
								<span class="font-bold text-slate-800 tracking-tighter">Mastercard</span>
							</div>
						</div>
						<div class="mb-6">
							<p class="text-xs font-label-md text-on-surface-variant mb-1">Card Number</p>
							<p class="font-headline-md text-headline-md tracking-widest text-primary">•••• •••• ••••
								8801</p>
						</div>
						<div class="flex justify-between items-end">
							<div>
								<p class="text-[10px] font-label-md text-on-surface-variant mb-1 uppercase">Expiry</p>
								<p class="font-label-md text-label-md text-primary">05 / 25</p>
							</div>
							<div class="flex gap-2">
								<button class="p-2 text-on-surface-variant hover:text-primary transition-colors"><span
										class="material-symbols-outlined">edit</span></button>
								<button class="p-2 text-on-surface-variant hover:text-error transition-colors"><span
										class="material-symbols-outlined">delete</span></button>
							</div>
						</div>
					</div>
				</div>
				<!-- Add New Card CTA -->
				<button
					class="border-2 border-dashed border-outline-variant rounded-xl p-8 flex flex-col items-center justify-center gap-4 hover:bg-surface-container transition-all group">
					<div
						class="w-12 h-12 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:scale-110 transition-transform">
						<span class="material-symbols-outlined text-primary">add_card</span>
					</div>
					<span class="font-label-md text-label-md text-primary uppercase">Add New Payment Method</span>
				</button>
			</div>
			<!-- Bento Grid Style Information -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="md:col-span-2 bg-white border border-outline-variant p-6 rounded-xl">
					<h4 class="font-label-md text-label-md text-primary mb-4 uppercase tracking-widest">Recent Billing
						Activity</h4>
					<div class="space-y-4">
						<div class="flex justify-between items-center py-3 border-b border-surface-container">
							<div class="flex gap-3 items-center">
								<span class="material-symbols-outlined text-on-surface-variant">shopping_bag</span>
								<div>
									<p class="font-label-md text-label-md text-primary">Order #LX-99021</p>
									<p class="text-xs text-on-surface-variant">Nov 12, 2024 • Visa ****4242</p>
								</div>
							</div>
							<p class="font-bold text-primary">$1,240.00</p>
						</div>
						<div class="flex justify-between items-center py-3 border-b border-surface-container">
							<div class="flex gap-3 items-center">
								<span class="material-symbols-outlined text-on-surface-variant">refresh</span>
								<div>
									<p class="font-label-md text-label-md text-primary">Merchant Portal Subscription</p>
									<p class="text-xs text-on-surface-variant">Oct 28, 2024 • Mastercard ****8801</p>
								</div>
							</div>
							<p class="font-bold text-primary">$49.00</p>
						</div>
					</div>
				</div>
				<div
					class="relative overflow-hidden rounded-xl bg-primary-container text-white p-6 flex flex-col justify-between">
					<div class="z-10">
						<h4 class="font-label-md text-label-md text-primary-fixed mb-2 uppercase tracking-widest">
							Business Credit</h4>
						<p class="font-display-lg text-display-lg">$2,500</p>
					</div>
					<div class="z-10 flex items-center justify-between">
						<span class="text-xs opacity-60">Available for next purchase</span>
						<span class="material-symbols-outlined text-primary-fixed">info</span>
					</div>
					<!-- Abstract Visual Pattern -->
					<div class="absolute top-0 right-0 w-32 h-32 bg-secondary opacity-20 blur-3xl -mr-16 -mt-16"></div>
					<div
						class="absolute bottom-0 left-0 w-24 h-24 bg-tertiary-fixed-dim opacity-10 blur-2xl -ml-8 -mb-8">
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
