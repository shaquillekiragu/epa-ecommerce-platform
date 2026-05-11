<template>
	<nav aria-label="Breadcrumb" v-bind="$attrs">
		<ol class="flex flex-wrap items-center gap-2 text-xs text-slate-600">
			<li v-for="(item, index) in visible_items" :key="index" class="flex min-w-0 max-w-full items-center gap-2">
				<template v-if="index > 0">
					<span class="material-symbols-outlined shrink-0 select-none text-sm text-slate-400" aria-hidden="true">chevron_right</span>
				</template>
				<NuxtLink v-if="item.to != null && item.to !== ''" :to="item.to" class="truncate hover:text-slate-900">
					{{ item.label }}
				</NuxtLink>
				<span v-else class="truncate font-semibold text-slate-900" aria-current="page">{{ item.label }}</span>
			</li>
		</ol>
	</nav>
</template>

<script setup lang="ts">
import type { BreadcrumbItem } from '~/types/breadcrumb';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
	items: BreadcrumbItem[];
}>();

const visible_items = computed(() => props.items.filter((i) => i.label.trim() !== ''));
</script>
