export type BasketLine = {
	product_id: number;
	product_name: string;
	product_slug?: string;
	thumbnail?: string;
	price_in_gbp: number;
	quantity: number;
	line_total: number;
};

export type BasketResponse = {
	id: number;
	customer_id: number;
	price_total: number;
	items: BasketLine[];
};
