<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 min-h-screen">
		<!-- TopAppBar -->
		<header
			class="bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-50 font-manrope antialiased border-b border-slate-200 dark:border-slate-800 flex justify-between items-center h-16 px-6 w-full sticky top-0 z-40">
			<div class="flex items-center">
				<span class="text-xl font-bold text-slate-900 dark:text-slate-50 tracking-tight mr-8">LuxCommerce</span>
			</div>
			<div class="flex items-center gap-4">
				<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors">
					<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
				</button>
				<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors">
					<span class="material-symbols-outlined" data-icon="settings">settings</span>
				</button>
				<div class="h-8 w-8 rounded-full overflow-hidden border border-slate-200 ml-2">
					<img alt="Merchant Profile" class="h-full w-full object-cover"
						data-alt="A professional close-up headshot of a boutique store owner in a minimalist, high-end office environment. The lighting is soft and flattering, emphasizing a clean and corporate aesthetic. The background features muted tones of slate and white, maintaining a professional commerce management atmosphere."
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuAE-LVh__7Uo_zCkTxblfEH_J22hJU1NF8cUI5N4YlG0LscNbMlqN4uI8RZhQchMqvgVtxOpGSbwKObzDXLFi0dj_zKiEqgg3hmnLcw8yyqk7lR_PzEgxQNwMR--_MSzY014PAbCpnqAkxIGnoWnSpQGoL3l-phPGwdWNFIIS6pQx3DfYT5yyljLTaBiDzsRYpalJIgnLRopNMKYO3AU4XsboJVEEtGBuceBTf_L7eRN9P3tIWxExPCo_lAD5dN7xdxV8olR1I6kMiw" />
				</div>
			</div>
		</header>
		<!-- Content Canvas -->
		<div class="p-8 max-w-7xl mx-auto">
			<!-- Breadcrumbs & Header -->
			<div class="mb-8">
				<div class="flex items-center text-xs text-slate-500 font-medium space-x-2 mb-3">
					<span>My Stores</span>
					<span class="material-symbols-outlined text-[10px]" data-icon="chevron_right">chevron_right</span>
					<span class="text-slate-900 font-semibold">Velvet &amp; Vine</span>
				</div>
				<div class="flex justify-between items-end">
					<div>
						<h2 class="font-bold tracking-tight text-slate-900">Velvet &amp; Vine</h2>
						<p class="text-slate-500 font-normal mt-1">Premium artisanal home decor and floral
							arrangements.</p>
						<div class="flex items-center mt-3 gap-4">
							<span
								class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
								<span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
								Active
							</span>
							<span class="text-sm font-semibold text-slate-600 flex items-center">
								<span class="material-symbols-outlined text-sm mr-1" data-icon="link">link</span>
								velvet-vine-premium.luxcommerce.io
							</span>
						</div>
					</div>
					<div class="flex gap-3">
						<button
							class="px-4 py-2 border border-slate-200 bg-white hover:bg-slate-50 text-slate-900 font-semibold rounded-xl transition-all">
							View Live Store
						</button>
						<button
							class="px-4 py-2 bg-slate-900 text-white font-semibold rounded-xl hover:opacity-90 transition-all flex items-center">
							<span class="material-symbols-outlined text-sm mr-2" data-icon="edit">edit</span>
							Edit Details
						</button>
					</div>
				</div>
			</div>
			<!-- Stats Grid -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
				<!-- Stat Card 1 -->
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
					<div class="flex items-center justify-between mb-4">
						<div class="p-2 bg-slate-100 rounded-lg">
							<span class="material-symbols-outlined text-slate-600" data-icon="payments">payments</span>
						</div>
						<span class="text-green-600 text-xs font-bold flex items-center">
							+12.5% <span class="material-symbols-outlined text-xs ml-0.5"
								data-icon="trending_up">trending_up</span>
						</span>
					</div>
					<p class="text-slate-500 text-xs uppercase tracking-wider mb-1">Total Sales</p>
					<h3 class="font-bold tracking-tight text-3xl">$42,912.00</h3>
				</div>
				<!-- Stat Card 2 -->
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
					<div class="flex items-center justify-between mb-4">
						<div class="p-2 bg-slate-100 rounded-lg">
							<span class="material-symbols-outlined text-slate-600"
								data-icon="inventory_2">inventory_2</span>
						</div>
					</div>
					<p class="text-slate-500 text-xs uppercase tracking-wider mb-1">Active Products</p>
					<h3 class="font-bold tracking-tight text-3xl">124</h3>
				</div>
				<!-- Stat Card 3 -->
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
					<div class="flex items-center justify-between mb-4">
						<div class="p-2 bg-slate-100 rounded-lg">
							<span class="material-symbols-outlined text-slate-600" data-icon="star">star</span>
						</div>
						<span class="text-slate-400 text-xs font-medium">84 reviews</span>
					</div>
					<p class="text-slate-500 text-xs uppercase tracking-wider mb-1">Store Rating</p>
					<div class="flex items-end gap-2">
						<h3 class="font-bold tracking-tight text-3xl">4.9</h3>
						<div class="flex text-amber-400 mb-1.5">
							<span class="material-symbols-outlined text-sm" data-weight="fill">star</span>
							<span class="material-symbols-outlined text-sm" data-weight="fill">star</span>
							<span class="material-symbols-outlined text-sm" data-weight="fill">star</span>
							<span class="material-symbols-outlined text-sm" data-weight="fill">star</span>
							<span class="material-symbols-outlined text-sm" data-weight="fill">star</span>
						</div>
					</div>
				</div>
				<!-- Stat Card 4 -->
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
					<div class="flex items-center justify-between mb-4">
						<div class="p-2 bg-slate-100 rounded-lg">
							<span class="material-symbols-outlined text-slate-600" data-icon="group">group</span>
						</div>
						<span class="text-green-600 text-xs font-bold flex items-center">
							+4% <span class="material-symbols-outlined text-xs ml-0.5"
								data-icon="trending_up">trending_up</span>
						</span>
					</div>
					<p class="text-slate-500 text-xs uppercase tracking-wider mb-1">Total Customers</p>
					<h3 class="font-bold tracking-tight text-3xl">1,208</h3>
				</div>
			</div>
			<!-- Main Layout Bento -->
			<div class="grid grid-cols-12 gap-6">
				<!-- Quick Management Column -->
				<div class="col-span-12 lg:col-span-8 space-y-6">
					<!-- Recent Orders -->
					<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
						<div class="p-6 border-b border-slate-100 flex justify-between items-center">
							<h4 class="font-semibold tracking-tight text-lg">Recent Orders</h4>
							<button class="text-slate-900 font-semibold text-sm hover:underline">View All Orders</button>
						</div>
						<div class="overflow-x-auto">
							<table class="w-full text-left border-collapse">
								<thead class="bg-slate-50 border-b border-slate-100">
									<tr>
										<th class="px-6 py-4 font-semibold text-slate-500 text-xs uppercase">Order ID
										</th>
										<th class="px-6 py-4 font-semibold text-slate-500 text-xs uppercase">Customer
										</th>
										<th class="px-6 py-4 font-semibold text-slate-500 text-xs uppercase">Date</th>
										<th class="px-6 py-4 font-semibold text-slate-500 text-xs uppercase">Total</th>
										<th class="px-6 py-4 font-semibold text-slate-500 text-xs uppercase">Status</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-slate-100">
									<tr class="hover:bg-slate-50/50 transition-colors cursor-pointer">
										<td class="px-6 py-4 text-sm font-semibold text-slate-900">#ORD-2918</td>
										<td class="px-6 py-4 text-sm text-slate-600">Marcus Sterling</td>
										<td class="px-6 py-4 text-sm text-slate-500">Oct 24, 2023</td>
										<td class="px-6 py-4 text-sm font-bold text-slate-900">$249.00</td>
										<td class="px-6 py-4">
											<span
												class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Processing</span>
										</td>
									</tr>
									<tr class="hover:bg-slate-50/50 transition-colors cursor-pointer">
										<td class="px-6 py-4 text-sm font-semibold text-slate-900">#ORD-2917</td>
										<td class="px-6 py-4 text-sm text-slate-600">Sarah Jenkins</td>
										<td class="px-6 py-4 text-sm text-slate-500">Oct 24, 2023</td>
										<td class="px-6 py-4 text-sm font-bold text-slate-900">$89.50</td>
										<td class="px-6 py-4">
											<span
												class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Shipped</span>
										</td>
									</tr>
									<tr class="hover:bg-slate-50/50 transition-colors cursor-pointer">
										<td class="px-6 py-4 text-sm font-semibold text-slate-900">#ORD-2916</td>
										<td class="px-6 py-4 text-sm text-slate-600">Elena Rodriguez</td>
										<td class="px-6 py-4 text-sm text-slate-500">Oct 23, 2023</td>
										<td class="px-6 py-4 text-sm font-bold text-slate-900">$1,120.00</td>
										<td class="px-6 py-4">
											<span
												class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Shipped</span>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<!-- Store Image & Style Preview -->
					<div
						class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm grid grid-cols-1 md:grid-cols-2">
						<div class="h-64 relative overflow-hidden">
							<img alt="Store Interior" class="h-full w-full object-cover"
								data-alt="A sophisticated retail showroom interior showcasing artisanal furniture and minimalist lighting. The space is curated with high-end materials like dark wood, textured linens, and warm ambient spotlights. The atmosphere is quiet, elegant, and modern, reflecting a premium merchant aesthetic."
								src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-GSSGtTwecH5ziiSHNSjghVTvRfOOEFR8MrwEB9cfpWWUfCK4E-wblq-AeD0GHar1yjcFc2XSVZM1fdhskS8oTvEBUAin1iKr8eY_eoGRJ52hBqcC6Y8m8n310CQaqvLzcD1vufZsdOHujnhq7P5cMBKvf6CeT_9BqPj9EDWGZaJeezI1t3hCF5J50A_YfQhimzjkYtCPOf-7T3roF_HGXUOnqzl2oFlpsxv6mxlQa0MFJIIONCl-Sf9tBc_AlwMTo46btmIck0Ql" />
							<div
								class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
								<span class="text-white font-semibold text-sm">Storefront Aesthetic: Nordic
									Minimal</span>
							</div>
						</div>
						<div class="p-8 flex flex-col justify-center">
							<h4 class="font-semibold tracking-tight text-lg mb-2">Store Branding</h4>
							<p class="text-slate-500 text-sm mb-6 font-normal leading-relaxed">Your store currently
								uses the "Nordic Lux" theme. This maintains a clean, high-contrast look suitable for
								home decor products.</p>
							<div class="space-y-3">
								<div class="flex items-center gap-3">
									<div class="w-8 h-8 rounded bg-slate-900"></div>
									<span class="text-xs font-medium text-slate-600">Primary: #0F172A</span>
								</div>
								<div class="flex items-center gap-3">
									<div class="w-8 h-8 rounded bg-white border border-slate-200"></div>
									<span class="text-xs font-medium text-slate-600">Background: #FFFFFF</span>
								</div>
								<div class="flex items-center gap-3">
									<div
										class="w-8 h-8 rounded border-2 border-slate-900 flex items-center justify-center text-[10px] font-bold">
										Aa</div>
									<span class="text-xs font-medium text-slate-600">Font: Manrope Bold /
										Regular</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Secondary Actions Column -->
				<div class="col-span-12 lg:col-span-4 space-y-6">
					<!-- Quick Links Card -->
					<div class="bg-slate-900 text-white p-8 rounded-xl shadow-lg relative overflow-hidden group">
						<div class="relative z-10">
							<h4 class="font-semibold tracking-tight text-lg mb-4">Management Actions</h4>
							<div class="grid gap-3">
								<button
									class="w-full flex items-center justify-between p-3 bg-white/10 hover:bg-white/20 rounded-lg transition-all text-sm font-semibold group/item">
									<span class="flex items-center">
										<span class="material-symbols-outlined mr-3" data-icon="add_box">add_box</span>
										Add New Product
									</span>
									<span
										class="material-symbols-outlined opacity-0 group-hover/item:opacity-100 -translate-x-2 group-hover/item:translate-x-0 transition-all text-xs"
										data-icon="arrow_forward">arrow_forward</span>
								</button>
								<button
									class="w-full flex items-center justify-between p-3 bg-white/10 hover:bg-white/20 rounded-lg transition-all text-sm font-semibold group/item">
									<span class="flex items-center">
										<span class="material-symbols-outlined mr-3"
											data-icon="campaign">campaign</span>
										Create Promotion
									</span>
									<span
										class="material-symbols-outlined opacity-0 group-hover/item:opacity-100 -translate-x-2 group-hover/item:translate-x-0 transition-all text-xs"
										data-icon="arrow_forward">arrow_forward</span>
								</button>
								<button
									class="w-full flex items-center justify-between p-3 bg-white/10 hover:bg-white/20 rounded-lg transition-all text-sm font-semibold group/item">
									<span class="flex items-center">
										<span class="material-symbols-outlined mr-3" data-icon="brush">brush</span>
										Customize Theme
									</span>
									<span
										class="material-symbols-outlined opacity-0 group-hover/item:opacity-100 -translate-x-2 group-hover/item:translate-x-0 transition-all text-xs"
										data-icon="arrow_forward">arrow_forward</span>
								</button>
								<button
									class="w-full flex items-center justify-between p-3 bg-white/10 hover:bg-white/20 rounded-lg transition-all text-sm font-semibold group/item">
									<span class="flex items-center">
										<span class="material-symbols-outlined mr-3"
											data-icon="analytics">analytics</span>
										Deep Analytics
									</span>
									<span
										class="material-symbols-outlined opacity-0 group-hover/item:opacity-100 -translate-x-2 group-hover/item:translate-x-0 transition-all text-xs"
										data-icon="arrow_forward">arrow_forward</span>
								</button>
							</div>
						</div>
						<!-- Abstract Design Element -->
						<div
							class="absolute -bottom-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-2xl group-hover:bg-white/10 transition-colors">
						</div>
					</div>
					<!-- Inventory Alert -->
					<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm">
						<div class="flex items-center gap-3 mb-4">
							<div class="w-10 h-10 rounded-lg bg-red-50 flex items-center justify-center text-red-500">
								<span class="material-symbols-outlined" data-icon="warning">warning</span>
							</div>
							<div>
								<h4 class="font-semibold text-slate-900">Inventory Alerts</h4>
								<p class="text-[10px] text-slate-500 uppercase tracking-widest">3 items low in stock</p>
							</div>
						</div>
						<div class="space-y-4">
							<div class="flex items-center justify-between">
								<div class="flex items-center gap-3">
									<div class="w-10 h-10 bg-slate-100 rounded border border-slate-200">
										<img alt="Product" class="w-full h-full object-cover rounded"
											data-alt="A macro shot of a handcrafted ceramic vase with a textured matte finish. The image is brightly lit from the side to emphasize the surface detail. The background is a clean, neutral white, typical of a high-end product listing."
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuBy0-SbJvGeefYE0i4wEdkHpJtOhj01b1h43yrrPBT4rEjPNXROnBBoEsjrSO9P1UmZEaVUrLZ3jvGq0w10PEbimp0axvDFBWQCSJnPjR_ap7xKiEM0ZGyD5mPFDaJKAjlLDJ-eZMy2VBSqiHmGEId7OIMNiLqoVlNYdEjp5YCapsNWCusDBSuUKJw7Fhl472MwIuZ4PQWfy3KJ-V0KEFlUkDYH2iXCF9XRr-3utVQ62fW14UCmCnhjjxkTVHG9EwEGCMXWFFnkkOG0" />
									</div>
									<div>
										<p class="text-xs font-semibold text-slate-900">Lunar Candle Holder</p>
										<p class="text-[10px] text-red-500">Only 2 left</p>
									</div>
								</div>
								<button
									class="text-[10px] px-2 py-1 bg-slate-100 hover:bg-slate-200 rounded font-bold uppercase tracking-tighter">Restock</button>
							</div>
							<div class="flex items-center justify-between">
								<div class="flex items-center gap-3">
									<div class="w-10 h-10 bg-slate-100 rounded border border-slate-200">
										<img alt="Product" class="w-full h-full object-cover rounded"
											data-alt="A minimalist brass pendant light hanging against a soft grey wall. The lighting is warm and directional, creating subtle shadows that define the geometric form of the lamp. The aesthetic is clean, professional, and sophisticated."
											src="https://lh3.googleusercontent.com/aida-public/AB6AXuAxgKdf2Xj0ETY2p-CENoCbvicXDHXNRnNYZ2G5I6J0m0ymXBcTYhk7WKxwi143yu4kmbh1V4664yIqgDbtLlSddG47kWKhj0SUIKi_q_2P0VOsunyVcxUACvzDUXR2LaV7GVJzUTDGkO4fWojDlvZm9B_Kg87izol3uE0cIStGa5lTBDJwK85SW146q-ltoX90ofhTA48lNC7TOemdN1x8-ZIPtWIZULcnToVzsxzIbLGLuydGQHyhj-2Bvf5722XNZv3kjUZvEFYo" />
									</div>
									<div>
										<p class="text-xs font-semibold text-slate-900">Minimalist Pendant</p>
										<p class="text-[10px] text-red-500">Only 5 left</p>
									</div>
								</div>
								<button
									class="text-[10px] px-2 py-1 bg-slate-100 hover:bg-slate-200 rounded font-bold uppercase tracking-tighter">Restock</button>
							</div>
						</div>
						<button
							class="w-full mt-6 py-2 text-sm text-slate-500 hover:text-slate-900 font-semibold border-t border-slate-100 pt-4">
							View Inventory Dashboard
						</button>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
