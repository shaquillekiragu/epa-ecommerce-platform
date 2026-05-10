<template>
	<div class="space-y-1">
		<label v-if="label" class="text-sm font-medium text-slate-700" :for="input_id">{{ label }}</label>
		<div class="relative">
			<input
				:id="input_id"
				:value="modelValue"
				:type="show_password ? 'text' : 'password'"
				:placeholder="placeholder"
				:autocomplete="autocomplete"
				:disabled="disabled"
				class="w-full border rounded-lg py-3 pl-3 pr-12 outline-none focus:ring-2 focus:ring-slate-900 disabled:opacity-60"
				@input="on_input"
			/>
			<button
				type="button"
				class="absolute right-1 top-1/2 -translate-y-1/2 flex size-10 items-center justify-center rounded-md text-slate-600 hover:bg-slate-100 hover:text-slate-900 outline-none focus-visible:ring-2 focus-visible:ring-slate-900"
				:aria-label="show_password ? 'Hide password' : 'Show password'"
				:aria-pressed="show_password"
				@click="show_password = !show_password"
			>
				<span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 0">
					{{ show_password ? 'visibility' : 'visibility_off' }}
				</span>
			</button>
		</div>
	</div>
</template>

<script setup lang="ts">
const props = withDefaults(
	defineProps<{
		modelValue: string;
		label?: string;
		placeholder?: string;
		autocomplete?: string;
		disabled?: boolean;
	}>(),
	{
		label: 'Password',
		placeholder: '',
		autocomplete: 'current-password',
		disabled: false,
	},
);

const emit = defineEmits<{ 'update:modelValue': [value: string] }>();

const input_id = useId();
const show_password = ref(false);

function on_input(e: Event) {
	emit('update:modelValue', (e.target as HTMLInputElement).value);
}
</script>
