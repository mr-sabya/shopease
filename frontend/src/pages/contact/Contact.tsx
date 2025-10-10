// app/pages/ContactPage.tsx
import { useState } from "react";
import { Mail, Phone, MapPin } from "lucide-react"; // Icons for contact info
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

export default function Contact() {
    const [formData, setFormData] = useState({
        name: "",
        email: "",
        subject: "",
        message: "",
    });

    const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        // In a real application, you would send this data to a backend service
        console.log("Contact form submitted:", formData);
        alert("Thank you for your message! We will get back to you shortly.");
        // Optionally clear the form
        setFormData({ name: "", email: "", subject: "", message: "" });
    };

    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Contact Us"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Contact Us" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <p className="text-lg text-gray-600 mb-10 text-center max-w-2xl mx-auto">
                        Have a question or want to get in touch? Fill out the form below or use our direct contact information.
                    </p>

                    <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        {/* Left Column: Contact Form */}
                        <div className="bg-white p-8 rounded-lg shadow-md">
                            <h2 className="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                Send us a message <Mail className="h-6 w-6 text-blue-600" />
                            </h2>
                            <form onSubmit={handleSubmit} className="space-y-6">
                                <div>
                                    <label htmlFor="name" className="block text-sm font-medium text-gray-700">Your Name</label>
                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value={formData.name}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <label htmlFor="email" className="block text-sm font-medium text-gray-700">Your Email</label>
                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value={formData.email}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <label htmlFor="subject" className="block text-sm font-medium text-gray-700">Subject</label>
                                    <input
                                        type="text"
                                        id="subject"
                                        name="subject"
                                        value={formData.subject}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <label htmlFor="message" className="block text-sm font-medium text-gray-700">Your Message</label>
                                    <textarea
                                        id="message"
                                        name="message"
                                        rows={5}
                                        value={formData.message}
                                        onChange={handleChange}
                                        required
                                        className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                                <button
                                    type="submit"
                                    className="w-full bg-blue-600 text-white py-3 px-4 rounded-md text-center font-semibold hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                >
                                    Submit Message
                                </button>
                            </form>
                        </div>

                        {/* Right Column: Contact Info & Map */}
                        <div className="space-y-8">
                            <div className="bg-white p-8 rounded-lg shadow-md">
                                <h2 className="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                                    Our Information <MapPin className="h-6 w-6 text-blue-600" />
                                </h2>
                                <div className="space-y-4 text-gray-700">
                                    <div className="flex items-start gap-3">
                                        <MapPin className="h-5 w-5 text-gray-500 flex-shrink-0 mt-1" />
                                        <div>
                                            <p className="font-semibold">Address:</p>
                                            <p>123 E-commerce Street,</p>
                                            <p>Suite 100,</p>
                                            <p>Business City, BC 98765</p>
                                            <p>Country</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <Phone className="h-5 w-5 text-gray-500 flex-shrink-0" />
                                        <div>
                                            <p className="font-semibold">Phone:</p>
                                            <p>+1 (555) 123-4567</p>
                                        </div>
                                    </div>
                                    <div className="flex items-center gap-3">
                                        <Mail className="h-5 w-5 text-gray-500 flex-shrink-0" />
                                        <div>
                                            <p className="font-semibold">Email:</p>
                                            <p><a href="mailto:info@yourcompany.com" className="text-blue-600 hover:underline">info@yourcompany.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Optional: Map Embed Placeholder */}
                            <div className="bg-white p-8 rounded-lg shadow-md">
                                <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    Find Us on the Map
                                </h2>
                                <div className="bg-gray-200 h-64 flex items-center justify-center rounded-md text-gray-500">
                                    {/* In a real application, you would embed a map here (e.g., Google Maps iframe) */}
                                    <p>Map Placeholder</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}