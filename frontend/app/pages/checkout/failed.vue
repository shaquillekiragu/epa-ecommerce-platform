<template>
	<main class="flex-grow flex items-center justify-center px-6 py-8">
		<div class="max-w-[480px] w-full">
			<div
				class="bg-white border border-slate-200 rounded-xl p-6 flex flex-col items-center text-center">
				<!-- Error Icon Cluster -->
				<div class="mb-4 relative">
					<div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
						<span class="material-symbols-outlined text-[48px] text-red-700" data-icon="error"
							style="font-variation-settings: 'FILL' 1;">error</span>
					</div>
				</div>
				<!-- Headline -->
				<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900 mb-2">Payment Failed</h1>
				<p class="font-normal text-slate-600 mb-4 px-3">
					We were unable to process your payment for this order. Please check your payment details or try a
					different method.
				</p>
				<!-- Status Detail Card -->
				<div
					class="w-full bg-slate-50 rounded-xl p-4 border border-slate-400 mb-6 text-left">
					<div class="flex justify-between items-center mb-3">
						<span class="font-semibold text-slate-600 uppercase tracking-wider">Order ID</span>
						<span class="font-semibold text-slate-900 font-bold">#AC-98231-PF</span>
					</div>
					<div class="h-[1px] bg-slate-300 w-full my-2"></div>
					<div class="flex items-start gap-2">
						<span class="material-symbols-outlined text-red-600 mt-1" data-icon="report">report</span>
						<div>
							<span class="font-semibold text-slate-900 block mb-1">Reason for Failure</span>
							<p class="font-normal text-slate-600">The bank declined the transaction. This
								often happens due to insufficient funds or security blocks for international
								transactions.</p>
						</div>
					</div>
				</div>
				<!-- Actions -->
				<div class="w-full flex flex-col gap-2">
					<button
						class="w-full py-4 px-6 bg-slate-900 text-white font-semibold rounded-xl hover:opacity-90 active:scale-95 transition-all duration-150">
						Retry Payment
					</button>
					<button
						class="w-full py-4 px-6 border border-slate-300 text-slate-900 font-semibold rounded-xl hover:bg-slate-50 active:scale-95 transition-all duration-150">
						Cancel Order
					</button>
				</div>
				<!-- Support Link -->
				<div class="mt-6 flex items-center gap-1">
					<span class="font-normal text-slate-600">Need immediate help?</span>
					<a class="font-semibold text-slate-900 hover:underline flex items-center gap-1" href="#">
						Contact Support
						<span class="material-symbols-outlined text-[16px]" data-icon="open_in_new">open_in_new</span>
					</a>
				</div>
			</div>
			<!-- Side Illustration (Subtle Visual Context) -->
			<div class="mt-4 px-4 opacity-60">
				<div
					class="relative w-full h-[120px] rounded-xl overflow-hidden grayscale contrast-125 border border-slate-200">
					<img alt="Financial Transaction Error Illustration" class="w-full h-full object-cover"
						data-alt="A high-contrast black and white photography close-up of a modern metallic credit card reader terminal sitting on a dark marble countertop. The lighting is dramatic and moody, casting deep shadows across the device. The composition is professional and corporate, reflecting a serious financial atmosphere. Subtle lens flare highlights the industrial design of the checkout counter in a light-mode corporate setting."
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuC2Jql8K5UdayOQMiRYTUtVqzjTtl1kTUG4DHWLWEmePyWLIu15We9UGWolWc97oLi80pi6TkEEf4Z3uSN--d6bvNVogVfDNzjpQLd_GMaXh23pu98CKy7q3itlpdeItGbCwl6lh9OHtrl8o8NKyzhliECJSklJ-336EW4AxVeIDfzhKbfd3dw8ZIBrBl3p-5wLXZjoo5KsNIg4kbtOFxYteJOxrOirLTSWF6xUsRl6CgpyZ1pGTIR17WXKF9sAxlRKEWH0exKyfEL1" />
					<div class="absolute inset-0 bg-gradient-to-t from-slate-50 to-transparent"></div>
				</div>
			</div>
		</div>
	</main>
</template>
