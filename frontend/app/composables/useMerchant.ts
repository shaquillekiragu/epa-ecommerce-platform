import type { MerchantOrderDetail, MerchantOrderRow, MerchantStore } from '~/types/merchant';
import type { MerchantProduct } from '~/types/merchant';

export async function merchantFetchStores(): Promise<MerchantStore[]> {
	const api = useApi();
	return api.get<MerchantStore[]>('/merchant/stores');
}

export async function merchantFetchStore(store_id: number): Promise<MerchantStore> {
	const api = useApi();
	return api.get<MerchantStore>(`/merchant/store?id=${store_id}`);
}

export async function merchantUpdateStore(
	store_id: number,
	payload: Partial<Pick<MerchantStore, 'name' | 'description'>>,
): Promise<MerchantStore> {
	const api = useApi();
	return api.patch<MerchantStore>(`/merchant/stores/${store_id}`, payload);
}

export async function merchantDeleteStore(store_id: number): Promise<void> {
	const api = useApi();
	await api.del(`/merchant/stores/${store_id}`);
}

export async function merchantFetchOrders(store_id: number): Promise<MerchantOrderRow[]> {
	const api = useApi();
	return api.get<MerchantOrderRow[]>(`/merchant/orders?store=${store_id}`);
}

export async function merchantFetchAllOrders(): Promise<MerchantOrderRow[]> {
	const api = useApi();
	return api.get<MerchantOrderRow[]>('/merchant/orders-all');
}

export async function merchantFetchOrder(order_id: number): Promise<MerchantOrderDetail> {
	const api = useApi();
	return api.get<MerchantOrderDetail>(`/merchant/orders/${order_id}`);
}

export async function merchantMarkOrderShipped(order_id: number): Promise<void> {
	const api = useApi();
	await api.patch(`/merchant/orders/${order_id}/status`, { status: 'shipped' });
}

export async function merchantFetchStoreProducts(store_id: number): Promise<MerchantProduct[]> {
	const api = useApi();
	return api.get<MerchantProduct[]>(`/merchant/products?store=${store_id}`);
}

export async function merchantFetchProduct(product_id: number): Promise<MerchantProduct> {
	const api = useApi();
	return api.get<MerchantProduct>(`/merchant/products/${product_id}`);
}

export async function merchantCreateProduct(
	payload: Partial<MerchantProduct> & { store_id: number },
): Promise<MerchantProduct> {
	const api = useApi();
	return api.post<MerchantProduct>('/merchant/products', payload);
}

export async function merchantUpdateProduct(
	product_id: number,
	payload: Partial<MerchantProduct>,
): Promise<MerchantProduct> {
	const api = useApi();
	return api.patch<MerchantProduct>(`/merchant/products/${product_id}`, payload);
}

export async function merchantDeleteProduct(product_id: number): Promise<void> {
	const api = useApi();
	await api.del(`/merchant/products/${product_id}`);
}
