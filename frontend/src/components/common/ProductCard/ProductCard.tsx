// app/components/ProductCard.tsx
import { ShoppingCart } from "lucide-react";
import { Link } from "react-router";
import type { Product } from "../../../types/product";
 // Ensure path is correct

interface ProductCardProps {
    product: Product;
    compact?: boolean; // To make it slightly smaller for sliders
}

export function ProductCard({ product, compact = false }: ProductCardProps) {
    const ratingStars = Math.round(product.rating); // Round to nearest whole star

    return (
        <div
            className={`relative flex flex-col bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 ease-in-out
        ${compact ? "w-44 flex-shrink-0" : "w-full"}`} // Fixed width for slider items
        >
            <div className="relative">
                {/* Label */}
                {product.label && (
                    <span className="absolute top-2 left-2 z-10 rounded bg-blue-600 px-2 py-1 text-xs font-semibold text-white">
                        {product.label}
                    </span>
                )}

                {/* Add to Cart Icon (Top Right) */}
                <button className="absolute top-2 right-2 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full transition cursor-pointer" onClick={() => console.log(`Add ${product.name} to cart`)}> <ShoppingCart className="w-4 h-4" /> </button>

                {/* Product Image */}
                <Link
                    to={product.link}
                    className="flex  items-center justify-center overflow-hidden rounded-t-lg bg-gray-50 p-2"
                >
                    <img
                        src={product.image}
                        alt={product.name}
                        className="h-full w-full object-contain"
                    />
                </Link>
            </div>

            <div className="flex flex-grow flex-col p-3 text-center">
                {/* Product Name */}
                <Link
                    to={product.link}
                    className="mb-1 text-sm font-medium text-gray-700 hover:text-blue-600"
                >
                    {product.name}
                </Link>

                {/* Rating */}
                <div className="mb-1 flex items-center justify-center space-x-1">
                    {Array.from({ length: 5 }).map((_, i) => (
                        <span
                            key={i}
                            className={`${i < ratingStars ? "text-yellow-400" : "text-gray-300"
                                }`}
                        >
                            ★
                        </span>
                    ))}
                    <span className="ml-1 text-xs text-gray-500">
                        ({product.reviews.toLocaleString()})
                    </span>
                </div>

                {/* Price */}
                <div className="mb-3 flex items-baseline justify-center space-x-2">
                    {product.oldPrice && (
                        <span className="text-sm text-gray-400 line-through">
                            ${product.oldPrice.toFixed(2)}
                        </span>
                    )}
                    <span className="text-lg font-semibold text-blue-600">
                        ${product.price.toFixed(2)}
                    </span>
                </div>

                {/* Buy Now Button */}
                <button
                    className="mt-auto flex w-full items-center justify-center space-x-2 rounded-full bg-green-600 py-2 text-sm font-medium text-white transition hover:bg-green-700"
                    onClick={() => console.log(`Added ${product.name} to cart`)}
                >
                    <ShoppingCart className="h-4 w-4" />
                    <span>Add to Cart</span>
                </button>
            </div>
        </div>
    );
}