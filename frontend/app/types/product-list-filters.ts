export type ProductStockFilter = 'all' | 'in' | 'out';

export interface ProductListFilters {
	categoryIds: number[];
	priceMin: string;
	priceMax: string;
	stock: ProductStockFilter;
}
