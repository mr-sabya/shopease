// app/types/collection.ts
export interface CollectionCardProps {
    id: string; // Unique identifier for the collection
    title: string;
    description: string;
    price: number; // Starting price
    imageSrc: string; // URL for the collection image
    imageAlt: string;
    tag?: string; // Optional tag like "SUNGLASS" or "SALE"
}