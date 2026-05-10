import type { AuthUserSelf, LoginResponse } from '~/types/auth';
import { getCurrentInstance, onMounted } from 'vue';

export function useAuth() {
	const api = useApi();
	const token = useCookie<string | null>('auth_token', { sameSite: 'lax', path: '/' });
	const token_expires_at = useCookie<string | null>('auth_token_expires_at', { sameSite: 'lax', path: '/' });

	const user = useState<AuthUserSelf | null>('auth_user', () => null);
	const me_request = useState<Promise<AuthUserSelf | null> | null>('auth_me_request', () => null);

	const is_logged_in = computed(() => Boolean(token.value));
	const role = computed(() => user.value?.role ?? null);

	async function login(email: string, password: string) {
		token.value = null;
		token_expires_at.value = null;
		user.value = null;

		const res = await api.post<LoginResponse>('/auth/login', {
			email: email.trim(),
			password,
		});
		token.value = res.token;
		token_expires_at.value = res.expires_at ?? null;
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
			token_expires_at.value = null;
			user.value = null;
		}
	}

	async function refresh_me() {
		if (!token.value) {
			user.value = null;
			return null;
		}

		if (me_request.value) {
			return me_request.value;
		}

		me_request.value = (async () => {
			try {
				const me = await api.get<AuthUserSelf>('/me');
				user.value = me;
				return me;
			} catch (e: any) {
				if (e?.status === 401) {
					token.value = null;
					token_expires_at.value = null;
					user.value = null;
				}
				throw e;
			} finally {
				me_request.value = null;
			}
		})();

		return me_request.value;
	}

	if (getCurrentInstance()) {
		onMounted(() => {
			if (token.value && !user.value) {
				refresh_me().catch(() => {});
			}
		});
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
