<template>
	<MerchantSidePanelComponent />

	<main class="flex-1 p-md lg:p-lg overflow-y-auto">
		<!-- Header Section -->
		<div class="max-w-6xl mx-auto mb-lg">
			<div class="flex flex-col md:flex-row md:items-center justify-between gap-md">
				<div>
					<div
						class="flex items-center gap-2 text-on-primary-container text-label-sm mb-base uppercase tracking-widest">
						<a class="hover:text-primary transition-colors" href="#">Products</a>
						<span class="material-symbols-outlined text-[12px]">chevron_right</span>
						<span>Edit Product</span>
					</div>
					<h2 class="font-headline-lg text-headline-lg text-primary">Artisan Leather Weekender</h2>
				</div>
				<div class="flex items-center gap-sm">
					<button
						class="px-md py-2 border border-outline text-primary font-label-md rounded hover:bg-surface-container-low transition-colors">
						Cancel
					</button>
					<button
						class="px-md py-2 bg-primary text-on-primary font-label-md rounded hover:opacity-90 transition-opacity">
						Update Product
					</button>
				</div>
			</div>
		</div>
		<!-- Edit Form Grid -->
		<div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-grid_gutter">
			<!-- Left Column: Primary Details -->
			<div class="lg:col-span-8 space-y-grid_gutter">
				<!-- Basic Information Section -->
				<section class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
					<h3 class="font-headline-md text-headline-md mb-md">General Information</h3>
					<div class="space-y-md">
						<div class="space-y-xs">
							<label class="font-label-md text-label-md text-on-surface-variant">Product Name</label>
							<input
								class="w-full bg-white border border-outline-variant p-sm rounded font-body-md text-body-md focus:border-primary"
								type="text" value="Artisan Leather Weekender Bag" />
						</div>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-md">
							<div class="space-y-xs">
								<label class="font-label-md text-label-md text-on-surface-variant">SKU Code</label>
								<input
									class="w-full bg-white border border-outline-variant p-sm rounded font-body-md text-body-md"
									type="text" value="ALW-2024-BRWN" />
							</div>
							<div class="space-y-xs">
								<label class="font-label-md text-label-md text-on-surface-variant">Weight
									(grams)</label>
								<input
									class="w-full bg-white border border-outline-variant p-sm rounded font-body-md text-body-md"
									type="number" value="1250" />
							</div>
						</div>
					</div>
				</section>
				<!-- Pricing & Inventory -->
				<section class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
					<h3 class="font-headline-md text-headline-md mb-md">Pricing &amp; Inventory</h3>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-md">
						<div class="space-y-xs">
							<label class="font-label-md text-label-md text-on-surface-variant">Price (GBP)</label>
							<div class="relative">
								<span
									class="absolute left-sm top-1/2 -translate-y-1/2 font-label-md text-on-surface-variant">£</span>
								<input
									class="w-full bg-white border border-outline-variant py-sm pl-md pr-sm rounded font-body-md text-body-md"
									type="text" value="349.00" />
							</div>
						</div>
						<div class="space-y-xs">
							<label class="font-label-md text-label-md text-on-surface-variant">Stock Quantity</label>
							<input
								class="w-full bg-white border border-outline-variant p-sm rounded font-body-md text-body-md"
								type="number" value="12" />
						</div>
					</div>
				</section>
				<!-- SEO Section -->
				<section class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
					<div class="flex items-center gap-2 mb-md">
						<span class="material-symbols-outlined text-secondary" data-icon="search">search</span>
						<h3 class="font-headline-md text-headline-md">Search Engine Optimization</h3>
					</div>
					<div class="space-y-md">
						<div class="space-y-xs">
							<label class="font-label-md text-label-md text-on-surface-variant">SEO Title</label>
							<input
								class="w-full bg-white border border-outline-variant p-sm rounded font-body-md text-body-md"
								type="text" value="Artisan Leather Weekender Bag - Handcrafted Travel Essential" />
							<p class="text-label-sm text-outline">Characters: 62/70</p>
						</div>
						<div class="p-sm bg-surface-container-low border border-dashed border-outline-variant rounded">
							<p class="text-label-sm text-on-tertiary-container mb-xs">Google Preview</p>
							<h4 class="text-blue-700 font-medium text-body-md hover:underline cursor-pointer">Artisan
								Leather Weekender Bag - Handcrafted Travel Essential</h4>
							<p class="text-green-700 text-label-sm">luxcommerce.com/products/artisan-leather-weekender
							</p>
							<p class="text-on-surface-variant text-label-sm mt-xs">Expertly crafted with full-grain
								Italian leather, our weekender bag combines timeless style with modern durability for
								the sophisticated traveler...</p>
						</div>
					</div>
				</section>
			</div>
			<!-- Right Column: Sidebar Actions -->
			<div class="lg:col-span-4 space-y-grid_gutter">
				<!-- Organization & Status -->
				<section class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
					<h3 class="font-label-md text-label-md text-secondary uppercase tracking-wider mb-md">Status &amp;
						Organization</h3>
					<div class="space-y-md">
						<!-- Toggle -->
						<div class="flex items-center justify-between p-sm bg-surface-container-low rounded">
							<div class="flex flex-col">
								<span class="font-label-md text-primary">Is Live</span>
								<span class="text-label-sm text-on-surface-variant">Visible in storefront</span>
							</div>
							<div class="relative inline-flex items-center cursor-pointer">
								<input checked class="sr-only peer" type="checkbox" />
								<div
									class="w-11 h-6 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
								</div>
							</div>
						</div>
						<!-- Category Dropdown -->
						<div class="space-y-xs">
							<label class="font-label-md text-label-md text-on-surface-variant">Category</label>
							<div class="relative">
								<select
									class="w-full bg-white border border-outline-variant p-sm pr-lg rounded font-body-md text-body-md appearance-none">
									<option>Travel Bags</option>
									<option>Backpacks</option>
									<option>Accessories</option>
									<option>Footwear</option>
								</select>
								<span
									class="material-symbols-outlined absolute right-sm top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
							</div>
						</div>
					</div>
				</section>
				<!-- Image Section -->
				<section class="bg-surface-container-lowest p-md border border-outline-variant rounded shadow-sm">
					<div class="flex items-center justify-between mb-md">
						<h3 class="font-label-md text-label-md text-secondary uppercase tracking-wider">Product
							Thumbnail</h3>
						<button class="text-on-tertiary-container text-label-sm hover:underline">Edit</button>
					</div>
					<div class="space-y-md">
						<div
							class="aspect-square w-full rounded border border-outline-variant overflow-hidden group relative">
							<img alt="Leather Weekender Bag" class="w-full h-full object-cover"
								data-alt="A luxurious, cognac-colored full-grain leather weekender bag sitting on a minimalist concrete plinth. The lighting is cinematic with deep shadows and soft highlights that reveal the rich texture and stitching of the leather. The environment is a clean, modern studio with a neutral background, conveying a sense of premium craftsmanship and timeless design. High-resolution product photography for a top-tier e-commerce platform."
								src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQ7vYmK39cpanEbP9F_pl6TIhEBm-aND7rHyKQq24df7sbqColT6VBVsEgNYOiVINfMgUX0ZFkaIoNm5PBMXdd_tP0BrMBdiakyJ6nBf-hyiE4bzAWM6NhA4cKS41tqCxsvMtru2Fy2iRgkmsa2wxz7XNpsyNNfvD5nI6unJ0pCgcLZCc8ambrAyCvaQh7dexb5tftSo3UM7jQvdvGTKY6ZVHod1I8h8ehbwfLFZ07852Vk9DdmaZhKQmSKtfRKoLBqsgDO1wbHy2O" />
							<div
								class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
								<button class="bg-white px-md py-2 rounded font-label-md flex items-center gap-xs">
									<span class="material-symbols-outlined text-[18px]">photo_camera</span>
									Change Image
								</button>
							</div>
						</div>
						<div
							class="flex flex-col items-center justify-center p-md border-2 border-dashed border-outline-variant rounded bg-surface-container-low hover:bg-surface-container transition-colors cursor-pointer group">
							<span
								class="material-symbols-outlined text-outline group-hover:text-primary transition-colors text-3xl"
								data-icon="cloud_upload">cloud_upload</span>
							<p class="font-label-md text-on-surface-variant mt-sm">Upload more photos</p>
							<p class="text-label-sm text-outline">Drag and drop or click to browse</p>
						</div>
					</div>
				</section>
				<!-- Danger Zone -->
				<section class="p-md border border-red-100 bg-red-50/30 rounded">
					<h3 class="font-label-md text-error text-label-md uppercase tracking-wider mb-sm">Danger Zone</h3>
					<p class="text-label-sm text-on-surface-variant mb-md">Once deleted, this product cannot be
						recovered from the catalog.</p>
					<button
						class="w-full py-2 border border-error text-error font-label-md rounded hover:bg-error hover:text-white transition-all">
						Delete Product
					</button>
				</section>
			</div>
		</div>
		<!-- Mobile Action Bar -->
		<div class="md:hidden sticky bottom-0 left-0 right-0 p-md bg-white border-t border-outline-variant flex gap-sm">
			<button class="flex-1 py-3 border border-outline text-primary font-label-md rounded">Cancel</button>
			<button class="flex-2 py-3 bg-primary text-on-primary font-label-md rounded px-lg">Update</button>
		</div>
	</main>
</template>
