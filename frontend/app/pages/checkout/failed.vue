<template>
	<main class="flex-grow flex items-center justify-center px-grid_margin py-xl">
		<div class="max-w-[480px] w-full">
			<div
				class="bg-surface-container-lowest border border-surface-variant rounded-xl p-lg flex flex-col items-center text-center">
				<!-- Error Icon Cluster -->
				<div class="mb-md relative">
					<div class="w-xl h-xl bg-error-container rounded-full flex items-center justify-center">
						<span class="material-symbols-outlined text-[48px] text-on-error-container" data-icon="error"
							style="font-variation-settings: 'FILL' 1;">error</span>
					</div>
				</div>
				<!-- Headline -->
				<h1 class="font-headline-lg text-headline-lg text-on-surface mb-sm">Payment Failed</h1>
				<p class="font-body-md text-on-surface-variant mb-md px-base">
					We were unable to process your payment for this order. Please check your payment details or try a
					different method.
				</p>
				<!-- Status Detail Card -->
				<div
					class="w-full bg-surface-container-low rounded-xl p-md border border-outline-variant mb-lg text-left">
					<div class="flex justify-between items-center mb-base">
						<span class="font-label-md text-on-surface-variant uppercase tracking-wider">Order ID</span>
						<span class="font-label-md text-on-surface font-bold">#AC-98231-PF</span>
					</div>
					<div class="h-[1px] bg-outline-variant w-full my-sm"></div>
					<div class="flex items-start gap-sm">
						<span class="material-symbols-outlined text-error mt-xs" data-icon="report">report</span>
						<div>
							<span class="font-label-md text-on-surface block mb-xs">Reason for Failure</span>
							<p class="font-body-md text-on-surface-variant">The bank declined the transaction. This
								often happens due to insufficient funds or security blocks for international
								transactions.</p>
						</div>
					</div>
				</div>
				<!-- Actions -->
				<div class="w-full flex flex-col gap-sm">
					<button
						class="w-full py-md px-lg bg-primary text-on-primary font-label-md rounded-xl hover:opacity-90 active:scale-95 transition-all duration-150">
						Retry Payment
					</button>
					<button
						class="w-full py-md px-lg border border-outline text-on-surface font-label-md rounded-xl hover:bg-surface-container-low active:scale-95 transition-all duration-150">
						Cancel Order
					</button>
				</div>
				<!-- Support Link -->
				<div class="mt-lg flex items-center gap-xs">
					<span class="font-body-md text-on-surface-variant">Need immediate help?</span>
					<a class="font-label-md text-primary hover:underline flex items-center gap-xs" href="#">
						Contact Support
						<span class="material-symbols-outlined text-[16px]" data-icon="open_in_new">open_in_new</span>
					</a>
				</div>
			</div>
			<!-- Side Illustration (Subtle Visual Context) -->
			<div class="mt-md px-md opacity-60">
				<div
					class="relative w-full h-[120px] rounded-xl overflow-hidden grayscale contrast-125 border border-surface-variant">
					<img alt="Financial Transaction Error Illustration" class="w-full h-full object-cover"
						data-alt="A high-contrast black and white photography close-up of a modern metallic credit card reader terminal sitting on a dark marble countertop. The lighting is dramatic and moody, casting deep shadows across the device. The composition is professional and corporate, reflecting a serious financial atmosphere. Subtle lens flare highlights the industrial design of the checkout counter in a light-mode corporate setting."
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2Jql8K5UdayOQMiRYTUtVqzjTtl1kTUG4DHWLWEmePyWLIu15We9UGWolWc97oLi80pi6TkEEf4Z3uSN--d6bvNVogVfDNzjpQLd_GMaXh23pu98CKy7q3itlpdeItGbCwl6lh9OHtrl8o8NKyzhliECJSklJ-336EW4AxVeIDfzhKbfd3dw8ZIBrBl3p-5wLXZjoo5KsNIg4kbtOFxYteJOxrOirLTSWF6xUsRl6CgpyZ1pGTIR17WXKF9sAxlRKEWH0exKyfEL1" />
					<div class="absolute inset-0 bg-gradient-to-t from-background to-transparent"></div>
				</div>
			</div>
		</div>
	</main>
</template>
