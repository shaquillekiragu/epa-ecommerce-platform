import { describe, expect, it } from 'vitest';
import { parseOrderIdsFromQuery } from '../order-ids';

describe('parseOrderIdsFromQuery', () => {
	it('parses a comma-separated list of order ids', () => {
		expect(parseOrderIdsFromQuery('1,2,3')).toEqual([1, 2, 3]);
	});

	it('ignores zero and non-positive segments', () => {
		expect(parseOrderIdsFromQuery('0,7,0')).toEqual([7]);
	});

	it('returns null for null or blank query values', () => {
		expect(parseOrderIdsFromQuery(null)).toBeNull();
		expect(parseOrderIdsFromQuery('   ')).toBeNull();
	});
});
