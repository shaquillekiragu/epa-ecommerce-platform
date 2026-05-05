<template>
	<MerchantSidePanelComponent />

	<main class="flex-1 p-4 lg:p-6 overflow-y-auto">
		<!-- Header Section -->
		<div class="max-w-6xl mx-auto mb-6">
			<div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
				<div>
					<div
						class="flex items-center gap-2 text-slate-50 text-xs mb-3 uppercase tracking-widest">
						<a class="hover:text-slate-900 transition-colors" href="#">Products</a>
						<span class="material-symbols-outlined text-[12px]">chevron_right</span>
						<span>Edit Product</span>
					</div>
					<h2 class="font-bold tracking-tight text-3xl leading-tight text-slate-900">Artisan Leather Weekender</h2>
				</div>
				<div class="flex items-center gap-2">
					<button
						class="px-4 py-2 border border-slate-300 text-slate-900 font-semibold rounded hover:bg-slate-50 transition-colors">
						Cancel
					</button>
					<button
						class="px-4 py-2 bg-slate-900 text-white font-semibold rounded hover:opacity-90 transition-opacity">
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
				<section class="bg-white p-4 border border-slate-400 rounded shadow-sm">
					<h3 class="font-semibold tracking-tight text-xl leading-snug mb-4">General Information</h3>
					<div class="space-y-md">
						<div class="space-y-xs">
							<label class="font-semibold text-sm text-slate-600">Product Name</label>
							<input
								class="w-full bg-white border border-slate-400 p-2 rounded font-normal text-base focus:border-slate-900"
								type="text" value="Artisan Leather Weekender Bag" />
						</div>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
							<div class="space-y-xs">
								<label class="font-semibold text-sm text-slate-600">SKU Code</label>
								<input
									class="w-full bg-white border border-slate-400 p-2 rounded font-normal text-base"
									type="text" value="ALW-2024-BRWN" />
							</div>
							<div class="space-y-xs">
								<label class="font-semibold text-sm text-slate-600">Weight
									(grams)</label>
								<input
									class="w-full bg-white border border-slate-400 p-2 rounded font-normal text-base"
									type="number" value="1250" />
							</div>
						</div>
					</div>
				</section>
				<!-- Pricing & Inventory -->
				<section class="bg-white p-4 border border-slate-400 rounded shadow-sm">
					<h3 class="font-semibold tracking-tight text-xl leading-snug mb-4">Pricing &amp; Inventory</h3>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
						<div class="space-y-xs">
							<label class="font-semibold text-sm text-slate-600">Price (GBP)</label>
							<div class="relative">
								<span
									class="absolute left-sm top-1/2 -translate-y-1/2 font-semibold text-slate-600">£</span>
								<input
									class="w-full bg-white border border-slate-400 py-2 pl-4 pr-2 rounded font-normal text-base"
									type="text" value="349.00" />
							</div>
						</div>
						<div class="space-y-xs">
							<label class="font-semibold text-sm text-slate-600">Stock Quantity</label>
							<input
								class="w-full bg-white border border-slate-400 p-2 rounded font-normal text-base"
								type="number" value="12" />
						</div>
					</div>
				</section>
				<!-- SEO Section -->
				<section class="bg-white p-4 border border-slate-400 rounded shadow-sm">
					<div class="flex items-center gap-2 mb-4">
						<span class="material-symbols-outlined text-slate-600" data-icon="search">search</span>
						<h3 class="font-semibold tracking-tight text-xl leading-snug">Search Engine Optimization</h3>
					</div>
					<div class="space-y-md">
						<div class="space-y-xs">
							<label class="font-semibold text-sm text-slate-600">SEO Title</label>
							<input
								class="w-full bg-white border border-slate-400 p-2 rounded font-normal text-base"
								type="text" value="Artisan Leather Weekender Bag - Handcrafted Travel Essential" />
							<p class="text-xs text-slate-400">Characters: 62/70</p>
						</div>
						<div class="p-2 bg-slate-50 border border-dashed border-slate-400 rounded">
							<p class="text-xs text-slate-700 mb-1">Google Preview</p>
							<h4 class="text-blue-700 font-medium text-base hover:underline cursor-pointer">Artisan
								Leather Weekender Bag - Handcrafted Travel Essential</h4>
							<p class="text-green-700 text-xs">luxcommerce.com/products/artisan-leather-weekender
							</p>
							<p class="text-slate-600 text-xs mt-1">Expertly crafted with full-grain
								Italian leather, our weekender bag combines timeless style with modern durability for
								the sophisticated traveler...</p>
						</div>
					</div>
				</section>
			</div>
			<!-- Right Column: Sidebar Actions -->
			<div class="lg:col-span-4 space-y-grid_gutter">
				<!-- Organization & Status -->
				<section class="bg-white p-4 border border-slate-400 rounded shadow-sm">
					<h3 class="font-semibold text-sm text-slate-600 uppercase tracking-wider mb-4">Status &amp;
						Organization</h3>
					<div class="space-y-md">
						<!-- Toggle -->
						<div class="flex items-center justify-between p-2 bg-slate-50 rounded">
							<div class="flex flex-col">
								<span class="font-semibold text-slate-900">Is Live</span>
								<span class="text-xs text-slate-600">Visible in storefront</span>
							</div>
							<div class="relative inline-flex items-center cursor-pointer">
								<input checked class="sr-only peer" type="checkbox" />
								<div
									class="w-11 h-6 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-slate-900">
								</div>
							</div>
						</div>
						<!-- Category Dropdown -->
						<div class="space-y-xs">
							<label class="font-semibold text-sm text-slate-600">Category</label>
							<div class="relative">
								<select
									class="w-full bg-white border border-slate-400 p-2 pr-6 rounded font-normal text-base appearance-none">
									<option>Travel Bags</option>
									<option>Backpacks</option>
									<option>Accessories</option>
									<option>Footwear</option>
								</select>
								<span
									class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
							</div>
						</div>
					</div>
				</section>
				<!-- Image Section -->
				<section class="bg-white p-4 border border-slate-400 rounded shadow-sm">
					<div class="flex items-center justify-between mb-4">
						<h3 class="font-semibold text-sm text-slate-600 uppercase tracking-wider">Product
							Thumbnail</h3>
						<button class="text-slate-700 text-xs hover:underline">Edit</button>
					</div>
					<div class="space-y-md">
						<div
							class="aspect-square w-full rounded border border-slate-400 overflow-hidden group relative">
							<img alt="Leather Weekender Bag" class="size-full object-cover"
								data-alt="A luxurious, cognac-colored full-grain leather weekender bag sitting on a minimalist concrete plinth. The lighting is cinematic with deep shadows and soft highlights that reveal the rich texture and stitching of the leather. The environment is a clean, modern studio with a neutral background, conveying a sense of premium craftsmanship and timeless design. High-resolution product photography for a top-tier e-commerce platform."
								src="https://lh3.googleusercontent.com/aida-public/AB6AXuCQ7vYmK39cpanEbP9F_pl6TIhEBm-aND7rHyKQq24df7sbqColT6VBVsEgNYOiVINfMgUX0ZFkaIoNm5PBMXdd_tP0BrMBdiakyJ6nBf-hyiE4bzAWM6NhA4cKS41tqCxsvMtru2Fy2iRgkmsa2wxz7XNpsyNNfvD5nI6unJ0pCgcLZCc8ambrAyCvaQh7dexb5tftSo3UM7jQvdvGTKY6ZVHod1I8h8ehbwfLFZ07852Vk9DdmaZhKQmSKtfRKoLBqsgDO1wbHy2O" />
							<div
								class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
								<button class="bg-white px-4 py-2 rounded font-semibold flex items-center gap-1">
									<span class="material-symbols-outlined text-lg">photo_camera</span>
									Change Image
								</button>
							</div>
						</div>
						<div
							class="flex flex-col items-center justify-center p-4 border-2 border-dashed border-slate-400 rounded bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer group">
							<span
								class="material-symbols-outlined text-slate-400 group-hover:text-slate-900 transition-colors text-3xl"
								data-icon="cloud_upload">cloud_upload</span>
							<p class="font-semibold text-slate-600 mt-2">Upload more photos</p>
							<p class="text-xs text-slate-400">Drag and drop or click to browse</p>
						</div>
					</div>
				</section>
				<!-- Danger Zone -->
				<section class="p-4 border border-red-100 bg-red-50/30 rounded">
					<h3 class="font-semibold text-red-600 text-sm uppercase tracking-wider mb-2">Danger Zone</h3>
					<p class="text-xs text-slate-600 mb-4">Once deleted, this product cannot be
						recovered from the catalog.</p>
					<button
						class="w-full py-2 border border-red-600 text-red-600 font-semibold rounded hover:bg-red-600 hover:text-white transition-all">
						Delete Product
					</button>
				</section>
			</div>
		</div>
		<!-- Mobile Action Bar -->
		<div class="md:hidden sticky bottom-0 left-0 right-0 p-4 bg-white border-t border-slate-400 flex gap-2">
			<button class="flex-1 py-3 border border-slate-300 text-slate-900 font-semibold rounded">Cancel</button>
			<button class="flex-2 py-3 bg-slate-900 text-white font-semibold rounded px-6">Update</button>
		</div>
	</main>
</template>
