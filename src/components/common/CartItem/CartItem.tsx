// app/components/CartItem.tsx
import { Link } from "react-router-dom"; // Or "react-router"
import { Plus, Minus, Trash2 } from "lucide-react"; // Importing Trash2 for remove button

// Assuming CartProduct interface is defined in SideCart or a shared types file
export interface CartProduct {
    id: string;
    name: string;
    image: string;
    price: number;
    quantity: number;
}

interface CartItemProps {
    item: CartProduct;
    onQuantityChange: (id: string, newQuantity: number) => void;
    onRemoveItem: (id: string) => void;
}

export default function CartItem({ item, onQuantityChange, onRemoveItem }: CartItemProps) {
    const handleIncrement = () => {
        onQuantityChange(item.id, item.quantity + 1);
    };

    const handleDecrement = () => {
        if (item.quantity > 1) { // Prevent quantity from going below 1
            onQuantityChange(item.id, item.quantity - 1);
        } else {
            onRemoveItem(item.id); // Remove item if quantity goes to 0
        }
    };

    return (
        <div className="flex items-center gap-4 border-b pb-4 last:border-b-0">
            <Link to={`/product/${item.id}`} className="flex-shrink-0">
                <img
                    src={item.image}
                    alt={item.name}
                    className="h-16 w-16 object-cover rounded-md"
                />
            </Link>
            <div className="flex-1 grid gap-y-1">
                <Link to={`/product/${item.id}`} className="text-sm font-medium text-gray-800 hover:text-blue-600 line-clamp-1">
                    {item.name}
                </Link>
                <div className="text-sm font-semibold text-gray-800">
                    ${(item.price * item.quantity).toFixed(2)}
                </div>

                <div className="flex items-center justify-between mt-1">
                    {/* Quantity Controls */}
                    <div className="flex items-center border border-gray-300 rounded-md">
                        <button
                            onClick={handleDecrement}
                            className="p-1 text-gray-600 hover:bg-gray-100 rounded-l-md"
                            aria-label="Decrease quantity"
                        >
                            <Minus className="h-4 w-4" />
                        </button>
                        <span className="px-3 text-sm font-medium text-gray-800">
                            {item.quantity}
                        </span>
                        <button
                            onClick={handleIncrement}
                            className="p-1 text-gray-600 hover:bg-gray-100 rounded-r-md"
                            aria-label="Increase quantity"
                        >
                            <Plus className="h-4 w-4" />
                        </button>
                    </div>

                    {/* Remove Button */}
                    <button
                        onClick={() => onRemoveItem(item.id)}
                        className="text-gray-400 hover:text-red-500 text-sm flex items-center gap-1 transition-colors"
                        aria-label={`Remove ${item.name}`}
                    >
                        <Trash2 className="h-4 w-4" /> Remove
                    </button>
                </div>
            </div>
        </div>
    );
}