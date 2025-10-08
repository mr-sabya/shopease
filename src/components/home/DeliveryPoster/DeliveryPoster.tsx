
import DeliveryOptionCard from '../../common/DeliveryOptionCard/DeliveryOptionCard'

export default function DeliveryPoster() {
    return (
        <section className="bg-gray-50 py-10 px-4 md:px-10" style={{ paddingTop: 0 }}>
            <div className="container mx-auto px-4 md:px-8">
                <div className="grid md:grid-cols-3 gap-6 w-full">
                    <DeliveryOptionCard
                        type="pickup"
                        title="Order Pickup"
                        description="Choose Order Pickup & we'll have it waiting for you inside the store."
                        badgeText="ALWAYS FREE"
                        imageSrc="/assets/images/delivery_1.png" // Make sure this path is correct or use a direct URL
                        imageAlt="Delivery man holding boxes"
                    />
                    <DeliveryOptionCard
                        type="same-day"
                        title="Same Day Delivery"
                        description="We will delivery your goods on the same day on your doorstep."
                        badgeText="FAST DELIVERY"
                        imageSrc="/assets/images/delivery_2.png" // Make sure this path is correct or use a direct URL
                        imageAlt="Delivery man carrying a single box"
                    />
                    <DeliveryOptionCard
                        type="pickup"
                        title="Same Day Delivery"
                        description="We will delivery your goods on the same day on your doorstep."
                        badgeText="FAST DELIVERY"
                        imageSrc="/assets/images/delivery_2.png" // Make sure this path is correct or use a direct URL
                        imageAlt="Delivery man carrying a single box"
                    />
                </div>
            </div>
        </section>
    )
}
