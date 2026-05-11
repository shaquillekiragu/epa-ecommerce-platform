import type { MerchantOrderDetail, MerchantOrderRow, MerchantStore } from '~/types/merchant';

export async function merchantFetchStores(): Promise<MerchantStore[]> {
	const api = useApi();
	return api.get<MerchantStore[]>('/merchant/stores');
}

export async function merchantFetchStore(storeId: number): Promise<MerchantStore> {
	const api = useApi();
	return api.get<MerchantStore>(`/merchant/store?id=${storeId}`);
}

export async function merchantFetchOrders(storeId: number): Promise<MerchantOrderRow[]> {
	const api = useApi();
	return api.get<MerchantOrderRow[]>(`/merchant/orders?store=${storeId}`);
}

export async function merchantFetchOrder(orderId: number): Promise<MerchantOrderDetail> {
	const api = useApi();
	return api.get<MerchantOrderDetail>(`/merchant/orders/${orderId}`);
}

export async function merchantMarkOrderShipped(orderId: number): Promise<void> {
	const api = useApi();
	await api.patch(`/merchant/orders/${orderId}/status`, { status: 'shipped' });
}
