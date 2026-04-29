<template>
    <section class="w-full relative bg-surface-container-lowest border-b border-surface-variant overflow-hidden">
        <div class="max-w-[1280px] mx-auto px-6 py-16 md:py-24 flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1 flex flex-col items-start gap-6 z-10">
                <span class="font-label-md text-label-md text-secondary uppercase tracking-widest">New
                    Collection</span>
                <h1 class="font-display-lg text-display-lg text-on-surface">Elevate Your Everyday.</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-lg">
                    Discover curated collections of premium electronics, timeless fashion, and elegant home
                    essentials designed for those who demand excellence.
                </p>
                
                <div class="flex gap-4 mt-2">
                    <LinkButtonComponent text="Shop Now" url="#" :is_dark="true" />
                    <LinkButtonComponent text="Explore Collections" url="#" :is_dark="false" />
                </div>
            </div>

            <div class="flex-1 w-full relative">
                <!-- Bento Grid Style Hero Images -->
                <div class="grid grid-cols-2 gap-4 h-[400px]">
                    <div class="col-span-1 row-span-2 rounded-xl overflow-hidden relative group">
                        <img alt="Premium red sneaker"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            data-alt="High-end red running shoe floating against a dark background with dramatic studio lighting and sharp details"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuAlxnrWt_gMa7UF15hTXAen0wNOxGpFHbQ5fNZwF37f4in-0UQ5NnUoLKa7NJFAmzSYarAUK7G8Omq5nLGKCtkX5bMIT0ehkncGhL_LqeHk3aaNtziNFsGVpagutbkLCIJYne409JH7HUMEZlD0PJ7g9YCB0IvfFh2itfCdUUc6B__4UuQr8Jsh7xF3relYOmDznwYvcoHMGb_xRhazEO_iEJU60QhbJPwfpMEikqWoorYAzVinvpCpw4_glRR_fzCIQByP8GUVdXhB" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="font-label-md text-label-md block">Sneakers</span>
                        </div>
                    </div>

                    <div class="col-span-1 row-span-1 rounded-xl overflow-hidden relative group">
                        <img alt="Minimalist headphones"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            data-alt="Sleek white over-ear premium headphones resting on a minimalist concrete surface with soft natural light"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDAzUpBqQ-Bh3LcO7H9qydum8LaCWKG_VRcixf0RQmtfJJx6VFVtjtAoJsCVxsaub81rPxkEslhLIfrw7UTUPpr6-ztepNya5N5yAlPr2t4JMm7UMgW7V6Jhjh0enzrolb2YIkjt0gNAQnFwWf-451fiwIlZnLdySnp99FhtKuBlqhWT2_FCkGALUDCo_6Xv8udrnbdk9OrqkaSr_fp9emVDIJqLmm6sZ8GT7HU4kBkcjizWoiPJdQUVspgFvdU8qHDDtg-EpdNdVQC" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="font-label-md text-label-md block">Audio</span>
                        </div>
                    </div>
                    
                    <div class="col-span-1 row-span-1 rounded-xl overflow-hidden relative group">
                        <img alt="Luxury watch"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                            data-alt="Close up of a classic silver mechanical watch face with intricate details against a dark tailored suit sleeve"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCPg5T2Q__xF4ZKGG7YG6x-vd1f27QP0r6gX54rsYW5T-rta_0X9K9zP6TeoibTptJmx31PkOdMK_7kA7sNFaXA_l5XP9t68VdVvVAjr2ubD9uW1-IFcr11H1MaP7xqW_Ad1e8hakxuakwRo2oduQbubIgFZ2LR4csfbYHlE6bc6L8QaooZ9w9nzVbBVoObD3beUyjVmht0KsbXc6dRf68ScZCPiKM-sdwfCKAJVT6Zx1L6O54FrLiTW20KVLk35eTnwrM7UrCldDUQ" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 text-white">
                            <span class="font-label-md text-label-md block">Watches</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
