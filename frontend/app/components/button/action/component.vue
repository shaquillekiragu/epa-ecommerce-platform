<template>
	<button
		:type="button_type"
		:disabled="disabled"
		class="flex items-center gap-2 border font-medium transition duration-200 hover:scale-[1.02] hover:cursor-pointer disabled:cursor-not-allowed disabled:opacity-50 disabled:hover:scale-100"
		:class="is_dark === true ? 'bg-black text-white' : 'border-2 bg-transparent text-black'"
		@click.stop.prevent="on_click"
	>
		<UIcon v-if="icon.length" :name="icon" class="size-4" />
		{{ text }}
	</button>
</template>

<script setup lang="ts">
import type { PropType, ButtonHTMLAttributes } from 'vue';

const emit = defineEmits<{
	click: [event: MouseEvent];
}>();

const { text, button_type, is_dark, icon, disabled } = defineProps({
	text: {
		type: String,
		required: true,
	},
	button_type: {
		type: String as PropType<ButtonHTMLAttributes['type']>,
		required: true,
	},
	is_dark: {
		type: Boolean,
		required: true,
	},
	icon: {
		type: String,
		default: '',
	},
	disabled: {
		type: Boolean,
		default: false,
	},
});

function on_click(e: MouseEvent) {
	emit('click', e);
}
</script>
