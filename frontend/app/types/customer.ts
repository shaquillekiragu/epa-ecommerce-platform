export type CustomerOrder = {
	id: number;
	customer_id?: number;
	store_id: number;
	price_total: number;
	placed_at: string;
	status: string;
	item_count?: number;
};

export type CustomerOrderLine = {
	product_id: number;
	product_name: string;
	thumbnail?: string;
	price_at_purchase_in_gbp: number;
	quantity: number;
	line_total: number;
};

export type CustomerOrderDetail = {
	id: number;
	store_id: number;
	price_total: number;
	placed_at: string;
	status: string;
	items: CustomerOrderLine[];
};

export type CustomerAddress = {
	id: number;
	address_id: number;
	address_type: string;
	building_number: string;
	street_name: string;
	city: string;
	region: string | null;
	post_code: string;
	country: string;
};
