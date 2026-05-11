export type OrderNotificationTone = 'info' | 'success' | 'warning' | 'error' | 'neutral';

export type OrderNotification = {
	/** Stable key for read/unread (role + order id + status). */
	seen_key: string;
	order_id: number;
	store_id: number;
	status: string;
	title: string;
	message: string;
	tone: OrderNotificationTone;
	placed_at: string;
	/** Customer account vs merchant store workspace. */
	perspective: 'customer' | 'merchant';
	href: string;
};
