<template>
	<MerchantSidePanelComponent />

	<main class="ml-64 flex-1 min-h-screen flex flex-col">
		<!-- Top Utility Header (Theme specific, not JSON) -->
		<header
			class="h-16 px-md flex items-center justify-between border-b border-outline-variant bg-surface-container-lowest sticky top-0 z-30">
			<h1 class="font-headline-md text-headline-md text-on-surface">Dashboard</h1>
			<div class="flex items-center gap-sm">
				<button
					class="p-2 rounded-full hover:bg-surface-container-highest transition-colors text-on-surface-variant outline-none focus:ring-2 focus:ring-primary">
					<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
				</button>
				<div
					class="h-8 w-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-label-md text-label-md overflow-hidden ring-1 ring-outline-variant">
					<img alt="User Avatar" class="w-full h-full object-cover"
						data-alt="close-up portrait of a professional man in a bright modern office setting"
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuDqds0N5VSs_xqnweqTXweffd1SP4Ou_G0Ms46keqhH9JUd6ze4Ty7sgUJqhgQnzStyX6FhEFTn8uTJMYJ2tJ9GlDzQB5qsHYfloeMcpLq9B4yQ67KasblOOHwnoREEdOrK-bf2W3RDxbjfAGgBk_IU5JdThQ6os2c26OLr_f91CTxg2lRhMJqZ1p6Ljxcfkh_DFHR1HBT5BOYIrSLMPd8J50Rc5nCEVbgh4dshjraDcV8d-a3cYE-BDlZDT3d6wNDL1svgJ7qErbHf" />
				</div>
			</div>
		</header>
		<!-- Dashboard Content -->
		<div class="p-md flex-1 max-w-[1280px] w-full mx-auto space-y-md">
			<!-- Welcome Row -->
			<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pt-sm">
				<div>
					<h2 class="font-headline-lg text-headline-lg text-on-surface">Welcome back, Admin</h2>
					<p class="font-body-md text-body-md text-on-surface-variant mt-1">Here is what's happening with your
						stores today.</p>
				</div>
				<div class="flex gap-sm">
					<button
						class="px-4 py-2 border border-outline text-on-surface font-label-md text-label-md rounded-DEFAULT hover:bg-surface-container-highest transition-colors outline-none focus:ring-2 focus:ring-primary flex items-center gap-2">
						<span class="material-symbols-outlined text-lg" data-icon="download">download</span>
						Export Report
					</button>
				</div>
			</div>
			<!-- Metrics Grid -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-grid_gutter">
				<!-- Metric Card 1: Total Sales -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex flex-col gap-sm shadow-sm relative overflow-hidden group">
					<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
						<span class="material-symbols-outlined text-[64px] text-primary"
							data-icon="payments">payments</span>
					</div>
					<div class="flex items-center gap-2">
						<span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Total
							Sales</span>
						<div class="bg-surface-container-highest rounded-full p-1 flex items-center justify-center">
							<span class="material-symbols-outlined text-sm text-on-surface-variant"
								data-icon="trending_up">trending_up</span>
						</div>
					</div>
					<div class="mt-2">
						<span class="font-display-lg text-display-lg text-on-surface">$124,500</span>
					</div>
					<div class="flex items-center gap-2 mt-auto pt-2">
						<span
							class="font-label-sm text-label-sm text-primary flex items-center bg-primary-fixed px-2 py-1 rounded-DEFAULT">
							<span class="material-symbols-outlined text-[12px] mr-1"
								data-icon="arrow_upward">arrow_upward</span>
							12.5%
						</span>
						<span class="font-label-sm text-label-sm text-on-surface-variant">vs last month</span>
					</div>
				</div>
				<!-- Metric Card 2: Pending Orders -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex flex-col gap-sm shadow-sm relative overflow-hidden group">
					<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
						<span class="material-symbols-outlined text-[64px] text-primary"
							data-icon="local_shipping">local_shipping</span>
					</div>
					<div class="flex items-center gap-2">
						<span
							class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Pending
							Orders</span>
						<div class="bg-surface-container-highest rounded-full p-1 flex items-center justify-center">
							<span class="material-symbols-outlined text-sm text-on-surface-variant"
								data-icon="hourglass_empty">hourglass_empty</span>
						</div>
					</div>
					<div class="mt-2">
						<span class="font-display-lg text-display-lg text-on-surface">342</span>
					</div>
					<div class="flex items-center gap-2 mt-auto pt-2">
						<span
							class="font-label-sm text-label-sm text-error flex items-center bg-error-container px-2 py-1 rounded-DEFAULT">
							<span class="material-symbols-outlined text-[12px] mr-1"
								data-icon="arrow_downward">arrow_downward</span>
							2.4%
						</span>
						<span class="font-label-sm text-label-sm text-on-surface-variant">Requires attention</span>
					</div>
				</div>
				<!-- Metric Card 3: Active Stores -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg p-md flex flex-col gap-sm shadow-sm relative overflow-hidden group">
					<div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
						<span class="material-symbols-outlined text-[64px] text-primary"
							data-icon="storefront">storefront</span>
					</div>
					<div class="flex items-center gap-2">
						<span
							class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Active
							Stores</span>
					</div>
					<div class="mt-2">
						<span class="font-display-lg text-display-lg text-on-surface">14</span>
					</div>
					<div class="flex items-center gap-2 mt-auto pt-2">
						<div class="flex -space-x-2">
							<div
								class="w-6 h-6 rounded-full bg-surface-container-highest border border-surface-container-lowest">
							</div>
							<div
								class="w-6 h-6 rounded-full bg-surface-container-high border border-surface-container-lowest">
							</div>
							<div class="w-6 h-6 rounded-full bg-outline-variant border border-surface-container-lowest">
							</div>
						</div>
						<span class="font-label-sm text-label-sm text-on-surface-variant ml-2">All operating
							normally</span>
					</div>
				</div>
			</div>
			<!-- Recent Orders Section -->
			<div class="bg-surface-container-lowest border border-outline-variant rounded-lg flex flex-col shadow-sm">
				<div class="px-md py-sm border-b border-outline-variant flex items-center justify-between">
					<h3 class="font-headline-md text-headline-md text-on-surface">Recent Paid Orders</h3>
					<button
						class="font-label-md text-label-md text-primary hover:underline outline-none focus:ring-2 focus:ring-primary rounded-xs px-2 py-1">View
						All</button>
				</div>
				<div class="overflow-x-auto">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="bg-surface-container-low border-b border-outline-variant">
								<th
									class="py-3 px-md font-label-md text-label-md text-on-surface-variant whitespace-nowrap">
									Order ID</th>
								<th
									class="py-3 px-md font-label-md text-label-md text-on-surface-variant whitespace-nowrap">
									Customer</th>
								<th
									class="py-3 px-md font-label-md text-label-md text-on-surface-variant whitespace-nowrap">
									Date</th>
								<th
									class="py-3 px-md font-label-md text-label-md text-on-surface-variant whitespace-nowrap text-right">
									Amount</th>
								<th
									class="py-3 px-md font-label-md text-label-md text-on-surface-variant whitespace-nowrap">
									Status</th>
							</tr>
						</thead>
						<tbody class="font-body-md text-body-md text-on-surface">
							<tr
								class="border-b border-outline-variant hover:bg-surface-container transition-colors group cursor-pointer">
								<td class="py-4 px-md font-label-md text-label-md text-primary">#ORD-9823</td>
								<td class="py-4 px-md">
									<div class="flex items-center gap-3">
										<div
											class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed font-label-md text-label-md">
											ES</div>
										<span>Elena Smith</span>
									</div>
								</td>
								<td class="py-4 px-md text-on-surface-variant">Oct 24, 2024</td>
								<td class="py-4 px-md font-body-lg text-body-lg font-semibold text-right">$450.00</td>
								<td class="py-4 px-md">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary-fixed text-on-primary-fixed-variant border border-primary-fixed-dim">
										Processing
									</span>
								</td>
							</tr>
							<tr
								class="border-b border-outline-variant hover:bg-surface-container transition-colors group cursor-pointer">
								<td class="py-4 px-md font-label-md text-label-md text-primary">#ORD-9822</td>
								<td class="py-4 px-md">
									<div class="flex items-center gap-3">
										<div
											class="w-8 h-8 rounded-full bg-tertiary-fixed flex items-center justify-center text-on-tertiary-fixed font-label-md text-label-md">
											MR</div>
										<span>Marcus Rossi</span>
									</div>
								</td>
								<td class="py-4 px-md text-on-surface-variant">Oct 24, 2024</td>
								<td class="py-4 px-md font-body-lg text-body-lg font-semibold text-right">$1,299.50</td>
								<td class="py-4 px-md">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-primary-fixed text-on-primary-fixed-variant border border-primary-fixed-dim">
										Processing
									</span>
								</td>
							</tr>
							<tr
								class="border-b border-outline-variant hover:bg-surface-container transition-colors group cursor-pointer">
								<td class="py-4 px-md font-label-md text-label-md text-primary">#ORD-9821</td>
								<td class="py-4 px-md">
									<div class="flex items-center gap-3">
										<div
											class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center text-on-surface font-label-md text-label-md">
											<span class="material-symbols-outlined text-[16px]"
												data-icon="person">person</span>
										</div>
										<span>Guest Checkout</span>
									</div>
								</td>
								<td class="py-4 px-md text-on-surface-variant">Oct 23, 2024</td>
								<td class="py-4 px-md font-body-lg text-body-lg font-semibold text-right">$85.00</td>
								<td class="py-4 px-md">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant border border-outline-variant">
										Shipped
									</span>
								</td>
							</tr>
							<tr class="hover:bg-surface-container transition-colors group cursor-pointer">
								<td class="py-4 px-md font-label-md text-label-md text-primary">#ORD-9820</td>
								<td class="py-4 px-md">
									<div class="flex items-center gap-3">
										<div
											class="w-8 h-8 rounded-full bg-secondary-fixed flex items-center justify-center text-on-secondary-fixed font-label-md text-label-md">
											AL</div>
										<span>Anna Lee</span>
									</div>
								</td>
								<td class="py-4 px-md text-on-surface-variant">Oct 23, 2024</td>
								<td class="py-4 px-md font-body-lg text-body-lg font-semibold text-right">$320.00</td>
								<td class="py-4 px-md">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full font-label-sm text-label-sm bg-surface-container-high text-on-surface-variant border border-outline-variant">
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
