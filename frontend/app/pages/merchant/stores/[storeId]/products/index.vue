<template>
	<MerchantSidePanelComponent />

	<main class="md:ml-64 pt-20 min-h-screen bg-surface">
		<div class="max-w-[1280px] mx-auto px-6 py-8">
			<!-- Header Section -->
			<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
				<div>
					<nav class="flex text-xs text-slate-500 mb-2 gap-2">
						<span>Stores</span> <span>/</span> <span>Main Store</span> <span>/</span> <span
							class="text-primary font-bold">Products</span>
					</nav>
					<h1 class="font-display-lg text-display-lg text-on-background">Products</h1>
					<p class="text-on-surface-variant font-body-md mt-1">Manage your store's inventory, stock levels,
						and product visibility.</p>
				</div>
				<button
					class="bg-primary-container text-white px-6 py-3 rounded-lg font-bold flex items-center gap-2 active:scale-95 transition-all shadow-md">
					<span class="material-symbols-outlined" data-icon="add_circle">add_circle</span>
					Add New Product
				</button>
			</div>
			<!-- Stats Bar (Bento style) -->
			<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
				<div class="bg-white border border-outline-variant p-4 rounded-xl">
					<p class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Total Products</p>
					<p class="text-headline-lg font-display-lg">1,284</p>
				</div>
				<div class="bg-white border border-outline-variant p-4 rounded-xl">
					<p class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Low Stock Items</p>
					<div class="flex items-center gap-2">
						<p class="text-headline-lg font-display-lg text-error">12</p>
						<span class="material-symbols-outlined text-error" data-icon="warning">warning</span>
					</div>
				</div>
				<div class="bg-white border border-outline-variant p-4 rounded-xl">
					<p class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Out of Stock</p>
					<p class="text-headline-lg font-display-lg">3</p>
				</div>
				<div class="bg-white border border-outline-variant p-4 rounded-xl">
					<p class="text-label-sm text-on-surface-variant uppercase tracking-wider mb-1">Drafts</p>
					<p class="text-headline-lg font-display-lg text-secondary">45</p>
				</div>
			</div>
			<!-- Filter Bar -->
			<div class="bg-white border border-outline-variant rounded-xl p-4 mb-6 shadow-sm">
				<div class="flex flex-col lg:flex-row gap-4">
					<div class="flex flex-wrap items-center gap-3">
						<div class="relative">
							<select
								class="appearance-none bg-surface border-outline-variant border px-4 py-2 pr-10 rounded-md font-label-md text-on-surface-variant outline-none focus:ring-2 focus:ring-primary-container transition-all">
								<option>Category: All</option>
								<option>Electronics</option>
								<option>Apparel</option>
								<option>Home &amp; Living</option>
							</select>
							<span
								class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline"
								data-icon="expand_more">expand_more</span>
						</div>
						<div class="relative">
							<select
								class="appearance-none bg-surface border-outline-variant border px-4 py-2 pr-10 rounded-md font-label-md text-on-surface-variant outline-none focus:ring-2 focus:ring-primary-container transition-all">
								<option>Stock: All</option>
								<option>In Stock</option>
								<option>Low Stock</option>
								<option>Out of Stock</option>
							</select>
							<span
								class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-outline"
								data-icon="expand_more">expand_more</span>
						</div>
						<button
							class="flex items-center gap-2 border border-outline-variant px-4 py-2 rounded-md font-label-md text-on-surface-variant hover:bg-surface-variant transition-colors">
							<span class="material-symbols-outlined" data-icon="filter_list">filter_list</span>
							More Filters
						</button>
					</div>
				</div>
			</div>
			<!-- Inventory Data Table -->
			<div class="bg-white border border-outline-variant rounded-xl overflow-hidden shadow-sm">
				<div class="overflow-x-auto">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="bg-slate-50 border-b border-outline-variant">
								<th class="p-4 w-10">
									<input
										class="rounded border-outline-variant text-primary-container focus:ring-primary-container"
										type="checkbox" />
								</th>
								<th class="p-4 text-label-md text-on-surface-variant uppercase tracking-wider">Product
								</th>
								<th class="p-4 text-label-md text-on-surface-variant uppercase tracking-wider">SKU</th>
								<th class="p-4 text-label-md text-on-surface-variant uppercase tracking-wider">Category
								</th>
								<th class="p-4 text-label-md text-on-surface-variant uppercase tracking-wider">Price
								</th>
								<th class="p-4 text-label-md text-on-surface-variant uppercase tracking-wider">Stock
								</th>
								<th class="p-4 text-label-md text-on-surface-variant uppercase tracking-wider">Status
								</th>
								<th class="p-4 text-label-md text-on-surface-variant uppercase tracking-wider">
									Visibility</th>
								<th class="p-4 text-right"></th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-100">
							<!-- Product Row 1 -->
							<tr class="hover:bg-slate-50 transition-colors group">
								<td class="p-4">
									<input
										class="rounded border-outline-variant text-primary-container focus:ring-primary-container"
										type="checkbox" />
								</td>
								<td class="p-4">
									<div class="flex items-center gap-3">
										<div
											class="w-12 h-12 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
											<img class="w-full h-full object-cover"
												data-alt="A clean studio product shot of a minimalist white ceramic watch on a neutral background. The lighting is soft and high-key, emphasizing smooth textures and sharp geometric lines. The aesthetic is contemporary, premium, and aligns with a professional e-commerce dashboard. The focus is sharp on the watch face with a shallow depth of field."
												src="https://lh3.googleusercontent.com/aida-public/AB6AXuDwVsJsDyB0dPZeICKdEaXy5FWF0L7P8i0J8cjT18spWWAlJr3y865EHehk0yxhFRgQ6ukr-8Y_nAwmgScivbFU_jfYuE1lyH1qKCbnlHijO_KiXqcZDYDhd0E8aS4nL5ksY74cFX8kRTM0BIDKRLQn6Rahh3gV3Ks-im8jWJZ7Jg9s1rP4WhkpyrSTGD4AijZ643wRgm6gE6do6ov9Pws8xHwE6ig4OAT9ra4PZAQvYuVSGHHBhFD26awqmwBk-BjS5W9X2dKHTIzZ" />
										</div>
										<div>
											<p class="font-body-md font-bold text-on-background">Luxe Chronograph Series
												X</p>
											<p class="text-xs text-on-surface-variant">Last updated 2h ago</p>
										</div>
									</div>
								</td>
								<td class="p-4 font-label-md text-on-surface-variant">LXC-982-WHT</td>
								<td class="p-4">
									<span
										class="bg-secondary-fixed text-on-secondary-fixed px-2 py-1 rounded-full text-xs font-bold uppercase tracking-tight">Electronics</span>
								</td>
								<td class="p-4 font-body-md font-bold text-primary">£249.99</td>
								<td class="p-4">
									<div class="flex items-center gap-2">
										<div class="w-24 bg-slate-100 h-1.5 rounded-full overflow-hidden">
											<div class="bg-primary h-full" style="width: 85%"></div>
										</div>
										<span class="text-xs font-bold">142</span>
									</div>
								</td>
								<td class="p-4">
									<span class="flex items-center gap-1.5 text-xs font-bold text-green-600">
										<span class="w-2 h-2 rounded-full bg-green-500"></span>
										Active
									</span>
								</td>
								<td class="p-4">
									<div class="relative inline-block w-10 align-middle select-none">
										<input checked
											class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer right-0 border-primary-container"
											type="checkbox" />
										<label
											class="toggle-label block overflow-hidden h-5 rounded-full bg-primary-container cursor-pointer"></label>
									</div>
								</td>
								<td class="p-4 text-right">
									<button class="p-2 hover:bg-slate-200 rounded-full transition-colors">
										<span class="material-symbols-outlined text-outline"
											data-icon="more_vert">more_vert</span>
									</button>
								</td>
							</tr>
							<!-- Product Row 2 (Low Stock Warning) -->
							<tr class="hover:bg-slate-50 transition-colors group">
								<td class="p-4">
									<input
										class="rounded border-outline-variant text-primary-container focus:ring-primary-container"
										type="checkbox" />
								</td>
								<td class="p-4">
									<div class="flex items-center gap-3">
										<div
											class="w-12 h-12 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
											<img class="w-full h-full object-cover"
												data-alt="Vibrant red performance sneakers photographed in a professional studio setting with dramatic side lighting. The background is a clean, dark grey that makes the primary red color pop intensely. The product detail is crisp, showing the texture of the fabric and the sleek sole design. The overall mood is energetic and high-performance."
												src="https://lh3.googleusercontent.com/aida-public/AB6AXuDw1j3nphiR7A08NjuyH_GGv8YtqfTm8rivAVbhhv7h87ymnlebDXLqZtaty2bLYGXrxK-C9QMlHCzoz8yCK5ABxYzpffJUKEt-3kWUt7yly3KnXsn-rRNqBe-e858NtgyB18-NtglIDWnjk5_wlfYQ9u5-q4KfYXExC-dZzEjaNn8KjxoTlOH4Ct5hEb86hvPfv5oOzwI-MBJgPmxeVDHjQUC9p5_pN8nX9UMkMLu6WCFRa2q8YTFU9CYJPVe-Om3KyPc19P_ka0C5" />
										</div>
										<div>
											<p class="font-body-md font-bold text-on-background">Apex Runner Red Edition
											</p>
											<p class="text-xs text-on-surface-variant">Last updated 5h ago</p>
										</div>
									</div>
								</td>
								<td class="p-4 font-label-md text-on-surface-variant">RUN-551-RED</td>
								<td class="p-4">
									<span
										class="bg-secondary-fixed text-on-secondary-fixed px-2 py-1 rounded-full text-xs font-bold uppercase tracking-tight">Apparel</span>
								</td>
								<td class="p-4 font-body-md font-bold text-primary">£85.00</td>
								<td class="p-4">
									<div class="flex items-center gap-2">
										<div class="w-24 bg-slate-100 h-1.5 rounded-full overflow-hidden">
											<div class="bg-error h-full" style="width: 8%"></div>
										</div>
										<span class="text-xs font-bold text-error">8</span>
										<span class="material-symbols-outlined text-error text-xs"
											data-icon="error_outline">error_outline</span>
									</div>
								</td>
								<td class="p-4">
									<span class="flex items-center gap-1.5 text-xs font-bold text-amber-600">
										<span class="w-2 h-2 rounded-full bg-amber-500"></span>
										Low Stock
									</span>
								</td>
								<td class="p-4">
									<div class="relative inline-block w-10 align-middle select-none">
										<input checked
											class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer right-0 border-primary-container"
											type="checkbox" />
										<label
											class="toggle-label block overflow-hidden h-5 rounded-full bg-primary-container cursor-pointer"></label>
									</div>
								</td>
								<td class="p-4 text-right">
									<button class="p-2 hover:bg-slate-200 rounded-full transition-colors">
										<span class="material-symbols-outlined text-outline"
											data-icon="more_vert">more_vert</span>
									</button>
								</td>
							</tr>
							<!-- Product Row 3 -->
							<tr class="hover:bg-slate-50 transition-colors group">
								<td class="p-4">
									<input
										class="rounded border-outline-variant text-primary-container focus:ring-primary-container"
										type="checkbox" />
								</td>
								<td class="p-4">
									<div class="flex items-center gap-3">
										<div
											class="w-12 h-12 rounded bg-slate-100 flex-shrink-0 overflow-hidden border border-slate-200">
											<img class="w-full h-full object-cover"
												data-alt="High-fidelity black wireless headphones positioned against a minimalist grey background. The professional studio lighting creates subtle highlights on the metallic and leather surfaces, emphasizing the high-end build quality. The aesthetic is sleek, corporate, and focuses on technological excellence and comfort."
												src="https://lh3.googleusercontent.com/aida-public/AB6AXuAj8RTXlZq3x3ohoSRomQaSQKr3T6Ca3a2nSRCqPoOcF5TX_JAq-j0vLlHY8OqYVRrfG20USL3FlMUMrD16VGrwoPSUF7RRnTvTxnkMzctWl-Qxp4HbgASu2-bdTki_G1fQHJWH19jmK98Qy9HftOaWZJQvxk7lgKwBLDS5TknNQYzdD_r8TJnGrSfavrF4vcaGh52s0wgaEuBmfOVyojLXQ4xXYqrxKHRMGi0P5nuI63MwNsUWaGLbCaAW9T-tBrzIuXTdwwYjIKtN" />
										</div>
										<div>
											<p class="font-body-md font-bold text-on-background">Sonic Pro Over-Ear</p>
											<p class="text-xs text-on-surface-variant">Last updated 1d ago</p>
										</div>
									</div>
								</td>
								<td class="p-4 font-label-md text-on-surface-variant">SNC-001-BLK</td>
								<td class="p-4">
									<span
										class="bg-secondary-fixed text-on-secondary-fixed px-2 py-1 rounded-full text-xs font-bold uppercase tracking-tight">Electronics</span>
								</td>
								<td class="p-4 font-body-md font-bold text-primary">£189.50</td>
								<td class="p-4">
									<div class="flex items-center gap-2">
										<div class="w-24 bg-slate-100 h-1.5 rounded-full overflow-hidden">
											<div class="bg-primary h-full" style="width: 42%"></div>
										</div>
										<span class="text-xs font-bold">42</span>
									</div>
								</td>
								<td class="p-4">
									<span class="flex items-center gap-1.5 text-xs font-bold text-green-600">
										<span class="w-2 h-2 rounded-full bg-green-500"></span>
										Active
									</span>
								</td>
								<td class="p-4">
									<div class="relative inline-block w-10 align-middle select-none">
										<input checked
											class="toggle-checkbox absolute block w-5 h-5 rounded-full bg-white border-4 appearance-none cursor-pointer right-0 border-primary-container"
											type="checkbox" />
										<label
											class="toggle-label block overflow-hidden h-5 rounded-full bg-primary-container cursor-pointer"></label>
									</div>
								</td>
								<td class="p-4 text-right">
									<button class="p-2 hover:bg-slate-200 rounded-full transition-colors">
										<span class="material-symbols-outlined text-outline"
											data-icon="more_vert">more_vert</span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- Pagination -->
				<div
					class="p-4 flex flex-col md:flex-row items-center justify-between border-t border-slate-100 bg-slate-50 gap-4">
					<p class="text-xs text-on-surface-variant font-medium">Showing 1 to 10 of 1,284 results</p>
					<div class="flex items-center gap-2">
						<button
							class="px-3 py-1 border border-outline-variant rounded-md text-xs font-bold bg-white hover:bg-surface-variant transition-colors disabled:opacity-50"
							disabled>Previous</button>
						<button
							class="px-3 py-1 border border-primary-container rounded-md text-xs font-bold bg-primary-container text-white">1</button>
						<button
							class="px-3 py-1 border border-outline-variant rounded-md text-xs font-bold bg-white hover:bg-surface-variant transition-colors">2</button>
						<button
							class="px-3 py-1 border border-outline-variant rounded-md text-xs font-bold bg-white hover:bg-surface-variant transition-colors">3</button>
						<span class="text-xs">...</span>
						<button
							class="px-3 py-1 border border-outline-variant rounded-md text-xs font-bold bg-white hover:bg-surface-variant transition-colors">129</button>
						<button
							class="px-3 py-1 border border-outline-variant rounded-md text-xs font-bold bg-white hover:bg-surface-variant transition-colors">Next</button>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
