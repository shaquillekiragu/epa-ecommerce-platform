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
			email: email.trim().toLowerCase(),
			// Do not trim here: the API compares trimmed and raw password (legacy hashes / paste quirks).
			password,
		});
		token.value = res.token;
		token_expires_at.value = res.expires_at ?? null;
		try {
			// Pass token explicitly: Nuxt useCookie can lag one tick, so useApi might not send Authorization yet.
			await refresh_me(res.token);
		} catch {
			token.value = null;
			token_expires_at.value = null;
			user.value = null;
			throw {
				status: 401,
				message:
					'We could not finish signing you in (loading your profile). Please try again, or contact support if this continues.',
			};
		}
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

	async function refresh_me(explicit_bearer?: string) {
		const bearer = explicit_bearer ?? token.value;
		if (!bearer) {
			user.value = null;
			return null;
		}

		const request_opts = explicit_bearer !== undefined ? { bearerOverride: explicit_bearer } : undefined;

		async function run_me(): Promise<AuthUserSelf> {
			const me = await api.get<AuthUserSelf>('/me', request_opts);
			user.value = me;
			return me;
		}

		// Right after login: use explicit token and skip shared in-flight request (cookie may not be readable yet).
		if (explicit_bearer !== undefined) {
			try {
				return await run_me();
			} catch (e: any) {
				if (e?.status === 401) {
					token.value = null;
					token_expires_at.value = null;
					user.value = null;
				}
				throw e;
			}
		}

		if (me_request.value) {
			return me_request.value;
		}

		me_request.value = (async () => {
			try {
				return await run_me();
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
