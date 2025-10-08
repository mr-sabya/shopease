// app/components/SideCart.tsx
import { useState } from "react"; // Import useEffect for initial state if needed
import { X } from "lucide-react";
import { Link } from "react-router-dom";
import CartItem, { CartProduct } from '../CartItem/CartItem'; // Import CartItem and its type

// Dummy Cart Data - now used for initial state
const initialDummyCartItems: CartProduct[] = [
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
];

interface SideCartProps {
    isOpen: boolean;
    onClose: () => void;
}

export default function SideCart({ isOpen, onClose }: SideCartProps) {
    // Use state to manage cart items
    const [cartItems, setCartItems] = useState<CartProduct[]>(initialDummyCartItems);

    // Calculate subtotal
    const subtotal = cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);

    // Handler for quantity changes
    const handleQuantityChange = (id: string, newQuantity: number) => {
        setCartItems(prevItems =>
            prevItems.map(item =>
                item.id === id ? { ...item, quantity: newQuantity } : item
            )
        );
    };

    // Handler for removing an item
    const handleRemoveItem = (id: string) => {
        setCartItems(prevItems => prevItems.filter(item => item.id !== id));
    };

    return (
        <>
            {/* Overlay */}
            {isOpen && (
                <div
                    className="fixed inset-0 bg-gray-600/50 bg-opacity-50 z-40"
                    onClick={onClose}
                ></div>
            )}

            {/* Side Tray */}
            <div
                className={`fixed top-0 right-0 h-full w-full sm:w-96 bg-white shadow-xl z-50 transform transition-transform duration-300 ease-in-out
                ${isOpen ? "translate-x-0" : "translate-x-full"}`}
            >
                <div className="flex h-full flex-col">
                    {/* Header */}
                    <div className="flex items-center justify-between p-4 border-b">
                        <h2 className="text-xl font-semibold text-gray-800">Your Cart ({cartItems.length} items)</h2>
                        <button onClick={onClose} className="text-gray-500 hover:text-gray-800">
                            <X className="h-6 w-6" />
                        </button>
                    </div>

                    {/* Cart Items */}
                    <div className="flex-1 overflow-y-auto p-4 space-y-4">
                        {cartItems.length === 0 ? (
                            <p className="text-center text-gray-500 py-8">Your cart is empty.</p>
                        ) : (
                            cartItems.map((item) => (
                                <CartItem
                                    key={item.id}
                                    item={item}
                                    onQuantityChange={handleQuantityChange}
                                    onRemoveItem={handleRemoveItem}
                                />
                            ))
                        )}
                    </div>

                    {/* Footer */}
                    <div className="p-4 border-t bg-gray-50">
                        <div className="flex justify-between items-center mb-4">
                            <span className="text-lg font-semibold text-gray-800">Subtotal:</span>
                            <span className="text-lg font-bold text-blue-600">${subtotal.toFixed(2)}</span>
                        </div>
                        <Link
                            to="/checkout"
                            onClick={onClose}
                            className="w-full bg-blue-600 text-white py-3 px-4 rounded-md text-center font-semibold hover:bg-blue-700 transition-colors block"
                        >
                            Proceed to Checkout
                        </Link>
                        <Link
                            to="/cart"
                            onClick={onClose}
                            className="w-full mt-2 text-blue-600 border border-blue-600 py-3 px-4 rounded-md text-center font-semibold hover:bg-blue-50 transition-colors block"
                        >
                            View Full Cart
                        </Link>
                    </div>
                </div>
            </div>
        </>
    );
}