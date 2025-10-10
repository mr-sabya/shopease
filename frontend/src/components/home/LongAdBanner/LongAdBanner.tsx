import { Link } from 'react-router'

export default function LongAdBanner() {
    return (
        <section className="bg-gray-50 py-10 px-4 md:px-10" style={{paddingBottom: 0}}>
            <div className="container mx-auto px-4 md:px-8">
                <Link to={"/"}>
                    <img className='w-full rounded-2xl' src="/assets/images/ad/sale_banner.png" alt="" />
                </Link>
            </div>
        </section>
    )
}
