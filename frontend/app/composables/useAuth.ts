import type { AuthUserSelf, LoginResponse } from '~/types/auth';

export function useAuth() {
	const api = useApi();
	const token = useCookie<string | null>('auth_token', { sameSite: 'lax' });

	const user = useState<AuthUserSelf | null>('auth_user', () => null);

	const is_logged_in = computed(() => Boolean(token.value));
	const role = computed(() => user.value?.role ?? null);

	async function login(email: string, password: string) {
		const res = await api.post<LoginResponse>('/auth/login', { email, password });
		token.value = res.token;
		await refresh_me();
		return res;
	}

	async function register(payload: Record<string, unknown>) {
		return api.post<{ user: unknown }>('/auth/register', payload);
	}

	async function logout() {
		try {
			await api.post('/auth/logout');
		} finally {
			token.value = null;
			user.value = null;
		}
	}

	async function refresh_me() {
		if (!token.value) {
			user.value = null;
			return null;
		}

		// This endpoint is role/customer protected; for merchants, we’ll use it too
		// by changing backend later, but for now use /api/v1/user if present.
		// We wired GET /api/v1/user -> CustomerController::actionUser (customer only).
		// For now, we’ll attempt it and ignore failures.
		try {
			const me = await api.get<AuthUserSelf>('/user');
			user.value = me;
			return me;
		} catch {
			// Fallback: if customer-only endpoint blocks merchants, keep user null until you add /merchant/me.
			user.value = null;
			return null;
		}
	}

	return {
		token,
		user,
		is_logged_in,
		role,
		login,
		register,
		logout,
		refresh_me,
	};
}
