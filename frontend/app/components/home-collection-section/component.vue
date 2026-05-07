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
                <ButtonLinkComponent text="Shop Now" url="/products" :is_dark="true" class="px-16" />
            </div>
        </article>

        <TriCardComponent :cards="cards" :is_section_large="false" variant="default-sm" />
    </section>
</template>

<script setup lang="ts">
import { useProducts } from '#imports';

const { product_cards } = useProducts();
const cards = computed(() => product_cards.value);

</script>
