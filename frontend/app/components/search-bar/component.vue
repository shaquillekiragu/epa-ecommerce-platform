<template>
	<form class="w-full max-w-2xl" role="search" @submit.prevent="flush_search">
		<label :for="input_id" class="mb-1.5 block text-sm font-medium text-slate-700">Search</label>
		<div class="relative flex gap-2">
			<input
				:id="input_id"
				v-model="model"
				type="search"
				name="search"
				:placeholder="placeholder"
				autocomplete="off"
				class="min-w-0 flex-1 rounded-md border border-slate-200 bg-white px-3 py-2.5 text-base text-slate-900 placeholder:text-slate-400 focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/15"
			/>
			<button
				v-if="model.trim() !== ''"
				type="button"
				class="shrink-0 rounded-md border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
				@click="clear_search"
			>
				Clear
			</button>
		</div>
	</form>
</template>

<script setup lang="ts">
const props = withDefaults(
	defineProps<{
		/** Query string key to read/write (default matches product API `search`). */
		query_key?: string;
		input_id?: string;
		placeholder?: string;
	}>(),
	{
		query_key: 'search',
		input_id: 'catalog-search',
		placeholder: 'Search by product name or SKU…',
	},
);

const model = defineModel<string>({ required: true });

const emit = defineEmits<{
	/** Fired after the URL is synced and the parent should reload list data. */
	apply: [];
}>();

const route = useRoute();
const router = useRouter();

function search_from_route(): string {
	const raw = route.query[props.query_key];
	if (Array.isArray(raw)) return typeof raw[0] === 'string' ? raw[0].trim() : '';
	return typeof raw === 'string' ? raw.trim() : '';
}

let search_debounce: ReturnType<typeof setTimeout> | null = null;

function sync_search_query_to_route(): void {
	const trimmed = model.value.trim();
	const next_query = { ...route.query } as Record<string, string | string[] | undefined>;
	if (trimmed) {
		next_query[props.query_key] = trimmed;
	} else {
		delete next_query[props.query_key];
	}
	void router.replace({ query: next_query });
}

function flush_search(): void {
	if (search_debounce) {
		clearTimeout(search_debounce);
		search_debounce = null;
	}
	sync_search_query_to_route();
	emit('apply');
}

function clear_search(): void {
	model.value = '';
	flush_search();
}

watch(model, () => {
	if (search_debounce) {
		clearTimeout(search_debounce);
	}
	search_debounce = setTimeout(() => {
		search_debounce = null;
		const trimmed = model.value.trim();
		const cur = search_from_route();
		if (trimmed === cur) {
			return;
		}
		sync_search_query_to_route();
		emit('apply');
	}, 320);
});

watch(
	() => route.query[props.query_key],
	() => {
		const from_route = search_from_route();
		if (from_route === model.value.trim()) {
			return;
		}
		model.value = from_route;
		emit('apply');
	},
);

onBeforeUnmount(() => {
	if (search_debounce) {
		clearTimeout(search_debounce);
		search_debounce = null;
	}
});
</script>
