export function humaniseSnakeCase(value: string): string {
	return value.replaceAll('_', ' ').replace(/\b\w/g, (c) => c.toUpperCase());
}
