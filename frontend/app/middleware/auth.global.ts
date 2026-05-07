export default defineNuxtRouteMiddleware(async (to) => {
	const { is_logged_in, role, refresh_me } = useAuth();

	const is_auth_page = to.path.startsWith('/auth');
	const is_merchant_area = to.path.startsWith('/merchant');

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
		if (is_merchant_area) {
			return navigateTo('/auth/login');
		}
		return;
	}

	// Logged in merchant: force them into merchant portal.
	if (role.value === 'merchant' && !is_merchant_area) {
		return navigateTo('/merchant/stores');
	}

	// Logged in customer: block merchant portal.
	if (role.value === 'customer' && is_merchant_area) {
		return navigateTo('/');
	}
});
