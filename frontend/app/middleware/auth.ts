export default defineNuxtRouteMiddleware(async (to) => {
	const { is_logged_in, role, refresh_me } = useAuth();

	// Allow auth pages always.
	if (to.path.startsWith('/auth')) {
		return;
	}

	// If token exists but user not loaded, load it once.
	if (is_logged_in.value && role.value === null) {
		await refresh_me();
	}

	const is_merchant_area = to.path.startsWith('/merchant');

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
