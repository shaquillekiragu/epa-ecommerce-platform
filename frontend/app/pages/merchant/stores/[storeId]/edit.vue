<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 p-4 max-w-5xl mx-auto">
		<!-- Breadcrumbs & Header -->
		<section class="mb-6">
			<nav class="flex items-center gap-2 text-xs font-medium text-slate-600 mb-4">
				<span class="hover:text-slate-900 cursor-pointer">My Stores</span>
				<span class="material-symbols-outlined text-xs" data-icon="chevron_right">chevron_right</span>
				<span class="text-slate-900">Edit Store</span>
			</nav>
			<h2 class="text-3xl leading-tight font-bold tracking-tight text-slate-900">Store Settings</h2>
			<p class="text-base font-normal text-slate-600 mt-2">Manage your store identity, public description, and
				operational preferences.</p>
		</section>
		<!-- Form Sections (Bento-inspired Grid) -->
		<div class="grid grid-cols-12 gap-grid_gutter">
			<!-- Left Column: Primary Information -->
			<div class="col-span-12 lg:col-span-8 space-y-md">
				<!-- General Information Card -->
				<div class="bg-white border border-slate-400 p-4 rounded-lg">
					<h3 class="text-xl leading-snug font-semibold tracking-tight text-slate-900 mb-6">General Information</h3>
					<div class="space-y-6">
						<div>
							<label class="block text-sm font-semibold text-slate-900 mb-2">Store Name</label>
							<input
								class="w-full bg-white border border-slate-400 rounded p-2 focus:border-slate-900 focus:ring-0 transition-all text-base font-normal"
								placeholder="Enter your store name" type="text" value="Avenue Luxe Boutique" />
						</div>
						<div>
							<label class="block text-sm font-semibold text-slate-900 mb-2">Public
								Description</label>
							<textarea
								class="w-full bg-white border border-slate-400 rounded p-2 focus:border-slate-900 focus:ring-0 transition-all text-base font-normal"
								placeholder="Describe what makes your store unique..."
								rows="5">Premium curated collection of sustainable luxury fashion and artisanal home decor items. Founded in 2024, Avenue Luxe brings together global designers and conscious consumers through a seamless digital experience.</textarea>
							<p class="text-xs font-medium text-slate-600 mt-2">Maximum 500 characters. This will
								be visible on your storefront page.</p>
						</div>
					</div>
				</div>
				<!-- Appearance Card -->
				<div class="bg-white border border-slate-400 p-4 rounded-lg">
					<h3 class="text-xl leading-snug font-semibold tracking-tight text-slate-900 mb-6">Store Brand</h3>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<div>
							<p class="text-sm font-semibold text-slate-900 mb-4">Store Logo</p>
							<div class="flex items-center gap-4">
								<div
									class="size-24 bg-slate-100 rounded-lg border border-dashed border-slate-400 flex items-center justify-center relative overflow-hidden group">
									<img class="size-full object-cover"
										data-alt="A minimalist logo design featuring clean, high-contrast typography in black and white. The aesthetic is extremely modern and sophisticated, reflecting a luxury boutique identity. The logo is displayed in a brightly lit studio setting with soft shadows, fitting perfectly within the LuxCommerce design system."
										src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpXaEN_vEmKiC9EvKlAgBmIDrUtWlNZg6AA0MYXTBaDyoQ4SSDoyudPCLEj2Ia_IQP0UdECSt5Oa3mK-IqQ2Qj6jI1dpVeLF_4EHi9wjDw6DmTO_MmuXFLF5xF1jPca5w8inbTF3pc6vOx8toDpwiCezLGLE8JLpH4Tn1_kBqAvtS3EhbP7r7MNNRN8xogJtJHRCvLeESaIqsWSDSRi5RLpXjCCCuksNa0HQnG68bnvdXQxGe827YqRB3hPz0Ck2jkqof1CZnT49fV" />
									<div
										class="absolute inset-0 bg-slate-900/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
										<span class="material-symbols-outlined text-white" data-icon="edit">edit</span>
									</div>
								</div>
								<div class="flex-1">
									<button
										class="p-2 border border-slate-400 rounded text-xs font-medium text-slate-900 hover:bg-slate-100 transition-colors mb-2">Upload
										New Logo</button>
									<p class="text-[11px] text-slate-600">Recommended size: 512x512px. PNG or SVG.</p>
								</div>
							</div>
						</div>
						<div>
							<p class="text-sm font-semibold text-slate-900 mb-4">Banner Image</p>
							<div
								class="h-24 bg-slate-100 rounded-lg border border-dashed border-slate-400 flex items-center justify-center overflow-hidden relative group">
								<img class="size-full object-cover"
									data-alt="An expansive, wide-angle shot of a high-end fashion showroom with minimalist interior design. The lighting is soft and airy, creating a high-key, sophisticated atmosphere. Soft neutral tones of beige, white, and charcoal dominate the palette, aligning with the premium retail focus of the Merchant Central platform."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuA7vbGgLZJS3xuWOrbFbp9-146OTvE2R3jK6vLk139U8dpAUOfkWhqO5T73kNK1oCKMACxa1ATDyayMgNGQx_fx9RG3vdLsLv4eaRY9ZueFygsCFpNeY3ZnNWuWfgElEl4XY6DzlUVqgQ3QZLA2KUW0IyyDvDvj1UnGMqJ2bHM1qwJQSzZpQMUQA8c7ZRlJYvlZPu4ZkSD_qfjYeNIUa80Up9OHS8azHik3YG4Q5x_JOZBZqZI3-yGqe8zahAmxXqtfvLQ3UIwMWKvn" />
								<div
									class="absolute inset-0 bg-slate-900/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
									<span class="material-symbols-outlined text-white"
										data-icon="photo_camera">photo_camera</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Right Column: Settings & Quick Actions -->
			<div class="col-span-12 lg:col-span-4 space-y-md">
				<!-- Visibility Status -->
				<div class="bg-white border border-slate-400 p-4 rounded-lg">
					<h3 class="text-sm font-semibold text-slate-900 mb-4">Store Visibility</h3>
					<div
						class="flex items-center justify-between p-2 bg-slate-50 rounded border border-slate-400 mb-4">
						<div class="flex items-center gap-2">
							<span class="size-2 rounded-full bg-emerald-500"></span>
							<span class="text-sm font-semibold text-slate-900">Public</span>
						</div>
						<button
							class="text-xs font-medium text-slate-600 hover:text-slate-900 underline">Change</button>
					</div>
					<p class="text-xs font-medium text-slate-600">Your store is currently visible to all
						customers on the global marketplace.</p>
				</div>
				<!-- Contact & Support -->
				<div class="bg-white border border-slate-400 p-4 rounded-lg">
					<h3 class="text-sm font-semibold text-slate-900 mb-4">Support Contact</h3>
					<div class="space-y-4">
						<div>
							<label class="block text-[11px] font-medium text-slate-600 mb-1">Customer Email</label>
							<input
								class="w-full bg-white border border-slate-400 rounded p-2 text-sm focus:border-slate-900 focus:ring-0"
								type="email" value="support@avenueluxe.com" />
						</div>
						<div class="flex items-center gap-2">
							<input checked
								class="size-4 rounded border-slate-400 text-slate-900 focus:ring-primary"
								id="showEmail" type="checkbox" />
							<label class="text-xs font-medium text-slate-900" for="showEmail">Display on
								storefront</label>
						</div>
					</div>
				</div>
				<!-- Danger Zone -->
				<div class="bg-red-100/10 border border-red-600/20 p-4 rounded-lg">
					<h3 class="text-sm font-semibold text-red-600 mb-2">Danger Zone</h3>
					<p class="text-xs font-medium text-slate-600 mb-4">Deleting your store is permanent and
						cannot be undone.</p>
					<button
						class="w-full py-2 border border-red-600 text-red-600 text-xs font-medium rounded hover:bg-red-600 hover:text-white transition-all">
						Delete Store
					</button>
				</div>
			</div>
		</div>
		<!-- Footer Actions -->
		<section
			class="mt-6 pt-4 border-t border-slate-400 flex flex-col md:flex-row items-center justify-between gap-4">
			<div class="flex items-center gap-2 text-slate-600">
				<span class="material-symbols-outlined text-sm" data-icon="info">info</span>
				<p class="text-xs font-medium">Changes will be reflected across all storefronts immediately
					after saving.</p>
			</div>
			<div class="flex items-center gap-4 w-full md:w-auto">
				<button
					class="flex-1 md:flex-none px-6 py-2 border border-slate-900 text-slate-900 text-sm font-semibold rounded hover:bg-slate-100 transition-all">
					Cancel
				</button>
				<button
					class="flex-1 md:flex-none px-6 py-2 bg-slate-900 text-white text-sm font-semibold rounded hover:opacity-90 transition-all shadow-sm">
					Save Changes
				</button>
			</div>
		</section>
	</main>
</template>
