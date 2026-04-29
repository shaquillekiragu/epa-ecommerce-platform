<template>
    <a :href="url" class="border px-6 py-3 transition-colors" :class="is_dark === true ? 'bg-black text-white' : 'bg-transparent text-black'">{{ text }}</a>
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
