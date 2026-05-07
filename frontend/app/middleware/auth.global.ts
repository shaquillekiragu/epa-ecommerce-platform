export default defineNuxtRouteMiddleware(async (to) => {
	const { is_logged_in, role, refresh_me } = useAuth();
	const api = useApi();

	const is_auth_page = to.path.startsWith('/auth');
	const is_merchant_area = to.path.startsWith('/merchant');
	const is_account_area = to.path.startsWith('/account');
	const is_checkout_area = to.path.startsWith('/checkout');
	const needs_customer = is_account_area || is_checkout_area;

	// If token exists but user not loaded, load it once.
	if (is_logged_in.value && role.value === null) {
		try {
			await refresh_me();
		} catch {
			// Bad/expired token
		}
	}

	// Logged-in users shouldn't see auth pages.
	if (is_logged_in.value && is_auth_page) {
		return role.value === 'merchant' ? navigateTo('/merchant/stores') : navigateTo('/');
	}

	// Not logged in: block merchant portal pages.
	if (!is_logged_in.value) {
		if (is_merchant_area || needs_customer) {
			return navigateTo('/auth/login');
		}
		return;
	}

	// Logged in but role unknown (token invalid / failed hydrate)
	if (role.value === null) {
		return navigateTo('/auth/login');
	}

	// Logged in merchant: force them into merchant portal.
	if (role.value === 'merchant' && !is_merchant_area) {
		return navigateTo('/merchant/stores');
	}

	// Logged in customer: block merchant portal.
	if (role.value === 'customer' && is_merchant_area) {
		return navigateTo('/');
	}

	// Customer-only areas (account + checkout).
	if (needs_customer && role.value !== 'customer') {
		return navigateTo('/merchant/stores');
	}

	// Checkout requires a non-empty basket (shipping + review steps).
	if (role.value === 'customer' && (to.path === '/checkout' || to.path === '/checkout/review')) {
		try {
			const basket = await api.get<{ items?: unknown[] }>('/basket');
			if (!basket?.items || basket.items.length === 0) {
				return navigateTo('/basket');
			}
		} catch {
			return navigateTo('/basket');
		}
	}
});
