<template>
	<MerchantSidePanelComponent />

	<main class="flex-1 md:ml-64 p-6 md:p-4 lg:p-6">
		<!-- Breadcrumbs and Header -->
		<div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
			<div>
				<nav class="flex items-center gap-2 text-xs font-medium text-slate-600 mb-2">
					<a class="hover:text-slate-900 transition-colors" href="#">Orders</a>
					<span class="material-symbols-outlined text-[14px]" data-icon="chevron_right">chevron_right</span>
					<span class="text-slate-900 font-bold">#ORD-7402</span>
				</nav>
				<h1 class="text-3xl leading-tight font-bold tracking-tight text-slate-900 tracking-tight">Order Review</h1>
			</div>
			<div class="flex items-center gap-3">
				<button
					class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors flex items-center gap-2">
					<span class="material-symbols-outlined" data-icon="print">print</span>
					Print Invoice
				</button>
				<button
					class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-semibold hover:opacity-90 transition-opacity flex items-center gap-2">
					<span class="material-symbols-outlined" data-icon="edit">edit</span>
					Edit Order
				</button>
			</div>
		</div>
		<!-- Bento Grid Layout -->
		<div class="grid grid-cols-1 lg:grid-cols-12 gap-grid_gutter">
			<!-- Left Column: Order Summary & Status -->
			<div class="lg:col-span-8 space-y-grid_gutter">
				<!-- Order Items Card -->
				<div class="bg-white border border-slate-400 rounded-xl overflow-hidden shadow-sm">
					<div
						class="p-6 border-b border-slate-400 bg-slate-50 flex justify-between items-center">
						<h3 class="text-xl leading-snug font-semibold tracking-tight">Line Items</h3>
						<span
							class="text-xs font-medium bg-slate-100 text-slate-700 px-3 py-1 rounded-full uppercase tracking-wider">3
							Items</span>
					</div>
					<div class="overflow-x-auto">
						<table class="w-full text-left">
							<thead class="bg-slate-50 border-b border-slate-400">
								<tr>
									<th class="px-6 py-4 text-sm font-semibold text-slate-600">Product</th>
									<th class="px-6 py-4 text-sm font-semibold text-slate-600">Quantity</th>
									<th class="px-6 py-4 text-sm font-semibold text-slate-600">Price</th>
									<th class="px-6 py-4 text-sm font-semibold text-slate-600 text-right">Subtotal
									</th>
								</tr>
							</thead>
							<tbody class="divide-y divide-slate-300">
								<tr class="hover:bg-slate-900/5 transition-colors">
									<td class="px-6 py-4">
										<div class="flex items-center gap-4">
											<div
												class="h-16 w-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
												<img alt="Premium Watch"
													data-alt="A high-end luxury wristwatch with a sleek black face and silver steel band, photographed in a studio with dramatic cinematic lighting. The watch is presented on a minimalist white pedestal, reflecting a corporate and modern aesthetic. The atmosphere is professional, highlighting refined craftsmanship and premium quality for an e-commerce context."
													src="https://lh3.googleusercontent.com/aida-public/AB6AXuCab3sur_BshtiV48atD3U-u_4F1GPJ_7qZNTDSeHZd5vm7H6Rnn7SaMtH-1pY_DATBTyb9myff44fPP7pPOusNjOdGoG9K4vNhui_gD5z9GHfUR9Ddj6x4kplJjcniTgU7QDA2K48e4hr4YYjYxrTnqbWoRbeA4Xzpngoii2atBt3PnVo-4ZL-8ngYJ7q3LIGN-cuYsUZS4ofDlsBF-MPSAUa06DHlvajxCJX4XRuwCDgD30jDERuUmqb15TVlSWWenYTFAsQfCOLG" />
											</div>
											<div>
												<p class="font-bold text-slate-900">Zenith Chrono Sport</p>
												<p class="text-xs text-slate-600">SKU: ZNT-77-SPRT</p>
											</div>
										</div>
									</td>
									<td class="px-6 py-4 text-base font-normal">01</td>
									<td class="px-6 py-4 text-base font-normal">$1,250.00</td>
									<td class="px-6 py-4 text-base font-normal text-right font-bold">$1,250.00</td>
								</tr>
								<tr class="hover:bg-slate-900/5 transition-colors">
									<td class="px-6 py-4">
										<div class="flex items-center gap-4">
											<div
												class="h-16 w-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
												<img alt="Leather Backpack"
													data-alt="A sophisticated dark brown leather backpack, showcasing fine stitching and metallic accents. The bag is placed in a bright, modern interior with soft, natural light coming from a large window. The background remains clean and uncluttered, maintaining a professional corporate feel. The lighting emphasizes the texture and quality of the leather."
													src="https://lh3.googleusercontent.com/aida-public/AB6AXuCWQz1tT4KPN32gknR34hyRiVOxTMa_8XuoadPHABHjWHb31i1IXxuht1h1GKjf3262VLmbF_XBdBD3R2AFJGI7FJ5bHdDCAJ8qp9Stfp6BXlK6uVa4vfo1w86Ymvncb8Ww6bV4fBHSF2Jv-jTzi0h1UDZ-Q8o1cZ9kK9eEmM20GBlV8s0bU-u3IUMIRnrJCr1Htp_7bwpD_LQVL9tDPyCc3yo4v1oCAhFJ2HEXw6WzriCDLCvhe8_fI86WL9GW_EZFLbd5VOeOZkks" />
											</div>
											<div>
												<p class="font-bold text-slate-900">Executive Leather Pack</p>
												<p class="text-xs text-slate-600">SKU: ELP-99-BRN</p>
											</div>
										</div>
									</td>
									<td class="px-6 py-4 text-base font-normal">01</td>
									<td class="px-6 py-4 text-base font-normal">$450.00</td>
									<td class="px-6 py-4 text-base font-normal text-right font-bold">$450.00</td>
								</tr>
								<tr class="hover:bg-slate-900/5 transition-colors">
									<td class="px-6 py-4">
										<div class="flex items-center gap-4">
											<div
												class="h-16 w-16 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
												<img alt="ANC Headphones"
													data-alt="A pair of sleek, matte black wireless noise-canceling headphones resting on a polished wooden desk. The environment is a contemporary office setting with high-key lighting that creates a bright, productive mood. The image is crisp and clear, focusing on the technological sophistication and ergonomic design of the product in a premium e-commerce style."
													src="https://lh3.googleusercontent.com/aida-public/AB6AXuCurFo3aBsLeVSSmndTeOg6eGorJZduTiViziWbHq0BwhpxFGcIJVtH3nmBrbhnbuae1amcsx-e6uXYcRUqsbkqYYOS0LWBgrJBGAAl7jPWD9km83fp8MWnudNgErby3p0h6WjUK3Xm67wQxJdkeXqzgp3aUBb3Qgjzdnn-M9SQy3IImQaix_RDSrdshKCoGFS3Mm_X2O3ouhMwuPIVJk-3sknjOUyENX1Kv4H6cQODLyN7s6guwJMScvI_O5afumFX1lQUJaPYB7ST" />
											</div>
											<div>
												<p class="font-bold text-slate-900">SilentFlow ANC V2</p>
												<p class="text-xs text-slate-600">SKU: SFW-22-ANC</p>
											</div>
										</div>
									</td>
									<td class="px-6 py-4 text-base font-normal">01</td>
									<td class="px-6 py-4 text-base font-normal">$349.00</td>
									<td class="px-6 py-4 text-base font-normal text-right font-bold">$349.00</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="p-6 bg-slate-50 flex justify-end">
						<div class="w-full md:w-1/3 space-y-2">
							<div class="flex justify-between text-base">
								<span class="text-slate-600">Subtotal</span>
								<span class="font-medium">$2,049.00</span>
							</div>
							<div class="flex justify-between text-base">
								<span class="text-slate-600">Shipping (Express)</span>
								<span class="font-medium">$25.00</span>
							</div>
							<div class="flex justify-between text-base border-b border-slate-400 pb-2">
								<span class="text-slate-600">Tax (VAT 10%)</span>
								<span class="font-medium">$204.90</span>
							</div>
							<div class="flex justify-between pt-2">
								<span class="text-xl leading-snug font-semibold tracking-tight">Total</span>
								<span class="text-xl leading-snug font-semibold tracking-tight text-slate-900">$2,278.90</span>
							</div>
						</div>
					</div>
				</div>
				<!-- Order Timeline -->
				<div class="bg-white border border-slate-400 rounded-xl p-6 shadow-sm">
					<h3 class="text-xl leading-snug font-semibold tracking-tight mb-6">Order Status Timeline</h3>
					<div class="relative">
						<div class="absolute left-4 top-0 h-full w-0.5 bg-slate-300"></div>
						<div class="space-y-8">
							<div class="relative flex items-start gap-6">
								<div
									class="z-10 w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white">
									<span class="material-symbols-outlined text-[18px]" data-icon="check"
										style="font-variation-settings: 'FILL' 0;">check</span>
								</div>
								<div>
									<p class="font-bold text-slate-900">Order Placed</p>
									<p class="text-base text-slate-600">Oct 24, 2023 at 02:30 PM</p>
									<p class="text-xs text-slate-400 mt-1 italic">Order #ORD-7402 was successfully
										placed by Sarah Jenkins.</p>
								</div>
							</div>
							<div class="relative flex items-start gap-6">
								<div
									class="z-10 w-8 h-8 rounded-full bg-slate-900 flex items-center justify-center text-white">
									<span class="material-symbols-outlined text-[18px]"
										data-icon="payments">payments</span>
								</div>
								<div>
									<p class="font-bold text-slate-900">Payment Confirmed</p>
									<p class="text-base text-slate-600">Oct 24, 2023 at 02:45 PM</p>
									<p class="text-xs text-slate-400 mt-1 italic">Authorized via Stripe (Ref:
										TX_99012488)</p>
								</div>
							</div>
							<div class="relative flex items-start gap-6">
								<div
									class="z-10 w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-50 ring-4 ring-white">
									<span class="material-symbols-outlined text-[18px]"
										data-icon="inventory_2">inventory_2</span>
								</div>
								<div>
									<p class="font-bold text-slate-900">Processing</p>
									<p class="text-base text-slate-50">Oct 25, 2023 (Active)</p>
									<p class="text-xs text-slate-400 mt-1 italic">Items are being picked and packed for
										shipment.</p>
								</div>
							</div>
							<div class="relative flex items-start gap-6">
								<div
									class="z-10 w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-slate-400">
									<span class="material-symbols-outlined text-[18px]"
										data-icon="local_shipping">local_shipping</span>
								</div>
								<div>
									<p class="font-bold text-slate-400">Shipped</p>
									<p class="text-base text-slate-400">Estimated Oct 27, 2023</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Right Column: Customer Info & Actions -->
			<div class="lg:col-span-4 space-y-grid_gutter">
				<!-- Update Status Action Card -->
				<div class="bg-slate-900 text-white rounded-xl p-6 shadow-md">
					<h3 class="text-xl leading-snug font-semibold tracking-tight mb-4 flex items-center gap-2">
						<span class="material-symbols-outlined" data-icon="pending_actions">pending_actions</span>
						Update Status
					</h3>
					<div class="space-y-4">
						<div>
							<label class="text-xs font-medium block mb-2 opacity-80">Current Stage</label>
							<select
								class="w-full bg-white/10 border border-white/20 rounded-lg p-3 text-white focus:ring-2 focus:ring-white/50 cursor-pointer">
								<option class="text-slate-900">Awaiting Fulfillment</option>
								<option class="text-slate-900" selected>Processing</option>
								<option class="text-slate-900">Dispatched</option>
								<option class="text-slate-900">Delivered</option>
								<option class="text-slate-900">On Hold</option>
							</select>
						</div>
						<button
							class="w-full bg-white text-slate-900 font-bold py-3 rounded-lg hover:bg-opacity-90 transition-all active:scale-[0.98]">
							Save Status Update
						</button>
					</div>
				</div>
				<!-- Customer Detail Card -->
				<div class="bg-white border border-slate-400 rounded-xl p-6 shadow-sm">
					<div class="flex items-center justify-between mb-6">
						<h3 class="text-xl leading-snug font-semibold tracking-tight">Customer</h3>
						<button class="text-slate-900 text-sm font-semibold hover:underline">View Profile</button>
					</div>
					<div class="flex items-center gap-4 mb-6">
						<div
							class="h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-700 font-black text-lg">
							SJ
						</div>
						<div>
							<p class="font-bold text-slate-900">Sarah Jenkins</p>
							<p class="text-xs text-slate-600">sarah.j@enterprise.com</p>
						</div>
					</div>
					<div class="space-y-4">
						<div class="flex items-center gap-3">
							<span class="material-symbols-outlined text-slate-600" data-icon="phone">phone</span>
							<span class="text-base">+1 (555) 098-7654</span>
						</div>
						<div class="flex items-center gap-3">
							<span class="material-symbols-outlined text-slate-600" data-icon="event">event</span>
							<span class="text-base">Customer since May 2021</span>
						</div>
					</div>
				</div>
				<!-- Addresses Card -->
				<div class="bg-white border border-slate-400 rounded-xl p-6 shadow-sm">
					<div class="mb-6">
						<div class="flex items-center gap-2 mb-3">
							<span class="material-symbols-outlined text-slate-900"
								data-icon="local_shipping">local_shipping</span>
							<h3 class="text-sm font-semibold uppercase tracking-wide">Shipping Address</h3>
						</div>
						<address class="not-italic text-base text-slate-600 leading-relaxed">
							4522 Innovation Way<br />
							Suite 300 - Building B<br />
							Palo Alto, CA 94304<br />
							United States
						</address>
					</div>
					<div class="pt-6 border-t border-slate-400">
						<div class="flex items-center gap-2 mb-3">
							<span class="material-symbols-outlined text-slate-900" data-icon="receipt">receipt</span>
							<h3 class="text-sm font-semibold uppercase tracking-wide">Billing Address</h3>
						</div>
						<address class="not-italic text-base text-slate-600 leading-relaxed">
							4522 Innovation Way<br />
							Suite 300 - Building B<br />
							Palo Alto, CA 94304<br />
							United States
						</address>
					</div>
				</div>
				<!-- Payment Information Card -->
				<div class="bg-white border border-slate-400 rounded-xl p-6 shadow-sm">
					<h3 class="text-sm font-semibold uppercase tracking-wide mb-4">Payment Info</h3>
					<div
						class="flex items-center justify-between p-3 bg-slate-50 rounded-lg border border-slate-400">
						<div class="flex items-center gap-3">
							<div class="bg-white p-1 rounded border border-slate-400">
								<img alt="Visa Card"
									data-alt="A professional graphic icon representing a Visa credit card, featuring the clean blue and gold logo. The image is styled as a flat UI element with precise lines and a corporate finish, fitting perfectly into a modern checkout or billing interface. The background is a crisp, neutral white."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuDMaXf0z2AkjAiB1i8-enCyPKHt1KigBQnduVKTY6u08ajw2kyVGyPSM45aTP2xobYjTe9BSmSIqhKQ_SxEsYZxC-SlLjGRBbucYEGoNcoRMapTUADfkI_R7hyYI-qZ3_CCQ7nutrFONcQw9Tu4B4YsoxZDekoorvF-JkZIEVBesVAaj9ogR0nqwDfZK1xyuYsQ3zUzsWV1gO4SQTUQHfxUQ_P102XhyfE3bqoYcOVNzIGjqIBKW0yP7ElBN-4z4-quSBjSIwgsk57I" />
							</div>
							<div>
								<p class="text-xs font-bold text-slate-900">Visa ending in 4242</p>
								<p class="text-[10px] text-slate-600">Expires 12/26</p>
							</div>
						</div>
						<span class="material-symbols-outlined text-green-600" data-icon="verified" data-weight="fill"
							style="font-variation-settings: 'FILL' 1;">verified</span>
					</div>
				</div>
			</div>
		</div>
	</main>
</template>
