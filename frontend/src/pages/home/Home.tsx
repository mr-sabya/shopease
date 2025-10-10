import Banner from '../../components/home/Banner/Banners'
import TopCategories from '../../components/home/TopCategories/TopCategories'
import TopProducts from '../../components/home/TopProducts/TopProducts'
import BestDeals from '../../components/home/BestDeals/BestDeals'
import { MegaCollections } from '../../components/home/MegaCollections/MegaCollections'
import LongAdBanner from '../../components/home/LongAdBanner/LongAdBanner'
import RecentlyViewed from '../../components/home/RecentlyViewed/RecentlyViewed'
import DeliveryPoster from '../../components/home/DeliveryPoster/DeliveryPoster'
import usePageMetadata from '../../hooks/usePageMetadata'

export default function Home() {
    usePageMetadata({
        title: 'Home Page | My Awesome App',
        description: 'This is the main entry point of our application, offering a variety of products and services.',
        keywords: 'home, app, products, services, main page',
        ogTitle: 'Welcome to My Awesome App!',
        ogDescription: 'Explore the best products and services on our homepage.',
        ogImage: 'https://example.com/assets/images/home-hero.jpg',
        ogUrl: 'https://example.com/',
        canonicalUrl: 'https://example.com/',
    });

    return (
        <div className=''>
            <Banner />
            <TopCategories />
            <TopProducts />
            <BestDeals />
            <MegaCollections />
            <LongAdBanner />
            <RecentlyViewed />
            <DeliveryPoster />
        </div>
    )
}
