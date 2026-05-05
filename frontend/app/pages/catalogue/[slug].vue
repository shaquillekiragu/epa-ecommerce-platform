<template>
	<main class="w-screen flex p-16 pr-4">
		<section class="lg:grid-cols-12 w-full grid grid-cols-1">
			<div class="w-full flex flex-col lg:col-span-7 ">
				<div
					class="aspect-square rounded-xl overflow-hidden relative border flex items-center justify-center">
					<img class="w-full h-full object-cover"
						data-alt="sleek modern over-ear wireless headphones resting on a pristine white minimalist studio table with soft dramatic shadow"
						src="https://lh3.googleusercontent.com/aida-public/AB6AXuBI7tdMnNbNZIYQyuZxpPLd9Z1sN-hGpE6abLRrFTg8z1-c4KCyWl4rSYazQbpR9aukGCBu1FRpCTn1xLirpDSRtQ0txN3zqRZ2oKrBp_AqqrbXYIQx0xmH8TD0HEMz6erbRMGJGTpW2mNwM_zCDMuVF2HfdSKkAbjhfgTTm998xTycGI9uZb-AtBOZOL867K78n0fvFRXs0bVQR0Gdiv05DKn_uaH8Nqavngn0ttMHjZoWc_Yv0BEOGXkVrBnyggK5FesBjN3NaSA_" />
				</div>
			</div>

			<div class="lg:col-span-5 w-full flex flex-col pl-12 pr-6">
				<h1 class="text-5xl font-bold">Aura Studio Wireless Headphones</h1>

				<div class="flex items-center">
					<span class="text-slate-900">£349.50</span>
					<span
						class="px-2 py-1 text-slate-700 rounded-full flex items-center gap-1 border border-slate-400">
						<span class=" text-[14px]">check_circle</span>
						In Stock
					</span>
				</div>

				<p class="font-normal text-lg mb-6">
					Experience unparalleled acoustic clarity with the Aura Studio Wireless Headphones. Featuring
					custom-tuned 50mm beryllium drivers and adaptive active noise cancellation, these headphones deliver
					an immersive soundscape tailored precisely to your environment, enveloped in aerospace-grade
					aluminum and premium memory foam.
				</p>
				
				<div class="border-t pt-6 flex flex-col mb-6">
					<div class="font-semibold text-sm mb-2">Quantity</div>
					<div class="flex flex-col sm:flex-row items-stretch sm:items-center">
						<div
							class="flex items-center border rounded-lg h-[56px] w-[140px] shrink-0">
							<button
								class="w-full h-full flex items-center justify-center hover:text-slate-900 transition-colors active:bg-slate-50 rounded-l-lg">
								<span class="">remove</span>
							</button>
							<span class="font-semibold text-sm w-[40px] text-center">1</span>
							<button
								class="w-full h-full flex items-center justify-center hover:text-slate-900 transition-colors active:bg-slate-50 rounded-r-lg">
								<span class="">add</span>
							</button>
						</div>
						<button
							class="flex-1 h-[56px] bg-slate-900 text-white rounded-lg font-semibold text-sm flex items-center justify-center gap-2 hover:bg-slate-800 transition-colors shadow-sm">
							<span class="">shopping_bag</span>
							Add to Basket
						</button>
					</div>
				</div>
				<div class="flex items-center pt-2">
					<button
						class="flex items-center gap-2 font-semibold text-sm hover:text-slate-900 transition-colors group">
						<span
							class=" text-[20px] group-hover:text-red-600 transition-colors">favorite</span>
						Save for Later
					</button>
				</div>
			</div>
		</section>

		<!-- <section class="mt-8 border-t pt-8">
			<div class="flex flex-col md:flex-row md:items-end justify-between mb-6 gap-4">
				<div>
					<h2 class=" mb-2">Technical Specifications</h2>
					<p class="font-normal text-base max-w-2xl">Precision engineering meets
						audiophile-grade materials for uncompromising performance.</p>
				</div>
			</div>
			<div class="grid grid-cols-1 md:grid-cols-3">
				<div
					class="border p-6 rounded-xl hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow group">
					<div
						class="w-[56px] h-[56px] bg-white border text-slate-900 rounded-full flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-colors">
						<span class=" text-[28px]">graphic_eq</span>
					</div>
					<h3 class="font-semibold tracking-tight text-xl leading-snug mb-2">Acoustics &amp; Drivers</h3>
					<ul class="font-normal text-base space-y-3">
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>50mm Custom Beryllium Drivers</span>
						</li>
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>Frequency Response: 10Hz - 40kHz</span>
						</li>
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>Impedance: 32 Ohms</span>
						</li>
					</ul>
				</div>
				<div
					class="border p-6 rounded-xl hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow group">
					<div
						class="w-[56px] h-[56px] bg-white border text-slate-900 rounded-full flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-colors">
						<span class=" text-[28px]">battery_charging_full</span>
					</div>
					<h3 class="font-semibold tracking-tight text-xl leading-snug mb-2">Battery &amp; Power</h3>
					<ul class="font-normal text-base space-y-3">
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>Up to 40 hours continuous playtime</span>
						</li>
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>Fast charge: 15 mins for 5 hours</span>
						</li>
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>USB-C charging interface</span>
						</li>
					</ul>
				</div>
				<div
					class="border p-6 rounded-xl hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow group">
					<div
						class="w-[56px] h-[56px] bg-white border text-slate-900 rounded-full flex items-center justify-center group-hover:bg-slate-900 group-hover:text-white transition-colors">
						<span class=" text-[28px]">bluetooth</span>
					</div>
					<h3 class="font-semibold tracking-tight text-xl leading-snug mb-2">Connectivity</h3>
					<ul class="font-normal text-base space-y-3">
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>Bluetooth 5.3 with multipoint</span>
						</li>
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>aptX Adaptive &amp; LDAC support</span>
						</li>
						<li class="flex items-start gap-2">
							<span class=" text-[18px] text-slate-400 mt-[2px]">check</span>
							<span>3.5mm analog input included</span>
						</li>
					</ul>
				</div>
			</div>
		</section> -->
	</main>
</template>
