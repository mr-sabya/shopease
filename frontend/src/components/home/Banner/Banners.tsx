import { Swiper, SwiperSlide } from "swiper/react";
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
import "swiper/css/autoplay";
import "./banner.css"; // Keep your custom CSS if you have any specific overrides

// Important: Use `Link` from `@remix-run/react` for Remix applications

import { Autoplay, Navigation, Pagination } from "swiper/modules";
import { Link } from "react-router";

// Define the type for a slide to ensure type safety
interface Slide {
    image: string;
    title: string;
    subtitle: string;
    link: string;
    button: string;
}

const slides: Slide[] = [
    {
        image: "/assets/images/banner-bg-3.png", // Ensure this path is correct
        title: 'Summer Sale Up to <span class="text-red-400">50% Off</span>', // Added Tailwind class for styling
        subtitle: "Grab your favorite products now!",
        link: "/shop",
        button: "Shop Now",
    },
    {
        image: "/assets/images/banner-bg-3.png", // Ensure this path is correct
        title: "New Arrivals are Here",
        subtitle: "Check out the latest trends",
        link: "/shop",
        button: "Explore",
    },
    {
        image: "/assets/images/banner-bg-3.png", // Ensure this path is correct
        title: "Free Shipping on Orders <span class='text-green-300'>$50+</span>", // Example with another color
        subtitle: "Hurry! Limited time offer",
        link: "/shop",
        button: "Shop Now",
    },
];

export default function Banner() {
    return (
        <div className="w-full relative banner">
            <Swiper
                modules={[Autoplay, Pagination, Navigation]}
                autoplay={{ delay: 4000, disableOnInteraction: false }}
                loop={true}
                pagination={{ clickable: true }}
                navigation={true}
                className="h-80 md:h-[400px] lg:h-[550px]"
            >
                {slides.map((slide, index) => (
                    <SwiperSlide key={index}>
                        <div
                            className="w-full h-full bg-cover bg-center relative banner-item" // Changed h-80/400/550px to h-full as SwiperSlide already controls height
                            style={{ backgroundImage: `url('${slide.image}')` }}
                        >
                            {/* Overlay */}
                            <div className="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <div className="text-center text-white px-4 md:px-8 max-w-4xl"> {/* Added max-w for better readability on large screens */}
                                    <h2
                                        className="text-3xl md:text-5xl lg:text-6xl font-extrabold mb-3 md:mb-4 leading-tight" // Increased text size, font-weight, and line-height
                                        dangerouslySetInnerHTML={{ __html: slide.title }}
                                    ></h2>
                                    <p className="mb-6 text-base md:text-xl lg:text-2xl font-light opacity-90"> {/* Increased text size and reduced opacity */}
                                        {slide.subtitle}
                                    </p>
                                    <Link
                                        to={slide.link}
                                        className="inline-block bg-blue-600 hover:bg-blue-700 text-white px-7 py-3 rounded-full text-base md:text-lg font-semibold transition transform hover:scale-105 duration-300 ease-in-out" // Larger button, better hover effects
                                    >
                                        {slide.button}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </SwiperSlide>
                ))}
            </Swiper>
        </div>
    );
}