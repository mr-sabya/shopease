// app/pages/HelpPage.tsx
import { Link } from "react-router-dom";
import { LifeBuoy, BookOpen, MessageCircle, Phone, Mail, User, ShieldCheck } from "lucide-react"; // Make sure ShieldCheck is imported
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

interface HelpLink {
    id: string;
    icon: React.ElementType;
    title: string;
    description: string;
    link: string;
    isExternal?: boolean; // If the link goes outside the app
}

const dummyHelpLinks: HelpLink[] = [
    {
        id: "HLP001",
        icon: BookOpen,
        title: "Read FAQs",
        description: "Find instant answers to common questions about orders, payments, shipping, and more.",
        link: "/faq",
    },
    {
        id: "HLP002",
        icon: User,
        title: "Manage My Account",
        description: "Update your profile, view order history, and manage addresses in your personal dashboard.",
        link: "/profile",
    },
    {
        id: "HLP003",
        icon: MessageCircle,
        title: "Contact Us Directly",
        description: "Can't find what you need? Send us a message and our support team will assist you.",
        link: "/contact",
    },
    {
        id: "HLP004",
        icon: Phone,
        title: "Call Our Support Line",
        description: "Speak with a customer service representative for immediate assistance during business hours.",
        link: "tel:+15551234567",
        isExternal: true,
    },
    {
        id: "HLP005",
        icon: Mail,
        title: "Email Support",
        description: "Send us an email with your detailed query, and we'll get back to you within 24-48 hours.",
        link: "mailto:support@yourcompany.com",
        isExternal: true,
    },
    {
        id: "HLP006",
        icon: ShieldCheck,
        title: "Privacy & Legal",
        description: "Review our privacy policy and terms of service for important legal information.",
        link: "/privacy-policy", // or a general legal page
    },
];

export default function HelpPage() {
    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Help"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Help" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <h1 className="text-4xl font-extrabold text-gray-900 mb-4 text-center flex items-center justify-center gap-3">
                        <LifeBuoy className="h-9 w-9 text-blue-600" /> Help Center
                    </h1>
                    <p className="text-xl text-gray-700 mb-10 text-center max-w-3xl mx-auto leading-relaxed">
                        How can we help you today? Find answers, manage your account, or get in touch with our support team.
                    </p>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {dummyHelpLinks.map((item) => {
                            const IconComponent = item.icon;
                            // Define common styles for the link/button
                            const commonLinkClasses = "bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col items-center text-center group";
                            const iconClasses = "h-12 w-12 text-blue-600 mb-4 group-hover:text-blue-700 transition-colors";
                            const titleClasses = "text-xl font-bold text-gray-800 mb-3 group-hover:text-blue-800 transition-colors";
                            const descriptionClasses = "text-gray-700 flex-grow mb-4";
                            const spanClasses = "mt-auto text-blue-600 group-hover:underline font-medium";

                            return (
                                <div key={item.id}> {/* Wrapper div for consistent key handling */}
                                    {item.isExternal ? (
                                        <a
                                            href={item.link}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            className={commonLinkClasses}
                                        >
                                            <IconComponent className={iconClasses} />
                                            <h2 className={titleClasses}>{item.title}</h2>
                                            <p className={descriptionClasses}>{item.description}</p>
                                            <span className={spanClasses}>Go to Link</span>
                                        </a>
                                    ) : (
                                        <Link
                                            to={item.link}
                                            className={commonLinkClasses}
                                        >
                                            <IconComponent className={iconClasses} />
                                            <h2 className={titleClasses}>{item.title}</h2>
                                            <p className={descriptionClasses}>{item.description}</p>
                                            <span className={spanClasses}>View Details</span>
                                        </Link>
                                    )}
                                </div>
                            );
                        })}
                    </div>

                    <div className="text-center mt-12 p-8 bg-gray-50 rounded-lg shadow-inner">
                        <h2 className="text-2xl font-bold text-gray-800 mb-4">Need personalized assistance?</h2>
                        <p className="text-lg text-gray-600 mb-6">
                            Our dedicated support agents are here to provide one-on-one help.
                        </p>
                        <Link
                            to="/contact"
                            className="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Chat with Support
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    );
}