<template>
	<main class="min-h-screen w-full pb-16 pt-24">
		<!-- TopAppBar -->
		<header
			class="flex justify-between items-center h-16 px-6 w-full sticky top-0 bg-white border-b border-slate-200 z-40">
			<div class="flex items-center gap-4">
				<span class="material-symbols-outlined text-slate-500 cursor-pointer"
					data-icon="arrow_back">arrow_back</span>
				<div class="text-xl font-bold text-slate-900 tracking-tight">MerchFlow</div>
			</div>
			<div class="flex items-center gap-4">
				<span
					class="material-symbols-outlined text-slate-600 cursor-pointer hover:bg-slate-50 p-2 rounded-full transition-colors"
					data-icon="notifications">notifications</span>
				<span
					class="material-symbols-outlined text-slate-600 cursor-pointer hover:bg-slate-50 p-2 rounded-full transition-colors"
					data-icon="settings">settings</span>
				<img alt="Merchant Profile" class="size-8 rounded-full border border-slate-200"
					data-alt="A professional headshot of a middle-aged merchant with a friendly expression, set against a blurred office background. The lighting is bright and clean, emphasizing a corporate and trustworthy aesthetic. The image features high contrast with natural skin tones and a minimalist composition."
					src="https://lh3.googleusercontent.com/aida-public/AB6AXuD3mmh9SuMl1xwD_2o2o-EkxHu8QFn75ViLccU-0EgWew5gEvbOtH5ZcErmU_sN9SkMhKB0Ytb4S0O5PQY-GUFKRzdllvWUj9b8BOWZPHbq19H0_dePI46SLiv21IS0utkvinCeCuxxkQQYinjr4lqIVH5tEo6Sls3E7Dtm9fiNzXuM2rDwlj2vC4gitJaX1h83hFiXVL6CA7dd8DUjJHhwwKNizo80iQoUW6SP1QebFORaUj14GjMdqsfhBezv8BIkR5AuCEqMg-Nd" />
			</div>
		</header>
		<!-- Stage Container -->
		<div class="p-8 max-w-7xl mx-auto">
			<!-- Product Header Section -->
			<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
				<div>
					<div class="flex items-center gap-3 mb-1">
						<h2 class="font-bold tracking-tight text-3xl leading-tight text-slate-900">Aura Studio Headphones</h2>
						<span
							class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full flex items-center gap-1">
							<span class="size-1.5 bg-green-600 rounded-full"></span>
							Live
						</span>
					</div>
					<p class="text-slate-500 font-normal">Category: Premium Audio / Wireless Over-Ear</p>
				</div>
				<div class="flex gap-3">
					<button
						class="px-4 py-2 border border-slate-200 bg-white text-slate-700 font-semibold rounded-lg flex items-center gap-2 hover:bg-slate-50 transition-colors">
						<span class="material-symbols-outlined text-sm" data-icon="visibility_off">visibility_off</span>
						Hide Product
					</button>
					<button
						class="px-6 py-2 bg-slate-900 text-white font-semibold rounded-lg flex items-center gap-2 hover:opacity-90 active:opacity-100 transition-opacity">
						<span class="material-symbols-outlined text-sm" data-icon="edit">edit</span>
						Edit Product
					</button>
				</div>
			</div>
			<!-- Bento Layout Grid -->
			<div class="grid grid-cols-12 gap-6">
				<!-- Main Preview Card -->
				<div class="col-span-12 lg:col-span-8 space-y-6">
					<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
						<div class="aspect-video w-full bg-slate-100 relative">
							<img alt="Product Thumbnail" class="size-full object-cover"
								data-alt="A premium pair of matte black studio headphones placed on a minimalist wooden surface with soft, directional lighting. The background is a clean, neutral grey that enhances the sleek curves and high-end materials of the audio equipment. The overall mood is sophisticated and modern, mirroring a high-end commercial photography style for luxury technology."
								src="https://lh3.googleusercontent.com/aida-public/AB6AXuCZLj9bNLJUvpnZnLY6Bgiq86rRGjK2VVcSLZClJOge_S2Tv5zAzuLmRDTpKQShlBcVLq36KuSPdFBATFtnxSk-PjSJ0leE6Owci32IethpNSvKmsNr8NPz8IDGWLk0G-oZyHeRSez5nwhrCs9EahKl7rahi6QvJIJaD9lz2wVuU70P3yO04cfz3B1CrwCqc5XXYztfBlYHRlIFQ5UJnkLbIZEiJQdQGrzFuXRGFX3dS_RZAf_bYUcghps7XFODtiEy7irhvzTRXkmH" />
							<div class="absolute top-4 left-4">
								<button class="bg-white/90 backdrop-blur p-2 rounded-full shadow-sm">
									<span class="material-symbols-outlined text-slate-900"
										data-icon="zoom_in">zoom_in</span>
								</button>
							</div>
						</div>
						<div class="p-6">
							<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-4">Product Description</h3>
							<p class="text-slate-600 font-normal leading-relaxed">
								Engineered for the purist, the Aura Studio Headphones deliver uncompromising sonic
								clarity and an expansive soundstage. Featuring custom 40mm drivers and active noise
								cancellation, these headphones are the pinnacle of our merchant collection. The
								minimalist design is complemented by memory foam cushions and a lightweight frame for
								all-day comfort.
							</p>
						</div>
					</div>
					<!-- SEO & Metadata Section -->
					<div class="bg-white border border-slate-200 rounded-xl p-6">
						<div class="flex items-center justify-between mb-6">
							<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">SEO Metadata</h3>
							<span class="material-symbols-outlined text-slate-400" data-icon="info">info</span>
						</div>
						<div class="space-y-4">
							<div>
								<label class="block font-semibold text-sm text-slate-500 mb-2">Meta Title</label>
								<div
									class="p-3 bg-slate-50 rounded border border-slate-100 font-normal text-slate-800">
									Aura Studio Headphones | High-Fidelity Wireless Audio | MerchFlow
								</div>
							</div>
							<div>
								<label class="block font-semibold text-sm text-slate-500 mb-2">Meta
									Description</label>
								<div
									class="p-3 bg-slate-50 rounded border border-slate-100 font-normal text-slate-600">
									Experience pure sound with the Aura Studio Headphones. Featuring 40mm drivers,
									active noise cancellation, and 40-hour battery life. Shop now at MerchFlow.
								</div>
							</div>
							<div class="flex gap-4">
								<div class="flex-1">
									<label class="block font-semibold text-sm text-slate-500 mb-2">Slug</label>
									<div
										class="p-3 bg-slate-50 rounded border border-slate-100 font-normal text-slate-900">
										/products/aura-studio-headphones-v1
									</div>
								</div>
								<div class="flex-1">
									<label class="block font-semibold text-sm text-slate-500 mb-2">Tags</label>
									<div class="flex flex-wrap gap-2">
										<span
											class="px-2 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded">Audio</span>
										<span
											class="px-2 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded">Premium</span>
										<span
											class="px-2 py-1 bg-slate-200 text-slate-700 text-xs font-semibold rounded">Wireless</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Side Panels -->
				<div class="col-span-12 lg:col-span-4 space-y-6">
					<!-- Inventory & Pricing -->
					<div class="bg-white border border-slate-200 rounded-xl p-6">
						<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900 mb-6">Inventory Status</h3>
						<div class="space-y-6">
							<div class="flex justify-between items-end pb-4 border-b border-slate-100">
								<div>
									<p class="font-medium text-xs text-slate-500 mb-1">Current Stock</p>
									<p class="font-bold tracking-tight text-4xl leading-tight text-slate-900">1,248</p>
								</div>
								<div class="text-right">
									<p
										class="font-medium text-xs text-green-600 mb-1 flex items-center justify-end">
										<span class="material-symbols-outlined text-xs mr-1"
											data-icon="trending_up">trending_up</span>
										+12%
									</p>
									<p class="font-normal text-slate-500">Units / Month</p>
								</div>
							</div>
							<div class="grid grid-cols-2 gap-4">
								<div>
									<p class="font-medium text-xs text-slate-500 mb-1 uppercase tracking-wider">
										SKU</p>
									<p class="font-normal text-lg text-slate-900 font-bold">LX-ASH-001</p>
								</div>
								<div>
									<p class="font-medium text-xs text-slate-500 mb-1 uppercase tracking-wider">
										Price</p>
									<p class="font-normal text-lg text-slate-900 font-bold">$349.00</p>
								</div>
							</div>
							<div>
								<div class="flex justify-between mb-2">
									<span class="font-semibold text-sm text-slate-700">Stock Threshold</span>
									<span class="font-semibold text-sm text-slate-900 font-bold">Low (100)</span>
								</div>
								<div class="w-full bg-slate-100 h-2 rounded-full">
									<div class="bg-slate-900 h-2 rounded-full" style="width: 85%"></div>
								</div>
							</div>
						</div>
					</div>
					<!-- Quick Actions / Details -->
					<div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
						<div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
							<h3 class="font-semibold text-sm text-slate-900">Distribution Channels</h3>
						</div>
						<div class="p-6 space-y-4">
							<div class="flex items-center justify-between">
								<div class="flex items-center gap-3">
									<span class="material-symbols-outlined text-slate-400"
										data-icon="public">public</span>
									<span class="font-normal text-slate-700">Online Store</span>
								</div>
								<span class="material-symbols-outlined text-green-500" data-icon="check_circle"
									data-weight="fill">check_circle</span>
							</div>
							<div class="flex items-center justify-between">
								<div class="flex items-center gap-3">
									<span class="material-symbols-outlined text-slate-400"
										data-icon="shopping_bag">shopping_bag</span>
									<span class="font-normal text-slate-700">Mobile App</span>
								</div>
								<span class="material-symbols-outlined text-green-500" data-icon="check_circle"
									data-weight="fill">check_circle</span>
							</div>
							<div class="flex items-center justify-between">
								<div class="flex items-center gap-3">
									<span class="material-symbols-outlined text-slate-400" data-icon="hub">hub</span>
									<span class="font-normal text-slate-700">Marketplaces</span>
								</div>
								<span class="material-symbols-outlined text-slate-300"
									data-icon="radio_button_unchecked">radio_button_unchecked</span>
							</div>
						</div>
					</div>
					<!-- Audit Trail Card -->
					<div class="bg-white border border-slate-200 rounded-xl p-6">
						<h3 class="font-semibold text-sm text-slate-900 mb-4 uppercase tracking-widest">Last
							Activity</h3>
						<div class="space-y-4">
							<div class="flex gap-3">
								<div class="size-2 rounded-full bg-slate-300 mt-1.5 shrink-0"></div>
								<div>
									<p class="font-medium text-xs text-slate-800">Inventory count updated</p>
									<p class="text-[10px] text-slate-400">2 hours ago • Warehouse A</p>
								</div>
							</div>
							<div class="flex gap-3">
								<div class="size-2 rounded-full bg-slate-300 mt-1.5 shrink-0"></div>
								<div>
									<p class="font-medium text-xs text-slate-800">Price changed from $329 to
										$349</p>
									<p class="text-[10px] text-slate-400">Yesterday • Admin User</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
