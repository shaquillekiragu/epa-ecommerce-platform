import { describe, expect, it } from 'vitest';
import { humaniseSnakeCase } from '../humanise-text';

describe('humaniseSnakeCase', () => {
	it('humanises pending_payment for display', () => {
		expect(humaniseSnakeCase('pending_payment')).toBe('Pending Payment');
	});

	it('humanises payment_failed for display', () => {
		expect(humaniseSnakeCase('payment_failed')).toBe('Payment Failed');
	});

	it('humanises multi-word snake_case identifiers', () => {
		expect(humaniseSnakeCase('product_category_id')).toBe('Product Category Id');
	});
});
