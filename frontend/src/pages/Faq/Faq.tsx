// app/pages/FAQPage.tsx
import { useState } from "react";
import { Plus, Minus, HelpCircle } from "lucide-react";
import { Link } from "react-router-dom";
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

interface FAQItem {
    id: string;
    question: string;
    answer: string;
}

const dummyFAQs: FAQItem[] = [
    {
        id: "1",
        question: "How do I place an order?",
        answer: "To place an order, simply browse our products, add items to your cart, and proceed to checkout. Follow the steps for shipping and payment, then confirm your order.",
    },
    {
        id: "2",
        question: "What payment methods do you accept?",
        answer: "We accept major credit cards (Visa, MasterCard, American Express), PayPal, and other secure payment options. You can see the full list during checkout.",
    },
    {
        id: "3",
        question: "How can I track my order?",
        answer: "Once your order is shipped, you will receive an email with a tracking number and a link to track your package's journey. You can also find tracking information in your user profile under 'Order History'.",
    },
    {
        id: "4",
        question: "What is your return policy?",
        answer: "We offer a 30-day return policy for most items, provided they are in their original condition and packaging. Please refer to our 'Returns & Refunds' section in the Help Center for detailed information.",
    },
    {
        id: "5",
        question: "Do you offer international shipping?",
        answer: "Yes, we do! International shipping options and costs vary by destination. You can calculate shipping fees during the checkout process before finalizing your order.",
    },
    {
        id: "6",
        question: "How do I create an account?",
        answer: "You can create an account by clicking on the 'Sign Up' or 'Register' link in the top right corner of our website. Fill in your details, and you'll be ready to enjoy personalized shopping.",
    },
    {
        id: "7",
        question: "How do I contact customer support?",
        answer: "Our customer support team is available via our 'Contact Us' page, email at support@yourcompany.com, or by phone during business hours. Visit the 'Help' page for all contact options.",
    },
];

const FAQItemComponent: React.FC<{ faq: FAQItem; isOpen: boolean; toggleOpen: () => void }> = ({ faq, isOpen, toggleOpen }) => {
    return (
        <div className="border-b border-gray-200 py-4">
            <button
                className="flex justify-between items-center w-full text-left font-semibold text-lg text-gray-800 hover:text-blue-600 transition-colors duration-200"
                onClick={toggleOpen}
            >
                {faq.question}
                {isOpen ? <Minus className="h-5 w-5 text-blue-600" /> : <Plus className="h-5 w-5 text-gray-500" />}
            </button>
            {isOpen && (
                <div className="mt-3 text-gray-700 pr-8">
                    <p>{faq.answer}</p>
                </div>
            )}
        </div>
    );
};

export default function FAQPage() {
    const [openFAQId, setOpenFAQId] = useState<string | null>(null);

    const toggleFAQ = (id: string) => {
        setOpenFAQId(openFAQId === id ? null : id);
    };

    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="FAQ"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "FAQ" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <h1 className="text-4xl font-extrabold text-gray-900 mb-4 text-center flex items-center justify-center gap-3">
                        <HelpCircle className="h-9 w-9 text-blue-600" /> Frequently Asked Questions
                    </h1>
                    <p className="text-xl text-gray-700 mb-10 text-center leading-relaxed">
                        Find quick answers to our most common questions. If you can't find what you're looking for, feel free to contact us.
                    </p>

                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        {dummyFAQs.map((faq) => (
                            <FAQItemComponent
                                key={faq.id}
                                faq={faq}
                                isOpen={openFAQId === faq.id}
                                toggleOpen={() => toggleFAQ(faq.id)}
                            />
                        ))}
                    </div>

                    <div className="text-center mt-12 p-8 bg-gray-50 rounded-lg shadow-inner">
                        <h2 className="text-2xl font-bold text-gray-800 mb-4">Still have questions?</h2>
                        <p className="text-lg text-gray-600 mb-6">
                            Our support team is happy to assist you.
                        </p>
                        <Link
                            to="/contact"
                            className="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        >
                            Contact Support
                        </Link>
                    </div>
                </div>
            </section>
        </div>
    );
}