// app/pages/CheckoutPage.tsx
import { useState } from "react";
import { Link } from "react-router-dom";
import { CreditCard, Truck, Package } from "lucide-react"; // Icons for sections
import { Breadcrumbs } from "../../components/common/Breadcrumb/Breadcrumb";

// Re-using CartProduct interface
export interface CartProduct {
    id: string;
    name: string;
    image: string;
    price: number;
    quantity: number;
}

// Dummy Cart Data for Checkout (should eventually come from global state)
const initialCheckoutCartProducts: CartProduct[] = [
    {
        id: "1",
        name: "Kalrez® Spectrum™ 6375 long product name test",
        image: "/assets/images/products/product-1.png",
        price: 17.84,
        quantity: 1,
    },
    {
        id: "2",
        name: "Chiffon Bell Sleeves Dress",
        image: "/assets/images/products/product-2.png",
        price: 78.00,
        quantity: 2,
    },
    {
        id: "3",
        name: "Wireless Headphones",
        image: "/assets/images/products/product-3.png",
        price: 99.00,
        quantity: 1,
    },
];

export default function Checkout() {
    // --- UPDATED LINE TO REMOVE 'setCartItems' from destructuring ---
    const [cartItems] = useState<CartProduct[]>(initialCheckoutCartProducts);
    // --- END UPDATE ---

    // Form states
    const [shippingAddress, setShippingAddress] = useState({
        firstName: "",
        lastName: "",
        address1: "",
        address2: "",
        city: "",
        state: "",
        zip: "",
        country: "USA",
    });

    const [paymentMethod, setPaymentMethod] = useState({
        cardHolder: "",
        cardNumber: "",
        expiryMonth: "",
        expiryYear: "",
        cvv: "",
        saveCard: false,
    });

    // Calculate totals
    const subtotal = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
    const shippingCost = 10.00; // Example fixed shipping
    const taxRate = 0.08; // Example 8% tax
    const estimatedTax = subtotal * taxRate;
    const total = subtotal + shippingCost + estimatedTax;

    const handleShippingChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        setShippingAddress(prev => ({ ...prev, [name]: value }));
    };

    const handlePaymentChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value, type } = e.target;

        // Type narrowing: Check if e.target is an HTMLInputElement
        // AND if its type is 'checkbox' to safely access 'checked'
        const isCheckbox = type === "checkbox" && e.target instanceof HTMLInputElement;

        setPaymentMethod(prev => ({
            ...prev,
            [name]: isCheckbox ? (e.target as HTMLInputElement).checked : value,
        }));
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        // Here you would typically send this data to your backend
        console.log("Submitting order:", { shippingAddress, paymentMethod, cartItems, total });
        alert("Order submitted! (Check console for data)");
        // Redirect to an order confirmation page
        // navigate('/order-confirmation');
    };

    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Checkout"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Checkout" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    
                    {cartItems.length === 0 ? (
                        <div className="bg-white p-8 rounded-lg shadow-md text-center">
                            <p className="text-xl text-gray-600 mb-4">Your cart is empty. Please add items before checking out.</p>
                            <Link to="/shop" className="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Continue Shopping
                            </Link>
                        </div>
                    ) : (
                        <form onSubmit={handleSubmit} className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            {/* Left Column: Forms */}
                            <div className="lg:col-span-2 space-y-8">
                                {/* Shipping Address */}
                                <div className="bg-white p-6 rounded-lg shadow-md">
                                    <h2 className="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                        <Truck className="h-5 w-5 text-blue-600" /> Shipping Address
                                    </h2>
                                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label htmlFor="firstName" className="block text-sm font-medium text-gray-700">First Name</label>
                                            <input type="text" id="firstName" name="firstName" value={shippingAddress.firstName} onChange={handleShippingChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div>
                                            <label htmlFor="lastName" className="block text-sm font-medium text-gray-700">Last Name</label>
                                            <input type="text" id="lastName" name="lastName" value={shippingAddress.lastName} onChange={handleShippingChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div className="md:col-span-2">
                                            <label htmlFor="address1" className="block text-sm font-medium text-gray-700">Address Line 1</label>
                                            <input type="text" id="address1" name="address1" value={shippingAddress.address1} onChange={handleShippingChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div className="md:col-span-2">
                                            <label htmlFor="address2" className="block text-sm font-medium text-gray-700">Address Line 2 (Optional)</label>
                                            <input type="text" id="address2" name="address2" value={shippingAddress.address2} onChange={handleShippingChange}
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div>
                                            <label htmlFor="city" className="block text-sm font-medium text-gray-700">City</label>
                                            <input type="text" id="city" name="city" value={shippingAddress.city} onChange={handleShippingChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div>
                                            <label htmlFor="state" className="block text-sm font-medium text-gray-700">State / Province</label>
                                            <input type="text" id="state" name="state" value={shippingAddress.state} onChange={handleShippingChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div>
                                            <label htmlFor="zip" className="block text-sm font-medium text-gray-700">ZIP / Postal Code</label>
                                            <input type="text" id="zip" name="zip" value={shippingAddress.zip} onChange={handleShippingChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div>
                                            <label htmlFor="country" className="block text-sm font-medium text-gray-700">Country</label>
                                            <select id="country" name="country" value={shippingAddress.country} onChange={handleShippingChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                <option value="USA">United States</option>
                                                <option value="CAN">Canada</option>
                                                <option value="GBR">United Kingdom</option>
                                                {/* Add more countries */}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {/* Payment Method */}
                                <div className="bg-white p-6 rounded-lg shadow-md">
                                    <h2 className="text-xl font-semibold text-gray-800 mb-4 flex items-center gap-2">
                                        <CreditCard className="h-5 w-5 text-blue-600" /> Payment Information
                                    </h2>
                                    <div className="space-y-4">
                                        <div>
                                            <label htmlFor="cardHolder" className="block text-sm font-medium text-gray-700">Card Holder Name</label>
                                            <input type="text" id="cardHolder" name="cardHolder" value={paymentMethod.cardHolder} onChange={handlePaymentChange} required
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div>
                                            <label htmlFor="cardNumber" className="block text-sm font-medium text-gray-700">Card Number</label>
                                            <input type="text" id="cardNumber" name="cardNumber" value={paymentMethod.cardNumber} onChange={handlePaymentChange} required
                                                placeholder="XXXX XXXX XXXX XXXX"
                                                className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                        </div>
                                        <div className="grid grid-cols-3 gap-4">
                                            <div>
                                                <label htmlFor="expiryMonth" className="block text-sm font-medium text-gray-700">Expiry Month</label>
                                                <input type="text" id="expiryMonth" name="expiryMonth" value={paymentMethod.expiryMonth} onChange={handlePaymentChange} required
                                                    placeholder="MM" maxLength={2}
                                                    className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                            </div>
                                            <div>
                                                <label htmlFor="expiryYear" className="block text-sm font-medium text-gray-700">Expiry Year</label>
                                                <input type="text" id="expiryYear" name="expiryYear" value={paymentMethod.expiryYear} onChange={handlePaymentChange} required
                                                    placeholder="YYYY" maxLength={4}
                                                    className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                            </div>
                                            <div>
                                                <label htmlFor="cvv" className="block text-sm font-medium text-gray-700">CVV</label>
                                                <input type="text" id="cvv" name="cvv" value={paymentMethod.cvv} onChange={handlePaymentChange} required
                                                    placeholder="123" maxLength={4}
                                                    className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                            </div>
                                        </div>
                                        <div className="flex items-center">
                                            <input id="saveCard" name="saveCard" type="checkbox" checked={paymentMethod.saveCard} onChange={handlePaymentChange}
                                                className="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                                            <label htmlFor="saveCard" className="ml-2 block text-sm text-gray-900">Save card for future purchases</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Right Column: Order Summary */}
                            <div className="lg:col-span-1 bg-white rounded-lg shadow-md p-6 h-fit sticky top-8"> {/* sticky for fixed position on scroll */}
                                <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                                    <Package className="h-6 w-6 text-gray-600" /> Order Summary
                                </h2>

                                <div className="space-y-4 mb-6">
                                    {cartItems.map((item) => (
                                        <div key={item.id} className="flex items-center gap-4 border-b pb-3 last:border-b-0">
                                            <img src={item.image} alt={item.name} className="h-16 w-16 object-cover rounded-md flex-shrink-0" />
                                            <div className="flex-grow">
                                                <p className="text-sm font-medium text-gray-800 line-clamp-2">{item.name}</p>
                                                <p className="text-xs text-gray-500">Qty: {item.quantity}</p>
                                            </div>
                                            <p className="text-sm font-semibold text-gray-800">${(item.price * item.quantity).toFixed(2)}</p>
                                        </div>
                                    ))}
                                </div>

                                <div className="space-y-2 text-gray-700 border-t pt-4">
                                    <div className="flex justify-between">
                                        <span>Subtotal:</span>
                                        <span>${subtotal.toFixed(2)}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span>Shipping:</span>
                                        <span>${shippingCost.toFixed(2)}</span>
                                    </div>
                                    <div className="flex justify-between">
                                        <span>Estimated Tax ({taxRate * 100}%):</span>
                                        <span>${estimatedTax.toFixed(2)}</span>
                                    </div>
                                    <div className="flex justify-between pt-4 border-t border-gray-200 text-xl font-bold text-gray-800">
                                        <span>Order Total:</span>
                                        <span>${total.toFixed(2)}</span>
                                    </div>
                                </div>

                                <button
                                    type="submit"
                                    className="w-full bg-blue-600 text-white py-3 px-4 mt-6 rounded-md text-center font-semibold hover:bg-blue-700 transition-colors block"
                                >
                                    Place Order
                                </button>
                            </div>
                        </form>
                    )}
                </div>
            </section>
        </div>
    );
}