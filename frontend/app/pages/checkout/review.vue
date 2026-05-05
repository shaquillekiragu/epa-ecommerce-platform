<template>
	<main class="pt-24 pb-xl px-6 max-w-7xl mx-auto min-h-screen">
		<div class="mb-lg">
			<h1 class="font-headline-lg text-headline-lg text-primary">Checkout: Final Review</h1>
			<p class="font-body-md text-body-md text-secondary mt-2">Please verify your order details before confirming
				your purchase.</p>
		</div>
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-grid_gutter">
			<!-- Left Column: Order Details -->
			<div class="lg:col-span-8 space-y-grid_gutter">
				<!-- Section: Shipping & Billing -->
				<div class="grid grid-cols-1 md:grid-cols-2 gap-grid_gutter">
					<!-- Shipping Address Card -->
					<div class="bg-surface-container-lowest border border-outline-variant p-md">
						<div class="flex items-center justify-between mb-sm">
							<h2 class="font-label-md text-label-md uppercase text-secondary">Shipping Address</h2>
							<button
								class="text-on-tertiary-fixed-variant hover:underline font-label-sm text-label-sm">Edit</button>
						</div>
						<div class="font-body-md text-body-md text-on-surface">
							<p class="font-bold">Jonathan Sterling</p>
							<p>1248 Luxury Drive, Suite 400</p>
							<p>Beverly Hills, CA 90210</p>
							<p>United States</p>
							<p class="mt-base text-secondary text-sm italic">Standard Shipping (3-5 business days)</p>
						</div>
					</div>
					<!-- Billing Address Card -->
					<div class="bg-surface-container-lowest border border-outline-variant p-md">
						<div class="flex items-center justify-between mb-sm">
							<h2 class="font-label-md text-label-md uppercase text-secondary">Billing Address</h2>
							<button
								class="text-on-tertiary-fixed-variant hover:underline font-label-sm text-label-sm">Edit</button>
						</div>
						<div class="font-body-md text-body-md text-on-surface">
							<p class="font-bold">Jonathan Sterling</p>
							<p>1248 Luxury Drive, Suite 400</p>
							<p>Beverly Hills, CA 90210</p>
							<p>United States</p>
						</div>
					</div>
				</div>
				<!-- Section: Payment Method -->
				<div class="bg-surface-container-lowest border border-outline-variant p-md">
					<div class="flex items-center justify-between mb-sm">
						<h2 class="font-label-md text-label-md uppercase text-secondary">Payment Method</h2>
						<button
							class="text-on-tertiary-fixed-variant hover:underline font-label-sm text-label-sm">Change</button>
					</div>
					<div class="flex items-center gap-sm">
						<div class="w-12 h-8 bg-surface-container rounded-sm flex items-center justify-center">
							<span class="material-symbols-outlined text-on-surface-variant">credit_card</span>
						</div>
						<div class="font-body-md text-body-md text-on-surface">
							<span class="font-bold">Visa ending in 8892</span>
							<p class="text-label-sm text-secondary">Expires 12/2026</p>
						</div>
					</div>
				</div>
				<!-- Section: Items Breakdown -->
				<div class="bg-surface-container-lowest border border-outline-variant overflow-hidden">
					<div class="p-md border-b border-outline-variant">
						<h2 class="font-label-md text-label-md uppercase text-secondary">Your Basket (3 items)</h2>
					</div>
					<div class="divide-y divide-outline-variant">
						<!-- Item 1 -->
						<div class="p-md flex items-start gap-md">
							<div class="w-24 h-32 bg-surface-container flex-shrink-0">
								<img class="w-full h-full object-cover"
									data-alt="A premium, structured black tailored coat photographed against a clean, light grey studio background. The lighting is crisp and editorial, highlighting the high-quality wool texture and sharp lapel details. The aesthetic is modern corporate luxury, using a minimalist composition to emphasize craftsmanship and material integrity."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPkttIguTQjXUadmNtS_BMeFn6de0M6SMFkcQYsa9fOyZN3oWDrmH4f3Mj7TU53-DqbitIjFJmPlTvtMHrGc7y12UDXYJRXtGVZbJIZvVwgxnnJyyCpa1iexNWVx_NRppCtaC7CcSp-aqScYSweC-zX6LcVWaQ6sdT3hM2M6LsRhQkQZTYd7iF7GlKmi_CM8aQYTetDl3om3pHOwTVJ5qn6Vi-m3RzPCMIYsEQpyxsSzXXKcAo-Xe7uiUxFIaffQ9VHGmi9Q9GFYZP" />
							</div>
							<div class="flex-grow">
								<div class="flex justify-between items-start">
									<div>
										<h3 class="font-headline-md text-[18px] text-primary">Sculpted Wool Overcoat
										</h3>
										<p class="font-body-md text-label-sm text-secondary mt-xs">Midnight Black | Size
											42</p>
									</div>
									<span class="font-body-lg text-body-lg font-bold text-primary">$850.00</span>
								</div>
								<p class="mt-sm font-label-sm text-label-sm text-on-surface-variant">Qty: 1</p>
							</div>
						</div>
						<!-- Item 2 -->
						<div class="p-md flex items-start gap-md">
							<div class="w-24 h-32 bg-surface-container flex-shrink-0">
								<img class="w-full h-full object-cover"
									data-alt="Modern athletic footwear with a sleek, aerodynamic silhouette in a sophisticated tonal grey and white palette. The shoes are presented in a high-key studio setting with soft, diffused shadows, creating an atmosphere of technical precision and effortless efficiency. Every stitching detail and texture transition is clearly visible."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFZSd6JRxMHXAOheLJFvLOsh0znbX-opDdqMzt4r_B_1Jz97Jl0_ASyxVRidL-tJJCQytx7amktPb1IeG5MizuyV4XervngD4cF3OKKWNs4dgd9peoWwI5Sby0EWTy45AzXdCssFOOzmv-y5jIqy-ZEUuzaq2Ar4ZWnDBKWgUIAsD_Ky0OO6VlMfO6zMwOpxdzTsjzZYgzQP897pVNvEjpgXGMedIBQkh2a_hwJYTzbjYn5oCsPfnC7UxMQk5jZIOkBzAkSUbbZAPA" />
							</div>
							<div class="flex-grow">
								<div class="flex justify-between items-start">
									<div>
										<h3 class="font-headline-md text-[18px] text-primary">Aerodynamic Runner v2</h3>
										<p class="font-body-md text-label-sm text-secondary mt-xs">Cloud White | Size 10
										</p>
									</div>
									<span class="font-body-lg text-body-lg font-bold text-primary">$210.00</span>
								</div>
								<p class="mt-sm font-label-sm text-label-sm text-on-surface-variant">Qty: 1</p>
							</div>
						</div>
						<!-- Item 3 -->
						<div class="p-md flex items-start gap-md">
							<div class="w-24 h-32 bg-surface-container flex-shrink-0">
								<img class="w-full h-full object-cover"
									data-alt="A luxury pebble-grain leather tote bag in a deep charcoal color, standing elegantly on a marble surface. The lighting is natural and bright, conveying a sense of reliability and structural integrity. The leather's rich texture and the metallic hardware accents are captured with high definition, reflecting a premium e-commerce visual style."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_V3D3Hsq7hBIZ8oQaGSp6sEADJLRDbAhAxYLxT8RVJxOB4DkVj-0-2C0L8_l_ZsJ9bvk3E-8sWt6pPcMh7nHqSa9bgjZ_ppsFz-PnhTWQmE48-eeMcf0G7C-wEfG9krscVPoQb9gMK2qeFO38EDtlnm-aWqND-CgeMn-7ijjP0p67fAS5Ap1Y6TvKekPgMGEHstN4T29zUUw-bqNSSGNgZMWWbo8MRQB1Iucp5Z1METoB1b6ZkLeCsSKp49q_Oh62V9qs4AT-5VNi" />
							</div>
							<div class="flex-grow">
								<div class="flex justify-between items-start">
									<div>
										<h3 class="font-headline-md text-[18px] text-primary">Signature Leather Tote
										</h3>
										<p class="font-body-md text-label-sm text-secondary mt-xs">Charcoal Grey | One
											Size</p>
									</div>
									<span class="font-body-lg text-body-lg font-bold text-primary">$495.00</span>
								</div>
								<p class="mt-sm font-label-sm text-label-sm text-on-surface-variant">Qty: 1</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Right Column: Order Summary & CTA -->
			<div class="lg:col-span-4">
				<div class="sticky top-24 space-y-md">
					<div class="bg-surface-container-highest border border-outline-variant p-md">
						<h2 class="font-headline-md text-headline-md mb-md">Order Summary</h2>
						<div class="space-y-sm">
							<div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
								<span>Subtotal</span>
								<span>$1,555.00</span>
							</div>
							<div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
								<span>Shipping</span>
								<span class="text-on-tertiary-container font-medium">Free</span>
							</div>
							<div class="flex justify-between font-body-md text-body-md text-on-surface-variant">
								<span>Estimated Tax</span>
								<span>$124.40</span>
							</div>
							<div
								class="pt-sm border-t border-outline-variant mt-sm flex justify-between font-display-lg text-[24px] text-primary">
								<span>Total</span>
								<span>$1,679.40</span>
							</div>
						</div>
						<div class="mt-md">
							<button
								class="w-full bg-primary text-on-primary py-4 font-label-md text-label-md uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-[0.98] duration-200">
								Confirm &amp; Pay
							</button>
						</div>
						<p class="mt-md font-label-sm text-label-sm text-secondary text-center">
							By placing this order, you agree to LuxCommerce's <a class="underline" href="#">Terms of
								Service</a> and <a class="underline" href="#">Privacy Policy</a>.
						</p>
					</div>
					<!-- Trust Indicators -->
					<div class="flex flex-col gap-sm px-base">
						<div class="flex items-center gap-base text-secondary">
							<span class="material-symbols-outlined text-[20px]">shield</span>
							<span class="font-label-sm text-label-sm">Secure Encrypted Checkout</span>
						</div>
						<div class="flex items-center gap-base text-secondary">
							<span class="material-symbols-outlined text-[20px]">package_2</span>
							<span class="font-label-sm text-label-sm">Sustainability Certified Packaging</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
