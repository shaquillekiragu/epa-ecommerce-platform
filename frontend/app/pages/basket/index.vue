<template>
	<main class="flex-grow pt-[80px] md:pt-[100px] pb-[100px] md:pb-[80px] px-md max-w-7xl mx-auto w-full">
		<div class="mb-lg">
			<h1 class="font-display-lg text-display-lg text-on-surface">Your Basket</h1>
			<p class="font-body-md text-body-md text-on-surface-variant mt-2">1 item in your basket.</p>
		</div>
		
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-lg">
			<!-- Items List Column -->
			<div class="lg:col-span-8 flex flex-col gap-md">
				<!-- Product Card (Horizontal List Item) -->
				<div
					class="bg-surface-container-lowest border border-surface-variant rounded-xl p-md flex flex-col sm:flex-row gap-md items-start sm:items-center">
					<!-- Product Image -->
					<div
						class="w-full sm:w-40 h-40 bg-surface-container flex-shrink-0 rounded-lg overflow-hidden border border-outline-variant/30">
						<img alt="Aura Studio Wireless Headphones" class="w-full h-full object-cover"
							data-alt="Sleek modern premium wireless over-ear headphones in matte black resting on a clean studio background with soft directional lighting."
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuAArmaIdhfBDuayeLEteMlMKqvZLDMP1KiA-vNGWS3myMj3rAp2TnzP9it93xevc2Kcp1TlIZmG5q_UFpIO_yUvtxuXOqXkSxV68L0vdXdXzi-b4E2GUCwk8QUDqwSrrf1gXloOikQhc8XAXx865d9Ge147TzdqlsHt_7WeTGwhpo5J_ieLW7hF4xAyqEg91CPriBg1B1K8LID9wRBGMuj0ExbFeQpzczAc08Aqctwn3W2mUApBMWc9pybd4ftA5D2BhCDmFMOkSN41" />
					</div>
					<!-- Product Details -->
					<div class="flex-grow flex flex-col gap-2 w-full">
						<div class="flex justify-between items-start w-full">
							<div>
								<h3 class="font-headline-md text-headline-md text-on-surface">Aura Studio Wireless
									Headphones</h3>
								<p class="font-label-md text-label-md text-on-surface-variant mt-1">Color: Midnight
									Black</p>
							</div>
							<span
								class="font-body-lg text-body-lg font-bold text-on-surface ml-4 whitespace-nowrap">£349.50</span>
						</div>
						<div class="flex items-center justify-between mt-auto pt-sm">
							<!-- Quantity Controls -->
							<div class="flex items-center border border-outline-variant rounded-lg h-10 w-fit">
								<button aria-label="Decrease quantity"
									class="w-10 h-full flex items-center justify-center text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low transition-colors rounded-l-lg">
									<span class="material-symbols-outlined text-[18px]">remove</span>
								</button>
								<span
									class="w-10 text-center font-label-md text-label-md text-on-surface flex items-center justify-center">1</span>
								<button aria-label="Increase quantity"
									class="w-10 h-full flex items-center justify-center text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low transition-colors rounded-r-lg">
									<span class="material-symbols-outlined text-[18px]">add</span>
								</button>
							</div>
							<!-- Remove Action -->
							<button
								class="flex items-center gap-1 text-error hover:text-error/80 transition-colors font-label-md text-label-md group">
								<span
									class="material-symbols-outlined text-[18px] group-hover:scale-110 transition-transform">delete</span>
								<span>Remove</span>
							</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Order Summary Column -->
			<div class="lg:col-span-4">
				<div
					class="bg-surface-container-lowest border border-surface-variant rounded-xl p-md sticky top-[120px]">
					<h2 class="font-headline-md text-headline-md text-on-surface mb-md">Order Summary</h2>
					<div class="flex flex-col gap-sm border-b border-surface-variant pb-md mb-md">
						<div
							class="flex justify-between items-center font-body-md text-body-md text-on-surface-variant">
							<span>Subtotal</span>
							<span class="text-on-surface font-medium">£349.50</span>
						</div>
						<div
							class="flex justify-between items-center font-body-md text-body-md text-on-surface-variant">
							<span>Estimated Shipping</span>
							<span class="text-on-surface font-medium">£5.00</span>
						</div>
					</div>
					<div
						class="flex justify-between items-center font-headline-md text-headline-md text-on-surface mb-lg">
						<span>Total</span>
						<span>£354.50</span>
					</div>
					<button
						class="w-full bg-primary text-on-primary py-sm px-md rounded-lg font-label-md text-label-md hover:bg-primary/90 transition-colors shadow-sm flex items-center justify-center gap-2">
						Proceed to Checkout
						<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
					</button>
					<div class="mt-sm text-center">
						<p
							class="font-label-sm text-label-sm text-on-surface-variant flex items-center justify-center gap-1">
							<span class="material-symbols-outlined text-[14px]">lock</span>
							Secure Checkout Guarantee
						</p>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
