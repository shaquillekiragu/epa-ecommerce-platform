<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 flex-1 p-lg max-w-[1600px]">
		<!-- Page Header -->
		<header class="flex justify-between items-end mb-lg">
			<div>
				<h1 class="font-headline-lg text-headline-lg text-on-background mb-sm">Inventory</h1>
				<p class="font-body-md text-body-md text-on-surface-variant">Manage your product catalog, pricing, and
					stock levels.</p>
			</div>
			<!-- Controls -->
			<div class="flex items-center gap-sm">
				<!-- Filter -->
				<button
					class="flex items-center gap-xs px-md py-base bg-surface-container-lowest border border-outline-variant rounded-DEFAULT font-label-md text-label-md text-on-surface hover:bg-surface-container-low transition-colors shadow-sm">
					<span class="material-symbols-outlined text-[18px]">filter_list</span>
					Filter
				</button>
			</div>
		</header>
		<!-- KPI Cards (Bento style) -->
		<div class="grid grid-cols-3 gap-grid_gutter mb-lg">
			<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md shadow-sm">
				<div class="flex justify-between items-start mb-sm">
					<div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total
						Products</div>
					<span class="material-symbols-outlined text-outline">inventory_2</span>
				</div>
				<div class="font-display-lg text-display-lg text-on-surface">1,248</div>
			</div>
			<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md shadow-sm">
				<div class="flex justify-between items-start mb-sm">
					<div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Low Stock
						Alerts</div>
					<span class="material-symbols-outlined text-error">warning</span>
				</div>
				<div class="font-display-lg text-display-lg text-error">12</div>
				<div class="font-label-sm text-label-sm text-on-surface-variant mt-xs">Requires immediate attention
				</div>
			</div>
			<div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md shadow-sm">
				<div class="flex justify-between items-start mb-sm">
					<div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Active
						Listings</div>
					<span class="material-symbols-outlined text-primary">check_circle</span>
				</div>
				<div class="font-display-lg text-display-lg text-on-surface">1,180</div>
				<div class="font-label-sm text-label-sm text-on-surface-variant mt-xs">94.5% of total catalog</div>
			</div>
		</div>
		<!-- DataTable Container -->
		<div class="bg-surface-container-lowest border border-outline-variant rounded-lg shadow-sm overflow-hidden">
			<div class="w-full overflow-x-auto">
				<table class="w-full text-left border-collapse">
					<thead class="bg-surface-container-low border-b border-surface-variant">
						<tr>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant w-[48px]">
								<input class="rounded-sm border-outline text-primary focus:ring-primary h-4 w-4"
									type="checkbox" />
							</th>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">Product Details
							</th>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">SKU</th>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant">Category</th>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-right">Price
							</th>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-right">Stock
							</th>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-center">Live
							</th>
							<th class="px-md py-sm font-label-md text-label-md text-on-surface-variant text-right">
								Actions</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-surface-variant">
						<!-- Row 1 -->
						<tr class="hover:bg-surface-container-highest transition-colors group">
							<td class="px-md py-sm">
								<input class="rounded-sm border-outline text-primary focus:ring-primary h-4 w-4"
									type="checkbox" />
							</td>
							<td class="px-md py-sm">
								<div class="flex items-center gap-sm">
									<div
										class="h-12 w-12 rounded-DEFAULT bg-surface-variant overflow-hidden border border-outline-variant shrink-0">
										<img alt="Minimalist white smartwatch on a clean light grey background, soft studio lighting"
											class="w-full h-full object-cover"
											data-alt="Minimalist white smartwatch on a clean light grey background, soft studio lighting"
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSOAlc3BRD_ZretL7iuDu5W6CP2yWnsWxQXrjJNCN1tsELx4thSWmBN1IMRNx8pBUimGIkdZek40MVQQ0p4SHBpOT42Qmdt61s6QNK2d6D5QZiELe4Nq8hllGthE6eUFka8jau-bauUkUZx-BZkwioMXZMVXGeV1RtzoYt0ZwkhDTBTcK5LFkEqid8Vvn-iBLqzB-igR8d9p7HW8VAT_ITdh0-2QEF7FGNjh61LiWLmriMLau5jWTPqpDpWJP-8VoJnkYwbAPUMorT" />
									</div>
									<div>
										<div class="font-label-md text-label-md text-on-surface">Chronograph Series 7
										</div>
										<div class="font-label-sm text-label-sm text-on-surface-variant">Titanium
											Edition</div>
									</div>
								</div>
							</td>
							<td class="px-md py-sm font-body-md text-body-md text-on-surface-variant">WTCH-700-TIT</td>
							<td class="px-md py-sm">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-surface-container text-on-surface font-label-sm text-label-sm">Accessories</span>
							</td>
							<td class="px-md py-sm font-body-lg text-body-lg text-on-surface font-bold text-right">
								$499.00</td>
							<td class="px-md py-sm text-right">
								<div class="font-body-md text-body-md text-on-surface">45</div>
							</td>
							<td class="px-md py-sm text-center">
								<!-- Toggle Active -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-primary transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block h-4 w-4 translate-x-4 transform rounded-full bg-surface-container-lowest transition-transform"></span>
								</button>
							</td>
							<td class="px-md py-sm text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-on-surface-variant hover:text-primary transition-colors"><span
										class="material-symbols-outlined text-[20px]">edit</span></button>
								<button class="p-1 text-on-surface-variant hover:text-error transition-colors"><span
										class="material-symbols-outlined text-[20px]">delete</span></button>
							</td>
						</tr>
						<!-- Row 2 -->
						<tr class="hover:bg-surface-container-highest transition-colors group">
							<td class="px-md py-sm">
								<input class="rounded-sm border-outline text-primary focus:ring-primary h-4 w-4"
									type="checkbox" />
							</td>
							<td class="px-md py-sm">
								<div class="flex items-center gap-sm">
									<div
										class="h-12 w-12 rounded-DEFAULT bg-surface-variant overflow-hidden border border-outline-variant shrink-0">
										<img alt="Premium leather messenger bag in rich brown, standing upright on a clean surface"
											class="w-full h-full object-cover"
											data-alt="Premium leather messenger bag in rich brown, standing upright on a clean surface"
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOWMoqWdZLcWI-QZy8XV6ToZuf70Ddu79Rkd5O01YxBF1zZDoRGWPYKcIV8RzdaCc2HQURFzmsJQrsd6p3_i3whbFKyGHmsukjNtIChVlXoTDYmdOKbD9zFO6qZVAclkxB9RZZNo4LZ2g-7_E1NGUb5DHKteR0ubtUEIC0qdnC8KH2_kEnkGeUbCsV5k9J7yJTgk10oAxA8gDkn4lcRw_NED_Q4Ecsd35MdEKDDz_Qb5TbtMbs3yzpoH1b2lIsMNmV6qzOCErbRIbq" />
									</div>
									<div>
										<div class="font-label-md text-label-md text-on-surface">Executive Leather
											Briefcase</div>
										<div class="font-label-sm text-label-sm text-on-surface-variant">Saddle Brown
										</div>
									</div>
								</div>
							</td>
							<td class="px-md py-sm font-body-md text-body-md text-on-surface-variant">BAG-EXEC-BRN</td>
							<td class="px-md py-sm">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-surface-container text-on-surface font-label-sm text-label-sm">Bags</span>
							</td>
							<td class="px-md py-sm font-body-lg text-body-lg text-on-surface font-bold text-right">
								$285.00</td>
							<td class="px-md py-sm text-right">
								<div
									class="font-body-md text-body-md text-error font-bold flex items-center justify-end gap-1">
									<span class="material-symbols-outlined text-[16px]">warning</span>
									3
								</div>
							</td>
							<td class="px-md py-sm text-center">
								<!-- Toggle Active -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-primary transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block h-4 w-4 translate-x-4 transform rounded-full bg-surface-container-lowest transition-transform"></span>
								</button>
							</td>
							<td class="px-md py-sm text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-on-surface-variant hover:text-primary transition-colors"><span
										class="material-symbols-outlined text-[20px]">edit</span></button>
								<button class="p-1 text-on-surface-variant hover:text-error transition-colors"><span
										class="material-symbols-outlined text-[20px]">delete</span></button>
							</td>
						</tr>
						<!-- Row 3 -->
						<tr class="hover:bg-surface-container-highest transition-colors group">
							<td class="px-md py-sm">
								<input class="rounded-sm border-outline text-primary focus:ring-primary h-4 w-4"
									type="checkbox" />
							</td>
							<td class="px-md py-sm">
								<div class="flex items-center gap-sm">
									<div
										class="h-12 w-12 rounded-DEFAULT bg-surface-variant overflow-hidden border border-outline-variant shrink-0 flex items-center justify-center">
										<span
											class="material-symbols-outlined text-outline-variant text-[24px]">image_not_supported</span>
									</div>
									<div>
										<div class="font-label-md text-label-md text-on-surface">Minimalist Ceramic Vase
										</div>
										<div class="font-label-sm text-label-sm text-on-surface-variant">Matte Black
										</div>
									</div>
								</div>
							</td>
							<td class="px-md py-sm font-body-md text-body-md text-on-surface-variant">HM-VASE-BLK</td>
							<td class="px-md py-sm">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-surface-container text-on-surface font-label-sm text-label-sm">Home</span>
							</td>
							<td class="px-md py-sm font-body-lg text-body-lg text-on-surface font-bold text-right">
								$65.00</td>
							<td class="px-md py-sm text-right">
								<div class="font-body-md text-body-md text-on-surface">120</div>
							</td>
							<td class="px-md py-sm text-center">
								<!-- Toggle Inactive -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-surface-dim transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block h-4 w-4 translate-x-1 transform rounded-full bg-surface-container-lowest transition-transform"></span>
								</button>
							</td>
							<td class="px-md py-sm text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-on-surface-variant hover:text-primary transition-colors"><span
										class="material-symbols-outlined text-[20px]">edit</span></button>
								<button class="p-1 text-on-surface-variant hover:text-error transition-colors"><span
										class="material-symbols-outlined text-[20px]">delete</span></button>
							</td>
						</tr>
						<!-- Row 4 -->
						<tr class="hover:bg-surface-container-highest transition-colors group">
							<td class="px-md py-sm">
								<input class="rounded-sm border-outline text-primary focus:ring-primary h-4 w-4"
									type="checkbox" />
							</td>
							<td class="px-md py-sm">
								<div class="flex items-center gap-sm">
									<div
										class="h-12 w-12 rounded-DEFAULT bg-surface-variant overflow-hidden border border-outline-variant shrink-0">
										<img alt="Vibrant red athletic sneaker floating against a dark dramatic background"
											class="w-full h-full object-cover"
											data-alt="Vibrant red athletic sneaker floating against a dark dramatic background"
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuCP34elNOEcfebozAKtWBDxGyy43QqF8u45DSJ8-fCtjU_YXN5MpFEmmAqR8T6-fAc0DkPNxppQlNSsZEv1JVmZXr6tMDukBUFJB0Ft9GB64DyBWse5pGgetQNzntZCAqgndHZb7318vfLIV30y3FObrsBwZFN2t6__9PvXhibDn-f7wV1I9h3JxkOvqPTuiLOfX5_cDl7oLdAtKF1ZOHvREWJAZtung4XpzGCF7643Knz2czQqPZ0mmw5TjugnZsA-abUqoDjX6hGL" />
									</div>
									<div>
										<div class="font-label-md text-label-md text-on-surface">AeroRun Pro Sneakers
										</div>
										<div class="font-label-sm text-label-sm text-on-surface-variant">Crimson Red -
											Size 10</div>
									</div>
								</div>
							</td>
							<td class="px-md py-sm font-body-md text-body-md text-on-surface-variant">SHOE-AERO-RD10
							</td>
							<td class="px-md py-sm">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-surface-container text-on-surface font-label-sm text-label-sm">Footwear</span>
							</td>
							<td class="px-md py-sm font-body-lg text-body-lg text-on-surface font-bold text-right">
								$145.00</td>
							<td class="px-md py-sm text-right">
								<div class="font-body-md text-body-md text-on-surface">18</div>
							</td>
							<td class="px-md py-sm text-center">
								<!-- Toggle Active -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-primary transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block h-4 w-4 translate-x-4 transform rounded-full bg-surface-container-lowest transition-transform"></span>
								</button>
							</td>
							<td class="px-md py-sm text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-on-surface-variant hover:text-primary transition-colors"><span
										class="material-symbols-outlined text-[20px]">edit</span></button>
								<button class="p-1 text-on-surface-variant hover:text-error transition-colors"><span
										class="material-symbols-outlined text-[20px]">delete</span></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- Pagination Footer -->
			<div
				class="bg-surface-container-lowest px-md py-sm border-t border-surface-variant flex items-center justify-between">
				<div class="font-body-md text-body-md text-on-surface-variant">
					Showing <span class="font-bold text-on-surface">1</span> to <span
						class="font-bold text-on-surface">4</span> of <span
						class="font-bold text-on-surface">1,248</span> results
				</div>
				<div class="flex items-center gap-2">
					<button
						class="px-3 py-1 border border-outline-variant rounded-DEFAULT text-on-surface-variant hover:bg-surface-container-low transition-colors disabled:opacity-50"
						disabled>Previous</button>
					<button class="px-3 py-1 bg-primary text-on-primary rounded-DEFAULT font-bold">1</button>
					<button
						class="px-3 py-1 border border-outline-variant rounded-DEFAULT text-on-surface hover:bg-surface-container-low transition-colors">2</button>
					<button
						class="px-3 py-1 border border-outline-variant rounded-DEFAULT text-on-surface hover:bg-surface-container-low transition-colors">3</button>
					<span class="text-on-surface-variant px-1">...</span>
					<button
						class="px-3 py-1 border border-outline-variant rounded-DEFAULT text-on-surface hover:bg-surface-container-low transition-colors">Next</button>
				</div>
			</div>
		</div>
	</main>
</template>
