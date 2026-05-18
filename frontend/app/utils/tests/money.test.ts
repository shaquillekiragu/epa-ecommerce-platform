import { describe, expect, it } from 'vitest';
import { getPoundAndPenceFormat } from '../money';

describe('getPoundAndPenceFormat', () => {
	it('formats a numeric order total with two decimal places', () => {
		expect(getPoundAndPenceFormat(24.25)).toBe('£24.25');
	});

	it('parses a string price before formatting', () => {
		expect(getPoundAndPenceFormat('10.5')).toBe('£10.50');
	});

	it('returns £0.00 for non-numeric input', () => {
		expect(getPoundAndPenceFormat('not-a-price')).toBe('£0.00');
	});
});
