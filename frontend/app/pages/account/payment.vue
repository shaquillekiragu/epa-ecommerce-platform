<template>
	<main class="flex-1 md:ml-64 p-6 md:p-12">
		<div class="max-w-4xl mx-auto">
			<header class="mb-10">
				<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900 mb-2">Payment Methods</h1>
				<p class="font-normal text-base text-slate-600">Manage your saved credit cards and billing
					preferences securely.</p>
			</header>
			<!-- Status Banner (Glassmorphism inspired) -->
			<div
				class="mb-8 p-6 bg-slate-100 rounded-xl border border-slate-400 flex items-start gap-4">
				<span class="material-symbols-outlined text-slate-700 mt-1">shield</span>
				<div>
					<h3 class="font-semibold text-sm text-slate-700 mb-1 uppercase tracking-wider">
						Security First</h3>
					<p class="font-normal text-base text-slate-700 opacity-80">Your payment data is
						encrypted and stored according to PCI-DSS standards. LuxCommerce never stores your full CVV or
						card number.</p>
				</div>
			</div>
			<!-- Payment Methods Grid -->
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
				<!-- Card 1: Visa -->
				<div
					class="bg-white border border-slate-400 rounded-xl overflow-hidden group hover:shadow-md transition-all">
					<div class="p-6">
						<div class="flex justify-between items-start mb-8">
							<div class="bg-slate-100 p-2 rounded">
								<span class="font-bold text-slate-800 tracking-tighter">VISA</span>
							</div>
							<span
								class="bg-slate-200 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest text-slate-600">Primary</span>
						</div>
						<div class="mb-6">
							<p class="text-xs font-semibold text-slate-600 mb-1">Card Number</p>
							<p class="font-semibold text-xl leading-snug tracking-widest text-slate-900">•••• •••• ••••
								4242</p>
						</div>
						<div class="flex justify-between items-end">
							<div>
								<p class="text-[10px] font-semibold text-slate-600 mb-1 uppercase">Expiry</p>
								<p class="font-semibold text-sm text-slate-900">12 / 26</p>
							</div>
							<div class="flex gap-2">
								<button class="p-2 text-slate-600 hover:text-slate-900 transition-colors"><span
										class="material-symbols-outlined">edit</span></button>
								<button class="p-2 text-slate-600 hover:text-red-600 transition-colors"><span
										class="material-symbols-outlined">delete</span></button>
							</div>
						</div>
					</div>
					<div class="h-1 w-full bg-slate-900"></div>
				</div>
				<!-- Card 2: Mastercard -->
				<div
					class="bg-white border border-slate-400 rounded-xl overflow-hidden group hover:shadow-md transition-all">
					<div class="p-6">
						<div class="flex justify-between items-start mb-8">
							<div class="bg-slate-100 p-2 rounded">
								<span class="font-bold text-slate-800 tracking-tighter">Mastercard</span>
							</div>
						</div>
						<div class="mb-6">
							<p class="text-xs font-semibold text-slate-600 mb-1">Card Number</p>
							<p class="font-semibold text-xl leading-snug tracking-widest text-slate-900">•••• •••• ••••
								8801</p>
						</div>
						<div class="flex justify-between items-end">
							<div>
								<p class="text-[10px] font-semibold text-slate-600 mb-1 uppercase">Expiry</p>
								<p class="font-semibold text-sm text-slate-900">05 / 25</p>
							</div>
							<div class="flex gap-2">
								<button class="p-2 text-slate-600 hover:text-slate-900 transition-colors"><span
										class="material-symbols-outlined">edit</span></button>
								<button class="p-2 text-slate-600 hover:text-red-600 transition-colors"><span
										class="material-symbols-outlined">delete</span></button>
							</div>
						</div>
					</div>
				</div>
				<!-- Add New Card CTA -->
				<button
					class="border-2 border-dashed border-slate-400 rounded-xl p-8 flex flex-col items-center justify-center gap-4 hover:bg-slate-100 transition-all group">
					<div
						class="size-12 rounded-full bg-slate-200 flex items-center justify-center group-hover:scale-110 transition-transform">
						<span class="material-symbols-outlined text-slate-900">add_card</span>
					</div>
					<span class="font-semibold text-sm text-slate-900 uppercase">Add New Payment Method</span>
				</button>
			</div>
			<!-- Bento Grid Style Information -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="md:col-span-2 bg-white border border-slate-400 p-6 rounded-xl">
					<h4 class="font-semibold text-sm text-slate-900 mb-4 uppercase tracking-widest">Recent Billing
						Activity</h4>
					<div class="space-y-4">
						<div class="flex justify-between items-center py-3 border-b border-slate-200">
							<div class="flex gap-3 items-center">
								<span class="material-symbols-outlined text-slate-600">shopping_bag</span>
								<div>
									<p class="font-semibold text-sm text-slate-900">Order #LX-99021</p>
									<p class="text-xs text-slate-600">Nov 12, 2024 • Visa ****4242</p>
								</div>
							</div>
							<p class="font-bold text-slate-900">$1,240.00</p>
						</div>
						<div class="flex justify-between items-center py-3 border-b border-slate-200">
							<div class="flex gap-3 items-center">
								<span class="material-symbols-outlined text-slate-600">refresh</span>
								<div>
									<p class="font-semibold text-sm text-slate-900">Merchant Portal Subscription</p>
									<p class="text-xs text-slate-600">Oct 28, 2024 • Mastercard ****8801</p>
								</div>
							</div>
							<p class="font-bold text-slate-900">$49.00</p>
						</div>
					</div>
				</div>
				<div
					class="relative overflow-hidden rounded-xl bg-slate-800 text-white p-6 flex flex-col justify-between">
					<div class="z-10">
						<h4 class="font-semibold text-sm text-slate-900 mb-2 uppercase tracking-widest">
							Business Credit</h4>
						<p class="font-bold tracking-tight text-4xl leading-tight">$2,500</p>
					</div>
					<div class="z-10 flex items-center justify-between">
						<span class="text-xs opacity-60">Available for next purchase</span>
						<span class="material-symbols-outlined text-slate-900">info</span>
					</div>
					<!-- Abstract Visual Pattern -->
					<div class="absolute top-0 right-0 size-32 bg-slate-600 opacity-20 blur-3xl -mr-16 -mt-16"></div>
					<div
						class="absolute bottom-0 left-0 size-24 bg-slate-200 opacity-10 blur-2xl -ml-8 -mb-8">
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
