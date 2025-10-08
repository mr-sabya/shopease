// app/components/DeliveryOptionCard.tsx
import React from 'react';

interface DeliveryOptionCardProps {
    type: 'pickup' | 'same-day';
    title: string;
    description: string;
    badgeText: string;
    imageSrc: string;
    imageAlt: string;
}

const DeliveryOptionCard: React.FC<DeliveryOptionCardProps> = ({
    type,
    title,
    description,
    badgeText,
    imageSrc,
    imageAlt,
}) => {
    const gradientClass =
        type === 'pickup'
            ? 'bg-gradient-to-r from-purple-100 to-white'
            : 'bg-gradient-to-r from-red-50 to-white';
    const titleColorClass = type === 'pickup' ? 'text-blue-600' : 'text-blue-600'; // Both seem blue in your image
    const badgeColorClass = type === 'pickup' ? 'bg-red-400' : 'bg-red-400'; // Both seem red in your image

    return (
        <div
            className={`relative flex items-center p-6 rounded-xl shadow-sm border border-gray-100 overflow-hidden ${gradientClass}`}
        >
            {/* Badge */}
            <span
                className={`absolute top-0 left-0 px-3 py-1 text-xs font-semibold text-white rounded-br-lg ${badgeColorClass}`}
            >
                {badgeText}
            </span>

            {/* Text Content */}
            <div className="flex-1 pr-4">
                <h3 className={`text-2xl font-bold mb-2 ${titleColorClass}`}>
                    {title}
                </h3>
                <p className="text-gray-700 text-base">{description}</p>
            </div>

            {/* Image */}
            <div className="flex-shrink-0 w-40 h-40 relative">
                <div className="absolute inset-0 flex items-center justify-center rounded-ful">
                    <img
                        src={imageSrc}
                        alt={imageAlt}
                        className="object-cover w-full h-full"
                    />
                </div>
            </div>
        </div>
    );
};

export default DeliveryOptionCard;