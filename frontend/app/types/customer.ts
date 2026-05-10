export type CustomerOrder = {
	id: number;
	customer_id?: number;
	store_id: number;
	price_total: number;
	order_datetime: string;
	status: string;
	item_count?: number;
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
