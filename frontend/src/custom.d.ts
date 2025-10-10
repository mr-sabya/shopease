// src/custom.d.ts (expanded for very specific cases)

// Generic CSS module declaration (keep this one)
declare module '*.css' {
    const content: string;
    export default content;
}

// Specific Swiper CSS module declarations (try adding these if generic fails)
// These explicitly declare that these specific paths are valid modules.
declare module 'swiper/css';
declare module 'swiper/css/navigation';
declare module 'swiper/css/pagination';
declare module 'swiper/css/scrollbar';
declare module "swiper/css/autoplay";
// Add other specific Swiper CSS paths you use, e.g., 'swiper/css/effect-fade'