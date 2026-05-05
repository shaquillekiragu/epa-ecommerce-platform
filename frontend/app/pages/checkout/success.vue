<template>
	<main class="flex-grow pt-32 pb-24 px-6">
		<div class="max-w-4xl mx-auto">
			<!-- Success Header -->
			<div class="text-center mb-12">
				<div class="inline-flex items-center justify-center w-20 h-20 bg-slate-900 text-white rounded-full mb-6">
					<span class="material-symbols-outlined text-4xl" data-icon="check_circle" data-weight="fill"
						style="font-variation-settings: 'FILL' 1;">check_circle</span>
				</div>
				<h1 class="font-bold tracking-tight text-4xl leading-tight text-slate-900 mb-2">Order Confirmed</h1>
				<p class="font-normal text-slate-600 max-w-lg mx-auto">Thank you for your purchase. We've sent
					a confirmation email to your registered address.</p>
				<div class="mt-4 inline-block bg-slate-100 px-4 py-2 rounded-xl">
					<span class="font-semibold text-slate-600 uppercase tracking-widest">Order ID:</span>
					<span class="font-semibold text-slate-900 ml-2 font-bold">LX-99284-CO</span>
				</div>
			</div>
			<!-- Bento Content Grid -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<!-- Timeline Section -->
				<div
					class="md:col-span-1 bg-white border border-slate-200 p-8 rounded-xl shadow-[0_4px_12px_rgba(15,23,42,0.05)]">
					<h3 class="font-semibold tracking-tight text-sm mb-8 uppercase tracking-widest text-slate-600">
						Status Timeline</h3>
					<div class="relative space-y-12">
						<div class="absolute left-4 top-2 bottom-2 w-0.5 bg-slate-100"></div>
						<!-- Step 1 -->
						<div class="relative flex items-center gap-6">
							<div
								class="z-10 w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white">
								<span class="material-symbols-outlined text-sm" data-icon="check">check</span>
							</div>
							<div>
								<p class="font-semibold text-slate-900">Payment Pending</p>
								<p class="text-[10px] text-slate-600 uppercase">Completed 14:02</p>
							</div>
						</div>
						<!-- Step 2 -->
						<div class="relative flex items-center gap-6">
							<div
								class="z-10 w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white ring-4 ring-primary/10">
								<span class="material-symbols-outlined text-sm" data-icon="payments" data-weight="fill"
									style="font-variation-settings: 'FILL' 1;">payments</span>
							</div>
							<div>
								<p class="font-semibold text-slate-900">Paid &amp; Verified</p>
								<p class="text-[10px] text-slate-600 uppercase">Success 14:03</p>
							</div>
						</div>
						<!-- Step 3 -->
						<div class="relative flex items-center gap-6 opacity-40">
							<div
								class="z-10 w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-500">
								<span class="material-symbols-outlined text-sm"
									data-icon="inventory_2">inventory_2</span>
							</div>
							<div>
								<p class="font-semibold text-slate-500">Processing</p>
								<p class="text-[10px] uppercase">Estimated 1-2 Days</p>
							</div>
						</div>
					</div>
				</div>
				<!-- Order Summary Section -->
				<div
					class="md:col-span-2 bg-white border border-slate-200 rounded-xl shadow-[0_4px_12px_rgba(15,23,42,0.05)] overflow-hidden flex flex-col">
					<div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
						<h3 class="font-semibold tracking-tight text-sm uppercase tracking-widest text-slate-600">
							Order Summary</h3>
						<span class="font-medium text-slate-600">3 Items</span>
					</div>
					<div class="flex-grow overflow-y-auto max-h-[300px]">
						<div class="divide-y divide-slate-100">
							<!-- Item 1 -->
							<div class="p-6 flex items-center gap-4 hover:bg-slate-50 transition-colors">
								<div class="w-16 h-16 bg-slate-100 rounded overflow-hidden flex-shrink-0">
									<img alt="Product" class="w-full h-full object-cover"
										data-alt="A high-end, professional product photograph of a sleek crimson running shoe against a minimalist, bright light-mode background. The lighting is crisp and soft, emphasizing the textures of the high-performance fabric. The aesthetic is clean, corporate, and focuses on structural integrity with deep blacks and vibrant reds as accents."
										src="https://lh3.googleusercontent.com/aida-public/AB6AXuCsP0brIpa6RGliR_LnX4sKRoU5eofeW1Zk-j5zSAUHJHWywKONN3xutvNBjQpCbpTzsdzDjaodtQdAobDg5IdvQHpgtfq3FaqvjCSCFj3Qmj4MD2IWh16tSuPlEesIixtZ25WnDiKO_itfhOglNTyzQluQspQP4th8BOtniEuiiwHRvCBCnyaD58107jfhA16-4ZfqVBw65LPFjiXh8ym2fz-UqwxHxyjnIO9_cCZgZlMGXadqHIXuXb6bSgGfuCHtzqQsA3W0B0EL" />
								</div>
								<div class="flex-grow">
									<p class="font-semibold text-slate-900">Velocity Runner X1</p>
									<p class="text-xs text-slate-600">Size: 42 | Color: Crimson</p>
								</div>
								<p class="font-semibold text-slate-900">$180.00</p>
							</div>
							<!-- Item 2 -->
							<div class="p-6 flex items-center gap-4 hover:bg-slate-50 transition-colors">
								<div class="w-16 h-16 bg-slate-100 rounded overflow-hidden flex-shrink-0">
									<img alt="Product" class="w-full h-full object-cover"
										data-alt="A minimalist studio photograph of a premium white smart watch with a clean, industrial design. The watch is presented on a soft grey surface under diffused bright lighting, creating a professional light-mode aesthetic. The composition highlights geometric precision and functional density, maintaining a palette of subtle greys and stark blacks."
										src="https://lh3.googleusercontent.com/aida-public/AB6AXuAfAjzhD8IU1hWkHsvqBsDKhVYKRzeaPsQZw6Ksx4OK20eyklJ2SgIB2hQBUsikftc4iAck2LsyhcdhRwHT1iw_MYG8sb3afvCeIRfYx7I3LkZ-zQ5lEPo8q39XdWeBVDZK8d5JOzIeHUFCvvP8Txcpva7_HLVh4Yv8Hc8VixszV-zV6MjI3x3FcYhBKichpNVsYrHcsoyp3lvhFtD2-hTMTwNCZSQo8-zwFpxRwq2Z0C5d24UzjTLP9wPYXdk37OKiPP5FdogM37yj" />
								</div>
								<div class="flex-grow">
									<p class="font-semibold text-slate-900">Core Chronograph</p>
									<p class="text-xs text-slate-600">Edition: Matte White</p>
								</div>
								<p class="font-semibold text-slate-900">$320.00</p>
							</div>
						</div>
					</div>
					<div class="p-6 bg-slate-50/50 border-t border-slate-100">
						<div class="flex justify-between items-center mb-2">
							<span class="text-xs text-slate-600">Subtotal</span>
							<span class="text-xs text-slate-900">$500.00</span>
						</div>
						<div class="flex justify-between items-center mb-4">
							<span class="text-xs text-slate-600">Shipping</span>
							<span class="text-xs text-slate-900">Free</span>
						</div>
						<div class="flex justify-between items-center">
							<span class="font-semibold text-slate-900 font-bold">Total</span>
							<span class="font-semibold tracking-tight text-slate-900">$500.00</span>
						</div>
					</div>
				</div>
				<!-- Action Bar -->
				<div class="md:col-span-3 mt-4 flex flex-col md:flex-row gap-4 justify-center items-center">
					<button
						class="w-full md:w-auto px-10 py-4 bg-slate-900 text-white font-semibold rounded-xl hover:opacity-90 transition-all active:scale-95 duration-200 flex items-center justify-center gap-2">
						View Order History
						<span class="material-symbols-outlined text-sm" data-icon="history">history</span>
					</button>
					<button
						class="w-full md:w-auto px-10 py-4 border-2 border-slate-900 text-slate-900 font-semibold rounded-xl hover:bg-slate-50 transition-all active:scale-95 duration-200">
						Continue Shopping
					</button>
				</div>
			</div>
		</div>
	</main>
</template>
