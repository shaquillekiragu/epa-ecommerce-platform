type HttpMethod = 'GET' | 'POST' | 'PATCH' | 'DELETE';

export type ApiError = {
	status: number;
	message: string;
	details?: unknown;
};

function getApiBaseUrl(): string {
	const env = useRuntimeConfig().public as { apiBaseUrl?: string };
	const configured = (env.apiBaseUrl ?? '').trim();
	return (configured !== '' ? configured : 'http://localhost:21080/api/v1').replace(/\/+$/, '');
}

export function useApi() {
	const token = useCookie<string | null>('auth_token', { sameSite: 'lax', path: '/' });
	const token_expires_at = useCookie<string | null>('auth_token_expires_at', { sameSite: 'lax', path: '/' });

	function is_token_expired(): boolean {
		const raw = (token_expires_at.value ?? '').trim();
		if (raw === '') return false; // unknown; treat as not expired
		const ms = Date.parse(raw);
		if (!Number.isFinite(ms)) return false;
		return Date.now() >= ms;
	}

	async function request<T>(path: string, method: HttpMethod, body?: unknown): Promise<T> {
		// Proactively treat expired tokens as logged-out to avoid loops.
		if (token.value && is_token_expired()) {
			token.value = null;
			token_expires_at.value = null;
			const err: ApiError = { status: 401, message: 'Session expired.' };
			throw err;
		}

		const base_url = getApiBaseUrl();
		const url = path.startsWith('http') ? path : `${base_url}${path.startsWith('/') ? '' : '/'}${path}`;

		const headers: Record<string, string> = {
			'Content-Type': 'application/json',
			Accept: 'application/json',
		};

		if (token.value) {
			headers.Authorization = `Bearer ${token.value}`;
		}

		const res = await fetch(url, {
			method,
			headers,
			body: body === undefined ? undefined : JSON.stringify(body),
		});

		const text = await res.text();
		const data = text ? (() => { try { return JSON.parse(text) } catch { return text } })() : null;

		if (!res.ok) {
			const err: ApiError = {
				status: res.status,
				message: typeof data === 'object' && data && 'message' in (data as any) ? (data as any).message : 'API request failed',
				details: data,
			};

			// If API says the token is no longer valid, clear it.
			if (err.status === 401) {
				token.value = null;
				token_expires_at.value = null;
			}

			throw err;
		}

		return data as T;
	}

	return {
		get: <T>(path: string) => request<T>(path, 'GET'),
		post: <T>(path: string, body?: unknown) => request<T>(path, 'POST', body),
		patch: <T>(path: string, body?: unknown) => request<T>(path, 'PATCH', body),
		del: <T>(path: string) => request<T>(path, 'DELETE'),
	};
}
