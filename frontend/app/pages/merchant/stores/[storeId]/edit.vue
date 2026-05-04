<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 p-md max-w-5xl mx-auto">
		<!-- Breadcrumbs & Header -->
		<section class="mb-lg">
			<nav class="flex items-center gap-2 text-label-sm font-label-sm text-secondary mb-4">
				<span class="hover:text-primary cursor-pointer">My Stores</span>
				<span class="material-symbols-outlined text-xs" data-icon="chevron_right">chevron_right</span>
				<span class="text-primary">Edit Store</span>
			</nav>
			<h2 class="text-headline-lg font-headline-lg text-primary">Store Settings</h2>
			<p class="text-body-md font-body-md text-secondary mt-2">Manage your store identity, public description, and
				operational preferences.</p>
		</section>
		<!-- Form Sections (Bento-inspired Grid) -->
		<div class="grid grid-cols-12 gap-grid_gutter">
			<!-- Left Column: Primary Information -->
			<div class="col-span-12 lg:col-span-8 space-y-md">
				<!-- General Information Card -->
				<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-lg">
					<h3 class="text-headline-md font-headline-md text-primary mb-6">General Information</h3>
					<div class="space-y-6">
						<div>
							<label class="block text-label-md font-label-md text-primary mb-2">Store Name</label>
							<input
								class="w-full bg-white border border-outline-variant rounded p-sm focus:border-primary focus:ring-0 transition-all text-body-md font-body-md"
								placeholder="Enter your store name" type="text" value="Avenue Luxe Boutique" />
						</div>
						<div>
							<label class="block text-label-md font-label-md text-primary mb-2">Public
								Description</label>
							<textarea
								class="w-full bg-white border border-outline-variant rounded p-sm focus:border-primary focus:ring-0 transition-all text-body-md font-body-md"
								placeholder="Describe what makes your store unique..."
								rows="5">Premium curated collection of sustainable luxury fashion and artisanal home decor items. Founded in 2024, Avenue Luxe brings together global designers and conscious consumers through a seamless digital experience.</textarea>
							<p class="text-label-sm font-label-sm text-secondary mt-2">Maximum 500 characters. This will
								be visible on your storefront page.</p>
						</div>
					</div>
				</div>
				<!-- Appearance Card -->
				<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-lg">
					<h3 class="text-headline-md font-headline-md text-primary mb-6">Store Brand</h3>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-md">
						<div>
							<p class="text-label-md font-label-md text-primary mb-4">Store Logo</p>
							<div class="flex items-center gap-md">
								<div
									class="w-24 h-24 bg-surface-container rounded-lg border border-dashed border-outline-variant flex items-center justify-center relative overflow-hidden group">
									<img class="w-full h-full object-cover"
										data-alt="A minimalist logo design featuring clean, high-contrast typography in black and white. The aesthetic is extremely modern and sophisticated, reflecting a luxury boutique identity. The logo is displayed in a brightly lit studio setting with soft shadows, fitting perfectly within the LuxCommerce design system."
										src="https://lh3.googleusercontent.com/aida-public/AB6AXuDpXaEN_vEmKiC9EvKlAgBmIDrUtWlNZg6AA0MYXTBaDyoQ4SSDoyudPCLEj2Ia_IQP0UdECSt5Oa3mK-IqQ2Qj6jI1dpVeLF_4EHi9wjDw6DmTO_MmuXFLF5xF1jPca5w8inbTF3pc6vOx8toDpwiCezLGLE8JLpH4Tn1_kBqAvtS3EhbP7r7MNNRN8xogJtJHRCvLeESaIqsWSDSRi5RLpXjCCCuksNa0HQnG68bnvdXQxGe827YqRB3hPz0Ck2jkqof1CZnT49fV" />
									<div
										class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
										<span class="material-symbols-outlined text-white" data-icon="edit">edit</span>
									</div>
								</div>
								<div class="flex-1">
									<button
										class="px-sm py-2 border border-outline-variant rounded text-label-sm font-label-sm text-primary hover:bg-surface-container transition-colors mb-2">Upload
										New Logo</button>
									<p class="text-[11px] text-secondary">Recommended size: 512x512px. PNG or SVG.</p>
								</div>
							</div>
						</div>
						<div>
							<p class="text-label-md font-label-md text-primary mb-4">Banner Image</p>
							<div
								class="h-24 bg-surface-container rounded-lg border border-dashed border-outline-variant flex items-center justify-center overflow-hidden relative group">
								<img class="w-full h-full object-cover"
									data-alt="An expansive, wide-angle shot of a high-end fashion showroom with minimalist interior design. The lighting is soft and airy, creating a high-key, sophisticated atmosphere. Soft neutral tones of beige, white, and charcoal dominate the palette, aligning with the premium retail focus of the Merchant Central platform."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuA7vbGgLZJS3xuWOrbFbp9-146OTvE2R3jK6vLk139U8dpAUOfkWhqO5T73kNK1oCKMACxa1ATDyayMgNGQx_fx9RG3vdLsLv4eaRY9ZueFygsCFpNeY3ZnNWuWfgElEl4XY6DzlUVqgQ3QZLA2KUW0IyyDvDvj1UnGMqJ2bHM1qwJQSzZpQMUQA8c7ZRlJYvlZPu4ZkSD_qfjYeNIUa80Up9OHS8azHik3YG4Q5x_JOZBZqZI3-yGqe8zahAmxXqtfvLQ3UIwMWKvn" />
								<div
									class="absolute inset-0 bg-primary/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer">
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
				<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-lg">
					<h3 class="text-label-md font-label-md text-primary mb-4">Store Visibility</h3>
					<div
						class="flex items-center justify-between p-sm bg-surface-container-low rounded border border-outline-variant mb-4">
						<div class="flex items-center gap-2">
							<span class="w-2 h-2 rounded-full bg-emerald-500"></span>
							<span class="text-label-md font-label-md text-primary">Public</span>
						</div>
						<button
							class="text-label-sm font-label-sm text-secondary hover:text-primary underline">Change</button>
					</div>
					<p class="text-label-sm font-label-sm text-secondary">Your store is currently visible to all
						customers on the global marketplace.</p>
				</div>
				<!-- Contact & Support -->
				<div class="bg-surface-container-lowest border border-outline-variant p-md rounded-lg">
					<h3 class="text-label-md font-label-md text-primary mb-4">Support Contact</h3>
					<div class="space-y-4">
						<div>
							<label class="block text-[11px] font-label-sm text-secondary mb-1">Customer Email</label>
							<input
								class="w-full bg-white border border-outline-variant rounded p-2 text-label-md focus:border-primary focus:ring-0"
								type="email" value="support@avenueluxe.com" />
						</div>
						<div class="flex items-center gap-2">
							<input checked
								class="w-4 h-4 rounded border-outline-variant text-primary focus:ring-primary"
								id="showEmail" type="checkbox" />
							<label class="text-label-sm font-label-sm text-primary" for="showEmail">Display on
								storefront</label>
						</div>
					</div>
				</div>
				<!-- Danger Zone -->
				<div class="bg-error-container/10 border border-error/20 p-md rounded-lg">
					<h3 class="text-label-md font-label-md text-error mb-2">Danger Zone</h3>
					<p class="text-label-sm font-label-sm text-secondary mb-4">Deleting your store is permanent and
						cannot be undone.</p>
					<button
						class="w-full py-2 border border-error text-error text-label-sm font-label-sm rounded hover:bg-error hover:text-white transition-all">
						Delete Store
					</button>
				</div>
			</div>
		</div>
		<!-- Footer Actions -->
		<section
			class="mt-lg pt-md border-t border-outline-variant flex flex-col md:flex-row items-center justify-between gap-md">
			<div class="flex items-center gap-2 text-secondary">
				<span class="material-symbols-outlined text-sm" data-icon="info">info</span>
				<p class="text-label-sm font-label-sm">Changes will be reflected across all storefronts immediately
					after saving.</p>
			</div>
			<div class="flex items-center gap-md w-full md:w-auto">
				<button
					class="flex-1 md:flex-none px-lg py-sm border border-primary text-primary text-label-md font-label-md rounded hover:bg-surface-container transition-all">
					Cancel
				</button>
				<button
					class="flex-1 md:flex-none px-lg py-sm bg-primary text-on-primary text-label-md font-label-md rounded hover:opacity-90 transition-all shadow-sm">
					Save Changes
				</button>
			</div>
		</section>
	</main>
</template>
