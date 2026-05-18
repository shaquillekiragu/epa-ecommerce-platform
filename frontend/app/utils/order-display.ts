export function formatOrderPlacedAt(raw: string, preset: 'list' | 'detail' | 'account_date'): string {
	try {
		const d = new Date(raw);
		
		if (Number.isNaN(d.getTime())) {
			return raw;
		} else if (preset === 'list') {
			return new Intl.DateTimeFormat('en-GB', { dateStyle: 'medium', timeStyle: 'short' }).format(d);
		} else if (preset === 'detail') {
			return new Intl.DateTimeFormat('en-GB', { dateStyle: 'long', timeStyle: 'short' }).format(d);
		}

		return new Intl.DateTimeFormat('en-GB', { dateStyle: 'medium' }).format(d);
	} catch {
		return raw;
	}
}
