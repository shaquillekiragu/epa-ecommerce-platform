<template>
    <button :to="url" :type="button_type" class="flex items-center gap-2 border font-medium transition duration-200 hover:scale-[1.02] hover:cursor-pointer" :class="is_dark === true ? 'bg-black text-white' : 'border-2 bg-transparent text-black'" @click.stop >
        <UIcon v-if="icon.length" :name="icon" class="size-4" />
        {{ text }}
    </button>
</template>

<script setup lang="ts">
import type { PropType, ButtonHTMLAttributes } from 'vue'

const { text, url, button_type, is_dark, icon } = defineProps({
    text: {
        type: String,
        required: true
    },
    url: {
        type: String,
        required: true
    },
    button_type: {
        type: String as PropType<ButtonHTMLAttributes['type']>,
        required: true
    },
    is_dark: {
        type: Boolean,
        required: true
    },
    icon: {
        type: String,
        default: ''
    }
})

</script>
