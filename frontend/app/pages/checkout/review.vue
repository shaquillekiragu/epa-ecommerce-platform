<template>
	<main class="pt-24 pb-8 px-6 max-w-7xl mx-auto min-h-screen">
		<div class="mb-6">
			<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900">Checkout: Final Review</h1>
			<p class="font-normal text-base text-slate-600 mt-2">Please verify your order details before confirming
				your purchase.</p>
		</div>
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-grid_gutter">
			<!-- Left Column: Order Details -->
			<div class="lg:col-span-8 space-y-grid_gutter">
				<!-- Section: Shipping & Billing -->
				<div class="grid grid-cols-1 md:grid-cols-2 gap-grid_gutter">
					<!-- Shipping Address Card -->
					<div class="bg-white border border-slate-400 p-4">
						<div class="flex items-center justify-between mb-2">
							<h2 class="font-semibold text-sm uppercase text-slate-600">Shipping Address</h2>
							<button
								class="text-slate-700 hover:underline font-medium text-xs">Edit</button>
						</div>
						<div class="font-normal text-base text-slate-900">
							<p class="font-bold">Jonathan Sterling</p>
							<p>1248 Luxury Drive, Suite 400</p>
							<p>Beverly Hills, CA 90210</p>
							<p>United States</p>
							<p class="mt-3 text-slate-600 text-sm italic">Standard Shipping (3-5 business days)</p>
						</div>
					</div>
					<!-- Billing Address Card -->
					<div class="bg-white border border-slate-400 p-4">
						<div class="flex items-center justify-between mb-2">
							<h2 class="font-semibold text-sm uppercase text-slate-600">Billing Address</h2>
							<button
								class="text-slate-700 hover:underline font-medium text-xs">Edit</button>
						</div>
						<div class="font-normal text-base text-slate-900">
							<p class="font-bold">Jonathan Sterling</p>
							<p>1248 Luxury Drive, Suite 400</p>
							<p>Beverly Hills, CA 90210</p>
							<p>United States</p>
						</div>
					</div>
				</div>
				<!-- Section: Payment Method -->
				<div class="bg-white border border-slate-400 p-4">
					<div class="flex items-center justify-between mb-2">
						<h2 class="font-semibold text-sm uppercase text-slate-600">Payment Method</h2>
						<button
							class="text-slate-700 hover:underline font-medium text-xs">Change</button>
					</div>
					<div class="flex items-center gap-2">
						<div class="w-12 h-8 bg-slate-100 rounded-sm flex items-center justify-center">
							<span class="material-symbols-outlined text-slate-600">credit_card</span>
						</div>
						<div class="font-normal text-base text-slate-900">
							<span class="font-bold">Visa ending in 8892</span>
							<p class="text-xs text-slate-600">Expires 12/2026</p>
						</div>
					</div>
				</div>
				<!-- Section: Items Breakdown -->
				<div class="bg-white border border-slate-400 overflow-hidden">
					<div class="p-4 border-b border-slate-400">
						<h2 class="font-semibold text-sm uppercase text-slate-600">Your Basket (3 items)</h2>
					</div>
					<div class="divide-y divide-slate-300">
						<!-- Item 1 -->
						<div class="p-4 flex items-start gap-4">
							<div class="w-24 h-32 bg-slate-100 shrink-0">
								<img class="size-full object-cover"
									data-alt="A premium, structured black tailored coat photographed against a clean, light grey studio background. The lighting is crisp and editorial, highlighting the high-quality wool texture and sharp lapel details. The aesthetic is modern corporate luxury, using a minimalist composition to emphasize craftsmanship and material integrity."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPkttIguTQjXUadmNtS_BMeFn6de0M6SMFkcQYsa9fOyZN3oWDrmH4f3Mj7TU53-DqbitIjFJmPlTvtMHrGc7y12UDXYJRXtGVZbJIZvVwgxnnJyyCpa1iexNWVx_NRppCtaC7CcSp-aqScYSweC-zX6LcVWaQ6sdT3hM2M6LsRhQkQZTYd7iF7GlKmi_CM8aQYTetDl3om3pHOwTVJ5qn6Vi-m3RzPCMIYsEQpyxsSzXXKcAo-Xe7uiUxFIaffQ9VHGmi9Q9GFYZP" />
							</div>
							<div class="grow">
								<div class="flex justify-between items-start">
									<div>
										<h3 class="font-semibold tracking-tight text-lg text-slate-900">Sculpted Wool Overcoat
										</h3>
										<p class="font-normal text-xs text-slate-600 mt-1">Midnight Black | Size
											42</p>
									</div>
									<span class="font-normal text-lg font-bold text-slate-900">$850.00</span>
								</div>
								<p class="mt-2 font-medium text-xs text-slate-600">Qty: 1</p>
							</div>
						</div>
						<!-- Item 2 -->
						<div class="p-4 flex items-start gap-4">
							<div class="w-24 h-32 bg-slate-100 shrink-0">
								<img class="size-full object-cover"
									data-alt="Modern athletic footwear with a sleek, aerodynamic silhouette in a sophisticated tonal grey and white palette. The shoes are presented in a high-key studio setting with soft, diffused shadows, creating an atmosphere of technical precision and effortless efficiency. Every stitching detail and texture transition is clearly visible."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuDFZSd6JRxMHXAOheLJFvLOsh0znbX-opDdqMzt4r_B_1Jz97Jl0_ASyxVRidL-tJJCQytx7amktPb1IeG5MizuyV4XervngD4cF3OKKWNs4dgd9peoWwI5Sby0EWTy45AzXdCssFOOzmv-y5jIqy-ZEUuzaq2Ar4ZWnDBKWgUIAsD_Ky0OO6VlMfO6zMwOpxdzTsjzZYgzQP897pVNvEjpgXGMedIBQkh2a_hwJYTzbjYn5oCsPfnC7UxMQk5jZIOkBzAkSUbbZAPA" />
							</div>
							<div class="grow">
								<div class="flex justify-between items-start">
									<div>
										<h3 class="font-semibold tracking-tight text-lg text-slate-900">Aerodynamic Runner v2</h3>
										<p class="font-normal text-xs text-slate-600 mt-1">Cloud White | Size 10
										</p>
									</div>
									<span class="font-normal text-lg font-bold text-slate-900">$210.00</span>
								</div>
								<p class="mt-2 font-medium text-xs text-slate-600">Qty: 1</p>
							</div>
						</div>
						<!-- Item 3 -->
						<div class="p-4 flex items-start gap-4">
							<div class="w-24 h-32 bg-slate-100 shrink-0">
								<img class="size-full object-cover"
									data-alt="A luxury pebble-grain leather tote bag in a deep charcoal color, standing elegantly on a marble surface. The lighting is natural and bright, conveying a sense of reliability and structural integrity. The leather's rich texture and the metallic hardware accents are captured with high definition, reflecting a premium e-commerce visual style."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_V3D3Hsq7hBIZ8oQaGSp6sEADJLRDbAhAxYLxT8RVJxOB4DkVj-0-2C0L8_l_ZsJ9bvk3E-8sWt6pPcMh7nHqSa9bgjZ_ppsFz-PnhTWQmE48-eeMcf0G7C-wEfG9krscVPoQb9gMK2qeFO38EDtlnm-aWqND-CgeMn-7ijjP0p67fAS5Ap1Y6TvKekPgMGEHstN4T29zUUw-bqNSSGNgZMWWbo8MRQB1Iucp5Z1METoB1b6ZkLeCsSKp49q_Oh62V9qs4AT-5VNi" />
							</div>
							<div class="grow">
								<div class="flex justify-between items-start">
									<div>
										<h3 class="font-semibold tracking-tight text-lg text-slate-900">Signature Leather Tote
										</h3>
										<p class="font-normal text-xs text-slate-600 mt-1">Charcoal Grey | One
											Size</p>
									</div>
									<span class="font-normal text-lg font-bold text-slate-900">$495.00</span>
								</div>
								<p class="mt-2 font-medium text-xs text-slate-600">Qty: 1</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Right Column: Order Summary & CTA -->
			<div class="lg:col-span-4">
				<div class="sticky top-24 space-y-md">
					<div class="bg-slate-200 border border-slate-400 p-4">
						<h2 class="font-semibold tracking-tight text-xl leading-snug mb-4">Order Summary</h2>
						<div class="space-y-sm">
							<div class="flex justify-between font-normal text-base text-slate-600">
								<span>Subtotal</span>
								<span>$1,555.00</span>
							</div>
							<div class="flex justify-between font-normal text-base text-slate-600">
								<span>Shipping</span>
								<span class="text-slate-700 font-medium">Free</span>
							</div>
							<div class="flex justify-between font-normal text-base text-slate-600">
								<span>Estimated Tax</span>
								<span>$124.40</span>
							</div>
							<div
								class="pt-2 border-t border-slate-400 mt-2 flex justify-between font-bold tracking-tight text-[24px] text-slate-900">
								<span>Total</span>
								<span>$1,679.40</span>
							</div>
						</div>
						<div class="mt-4">
							<button
								class="w-full bg-slate-900 text-white py-4 font-semibold text-sm uppercase tracking-widest hover:bg-slate-800 transition-all active:scale-[0.98] duration-200">
								Confirm &amp; Pay
							</button>
						</div>
						<p class="mt-4 font-medium text-xs text-slate-600 text-center">
							By placing this order, you agree to LuxCommerce's <a class="underline" href="#">Terms of
								Service</a> and <a class="underline" href="#">Privacy Policy</a>.
						</p>
					</div>
					<!-- Trust Indicators -->
					<div class="flex flex-col gap-2 px-3">
						<div class="flex items-center gap-3 text-slate-600">
							<span class="material-symbols-outlined text-xl">shield</span>
							<span class="font-medium text-xs">Secure Encrypted Checkout</span>
						</div>
						<div class="flex items-center gap-3 text-slate-600">
							<span class="material-symbols-outlined text-xl">package_2</span>
							<span class="font-medium text-xs">Sustainability Certified Packaging</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
