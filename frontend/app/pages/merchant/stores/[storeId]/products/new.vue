<template>
	<main class="min-h-screen w-full pb-16 pt-24">
		<!-- Top App Bar -->
		<header
			class="flex justify-between items-center h-16 px-6 w-full sticky top-0 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 z-40">
			<div class="flex items-center gap-4">
				<button
					class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
					<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
				</button>
				<button
					class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
					<span class="material-symbols-outlined" data-icon="settings">settings</span>
				</button>
				<div class="size-8 rounded-full overflow-hidden border border-slate-200">
					<img alt="Merchant Profile" class="size-full object-cover"
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuAeQxsUlnzf-vcWAJVJdLNdI8MwNN2zcPo3NwneKrKj3_TFRqVDS_LWm677lv1DGFoOYws499zbTHeinfKqaL-Quh9VnImUXJOOOJYWzP5eKZLFA9NCGC9MKo3UdRFW-ZjjFkSoTFTCpuxZDGYPgD1Q6SROHA7PWvQrQrQyZO2OjS2A-TI-CavjZ0zq8v-YRXq3piVN5C_u5zisyVydg7lRsz5vhUr2NZG4dZw7p-7Zt9sChlyGxPj152G4PDTjgcl43YH5-qrcOo5v" />
				</div>
			</div>
		</header>
		<!-- Page Header -->
		<div class="px-10 py-8 border-b border-slate-200 bg-white">
			<div class="max-w-6xl mx-auto flex items-end justify-between">
				<div>
					<div class="flex items-center gap-2 text-slate-500 mb-2">
						<span class="text-xs font-medium uppercase tracking-widest">Inventory Management</span>
						<span class="material-symbols-outlined text-xs" data-icon="chevron_right">chevron_right</span>
						<span class="text-xs font-medium text-slate-900 uppercase tracking-widest">Add
							Product</span>
					</div>
					<h2 class="text-3xl leading-tight font-bold tracking-tight text-slate-900">Create New Product</h2>
					<p class="text-base font-normal text-slate-500 mt-1">Populate your inventory with a new retail
						entry.</p>
				</div>
				<div class="flex gap-3">
					<button
						class="px-6 py-2.5 border border-slate-300 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 transition-colors">Discard
						Draft</button>
					<button
						class="px-8 py-2.5 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:opacity-90 transition-opacity flex items-center gap-2 shadow-lg shadow-slate-900/10">
						<span class="material-symbols-outlined text-base" data-icon="save">save</span>
						Save Product
					</button>
				</div>
			</div>
		</div>
		<!-- Form Layout: Asymmetric Bento Grid -->
		<div class="p-10 max-w-6xl mx-auto">
			<div class="grid grid-cols-12 gap-8">
				<!-- Main Form Body -->
				<div class="col-span-12 lg:col-span-8 space-y-8">
					<!-- Basic Information Card -->
					<div class="bg-white border border-slate-200 rounded-xl p-8 space-y-6">
						<div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-2">
							<span class="material-symbols-outlined text-slate-600"
								data-icon="description">description</span>
							<h3 class="text-xl leading-snug font-semibold tracking-tight">Product Essentials</h3>
						</div>
						<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
							<div class="md:col-span-2">
								<label class="block text-xs font-medium text-slate-600 mb-2">Product
									Name</label>
								<input
									class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-base font-normal focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
									placeholder="e.g. Premium Leather Weekend Bag" type="text" />
							</div>
							<div>
								<label class="block text-xs font-medium text-slate-600 mb-2">Category</label>
								<select
									class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-base font-normal focus:ring-2 focus:ring-primary focus:border-transparent transition-all">
									<option>Select Category</option>
									<option>Leather Goods</option>
									<option>Accessories</option>
									<option>Travel</option>
									<option>New Arrivals</option>
								</select>
							</div>
							<div>
								<label class="block text-xs font-medium text-slate-600 mb-2">Price (USD)</label>
								<div class="relative">
									<span
										class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">$</span>
									<input
										class="w-full pl-8 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-base font-normal focus:ring-2 focus:ring-primary focus:border-transparent transition-all"
										placeholder="0.00" type="number" />
								</div>
							</div>
						</div>
					</div>
					<!-- Inventory & Details Card -->
					<div class="bg-white border border-slate-200 rounded-xl p-8 space-y-6">
						<div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-2">
							<span class="material-symbols-outlined text-slate-600" data-icon="box">box</span>
							<h3 class="text-xl leading-snug font-semibold tracking-tight">Stock &amp; Logistics</h3>
						</div>
						<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
							<div>
								<label class="block text-xs font-medium text-slate-600 mb-2">SKU</label>
								<input
									class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-base font-normal focus:ring-2 focus:ring-primary transition-all uppercase"
									placeholder="LXR-WB-001" type="text" />
							</div>
							<div>
								<label class="block text-xs font-medium text-slate-600 mb-2">Stock Level</label>
								<input
									class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-base font-normal focus:ring-2 focus:ring-primary transition-all"
									placeholder="0" type="number" />
							</div>
							<div>
								<label class="block text-xs font-medium text-slate-600 mb-2">Weight (kg)</label>
								<input
									class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-base font-normal focus:ring-2 focus:ring-primary transition-all"
									placeholder="1.2" step="0.1" type="number" />
							</div>
						</div>
					</div>
					<!-- SEO Section -->
					<div class="bg-slate-900 border border-slate-800 rounded-xl p-8 space-y-6 text-slate-50">
						<div class="flex items-center gap-3 border-b border-slate-800 pb-4 mb-2">
							<span class="material-symbols-outlined text-slate-700"
								data-icon="search_check">search_check</span>
							<h3 class="text-xl leading-snug font-semibold tracking-tight">Search Optimization</h3>
						</div>
						<div>
							<label class="block text-xs font-medium text-slate-400 mb-2">SEO Title</label>
							<input
								class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-xl text-base font-normal text-white focus:ring-2 focus:ring-tertiary-fixed transition-all placeholder:text-slate-500"
								placeholder="Enter meta title for search engines" type="text" />
						</div>
						<div class="p-4 bg-slate-800 rounded-lg border border-slate-700">
							<p class="text-xs font-bold text-sky-400 mb-1">Search Preview</p>
							<h4 class="text-blue-400 text-lg hover:underline cursor-pointer">MerchFlow | Your Meta
								Title Will Appear Here</h4>
							<p class="text-green-500 text-sm">https://merchflow.com/products/leather-bag</p>
						</div>
					</div>
				</div>
				<!-- Sidebar Form Controls -->
				<div class="col-span-12 lg:col-span-4 space-y-8">
					<!-- Image Upload Empty State -->
					<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
						<div class="p-6 border-b border-slate-100">
							<h3 class="text-sm font-semibold text-slate-900">Product Media</h3>
						</div>
						<div
							class="p-8 flex flex-col items-center justify-center min-h-[300px] bg-slate-50 border-2 border-dashed border-slate-200 m-6 rounded-xl group hover:border-slate-900 transition-colors cursor-pointer">
							<div
								class="size-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4 text-slate-400 group-hover:text-slate-900 transition-colors">
								<span class="material-symbols-outlined text-3xl"
									data-icon="add_a_photo">add_a_photo</span>
							</div>
							<p class="text-sm font-semibold text-slate-900">Upload Media</p>
							<p class="text-xs font-medium text-slate-500 text-center mt-2 px-4 leading-relaxed">
								Drag and drop high-resolution JPG or PNG files. Recommended size 1200x1200px.
							</p>
						</div>
					</div>
					<!-- Visibility Toggle -->
					<div class="bg-white border border-slate-200 rounded-xl p-6">
						<h3 class="text-sm font-semibold text-slate-900 mb-4">Product Status</h3>
						<div class="space-y-4">
							<label
								class="flex items-center justify-between p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
								<div class="flex items-center gap-3">
									<div class="size-2 bg-green-500 rounded-full"></div>
									<span class="text-base font-normal">Published</span>
								</div>
								<input checked class="text-slate-900 focus:ring-primary size-4" name="status"
									type="radio" />
							</label>
							<label
								class="flex items-center justify-between p-3 border border-slate-200 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
								<div class="flex items-center gap-3">
									<div class="size-2 bg-slate-300 rounded-full"></div>
									<span class="text-base font-normal">Draft</span>
								</div>
								<input class="text-slate-900 focus:ring-primary size-4" name="status" type="radio" />
							</label>
						</div>
					</div>
					<!-- Marketing Banner (Contextual Visual) -->
					<div class="relative h-64 rounded-xl overflow-hidden group">
						<img alt="Luxury Retail Concept"
							class="size-full object-cover group-hover:scale-105 transition-transform duration-700"
							data-alt="A studio shot of a vibrant red luxury sneaker positioned against a clean, minimalist white background with sharp, professional commercial lighting. The image captures the texture of the fabric and the sleek design lines, embodying a high-end retail aesthetic that matches a clean, corporate e-commerce user interface. The mood is sophisticated, polished, and emphasizes premium quality."
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuCkhvqDhOpo9R-7Z_w7n8_pREafC8NYzRPxzLE4AEqGyPR0vrXCDCJ-p9nwQ2zz7HTpl0tSlu2ZNgYdODqBAtS0CjR161ICmvS3D-vCsRAWihziXePzrg5zZno0fJ_HFOjg-yISpydc_enEAILW-F-8E1m4KUB8PXyVfX1w6Pr7B-Aaq5TP52qWeufJT9SeHETahZQDp8Vk8Z4PrQkOw74S_WJRHzaQvHxxE-UpnwAEKqM1Ja9xF6hYKH595k_eN7IAZ5CTJehXZwAu" />
						<div
							class="absolute inset-0 bg-linear-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-6">
							<span
								class="text-xs font-medium text-slate-700 bg-slate-100 px-2 py-1 rounded inline-block w-fit mb-2">Merchant
								Tip</span>
							<p class="text-white text-sm font-semibold leading-snug">Product images with natural
								lifestyle settings convert 35% better than plain white backgrounds.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
