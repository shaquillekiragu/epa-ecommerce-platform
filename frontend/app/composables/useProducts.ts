import { slugify } from "~/utils/strings";
import type { Product, ProductCard } from "~/types/product";

function getSlug(name: string, sku_code: string): string {
    return `${slugify(name)}-${slugify(sku_code)}`
}

export function getProducts(): Product[] {
    const products: Product[] = [
        {
            id: 1,
            name: 'Series X Chronograph Smartwatch',
            slug: 'series-x-chronograph-smartwatch',
            product_category_name: 'Electronics',
            price_in_gbp: 499,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDfH9wPMTMr_wD6yLx_pbGR6aMEcyawkhlpBGqHTlqE7dfxFrDibbI3hWtqLMRNQb70Tgqh33_-ROtzqWhLXr95jGm021_GcKRxhX6NLTGbhAieM-0eKwFsAZMoaYNCgmRMshclnPnz7cPPOA7kXut6O_gvBQiv_4_rUlGtRWBMtptWuVX88bgb1K2cyRZPw2TD3r_AR3lLOAGBavsZ6EFLnhHtBlyKBo3gCjkduy2SmnbWFOgLpQpvysNuOUxrIdzk4veMMC2oWfPs',
            product_url: '',
            store_id: 1,
            description:
                'Premium smartwatch with chronograph face, health tracking, and all-day battery in a refined steel case.',
            number_in_stock: 24,
            sku_code: 'LC-WCH-001',
            weight_in_grams: 78,
            seo_title: 'Series X Chronograph Smartwatch | LuxCommerce',
            is_live: true,
        },
        {
            id: 2,
            name: 'Artisan Leather Tote',
            slug: 'artisan-leather-tote',
            product_category_name: 'Fashion',
            price_in_gbp: 285,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDAo9Zgpjz_whssbG4qQcGf5T85N0DH5FzylFdl1fPE_lN33BSswwMU0zIBuxe8tpH84kEj3etgBVkhOsfVRlHKzg6tcn_6Pd4UJ8mDG8ppijFEEP_vEKnlJhniZv0RcXZzk4-0W8IKhofhN5D0vWhw0eOcHo7005biU8aORsJPTLze12r0F_CH2eVQKmHdEePg4aIYzXefT4zhtj3LYjUyOvhn1f1NnaQ7UpFyupqa5xOvkLrHBKdXK6w1k7e-gDo5kXq1Vx617dgZ',
            product_url: '',
            store_id: 1,
            description:
                'Hand-finished full-grain leather tote with structured silhouette and interior pockets for daily essentials.',
            number_in_stock: 12,
            sku_code: 'LC-BAG-002',
            weight_in_grams: 620,
            seo_title: 'Artisan Leather Tote | LuxCommerce',
            is_live: true,
        },
        {
            id: 3,
            name: 'Aura Pro Noise-Cancelling Audio',
            slug: 'aura-pro-noise-cancelling-audio',
            product_category_name: 'Electronics',
            price_in_gbp: 349,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDQ8j7F5WmQ1NqAfnkqK_2mxo6km14ozRgXsgjrSjfYpsKHY68xoF-ga7ZfSjuUDSaZ7VTzsBEQq3SJ32eh_zw6Zncozn68FcbyCenan0LWG2URk07fHOevaUx0vHwRuCQN80VHboALXrFcuAl0dkltyxNE0M2MHd7vswGQhOhZY4NfWAYZafq7qmxgcd0MDzn1OjDWm8zUdPIWGgZmdkeFXDlDFyTUV0JQZyvmnYgaJeQYckiCkEpX-ko7V9Xx_yRcGeDjX34cnK5v',
            product_url: '',
            store_id: 1,
            description:
                'Over-ear headphones with adaptive noise cancellation and studio-grade clarity for travel and focus.',
            number_in_stock: 31,
            sku_code: 'LC-AUD-003',
            weight_in_grams: 298,
            seo_title: 'Aura Pro Noise-Cancelling Headphones | LuxCommerce',
            is_live: true,
        },
        {
            id: 4,
            name: 'Sculptural Ceramic Vase',
            slug: 'sculptural-ceramic-vase',
            product_category_name: 'Home Decor',
            price_in_gbp: 120,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuCWXKImU18UrDzp-uX3wf3_EL77Ub7FUZ27zkJp-RHc5A9dsSbv4377VF6lpmjdrvjXW9PZkQdiX9wv02xC_-tdi3jXcy1VuwnoVGFrgRC31OnL4mg5jGrReSDiGl839-KoxZfbTpOXWtO8HcaLA1qXE6gVtJlyCi1554Q6HGH_HpJAnvhzeJG3iqaHgTgyfXb1CuTIBGQJsKA93Qu3YJSbHKTHsHgnX2eTry5RLyh6oEEndmYC_0a--t-YD10CSbW2XsY0uSr0tYSG',
            product_url: '',
            store_id: 1,
            description:
                'Statement ceramic vase with organic curves—ideal as a centrepiece or paired with dried botanicals.',
            number_in_stock: 18,
            sku_code: 'LC-HOM-004',
            weight_in_grams: 890,
            seo_title: 'Sculptural Ceramic Vase | LuxCommerce',
            is_live: true,
        },
        {
            id: 5,
            name: 'Chronograph Smartwatch',
            slug: 'chronograph-smartwatch',
            product_category_name: '',
            price_in_gbp: 299,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDQyyzuyPMo8Bju05LvbZVbO3ZfqLtfx673f6HTYbr1SSbDCQOHgoj_JFIJwNgl5MIEUCNR9qpDMm1VXiB4uhHtDE_rPR__NdAYvVqXiiDwUtYPzNQ17rqyZkfNfw2cTk4Ee4iJJjjFNLY04fI-uC83_lw1-cZZNSrIhpuchzdTrvw1eKKG4FQcIGVA9fxf-U2UczdkmBvWI11uBvR1IvhzHFUmlzvW0rR1c-zEh-e7GltOUEt_UhhgKQ2jePH3IagEp2vLl0zGyl-r',
            product_url: '',
            store_id: 1,
            description:
                'Sleek minimalist smartwatch with advanced health tracking and a crisp always-on display.',
            number_in_stock: 42,
            sku_code: 'LC-WCH-005',
            weight_in_grams: 52,
            seo_title: 'Chronograph Smartwatch | LuxCommerce',
            is_live: true,
        },
        {
            id: 6,
            name: 'Aura Studio Headphones',
            slug: 'aura-studio-headphones',
            product_category_name: '',
            price_in_gbp: 349.5,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuB6g4Q5jZ-O9UP18dFdVUXlg-oygmNWEbD-jgvJyPF0m447xLG0A7iTz0IjpbqfhJyqms55JGxOovd60eKKfH2oD3zDzPA6TbcnvH9V_TH0R7Rkk35DrEZ3SC7NX48s0NLdAiUKnSMcXsfgJ0W7cVh0Wbjmi1WDaWX_t5nI4o7JXvzs7Wz9ye3744PGBq39E9-8sjHNGjVqGjeAg7-stwv-G1J_vbs2f-JA8kTls1YgkAFinIanqD510RejJpMyXWchpbBAjYn1OLG7',
            product_url: '',
            store_id: 1,
            description:
                'Studio-tuned over-ears with plush memory foam and balanced sound for long listening sessions.',
            number_in_stock: 27,
            sku_code: 'LC-AUD-006',
            weight_in_grams: 310,
            seo_title: 'Aura Studio Headphones | LuxCommerce',
            is_live: true,
        },
        {
            id: 7,
            name: 'Artisan Pour-Over Set',
            slug: 'artisan-pour-over-set',
            product_category_name: '',
            price_in_gbp: 85,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuBzXGnXhpG9OzkZmpZz-B73aGTXl1iNy1fKSLWuKaqWRCRvbPtzKORyRSNQf9ayl93z_wosLPt1qg7kXzTsSCgDXINK8mZLbXfe8IccIRbkRe_tX5NPEQA-_8f-F0NOVFrqUi3QLG2j5A1vtPtkwW_fJa5u1nt95zkI8ha-hHMnF7vfPzuez2bh9aKytMTqwJDXYAMcsVW_IqRm-MfMTFnk1rtfFGxNOVJRqg-i-SfQ_-wl952-4-p5qRbncJf6vVtVH3-KmQOvhNa5',
            product_url: '',
            store_id: 1,
            description:
                'Hand-crafted ceramic dripper and server set for a precise, ritual pour-over every morning.',
            number_in_stock: 55,
            sku_code: 'LC-KIT-007',
            weight_in_grams: 540,
            seo_title: 'Artisan Pour-Over Set | LuxCommerce',
            is_live: true,
        },
        {
            id: 8,
            name: 'Retro Instant Camera',
            slug: 'retro-instant-camera',
            product_category_name: '',
            price_in_gbp: 129.99,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuA50OmyAKcg-1jOCo-NetkshDh_mmriA1RsStiBj1IJALJI86RY3Vm142_0LQByng0lGPfuho7GAMvfFLKfHTr5u-fFyz0swvy_4iDyMkNEjCAEytHD5gzWc4lXgVrWcNirVuPggYxfs7YVSawNtCXJtiUnURQnzJIxoj2b7EjiJLhCHpcKJZ4IayKSg-uol6vFeyYxi3zJWhIvuyI0WI5YumNtEM6xZ_vYBV5NeKzlSXOvfZq8n_Sj0IsYXoWv_lSu0UBn5D2sz3Tf',
            product_url: '',
            store_id: 1,
            description:
                'Vintage-inspired instant camera with easy point-and-shoot operation and classic print charm.',
            number_in_stock: 19,
            sku_code: 'LC-CAM-008',
            weight_in_grams: 415,
            seo_title: 'Retro Instant Camera | LuxCommerce',
            is_live: true,
        },
        {
            id: 9,
            name: 'Velocity Runners',
            slug: 'velocity-runners',
            product_category_name: '',
            price_in_gbp: 165,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuBanppMpZkWX00vOfTnPdov10Llx78bqqHkOuzZSrSLX-2pwl-W-_kT2xL88fkEy6G6Xl6kdTCqpH0YZjAuMNGWeiVFHEqu9VmiNV6WGGz6QxcPVl4C5wMhmE17e6cHkJkT3gwCYZ5F2FqgKZfTwWIt4N6FU0mlIsPoMp-OLtAdzuQqPZdjAMoC8sVX4a1xMvWRCsm5u3HSe8yHFecqYCUhNcHNJ86RbjrnJoh2iXQJXhKDbO6QTTJktKwUHYvg95VEDreJxKbgwHUN',
            product_url: '',
            store_id: 1,
            description:
                'Lightweight performance runners with responsive cushioning and breathable upper for daily miles.',
            number_in_stock: 36,
            sku_code: 'LC-SNK-009',
            weight_in_grams: 280,
            seo_title: 'Velocity Runners | LuxCommerce',
            is_live: true,
        },
        {
            id: 10,
            name: 'Echo Home Hub',
            slug: 'echo-home-hub',
            product_category_name: '',
            price_in_gbp: 199,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuBTefx-Zr7C3Zz09rxeBvmAXBZicGaXOe12Q22BL8OySXqwHFQsktmta50p3IZaQrHDzSZSrNfXJVygilydEZb_uHpKGWSYCqugICYGGaFaX2GQV_v-HY3DIax-dVRdWJqToCtDcg-_fYu2HyJzdIS_Q035sRN-tpS0ComlgmeVGVSpHK1BnqtGDtGAumyZyGo07KkRR-jXUnbZZWDQHcSVPZs1skgJeip5XsM3a8kfQd6A0PXozoNFp6xer71uGYZ9RsNKHiUMVi84',
            product_url: '',
            store_id: 1,
            description:
                'Compact smart home hub to control lights, climate, and scenes from one elegant interface.',
            number_in_stock: 22,
            sku_code: 'LC-IOT-010',
            weight_in_grams: 340,
            seo_title: 'Echo Home Hub | LuxCommerce',
            is_live: true,
        },
    ]

    products.forEach((product) => {
        product.slug = getSlug(product.name, product.sku_code)
    })

    return products
}

const products = getProducts()

export function getProductCards(): ProductCard[] {
    const product_cards: ProductCard[] = [
        {
            id: 1,
            name: 'Series X Chronograph Smartwatch',
            slug: '',
            product_category_name: 'Electronics',
            price_in_gbp: 499,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDfH9wPMTMr_wD6yLx_pbGR6aMEcyawkhlpBGqHTlqE7dfxFrDibbI3hWtqLMRNQb70Tgqh33_-ROtzqWhLXr95jGm021_GcKRxhX6NLTGbhAieM-0eKwFsAZMoaYNCgmRMshclnPnz7cPPOA7kXut6O_gvBQiv_4_rUlGtRWBMtptWuVX88bgb1K2cyRZPw2TD3r_AR3lLOAGBavsZ6EFLnhHtBlyKBo3gCjkduy2SmnbWFOgLpQpvysNuOUxrIdzk4veMMC2oWfPs',
            product_url: ''
        },
        {
            id: 2,
            name: 'Artisan Leather Tote',
            slug: '',
            product_category_name: 'Fashion',
            price_in_gbp: 285,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDAo9Zgpjz_whssbG4qQcGf5T85N0DH5FzylFdl1fPE_lN33BSswwMU0zIBuxe8tpH84kEj3etgBVkhOsfVRlHKzg6tcn_6Pd4UJ8mDG8ppijFEEP_vEKnlJhniZv0RcXZzk4-0W8IKhofhN5D0vWhw0eOcHo7005biU8aORsJPTLze12r0F_CH2eVQKmHdEePg4aIYzXefT4zhtj3LYjUyOvhn1f1NnaQ7UpFyupqa5xOvkLrHBKdXK6w1k7e-gDo5kXq1Vx617dgZ',
            product_url: '',
        },
        {
            id: 3,
            name: 'Aura Pro Noise-Cancelling Audio',
            slug: '',
            product_category_name: 'Electronics',
            price_in_gbp: 349,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDQ8j7F5WmQ1NqAfnkqK_2mxo6km14ozRgXsgjrSjfYpsKHY68xoF-ga7ZfSjuUDSaZ7VTzsBEQq3SJ32eh_zw6Zncozn68FcbyCenan0LWG2URk07fHOevaUx0vHwRuCQN80VHboALXrFcuAl0dkltyxNE0M2MHd7vswGQhOhZY4NfWAYZafq7qmxgcd0MDzn1OjDWm8zUdPIWGgZmdkeFXDlDFyTUV0JQZyvmnYgaJeQYckiCkEpX-ko7V9Xx_yRcGeDjX34cnK5v',
            product_url: '',
        },
        {
            id: 4,
            name: 'Sculptural Ceramic Vase',
            slug: '',
            product_category_name: 'Home Decor',
            price_in_gbp: 120,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuCWXKImU18UrDzp-uX3wf3_EL77Ub7FUZ27zkJp-RHc5A9dsSbv4377VF6lpmjdrvjXW9PZkQdiX9wv02xC_-tdi3jXcy1VuwnoVGFrgRC31OnL4mg5jGrReSDiGl839-KoxZfbTpOXWtO8HcaLA1qXE6gVtJlyCi1554Q6HGH_HpJAnvhzeJG3iqaHgTgyfXb1CuTIBGQJsKA93Qu3YJSbHKTHsHgnX2eTry5RLyh6oEEndmYC_0a--t-YD10CSbW2XsY0uSr0tYSG',
            product_url: '',
        },
        {
            id: 5,
            name: 'Chronograph Smartwatch',
            slug: '',
            product_category_name: '',
            price_in_gbp: 299,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuDQyyzuyPMo8Bju05LvbZVbO3ZfqLtfx673f6HTYbr1SSbDCQOHgoj_JFIJwNgl5MIEUCNR9qpDMm1VXiB4uhHtDE_rPR__NdAYvVqXiiDwUtYPzNQ17rqyZkfNfw2cTk4Ee4iJJjjFNLY04fI-uC83_lw1-cZZNSrIhpuchzdTrvw1eKKG4FQcIGVA9fxf-U2UczdkmBvWI11uBvR1IvhzHFUmlzvW0rR1c-zEh-e7GltOUEt_UhhgKQ2jePH3IagEp2vLl0zGyl-r',
            product_url: '',
        },
        {
            id: 6,
            name: 'Aura Studio Headphones',
            slug: '',
            product_category_name: '',
            price_in_gbp: 349.5,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuB6g4Q5jZ-O9UP18dFdVUXlg-oygmNWEbD-jgvJyPF0m447xLG0A7iTz0IjpbqfhJyqms55JGxOovd60eKKfH2oD3zDzPA6TbcnvH9V_TH0R7Rkk35DrEZ3SC7NX48s0NLdAiUKnSMcXsfgJ0W7cVh0Wbjmi1WDaWX_t5nI4o7JXvzs7Wz9ye3744PGBq39E9-8sjHNGjVqGjeAg7-stwv-G1J_vbs2f-JA8kTls1YgkAFinIanqD510RejJpMyXWchpbBAjYn1OLG7',
            product_url: '',
        },
        {
            id: 7,
            name: 'Artisan Pour-Over Set',
            slug: '',
            product_category_name: '',
            price_in_gbp: 85,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuBzXGnXhpG9OzkZmpZz-B73aGTXl1iNy1fKSLWuKaqWRCRvbPtzKORyRSNQf9ayl93z_wosLPt1qg7kXzTsSCgDXINK8mZLbXfe8IccIRbkRe_tX5NPEQA-_8f-F0NOVFrqUi3QLG2j5A1vtPtkwW_fJa5u1nt95zkI8ha-hHMnF7vfPzuez2bh9aKytMTqwJDXYAMcsVW_IqRm-MfMTFnk1rtfFGxNOVJRqg-i-SfQ_-wl952-4-p5qRbncJf6vVtVH3-KmQOvhNa5',
            product_url: '',
        },
        {
            id: 8,
            name: 'Retro Instant Camera',
            slug: '',
            product_category_name: '',
            price_in_gbp: 129.99,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuA50OmyAKcg-1jOCo-NetkshDh_mmriA1RsStiBj1IJALJI86RY3Vm142_0LQByng0lGPfuho7GAMvfFLKfHTr5u-fFyz0swvy_4iDyMkNEjCAEytHD5gzWc4lXgVrWcNirVuPggYxfs7YVSawNtCXJtiUnURQnzJIxoj2b7EjiJLhCHpcKJZ4IayKSg-uol6vFeyYxi3zJWhIvuyI0WI5YumNtEM6xZ_vYBV5NeKzlSXOvfZq8n_Sj0IsYXoWv_lSu0UBn5D2sz3Tf',
            product_url: '',
        },
        {
            id: 9,
            name: 'Velocity Runners',
            slug: '',
            product_category_name: '',
            price_in_gbp: 165,
            thumbnail:
                'https://lh3.googleusercontent.com/aida-public/AB6AXuBanppMpZkWX00vOfTnPdov10Llx78bqqHkOuzZSrSLX-2pwl-W-_kT2xL88fkEy6G6Xl6kdTCqpH0YZjAuMNGWeiVFHEqu9VmiNV6WGGz6QxcPVl4C5wMhmE17e6cHkJkT3gwCYZ5F2FqgKZfTwWIt4N6FU0mlIsPoMp-OLtAdzuQqPZdjAMoC8sVX4a1xMvWRCsm5u3HSe8yHFecqYCUhNcHNJ86RbjrnJoh2iXQJXhKDbO6QTTJktKwUHYvg95VEDreJxKbgwHUN',
            product_url: '',
        },
        {
            id: 10,
            name: 'Echo Home Hub',
            slug: '',
            product_category_name: '',
            price_in_gbp: 199,
            thumbnail:
            'https://lh3.googleusercontent.com/aida-public/AB6AXuBTefx-Zr7C3Zz09rxeBvmAXBZicGaXOe12Q22BL8OySXqwHFQsktmta50p3IZaQrHDzSZSrNfXJVygilydEZb_uHpKGWSYCqugICYGGaFaX2GQV_v-HY3DIax-dVRdWJqToCtDcg-_fYu2HyJzdIS_Q035sRN-tpS0ComlgmeVGVSpHK1BnqtGDtGAumyZyGo07KkRR-jXUnbZZWDQHcSVPZs1skgJeip5XsM3a8kfQd6A0PXozoNFp6xer71uGYZ9RsNKHiUMVi84',
            product_url: '',
        },
    ]

    for (const card of product_cards) {
        for (const product of products) {
            if (card.id === product.id) {
                card.slug = product.slug
            }
        }
    }

    return product_cards
}
