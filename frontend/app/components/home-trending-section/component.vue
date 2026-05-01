<template>
    <section class="w-full max-w-7xl flex flex-col justify-center items-center px-6 py-16 border-t">
        <article class="flex flex-col gap-3 text-center mb-12">
            <h2 class="text-4xl">Trending Now</h2>

            <p class="max-w-2xl">
                Items currently capturing the attention of our discerning shoppers.
            </p>
        </article>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <CardListComponent :cards="cards" :has_limit="true" layout="portrait" variant="product" />
        </section>

        <LinkButtonComponent text="Load More Products" url="/catalogue" :is_dark="false" class="mt-12 px-8" />
    </section>
</template>

<script setup lang="ts">
import type { ProductCard } from '~/types/product';

const cards: ProductCard[] = [
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
        thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDAo9Zgpjz_whssbG4qQcGf5T85N0DH5FzylFdl1fPE_lN33BSswwMU0zIBuxe8tpH84kEj3etgBVkhOsfVRlHKzg6tcn_6Pd4UJ8mDG8ppijFEEP_vEKnlJhniZv0RcXZzk4-0W8IKhofhN5D0vWhw0eOcHo7005biU8aORsJPTLze12r0F_CH2eVQKmHdEePg4aIYzXefT4zhtj3LYjUyOvhn1f1NnaQ7UpFyupqa5xOvkLrHBKdXK6w1k7e-gDo5kXq1Vx617dgZ',
        product_url: ''
    },
    {
        id: 3,
        name: 'Aura Pro Noise-Cancelling Audio',
        product_category_name: 'Electronics',
        price_in_gbp: 349,
        thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDQ8j7F5WmQ1NqAfnkqK_2mxo6km14ozRgXsgjrSjfYpsKHY68xoF-ga7ZfSjuUDSaZ7VTzsBEQq3SJ32eh_zw6Zncozn68FcbyCenan0LWG2URk07fHOevaUx0vHwRuCQN80VHboALXrFcuAl0dkltyxNE0M2MHd7vswGQhOhZY4NfWAYZafq7qmxgcd0MDzn1OjDWm8zUdPIWGgZmdkeFXDlDFyTUV0JQZyvmnYgaJeQYckiCkEpX-ko7V9Xx_yRcGeDjX34cnK5v',
        product_url: ''
    },
    {
        id: 4,
        name: 'Sculptural Ceramic Vase',
        product_category_name: 'Home Decor',
        price_in_gbp: 120,
        thumbnail: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCWXKImU18UrDzp-uX3wf3_EL77Ub7FUZ27zkJp-RHc5A9dsSbv4377VF6lpmjdrvjXW9PZkQdiX9wv02xC_-tdi3jXcy1VuwnoVGFrgRC31OnL4mg5jGrReSDiGl839-KoxZfbTpOXWtO8HcaLA1qXE6gVtJlyCi1554Q6HGH_HpJAnvhzeJG3iqaHgTgyfXb1CuTIBGQJsKA93Qu3YJSbHKTHsHgnX2eTry5RLyh6oEEndmYC_0a--t-YD10CSbW2XsY0uSr0tYSG',
        product_url: ''
    },
]

</script>
