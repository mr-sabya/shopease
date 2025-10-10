// app/components/RecentlyViewed.tsx
import { useRef } from "react";
 // Ensure path is correct

// Import Swiper React components and modules
import { Swiper, SwiperSlide } from "swiper/react";
import { Navigation, Pagination, A11y } from "swiper/modules";

// Import Swiper styles
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

// You might also need core Swiper styles if not already imported globally
// import "swiper/swiper-bundle.min.css"; // Or specifically "swiper/css"
import './recenlty-viewed.css';
import { ProductCard } from "../../common/ProductCard/ProductCard";
import type { Product } from "../../../types/product";


// --- Dummy Data (replace with actual data from a Remix loader) ---
const products: Product[] = [
    {
        name: "Kalrez® Spectrum™ 6375",
        image: "/assets/images/products/product-1.png",
        price: 17.84,
        oldPrice: 30.0,
        label: "Sale",
        rating: 5,
        reviews: 6400,
        colors: ["#3B82F6", "#10B981", "#F59E0B", "#EC4899", "#A78BFA"],
        link: "/product/kalrez-spectrum",
        category: "computer"
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
        link: "/product/calvin-dress",
        category: "computer"
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
        link: "/product/wireless-headphones",
        category: "computer"
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
        link: "/product/smart-watch",
        category: "computer"
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
        link: "/product/sneakers",
        category: "computer"
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
        link: "/product/backpack",
        category: "computer"
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
        link: "/product/sunglasses",
        category: "computer"
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
        link: "/product/coffee-maker",
        category: "computer"
    },
];
// --- End Dummy Data ---

export default function RecentlyViewed() {
    const navigationPrevRef = useRef(null);
    const navigationNextRef = useRef(null);

    return (
        <section className="bg-gray-50 py-10">
            <div className="container mx-auto px-4">
                <h2 className="mb-6 text-2xl font-bold text-gray-800">
                    Recently Viewed
                </h2>

                <div className="relative">
                    <Swiper
                        modules={[Navigation, Pagination, A11y]}
                        spaceBetween={10} // Gap between slides
                        slidesPerView={1.5} // Number of slides visible at once
                        breakpoints={{
                            // Responsive breakpoints
                            640: {
                                slidesPerView: 2.5,
                                spaceBetween: 10,
                            },
                            768: {
                                slidesPerView: 3.5,
                                spaceBetween: 15,
                            },
                            1024: {
                                slidesPerView: 4.5,
                                spaceBetween: 15,
                            },
                            1280: {
                                slidesPerView: 5.5,
                                spaceBetween: 15,
                            },
                        }}
                        navigation={{
                            prevEl: navigationPrevRef.current,
                            nextEl: navigationNextRef.current,
                        }}
                        onBeforeInit={(swiper) => {
                            // Workaround to ensure navigation refs are set before Swiper initializes
                            // This is a common pattern when using custom navigation elements
                            // with useRef and Swiper in React.
                            if (swiper.params.navigation && typeof swiper.params.navigation !== 'boolean') {
                                const navigation = swiper.params.navigation;
                                navigation.prevEl = navigationPrevRef.current;
                                navigation.nextEl = navigationNextRef.current;
                            }
                        }}
                        pagination={{ clickable: true }}
                        className="mySwiper" // Apply your custom Swiper styles here if needed
                    >
                        {products.map((product) => (
                            <SwiperSlide key={product.name}>
                                <ProductCard product={product} compact={false} />
                            </SwiperSlide>
                        ))}
                    </Swiper>

                    {/* Custom Navigation Arrows */}
                    <div
                        ref={navigationPrevRef}
                        className="absolute left-0 top-1/2 z-10 -translate-y-1/2 transform cursor-pointer rounded-full bg-white p-2 shadow-md hover:bg-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            strokeWidth={2}
                            stroke="currentColor"
                            className="h-6 w-6 text-gray-700"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M15.75 19.5 8.25 12l7.5-7.5"
                            />
                        </svg>
                    </div>
                    <div
                        ref={navigationNextRef}
                        className="absolute right-0 top-1/2 z-10 -translate-y-1/2 transform cursor-pointer rounded-full bg-white p-2 shadow-md hover:bg-gray-100"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            strokeWidth={2}
                            stroke="currentColor"
                            className="h-6 w-6 text-gray-700"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                d="M8.25 4.5 15.75 12l-7.5 7.5"
                            />
                        </svg>
                    </div>
                </div>
            </div>
        </section>
    );
}