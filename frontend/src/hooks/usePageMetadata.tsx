import { useEffect } from 'react';

// Define the interface for the metadata props
interface PageMetadataProps {
    title: string;
    description?: string;
    keywords?: string; // Optional: for SEO keywords
    ogTitle?: string;
    ogDescription?: string;
    ogImage?: string;
    ogUrl?: string;
    ogType?: string;
    twitterCard?: string;
    twitterTitle?: string;
    twitterDescription?: string;
    twitterImage?: string;
    canonicalUrl?: string; // Optional: for canonical links
}

/**
 * A custom hook to dynamically update the document's head (title, meta tags).
 * This is primarily for client-side rendering (CSR) applications.
 * For Server-Side Rendering (SSR) frameworks (Next.js, Remix),
 * use their built-in solutions (e.g., next/head, Remix meta function) or react-helmet.
 *
 * @param {PageMetadataProps} metadata - An object containing the metadata for the page.
 */
const usePageMetadata = (metadata: PageMetadataProps) => {
    const {
        title,
        description,
        keywords,
        ogTitle,
        ogDescription,
        ogImage,
        ogUrl,
        ogType = 'website', // Default to 'website'
        twitterCard = 'summary_large_image', // Default Twitter card type
        twitterTitle,
        twitterDescription,
        twitterImage,
        canonicalUrl,
    } = metadata;

    useEffect(() => {
        // 1. Update Document Title
        document.title = title;

        // Helper function to create or update a meta tag
        const setMetaTag = (selector: string, attribute: string, content: string | undefined | null) => {
            let tag = document.querySelector(selector) as HTMLMetaElement | null;
            if (content) {
                if (!tag) {
                    tag = document.createElement('meta');
                    tag.setAttribute(attribute, selector.includes('property=') ? 'property' : 'name'); // Determine if 'name' or 'property'
                    document.head.appendChild(tag);
                }
                tag.setAttribute('content', content);
            } else if (tag) {
                // Remove tag if content is explicitly undefined/null and tag exists
                tag.remove();
            }
        };

        // 2. Update Meta Description
        setMetaTag('meta[name="description"]', 'name', description);

        // 3. Update Meta Keywords (if provided)
        setMetaTag('meta[name="keywords"]', 'name', keywords);

        // 4. Update Canonical URL (if provided)
        if (canonicalUrl) {
            let canonicalLink = document.querySelector('link[rel="canonical"]') as HTMLLinkElement | null;
            if (!canonicalLink) {
                canonicalLink = document.createElement('link');
                canonicalLink.setAttribute('rel', 'canonical');
                document.head.appendChild(canonicalLink);
            }
            canonicalLink.setAttribute('href', canonicalUrl);
        } else {
            // Remove if no canonicalUrl is provided and it exists
            document.querySelector('link[rel="canonical"]')?.remove();
        }


        // 5. Update Open Graph Meta Tags (for social media sharing)
        setMetaTag('meta[property="og:title"]', 'property', ogTitle || title);
        setMetaTag('meta[property="og:description"]', 'property', ogDescription || description);
        setMetaTag('meta[property="og:image"]', 'property', ogImage);
        setMetaTag('meta[property="og:url"]', 'property', ogUrl || window.location.href);
        setMetaTag('meta[property="og:type"]', 'property', ogType);

        // 6. Update Twitter Card Meta Tags
        setMetaTag('meta[name="twitter:card"]', 'name', twitterCard);
        setMetaTag('meta[name="twitter:title"]', 'name', twitterTitle || ogTitle || title);
        setMetaTag('meta[name="twitter:description"]', 'name', twitterDescription || ogDescription || description);
        setMetaTag('meta[name="twitter:image"]', 'name', twitterImage || ogImage);

        // Note: No cleanup return needed here for most cases, as subsequent calls
        // to the hook will simply overwrite the meta tags. If you need to revert
        // to default index.html values, you'd need more complex logic.

    }, [
        title,
        description,
        keywords,
        ogTitle,
        ogDescription,
        ogImage,
        ogUrl,
        ogType,
        twitterCard,
        twitterTitle,
        twitterDescription,
        twitterImage,
        canonicalUrl
    ]);
};

export default usePageMetadata;