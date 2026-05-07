export default defineNuxtRouteMiddleware(() => {
	const { is_logged_in, role } = useAuth();
	
	if (!is_logged_in.value) {
		return navigateTo('/auth/login');
	}

	if (role.value !== 'merchant') {
		return navigateTo('/');
	}
});
