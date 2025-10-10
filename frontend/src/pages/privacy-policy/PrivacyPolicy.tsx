// app/pages/PrivacyPolicyPage.tsx
import { Shield } from "lucide-react";
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

export default function PrivacyPolicyPage() {
    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Privacy Policy"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Privacy Policy" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <h1 className="text-4xl font-extrabold text-gray-900 mb-4 text-center flex items-center justify-center gap-3">
                        <Shield className="h-9 w-9 text-blue-600" /> Privacy Policy
                    </h1>
                    <p className="text-xl text-gray-700 mb-10 text-center leading-relaxed">
                        Your privacy is important to us. This policy explains how we collect, use, and protect your personal information.
                    </p>

                    <div className="bg-white p-8 rounded-lg shadow-lg text-gray-700 space-y-6">
                        <p><strong>Last Updated:</strong> October 27, 2023</p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">1. Introduction</h2>
                        <p>
                            Welcome to [Your Company Name]'s Privacy Policy. We are committed to protecting your personal information
                            and your right to privacy. If you have any questions or concerns about our policy, or our practices
                            with regard to your personal information, please contact us.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">2. What Information Do We Collect?</h2>
                        <p>
                            We collect personal information that you voluntarily provide to us when you register on the website,
                            express an interest in obtaining information about us or our products and services, when you participate
                            in activities on the website (such as posting messages in our online forums or entering competitions)
                            or otherwise when you contact us.
                        </p>
                        <ul className="list-disc pl-6 space-y-2">
                            <li><strong>Personal Data:</strong> Name, email address, mailing address, phone number, payment information.</li>
                            <li><strong>Usage Data:</strong> Information about how you access and use our website, including IP address, browser type, pages viewed, and access times.</li>
                            <li><strong>Cookies:</strong> We use cookies and similar tracking technologies to track the activity on our Service and hold certain information.</li>
                        </ul>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">3. How Do We Use Your Information?</h2>
                        <p>
                            We use personal information collected via our website for a variety of business purposes described below.
                            We process your personal information for these purposes in reliance on our legitimate business interests,
                            in order to enter into or perform a contract with you, with your consent, and/or for compliance with our legal obligations.
                        </p>
                        <ul className="list-disc pl-6 space-y-2">
                            <li>To facilitate account creation and logon process.</li>
                            <li>To send you marketing and promotional communications.</li>
                            <li>To fulfill and manage your orders.</li>
                            <li>To post testimonials with your consent.</li>
                            <li>To deliver targeted advertising to you.</li>
                            <li>To improve our website and marketing efforts.</li>
                        </ul>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">4. Will Your Information Be Shared With Anyone?</h2>
                        <p>
                            We only share information with your consent, to comply with laws, to provide you with services, to protect
                            your rights, or to fulfill business obligations.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">5. How Long Do We Keep Your Information?</h2>
                        <p>
                            We keep your information for as long as necessary to fulfill the purposes outlined in this privacy policy
                            unless otherwise required by law (such as tax, accounting, or other legal requirements).
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">6. What Are Your Privacy Rights?</h2>
                        <p>
                            In some regions (like the European Economic Area), you have rights that allow you greater access to
                            and control over your personal information. You may review, change, or terminate your account at any time.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">7. Do We Make Updates to This Policy?</h2>
                        <p>
                            We may update this privacy policy from time to time. The updated version will be indicated by an updated
                            "Revised" date and the updated version will be effective as soon as it is accessible.
                        </p>

                        <h2 className="text-2xl font-bold text-gray-800 mt-6 mb-3">8. How Can You Contact Us About This Policy?</h2>
                        <p>
                            If you have questions or comments about this policy, you may email us at <a href="mailto:privacy@yourcompany.com" className="text-blue-600 hover:underline">privacy@yourcompany.com</a> or by post to:
                        </p>
                        <p className="ml-6">
                            [Your Company Name]<br />
                            [Your Company Address]<br />
                            [Your City, Postal Code]<br />
                            [Your Country]
                        </p>
                    </div>
                </div>
            </section>
        </div>
    );
}