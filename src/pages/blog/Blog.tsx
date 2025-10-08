import { CalendarDays, Tag } from "lucide-react";
import { Link } from "react-router";
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";
import { BlogPostCard } from "../../components/common/BlogPostCard/BlogPostCard";


// Dummy Blog Post Data (In a real app, this would come from a Remix loader or CMS)
const blogPosts = [
    {
        slug: "mastering-your-morning-routine",
        title: "Mastering Your Morning Routine for Peak Productivity",
        imageUrl: "/assets/images/blog/blog-01.png",
        category: "Productivity",
        date: "2023-10-27",
        excerpt: "Discover the secrets to a highly effective morning routine that can boost your energy, focus, and overall productivity throughout the day. Small changes can make a big difference.",
        tags: ["Morning", "Habits", "Wellness"]
    },
    {
        slug: "the-future-of-ai-in-e-commerce",
        title: "The Future of AI in E-commerce: Personalization & Beyond",
        imageUrl: "/assets/images/blog/blog-02.png",
        category: "Technology",
        date: "2023-10-25",
        excerpt: "Artificial Intelligence is revolutionizing the e-commerce landscape, offering unparalleled personalization, predictive analytics, and operational efficiencies. Explore how AI is shaping the future of online shopping.",
        tags: ["AI", "E-commerce", "Innovation"]
    },
    {
        slug: "healthy-eating-on-a-budget",
        title: "Healthy Eating on a Budget: Delicious & Affordable Meals",
        imageUrl: "/assets/images/blog/blog-03.png",
        category: "Nutrition",
        date: "2023-10-22",
        excerpt: "Eating healthy doesn't have to break the bank. Learn practical tips and discover delicious, budget-friendly recipes that will keep you and your wallet happy without compromising on taste or nutrition.",
        tags: ["Food", "Budget", "Health"]
    },
    {
        slug: "ultimate-guide-to-traveling-solo",
        title: "The Ultimate Guide to Traveling Solo: Tips & Destinations",
        imageUrl: "/assets/images/blog/blog-04.png",
        category: "Travel",
        date: "2023-10-18",
        excerpt: "Embarking on a solo adventure can be incredibly empowering. This comprehensive guide covers everything from safety tips and packing essentials to choosing the best destinations for solo travelers.",
        tags: ["Adventure", "Travel", "Destinations"]
    },
    {
        slug: "sustainable-living-at-home",
        title: "Sustainable Living: Simple Steps to an Eco-Friendly Home",
        imageUrl: "/assets/images/blog/blog-05.png",
        category: "Lifestyle",
        date: "2023-10-15",
        excerpt: "Make a positive impact on the planet from the comfort of your home. This article provides easy-to-implement tips for sustainable living, reducing waste, and conserving energy.",
        tags: ["Eco-friendly", "Home", "Environment"]
    },
    {
        slug: "intro-to-remix-js-development",
        title: "An Introduction to Remix.js for Modern Web Development",
        imageUrl: "/assets/images/blog/blog-06.png",
        category: "Development",
        date: "2023-10-10",
        excerpt: "Dive into the world of Remix.js and understand why this full-stack web framework is gaining traction among developers. Learn about its key features and how it simplifies web development.",
        tags: ["Remix", "Web Dev", "JavaScript"]
    },
];

// Helper to get unique categories and tags for the sidebar (static for now)
const getUnique = (arr: any[], key: string) => {
    const values = arr.map(item => item[key]).flat().filter(Boolean) as string[];
    return Array.from(new Set(values.sort()));
};

const blogCategories = getUnique(blogPosts, "category");
const blogTags = getUnique(blogPosts, "tags");


export default function Blog() {
    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Our Blog"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Blog" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    {/* Page Header */}


                    <div className="flex flex-col lg:flex-row gap-8">

                        {/* Main Blog Post Grid */}
                        <main className="w-full lg:w-3/4">
                            {/* Latest Posts Heading */}


                            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                                {blogPosts.map((post) => (
                                    <BlogPostCard key={post.slug} post={post} />
                                ))}
                            </div>

                            {/* Pagination (Placeholder - similar to shop page) */}
                            <div className="mt-12 flex justify-center">
                                <nav className="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                    <a href="#" className="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span className="sr-only">Previous</span>
                                        <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fillRule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clipRule="evenodd" />
                                        </svg>
                                    </a>
                                    <a href="#" aria-current="page" className="z-10 bg-blue-50 border-blue-600 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
                                    <a href="#" className="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">2</a>
                                    <a href="#" className="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">3</a>
                                    <a href="#" className="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span className="sr-only">Next</span>
                                        <svg className="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fillRule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clipRule="evenodd" />
                                        </svg>
                                    </a>
                                </nav>
                            </div>
                        </main>

                        {/* Sidebar: Professionally Designed */}
                        <aside className="w-full lg:w-1/4 p-6 bg-white rounded-lg shadow-md self-start sticky top-4 space-y-8">
                            {/* Search Bar */}
                            <div className="pb-4 border-b border-gray-200">
                                <h4 className="text-lg font-semibold text-gray-800 mb-3">Search Blog</h4>
                                <div className="relative">
                                    <input
                                        type="text"
                                        placeholder="Search articles..."
                                        className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    />
                                    <svg className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </div>
                            </div>

                            {/* Categories Section */}
                            <div className="pb-4 border-b border-gray-200">
                                <h4 className="text-lg font-semibold text-gray-800 mb-4">Categories</h4>
                                <ul className="space-y-2">
                                    {blogCategories.map(category => (
                                        <li key={category}>
                                            <Link
                                                to={`/blog?category=${category.toLowerCase()}`}
                                                className="group flex justify-between items-center text-gray-700 hover:text-blue-600 transition-colors duration-200 text-base"
                                            >
                                                <span className="group-hover:translate-x-1 transition-transform duration-200">{category}</span>
                                                {/* Optional: Add a count of posts in this category if you have that data */}
                                                {/* <span className="text-xs font-medium text-gray-500 group-hover:text-blue-500">(12)</span> */}
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            </div>

                            {/* Popular Tags Section */}
                            <div className="pb-4 border-b border-gray-200">
                                <h4 className="text-lg font-semibold text-gray-800 mb-4">Popular Tags</h4>
                                <div className="flex flex-wrap gap-2">
                                    {blogTags.map(tag => (
                                        <Link
                                            key={tag}
                                            to={`/blog?tag=${tag.toLowerCase()}`}
                                            className="inline-flex items-center px-3 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-full hover:bg-blue-100 hover:text-blue-800 transition-colors duration-200"
                                        >
                                            <Tag className="w-3 h-3 mr-1" />
                                            {tag}
                                        </Link>
                                    ))}
                                </div>
                            </div>

                            {/* Recent Posts Section */}
                            <div>
                                <h4 className="text-lg font-semibold text-gray-800 mb-4">Recent Posts</h4>
                                <ul className="space-y-4">
                                    {blogPosts.slice(0, 3).map(post => (
                                        <li key={post.slug}>
                                            <Link to={`/blog/${post.slug}`} className="block group">
                                                <p className="font-medium text-gray-800 group-hover:text-blue-600 transition-colors duration-200 line-clamp-2">
                                                    {post.title}
                                                </p>
                                                <span className="text-gray-500 text-sm flex items-center mt-1">
                                                    <CalendarDays className="w-4 h-4 mr-1" />
                                                    {new Date(post.date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                                                </span>
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </aside>
                    </div>

                </div>
            </section>
        </div>
    );
}