import type { MerchantOrderDetail, MerchantOrderRow, MerchantStore } from '~/types/merchant';
import type { MerchantProduct } from '~/types/merchant';

export async function merchantFetchStores(): Promise<MerchantStore[]> {
	const api = useApi();
	return api.get<MerchantStore[]>('/merchant/stores');
}

export async function merchantFetchStore(storeId: number): Promise<MerchantStore> {
	const api = useApi();
	return api.get<MerchantStore>(`/merchant/store?id=${storeId}`);
}

export async function merchantUpdateStore(storeId: number, payload: Partial<Pick<MerchantStore, 'name' | 'description'>>): Promise<MerchantStore> {
	const api = useApi();
	return api.patch<MerchantStore>(`/merchant/stores/${storeId}`, payload);
}

export async function merchantFetchOrders(storeId: number): Promise<MerchantOrderRow[]> {
	const api = useApi();
	return api.get<MerchantOrderRow[]>(`/merchant/orders?store=${storeId}`);
}

export async function merchantFetchAllOrders(): Promise<MerchantOrderRow[]> {
	const api = useApi();
	return api.get<MerchantOrderRow[]>('/merchant/orders-all');
}

export async function merchantFetchOrder(orderId: number): Promise<MerchantOrderDetail> {
	const api = useApi();
	return api.get<MerchantOrderDetail>(`/merchant/orders/${orderId}`);
}

export async function merchantMarkOrderShipped(orderId: number): Promise<void> {
	const api = useApi();
	await api.patch(`/merchant/orders/${orderId}/status`, { status: 'shipped' });
}

export async function merchantFetchStoreProducts(storeId: number): Promise<MerchantProduct[]> {
	const api = useApi();
	return api.get<MerchantProduct[]>(`/merchant/products?store=${storeId}`);
}

export async function merchantFetchProduct(productId: number): Promise<MerchantProduct> {
	const api = useApi();
	return api.get<MerchantProduct>(`/merchant/products/${productId}`);
}

export async function merchantCreateProduct(payload: Partial<MerchantProduct> & { store_id: number }): Promise<MerchantProduct> {
	const api = useApi();
	return api.post<MerchantProduct>('/merchant/products', payload);
}

export async function merchantUpdateProduct(productId: number, payload: Partial<MerchantProduct>): Promise<MerchantProduct> {
	const api = useApi();
	return api.patch<MerchantProduct>(`/merchant/products/${productId}`, payload);
}

export async function merchantDeleteProduct(productId: number): Promise<void> {
	const api = useApi();
	await api.del(`/merchant/products/${productId}`);
}
