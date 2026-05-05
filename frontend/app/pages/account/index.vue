<template>
	<main class="flex-1 md:ml-64 bg-slate-50 p-6 md:p-12 overflow-y-auto">
		<div class="max-w-5xl mx-auto">
			<!-- Welcome Section -->
			<header class="mb-12">
				<h1 class="font-bold tracking-tight text-3xl leading-tight text-slate-900 mb-2">Welcome back, Alexander</h1>
				<p class="font-normal text-base text-slate-600">Here is a summary of your recent activity
					and account status.</p>
			</header>
			<!-- Bento Grid: Quick Stats & Primary Actions -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
				<!-- Profile Card -->
				<div
					class="md:col-span-2 bg-white p-6 border border-slate-400 rounded shadow-sm flex flex-col justify-between">
					<div>
						<span
							class="font-semibold text-sm text-slate-600 uppercase tracking-wider mb-4 block">Primary
							Profile</span>
						<div class="flex items-center gap-4 mb-6">
							<div class="size-16 rounded-full overflow-hidden bg-slate-100">
								<img class="size-full object-cover"
									data-alt="A professional portrait of a man in his mid-30s with short hair and a warm, confident expression. He is wearing a dark, well-tailored business casual shirt. The background is a clean, neutral gray that emphasizes the subject, fitting a modern corporate light-mode aesthetic with soft, directional lighting."
									src="https://lh3.googleusercontent.com/aida-public/AB6AXuAcVgGwt4aWVGaYQcJJepzaJ-xNl3z7E6G48286Yz3etaO7q_2bhtkrtSkbWFQ-J5AQLVi-KDhJ7d2hzLB4wQUG5NQuVZlWgHIu1ZPSJnDGNz7Yk9i6-8wlNatBlHXRDzy7Rz94CbjQruG4Flit_la3LW6b8i5TiD_9Pklel5jhiYF1kY4MJPOUFXeInvQrqo0jy_NPRcW1vnc3KYk4KVoE414zySa7ADjiEgmDKL_lNCwBW9NZOJJrRFsvt6ML_F3lFCzKNaPVGhog" />
							</div>
							<div>
								<h3 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Alexander Sterling</h3>
								<p class="font-normal text-base text-slate-600">alex.sterling@corporate.com
								</p>
							</div>
						</div>
					</div>
					<div class="flex gap-3">
						<button
							class="bg-slate-900 text-white px-4 py-2 font-semibold text-sm rounded transition-all active:scale-95">Edit
							Profile</button>
						<button
							class="border border-slate-900 text-slate-900 px-4 py-2 font-semibold text-sm rounded hover:bg-slate-50 transition-all">Manage
							Privacy</button>
					</div>
				</div>
				<!-- Loyalty Card -->
				<div
					class="bg-slate-800 text-slate-50 p-6 rounded shadow-sm flex flex-col justify-between">
					<div>
						<span
							class="font-semibold text-sm text-slate-50 opacity-60 uppercase tracking-wider mb-2 block">Membership</span>
						<h3 class="font-semibold tracking-tight text-xl leading-snug text-white mb-2">Platinum Tier</h3>
						<p class="font-normal text-base text-slate-50 opacity-80">You're 2,400 points
							away from the Diamond elite status.</p>
					</div>
					<div class="w-full bg-white/10 h-1.5 rounded-full mt-4">
						<div class="bg-white h-full rounded-full" style="width: 75%"></div>
					</div>
				</div>
			</div>
			<!-- Recent Orders Table -->
			<section class="mb-12">
				<div class="flex items-center justify-between mb-6">
					<h2 class="font-semibold tracking-tight text-xl leading-snug text-slate-900">Recent Orders</h2>
					<a class="font-semibold text-sm text-slate-900 flex items-center gap-1 hover:underline"
						href="#">
						View All Orders <span class="material-symbols-outlined">arrow_forward</span>
					</a>
				</div>
				<div class="bg-white border border-slate-400 rounded overflow-hidden shadow-sm">
					<table class="w-full text-left border-collapse">
						<thead>
							<tr class="bg-slate-50 border-b border-slate-400">
								<th class="p-4 font-semibold text-sm text-slate-600">Order ID</th>
								<th class="p-4 font-semibold text-sm text-slate-600">Date</th>
								<th class="p-4 font-semibold text-sm text-slate-600">Items</th>
								<th class="p-4 font-semibold text-sm text-slate-600">Total</th>
								<th class="p-4 font-semibold text-sm text-slate-600">Status</th>
								<th class="p-4"></th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-200">
							<tr class="hover:bg-slate-50 transition-colors">
								<td class="p-4 font-semibold text-sm text-slate-900">#LX-99201</td>
								<td class="p-4 font-normal text-base text-slate-600">Oct 24, 2024</td>
								<td class="p-4 font-normal text-base text-slate-600">3 Items</td>
								<td class="p-4 text-base font-bold text-slate-900">$1,420.00</td>
								<td class="p-4">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">Shipped</span>
								</td>
								<td class="p-4 text-right">
									<button class="text-slate-900 hover:bg-slate-100 p-2 rounded-full transition-all">
										<span class="material-symbols-outlined">visibility</span>
									</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50 transition-colors">
								<td class="p-4 font-semibold text-sm text-slate-900">#LX-98442</td>
								<td class="p-4 font-normal text-base text-slate-600">Oct 12, 2024</td>
								<td class="p-4 font-normal text-base text-slate-600">1 Item</td>
								<td class="p-4 text-base font-bold text-slate-900">$89.00</td>
								<td class="p-4">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">Delivered</span>
								</td>
								<td class="p-4 text-right">
									<button class="text-slate-900 hover:bg-slate-100 p-2 rounded-full transition-all">
										<span class="material-symbols-outlined">visibility</span>
									</button>
								</td>
							</tr>
							<tr class="hover:bg-slate-50 transition-colors">
								<td class="p-4 font-semibold text-sm text-slate-900">#LX-97810</td>
								<td class="p-4 font-normal text-base text-slate-600">Sep 28, 2024</td>
								<td class="p-4 font-normal text-base text-slate-600">5 Items</td>
								<td class="p-4 text-base font-bold text-slate-900">$2,105.50</td>
								<td class="p-4">
									<span
										class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">Delivered</span>
								</td>
								<td class="p-4 text-right">
									<button class="text-slate-900 hover:bg-slate-100 p-2 rounded-full transition-all">
										<span class="material-symbols-outlined">visibility</span>
									</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</section>
			<!-- Quick Management Links -->
			<section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
				<div
					class="bg-white p-6 border border-slate-400 rounded shadow-sm hover:shadow-md transition-all group cursor-pointer">
					<div class="flex items-center gap-4 mb-4">
						<div
							class="size-10 bg-slate-100 rounded flex items-center justify-center text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">location_on</span>
						</div>
						<h3 class="font-semibold tracking-tight text-lg">Shipping Addresses</h3>
					</div>
					<p class="font-normal text-base text-slate-600 mb-4">Manage your saved home and office
						delivery locations.</p>
					<span class="text-slate-900 font-semibold text-sm">2 saved addresses</span>
				</div>
				<div
					class="bg-white p-6 border border-slate-400 rounded shadow-sm hover:shadow-md transition-all group cursor-pointer">
					<div class="flex items-center gap-4 mb-4">
						<div
							class="size-10 bg-slate-100 rounded flex items-center justify-center text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">payments</span>
						</div>
						<h3 class="font-semibold tracking-tight text-lg">Payment Methods</h3>
					</div>
					<p class="font-normal text-base text-slate-600 mb-4">Update your credit cards and
						secure digital wallets.</p>
					<span class="text-slate-900 font-semibold text-sm">Visa ending in 4242</span>
				</div>
				<div
					class="bg-white p-6 border border-slate-400 rounded shadow-sm hover:shadow-md transition-all group cursor-pointer">
					<div class="flex items-center gap-4 mb-4">
						<div
							class="size-10 bg-slate-100 rounded flex items-center justify-center text-slate-900 group-hover:bg-slate-900 group-hover:text-white transition-colors">
							<span class="material-symbols-outlined">security</span>
						</div>
						<h3 class="font-semibold tracking-tight text-lg">Security Settings</h3>
					</div>
					<p class="font-normal text-base text-slate-600 mb-4">Adjust password, 2FA, and
						notification preferences.</p>
					<span class="text-slate-900 font-semibold text-sm">Strong security status</span>
				</div>
			</section>
		</div>
	</main>
</template>
