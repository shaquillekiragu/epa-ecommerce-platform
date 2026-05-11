<template>
	<span :class="span_class">{{ humanizeOrderStatus(status) }}</span>
</template>

<script setup lang="ts">
import { humanizeOrderStatus } from '~/utils/order-display';

const props = withDefaults(
	defineProps<{
		status: string;
		variant?: 'inline' | 'header';
	}>(),
	{ variant: 'inline' },
);

const span_class = computed(() =>
	props.variant === 'header'
		? 'inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-800'
		: 'inline-flex shrink-0 items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-700',
);
</script>
