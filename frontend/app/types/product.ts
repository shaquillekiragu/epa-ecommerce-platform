export interface ProductCard {
    id: number;
    name: string;
    thumbnail: string;
}

export interface Product extends ProductCard {
    store_id: number;
    product_category_name: string;
    description: string;
    price_in_gbp: number;
    number_in_stock: number;
    sku_code: string;
    weight_in_grams: number;
    seo_title: string;
    is_live: boolean;
}
