// app/pages/CartPage.tsx
import { useState } from "react";
import { Link } from "react-router-dom";
import { Plus, Minus, Trash2 } from "lucide-react";

export interface CartProduct {
    id: string;
    name: string;
    image: string;
    price: number;
    quantity: number;
}

const initialCartProducts: CartProduct[] = [
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
    {
        id: "4",
        name: "Smart Watch Pro X",
        image: "/assets/images/products/product-4.png",
        price: 199.00,
        quantity: 1,
    },
    {
        id: "5",
        name: "Ergonomic Office Chair",
        image: "/assets/images/products/product-5.png",
        price: 249.99,
        quantity: 1,
    },
];


export default function Cart() {
    const [cartItems, setCartItems] = useState<CartProduct[]>(initialCartProducts);

    const handleQuantityChange = (id: string, newQuantity: number) => {
        setCartItems(prevItems =>
            prevItems.map(item =>
                item.id === id ? { ...item, quantity: newQuantity } : item
            )
        );
    };

    const handleRemoveItem = (id: string) => {
        setCartItems(prevItems => prevItems.filter(item => item.id !== id));
    };

    const subtotal = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
    const shippingCost = 10.00;
    const taxRate = 0.08;
    const estimatedTax = subtotal * taxRate;
    const total = subtotal + shippingCost + estimatedTax;


    return (
        <section className="bg-gray-50 py-8">
            <div className="container mx-auto px-4 md:px-8">
                <h1 className="text-3xl font-bold text-gray-800 mb-6">Shopping Cart</h1>

                {cartItems.length === 0 ? (
                    <div className="bg-white p-8 rounded-lg shadow-md text-center">
                        <p className="text-xl text-gray-600 mb-4">Your cart is currently empty.</p>
                        <Link to="/shop" className="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Continue Shopping
                        </Link>
                    </div>
                ) : (
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Cart Items List */}
                        <div className="lg:col-span-2 bg-white rounded-lg shadow-md p-6">
                            {/* Column Headers */}
                            {/* Using explicit grid-cols-6 for md and up. Adjust if needed. */}
                            <div className="hidden md:grid md:grid-cols-6 gap-4 border-b pb-4 mb-4 font-semibold text-gray-600 text-sm items-center">
                                <div className="col-span-2">Product</div> {/* Takes 2 of 6 parts */}
                                <div className="text-left">Price</div>
                                <div className="text-center">Quantity</div>
                                <div className="text-right">Total</div>
                                <div className="col-span-1"></div> {/* Empty for alignment/remove icon */}
                            </div>

                            {cartItems.map((item) => (
                                // Using explicit grid-cols-6 for md and up for item rows
                                <div key={item.id} className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-6 gap-4 items-center border-b py-4 last:border-b-0">
                                    {/* Product Info */}
                                    <div className="col-span-1 sm:col-span-2 md:col-span-2 flex items-center gap-4">
                                        <Link to={`/product/${item.id}`} className="flex-shrink-0">
                                            <img
                                                src={item.image}
                                                alt={item.name}
                                                className="h-20 w-20 object-cover rounded-md"
                                            />
                                        </Link>
                                        <div className="flex flex-col flex-grow">
                                            <Link to={`/product/${item.id}`} className="text-base font-medium text-gray-800 hover:text-blue-600 line-clamp-2">
                                                {item.name}
                                            </Link>
                                        </div>
                                        {/* On small screens, place remove button next to product name */}
                                        <div className="sm:hidden ml-auto">
                                            <button
                                                onClick={() => handleRemoveItem(item.id)}
                                                className="text-gray-400 hover:text-red-500 transition-colors p-2"
                                                aria-label={`Remove ${item.name}`}
                                            >
                                                <Trash2 className="h-5 w-5" />
                                            </button>
                                        </div>
                                    </div>

                                    {/* Price */}
                                    <div className="text-gray-800 font-medium md:text-left text-sm sm:text-base">
                                        <span className="md:hidden font-semibold text-gray-600 mr-2">Price:</span>${item.price.toFixed(2)}
                                    </div>

                                    {/* Quantity Controls */}
                                    <div className="flex items-center justify-center md:justify-start">
                                        <div className="md:hidden font-semibold text-gray-600 mr-2">Quantity:</div>
                                        <div className="flex items-center border border-gray-300 rounded-md">
                                            <button
                                                onClick={() => handleQuantityChange(item.id, item.quantity - 1)}
                                                disabled={item.quantity <= 1}
                                                className="p-2 text-gray-600 hover:bg-gray-100 rounded-l-md disabled:opacity-50 disabled:cursor-not-allowed"
                                                aria-label="Decrease quantity"
                                            >
                                                <Minus className="h-4 w-4" />
                                            </button>
                                            <span className="px-3 text-base font-medium text-gray-800">
                                                {item.quantity}
                                            </span>
                                            <button
                                                onClick={() => handleQuantityChange(item.id, item.quantity + 1)}
                                                className="p-2 text-gray-600 hover:bg-gray-100 rounded-r-md"
                                                aria-label="Increase quantity"
                                            >
                                                <Plus className="h-4 w-4" />
                                            </button>
                                        </div>
                                    </div>

                                    {/* Total for item */}
                                    <div className="text-right text-gray-800 font-semibold text-sm sm:text-base">
                                        <span className="md:hidden font-semibold text-gray-600 mr-2">Total:</span>${(item.price * item.quantity).toFixed(2)}
                                    </div>

                                    {/* Remove Button for md and larger screens */}
                                    <div className="hidden md:block text-center">
                                        <button
                                            onClick={() => handleRemoveItem(item.id)}
                                            className="text-gray-400 hover:text-red-500 transition-colors p-2"
                                            aria-label={`Remove ${item.name}`}
                                        >
                                            <Trash2 className="h-5 w-5" />
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>

                        {/* Cart Summary / Order Totals (Same as before) */}
                        <div className="lg:col-span-1 bg-white rounded-lg shadow-md p-6">
                            <h2 className="text-2xl font-bold text-gray-800 mb-4">Order Summary</h2>

                            <div className="space-y-2 text-gray-700">
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

                            <Link
                                to="/checkout"
                                className="w-full bg-blue-600 text-white py-3 px-4 mt-6 rounded-md text-center font-semibold hover:bg-blue-700 transition-colors block"
                            >
                                Proceed to Checkout
                            </Link>
                            <Link
                                to="/shop"
                                className="w-full mt-3 text-blue-600 border border-blue-600 py-3 px-4 rounded-md text-center font-semibold hover:bg-blue-50 transition-colors block"
                            >
                                Continue Shopping
                            </Link>
                        </div>
                    </div>
                )}
            </div>
        </section>
    );
}