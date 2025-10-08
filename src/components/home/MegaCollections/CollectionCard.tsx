// app/components/CollectionCard.tsx
import { CollectionCardProps } from '../../../types/collection';
import './collection.css';

export function CollectionCard({
    title,
    description,
    price,
    imageSrc,
    imageAlt,
    tag,
}: CollectionCardProps) {
    return (
        <div className="relative overflow-hidden rounded-lg bg-gray-100 shadow-md md:flex md:items-center collection-card">
            <div className="collection-text">
                <h3 className="mb-2 text-xl font-bold text-gray-800">{title}</h3>
                <p className="mb-4 text-gray-600">{description}</p>
                <div className="mb-4 flex items-baseline">
                    <span className="mr-2 text-lg font-bold text-red-600">
                        Starting From
                    </span>
                    <span className="text-3xl font-extrabold text-red-600 mb-11">
                        ${price.toFixed(2)}
                    </span>
                </div>
                <button className="flex items-center rounded-md bg-blue-600 px-6 py-3 text-white transition-colors hover:bg-blue-700">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        strokeWidth={2}
                        stroke="currentColor"
                        className="mr-2 h-5 w-5"
                    >
                        <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.75-.179 1.5-.74 2.028A1.997 1.997 0 0 1 18 18.75H6.75a1.997 1.997 0 0 1-1.977-2.328l1.262-12c.07-.75.348-1.5.74-2.028A1.998 1.998 0 0 1 9.75 3h4.5c.017-.001.033-.002.05-.002a2.333 2.333 0 0 1 2.298 2.09c.076.609.308 1.157.653 1.589L12 12.75l-4.706-4.991c.345-.432.577-.98.653-1.589A2.333 2.333 0 0 1 9.75 3h4.5c.017-.001.033-.002.05-.002a2.333 2.333 0 0 1 2.298 2.09c.076.609.308 1.157.653 1.589Z"
                        />
                    </svg>
                    SHOP BRAND
                </button>
            </div>

            <div className="relative w-full">
                <img
                    src={imageSrc}
                    alt={imageAlt}
                    className="h-full w-full object-cover"
                />
                {tag && (
                    <span className="absolute right-4 top-4 rounded-full bg-black px-3 py-1 text-xs font-semibold uppercase text-white">
                        {tag}
                    </span>
                )}
                
            </div>
        </div>
    );
}