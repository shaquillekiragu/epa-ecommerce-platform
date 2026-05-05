<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 flex-1 p-6 max-w-[1600px]">
		<!-- Page Header -->
		<header class="flex justify-between items-end mb-6">
			<div>
				<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900 mb-2">Inventory</h1>
				<p class="font-normal text-base text-slate-600">Manage your product catalog, pricing, and
					stock levels.</p>
			</div>
			<!-- Controls -->
			<div class="flex items-center gap-2">
				<!-- Filter -->
				<button
					class="flex items-center gap-1 px-4 py-3 bg-white border border-slate-400 rounded-md font-semibold text-sm text-slate-900 hover:bg-slate-50 transition-colors shadow-sm">
					<span class="material-symbols-outlined text-lg">filter_list</span>
					Filter
				</button>
			</div>
		</header>
		<!-- KPI Cards (Bento style) -->
		<div class="grid grid-cols-3 gap-grid_gutter mb-6">
			<div class="bg-white border border-slate-400 rounded-lg p-4 shadow-sm">
				<div class="flex justify-between items-start mb-2">
					<div class="font-medium text-xs text-slate-600 uppercase tracking-wider">Total
						Products</div>
					<span class="material-symbols-outlined text-slate-400">inventory_2</span>
				</div>
				<div class="font-bold tracking-tight text-4xl leading-tight text-slate-900">1,248</div>
			</div>
			<div class="bg-white border border-slate-400 rounded-lg p-4 shadow-sm">
				<div class="flex justify-between items-start mb-2">
					<div class="font-medium text-xs text-slate-600 uppercase tracking-wider">Low Stock
						Alerts</div>
					<span class="material-symbols-outlined text-red-600">warning</span>
				</div>
				<div class="font-bold tracking-tight text-4xl leading-tight text-red-600">12</div>
				<div class="font-medium text-xs text-slate-600 mt-1">Requires immediate attention
				</div>
			</div>
			<div class="bg-white border border-slate-400 rounded-lg p-4 shadow-sm">
				<div class="flex justify-between items-start mb-2">
					<div class="font-medium text-xs text-slate-600 uppercase tracking-wider">Active
						Listings</div>
					<span class="material-symbols-outlined text-slate-900">check_circle</span>
				</div>
				<div class="font-bold tracking-tight text-4xl leading-tight text-slate-900">1,180</div>
				<div class="font-medium text-xs text-slate-600 mt-1">94.5% of total catalog</div>
			</div>
		</div>
		<!-- DataTable Container -->
		<div class="bg-white border border-slate-400 rounded-lg shadow-sm overflow-hidden">
			<div class="w-full overflow-x-auto">
				<table class="w-full text-left border-collapse">
					<thead class="bg-slate-50 border-b border-slate-200">
						<tr>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600 w-[48px]">
								<input class="rounded-sm border-slate-300 text-slate-900 focus:ring-primary size-4"
									type="checkbox" />
							</th>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600">Product Details
							</th>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600">SKU</th>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600">Category</th>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600 text-right">Price
							</th>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600 text-right">Stock
							</th>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600 text-center">Live
							</th>
							<th class="px-4 py-2 font-semibold text-sm text-slate-600 text-right">
								Actions</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-200">
						<!-- Row 1 -->
						<tr class="hover:bg-slate-200 transition-colors group">
							<td class="px-4 py-2">
								<input class="rounded-sm border-slate-300 text-slate-900 focus:ring-primary size-4"
									type="checkbox" />
							</td>
							<td class="px-4 py-2">
								<div class="flex items-center gap-2">
									<div
										class="size-12 rounded-md bg-slate-100 overflow-hidden border border-slate-400 shrink-0">
										<img alt="Minimalist white smartwatch on a clean light grey background, soft studio lighting"
											class="size-full object-cover"
											data-alt="Minimalist white smartwatch on a clean light grey background, soft studio lighting"
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSOAlc3BRD_ZretL7iuDu5W6CP2yWnsWxQXrjJNCN1tsELx4thSWmBN1IMRNx8pBUimGIkdZek40MVQQ0p4SHBpOT42Qmdt61s6QNK2d6D5QZiELe4Nq8hllGthE6eUFka8jau-bauUkUZx-BZkwioMXZMVXGeV1RtzoYt0ZwkhDTBTcK5LFkEqid8Vvn-iBLqzB-igR8d9p7HW8VAT_ITdh0-2QEF7FGNjh61LiWLmriMLau5jWTPqpDpWJP-8VoJnkYwbAPUMorT" />
									</div>
									<div>
										<div class="font-semibold text-sm text-slate-900">Chronograph Series 7
										</div>
										<div class="font-medium text-xs text-slate-600">Titanium
											Edition</div>
									</div>
								</div>
							</td>
							<td class="px-4 py-2 font-normal text-base text-slate-600">WTCH-700-TIT</td>
							<td class="px-4 py-2">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-slate-100 text-slate-900 font-medium text-xs">Accessories</span>
							</td>
							<td class="px-4 py-2 text-lg text-slate-900 font-bold text-right">
								$499.00</td>
							<td class="px-4 py-2 text-right">
								<div class="font-normal text-base text-slate-900">45</div>
							</td>
							<td class="px-4 py-2 text-center">
								<!-- Toggle Active -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-slate-900 transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block size-4 translate-x-4 transform rounded-full bg-white transition-transform"></span>
								</button>
							</td>
							<td class="px-4 py-2 text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-slate-600 hover:text-slate-900 transition-colors"><span
										class="material-symbols-outlined text-xl">edit</span></button>
								<button class="p-1 text-slate-600 hover:text-red-600 transition-colors"><span
										class="material-symbols-outlined text-xl">delete</span></button>
							</td>
						</tr>
						<!-- Row 2 -->
						<tr class="hover:bg-slate-200 transition-colors group">
							<td class="px-4 py-2">
								<input class="rounded-sm border-slate-300 text-slate-900 focus:ring-primary size-4"
									type="checkbox" />
							</td>
							<td class="px-4 py-2">
								<div class="flex items-center gap-2">
									<div
										class="size-12 rounded-md bg-slate-100 overflow-hidden border border-slate-400 shrink-0">
										<img alt="Premium leather messenger bag in rich brown, standing upright on a clean surface"
											class="size-full object-cover"
											data-alt="Premium leather messenger bag in rich brown, standing upright on a clean surface"
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOWMoqWdZLcWI-QZy8XV6ToZuf70Ddu79Rkd5O01YxBF1zZDoRGWPYKcIV8RzdaCc2HQURFzmsJQrsd6p3_i3whbFKyGHmsukjNtIChVlXoTDYmdOKbD9zFO6qZVAclkxB9RZZNo4LZ2g-7_E1NGUb5DHKteR0ubtUEIC0qdnC8KH2_kEnkGeUbCsV5k9J7yJTgk10oAxA8gDkn4lcRw_NED_Q4Ecsd35MdEKDDz_Qb5TbtMbs3yzpoH1b2lIsMNmV6qzOCErbRIbq" />
									</div>
									<div>
										<div class="font-semibold text-sm text-slate-900">Executive Leather
											Briefcase</div>
										<div class="font-medium text-xs text-slate-600">Saddle Brown
										</div>
									</div>
								</div>
							</td>
							<td class="px-4 py-2 font-normal text-base text-slate-600">BAG-EXEC-BRN</td>
							<td class="px-4 py-2">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-slate-100 text-slate-900 font-medium text-xs">Bags</span>
							</td>
							<td class="px-4 py-2 text-lg text-slate-900 font-bold text-right">
								$285.00</td>
							<td class="px-4 py-2 text-right">
								<div
									class="text-base text-red-600 font-bold flex items-center justify-end gap-1">
									<span class="material-symbols-outlined">warning</span>
									3
								</div>
							</td>
							<td class="px-4 py-2 text-center">
								<!-- Toggle Active -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-slate-900 transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block size-4 translate-x-4 transform rounded-full bg-white transition-transform"></span>
								</button>
							</td>
							<td class="px-4 py-2 text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-slate-600 hover:text-slate-900 transition-colors"><span
										class="material-symbols-outlined text-xl">edit</span></button>
								<button class="p-1 text-slate-600 hover:text-red-600 transition-colors"><span
										class="material-symbols-outlined text-xl">delete</span></button>
							</td>
						</tr>
						<!-- Row 3 -->
						<tr class="hover:bg-slate-200 transition-colors group">
							<td class="px-4 py-2">
								<input class="rounded-sm border-slate-300 text-slate-900 focus:ring-primary size-4"
									type="checkbox" />
							</td>
							<td class="px-4 py-2">
								<div class="flex items-center gap-2">
									<div
										class="size-12 rounded-md bg-slate-100 overflow-hidden border border-slate-400 shrink-0 flex items-center justify-center">
										<span
											class="material-symbols-outlined text-slate-500 text-[24px]">image_not_supported</span>
									</div>
									<div>
										<div class="font-semibold text-sm text-slate-900">Minimalist Ceramic Vase
										</div>
										<div class="font-medium text-xs text-slate-600">Matte Black
										</div>
									</div>
								</div>
							</td>
							<td class="px-4 py-2 font-normal text-base text-slate-600">HM-VASE-BLK</td>
							<td class="px-4 py-2">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-slate-100 text-slate-900 font-medium text-xs">Home</span>
							</td>
							<td class="px-4 py-2 text-lg text-slate-900 font-bold text-right">
								$65.00</td>
							<td class="px-4 py-2 text-right">
								<div class="font-normal text-base text-slate-900">120</div>
							</td>
							<td class="px-4 py-2 text-center">
								<!-- Toggle Inactive -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-slate-200 transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block size-4 translate-x-1 transform rounded-full bg-white transition-transform"></span>
								</button>
							</td>
							<td class="px-4 py-2 text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-slate-600 hover:text-slate-900 transition-colors"><span
										class="material-symbols-outlined text-xl">edit</span></button>
								<button class="p-1 text-slate-600 hover:text-red-600 transition-colors"><span
										class="material-symbols-outlined text-xl">delete</span></button>
							</td>
						</tr>
						<!-- Row 4 -->
						<tr class="hover:bg-slate-200 transition-colors group">
							<td class="px-4 py-2">
								<input class="rounded-sm border-slate-300 text-slate-900 focus:ring-primary size-4"
									type="checkbox" />
							</td>
							<td class="px-4 py-2">
								<div class="flex items-center gap-2">
									<div
										class="size-12 rounded-md bg-slate-100 overflow-hidden border border-slate-400 shrink-0">
										<img alt="Vibrant red athletic sneaker floating against a dark dramatic background"
											class="size-full object-cover"
											data-alt="Vibrant red athletic sneaker floating against a dark dramatic background"
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuCP34elNOEcfebozAKtWBDxGyy43QqF8u45DSJ8-fCtjU_YXN5MpFEmmAqR8T6-fAc0DkPNxppQlNSsZEv1JVmZXr6tMDukBUFJB0Ft9GB64DyBWse5pGgetQNzntZCAqgndHZb7318vfLIV30y3FObrsBwZFN2t6__9PvXhibDn-f7wV1I9h3JxkOvqPTuiLOfX5_cDl7oLdAtKF1ZOHvREWJAZtung4XpzGCF7643Knz2czQqPZ0mmw5TjugnZsA-abUqoDjX6hGL" />
									</div>
									<div>
										<div class="font-semibold text-sm text-slate-900">AeroRun Pro Sneakers
										</div>
										<div class="font-medium text-xs text-slate-600">Crimson Red -
											Size 10</div>
									</div>
								</div>
							</td>
							<td class="px-4 py-2 font-normal text-base text-slate-600">SHOE-AERO-RD10
							</td>
							<td class="px-4 py-2">
								<span
									class="inline-flex items-center px-2 py-1 rounded-full bg-slate-100 text-slate-900 font-medium text-xs">Footwear</span>
							</td>
							<td class="px-4 py-2 text-lg text-slate-900 font-bold text-right">
								$145.00</td>
							<td class="px-4 py-2 text-right">
								<div class="font-normal text-base text-slate-900">18</div>
							</td>
							<td class="px-4 py-2 text-center">
								<!-- Toggle Active -->
								<button
									class="relative inline-flex h-5 w-9 items-center rounded-full bg-slate-900 transition-colors focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
									<span
										class="inline-block size-4 translate-x-4 transform rounded-full bg-white transition-transform"></span>
								</button>
							</td>
							<td class="px-4 py-2 text-right opacity-0 group-hover:opacity-100 transition-opacity">
								<button class="p-1 text-slate-600 hover:text-slate-900 transition-colors"><span
										class="material-symbols-outlined text-xl">edit</span></button>
								<button class="p-1 text-slate-600 hover:text-red-600 transition-colors"><span
										class="material-symbols-outlined text-xl">delete</span></button>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<!-- Pagination Footer -->
			<div
				class="bg-white px-4 py-2 border-t border-slate-200 flex items-center justify-between">
				<div class="font-normal text-base text-slate-600">
					Showing <span class="font-bold text-slate-900">1</span> to <span
						class="font-bold text-slate-900">4</span> of <span
						class="font-bold text-slate-900">1,248</span> results
				</div>
				<div class="flex items-center gap-2">
					<button
						class="px-3 py-1 border border-slate-400 rounded-md text-slate-600 hover:bg-slate-50 transition-colors disabled:opacity-50"
						disabled>Previous</button>
					<button class="px-3 py-1 bg-slate-900 text-white rounded-md font-bold">1</button>
					<button
						class="px-3 py-1 border border-slate-400 rounded-md text-slate-900 hover:bg-slate-50 transition-colors">2</button>
					<button
						class="px-3 py-1 border border-slate-400 rounded-md text-slate-900 hover:bg-slate-50 transition-colors">3</button>
					<span class="text-slate-600 px-1">...</span>
					<button
						class="px-3 py-1 border border-slate-400 rounded-md text-slate-900 hover:bg-slate-50 transition-colors">Next</button>
				</div>
			</div>
		</div>
	</main>
</template>
