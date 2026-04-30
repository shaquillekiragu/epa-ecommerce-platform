export interface ProductCard {
    id: number;
    name: string;
    product_category_name: string;
    price_in_gbp: number;
    thumbnail: string;
    product_url: string;
}

export interface Product extends ProductCard {
    store_id: number;
    description: string;
    number_in_stock: number;
    sku_code: string;
    weight_in_grams: number;
    seo_title: string;
    is_live: boolean;
}
