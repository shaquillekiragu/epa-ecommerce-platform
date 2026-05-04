<template>
	<MerchantSidePanelComponent />

	<main class="flex-1 lg:ml-64 p-6 md:p-8 bg-surface-container-lowest">
		<div class="max-w-[1200px] mx-auto space-y-8">
			<!-- Page Header -->
			<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
				<div>
					<h1 class="font-display-lg text-display-lg text-on-surface">Orders</h1>
					<p class="font-body-md text-body-md text-on-surface-variant">Manage and fulfill your store
						transactions efficiently.</p>
				</div>
				<div class="flex items-center gap-3">
					<button
						class="flex items-center gap-2 border border-outline px-4 py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-variant transition-colors">
						<span class="material-symbols-outlined text-[20px]" data-icon="download">download</span>
						Export CSV
					</button>
				</div>
			</div>
			<!-- Metric Cards -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm transition-all hover:shadow-md">
					<div class="flex items-center justify-between mb-4">
						<span
							class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Pending
							Fulfillment</span>
						<span class="material-symbols-outlined text-secondary"
							data-icon="pending_actions">pending_actions</span>
					</div>
					<div class="flex items-baseline gap-2">
						<span class="font-display-lg text-display-lg text-primary">24</span>
						<span class="text-error font-label-sm text-label-sm flex items-center gap-1">
							<span class="material-symbols-outlined text-[14px]"
								data-icon="trending_up">trending_up</span>
							+12%
						</span>
					</div>
				</div>
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm transition-all hover:shadow-md">
					<div class="flex items-center justify-between mb-4">
						<span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Total
							Revenue (Today)</span>
						<span class="material-symbols-outlined text-secondary" data-icon="payments">payments</span>
					</div>
					<div class="flex items-baseline gap-2">
						<span class="font-display-lg text-display-lg text-primary">$12,840</span>
						<span class="text-on-tertiary-container font-label-sm text-label-sm flex items-center gap-1">
							<span class="material-symbols-outlined text-[14px]"
								data-icon="trending_up">trending_up</span>
							+4.5%
						</span>
					</div>
				</div>
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm transition-all hover:shadow-md">
					<div class="flex items-center justify-between mb-4">
						<span
							class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Average
							Order Value</span>
						<span class="material-symbols-outlined text-secondary"
							data-icon="shopping_basket">shopping_basket</span>
					</div>
					<div class="flex items-baseline gap-2">
						<span class="font-display-lg text-display-lg text-primary">$535.00</span>
						<span class="text-on-surface-variant font-label-sm text-label-sm">Steady</span>
					</div>
				</div>
			</div>
			<!-- Table Section -->
			<div class="bg-white border border-slate-200 rounded-xl overflow-hidden shadow-sm">
				<!-- Filters -->
				<div
					class="p-6 border-b border-slate-100 flex flex-col md:flex-row gap-4 justify-between items-center bg-slate-50/50">
					<div class="flex gap-3 w-full md:w-auto">
						<select
							class="flex-1 md:w-40 border border-outline-variant rounded-lg px-3 py-2 font-label-md text-label-md focus:ring-2 focus:ring-primary outline-none bg-white">
							<option>All Statuses</option>
							<option>Paid</option>
							<option>Shipped</option>
							<option>Delivered</option>
						</select>
						<button
							class="flex items-center gap-2 border border-outline-variant px-4 py-2 rounded-lg font-label-md text-label-md bg-white hover:bg-slate-100">
							<span class="material-symbols-outlined text-[20px]"
								data-icon="calendar_month">calendar_month</span>
							Date Range
						</button>
					</div>
				</div>
				<!-- Data Table -->
				<div class="overflow-x-auto">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="bg-slate-50">
								<th
									class="px-6 py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
									Order ID</th>
								<th
									class="px-6 py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
									Date &amp; Time</th>
								<th
									class="px-6 py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
									Customer</th>
								<th
									class="px-6 py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
									Total</th>
								<th
									class="px-6 py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
									Status</th>
								<th
									class="px-6 py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right">
									Actions</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-100">
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-label-md text-label-md text-primary font-bold">#ORD-7402</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface-variant">Oct 24, 2023 •
									14:20</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface">Alexander Pierce</td>
								<td class="px-6 py-5 font-body-lg text-body-lg font-bold text-primary">$1,240.00</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-tertiary-fixed text-on-tertiary-fixed-variant">
										Paid
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-primary text-white font-label-md text-label-md px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-label-md text-label-md text-primary font-bold">#ORD-7401</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface-variant">Oct 24, 2023 •
									13:45</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface">Sarah Jenkins</td>
								<td class="px-6 py-5 font-body-lg text-body-lg font-bold text-primary">$850.50</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-secondary-fixed text-on-secondary-fixed-variant">
										Shipped
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-primary text-white font-label-md text-label-md px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-label-md text-label-md text-primary font-bold">#ORD-7399</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface-variant">Oct 23, 2023 •
									11:10</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface">Marcus Sterling</td>
								<td class="px-6 py-5 font-body-lg text-body-lg font-bold text-primary">$2,100.00</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-surface-container-highest text-on-surface-variant">
										Delivered
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-primary text-white font-label-md text-label-md px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-label-md text-label-md text-primary font-bold">#ORD-7395</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface-variant">Oct 23, 2023 •
									09:30</td>
								<td class="px-6 py-5 font-body-md text-body-md text-on-surface">Elara Vance</td>
								<td class="px-6 py-5 font-body-lg text-body-lg font-bold text-primary">$435.00</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-tertiary-fixed text-on-tertiary-fixed-variant">
										Paid
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-primary text-white font-label-md text-label-md px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- Pagination -->
				<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
					<span class="font-label-sm text-label-sm text-on-surface-variant">Showing 4 of 128 orders</span>
					<div class="flex gap-2">
						<button class="material-symbols-outlined p-1 rounded hover:bg-slate-200"
							data-icon="chevron_left">chevron_left</button>
						<button class="material-symbols-outlined p-1 rounded hover:bg-slate-200"
							data-icon="chevron_right">chevron_right</button>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
