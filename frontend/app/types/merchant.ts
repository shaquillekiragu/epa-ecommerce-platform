import type { CustomerOrder, CustomerOrderDetail } from '~/types/customer';

export type MerchantStore = {
	id: number;
	name: string;
	description?: string | null;
	merchant_id?: number;
};

export type MerchantOrderRow = CustomerOrder & {
	customer_display_name?: string;
	customer_email?: string;
};

export type MerchantOrderDetail = CustomerOrderDetail & {
	customer_id?: number;
	customer_display_name?: string;
	customer_email?: string;
};

export type MerchantProduct = {
	id: number;
	store_id: number;
	name: string;
	slug: string;
	product_category_id: number;
	product_category_name: string;
	description?: string | null;
	price_in_gbp: number;
	number_in_stock: number;
	sku_code: string;
	weight_in_grams: number;
	thumbnail?: string | null;
	seo_title?: string;
	is_active: boolean;
};
