<template>
    <section class="w-full max-w-7xl flex flex-col md:flex-row items-center gap-12 px-6 py-16 md:py-24 border-b overflow-hidden">
        <article class="flex flex-col flex-1 gap-6 z-10">
            <p class="uppercase font-medium opacity-60">New Collection</p>
            
            <h1 class="text-5xl font-bold">Elevate Your Everyday.</h1>

            <p class="text-lg opacity-70">
                Discover curated collections of premium electronics, timeless fashion, and elegant home
                essentials designed for those who demand excellence.
            </p>

            <div class="mt-4">
                <LinkButtonComponent text="Shop Now" url="/catalogue" :is_dark="true" class="px-16" />
            </div>
        </article>

        <TriCardComponent :cards="cards" :is_section_large="false" />
    </section>
</template>

<script setup lang="ts">
import type { ProductCategory } from '~/types/product-category';

const cards: ProductCategory[] = [
    {
        'id': 1,
        'category_name': 'Sneakers',
        'thumbnail': 'https://lh3.googleusercontent.com/aida-public/AB6AXuAlxnrWt_gMa7UF15hTXAen0wNOxGpFHbQ5fNZwF37f4in-0UQ5NnUoLKa7NJFAmzSYarAUK7G8Omq5nLGKCtkX5bMIT0ehkncGhL_LqeHk3aaNtziNFsGVpagutbkLCIJYne409JH7HUMEZlD0PJ7g9YCB0IvfFh2itfCdUUc6B__4UuQr8Jsh7xF3relYOmDznwYvcoHMGb_xRhazEO_iEJU60QhbJPwfpMEikqWoorYAzVinvpCpw4_glRR_fzCIQByP8GUVdXhB',
        'products_by_category_url': '#',
    },
    {
        'id': 2,
        'category_name': 'Audio',
        'thumbnail': 'https://lh3.googleusercontent.com/aida-public/AB6AXuDAzUpBqQ-Bh3LcO7H9qydum8LaCWKG_VRcixf0RQmtfJJx6VFVtjtAoJsCVxsaub81rPxkEslhLIfrw7UTUPpr6-ztepNya5N5yAlPr2t4JMm7UMgW7V6Jhjh0enzrolb2YIkjt0gNAQnFwWf-451fiwIlZnLdySnp99FhtKuBlqhWT2_FCkGALUDCo_6Xv8udrnbdk9OrqkaSr_fp9emVDIJqLmm6sZ8GT7HU4kBkcjizWoiPJdQUVspgFvdU8qHDDtg-EpdNdVQC',
        'products_by_category_url': '#',
    },
    {
        'id': 3,
        'category_name': 'Watches',
        'thumbnail': 'https://lh3.googleusercontent.com/aida-public/AB6AXuCPg5T2Q__xF4ZKGG7YG6x-vd1f27QP0r6gX54rsYW5T-rta_0X9K9zP6TeoibTptJmx31PkOdMK_7kA7sNFaXA_l5XP9t68VdVvVAjr2ubD9uW1-IFcr11H1MaP7xqW_Ad1e8hakxuakwRo2oduQbubIgFZ2LR4csfbYHlE6bc6L8QaooZ9w9nzVbBVoObD3beUyjVmht0KsbXc6dRf68ScZCPiKM-sdwfCKAJVT6Zx1L6O54FrLiTW20KVLk35eTnwrM7UrCldDUQ',
        'products_by_category_url': '#',
    },
]

</script>
