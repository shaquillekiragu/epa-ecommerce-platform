import type { BasketResponse } from '~/types/basket';

export function useBasketItemCount() {
	const api = useApi();
	const { is_logged_in, role } = useAuth();

	const basket_item_count = useState<number>('basket_item_count_total', () => 0);

	function apply_from_basket(b: BasketResponse | null) {
		if (!b?.items?.length) {
			basket_item_count.value = 0;
			return;
		}
		basket_item_count.value = b.items.reduce((sum, line) => sum + line.quantity, 0);
	}

	async function refresh_basket_item_count() {
		if (!is_logged_in.value || role.value !== 'customer') {
			basket_item_count.value = 0;
			return;
		}
		try {
			const b = await api.get<BasketResponse>('/basket');
			apply_from_basket(b);
		} catch {
			basket_item_count.value = 0;
		}
	}

	return {
		basket_item_count,
		refresh_basket_item_count,
		apply_from_basket,
	};
}
