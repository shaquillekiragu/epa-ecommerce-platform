import { describe, expect, it } from 'vitest';
import { slugify } from '../strings';

describe('slugify', () => {
	it('trims leading and trailing whitespace', () => {
		expect(slugify('  Hello World  ')).toBe('hello-world');
	});

	it('collapses internal whitespace to single hyphens', () => {
		expect(slugify('Multiple   spaces   here')).toBe('multiple-spaces-here');
	});

	it('lowercases the result', () => {
		expect(slugify('UPPER CASE')).toBe('upper-case');
	});
});
