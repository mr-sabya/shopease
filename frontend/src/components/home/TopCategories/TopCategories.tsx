import { Link } from "react-router";

const categories = [
    { name: "Electronics", image: "/assets/images/categories/electronics.png", link: "/category/electronics" },
    { name: "Fashion", image: "/assets/images/categories/fashion.png", link: "/category/fashion" },
    { name: "Home & Garden", image: "/assets/images/categories/home.png", link: "/category/home-garden" },
    { name: "Sports", image: "/assets/images/categories/sports.png", link: "/category/sports" },
    { name: "Beauty", image: "/assets/images/categories/beauty.png", link: "/category/beauty" },
    { name: "Toys", image: "/assets/images/categories/toys.png", link: "/category/toys" },
];

export default function TopCategories() {
    return (
        <section className="py-8 bg-gray-50">
            <div className="container mx-auto px-4 md:px-8">
                <h2 className="text-2xl font-bold mb-6 text-gray-800">Top Categories</h2>

                {/* Categories Grid (Desktop) */}
                <div className="hidden md:grid grid-cols-6 gap-6">
                    {categories.map((cat) => (
                        <Link
                            key={cat.name}
                            to={cat.link}
                            className="flex flex-col items-center py-6 px-4 bg-white rounded-lg shadow hover:shadow-lg transition"
                        >
                            <img src={cat.image} alt={cat.name} className="w-16 h-16 object-contain mb-2" />
                            <span className="text-gray-700 font-medium">{cat.name}</span>
                        </Link>
                    ))}
                </div>

                {/* Horizontal Scroll (Mobile) */}
                <div className="md:hidden flex space-x-4 overflow-x-auto scrollbar-hide pt-6 pb-4">
                    {categories.map((cat) => (
                        <Link
                            key={cat.name}
                            to={cat.link}
                            className="flex flex-col items-center py-6 px-4 bg-white rounded-lg shadow hover:shadow-lg transition min-w-[100px]"
                        >
                            <img src={cat.image} alt={cat.name} className="w-12 h-12 object-contain mb-2" />
                            <span className="text-gray-700 text-sm font-medium text-center">{cat.name}</span>
                        </Link>
                    ))}
                </div>
            </div>
        </section>
    );
}
