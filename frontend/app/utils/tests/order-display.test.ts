import { describe, expect, it } from 'vitest';
import { formatOrderPlacedAt } from '../order-display';

const SAMPLE_ISO = '2024-06-15T14:30:00.000Z';

describe('formatOrderPlacedAt', () => {
	it('formats list preset with medium date and short time (en-GB)', () => {
		expect(formatOrderPlacedAt(SAMPLE_ISO, 'list')).toBe('15 Jun 2024, 14:30');
	});

	it('formats detail preset with long date and short time (en-GB)', () => {
		expect(formatOrderPlacedAt(SAMPLE_ISO, 'detail')).toBe('15 June 2024 at 14:30');
	});

	it('formats account_date preset with medium date only', () => {
		expect(formatOrderPlacedAt(SAMPLE_ISO, 'account_date')).toBe('15 Jun 2024');
	});
});
