export function parseOrderIdsFromQuery(query_param_order_ids: unknown): number[] | null {
	if (query_param_order_ids === null) {
		return query_param_order_ids;
	}

	const first_value = Array.isArray(query_param_order_ids) ? query_param_order_ids[0] : query_param_order_ids;

	if (typeof first_value !== 'string' || !first_value.trim()) {
		return null;
	}

	const parts = first_value.split(',').map((p) => Number.parseInt(p.trim(), 10));
	const ids = parts.filter((n) => Number.isFinite(n) && n > 0);
	return ids.length > 0 ? ids : null;
}
