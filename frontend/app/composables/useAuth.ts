import type { AuthUserSelf, LoginResponse } from '~/types/auth';

export function useAuth() {
	const api = useApi();
	const token = useCookie<string | null>('auth_token', { sameSite: 'lax', path: '/' });

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

		const me = await api.get<AuthUserSelf>('/me');
		user.value = me;
		return me;
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
