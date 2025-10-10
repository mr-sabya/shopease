// app/components/common/PageHeaderWithBreadcrumbs.tsx
import { Link } from "react-router";

// Define a type for a single breadcrumb item
interface BreadcrumbItem {
    label: string;
    link?: string; // Link is optional; if not provided, it's the current page
}

interface PageHeaderWithBreadcrumbsProps {
    title: string;
    breadcrumbs: BreadcrumbItem[];
    backgroundColor?: string; // Tailwind class for background, e.g., "bg-blue-50"
    titleClassName?: string; // Optional classes for the title
    containerClassName?: string; // Optional classes for the outer container
}

export function Breadcrumbs({
    title,
    breadcrumbs,
    backgroundColor = "bg-white", // Default to white background
    titleClassName = "text-4xl font-extrabold text-gray-900",
    containerClassName = "py-8 md:py-12", // Default padding
}: PageHeaderWithBreadcrumbsProps) {
    return (
        <div className={`${backgroundColor} ${containerClassName} text-center`}> {/* Centered content */}
            <div className="container mx-auto px-4 md:px-8">
                <h1 className={`${titleClassName} mb-2`}>{title}</h1>
                <nav className="text-sm font-medium text-gray-500 flex justify-center" aria-label="Breadcrumb"> {/* Center breadcrumbs */}
                    <ol className="list-none p-0 inline-flex items-center space-x-2"> {/* space-x for gap */}
                        {breadcrumbs.map((item, index) => (
                            <li key={item.label + index} className="flex items-center">
                                {item.link ? (
                                    <Link to={item.link} className="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                        {item.label}
                                    </Link>
                                ) : (
                                    <span className="text-gray-700">{item.label}</span>
                                )}
                                {index < breadcrumbs.length - 1 && ( // Add separator only between items
                                    <svg className="fill-current w-3 h-3 mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                        <path d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" />
                                    </svg>
                                )}
                            </li>
                        ))}
                    </ol>
                </nav>
            </div>
        </div>
    );
}