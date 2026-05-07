import { slugify } from "~/utils/strings";
import type { Product, ProductCard } from "~/types/product";

function getSlug(name: string, sku_code: string): string {
    return `${slugify(name)}-${slugify(sku_code)}`
}

type ApiProduct = {
	id: number;
	store_id: number;
	product_name: string;
	slug?: string | null;
	product_category_name?: string | null;
	description?: string | null;
	price_in_gbp: number;
	number_in_stock: number;
	sku_code: string;
	weight_in_grams: number;
	thumbnail?: string | null;
	seo_title?: string | null;
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
	const name = p.product_name;
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
		description: p.description ?? '',
		number_in_stock: Number(p.number_in_stock),
		sku_code: p.sku_code,
		weight_in_grams: Number(p.weight_in_grams),
		seo_title: p.seo_title ?? '',
		is_live: Boolean(p.is_active),
	};
}

function toCard(p: Product): ProductCard {
	const { store_id, description, number_in_stock, sku_code, weight_in_grams, seo_title, is_live, ...card } = p;
	return card;
}

export type ProductsQuery = {
	category?: number | string | null;
	search?: string | null;
	sort?: string | null;
};

export function useProducts(query: ProductsQuery = {}) {
	const api = useApi();

	const products = useState<Product[]>('products', () => []);
	const pending = useState<boolean>('products_pending', () => false);
	const error = useState<unknown>('products_error', () => null);
	const did_autoload = useState<boolean>('products_did_autoload', () => false);

	function buildQueryString(q: ProductsQuery): string {
		const params = new URLSearchParams();
		if (q.category !== undefined && q.category !== null && String(q.category).trim() !== '') params.set('category', String(q.category));
		if (q.search !== undefined && q.search !== null && q.search.trim() !== '') params.set('search', q.search.trim());
		if (q.sort !== undefined && q.sort !== null && q.sort.trim() !== '') params.set('sort', q.sort.trim());
		const s = params.toString();
		return s ? `?${s}` : '';
	}

	async function refresh(nextQuery: ProductsQuery = query) {
		pending.value = true;
		error.value = null;
		try {
			const res = await api.get<unknown>(`/products${buildQueryString(nextQuery)}`);
			const apiProducts = unwrapCollection<ApiProduct>(res);
			products.value = apiProducts.map(mapProduct);
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
