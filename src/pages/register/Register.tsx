// app/routes/signup/index.tsx

import { User, Mail, Lock } from "lucide-react"; // Assuming lucide-react for icons
import { Link } from "react-router";


export default function Register() {
    // In a real Remix app, you'd handle form submission with useFetcher or useActionData
    // For this design, we're focusing on the UI.
    const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        alert("Sign Up form submitted (UI only). Implement actual logic with Remix loader/action!");
        // Here you would typically send data to a Remix action
    };

    return (
        <div className="flex items-center justify-center min-h-screen bg-gray-100 p-4 sm:p-6">
            <div className="w-full max-w-md bg-white rounded-lg shadow-xl p-6 sm:p-8 md:p-10 border border-gray-200">
                <div className="text-center mb-8">
                    <h1 className="text-4xl font-extrabold text-gray-900 mb-2">Create Account</h1>
                    <p className="text-gray-600 text-lg">Join us today!</p>
                </div>

                <form onSubmit={handleSubmit} className="space-y-6">
                    {/* Full Name Input */}
                    <div>
                        <label htmlFor="full-name" className="block text-sm font-medium text-gray-700 sr-only">Full Name</label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <User className="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <input
                                id="full-name"
                                name="fullName"
                                type="text"
                                autoComplete="name"
                                required
                                className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Full Name"
                            />
                        </div>
                    </div>

                    {/* Email Input */}
                    <div>
                        <label htmlFor="email" className="block text-sm font-medium text-gray-700 sr-only">Email address</label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Mail className="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                autoComplete="email"
                                required
                                className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Email address"
                            />
                        </div>
                    </div>

                    {/* Password Input */}
                    <div>
                        <label htmlFor="password" className="block text-sm font-medium text-gray-700 sr-only">Password</label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Lock className="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                autoComplete="new-password"
                                required
                                className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Password"
                            />
                        </div>
                    </div>

                    {/* Confirm Password Input */}
                    <div>
                        <label htmlFor="confirm-password" className="block text-sm font-medium text-gray-700 sr-only">Confirm Password</label>
                        <div className="relative">
                            <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <Lock className="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </div>
                            <input
                                id="confirm-password"
                                name="confirmPassword"
                                type="password"
                                autoComplete="new-password"
                                required
                                className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Confirm Password"
                            />
                        </div>
                    </div>

                    {/* Terms & Privacy Checkbox */}
                    <div className="flex items-center">
                        <input
                            id="terms-privacy"
                            name="termsPrivacy"
                            type="checkbox"
                            required
                            className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        />
                        <label htmlFor="terms-privacy" className="ml-2 block text-sm text-gray-900">
                            I agree to the{' '}
                            <Link to="/terms" className="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                                Terms of Service
                            </Link>{' '}
                            and{' '}
                            <Link to="/privacy" className="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                                Privacy Policy
                            </Link>
                        </label>
                    </div>

                    {/* Sign Up Button */}
                    <div>
                        <button
                            type="submit"
                            className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                        >
                            Sign Up
                        </button>
                    </div>
                </form>

                {/* Or divider (Optional, but common) */}
                <div className="relative mt-6 mb-6">
                    <div className="absolute inset-0 flex items-center" aria-hidden="true">
                        <div className="w-full border-t border-gray-300"></div>
                    </div>
                    <div className="relative flex justify-center text-sm">
                        <span className="px-2 bg-white text-gray-500">
                            Or continue with
                        </span>
                    </div>
                </div>

                {/* Social Sign-up Buttons (Placeholders) */}
                <div className="mt-6 space-y-3">
                    <button
                        type="button"
                        className="w-full flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                    >
                        <img src="/assets/icons/google.svg" alt="Google" className="h-5 w-5 mr-2" />
                        Sign up with Google
                    </button>
                    <button
                        type="button"
                        className="w-full flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                    >
                        <img src="/assets/icons/github.svg" alt="Github" className="h-5 w-5 mr-2" />
                        Sign up with GitHub
                    </button>
                </div>

                {/* Sign In Link */}
                <p className="mt-8 text-center text-sm text-gray-600">
                    Already have an account?{' '}
                    <Link to="/login" className="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                        Sign in
                    </Link>
                </p>
            </div>
        </div>
    );
}