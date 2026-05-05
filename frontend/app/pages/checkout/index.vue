<template>
	<main class="grow pt-24 pb-12 px-6 max-w-7xl mx-auto w-full">
		<!-- Page Title -->
		<div class="mb-8">
			<h1 class="font-bold text-3xl leading-tight text-slate-900 tracking-tight">Checkout: Shipping &amp; Billing
			</h1>
		</div>
		<!-- Progress Stepper -->
		<div class="mb-12 w-full max-w-3xl mx-auto">
			<div class="flex items-center justify-between relative">
				<!-- Line background -->
				<div class="absolute top-1/2 left-0 w-full h-0.5 bg-slate-100 -translate-y-1/2 z-0"></div>
				<!-- Line active -->
				<div class="absolute top-1/2 left-0 w-1/4 h-0.5 bg-slate-900 -translate-y-1/2 z-0"></div>
				<!-- Steps -->
				<div class="relative z-10 flex flex-col items-center">
					<div
						class="size-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm ring-4 ring-background">
						1</div>
					<span class="mt-2 font-medium text-xs text-slate-900">Shipping</span>
				</div>
				<div class="relative z-10 flex flex-col items-center">
					<div
						class="size-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm ring-4 ring-background">
						2</div>
					<span class="mt-2 font-medium text-xs text-slate-600">Payment</span>
				</div>
				<div class="relative z-10 flex flex-col items-center">
					<div
						class="size-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm ring-4 ring-background">
						3</div>
					<span class="mt-2 font-medium text-xs text-slate-600">Review</span>
				</div>
				<div class="relative z-10 flex flex-col items-center">
					<div
						class="size-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm ring-4 ring-background">
						4</div>
					<span class="mt-2 font-medium text-xs text-slate-600">Done</span>
				</div>
			</div>
		</div>
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
			<!-- Left Column: Shipping Form -->
			<div class="lg:col-span-8 space-y-8">
				<!-- Saved Addresses Section -->
				<section class="bg-white border border-slate-200 rounded-xl p-8 shadow-sm">
					<div class="flex items-center justify-between mb-6">
						<h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Shipping Address</h2>
						<button class="flex items-center text-slate-700 font-semibold hover:underline">
							<span class="material-symbols-outlined mr-1 text-xl">add_location</span>
							Use new address
						</button>
					</div>
					<!-- Bento Grid for Saved Addresses -->
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
						<label class="relative cursor-pointer group">
							<input checked class="peer sr-only" name="address" type="radio" value="1" />
							<div
								class="p-6 border-2 border-slate-100 rounded-xl bg-slate-50 transition-all peer-checked:border-slate-900 peer-checked:bg-white group-hover:bg-white h-full">
								<div class="flex justify-between items-start mb-2">
									<span class="font-semibold text-slate-900">Home (Primary)</span>
									<span class="material-symbols-outlined text-slate-900 invisible peer-checked:visible"
										style="font-variation-settings: 'FILL' 1;">check_circle</span>
								</div>
								<p class="text-base font-normal text-slate-600">1248 Luxury Lane, Penthouse
									A<br />Manhattan, NY 10001<br />United States</p>
								<p class="mt-4 text-xs font-medium text-slate-400">+1 (555) 012-3456</p>
							</div>
						</label>
						<label class="relative cursor-pointer group">
							<input class="peer sr-only" name="address" type="radio" value="2" />
							<div
								class="p-6 border-2 border-slate-100 rounded-xl bg-slate-50 transition-all peer-checked:border-slate-900 peer-checked:bg-white group-hover:bg-white h-full">
								<div class="flex justify-between items-start mb-2">
									<span class="font-semibold text-slate-900">Office</span>
									<span class="material-symbols-outlined text-slate-900 invisible peer-checked:visible"
										style="font-variation-settings: 'FILL' 1;">check_circle</span>
								</div>
								<p class="text-base font-normal text-slate-600">770 Innovation Blvd, Suite
									400<br />Austin, TX 78701<br />United States</p>
								<p class="mt-4 text-xs font-medium text-slate-400">+1 (555) 987-6543</p>
							</div>
						</label>
					</div>
					<!-- Address Form Fields -->
					<div class="space-y-6 pt-6 border-t border-slate-100">
						<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
							<div class="space-y-2">
								<label class="font-medium text-slate-700">First Name</label>
								<input
									class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-slate-900 transition-all font-normal outline-none"
									placeholder="e.g. Julian" type="text" />
							</div>
							<div class="space-y-2">
								<label class="font-medium text-slate-700">Last Name</label>
								<input
									class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-slate-900 transition-all font-normal outline-none"
									placeholder="e.g. Sterling" type="text" />
							</div>
						</div>
						<div class="space-y-2">
							<label class="font-medium text-slate-700">Street Address</label>
							<input
								class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-slate-900 transition-all font-normal outline-none"
								placeholder="House number and street name" type="text" />
						</div>
						<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
							<div class="space-y-2">
								<label class="font-medium text-slate-700">City</label>
								<input
									class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-slate-900 transition-all font-normal outline-none"
									type="text" />
							</div>
							<div class="space-y-2">
								<label class="font-medium text-slate-700">State / Province</label>
								<select
									class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-slate-900 transition-all font-normal outline-none">
									<option>Select State</option>
									<option>New York</option>
									<option>California</option>
									<option>Texas</option>
								</select>
							</div>
							<div class="space-y-2">
								<label class="font-medium text-slate-700">Postal Code</label>
								<input
									class="w-full bg-white border border-slate-200 rounded-lg p-3 focus:ring-2 focus:ring-primary focus:border-slate-900 transition-all font-normal outline-none"
									type="text" />
							</div>
						</div>
					</div>
					<!-- Billing Checkbox -->
					<div class="mt-8 pt-8 border-t border-slate-100">
						<label class="flex items-center space-x-3 cursor-pointer">
							<input checked class="size-5 rounded border-slate-300 text-slate-900 focus:ring-primary"
								type="checkbox" />
							<span class="font-normal text-slate-900">Use this as my billing address</span>
						</label>
					</div>
				</section>
				<div class="flex justify-end">
					<button
						class="bg-slate-900 text-white font-semibold px-12 py-4 rounded-xl hover:bg-slate-800 transition-all flex items-center space-x-2 active:scale-95">
						<span>Continue to Payment</span>
						<span class="material-symbols-outlined">arrow_forward</span>
					</button>
				</div>
			</div>
			<!-- Right Column: Summary Sidebar -->
			<aside class="lg:col-span-4">
				<div class="bg-white border border-slate-200 rounded-xl p-8 shadow-sm sticky top-28">
					<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-6">Order Summary</h3>
					<!-- Item List -->
					<div class="space-y-6 mb-8">
						<div class="flex space-x-4">
							<div class="w-20 h-24 bg-slate-100 rounded-lg overflow-hidden shrink-0">
								<img class="size-full object-cover"
									data-alt="A high-end, professionally photographed product shot of a premium crimson leather sneaker against a clean, minimalist white background. The lighting is soft and architectural, emphasizing the texture of the grain and the artisanal stitching. The mood is sophisticated and contemporary, aligning with a luxury e-commerce aesthetic using sharp focus and neutral surroundings."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuBgztCKRcYBpTn-6rUd5hmFiddFdqzCvEh-5neJLFGJcr9Cop3xtHK-VOxxpDn_hCs78DOhC2ZVoA_ml4RVOU5CAppS6gyYUEKczddiKK4em9nFRgBqz350EIsYzt2VG25tRcEZxA2JYTNkV4nxoQHxEvocwA4MY4lrNPolkfV5pOvTazWi-G_TXxLkwRvK-bv8Oo69HNvNRGgEkHOwePbci3F913JrZxRK66eLxNtICoRQuqYA-hWTts__v-0aAXgx1egdt3OjLFaX" />
							</div>
							<div class="flex flex-col justify-between">
								<div>
									<h4 class="font-semibold text-slate-900">Elite Performance Runner</h4>
									<p class="text-xs text-slate-500">Size: 42 | Color: Crimson</p>
								</div>
								<span class="font-normal text-slate-900">$295.00</span>
							</div>
						</div>
						<div class="flex space-x-4">
							<div class="w-20 h-24 bg-slate-100 rounded-lg overflow-hidden shrink-0">
								<img class="size-full object-cover"
									data-alt="A minimalist studio photograph of a structured designer handbag in charcoal gray, displayed on a sleek obsidian pedestal. The scene is illuminated by dramatic, high-contrast lighting that creates deep shadows and bright highlights, emphasizing its modern architectural silhouette. The overall aesthetic is one of quiet luxury and structural integrity, using a cool-toned slate color palette."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCyKOFXi6VKg0c_zdB-u1ZLnOZWHR4MZjld5fuxZfCmhkGXW48AItm-HvAFPS5B1_YNMdylohgiW6KbOyoWhsSfX-DTiLYS9XVOkcmgEMarQyqao7oLhKIws4ycPhW3SI_clfK6GnzKHfiFFxcV7MCyNlZHymMu1RliJyvDVPqiJ-kg_T5FMPiKEuyHstIzEHwVK9v5dHQECrGL8JkbK2roNDClfrQdnAC_AKL2_j9IRvHsdd3epHdnjXJWzg45-2QYxxxpjFhjmzP" />
							</div>
							<div class="flex flex-col justify-between">
								<div>
									<h4 class="font-semibold text-slate-900">Architectural Tote Bag</h4>
									<p class="text-xs text-slate-500">Size: Medium | Color: Slate</p>
								</div>
								<span class="font-normal text-slate-900">$1,450.00</span>
							</div>
						</div>
					</div>
					<!-- Totals -->
					<div class="border-t border-slate-100 pt-6 space-y-4">
						<div class="flex justify-between font-normal text-slate-600">
							<span>Subtotal</span>
							<span>$1,745.00</span>
						</div>
						<div class="flex justify-between font-normal text-slate-600">
							<span>Shipping</span>
							<span class="text-slate-700">Free</span>
						</div>
						<div class="flex justify-between font-normal text-slate-600">
							<span>Estimated Tax</span>
							<span>$144.20</span>
						</div>
						<div class="flex justify-between border-t border-slate-100 pt-6">
							<span class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Total</span>
							<span class="font-semibold tracking-tight text-xl leading-snug text-slate-900">$1,889.20</span>
						</div>
					</div>
					<!-- Promo Code -->
					<div class="mt-8">
						<label class="font-medium text-slate-700 block mb-2">Promo Code</label>
						<div class="flex space-x-2">
							<input
								class="grow bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm outline-none focus:bg-white focus:ring-1 focus:ring-primary"
								placeholder="Enter code" type="text" />
							<button
								class="bg-slate-900 text-white font-semibold px-4 py-2 rounded-lg hover:bg-black transition-colors">Apply</button>
						</div>
					</div>
				</div>
			</aside>
		</div>
	</main>
</template>
