// app/pages/AboutPage.tsx
import { Link } from "react-router-dom";
import { Gem, Target, Eye, Users, Leaf, Sparkles } from "lucide-react"; // Icons for sections
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

export default function About() {
    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="About Us"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "About Us" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <h1 className="text-4xl font-extrabold text-gray-900 mb-6 text-center">About Our Company</h1>
                    <p className="text-xl text-gray-700 mb-12 text-center max-w-3xl mx-auto leading-relaxed">
                        Welcome to [Your Company Name], where passion meets purpose. We are dedicated to providing exceptional products/services
                        and fostering meaningful connections with our community.
                    </p>

                    {/* Introduction Section */}
                    <div className="bg-white p-8 rounded-lg shadow-lg mb-12">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                            <div>
                                <h2 className="text-3xl font-bold text-gray-800 mb-4">Our Journey</h2>
                                <p className="text-gray-700 leading-relaxed mb-4">
                                    Founded in [Year], [Your Company Name] started with a simple idea: to [briefly state founding purpose].
                                    From humble beginnings, we've grown into a thriving platform, constantly striving to innovate and
                                    exceed expectations. Our commitment to quality and customer satisfaction is at the heart of everything we do.
                                </p>
                                <p className="text-gray-700 leading-relaxed">
                                    We believe in [key belief, e.g., creating sustainable products, empowering creativity, simplifying everyday life]
                                    and are passionate about making a positive impact. Every product/service we offer is carefully curated
                                    to ensure it meets our high standards and brings value to your life.
                                </p>
                            </div>
                            <div>
                                <img
                                    src="/assets/images/about/company-team.jpg" // Example image path
                                    alt="Our Company Team"
                                    className="rounded-lg shadow-md w-full h-auto object-cover max-h-96"
                                />
                            </div>
                        </div>
                    </div>

                    {/* Mission, Vision, Values Section */}
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                        <div className="bg-white p-8 rounded-lg shadow-lg text-center">
                            <Gem className="h-12 w-12 text-blue-600 mx-auto mb-4" />
                            <h3 className="text-2xl font-bold text-gray-800 mb-3">Our Mission</h3>
                            <p className="text-gray-700 leading-relaxed">
                                To deliver innovative [products/services] that enrich the lives of our customers and contribute positively
                                to our community, while maintaining a commitment to excellence and integrity.
                            </p>
                        </div>
                        <div className="bg-white p-8 rounded-lg shadow-lg text-center">
                            <Eye className="h-12 w-12 text-green-600 mx-auto mb-4" />
                            <h3 className="text-2xl font-bold text-gray-800 mb-3">Our Vision</h3>
                            <p className="text-gray-700 leading-relaxed">
                                To be the leading [industry type] provider, recognized for our exceptional quality, customer-centric
                                approach, and sustainable practices.
                            </p>
                        </div>
                        <div className="bg-white p-8 rounded-lg shadow-lg text-center">
                            <Target className="h-12 w-12 text-purple-600 mx-auto mb-4" />
                            <h3 className="text-2xl font-bold text-gray-800 mb-3">Our Values</h3>
                            <ul className="list-none space-y-2 text-gray-700 leading-relaxed">
                                <li className="flex items-center justify-center gap-2"><Leaf className="h-4 w-4 text-green-500" /> Sustainability</li>
                                <li className="flex items-center justify-center gap-2"><Users className="h-4 w-4 text-blue-500" /> Customer Focus</li>
                                <li className="flex items-center justify-center gap-2"><Sparkles className="h-4 w-4 text-yellow-500" /> Innovation</li>
                                <li>Integrity</li>
                                <li>Excellence</li>
                            </ul>
                        </div>
                    </div>

                    {/* Call to Action */}
                    <div className="text-center bg-blue-600 text-white p-10 rounded-lg shadow-lg">
                        <h2 className="text-3xl font-bold mb-4">Join Our Journey</h2>
                        <p className="text-lg mb-6 max-w-2xl mx-auto">
                            Ready to experience the [Your Company Name] difference? Explore our offerings or get in touch with us today.
                        </p>
                        <div className="flex flex-col sm:flex-row justify-center gap-4">
                            <Link
                                to="/shop"
                                className="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-blue-600 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                Explore Our Products
                            </Link>
                            <Link
                                to="/contact"
                                className="inline-flex items-center justify-center px-6 py-3 border border-white text-base font-medium rounded-md shadow-sm text-white hover:bg-white hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
                            >
                                Contact Us
                            </Link>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}