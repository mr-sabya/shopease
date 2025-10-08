// app/types/product.ts
export interface Product {
    name: string;
    image: string;
    price: number;
    oldPrice?: number;
    label?: string;
    rating: number;
    reviews: number;
    colors?: string[];
    link: string;
    // Added for more complete product data, though not in your dummy data yet:
    category: string;
    material?: string;
    size?: string[];
}