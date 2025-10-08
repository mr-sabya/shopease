import { Link } from "react-router";

import './best-deal.css';

export default function BestDeals() {
    // Featured product
    const featuredProduct = {
        name: "Decorative Plant For Home",
        image: "/assets/images/products/collection_5.jpg",
        price: 35,
        link: "/product/decorative-plant",
    };

    // Other best deals
    const bestProducts = [
        {
            name: "Ladies Short Sleeve Dress",
            image: "/assets/images/products/collection_5.png",
            price: 30.0,
            link: "/product/ladies-dress",
        },
        {
            name: "Oil Soap Wood Home Cleaner",
            image: "/assets/images/products/collection_6.png",
            price: 15.22,
            link: "/product/wood-cleaner",
        },
        {
            name: "Large Pendant Light Ceiling",
            image: "/assets/images/products/collection_7.png",
            price: 11.7,
            link: "/product/pendant-light",
        },
        {
            name: "iPhone New Model",
            image: "/assets/images/products/collection_8.png",
            price: 499.0,
            link: "/product/iphone-new",
        },
    ];

    return (
        <section className="bg-gray-50 py-10 px-4 md:px-10">
            <div className="container mx-auto px-4 md:px-8">
                {/* Header */}
                <div className="flex justify-between items-center mb-6">
                    <h2 className="text-2xl font-bold text-gray-800">
                        Today's Best Deals <span className="text-red-500">💥</span>
                    </h2>
                    <Link
                        to="/deals"
                        className="text-blue-600 font-medium hover:underline"
                    >
                        View All Deals
                    </Link>
                </div>

                {/* Grid */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {/* Featured Product */}
                    <div className="md:col-span-1 bg-white rounded-lg shadow flex flex-col md:flex-row items-center md:items-start relative overflow-hidden">

                        <div className="text-center md:text-left absolute z-1 feature-deal">
                            <h3 className="text-xl font-semibold text-gray-800">{featuredProduct.name}</h3>
                            <p className="mt-2 text-gray-500 text-sm">Starting From</p>
                            <p className="text-2xl font-bold text-pink-500 mt-1">
                                ${featuredProduct.price.toFixed(2)}
                            </p>
                            <Link
                                to={featuredProduct.link}
                                className="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                            >
                                View All Items
                            </Link>
                        </div>

                        <img
                            src={featuredProduct.image}
                            alt={featuredProduct.name}
                            className=""
                        />
                    </div>

                    {/* Other Products */}
                    <div className="grid grid-cols-2 gap-4">
                        {bestProducts.map((product, idx) => (
                            <div
                                key={idx}
                                className="bg-white rounded-lg shadow p-8 flex items-center space-x-4 deal-card"
                            >

                                <div className="text">
                                    <h4 className="text-sm font-medium text-gray-800">{product.name}</h4>
                                    <p className="text-xs text-gray-500">Starting From</p>
                                    <p className="text-sm font-bold text-pink-500">
                                        ${product.price.toFixed(2)}
                                    </p>
                                </div>

                                <div className="round">
                                    <img
                                        src={product.image}
                                        alt={product.name}
                                        className=""
                                    />
                                </div>


                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
}
