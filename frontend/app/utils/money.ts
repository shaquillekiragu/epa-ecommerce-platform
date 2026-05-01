export function getPoundAndPenceFormat(price: number | string): string {
	let num_price = typeof price === 'number' ? price : Number.parseFloat(price)

	if (!Number.isFinite(num_price)) {
		return '£0.00'
	}

	return `£${num_price.toFixed(2)}`
}
