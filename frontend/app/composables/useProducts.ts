import { slugify } from "~/utils/strings";
import type { Product, ProductCard } from "~/types/product";

function getSlug(name: string, sku_code: string): string {
    return `${slugify(name)}-${slugify(sku_code)}`
}

type ApiProduct = {
	id: number;
	store_id: number;
	store_name: string;
	name: string;
	slug: string;
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

function unwrapCollection<T>(data: unknown): T[] {
	if (Array.isArray(data)) return data as T[];

	if (data && typeof data === 'object' && 'items' in (data as any) && Array.isArray((data as any).items)) {
		return (data as any).items as T[];
	}

	return [];
}

function mapProduct(p: ApiProduct): Product {
	const name = p.name;
	const sku = p.sku_code;
	const slug = (p.slug ?? '').trim() !== '' ? (p.slug as string) : getSlug(name, sku);

	return {
		id: p.id,
		name,
		slug,
		product_category_name: p.product_category_name ?? '',
		price_in_gbp: Number(p.price_in_gbp),
		thumbnail: p.thumbnail ?? '',
		product_url: '',
		store_id: p.store_id,
		store_name: p.store_name ?? '',
		description: p.description ?? '',
		number_in_stock: Number(p.number_in_stock),
		sku_code: p.sku_code,
		weight_in_grams: Number(p.weight_in_grams),
		seo_title: p.seo_title ?? '',
		is_live: Boolean(p.is_active),
	};
}

function toCard(p: Product): ProductCard {
	const { store_id, store_name, description, number_in_stock, sku_code, weight_in_grams, seo_title, is_live, ...card } = p;
	return card;
}

export type ProductsQuery = {
	category?: number | string | null;
	categories?: string | null;
	store_id?: number | string | null;
	search?: string | null;
	sort?: string | null;
	price_min?: number | null;
	price_max?: number | null;
	stock?: 'in' | 'out' | null;
};

export type UseProductsOptions = {
	/** When true, skip the default onMounted fetch (parent drives `refresh`). */
	disableAutoload?: boolean;
	/**
	 * Isolated `useState` namespace (e.g. `'catalog'` for the browse page) so filtered lists
	 * do not overwrite the default `'products'` cache used on the home page.
	 */
	stateKey?: string;
};

export function useProducts(query: ProductsQuery = {}, options?: UseProductsOptions) {
	const api = useApi();

	const sk = options?.stateKey ? `:${options.stateKey}` : '';
	const products = useState<Product[]>(`products${sk}`, () => []);
	const pending = useState<boolean>(`products_pending${sk}`, () => false);
	const error = useState<unknown>(`products_error${sk}`, () => null);
	const did_autoload = useState<boolean>(`products_did_autoload${sk}`, () => false);

	function buildQueryString(q: ProductsQuery): string {
		const params = new URLSearchParams();
		if (q.category !== undefined && q.category !== null && String(q.category).trim() !== '') params.set('category', String(q.category));
		if (q.categories !== undefined && q.categories !== null && q.categories.trim() !== '') params.set('categories', q.categories.trim());
		if (q.store_id !== undefined && q.store_id !== null && String(q.store_id).trim() !== '') params.set('store_id', String(q.store_id).trim());
		if (q.search !== undefined && q.search !== null && q.search.trim() !== '') params.set('search', q.search.trim());
		if (q.sort !== undefined && q.sort !== null && q.sort.trim() !== '') params.set('sort', q.sort.trim());
		if (q.price_min !== undefined && q.price_min !== null && Number.isFinite(Number(q.price_min))) params.set('price_min', String(q.price_min));
		if (q.price_max !== undefined && q.price_max !== null && Number.isFinite(Number(q.price_max))) params.set('price_max', String(q.price_max));
		if (q.stock === 'in' || q.stock === 'out') params.set('stock', q.stock);
		const s = params.toString();
		return s ? `?${s}` : '';
	}

	async function refresh(next_query: ProductsQuery = query) {
		pending.value = true;
		error.value = null;
		try {
			const res = await api.get<unknown>(`/products${buildQueryString(next_query)}`);
			const api_products = unwrapCollection<ApiProduct>(res);
			products.value = api_products.map(mapProduct);
			return products.value;
		} catch (e) {
			error.value = e;
			products.value = [];
			throw e;
		} finally {
			pending.value = false;
		}
	}

	const product_cards = computed<ProductCard[]>(() => products.value.map(toCard));

	onMounted(() => {
		if (options?.disableAutoload) {
			return;
		}
		if (!did_autoload.value && products.value.length === 0 && !pending.value) {
			did_autoload.value = true;
			refresh().catch(() => {});
		}
	});

	return { products, product_cards, pending, error, refresh };
}

export function getProducts(): Product[] {
	const { products, refresh } = useProducts();
	if (import.meta.client && products.value.length === 0) refresh().catch(() => {});
	return products.value;
}

export function getProductCards(): ProductCard[] {
	const { product_cards, refresh, products } = useProducts();
	if (import.meta.client && products.value.length === 0) refresh().catch(() => {});
	return product_cards.value;
}

export function productDetailRoute(id: number, slug: string): string {
	const s = (slug ?? '').trim() || 'product';
	return `/products/${id}/${encodeURIComponent(s)}`;
}

export async function fetchProductById(id: number): Promise<Product | null> {
	if (!Number.isFinite(id) || id <= 0) {
		return null;
	}

	const api = useApi();
	try {
		const res = await api.get<unknown>(`/products/${id}`);
		if (!res || typeof res !== 'object' || !('id' in (res as object))) {
			return null;
		}
		return mapProduct(res as ApiProduct);
	} catch {
		return null;
	}
}
