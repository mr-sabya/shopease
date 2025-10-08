// app/pages/TermsOfServicePage.tsx
import { FileText } from "lucide-react";
import { Link } from "react-router-dom";
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

export default function TermsOfServicePage() {
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
                        <FileText className="h-9 w-9 text-blue-600" /> Terms of Service
                    </h1>
                    <p className="text-xl text-gray-700 mb-10 text-center leading-relaxed">
                        Please read these terms and conditions carefully before using our website.
                    </p>

                    <div className="bg-white p-8 rounded-lg shadow-lg text-gray-700 space-y-6">
                        <p><strong>Last Updated:</strong> October 27, 2023</p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">1. Acceptance of Terms</h2>
                        <p>
                            By accessing or using our website and services, you agree to be bound by these Terms of Service
                            ("Terms") and all terms incorporated by reference. If you do not agree to all of these Terms,
                            do not use our website.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">2. Changes to Terms</h2>
                        <p>
                            We reserve the right to modify or change these Terms at any time. Any changes will be effective
                            immediately upon posting the revised Terms on our website. Your continued use of the website
                            after any such changes constitutes your acceptance of the new Terms.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">3. Privacy Policy</h2>
                        <p>
                            Please refer to our <Link to="/privacy-policy" className="text-blue-600 hover:underline">Privacy Policy</Link> for information on how we collect, use, and disclose information about our users.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">4. User Accounts</h2>
                        <p>
                            When you create an account with us, you must provide information that is accurate, complete,
                            and current at all times. Failure to do so constitutes a breach of the Terms, which may result
                            in immediate termination of your account on our Service. You are responsible for safeguarding
                            the password that you use to access the Service and for any activities or actions under your password.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">5. Intellectual Property</h2>
                        <p>
                            The Service and its original content, features, and functionality are and will remain the exclusive
                            property of [Your Company Name] and its licensors. Our trademarks and trade dress may not be used
                            in connection with any product or service without the prior written consent of [Your Company Name].
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">6. Links To Other Web Sites</h2>
                        <p>
                            Our Service may contain links to third-party web sites or services that are not owned or controlled
                            by [Your Company Name]. We have no control over, and assume no responsibility for, the content,
                            privacy policies, or practices of any third-party web sites or services.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">7. Termination</h2>
                        <p>
                            We may terminate or suspend your account immediately, without prior notice or liability, for any
                            reason whatsoever, including without limitation if you breach the Terms.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">8. Disclaimer</h2>
                        <p>
                            Your use of the Service is at your sole risk. The Service is provided on an "AS IS" and "AS AVAILABLE"
                            basis. The Service is provided without warranties of any kind, whether express or implied.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">9. Governing Law</h2>
                        <p>
                            These Terms shall be governed and construed in accordance with the laws of [Your Country/State],
                            without regard to its conflict of law provisions.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">10. Contact Us</h2>
                        <p>
                            If you have any questions about these Terms, please contact us at <a href="mailto:legal@yourcompany.com" className="text-blue-600 hover:underline">legal@yourcompany.com</a>.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    );
}