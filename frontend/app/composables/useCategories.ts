import type { ProductCategory } from '~/types/product-category';

type ApiCategory = {
	id: number;
	name?: string | null;
	category_name?: string | null; // legacy
	description?: string | null;
	thumbnail?: string | null;
};

function mapCategory(c: ApiCategory): ProductCategory {
	return {
		id: c.id,
		name: (c.name ?? c.category_name ?? '').trim(),
		description: c.description ?? undefined,
		thumbnail: (c.thumbnail ?? '').trim() !== '' ? (c.thumbnail as string) : '/images/category-placeholder.svg',
	};
}

function unwrapCollection<T>(data: unknown): T[] {
	if (Array.isArray(data)) return data as T[];
	if (data && typeof data === 'object' && 'items' in (data as any) && Array.isArray((data as any).items)) {
		return (data as any).items as T[];
	}
	return [];
}

export function useCategories() {
	const api = useApi();

	const categories = useState<ProductCategory[]>('categories', () => []);
	const pending = useState<boolean>('categories_pending', () => false);
	const error = useState<unknown>('categories_error', () => null);

	async function refresh() {
		pending.value = true;
		error.value = null;
		try {
			const res = await api.get<unknown>('/categories');
			const api_categories = unwrapCollection<ApiCategory>(res);
			categories.value = api_categories.map(mapCategory);
			return categories.value;
		} catch (e) {
			error.value = e;
			categories.value = [];
			throw e;
		} finally {
			pending.value = false;
		}
	}

	// Auto-load on client to avoid SSR refresh emptiness.
	onMounted(() => {
		if (categories.value.length === 0 && !pending.value) {
			refresh().catch(() => {});
		}
	});

	return { categories, pending, error, refresh };
}

// Backwards-compatible export used by existing pages/components.
// Returns cached categories if already fetched, otherwise returns an empty list
// (and triggers an async fetch via useCategories()).
export function getProductCategories(): ProductCategory[] {
	const { categories } = useCategories();
	return categories.value;
}
