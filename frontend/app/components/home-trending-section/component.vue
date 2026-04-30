<template>
    <section class="w-full bg-surface-container-lowest py-16 border-t border-surface-variant">
        <div class="max-w-[1280px] mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Trending Now</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mt-2 max-w-2xl mx-auto">Items currently
                    capturing the attention of our discerning clientele.
                </p>
            </div>

            <CardListComponent />

            <div class="mt-12 flex justify-center">
                <LinkButtonComponent text="Load More Products" url="#" :is_dark="false" class="px-8" />
            </div>
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
