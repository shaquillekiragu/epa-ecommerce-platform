export default defineNuxtRouteMiddleware(async () => {
	const api = useApi();
	
	try {
		const basket = await api.get<{ items?: unknown[] }>('/basket');
		if (!basket?.items || basket.items.length === 0) {
			return navigateTo('/basket');
		}
	} catch {
		// If basket fetch fails, send user to basket page.
		return navigateTo('/basket');
	}
});
