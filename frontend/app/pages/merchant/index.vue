<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 flex-1 min-h-screen flex flex-col">
		<!-- Top Utility Header (Theme specific, not JSON) -->
		<header
			class="h-16 px-4 flex items-center justify-between border-b border-slate-400 bg-white sticky top-0 z-30">
			<h1 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Dashboard</h1>
			<div class="flex items-center gap-2">
				<button
					class="p-2 rounded-full hover:bg-slate-200 transition-colors text-slate-600 outline-none focus:ring-2 focus:ring-primary">
					<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
				</button>
				<div
					class="size-8 rounded-full bg-slate-800 text-slate-50 flex items-center justify-center font-semibold text-sm overflow-hidden ring-1 ring-outline-variant">
					<img alt="User Avatar" class="size-full object-cover"
						data-alt="close-up portrait of a professional man in a bright modern office setting"
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuDqds0N5VSs_xqnweqTXweffd1SP4Ou_G0Ms46keqhH9JUd6ze4Ty7sgUJqhgQnzStyX6FhEFTn8uTJMYJ2tJ9GlDzQB5qsHYfloeMcpLq9B4yQ67KasblOOHwnoREEdOrK-bf2W3RDxbjfAGgBk_IU5JdThQ6os2c26OLr_f91CTxg2lRhMJqZ1p6Ljxcfkh_DFHR1HBT5BOYIrSLMPd8J50Rc5nCEVbgh4dshjraDcV8d-a3cYE-BDlZDT3d6wNDL1svgJ7qErbHf" />
				</div>
			</div>
		</header>
		<!-- Dashboard Content -->
		<div class="p-4 flex-1 max-w-[1280px] w-full mx-auto space-y-md">
			<!-- Welcome Row -->
			<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pt-2">
				<div>
					<h2 class="font-bold tracking-tight text-3xl leading-tight text-slate-900">Welcome back, Admin</h2>
					<p class="font-normal text-base text-slate-600 mt-1">Here is what's happening with your
						stores today.</p>
				</div>
				<div class="flex gap-2">
					<button
						class="px-4 py-2 border border-slate-300 text-slate-900 font-semibold text-sm rounded-md hover:bg-slate-200 transition-colors outline-none focus:ring-2 focus:ring-primary flex items-center gap-2">
						<span class="material-symbols-outlined text-lg" data-icon="download">download</span>
						Export Report
					</button>
				</div>
			</div>
			<!-- Metrics Grid -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-grid_gutter">
				<!-- Metric Card 1: Total Sales -->
				<div
					class="bg-white border border-slate-400 rounded-lg p-4 flex flex-col gap-2 shadow-sm relative overflow-hidden group">
					<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
						<span class="material-symbols-outlined text-[64px] text-slate-900"
							data-icon="payments">payments</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="font-semibold text-sm text-slate-600 uppercase tracking-wider">Total
							Sales</span>
						<div class="bg-slate-200 rounded-full p-1 flex items-center justify-center">
							<span class="material-symbols-outlined text-sm text-slate-600"
								data-icon="trending_up">trending_up</span>
						</div>
					</div>
					<div class="mt-2">
						<span class="font-bold tracking-tight text-4xl leading-tight text-slate-900">$124,500</span>
					</div>
					<div class="flex items-center gap-2 mt-auto pt-2">
						<span
							class="font-medium text-xs text-slate-900 flex items-center bg-slate-900 px-2 py-1 rounded-md">
							<span class="material-symbols-outlined text-[12px] mr-1"
								data-icon="arrow_upward">arrow_upward</span>
							12.5%
						</span>
						<span class="font-medium text-xs text-slate-600">vs last month</span>
					</div>
				</div>
				<!-- Metric Card 2: Pending Orders -->
				<div
					class="bg-white border border-slate-400 rounded-lg p-4 flex flex-col gap-2 shadow-sm relative overflow-hidden group">
					<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
						<span class="material-symbols-outlined text-[64px] text-slate-900"
							data-icon="local_shipping">local_shipping</span>
					</div>
					<div class="flex items-center gap-2">
						<span
							class="font-semibold text-sm text-slate-600 uppercase tracking-wider">Pending
							Orders</span>
						<div class="bg-slate-200 rounded-full p-1 flex items-center justify-center">
							<span class="material-symbols-outlined text-sm text-slate-600"
								data-icon="hourglass_empty">hourglass_empty</span>
						</div>
					</div>
					<div class="mt-2">
						<span class="font-bold tracking-tight text-4xl leading-tight text-slate-900">342</span>
					</div>
					<div class="flex items-center gap-2 mt-auto pt-2">
						<span
							class="font-medium text-xs text-red-600 flex items-center bg-red-100 px-2 py-1 rounded-md">
							<span class="material-symbols-outlined text-[12px] mr-1"
								data-icon="arrow_downward">arrow_downward</span>
							2.4%
						</span>
						<span class="font-medium text-xs text-slate-600">Requires attention</span>
					</div>
				</div>
				<!-- Metric Card 3: Active Stores -->
				<div
					class="bg-white border border-slate-400 rounded-lg p-4 flex flex-col gap-2 shadow-sm relative overflow-hidden group">
					<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
						<span class="material-symbols-outlined text-[64px] text-slate-900"
							data-icon="storefront">storefront</span>
					</div>
					<div class="flex items-center gap-2">
						<span
							class="font-semibold text-sm text-slate-600 uppercase tracking-wider">Active
							Stores</span>
					</div>
					<div class="mt-2">
						<span class="font-bold tracking-tight text-4xl leading-tight text-slate-900">14</span>
					</div>
					<div class="flex items-center gap-2 mt-auto pt-2">
						<div class="flex -space-x-2">
							<div
								class="size-6 rounded-full bg-slate-200 border border-white">
							</div>
							<div
								class="size-6 rounded-full bg-slate-100 border border-white">
							</div>
							<div class="size-6 rounded-full bg-slate-300 border border-white">
							</div>
						</div>
						<span class="font-medium text-xs text-slate-600 ml-2">All operating
							normally</span>
					</div>
				</div>
			</div>
			<!-- Recent Orders Section -->
			<div class="bg-white border border-slate-400 rounded-lg flex flex-col shadow-sm">
				<div class="px-4 py-2 border-b border-slate-400 flex items-center justify-between">
					<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Recent Paid Orders</h3>
					<button
						class="font-semibold text-sm text-slate-900 hover:underline outline-none focus:ring-2 focus:ring-primary rounded-xs px-2 py-1">View
						All</button>
				</div>
				<div class="overflow-x-auto">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="bg-slate-50 border-b border-slate-400">
								<th
									class="py-3 px-4 font-semibold text-sm text-slate-600 whitespace-nowrap">
									Order ID</th>
								<th
									class="py-3 px-4 font-semibold text-sm text-slate-600 whitespace-nowrap">
									Customer</th>
								<th
									class="py-3 px-4 font-semibold text-sm text-slate-600 whitespace-nowrap">
									Date</th>
								<th
									class="py-3 px-4 font-semibold text-sm text-slate-600 whitespace-nowrap text-right">
									Amount</th>
								<th
									class="py-3 px-4 font-semibold text-sm text-slate-600 whitespace-nowrap">
									Status</th>
							</tr>
						</thead>
						<tbody class="font-normal text-base text-slate-900">
							<tr
								class="border-b border-slate-400 hover:bg-slate-100 transition-colors group cursor-pointer">
								<td class="p-4 font-semibold text-sm text-slate-900">#ORD-9823</td>
								<td class="p-4">
									<div class="flex items-center gap-3">
										<div
											class="size-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-800 font-semibold text-sm">
											ES</div>
										<span>Elena Smith</span>
									</div>
								</td>
								<td class="p-4 text-slate-600">Oct 24, 2024</td>
								<td class="p-4 text-lg font-semibold text-right">$450.00</td>
								<td class="p-4">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium text-xs bg-slate-900 text-white border border-slate-400">
										Processing
									</span>
								</td>
							</tr>
							<tr
								class="border-b border-slate-400 hover:bg-slate-100 transition-colors group cursor-pointer">
								<td class="p-4 font-semibold text-sm text-slate-900">#ORD-9822</td>
								<td class="p-4">
									<div class="flex items-center gap-3">
										<div
											class="size-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-semibold text-sm">
											MR</div>
										<span>Marcus Rossi</span>
									</div>
								</td>
								<td class="p-4 text-slate-600">Oct 24, 2024</td>
								<td class="p-4 text-lg font-semibold text-right">$1,299.50</td>
								<td class="p-4">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium text-xs bg-slate-900 text-white border border-slate-400">
										Processing
									</span>
								</td>
							</tr>
							<tr
								class="border-b border-slate-400 hover:bg-slate-100 transition-colors group cursor-pointer">
								<td class="p-4 font-semibold text-sm text-slate-900">#ORD-9821</td>
								<td class="p-4">
									<div class="flex items-center gap-3">
										<div
											class="size-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-900 font-semibold text-sm">
											<span class="material-symbols-outlined"
												data-icon="person">person</span>
										</div>
										<span>Guest Checkout</span>
									</div>
								</td>
								<td class="p-4 text-slate-600">Oct 23, 2024</td>
								<td class="p-4 text-lg font-semibold text-right">$85.00</td>
								<td class="p-4">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium text-xs bg-slate-100 text-slate-600 border border-slate-400">
										Shipped
									</span>
								</td>
							</tr>
							<tr class="hover:bg-slate-100 transition-colors group cursor-pointer">
								<td class="p-4 font-semibold text-sm text-slate-900">#ORD-9820</td>
								<td class="p-4">
									<div class="flex items-center gap-3">
										<div
											class="size-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-800 font-semibold text-sm">
											AL</div>
										<span>Anna Lee</span>
									</div>
								</td>
								<td class="p-4 text-slate-600">Oct 23, 2024</td>
								<td class="p-4 text-lg font-semibold text-right">$320.00</td>
								<td class="p-4">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-medium text-xs bg-slate-100 text-slate-600 border border-slate-400">
										Shipped
									</span>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</main>
</template>
