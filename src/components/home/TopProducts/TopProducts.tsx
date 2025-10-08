import { ProductCard } from "../../common/ProductCard/ProductCard";
const products = [
    {
        name: "Kalrez® Spectrum™ 6375",
        image: "/assets/images/products/product-1.png",
        price: 17.84,
        oldPrice: 30.0,
        label: "Sale",
        rating: 5,
        reviews: 6400,
        colors: ["#3B82F6", "#10B981", "#F59E0B", "#EC4899", "#A78BFA"],
        category: "Accessories",
        link: "/product/kalrez-spectrum",
    },
    {
        name: "Chiffon Bell Sleeves Dress",
        image: "/assets/images/products/product-2.png",
        price: 78,
        oldPrice: 100,
        label: "20% OFF",
        rating: 5,
        reviews: 6400,
        colors: ["#3B82F6", "#10B981", "#F59E0B", "#EC4899", "#A78BFA"],
        category: "Accessories",
        link: "/product/calvin-dress",
    },
    {
        name: "Wireless Headphones",
        image: "/assets/images/products/product-3.png",
        price: 99,
        oldPrice: 129,
        label: "New",
        rating: 4.5,
        reviews: 1200,
        colors: ["#000000", "#FFFFFF"],
        category: "Accessories",
        link: "/product/wireless-headphones",
    },
    {
        name: "Smart Watch",
        image: "/assets/images/products/product-4.png",
        price: 199,
        oldPrice: 249,
        label: "Trending",
        rating: 4.7,
        reviews: 800,
        colors: ["#3B82F6", "#10B981"],
        category: "Accessories",
        link: "/product/smart-watch",
    },
    {
        name: "Sneakers",
        image: "/assets/images/products/product-5.png",
        price: 79,
        oldPrice: 99,
        label: "Sale",
        rating: 4.3,
        reviews: 950,
        colors: ["#F59E0B", "#EC4899", "#A78BFA"],
        category: "Accessories",
        link: "/product/sneakers",
    },
    {
        name: "Backpack",
        image: "/assets/images/products/product-6.png",
        price: 49,
        oldPrice: 69,
        label: "Limited",
        rating: 4.0,
        reviews: 600,
        colors: ["#3B82F6", "#A78BFA"],
        category: "Accessories",
        link: "/product/backpack",
    },
    {
        name: "Sunglasses",
        image: "/assets/images/products/product-7.png",
        price: 29,
        oldPrice: 49,
        label: "Hot",
        rating: 4.5,
        reviews: 300,
        colors: ["#000000", "#F59E0B"],
        category: "Accessories",
        link: "/product/sunglasses",
    },
    {
        name: "Coffee Maker",
        image: "/assets/images/products/product-8.png",
        price: 129,
        oldPrice: 179,
        label: "Best Seller",
        rating: 4.8,
        reviews: 1100,
        colors: ["#10B981", "#EC4899"],
        category: "Accessories",
        link: "/product/coffee-maker",
    },
];


export default function TopProducts() {
    return (
        <section className="py-8 bg-white">
            <div className="container mx-auto px-4 md:px-8">
                <h2 className="text-2xl font-bold mb-6 text-gray-800">Top Products</h2>


                <div className="w-full grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-5 gap-6"> {/* Responsive grid */}
                    {products.map((product) => (
                        <ProductCard key={product.name} product={product} />
                    ))}
                </div>
            </div>

        </section>
    );
}
