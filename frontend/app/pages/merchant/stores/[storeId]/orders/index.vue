<template>
	<MerchantSidePanelComponent />

	<main class="flex-1 lg:ml-64 p-6 md:p-8 bg-white">
		<div class="max-w-[1200px] mx-auto space-y-8">
			<!-- Page Header -->
			<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
				<div>
					<h1 class="font-bold tracking-tight text-4xl leading-tight text-slate-900">Orders</h1>
					<p class="font-normal text-base text-slate-600">Manage and fulfill your store
						transactions efficiently.</p>
				</div>
				<div class="flex items-center gap-3">
					<button
						class="flex items-center gap-2 border border-slate-300 px-4 py-2 rounded-lg font-semibold text-sm text-slate-600 hover:bg-slate-100 transition-colors">
						<span class="material-symbols-outlined text-xl" data-icon="download">download</span>
						Export CSV
					</button>
				</div>
			</div>
			<!-- Metric Cards -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm transition-all hover:shadow-md">
					<div class="flex items-center justify-between mb-4">
						<span
							class="font-semibold text-sm text-slate-600 uppercase tracking-wider">Pending
							Fulfillment</span>
						<span class="material-symbols-outlined text-slate-600"
							data-icon="pending_actions">pending_actions</span>
					</div>
					<div class="flex items-baseline gap-2">
						<span class="font-bold tracking-tight text-4xl leading-tight text-slate-900">24</span>
						<span class="text-red-600 font-medium text-xs flex items-center gap-1">
							<span class="material-symbols-outlined text-sm"
								data-icon="trending_up">trending_up</span>
							+12%
						</span>
					</div>
				</div>
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm transition-all hover:shadow-md">
					<div class="flex items-center justify-between mb-4">
						<span class="font-semibold text-sm text-slate-600 uppercase tracking-wider">Total
							Revenue (Today)</span>
						<span class="material-symbols-outlined text-slate-600" data-icon="payments">payments</span>
					</div>
					<div class="flex items-baseline gap-2">
						<span class="font-bold tracking-tight text-4xl leading-tight text-slate-900">$12,840</span>
						<span class="text-slate-700 font-medium text-xs flex items-center gap-1">
							<span class="material-symbols-outlined text-sm"
								data-icon="trending_up">trending_up</span>
							+4.5%
						</span>
					</div>
				</div>
				<div class="bg-white border border-slate-200 p-6 rounded-xl shadow-sm transition-all hover:shadow-md">
					<div class="flex items-center justify-between mb-4">
						<span
							class="font-semibold text-sm text-slate-600 uppercase tracking-wider">Average
							Order Value</span>
						<span class="material-symbols-outlined text-slate-600"
							data-icon="shopping_basket">shopping_basket</span>
					</div>
					<div class="flex items-baseline gap-2">
						<span class="font-bold tracking-tight text-4xl leading-tight text-slate-900">$535.00</span>
						<span class="text-slate-600 font-medium text-xs">Steady</span>
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
							class="flex-1 md:w-40 border border-slate-400 rounded-lg px-3 py-2 font-semibold text-sm focus:ring-2 focus:ring-primary outline-none bg-white">
							<option>All Statuses</option>
							<option>Paid</option>
							<option>Shipped</option>
							<option>Delivered</option>
						</select>
						<button
							class="flex items-center gap-2 border border-slate-400 px-4 py-2 rounded-lg font-semibold text-sm bg-white hover:bg-slate-100">
							<span class="material-symbols-outlined text-xl"
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
									class="px-6 py-4 font-semibold text-sm text-slate-600 uppercase tracking-wider">
									Order ID</th>
								<th
									class="px-6 py-4 font-semibold text-sm text-slate-600 uppercase tracking-wider">
									Date &amp; Time</th>
								<th
									class="px-6 py-4 font-semibold text-sm text-slate-600 uppercase tracking-wider">
									Customer</th>
								<th
									class="px-6 py-4 font-semibold text-sm text-slate-600 uppercase tracking-wider">
									Total</th>
								<th
									class="px-6 py-4 font-semibold text-sm text-slate-600 uppercase tracking-wider">
									Status</th>
								<th
									class="px-6 py-4 font-semibold text-sm text-slate-600 uppercase tracking-wider text-right">
									Actions</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-100">
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-semibold text-sm text-slate-900 font-bold">#ORD-7402</td>
								<td class="px-6 py-5 font-normal text-base text-slate-600">Oct 24, 2023 •
									14:20</td>
								<td class="px-6 py-5 font-normal text-base text-slate-900">Alexander Pierce</td>
								<td class="px-6 py-5 font-normal text-lg font-bold text-slate-900">$1,240.00</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
										Paid
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-slate-900 text-white font-semibold text-sm px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-semibold text-sm text-slate-900 font-bold">#ORD-7401</td>
								<td class="px-6 py-5 font-normal text-base text-slate-600">Oct 24, 2023 •
									13:45</td>
								<td class="px-6 py-5 font-normal text-base text-slate-900">Sarah Jenkins</td>
								<td class="px-6 py-5 font-normal text-lg font-bold text-slate-900">$850.50</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-200 text-slate-700">
										Shipped
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-slate-900 text-white font-semibold text-sm px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-semibold text-sm text-slate-900 font-bold">#ORD-7399</td>
								<td class="px-6 py-5 font-normal text-base text-slate-600">Oct 23, 2023 •
									11:10</td>
								<td class="px-6 py-5 font-normal text-base text-slate-900">Marcus Sterling</td>
								<td class="px-6 py-5 font-normal text-lg font-bold text-slate-900">$2,100.00</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-200 text-slate-600">
										Delivered
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-slate-900 text-white font-semibold text-sm px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50/80 transition-colors group">
								<td class="px-6 py-5 font-semibold text-sm text-slate-900 font-bold">#ORD-7395</td>
								<td class="px-6 py-5 font-normal text-base text-slate-600">Oct 23, 2023 •
									09:30</td>
								<td class="px-6 py-5 font-normal text-base text-slate-900">Elara Vance</td>
								<td class="px-6 py-5 font-normal text-lg font-bold text-slate-900">$435.00</td>
								<td class="px-6 py-5">
									<span
										class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
										Paid
									</span>
								</td>
								<td class="px-6 py-5 text-right">
									<button
										class="bg-slate-900 text-white font-semibold text-sm px-4 py-2 rounded-lg hover:opacity-90 active:scale-95 transition-all">Review</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<!-- Pagination -->
				<div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between">
					<span class="font-medium text-xs text-slate-600">Showing 4 of 128 orders</span>
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
