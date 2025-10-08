// app/routes/categories/index.tsx
import { Link, MetaFunction } from 'react-router';
import { Breadcrumbs } from '../../components/common/Breadcrumb/Breadcrumb';


export const meta: MetaFunction = () => {
    return [{ title: "Shop - Your Store" }, { name: "description", content: "Explore our wide range of products." }];
};

// You might want to move this data to a loader function in a real app
const categories = [
    { name: "Electronics", image: "/assets/images/categories/electronics.png", link: "/category/electronics" },
    { name: "Fashion", image: "/assets/images/categories/fashion.png", link: "/category/fashion" },
    { name: "Home & Garden", image: "/assets/images/categories/home.png", link: "/category/home-garden" },
    { name: "Sports & Outdoors", image: "/assets/images/categories/sports.png", link: "/category/sports" }, // More descriptive
    { name: "Beauty & Personal Care", image: "/assets/images/categories/beauty.png", link: "/category/beauty" }, // More descriptive
    { name: "Toys & Games", image: "/assets/images/categories/toys.png", link: "/category/toys" }, // More descriptive
    { name: "Books", image: "/assets/images/categories/books.png", link: "/category/books" },
    { name: "Groceries", image: "/assets/images/categories/groceries.png", link: "/category/groceries" },
    { name: "Automotive", image: "/assets/images/categories/automotive.png", link: "/category/automotive" },
    { name: "Health & Wellness", image: "/assets/images/categories/health.png", link: "/category/health-wellness" },
    { name: "Jewelry", image: "/assets/images/categories/jewelry.png", link: "/category/jewelry" },
    { name: "Pet Supplies", image: "/assets/images/categories/pets.png", link: "/category/pet-supplies" },
];

export default function Categories() {
    return (

        <div>
            {/* Breadcrumbs / Page Header */}
            <Breadcrumbs
                title="Categories"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Categories" } // Current page, no link
                ]}
                backgroundColor="bg-blue-100" // Or "bg-blue-100", "bg-gray-100" etc.
                containerClassName="py-10 md:py-16 shadow-sm" // Add some extra padding and shadow to the header itself
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900" // Example of customizing title
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">





                    {/* Categories Grid */}
                    <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                        {categories.map((cat) => (
                            <Link
                                key={cat.name}
                                to={cat.link}
                                className="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out transform hover:-translate-y-1 group"
                            >
                                <img
                                    src={cat.image}
                                    alt={cat.name}
                                    className="w-20 h-20 md:w-24 md:h-24 object-contain mb-4 group-hover:scale-105 transition-transform duration-300"
                                />
                                <span className="text-gray-800 text-lg md:text-xl font-semibold text-center group-hover:text-blue-600 transition-colors duration-300">
                                    {cat.name}
                                </span>
                            </Link>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}