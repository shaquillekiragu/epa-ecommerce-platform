<template>
	<main class="flex-grow ml-0 md:ml-64 p-6 lg:p-12">
		<div class="max-w-[1000px] mx-auto">
			<header class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
				<div>
					<nav class="flex items-center gap-2 text-label-sm text-on-secondary-container mb-4">
						<a class="hover:text-primary" href="#">Account</a>
						<span class="material-symbols-outlined text-[14px]">chevron_right</span>
						<span class="text-primary font-bold">Addresses</span>
					</nav>
					<h1 class="font-headline-lg text-primary tracking-tight">Saved Addresses</h1>
					<p class="font-body-md text-on-surface-variant mt-2">Manage your default shipping and billing
						information for faster checkout.</p>
				</div>
				<button
					class="bg-primary text-on-primary font-label-md px-6 py-3 rounded-full flex items-center gap-2 hover:opacity-90 active:scale-95 transition-all shadow-lg shadow-black/5">
					<span class="material-symbols-outlined text-[20px]"
						data-icon="add_location_alt">add_location_alt</span>
					Add New Address
				</button>
			</header>
			<!-- Bento-style Address Grid -->
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-grid_gutter">
				<!-- Main Shipping Card (Large) -->
				<div
					class="lg:col-span-7 bg-white border border-outline-variant p-8 rounded-xl relative group hover:border-primary transition-colors">
					<div class="flex justify-between items-start mb-6">
						<span
							class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-label-sm flex items-center gap-1">
							<span class="material-symbols-outlined text-[16px]"
								style="font-variation-settings: 'FILL' 1;">star</span>
							Default Shipping
						</span>
						<div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
							<button class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant"><span
									class="material-symbols-outlined">edit</span></button>
							<button
								class="p-2 hover:bg-error-container hover:text-error rounded-full text-on-surface-variant"><span
									class="material-symbols-outlined">delete</span></button>
						</div>
					</div>
					<h3 class="font-headline-md text-primary mb-2">Corporate Headquarters</h3>
					<p class="font-body-lg text-on-surface leading-relaxed">
						Sarah Jenkins<br />
						1200 Avenue of the Americas<br />
						Floor 14, Suite 200<br />
						New York, NY 10036<br />
						United States
					</p>
					<div class="mt-8 flex items-center gap-4 pt-6 border-t border-slate-100">
						<div class="flex items-center gap-2 text-on-surface-variant">
							<span class="material-symbols-outlined text-[18px]">phone</span>
							<span class="text-label-md">+1 (212) 555-0198</span>
						</div>
						<div class="flex items-center gap-2 text-on-surface-variant">
							<span class="material-symbols-outlined text-[18px]">mail</span>
							<span class="text-label-md">s.jenkins@luxcommerce.com</span>
						</div>
					</div>
				</div>
				<!-- Billing Card (Compact) -->
				<div
					class="lg:col-span-5 bg-white border border-outline-variant p-8 rounded-xl group hover:border-primary transition-colors">
					<div class="flex justify-between items-start mb-6">
						<span
							class="bg-surface-container-highest text-on-surface px-3 py-1 rounded-full text-label-sm">Billing
							Only</span>
						<div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
							<button class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant"><span
									class="material-symbols-outlined">edit</span></button>
							<button
								class="p-2 hover:bg-error-container hover:text-error rounded-full text-on-surface-variant"><span
									class="material-symbols-outlined">delete</span></button>
						</div>
					</div>
					<h3 class="font-headline-md text-primary mb-2">Home Office</h3>
					<p class="font-body-md text-on-surface-variant leading-relaxed">
						Sarah Jenkins<br />
						452 West 22nd Street<br />
						Apt 4B<br />
						New York, NY 10011
					</p>
				</div>
				<!-- Secondary Shipping Card -->
				<div
					class="lg:col-span-5 bg-white border border-outline-variant p-8 rounded-xl group hover:border-primary transition-colors">
					<div class="flex justify-between items-start mb-6">
						<span
							class="bg-surface-container-highest text-on-surface px-3 py-1 rounded-full text-label-sm">Shipping
							Only</span>
						<div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
							<button class="p-2 hover:bg-surface-container rounded-full text-on-surface-variant"><span
									class="material-symbols-outlined">edit</span></button>
							<button
								class="p-2 hover:bg-error-container hover:text-error rounded-full text-on-surface-variant"><span
									class="material-symbols-outlined">delete</span></button>
						</div>
					</div>
					<h3 class="font-headline-md text-primary mb-2">Hamptons Retreat</h3>
					<p class="font-body-md text-on-surface-variant leading-relaxed">
						Sarah Jenkins<br />
						89 Ocean View Terrace<br />
						East Hampton, NY 11937
					</p>
				</div>
				<!-- Map Placeholder / Visual Element -->
				<div
					class="lg:col-span-7 bg-surface-container-low border border-outline-variant rounded-xl overflow-hidden relative min-h-[240px]">
					<img alt="Map view" class="w-full h-full object-cover grayscale opacity-50 contrast-125"
						data-alt="A clean, minimalist map visualization of Manhattan, New York, rendered in a sophisticated monochromatic slate and grey color palette. Subtle primary black dots indicate saved delivery locations across the urban grid. The aesthetic is modern and corporate, matching the high-end LuxCommerce UI style. Soft overhead lighting effect with no harsh shadows creates a professional, data-centric atmosphere."
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuDw5N8KG4aAtFEMnURXEZhMB3XWiqMw_z5ICFuVotuv96IB7TxXPBvM5dowp2pBjaTReP1ukinnsU_fuvIR4SEXXzDc7WdKxZwGIwDRFUKQ49Mpax0n8-uaPr-XKQf4Qp-_Un15P15ngh5RkYjo54ZlqVrqhZZvjsxzVRO1lQQhScsBWw4vYe8DYEvPM3ZbL_I-sM6pJAttH-fYPSc1UQ5hij-tJNykYukGDnKZLfsV2ogyYvrn51ODfmcpn2t5oGhlR34e12NRmzTw" />
					<div class="absolute inset-0 bg-gradient-to-t from-white/80 to-transparent flex items-end p-8">
						<div
							class="bg-white/90 backdrop-blur-md p-4 border border-outline-variant rounded-lg flex items-center gap-4">
							<span class="material-symbols-outlined text-primary text-[32px]">location_on</span>
							<div>
								<p class="text-label-md text-primary">All locations in New York</p>
								<p class="text-label-sm text-on-surface-variant">3 saved addresses</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Empty State Suggestion (Subtle) -->
			<div
				class="mt-12 border-2 border-dashed border-outline-variant rounded-xl p-12 flex flex-col items-center justify-center text-center">
				<div class="bg-surface-container w-16 h-16 rounded-full flex items-center justify-center mb-4">
					<span class="material-symbols-outlined text-on-surface-variant"
						data-icon="add_location">add_location</span>
				</div>
				<h4 class="font-headline-md text-primary">Need a temporary address?</h4>
				<p class="font-body-md text-on-surface-variant mt-2 max-w-md">You can add vacation homes, office
					addresses, or gift destinations to your profile for easy selection during checkout.</p>
				<button
					class="mt-6 text-primary font-label-md flex items-center gap-1 hover:underline underline-offset-4 transition-all">
					Explore address book options <span
						class="material-symbols-outlined text-[18px]">arrow_forward</span>
				</button>
			</div>
		</div>
	</main>
</template>
