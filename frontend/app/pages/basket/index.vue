<template>
	<main class="grow pt-20 md:py-25 md:pb-20 px-4 max-w-7xl mx-auto w-full">
		<div class="mb-6">
			<h1 class="font-bold tracking-tight text-4xl leading-tight text-slate-900">Your Basket</h1>
			<p class="font-normal text-base text-slate-600 mt-2">1 item in your basket.</p>
		</div>
		
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
			<!-- Items List Column -->
			<div class="lg:col-span-8 flex flex-col gap-4">
				<!-- Product Card (Horizontal List Item) -->
				<div
					class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col sm:flex-row gap-4 items-start sm:items-center">
					<!-- Product Image -->
					<div
						class="w-full sm:size-40 bg-slate-100 shrink-0 rounded-lg overflow-hidden border border-slate-400/30">
						<img alt="Aura Studio Wireless Headphones" class="size-full object-cover"
							data-alt="Sleek modern premium wireless over-ear headphones in matte black resting on a clean studio background with soft directional lighting."
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuAArmaIdhfBDuayeLEteMlMKqvZLDMP1KiA-vNGWS3myMj3rAp2TnzP9it93xevc2Kcp1TlIZmG5q_UFpIO_yUvtxuXOqXkSxV68L0vdXdXzi-b4E2GUCwk8QUDqwSrrf1gXloOikQhc8XAXx865d9Ge147TzdqlsHt_7WeTGwhpo5J_ieLW7hF4xAyqEg91CPriBg1B1K8LID9wRBGMuj0ExbFeQpzczAc08Aqctwn3W2mUApBMWc9pybd4ftA5D2BhCDmFMOkSN41" />
					</div>
					<!-- Product Details -->
					<div class="grow flex flex-col gap-2 w-full">
						<div class="flex justify-between items-start w-full">
							<div>
								<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Aura Studio Wireless
									Headphones</h3>
								<p class="font-semibold text-sm text-slate-600 mt-1">Color: Midnight
									Black</p>
							</div>
							<span
								class="font-normal text-lg font-bold text-slate-900 ml-4 whitespace-nowrap">£349.50</span>
						</div>
						<div class="flex items-center justify-between mt-auto pt-2">
							<!-- Quantity Controls -->
							<div class="flex items-center border border-slate-400 rounded-lg h-10 w-fit">
								<button aria-label="Decrease quantity"
									class="w-10 h-full flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors rounded-l-lg">
									<span class="material-symbols-outlined text-lg">remove</span>
								</button>
								<span
									class="w-10 text-center font-semibold text-sm text-slate-900 flex items-center justify-center">1</span>
								<button aria-label="Increase quantity"
									class="w-10 h-full flex items-center justify-center text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition-colors rounded-r-lg">
									<span class="material-symbols-outlined text-lg">add</span>
								</button>
							</div>
							<!-- Remove Action -->
							<button
								class="flex items-center gap-1 text-red-600 hover:text-red-600/80 transition-colors font-semibold text-sm group">
								<span
									class="material-symbols-outlined text-lg group-hover:scale-110 transition-transform">delete</span>
								<span>Remove</span>
							</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Order Summary Column -->
			<div class="lg:col-span-4">
				<div
					class="bg-white border border-slate-200 rounded-xl p-4 sticky top-30">
					<h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-4">Order Summary</h2>
					<div class="flex flex-col gap-2 border-b border-slate-200 pb-4 mb-4">
						<div
							class="flex justify-between items-center font-normal text-base text-slate-600">
							<span>Subtotal</span>
							<span class="text-slate-900 font-medium">£349.50</span>
						</div>
						<div
							class="flex justify-between items-center font-normal text-base text-slate-600">
							<span>Estimated Shipping</span>
							<span class="text-slate-900 font-medium">£5.00</span>
						</div>
					</div>
					<div
						class="flex justify-between items-center font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-6">
						<span>Total</span>
						<span>£354.50</span>
					</div>
					<button
						class="w-full bg-slate-900 text-white py-2 px-4 rounded-lg font-semibold text-sm hover:bg-slate-900/90 transition-colors shadow-sm flex items-center justify-center gap-2">
						Proceed to Checkout
						<span class="material-symbols-outlined text-lg">arrow_forward</span>
					</button>
					<div class="mt-2 text-center">
						<p
							class="font-medium text-xs text-slate-600 flex items-center justify-center gap-1">
							<span class="material-symbols-outlined text-sm">lock</span>
							Secure Checkout Guarantee
						</p>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
