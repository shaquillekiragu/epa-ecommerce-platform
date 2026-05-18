import { describe, expect, it } from 'vitest';
import { humanizeSnakeCase } from '../humanise-text';

describe('humanizeSnakeCase', () => {
	it('humanises pending_payment for display', () => {
		expect(humanizeSnakeCase('pending_payment')).toBe('Pending Payment');
	});

	it('humanises payment_failed for display', () => {
		expect(humanizeSnakeCase('payment_failed')).toBe('Payment Failed');
	});

	it('humanises multi-word snake_case identifiers', () => {
		expect(humanizeSnakeCase('product_category_id')).toBe('Product Category Id');
	});
});
