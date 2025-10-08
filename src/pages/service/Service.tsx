// app/pages/ServicePage.tsx
import { Link } from "react-router-dom";
import { Wrench, Sparkles, ShieldCheck, Zap, Handshake, Tag } from "lucide-react";
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

interface Service {
    id: string;
    icon: React.ElementType; // Lucide icon component
    title: string;
    description: string;
    link?: string; // Optional link to a detailed service page or contact
}

const dummyServices: Service[] = [
    {
        id: "SVC001",
        icon: Wrench,
        title: "Product Installation & Setup",
        description: "Professional installation and setup services for all our products, ensuring optimal performance from day one.",
        link: "/contact",
    },
    {
        id: "SVC002",
        icon: Sparkles,
        title: "Custom Solutions & Development",
        description: "Tailored solutions designed to meet your unique needs. We bring your specific requirements to life.",
        link: "/contact",
    },
    {
        id: "SVC003",
        icon: ShieldCheck,
        title: "Extended Warranty & Support",
        description: "Protect your investment with our extended warranty options and dedicated technical support.",
        link: "/help",
    },
    {
        id: "SVC004",
        icon: Zap,
        title: "Performance Optimization",
        description: "Maximize efficiency and speed with our expert optimization services for your existing systems.",
        link: "/contact",
    },
    {
        id: "SVC005",
        icon: Handshake,
        title: "Consultation & Training",
        description: "Get expert advice and comprehensive training for you or your team to leverage our offerings fully.",
        link: "/contact",
    },
    {
        id: "SVC006",
        icon: Tag, // Reusing Tag icon from lucide-react, assuming it's imported
        title: "Product Maintenance & Repair",
        description: "Regular maintenance and reliable repair services to keep your products running smoothly.",
        link: "/contact",
    },
];


export default function ServicePage() {
    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Services"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Services" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <p className="text-xl text-gray-700 mb-10 text-center max-w-3xl mx-auto leading-relaxed">
                        We offer a comprehensive suite of services designed to complement our products and ensure your complete satisfaction.
                        Explore how we can support you.
                    </p>

                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        {dummyServices.map((service) => {
                            const IconComponent = service.icon; // Render the icon component
                            return (
                                <div key={service.id} className="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 flex flex-col items-center text-center">
                                    <IconComponent className="h-12 w-12 text-blue-600 mb-4" />
                                    <h2 className="text-xl font-bold text-gray-800 mb-3">{service.title}</h2>
                                    <p className="text-gray-700 flex-grow mb-4">{service.description}</p>
                                    {service.link && (
                                        <Link
                                            to={service.link}
                                            className="mt-auto inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        >
                                            Learn More
                                        </Link>
                                    )}
                                </div>
                            );
                        })}
                    </div>

                    {/* Call to Action */}
                    <div className="text-center bg-blue-50 text-blue-800 p-10 rounded-lg shadow-inner mt-12">
                        <h2 className="text-3xl font-bold mb-4">Can't find what you're looking for?</h2>
                        <p className="text-lg mb-6 max-w-2xl mx-auto">
                            Our team is ready to discuss your specific needs and create a custom solution.
                        </p>
                        <Link
                            to="/contact"
                            className="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Contact Our Experts
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    );
}