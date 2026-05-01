<template>
    <NuxtLink :to="url" class="border px-6 py-3 text-lg font-medium transition duration-200 hover:scale-[1.02]" :class="is_dark === true ? 'bg-black text-white py-4' : 'border-2 bg-transparent text-black'">{{ text }}</NuxtLink>
</template>

<script setup lang="ts">
const { text, url, is_dark } = defineProps({
    text: {
        type: String,
        required: true
    },
    url: {
        type: String,
        required: true
    },
    is_dark: {
        type: Boolean,
        required: true
    },
})
</script>
