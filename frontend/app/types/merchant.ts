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
