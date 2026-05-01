<template>
    <main class="w-screen flex flex-col flex-1 items-center gap-6 px-45 py-16">
        <article class="w-full flex flex-col gap-3 items-start text-left">
            <h2 class="text-5xl font-medium">All Categories</h2>

            <p class="text-lg opacity-75 mt-2">
                Explore our finest selections across domains.
            </p>
        </article>

        <section class="w-full grid grid-cols-1 lg:grid-cols-2 gap-10">
            <CardListComponent :cards="cards" :has_limit="false" layout="landscape" variant="default" />
        </section>
    </main>
</template>

<script setup lang="ts">
import { getProductCategories } from '#imports';

const cards = getProductCategories();

</script>
