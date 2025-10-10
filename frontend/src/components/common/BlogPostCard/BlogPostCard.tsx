// app/components/common/BlogPostCard.tsx
import { Link } from "react-router";
import { CalendarDays, Tag } from "lucide-react"; // Assuming you have lucide-react

interface BlogPostCardProps {
    post: {
        slug: string; // Unique identifier for the post
        title: string;
        imageUrl: string;
        category: string;
        date: string; // e.g., "2023-10-27"
        excerpt: string;
        tags?: string[]; // Optional tags
    };
}

export function BlogPostCard({ post }: BlogPostCardProps) {
    // Format date for display
    const formattedDate = new Date(post.date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    return (
        <article className="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out overflow-hidden flex flex-col">
            <Link to={`/blog/${post.slug}`} className="block relative h-48 sm:h-56 overflow-hidden">
                <img
                    src={post.imageUrl}
                    alt={post.title}
                    className="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                />
                <span className="absolute bottom-2 left-2 bg-blue-600 text-white text-xs font-semibold px-2 py-1 rounded-full">
                    {post.category}
                </span>
            </Link>
            <div className="p-5 flex-grow flex flex-col">
                <Link to={`/blog/${post.slug}`} className="block">
                    <h3 className="text-xl font-bold text-gray-900 hover:text-blue-700 transition-colors duration-200 mb-2 line-clamp-2">
                        {post.title}
                    </h3>
                </Link>
                <div className="flex items-center text-gray-500 text-sm mb-3">
                    <CalendarDays className="w-4 h-4 mr-1" />
                    <span>{formattedDate}</span>
                </div>
                <p className="text-gray-700 text-sm mb-4 flex-grow line-clamp-3">
                    {post.excerpt}
                </p>
                {post.tags && post.tags.length > 0 && (
                    <div className="flex flex-wrap gap-2 mt-auto"> {/* mt-auto pushes tags to bottom */}
                        {post.tags.map(tag => (
                            <Link key={tag} to={`/blog?tag=${tag.toLowerCase()}`} className="text-xs text-blue-600 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded-full flex items-center transition-colors">
                                <Tag className="w-3 h-3 mr-1" /> {tag}
                            </Link>
                        ))}
                    </div>
                )}
                <Link
                    to={`/blog/${post.slug}`}
                    className="mt-4 inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition-colors"
                >
                    Read More
                    <svg className="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </Link>
            </div>
        </article>
    );
}