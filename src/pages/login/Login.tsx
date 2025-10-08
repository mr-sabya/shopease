// app/routes/signin/index.tsx
import { Lock, Mail } from "lucide-react"; // Assuming lucide-react for icons
import { Link } from "react-router";
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";



export default function Login() {
    // In a real Remix app, you'd handle form submission with useFetcher or useActionData
    // For this design, we're focusing on the UI.
    const handleSubmit = (event: React.FormEvent<HTMLFormElement>) => {
        event.preventDefault();
        alert("Sign In form submitted (UI only). Implement actual logic with Remix loader/action!");
        // Here you would typically send data to a Remix action
    };

    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Sign In"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Sign In" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <div className="flex items-center justify-center min-h-screen bg-gray-100 p-4 sm:p-6">
                <div className="w-full max-w-md bg-white rounded-lg shadow-xl p-6 sm:p-8 md:p-10 border border-gray-200">
                    <div className="text-center mb-8">
                        <h1 className="text-4xl font-extrabold text-gray-900 mb-2">Welcome Back!</h1>
                        <p className="text-gray-600 text-lg">Sign in to continue</p>
                    </div>

                    <form onSubmit={handleSubmit} className="space-y-6">
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
                                    autoComplete="current-password"
                                    required
                                    className="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Password"
                                />
                            </div>
                        </div>

                        {/* Remember Me & Forgot Password */}
                        <div className="flex items-center justify-between">
                            <div className="flex items-center">
                                <input
                                    id="remember-me"
                                    name="remember-me"
                                    type="checkbox"
                                    className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                />
                                <label htmlFor="remember-me" className="ml-2 block text-sm text-gray-900">
                                    Remember me
                                </label>
                            </div>

                            <div className="text-sm">
                                <Link to="/forgot-password" className="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                                    Forgot your password?
                                </Link>
                            </div>
                        </div>

                        {/* Sign In Button */}
                        <div>
                            <button
                                type="submit"
                                className="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200"
                            >
                                Sign In
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

                    {/* Social Sign-in Buttons (Placeholders) */}
                    <div className="mt-6 space-y-3">
                        <button
                            type="button"
                            className="w-full flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                        >
                            <img src="/assets/icons/google.svg" alt="Google" className="h-5 w-5 mr-2" /> {/* You'll need this icon */}
                            Sign in with Google
                        </button>
                        <button
                            type="button"
                            className="w-full flex items-center justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                        >
                            <img src="/assets/icons/github.svg" alt="Github" className="h-5 w-5 mr-2" /> {/* You'll need this icon */}
                            Sign in with GitHub
                        </button>
                    </div>

                    {/* Sign Up Link */}
                    <p className="mt-8 text-center text-sm text-gray-600">
                        Don't have an account?{' '}
                        <Link to="/register" className="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                            Sign up here
                        </Link>
                    </p>
                </div>
            </div>
        </div>
    );
}