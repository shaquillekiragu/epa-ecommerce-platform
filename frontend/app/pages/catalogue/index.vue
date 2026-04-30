<template>
	<main class="flex-grow w-full max-w-7xl mx-auto px-md py-lg flex flex-col md:flex-row gap-lg">
		<!-- Sidebar Filters -->
		<aside class="w-full md:w-64 flex-shrink-0">
			<div class="sticky top-24">
				<h2 class="font-headline-md text-headline-md text-on-surface mb-md">Filters</h2>
				<div class="space-y-md">
					<!-- Category Filter -->
					<div class="border-b border-outline-variant pb-md">
						<h3 class="font-label-md text-label-md text-on-surface mb-sm">Category</h3>
						<div class="space-y-sm">
							<label class="flex items-center space-x-3 cursor-pointer">
								<input checked
									class="form-checkbox h-4 w-4 text-primary border-outline-variant rounded-DEFAULT focus:ring-primary"
									type="checkbox" />
								<span class="font-body-md text-body-md text-on-surface-variant">All Products</span>
							</label>
							<label class="flex items-center space-x-3 cursor-pointer">
								<input
									class="form-checkbox h-4 w-4 text-primary border-outline-variant rounded-DEFAULT focus:ring-primary"
									type="checkbox" />
								<span class="font-body-md text-body-md text-on-surface-variant">Electronics</span>
							</label>
							<label class="flex items-center space-x-3 cursor-pointer">
								<input
									class="form-checkbox h-4 w-4 text-primary border-outline-variant rounded-DEFAULT focus:ring-primary"
									type="checkbox" />
								<span class="font-body-md text-body-md text-on-surface-variant">Home &amp; Garden</span>
							</label>
							<label class="flex items-center space-x-3 cursor-pointer">
								<input
									class="form-checkbox h-4 w-4 text-primary border-outline-variant rounded-DEFAULT focus:ring-primary"
									type="checkbox" />
								<span class="font-body-md text-body-md text-on-surface-variant">Apparel</span>
							</label>
						</div>
					</div>

					<!-- Price Range Filter -->
					<div class="border-b border-outline-variant pb-md">
						<h3 class="font-label-md text-label-md text-on-surface mb-sm">Price Range</h3>
						<div class="flex items-center space-x-2">
							<input
								class="w-full bg-surface-container-lowest border border-outline-variant rounded-DEFAULT p-sm font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0"
								placeholder="Min" type="text" />
							<span class="text-on-surface-variant">-</span>
							<input
								class="w-full bg-surface-container-lowest border border-outline-variant rounded-DEFAULT p-sm font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0"
								placeholder="Max" type="text" />
						</div>
					</div>

					<!-- Stock Status Filter -->
					<div>
						<h3 class="font-label-md text-label-md text-on-surface mb-sm">Availability</h3>
						<div class="space-y-sm">
							<label class="flex items-center space-x-3 cursor-pointer">
								<input checked
									class="form-radio h-4 w-4 text-primary border-outline-variant focus:ring-primary"
									name="stock" type="radio" />
								<span class="font-body-md text-body-md text-on-surface-variant">In Stock</span>
							</label>
							<label class="flex items-center space-x-3 cursor-pointer">
								<input class="form-radio h-4 w-4 text-primary border-outline-variant focus:ring-primary"
									name="stock" type="radio" />
								<span class="font-body-md text-body-md text-on-surface-variant">Out of Stock</span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</aside>

		<!-- Product Grid Area -->
		<section class="flex-grow flex flex-col">
			<!-- Toolbar -->
			<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-md gap-4">
				<h1 class="font-headline-lg text-headline-lg text-on-surface">Premium Collection</h1>
				<div class="flex items-center gap-4 w-full sm:w-auto">
					<div class="relative w-full sm:w-64">
						<span
							class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
						<input
							class="w-full bg-surface-container-lowest border border-outline-variant rounded-DEFAULT py-sm pl-10 pr-4 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0"
							placeholder="Search products..." type="text" />
					</div>
					<select
						class="bg-surface-container-lowest border border-outline-variant rounded-DEFAULT p-sm font-body-md text-body-md text-on-surface focus:border-primary focus:ring-0 cursor-pointer hidden sm:block">
						<option>Recommended</option>
						<option>Price: Low to High</option>
						<option>Price: High to Low</option>
						<option>Newest Arrivals</option>
					</select>
				</div>
			</div>

			<!-- Grid -->
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-grid_gutter">
				<!-- Product Card 1 -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden flex flex-col hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow duration-200">
					<div class="h-48 w-full bg-surface-container-highest relative">
						<img alt="Minimalist smart watch with a clean white face and grey band on a plain background"
							class="w-full h-full object-cover"
							data-alt="Minimalist smart watch with a clean white face and grey band on a plain background"
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQyyzuyPMo8Bju05LvbZVbO3ZfqLtfx673f6HTYbr1SSbDCQOHgoj_JFIJwNgl5MIEUCNR9qpDMm1VXiB4uhHtDE_rPR__NdAYvVqXiiDwUtYPzNQ17rqyZkfNfw2cTk4Ee4iJJjjFNLY04fI-uC83_lw1-cZZNSrIhpuchzdTrvw1eKKG4FQcIGVA9fxf-U2UczdkmBvWI11uBvR1IvhzHFUmlzvW0rR1c-zEh-e7GltOUEt_UhhgKQ2jePH3IagEp2vLl0zGyl-r" />
					</div>
					<div class="p-4 flex flex-col flex-grow">
						<h3 class="font-headline-md text-headline-md text-on-surface mb-xs line-clamp-1">Chronograph
							Smartwatch</h3>
						<p class="font-body-md text-body-md text-on-surface-variant mb-md flex-grow line-clamp-2">Sleek,
							minimalist design with advanced health tracking features.</p>
						<div
							class="flex justify-between items-center mt-auto pt-2 border-t border-surface-container-highest">
							<span class="font-body-lg text-body-lg font-bold text-primary">$299.00</span>
							<button
								class="bg-primary text-on-primary px-4 py-2 rounded-DEFAULT font-label-md text-label-md hover:bg-on-surface transition-colors flex items-center gap-2">
								<span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
								Add
							</button>
						</div>
					</div>
				</div>

				<!-- Product Card 2 -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden flex flex-col hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow duration-200">
					<div class="h-48 w-full bg-surface-container-highest relative">
						<img alt="High-end over-ear studio headphones resting on a dark sleek surface with dramatic lighting"
							class="w-full h-full object-cover"
							data-alt="High-end over-ear studio headphones resting on a dark sleek surface with dramatic lighting"
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6g4Q5jZ-O9UP18dFdVUXlg-oygmNWEbD-jgvJyPF0m447xLG0A7iTz0IjpbqfhJyqms55JGxOovd60eKKfH2oD3zDzPA6TbcnvH9V_TH0R7Rkk35DrEZ3SC7NX48s0NLdAiUKnSMcXsfgJ0W7cVh0Wbjmi1WDaWX_t5nI4o7JXvzs7Wz9ye3744PGBq39E9-8sjHNGjVqGjeAg7-stwv-G1J_vbs2f-JA8kTls1YgkAFinIanqD510RejJpMyXWchpbBAjYn1OLG7" />
					</div>
					<div class="p-4 flex flex-col flex-grow">
						<h3 class="font-headline-md text-headline-md text-on-surface mb-xs line-clamp-1">Aura Studio
							Headphones</h3>
						<p class="font-body-md text-body-md text-on-surface-variant mb-md flex-grow line-clamp-2">Active
							noise cancellation with studio-grade sound reproduction.</p>
						<div
							class="flex justify-between items-center mt-auto pt-2 border-t border-surface-container-highest">
							<span class="font-body-lg text-body-lg font-bold text-primary">$349.50</span>
							<button
								class="bg-primary text-on-primary px-4 py-2 rounded-DEFAULT font-label-md text-label-md hover:bg-on-surface transition-colors flex items-center gap-2">
								<span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
								Add
							</button>
						</div>
					</div>
				</div>
				<!-- Product Card 3 -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden flex flex-col hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow duration-200">
					<div class="h-48 w-full bg-surface-container-highest relative">
						<img alt="Minimalist ceramic pour-over coffee maker set on a light wood kitchen counter"
							class="w-full h-full object-cover"
							data-alt="Minimalist ceramic pour-over coffee maker set on a light wood kitchen counter"
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzXGnXhpG9OzkZmpZz-B73aGTXl1iNy1fKSLWuKaqWRCRvbPtzKORyRSNQf9ayl93z_wosLPt1qg7kXzTsSCgDXINK8mZLbXfe8IccIRbkRe_tX5NPEQA-_8f-F0NOVFrqUi3QLG2j5A1vtPtkwW_fJa5u1nt95zkI8ha-hHMnF7vfPzuez2bh9aKytMTqwJDXYAMcsVW_IqRm-MfMTFnk1rtfFGxNOVJRqg-i-SfQ_-wl952-4-p5qRbncJf6vVtVH3-KmQOvhNa5" />
					</div>
					<div class="p-4 flex flex-col flex-grow">
						<h3 class="font-headline-md text-headline-md text-on-surface mb-xs line-clamp-1">Artisan
							Pour-Over Set</h3>
						<p class="font-body-md text-body-md text-on-surface-variant mb-md flex-grow line-clamp-2">
							Hand-crafted ceramic set for the perfect morning brew ritual.</p>
						<div
							class="flex justify-between items-center mt-auto pt-2 border-t border-surface-container-highest">
							<span class="font-body-lg text-body-lg font-bold text-primary">$85.00</span>
							<button
								class="bg-primary text-on-primary px-4 py-2 rounded-DEFAULT font-label-md text-label-md hover:bg-on-surface transition-colors flex items-center gap-2">
								<span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
								Add
							</button>
						</div>
					</div>
				</div>
				<!-- Product Card 4 -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden flex flex-col hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow duration-200">
					<div class="h-48 w-full bg-surface-container-highest relative">
						<img alt="Vintage style instant camera resting on a colorful patterned fabric with soft natural light"
							class="w-full h-full object-cover"
							data-alt="Vintage style instant camera resting on a colorful patterned fabric with soft natural light"
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuA50OmyAKcg-1jOCo-NetkshDh_mmriA1RsStiBj1IJALJI86RY3Vm142_0LQByng0lGPfuho7GAMvfFLKfHTr5u-fFyz0swvy_4iDyMkNEjCAEytHD5gzWc4lXgVrWcNirVuPggYxfs7YVSawNtCXJtiUnURQnzJIxoj2b7EjiJLhCHpcKJZ4IayKSg-uol6vFeyYxi3zJWhIvuyI0WI5YumNtEM6xZ_vYBV5NeKzlSXOvfZq8n_Sj0IsYXoWv_lSu0UBn5D2sz3Tf" />
					</div>
					<div class="p-4 flex flex-col flex-grow">
						<h3 class="font-headline-md text-headline-md text-on-surface mb-xs line-clamp-1">Retro Instant
							Camera</h3>
						<p class="font-body-md text-body-md text-on-surface-variant mb-md flex-grow line-clamp-2">
							Capture memories instantly with classic vintage styling.</p>
						<div
							class="flex justify-between items-center mt-auto pt-2 border-t border-surface-container-highest">
							<span class="font-body-lg text-body-lg font-bold text-primary">$129.99</span>
							<button
								class="bg-primary text-on-primary px-4 py-2 rounded-DEFAULT font-label-md text-label-md hover:bg-on-surface transition-colors flex items-center gap-2">
								<span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
								Add
							</button>
						</div>
					</div>
				</div>
				<!-- Product Card 5 -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden flex flex-col hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow duration-200">
					<div class="h-48 w-full bg-surface-container-highest relative">
						<img alt="Vibrant red athletic running shoe suspended mid-air against a stark dark background"
							class="w-full h-full object-cover"
							data-alt="Vibrant red athletic running shoe suspended mid-air against a stark dark background"
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuBanppMpZkWX00vOfTnPdov10Llx78bqqHkOuzZSrSLX-2pwl-W-_kT2xL88fkEy6G6Xl6kdTCqpH0YZjAuMNGWeiVFHEqu9VmiNV6WGGz6QxcPVl4C5wMhmE17e6cHkJkT3gwCYZ5F2FqgKZfTwWIt4N6FU0mlIsPoMp-OLtAdzuQqPZdjAMoC8sVX4a1xMvWRCsm5u3HSe8yHFecqYCUhNcHNJ86RbjrnJoh2iXQJXhKDbO6QTTJktKwUHYvg95VEDreJxKbgwHUN" />
					</div>
					<div class="p-4 flex flex-col flex-grow">
						<h3 class="font-headline-md text-headline-md text-on-surface mb-xs line-clamp-1">Velocity
							Runners</h3>
						<p class="font-body-md text-body-md text-on-surface-variant mb-md flex-grow line-clamp-2">
							Ultra-lightweight performance sneakers for elite athletes.</p>
						<div
							class="flex justify-between items-center mt-auto pt-2 border-t border-surface-container-highest">
							<span class="font-body-lg text-body-lg font-bold text-primary">$165.00</span>
							<button
								class="bg-primary text-on-primary px-4 py-2 rounded-DEFAULT font-label-md text-label-md hover:bg-on-surface transition-colors flex items-center gap-2">
								<span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
								Add
							</button>
						</div>
					</div>
				</div>
				<!-- Product Card 6 -->
				<div
					class="bg-surface-container-lowest border border-outline-variant rounded-lg overflow-hidden flex flex-col hover:shadow-[0_4px_12px_rgba(15,23,42,0.05)] transition-shadow duration-200">
					<div class="h-48 w-full bg-surface-container-highest relative">
						<img alt="Modern white smart speaker sitting on a wooden shelf beside a small green succulent plant"
							class="w-full h-full object-cover"
							data-alt="Modern white smart speaker sitting on a wooden shelf beside a small green succulent plant"
							src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTefx-Zr7C3Zz09rxeBvmAXBZicGaXOe12Q22BL8OySXqwHFQsktmta50p3IZaQrHDzSZSrNfXJVygilydEZb_uHpKGWSYCqugICYGGaFaX2GQV_v-HY3DIax-dVRdWJqToCtDcg-_fYu2HyJzdIS_Q035sRN-tpS0ComlgmeVGVSpHK1BnqtGDtGAumyZyGo07KkRR-jXUnbZZWDQHcSVPZs1skgJeip5XsM3a8kfQd6A0PXozoNFp6xer71uGYZ9RsNKHiUMVi84" />
					</div>
					<div class="p-4 flex flex-col flex-grow">
						<h3 class="font-headline-md text-headline-md text-on-surface mb-xs line-clamp-1">Echo Home Hub
						</h3>
						<p class="font-body-md text-body-md text-on-surface-variant mb-md flex-grow line-clamp-2">
							Control your entire smart home from this sleek central unit.</p>
						<div
							class="flex justify-between items-center mt-auto pt-2 border-t border-surface-container-highest">
							<span class="font-body-lg text-body-lg font-bold text-primary">$199.00</span>
							<button
								class="bg-primary text-on-primary px-4 py-2 rounded-DEFAULT font-label-md text-label-md hover:bg-on-surface transition-colors flex items-center gap-2">
								<span class="material-symbols-outlined text-[18px]">add_shopping_cart</span>
								Add
							</button>
						</div>
					</div>
				</div>
			</div>
			<!-- Pagination (Simple implementation for design) -->
			<div class="mt-lg flex justify-center items-center space-x-2">
				<button
					class="px-4 py-2 border border-outline-variant rounded-DEFAULT font-label-md text-label-md text-on-surface hover:bg-surface-container-highest transition-colors disabled:opacity-50"
					disabled>Previous</button>
				<button
					class="w-10 h-10 flex items-center justify-center border border-primary bg-primary text-on-primary rounded-DEFAULT font-label-md text-label-md">1</button>
				<button
					class="w-10 h-10 flex items-center justify-center border border-outline-variant text-on-surface hover:bg-surface-container-highest rounded-DEFAULT font-label-md text-label-md transition-colors">2</button>
				<button
					class="w-10 h-10 flex items-center justify-center border border-outline-variant text-on-surface hover:bg-surface-container-highest rounded-DEFAULT font-label-md text-label-md transition-colors">3</button>
				<button
					class="px-4 py-2 border border-outline-variant rounded-DEFAULT font-label-md text-label-md text-on-surface hover:bg-surface-container-highest transition-colors">Next</button>
			</div>
		</section>
	</main>
</template>

<script setup lang="ts">
import type { ProductCard } from '~/types/product';

const products: ProductCard[] = [
	{
        id: 1,
        name: 'Series X Chronograph Smartwatch',
        product_category_name: 'Electronics',
        price_in_gbp: 499,
        thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDfH9wPMTMr_wD6yLx_pbGR6aMEcyawkhlpBGqHTlqE7dfxFrDibbI3hWtqLMRNQb70Tgqh33_-ROtzqWhLXr95jGm021_GcKRxhX6NLTGbhAieM-0eKwFsAZMoaYNCgmRMshclnPnz7cPPOA7kXut6O_gvBQiv_4_rUlGtRWBMtptWuVX88bgb1K2cyRZPw2TD3r_AR3lLOAGBavsZ6EFLnhHtBlyKBo3gCjkduy2SmnbWFOgLpQpvysNuOUxrIdzk4veMMC2oWfPs',
        product_url: ''
	},
	{
		id: 2,
		name: 'Artisan Leather Tote',
		product_category_name: 'Fashion',
		price_in_gbp: 285,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuDAo9Zgpjz_whssbG4qQcGf5T85N0DH5FzylFdl1fPE_lN33BSswwMU0zIBuxe8tpH84kEj3etgBVkhOsfVRlHKzg6tcn_6Pd4UJ8mDG8ppijFEEP_vEKnlJhniZv0RcXZzk4-0W8IKhofhN5D0vWhw0eOcHo7005biU8aORsJPTLze12r0F_CH2eVQKmHdEePg4aIYzXefT4zhtj3LYjUyOvhn1f1NnaQ7UpFyupqa5xOvkLrHBKdXK6w1k7e-gDo5kXq1Vx617dgZ',
		product_url: '',
	},
	{
		id: 3,
		name: 'Aura Pro Noise-Cancelling Audio',
		product_category_name: 'Electronics',
		price_in_gbp: 349,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuDQ8j7F5WmQ1NqAfnkqK_2mxo6km14ozRgXsgjrSjfYpsKHY68xoF-ga7ZfSjuUDSaZ7VTzsBEQq3SJ32eh_zw6Zncozn68FcbyCenan0LWG2URk07fHOevaUx0vHwRuCQN80VHboALXrFcuAl0dkltyxNE0M2MHd7vswGQhOhZY4NfWAYZafq7qmxgcd0MDzn1OjDWm8zUdPIWGgZmdkeFXDlDFyTUV0JQZyvmnYgaJeQYckiCkEpX-ko7V9Xx_yRcGeDjX34cnK5v',
		product_url: '',
	},
	{
		id: 4,
		name: 'Sculptural Ceramic Vase',
		product_category_name: 'Home Decor',
		price_in_gbp: 120,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuCWXKImU18UrDzp-uX3wf3_EL77Ub7FUZ27zkJp-RHc5A9dsSbv4377VF6lpmjdrvjXW9PZkQdiX9wv02xC_-tdi3jXcy1VuwnoVGFrgRC31OnL4mg5jGrReSDiGl839-KoxZfbTpOXWtO8HcaLA1qXE6gVtJlyCi1554Q6HGH_HpJAnvhzeJG3iqaHgTgyfXb1CuTIBGQJsKA93Qu3YJSbHKTHsHgnX2eTry5RLyh6oEEndmYC_0a--t-YD10CSbW2XsY0uSr0tYSG',
		product_url: '',
	},
	{
		id: 5,
		name: 'Chronograph Smartwatch',
		product_category_name: '',
		price_in_gbp: 299,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuDQyyzuyPMo8Bju05LvbZVbO3ZfqLtfx673f6HTYbr1SSbDCQOHgoj_JFIJwNgl5MIEUCNR9qpDMm1VXiB4uhHtDE_rPR__NdAYvVqXiiDwUtYPzNQ17rqyZkfNfw2cTk4Ee4iJJjjFNLY04fI-uC83_lw1-cZZNSrIhpuchzdTrvw1eKKG4FQcIGVA9fxf-U2UczdkmBvWI11uBvR1IvhzHFUmlzvW0rR1c-zEh-e7GltOUEt_UhhgKQ2jePH3IagEp2vLl0zGyl-r',
		product_url: '',
	},
	{
		id: 6,
		name: 'Aura Studio Headphones',
		product_category_name: '',
		price_in_gbp: 349.5,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuB6g4Q5jZ-O9UP18dFdVUXlg-oygmNWEbD-jgvJyPF0m447xLG0A7iTz0IjpbqfhJyqms55JGxOovd60eKKfH2oD3zDzPA6TbcnvH9V_TH0R7Rkk35DrEZ3SC7NX48s0NLdAiUKnSMcXsfgJ0W7cVh0Wbjmi1WDaWX_t5nI4o7JXvzs7Wz9ye3744PGBq39E9-8sjHNGjVqGjeAg7-stwv-G1J_vbs2f-JA8kTls1YgkAFinIanqD510RejJpMyXWchpbBAjYn1OLG7',
		product_url: '',
	},
	{
		id: 7,
		name: 'Artisan Pour-Over Set',
		product_category_name: '',
		price_in_gbp: 85,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuBzXGnXhpG9OzkZmpZz-B73aGTXl1iNy1fKSLWuKaqWRCRvbPtzKORyRSNQf9ayl93z_wosLPt1qg7kXzTsSCgDXINK8mZLbXfe8IccIRbkRe_tX5NPEQA-_8f-F0NOVFrqUi3QLG2j5A1vtPtkwW_fJa5u1nt95zkI8ha-hHMnF7vfPzuez2bh9aKytMTqwJDXYAMcsVW_IqRm-MfMTFnk1rtfFGxNOVJRqg-i-SfQ_-wl952-4-p5qRbncJf6vVtVH3-KmQOvhNa5',
		product_url: '',
	},
	{
		id: 8,
		name: 'Retro Instant Camera',
		product_category_name: '',
		price_in_gbp: 129.99,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuA50OmyAKcg-1jOCo-NetkshDh_mmriA1RsStiBj1IJALJI86RY3Vm142_0LQByng0lGPfuho7GAMvfFLKfHTr5u-fFyz0swvy_4iDyMkNEjCAEytHD5gzWc4lXgVrWcNirVuPggYxfs7YVSawNtCXJtiUnURQnzJIxoj2b7EjiJLhCHpcKJZ4IayKSg-uol6vFeyYxi3zJWhIvuyI0WI5YumNtEM6xZ_vYBV5NeKzlSXOvfZq8n_Sj0IsYXoWv_lSu0UBn5D2sz3Tf',
		product_url: '',
	},
	{
		id: 9,
		name: 'Velocity Runners',
		product_category_name: '',
		price_in_gbp: 165,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuBanppMpZkWX00vOfTnPdov10Llx78bqqHkOuzZSrSLX-2pwl-W-_kT2xL88fkEy6G6Xl6kdTCqpH0YZjAuMNGWeiVFHEqu9VmiNV6WGGz6QxcPVl4C5wMhmE17e6cHkJkT3gwCYZ5F2FqgKZfTwWIt4N6FU0mlIsPoMp-OLtAdzuQqPZdjAMoC8sVX4a1xMvWRCsm5u3HSe8yHFecqYCUhNcHNJ86RbjrnJoh2iXQJXhKDbO6QTTJktKwUHYvg95VEDreJxKbgwHUN',
		product_url: '',
	},
	{
		id: 10,
		name: 'Echo Home Hub',
		product_category_name: '',
		price_in_gbp: 199,
		thumbnail:
			'https://lh3.googleusercontent.com/aida-public/AB6AXuBTefx-Zr7C3Zz09rxeBvmAXBZicGaXOe12Q22BL8OySXqwHFQsktmta50p3IZaQrHDzSZSrNfXJVygilydEZb_uHpKGWSYCqugICYGGaFaX2GQV_v-HY3DIax-dVRdWJqToCtDcg-_fYu2HyJzdIS_Q035sRN-tpS0ComlgmeVGVSpHK1BnqtGDtGAumyZyGo07KkRR-jXUnbZZWDQHcSVPZs1skgJeip5XsM3a8kfQd6A0PXozoNFp6xer71uGYZ9RsNKHiUMVi84',
		product_url: '',
	},
]

</script>
