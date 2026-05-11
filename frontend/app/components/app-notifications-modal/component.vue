<template>
	<Teleport to="body">
		<div
			v-if="open"
			class="fixed inset-0 z-100 flex items-start justify-center sm:items-center p-4 sm:p-6"
			role="presentation"
			@click.self="close"
		>
			<div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[1px]" aria-hidden="true" @click="close" />

			<div
				ref="panel_ref"
				class="relative w-full max-w-lg max-h-[min(85vh,560px)] mt-12 sm:mt-0 flex flex-col rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-xl"
				role="dialog"
				aria-modal="true"
				aria-labelledby="notifications-modal-title"
			>
				<header class="flex items-center justify-between gap-3 px-5 py-4 border-b border-slate-200 dark:border-slate-700 shrink-0">
					<h2 id="notifications-modal-title" class="font-bold text-lg text-slate-900 dark:text-slate-50 tracking-tight">
						Notifications
					</h2>
					<button
						type="button"
						class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition"
						aria-label="Close"
						@click="close"
					>
						<span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 0">close</span>
					</button>
				</header>

				<div class="flex-1 overflow-y-auto px-5 py-4 min-h-[120px]">
					<p v-if="pending" class="text-slate-600 dark:text-slate-400 text-sm">Loading…</p>
					<p v-else-if="error_message" class="text-red-600 text-sm">{{ error_message }}</p>
					<p v-else-if="notifications.length === 0" class="text-slate-600 dark:text-slate-400 text-sm">
						No order updates yet. When your orders change status, they will appear here.
					</p>
					<ul v-else class="flex flex-col gap-3">
						<li v-for="n in notifications" :key="n.seen_key">
							<NuxtLink
								:to="n.href"
								class="block rounded-lg border border-slate-200 dark:border-slate-700 p-4 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition outline-none focus-visible:ring-2 focus-visible:ring-slate-900 dark:focus-visible:ring-slate-300"
								@click="close"
							>
								<div class="flex items-start gap-3">
									<span
										class="material-symbols-outlined shrink-0 text-[22px] mt-0.5"
										:class="tone_icon_class(n.tone)"
										style="font-variation-settings: 'FILL' 0"
										aria-hidden="true"
									>
										{{ tone_icon(n.tone) }}
									</span>
									<div class="min-w-0 flex-1">
										<p class="font-semibold text-slate-900 dark:text-slate-50 text-sm leading-snug">
											{{ n.title }}
										</p>
										<p class="text-slate-600 dark:text-slate-400 text-sm mt-1 leading-relaxed">
											{{ n.message }}
										</p>
										<p class="text-xs text-slate-400 dark:text-slate-500 mt-2">
											{{ format_when(n.placed_at) }}
										</p>
									</div>
								</div>
							</NuxtLink>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</Teleport>
</template>

<script setup lang="ts">
import type { OrderNotification, OrderNotificationTone } from '~/types/notifications';

const props = defineProps<{ open: boolean }>();
const emit = defineEmits<{ (e: 'update:open', value: boolean): void }>();

const { notifications, pending, error_message, refresh, markAllSeen } = useOrderNotifications();

const panel_ref = ref<HTMLElement | null>(null);

function close() {
	emit('update:open', false);
}

function tone_icon(tone: OrderNotificationTone): string {
	switch (tone) {
		case 'success':
			return 'check_circle';
		case 'warning':
			return 'schedule';
		case 'error':
			return 'error';
		case 'info':
			return 'local_shipping';
		default:
			return 'receipt_long';
	}
}

function tone_icon_class(tone: OrderNotificationTone): string {
	switch (tone) {
		case 'success':
			return 'text-green-600 dark:text-green-400';
		case 'warning':
			return 'text-amber-600 dark:text-amber-400';
		case 'error':
			return 'text-red-600 dark:text-red-400';
		case 'info':
			return 'text-sky-600 dark:text-sky-400';
		default:
			return 'text-slate-500 dark:text-slate-400';
	}
}

function format_when(iso: string): string {
	const t = Date.parse(iso);
	if (!Number.isFinite(t)) return '';
	const d = new Date(t);
	return d.toLocaleString(undefined, { dateStyle: 'medium', timeStyle: 'short' });
}

watch(
	() => props.open,
	async (is_open) => {
		if (!is_open) return;
		await refresh();
		markAllSeen();
		nextTick(() => {
			panel_ref.value?.querySelector<HTMLElement>('button[aria-label="Close"]')?.focus();
		});
	},
);

function on_keydown(ev: KeyboardEvent) {
	if (!props.open) return;
	if (ev.key === 'Escape') {
		ev.preventDefault();
		close();
	}
}

onMounted(() => {
	window.addEventListener('keydown', on_keydown);
});

onUnmounted(() => {
	window.removeEventListener('keydown', on_keydown);
});
</script>
