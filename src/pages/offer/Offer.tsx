// app/pages/OfferPage.tsx
import { Link } from "react-router-dom";
import { Tag, Percent, Gift, Sparkles } from "lucide-react"; // Icons for different offer types
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

// --- Interface for an individual offer ---
interface Offer {
    id: string;
    title: string;
    description: string;
    image: string; // URL to an image representing the offer
    type: "discount" | "bundle" | "free_shipping" | "limited_time"; // Categorize offers
    link: string; // Where the "Shop Now" button leads
    buttonText: string;
    highlightColor: string; // Tailwind color class for visual distinction
}

// --- Dummy Data for Offers ---
const dummyOffers: Offer[] = [
    {
        id: "OFFER001",
        title: "Flash Sale: Up to 50% Off!",
        description: "Don't miss out on our biggest discounts on electronics and fashion. Limited time only!",
        image: "/assets/images/offers/flash-sale.jpg", // Example image path
        type: "limited_time",
        link: "/shop?category=flash-sale",
        buttonText: "Shop Flash Sale",
        highlightColor: "bg-red-50 text-red-700",
    },
    {
        id: "OFFER002",
        title: "Buy One Get One 50% Off",
        description: "Mix and match your favorite apparel. Add two items to your cart and get the second for half price!",
        image: "/assets/images/offers/bogo.jpg", // Example image path
        type: "bundle",
        link: "/shop?category=apparel",
        buttonText: "Explore Apparel",
        highlightColor: "bg-green-50 text-green-700",
    },
    {
        id: "OFFER003",
        title: "Free Shipping on All Orders!",
        description: "For a limited period, enjoy complimentary standard shipping on every purchase, no minimum required.",
        image: "/assets/images/offers/free-shipping.jpg", // Example image path
        type: "free_shipping",
        link: "/shop",
        buttonText: "Start Shopping",
        highlightColor: "bg-blue-50 text-blue-700",
    },
    {
        id: "OFFER004",
        title: "20% Off Your First Order",
        description: "New to our store? Use code WELCOME20 at checkout to get 20% off your entire first purchase.",
        image: "/assets/images/offers/first-order.jpg", // Example image path
        type: "discount",
        link: "/signup", // Maybe link to sign up or directly to shop
        buttonText: "Sign Up & Save",
        highlightColor: "bg-purple-50 text-purple-700",
    },
    {
        id: "OFFER005",
        title: "Weekend Deals: Gadgets & Gizmos",
        description: "Grab the latest tech with special weekend-only prices. Perfect for upgrading your setup.",
        image: "/assets/images/offers/gadgets.jpg", // Example image path
        type: "limited_time",
        link: "/shop?category=electronics",
        buttonText: "View Gadgets",
        highlightColor: "bg-yellow-50 text-yellow-700",
    },
    {
        id: "OFFER006",
        title: "Exclusive Member Discounts",
        description: "Join our loyalty program and unlock exclusive discounts, early access to sales, and more!",
        image: "/assets/images/offers/member.jpg", // Example image path
        type: "discount",
        link: "/account/membership",
        buttonText: "Become a Member",
        highlightColor: "bg-indigo-50 text-indigo-700",
    },
];

// --- OfferCard Component ---
const OfferCard: React.FC<{ offer: Offer }> = ({ offer }) => {
    const getIcon = (type: Offer["type"]) => {
        switch (type) {
            case "discount":
                return <Percent className="h-5 w-5" />;
            case "bundle":
                return <Gift className="h-5 w-5" />;
            case "free_shipping":
                return <Tag className="h-5 w-5" />;
            case "limited_time":
                return <Sparkles className="h-5 w-5" />;
            default:
                return <Tag className="h-5 w-5" />;
        }
    };

    return (
        <div className="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full">
            <div className="relative overflow-hidden h-48 sm:h-56">
                <img
                    src={offer.image}
                    alt={offer.title}
                    className="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                />
                <div className={`absolute top-0 right-0 m-3 px-3 py-1 rounded-full text-xs font-semibold ${offer.highlightColor}`}>
                    <div className="flex items-center gap-1">
                        {getIcon(offer.type)}
                        {offer.type.replace(/_/g, ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ')}
                    </div>
                </div>
            </div>
            <div className="p-5 flex flex-col flex-grow">
                <h3 className="text-xl font-bold text-gray-800 mb-2">{offer.title}</h3>
                <p className="text-gray-600 text-sm flex-grow mb-4">{offer.description}</p>
                <Link
                    to={offer.link}
                    className="mt-auto inline-flex items-center justify-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
                >
                    {offer.buttonText}
                </Link>
            </div>
        </div>
    );
};

export default function OfferPage() {
    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Offers"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Offers" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <p className="text-xl text-gray-700 mb-10 text-center max-w-3xl mx-auto">
                        Discover incredible savings on your favorite products. Don't miss out on these limited-time opportunities!
                    </p>

                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        {dummyOffers.map((offer) => (
                            <OfferCard key={offer.id} offer={offer} />
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
}