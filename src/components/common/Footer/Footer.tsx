import Logo from "/logo.svg"; // replace with your logo path

export default function Footer() {
    return (
        <footer className="bg-gray-900 text-gray-200 pt-12">
            <div className="container mx-auto px-6">
                <div className="grid grid-cols-1 md:grid-cols-4 gap-8">

                    {/* Column 1: Logo + About */}
                    <div>
                        <img src={Logo} alt="Logo" className="w-32 mb-4" />
                        <p className="text-gray-400 text-sm">
                            We provide high-quality products and services that help you achieve your goals.
                        </p>
                    </div>

                    {/* Column 2: Quick Links */}
                    <div>
                        <h3 className="text-white font-semibold mb-4">Quick Links</h3>
                        <ul className="space-y-2 text-gray-400">
                            <li>
                                <a href="/" className="hover:text-white transition-colors">Home</a>
                            </li>
                            <li>
                                <a href="/about" className="hover:text-white transition-colors">About Us</a>
                            </li>
                            <li>
                                <a href="/services" className="hover:text-white transition-colors">Services</a>
                            </li>
                            <li>
                                <a href="/contact" className="hover:text-white transition-colors">Contact</a>
                            </li>
                        </ul>
                    </div>

                    {/* Column 3: Resources / Important Links */}
                    <div>
                        <h3 className="text-white font-semibold mb-4">Resources</h3>
                        <ul className="space-y-2 text-gray-400">
                            <li>
                                <a href="/blog" className="hover:text-white transition-colors">Blog</a>
                            </li>
                            <li>
                                <a href="/faq" className="hover:text-white transition-colors">FAQ</a>
                            </li>
                            <li>
                                <a href="/privacy" className="hover:text-white transition-colors">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="/terms" className="hover:text-white transition-colors">Terms of Service</a>
                            </li>
                        </ul>
                    </div>

                    {/* Column 4: Subscribe */}
                    <div>
                        <h3 className="text-white font-semibold mb-4">Subscribe</h3>
                        <p className="text-gray-400 text-sm mb-4">
                            Get the latest updates and offers directly in your inbox.
                        </p>
                        <form className="flex flex-col sm:flex-row gap-2">
                            <input
                                type="email"
                                placeholder="Enter your email"
                                className="px-4 py-2 rounded-md text-white w-full sm:w-auto flex-1 border border-white placeholder-gray-300 bg-transparent focus:outline-none focus:ring-2 focus:ring-blue-500"
                            />

                            <button
                                type="submit"
                                className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors"
                            >
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>

                {/* Divider */}
                <div className="border-t border-gray-700 mt-12"></div>

                {/* Copyright */}
                <div className="text-center text-gray-500 text-sm py-6">
                    &copy; {new Date().getFullYear()} Your Company. All rights reserved. <br />
                    Developed by <a href="https://yourwebsite.com" className="hover:text-white">Your Name/Team</a>
                </div>
            </div>
        </footer>
    );
}
