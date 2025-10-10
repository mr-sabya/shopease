import { useState } from "react"; // <--- Import useState

import { ChevronDown, SlidersHorizontal } from "lucide-react"; // Import filter icon
import { Product } from "../../types/product";
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";
import { ProductCard } from "../../components/common/ProductCard/ProductCard";
import usePageMetadata from "../../hooks/usePageMetadata";


// Dummy data for products (you'd typically fetch this from a Remix loader)
const products: Product[] = [
    {
        name: "Kalrez® Spectrum™ 6375 O-Rings",
        image: "/assets/images/products/product-1.png",
        price: 17.84,
        oldPrice: 30.0,
        label: "Sale",
        rating: 5,
        reviews: 6400,
        colors: ["#3B82F6", "#10B981"],
        category: "Industrial",
        material: "Rubber",
        link: "/product/kalrez-spectrum",
    },
    {
        name: "Elegant Chiffon Bell Sleeves Dress",
        image: "/assets/images/products/product-2.png",
        price: 78,
        oldPrice: 100,
        label: "20% OFF",
        rating: 5,
        reviews: 6400,
        colors: ["#F59E0B", "#EC4899", "#A78BFA"],
        category: "Apparel",
        size: ["S", "M", "L"],
        material: "Chiffon",
        link: "/product/chiffon-bell-sleeves-dress",
    },
    {
        name: "Premium Wireless Noise-Cancelling Headphones",
        image: "/assets/images/products/product-3.png",
        price: 99,
        oldPrice: 129,
        label: "New",
        rating: 4.5,
        reviews: 1200,
        colors: ["#000000", "#FFFFFF"],
        category: "Electronics",
        link: "/product/wireless-headphones",
    },
    {
        name: "Advanced Fitness Smart Watch with Heart Rate Monitor",
        image: "/assets/images/products/product-4.png",
        price: 199,
        oldPrice: 249,
        label: "Trending",
        rating: 4.7,
        reviews: 800,
        colors: ["#3B82F6", "#10B981"],
        category: "Electronics",
        link: "/product/smart-watch",
    },
    {
        name: "Stylish Sportswear Sneakers for Men & Women",
        image: "/assets/images/products/product-5.png",
        price: 79,
        oldPrice: 99,
        label: "Sale",
        rating: 4.3,
        reviews: 950,
        colors: ["#F59E0B", "#EC4899"],
        category: "Footwear",
        size: ["7", "8", "9", "10"],
        material: "Canvas",
        link: "/product/sneakers",
    },
    {
        name: "Durable Travel Backpack with Laptop Compartment",
        image: "/assets/images/products/product-6.png",
        price: 49,
        oldPrice: 69,
        label: "Limited Stock",
        rating: 4.0,
        reviews: 600,
        colors: ["#3B82F6", "#A78BFA"],
        category: "Bags",
        material: "Polyester",
        link: "/product/backpack",
    },
    {
        name: "Classic UV Protection Fashion Sunglasses",
        image: "/assets/images/products/product-7.png",
        price: 29,
        oldPrice: 49,
        label: "Hot Deal",
        rating: 4.5,
        reviews: 300,
        colors: ["#000000", "#F59E0B"],
        category: "Accessories",
        link: "/product/sunglasses",
    },
    {
        name: "Programmable Drip Coffee Maker",
        image: "/assets/images/products/product-8.png",
        price: 129,
        oldPrice: 179,
        label: "Best Seller",
        rating: 4.8,
        reviews: 1100,
        colors: ["#10B981", "#EC4899"],
        category: "Home & Kitchen",
        link: "/product/coffee-maker",
    },
    {
        name: "Ergonomic Office Chair",
        image: "/assets/images/products/product-9.png",
        price: 249,
        oldPrice: 300,
        label: "New",
        rating: 4.6,
        reviews: 750,
        colors: ["#000000", "#6B7280"],
        category: "Furniture",
        material: "Mesh",
        link: "/product/office-chair",
    },
    {
        name: "Stainless Steel Water Bottle",
        image: "/assets/images/products/product-10.png",
        price: 19.99,
        label: "Eco-Friendly",
        rating: 4.2,
        reviews: 200,
        colors: ["#3B82F6", "#10B981"],
        category: "Accessories",
        link: "/product/water-bottle",
    },
];

// Helper for unique values for filters (for demonstration)
const getUniqueValues = (arr: Product[], key: keyof Product) => {
    const values = arr.map(item => item[key]).flat().filter(Boolean) as string[]; // Handle arrays like 'size'
    return Array.from(new Set(values.sort()));
};

const categories = getUniqueValues(products, "category");
const colors = getUniqueValues(products, "colors"); // Treat colors as a variation/attribute
const sizes = getUniqueValues(products, "size"); // Treat sizes as a variation
const materials = getUniqueValues(products, "material"); // Treat materials as an attribute

// Helper component for Collapsible Filter Sections (defined outside the main component)
interface CollapsibleFilterProps {
    title: string;
    children: React.ReactNode;
    defaultOpen?: boolean;
}

const CollapsibleFilter: React.FC<CollapsibleFilterProps> = ({ title, children, defaultOpen = true }) => {
    const [isOpen, setIsOpen] = useState(defaultOpen);

    return (
        <div className="mb-6">
            <button
                className="font-semibold text-gray-700 mb-3 flex justify-between items-center w-full cursor-pointer focus:outline-none focus:ring-1 focus:ring-blue-500 rounded-sm p-1 -m-1" // Added focus styles
                onClick={() => setIsOpen(!isOpen)}
                aria-expanded={isOpen}
                aria-controls={`filter-${title.toLowerCase().replace(/\s/g, '-')}`}
            >
                {title}
                <ChevronDown className={`h-4 w-4 transform transition-transform duration-200 ${isOpen ? 'rotate-0' : '-rotate-90'}`} />
            </button>
            <div
                id={`filter-${title.toLowerCase().replace(/\s/g, '-')}`}
                className={`overflow-hidden transition-all duration-300 ease-in-out ${isOpen ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'}`} // max-h-96 should be enough for most content
            >
                {children}
            </div>
        </div>
    );
};


export default function Shop() { // Renamed from 'shop' to 'ShopPage' for consistency and clarity
    usePageMetadata({
        title: 'Home Page | My Awesome App',
        description: 'This is the main entry point of our application, offering a variety of products and services.',
        keywords: 'home, app, products, services, main page',
        ogTitle: 'Welcome to My Awesome App!',
        ogDescription: 'Explore the best products and services on our homepage.',
        ogImage: 'https://example.com/assets/images/home-hero.jpg',
        ogUrl: 'https://example.com/',
        canonicalUrl: 'https://example.com/',
    });
    return (

        <div>
            {/* Breadcrumbs / Page Header */}
            <Breadcrumbs
                title="Shop All Products"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Shop" } // Current page, no link
                ]}
                backgroundColor="bg-blue-100" // Or "bg-blue-100", "bg-gray-100" etc.
                containerClassName="py-10 md:py-16 shadow-sm" // Add some extra padding and shadow to the header itself
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900" // Example of customizing title
            />
            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">


                    <div className="flex flex-col lg:flex-row gap-8">
                        {/* Sidebar Filters */}
                        <aside className="w-full lg:w-1/4 p-6 bg-white rounded-lg shadow-md self-start sticky top-4">
                            <div className="mb-6 border-b pb-4">
                                <h3 className="text-xl font-semibold text-gray-800 flex items-center mb-2">
                                    <SlidersHorizontal className="h-5 w-5 mr-2 text-blue-600" />
                                    Filters
                                </h3>
                                <button className="text-sm text-blue-600 hover:text-blue-800">Clear All</button>
                            </div>

                            {/* Category Filter */}
                            <CollapsibleFilter title="Category">
                                <ul className="space-y-2 text-sm">
                                    {categories.map(cat => (
                                        <li key={cat} className="flex items-center">
                                            <input type="checkbox" id={`cat-${cat}`} name="category" value={cat} className="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                                            <label htmlFor={`cat-${cat}`} className="ml-2 text-gray-600">{cat}</label>
                                        </li>
                                    ))}
                                </ul>
                            </CollapsibleFilter>

                            {/* Price Range Filter */}
                            <CollapsibleFilter title="Price Range">
                                <div className="flex items-center space-x-2">
                                    <input type="number" placeholder="Min" className="w-1/2 p-2 border border-gray-300 rounded-md text-sm text-gray-700" />
                                    <span>-</span>
                                    <input type="number" placeholder="Max" className="w-1/2 p-2 border border-gray-300 rounded-md text-sm text-gray-700" />
                                </div>
                                <button className="mt-3 w-full bg-blue-600 text-white py-2 rounded-md text-sm hover:bg-blue-700 transition">Apply</button>
                            </CollapsibleFilter>

                            {/* Variations: Color */}
                            <CollapsibleFilter title="Color" defaultOpen={true}>
                                <div className="flex flex-wrap gap-2">
                                    {colors.map(color => (
                                        <button
                                            key={color}
                                            className="w-6 h-6 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500"
                                            style={{ backgroundColor: color }}
                                            aria-label={`Color ${color}`}
                                        ></button>
                                    ))}
                                </div>
                            </CollapsibleFilter>

                            {/* Variations: Size */}
                            {sizes.length > 0 && (
                                <CollapsibleFilter title="Size" defaultOpen={true}>
                                    <div className="flex flex-wrap gap-2">
                                        {sizes.map(size => (
                                            <button
                                                key={size}
                                                className="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-500 text-gray-800"
                                            >
                                                {size}
                                            </button>
                                        ))}
                                    </div>
                                </CollapsibleFilter>
                            )}


                            {/* Attributes: Material */}
                            {materials.length > 0 && (
                                <CollapsibleFilter title="Material" defaultOpen={true}>
                                    <ul className="space-y-2 text-sm">
                                        {materials.map(mat => (
                                            <li key={mat} className="flex items-center">
                                                <input type="checkbox" id={`mat-${mat}`} name="material" value={mat} className="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                                                <label htmlFor={`mat-${mat}`} className="ml-2 text-gray-600">{mat}</label>
                                            </li>
                                        ))}
                                    </ul>
                                </CollapsibleFilter>
                            )}
                            {/* You can add more attribute filters similarly */}

                        </aside>

                        {/* Main Product Grid */}
                        <main className="w-full lg:w-3/4">
                            {/* Sort & Pagination Controls (Placeholder) */}
                            <div className="flex justify-between items-center bg-white p-4 rounded-lg shadow-sm mb-6">
                                <span className="text-gray-700 text-sm md:text-base">{products.length} Products Found</span>
                                <div className="flex items-center space-x-4">
                                    <label htmlFor="sort-by" className="text-gray-700 text-sm">Sort by:</label>
                                    <select id="sort-by" className="p-2 border border-gray-300 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 text-gray-700">
                                        <option>Relevance</option>
                                        <option>Price: Low to High</option>
                                        <option>Price: High to Low</option>
                                        <option>Newest Arrivals</option>
                                        <option>Top Rated</option>
                                    </select>
                                </div>
                            </div>

                            <div className="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                {products.map((product) => (
                                    <ProductCard key={product.name} product={product} />
                                ))}
                            </div>

                            {/* Pagination (Placeholder) */}
                            <div className="mt-8 flex justify-center">
                                <nav className="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <a href="#" className="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span className="sr-only">Previous</span>
                                        {/* Heroicon name: solid/chevron-left */}
                                        <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fillRule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clipRule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="#" aria-current="page" className="z-10 bg-blue-50 border-blue-600 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        1
                                    </a>
                                    <a href="#" className="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        2
                                    </a>
                                    <a href="#" className="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                        3
                                    </a>
                                    <a href="#" className="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span className="sr-only">Next</span>
                                        {/* Heroicon name: solid/chevron-right */}
                                        <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </main>
                    </div>
                </div>
            </section>
        </div>
    );
}