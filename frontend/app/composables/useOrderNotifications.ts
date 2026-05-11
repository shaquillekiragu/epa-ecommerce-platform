import type { CustomerOrder } from '~/types/customer';
import type { OrderNotification, OrderNotificationTone } from '~/types/notifications';

const STORAGE_KEY = 'epa_order_notification_seen_v1';

type OrderRow = Pick<CustomerOrder, 'id' | 'store_id' | 'status' | 'placed_at'>;

function unwrapCollection<T>(data: unknown): T[] {
	if (Array.isArray(data)) return data as T[];
	if (data && typeof data === 'object' && 'items' in (data as object) && Array.isArray((data as { items: unknown }).items)) {
		return (data as { items: T[] }).items;
	}
	return [];
}

function readSeenKeys(): Set<string> {
	if (!import.meta.client) return new Set();
	try {
		const raw = localStorage.getItem(STORAGE_KEY);
		if (!raw) return new Set();
		const parsed = JSON.parse(raw) as unknown;
		if (!Array.isArray(parsed)) return new Set();
		return new Set(parsed.filter((x): x is string => typeof x === 'string'));
	} catch {
		return new Set();
	}
}

function writeSeenKeys(keys: Set<string>) {
	if (!import.meta.client) return;
	try {
		localStorage.setItem(STORAGE_KEY, JSON.stringify([...keys]));
	} catch {
		// ignore quota / private mode
	}
}

function statusTone(status: string): OrderNotificationTone {
	switch (status) {
		case 'payment_failed':
		case 'cancelled':
			return 'error';
		case 'pending_payment':
			return 'warning';
		case 'paid':
		case 'delivered':
			return 'success';
		case 'shipped':
		case 'refunded':
			return 'info';
		default:
			return 'neutral';
	}
}

function mapCustomerNotification(o: OrderRow): OrderNotification {
	const tone = statusTone(o.status);
	const id = o.id;
	let title = 'Order update';
	let message = `Order #${id} is now “${o.status.replace(/_/g, ' ')}”.`;

	switch (o.status) {
		case 'pending_payment':
			title = 'Payment pending';
			message = `Order #${id} is waiting for payment.`;
			break;
		case 'payment_failed':
			title = 'Payment failed';
			message = `Payment for order #${id} did not go through. You can try again from your account.`;
			break;
		case 'paid':
			title = 'Payment received';
			message = `Order #${id} is paid and being prepared.`;
			break;
		case 'shipped':
			title = 'Order shipped';
			message = `Order #${id} is on its way.`;
			break;
		case 'delivered':
			title = 'Delivered';
			message = `Order #${id} has been delivered.`;
			break;
		case 'cancelled':
			title = 'Order cancelled';
			message = `Order #${id} was cancelled.`;
			break;
		case 'refunded':
			title = 'Refund processed';
			message = `Order #${id} has been refunded.`;
			break;
		default:
			break;
	}

	const href =
		o.status === 'pending_payment' ? `/checkout/pay?order_ids=${encodeURIComponent(String(id))}` : '/account';

	return {
		seen_key: `customer:${id}:${o.status}`,
		order_id: id,
		store_id: o.store_id,
		status: o.status,
		title,
		message,
		tone,
		placed_at: o.placed_at,
		perspective: 'customer',
		href,
	};
}

function mapMerchantNotification(o: OrderRow): OrderNotification {
	const tone = statusTone(o.status);
	const id = o.id;
	let title = 'Store order';
	let message = `Order #${id} — status “${o.status.replace(/_/g, ' ')}”.`;

	switch (o.status) {
		case 'pending_payment':
			title = 'Awaiting customer payment';
			message = `Order #${id} is not paid yet.`;
			break;
		case 'payment_failed':
			title = 'Customer payment failed';
			message = `Order #${id} — payment failed.`;
			break;
		case 'paid':
			title = 'Order paid';
			message = `Order #${id} is paid and ready to fulfil.`;
			break;
		case 'shipped':
			title = 'Shipped';
			message = `Order #${id} is marked as shipped.`;
			break;
		case 'delivered':
			title = 'Delivered';
			message = `Order #${id} is delivered.`;
			break;
		case 'cancelled':
			title = 'Cancelled';
			message = `Order #${id} was cancelled.`;
			break;
		case 'refunded':
			title = 'Refunded';
			message = `Order #${id} was refunded.`;
			break;
		default:
			break;
	}

	return {
		seen_key: `merchant:${id}:${o.status}`,
		order_id: id,
		store_id: o.store_id,
		status: o.status,
		title,
		message,
		tone,
		placed_at: o.placed_at,
		perspective: 'merchant',
		href: `/merchant/stores/${o.store_id}/orders/${id}`,
	};
}

function parseOrderRows(data: unknown): OrderRow[] {
	const rows = Array.isArray(data) ? (data as OrderRow[]) : [];
	return rows
		.filter((r) => r && typeof r.id === 'number' && typeof r.store_id === 'number' && typeof r.status === 'string' && typeof r.placed_at === 'string')
		.map((r) => ({
			id: r.id,
			store_id: r.store_id,
			status: r.status,
			placed_at: r.placed_at,
		}));
}

function sortByDatetimeDesc(a: OrderNotification, b: OrderNotification) {
	return Date.parse(b.placed_at) - Date.parse(a.placed_at);
}

export function useOrderNotifications() {
	const api = useApi();
	const { is_logged_in, role, user, refresh_me } = useAuth();

	const notifications = useState<OrderNotification[]>('order_notifications', () => []);
	const pending = useState<boolean>('order_notifications_pending', () => false);
	const error_message = useState<string | null>('order_notifications_error', () => null);
	const seen_revision = useState<number>('order_notifications_seen_revision', () => 0);

	const unread_count = computed(() => {
		seen_revision.value;
		if (!import.meta.client) return 0;
		const seen = readSeenKeys();
		return notifications.value.filter((n) => !seen.has(n.seen_key)).length;
	});

	function mark_all_seen() {
		if (!import.meta.client) return;
		const seen = readSeenKeys();
		for (const n of notifications.value) {
			seen.add(n.seen_key);
		}
		writeSeenKeys(seen);
		seen_revision.value++;
	}

	async function refresh() {
		error_message.value = null;
		if (!is_logged_in.value) {
			notifications.value = [];
			return;
		}

		const r = role.value;
		if (r !== 'customer' && r !== 'merchant') {
			notifications.value = [];
			return;
		}

		pending.value = true;
		try {
			if (r === 'customer') {
				const raw = await api.get<unknown>('/customer/orders');
				const rows = parseOrderRows(raw);
				notifications.value = rows.map(mapCustomerNotification).sort(sortByDatetimeDesc);
				return;
			}

			let me = user.value;
			if (!me) {
				me = await refresh_me().catch(() => null);
			}
			if (!me || me.role !== 'merchant') {
				notifications.value = [];
				return;
			}

			const stores_res = await api.get<unknown>(`/stores?merchant_id=${me.id}&per-page=100`);
			const stores = unwrapCollection<{ id: number }>(stores_res);
			const store_ids = stores.map((s) => s.id).filter((id) => typeof id === 'number' && id > 0);
			const capped = store_ids.slice(0, 40);

			const order_lists = await Promise.all(
				capped.map(async (store_id) => {
					try {
						return await api.get<unknown>(`/merchant/orders?store=${store_id}`);
					} catch {
						return [];
					}
				}),
			);

			const by_id = new Map<number, OrderRow>();
			for (const list of order_lists) {
				for (const row of parseOrderRows(list)) {
					by_id.set(row.id, row);
				}
			}

			notifications.value = [...by_id.values()].map(mapMerchantNotification).sort(sortByDatetimeDesc);
		} catch (e: unknown) {
			const msg = typeof e === 'object' && e && 'message' in e ? String((e as { message: string }).message) : 'Could not load notifications.';
			error_message.value = msg;
			notifications.value = [];
		} finally {
			pending.value = false;
		}
	}

	watch(
		() => [is_logged_in.value, role.value] as const,
		([logged]) => {
			if (!logged) {
				notifications.value = [];
				error_message.value = null;
			}
		},
	);

	return {
		notifications,
		unread_count,
		pending,
		error_message,
		refresh,
		mark_all_seen,
	};
}
