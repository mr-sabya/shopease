// app/components/MegaCollections.tsx
import { CollectionCardProps } from "../../../types/collection";
import { CollectionCard } from "./CollectionCard";

// This would typically come from a loader function in a Remix route
const collectionsData: CollectionCardProps[] = [
    {
        id: "sunglass",
        title: "Explore The Sunglass",
        description: "The Bouguessa FW21 collection is.",
        price: 178.00,
        imageSrc: "/assets/images/products/collection_1.jpg", // Replace with your image URLs
        imageAlt: "Couple wearing stylish sunglasses",
        tag: "SUNGLASS",
    },
    {
        id: "headphones",
        title: "Inspire Creativity",
        description: "The Bouguessa FW21 collection is.",
        price: 69.00,
        imageSrc: "/assets/images/products/collection_2.jpg",
        imageAlt: "Pink wireless headphones",
        tag: "SALE",
    },
    {
        id: "backpack",
        title: "Trade Benefits",
        description: "The Bouguessa FW21 collection is.",
        price: 159.00,
        imageSrc: "/assets/images/products/collection_3.jpg",
        imageAlt: "Brown leather backpack",
    },
    {
        id: "winterwear",
        title: "Find A Great Deal",
        description: "The Bouguessa FW21 collection is.",
        price: 299.00,
        imageSrc: "/assets/images/products/collection_4.jpg",
        imageAlt: "Two people in winter clothing",
        tag: "JACKET",
    },
];

export function MegaCollections() {
    const [firstCollection, secondCollection, thirdCollection, fourthCollection] = collectionsData;

    return (
        <section className="bg-gray-900 py-10 px-4 md:px-10">
            <div className="container mx-auto px-4 md:px-8">
                <h2 className="mb-12 text-center text-4xl font-bold text-white md:text-5xl">
                    Our Mega Collections{" "}
                    <span className="inline-block animate-pulse text-red-500">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            className="h-10 w-10 md:h-12 md:w-12"
                        >
                            <path
                                fillRule="evenodd"
                                d="M9.363 2.25a.75.75 0 0 1 .613 1.157L7.472 9.75h4.156c.409 0 .762.306.79.715l.135 1.996c.033.488-.347.904-.84.904H6.892l1.246 6.341c.118.6-.289 1.2-.916 1.241-1.125.076-1.921-.77-2.188-1.992l-.99-4.874H3.75c-.412 0-.766-.312-.792-.724l-.007-.165c-.033-.488.347-.904.84-.904H6.01L4.764 3.305a.75.75 0 0 1 .613-1.157h3.986Z"
                                clipRule="evenodd"
                            />
                        </svg>
                    </span>
                </h2>

                {/* First row: 7:5 layout */}
                <div className="grid grid-cols-1 gap-8 md:grid-cols-12">
                    {firstCollection && (
                        <div className="md:col-span-7">
                            <CollectionCard key={firstCollection.id} {...firstCollection} />
                        </div>
                    )}
                    {secondCollection && (
                        <div className="md:col-span-5">
                            <CollectionCard key={secondCollection.id} {...secondCollection} />
                        </div>
                    )}
                </div>

                {/* Second row: 5:7 layout */}
                <div className="mt-8 grid grid-cols-1 gap-8 md:grid-cols-12">
                    {thirdCollection && (
                        <div className="md:col-span-5">
                            <CollectionCard key={thirdCollection.id} {...thirdCollection} />
                        </div>
                    )}
                    {fourthCollection && (
                        <div className="md:col-span-7">
                            <CollectionCard key={fourthCollection.id} {...fourthCollection} />
                        </div>
                    )}
                </div>
            </div>
        </section>
    );
}
