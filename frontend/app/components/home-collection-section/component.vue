<template>
    <section class="w-full border-b overflow-hidden">
        <div class="max-w-320 mx-auto px-6 py-16 md:py-24 flex flex-col md:flex-row items-center gap-12">

            <div class="flex flex-col flex-1 gap-6 z-10">
                <p class="uppercase font-medium opacity-60">New Collection</p>
                <h1 class="text-5xl font-bold">Elevate Your Everyday.</h1>

                <p class="text-lg opacity-70">
                    Discover curated collections of premium electronics, timeless fashion, and elegant home
                    essentials designed for those who demand excellence.
                </p>

                <div class="flex gap-4 mt-2">
                    <LinkButtonComponent text="Shop Now" url="#" :is_dark="true" />
                    <LinkButtonComponent text="Explore Collections" url="#" :is_dark="false" />
                </div>
            </div>

            <TriCardSectionComponent :cards="cards" :is_large="false" />
        </div>
    </section>
</template>

<script setup lang="ts">
import type { ProductCard } from '~/types/product';

const cards: ProductCard[] = [
    {
        'id': 1,
        'name': 'Sneakers',
        'thumbnail': ''
    },
    {
        'id': 2,
        'name': 'Audio',
        'thumbnail': ''
    },
    {
        'id': 3,
        'name': 'Watches',
        'thumbnail': ''
    },
]

</script>
