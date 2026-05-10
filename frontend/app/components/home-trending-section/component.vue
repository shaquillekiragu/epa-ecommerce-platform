<template>
    <section class="w-full max-w-7xl flex flex-col justify-center items-center px-6 py-16 border-t">
        <article class="flex flex-col gap-3 text-center mb-12">
            <h2 class="text-4xl">Trending Now</h2>

            <p class="max-w-2xl">
                Items currently capturing the attention of our discerning shoppers.
            </p>
        </article>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <CardListComponent :cards="cards" :has_limit="true" layout="portrait" variant="trending-product" />
        </section>

        <ButtonLinkComponent text="Explore More Products..." url="/products" :is_dark="false" class="mt-12 px-8" />
    </section>
</template>

<script setup lang="ts">
import { useProducts } from '#imports';

const { product_cards } = useProducts();
const cards = computed(() => product_cards.value);

</script>
