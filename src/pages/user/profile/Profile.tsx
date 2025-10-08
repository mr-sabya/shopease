// app/pages/UserProfilePage.tsx
import { useState } from "react";
import { User, ShoppingBag, Settings, MapPin, CreditCard } from "lucide-react";
import { Breadcrumbs } from "../../../components/common/Breadcrumb/Breadcrumb";

// --- Dummy Data for User Profile ---
interface UserProfile {
    firstName: string;
    lastName: string;
    email: string;
    shippingAddress: {
        address1: string;
        address2?: string;
        city: string;
        state: string;
        zip: string;
        country: string;
    };
}

const dummyUserProfile: UserProfile = {
    firstName: "John",
    lastName: "Doe",
    email: "john.doe@example.com",
    shippingAddress: {
        address1: "123 Main St",
        address2: "Apt 4B",
        city: "Anytown",
        state: "CA",
        zip: "90210",
        country: "USA",
    },
};

// --- Dummy Data for Order History ---
interface OrderItem {
    id: string;
    name: string;
    image: string;
    price: number;
    quantity: number;
}

interface Order {
    id: string;
    date: string;
    total: number;
    status: "Pending" | "Processing" | "Shipped" | "Delivered" | "Cancelled";
    items: OrderItem[];
    shippingAddress: {
        address1: string;
        city: string;
        state: string;
        zip: string;
    };
    paymentMethod: string;
}

const dummyOrderHistory: Order[] = [
    {
        id: "ORD001",
        date: "2023-10-26",
        total: 125.84,
        status: "Delivered",
        items: [
            { id: "1", name: "Kalrez® Spectrum™ 6375 long product name test", image: "/assets/images/products/product-1.png", price: 17.84, quantity: 1 },
            { id: "2", name: "Chiffon Bell Sleeves Dress", image: "/assets/images/products/product-2.png", price: 78.00, quantity: 1 },
        ],
        shippingAddress: { address1: "123 Main St", city: "Anytown", state: "CA", zip: "90210" },
        paymentMethod: "Visa **** 1234",
    },
    {
        id: "ORD002",
        date: "2023-11-15",
        total: 99.00,
        status: "Shipped",
        items: [
            { id: "3", name: "Wireless Headphones", image: "/assets/images/products/product-3.png", price: 99.00, quantity: 1 },
        ],
        shippingAddress: { address1: "123 Main St", city: "Anytown", state: "CA", zip: "90210" },
        paymentMethod: "Mastercard **** 5678",
    },
];

type ActiveSection = "profile" | "orders" | "settings";

export default function UserProfile() {
    const [activeSection, setActiveSection] = useState<ActiveSection>("profile");
    const [userProfile, setUserProfile] = useState<UserProfile>(dummyUserProfile);
    const [isEditingProfile, setIsEditingProfile] = useState(false);

    const handleProfileChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
        const { name, value } = e.target;
        if (name.startsWith("shippingAddress.")) {
            const addressField = name.split(".")[1];
            setUserProfile(prev => ({
                ...prev,
                shippingAddress: {
                    ...prev.shippingAddress,
                    [addressField]: value,
                },
            }));
        } else {
            setUserProfile(prev => ({ ...prev, [name]: value }));
        }
    };

    const handleSaveProfile = () => {
        // In a real app, you would send userProfile data to a backend API
        console.log("Saving profile:", userProfile);
        alert("Profile updated successfully!");
        setIsEditingProfile(false);
    };

    const renderSection = () => {
        switch (activeSection) {
            case "profile":
                return (
                    <div className="bg-white p-6 rounded-lg shadow-md">
                        <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <User className="h-6 w-6 text-blue-600" /> Personal Information
                        </h2>
                        {isEditingProfile ? (
                            <div className="space-y-4">
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label htmlFor="firstName" className="block text-sm font-medium text-gray-700">First Name</label>
                                        <input type="text" id="firstName" name="firstName" value={userProfile.firstName} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div>
                                        <label htmlFor="lastName" className="block text-sm font-medium text-gray-700">Last Name</label>
                                        <input type="text" id="lastName" name="lastName" value={userProfile.lastName} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div className="md:col-span-2">
                                        <label htmlFor="email" className="block text-sm font-medium text-gray-700">Email Address</label>
                                        <input type="email" id="email" name="email" value={userProfile.email} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                </div>

                                <h3 className="text-xl font-semibold text-gray-800 mt-6 mb-3 flex items-center gap-2">
                                    <MapPin className="h-5 w-5 text-blue-600" /> Shipping Address
                                </h3>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div className="md:col-span-2">
                                        <label htmlFor="shippingAddress.address1" className="block text-sm font-medium text-gray-700">Address Line 1</label>
                                        <input type="text" id="shippingAddress.address1" name="shippingAddress.address1" value={userProfile.shippingAddress.address1} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div className="md:col-span-2">
                                        <label htmlFor="shippingAddress.address2" className="block text-sm font-medium text-gray-700">Address Line 2 (Optional)</label>
                                        <input type="text" id="shippingAddress.address2" name="shippingAddress.address2" value={userProfile.shippingAddress.address2 || ""} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div>
                                        <label htmlFor="shippingAddress.city" className="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" id="shippingAddress.city" name="shippingAddress.city" value={userProfile.shippingAddress.city} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div>
                                        <label htmlFor="shippingAddress.state" className="block text-sm font-medium text-gray-700">State / Province</label>
                                        <input type="text" id="shippingAddress.state" name="shippingAddress.state" value={userProfile.shippingAddress.state} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div>
                                        <label htmlFor="shippingAddress.zip" className="block text-sm font-medium text-gray-700">ZIP / Postal Code</label>
                                        <input type="text" id="shippingAddress.zip" name="shippingAddress.zip" value={userProfile.shippingAddress.zip} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                                    </div>
                                    <div>
                                        <label htmlFor="shippingAddress.country" className="block text-sm font-medium text-gray-700">Country</label>
                                        <select id="shippingAddress.country" name="shippingAddress.country" value={userProfile.shippingAddress.country} onChange={handleProfileChange}
                                            className="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="USA">United States</option>
                                            <option value="CAN">Canada</option>
                                            <option value="GBR">United Kingdom</option>
                                            {/* Add more countries */}
                                        </select>
                                    </div>
                                </div>
                                <div className="flex justify-end gap-3 mt-6">
                                    <button type="button" onClick={() => setIsEditingProfile(false)}
                                        className="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Cancel
                                    </button>
                                    <button type="button" onClick={handleSaveProfile}
                                        className="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        ) : (
                            <div className="space-y-4 text-gray-700">
                                <p><span className="font-semibold">Name:</span> {userProfile.firstName} {userProfile.lastName}</p>
                                <p><span className="font-semibold">Email:</span> {userProfile.email}</p>

                                <h3 className="text-xl font-semibold text-gray-800 mt-6 mb-3 flex items-center gap-2">
                                    <MapPin className="h-5 w-5 text-blue-600" /> Shipping Address
                                </h3>
                                <p>{userProfile.shippingAddress.address1}</p>
                                {userProfile.shippingAddress.address2 && <p>{userProfile.shippingAddress.address2}</p>}
                                <p>{userProfile.shippingAddress.city}, {userProfile.shippingAddress.state} {userProfile.shippingAddress.zip}</p>
                                <p>{userProfile.shippingAddress.country}</p>

                                <button type="button" onClick={() => setIsEditingProfile(true)}
                                    className="mt-6 px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Edit Profile
                                </button>
                            </div>
                        )}
                    </div>
                );
            case "orders":
                return (
                    <div className="bg-white p-6 rounded-lg shadow-md">
                        <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <ShoppingBag className="h-6 w-6 text-blue-600" /> Order History
                        </h2>
                        {dummyOrderHistory.length === 0 ? (
                            <p className="text-gray-600">You haven't placed any orders yet.</p>
                        ) : (
                            <div className="space-y-6">
                                {dummyOrderHistory.map((order) => (
                                    <div key={order.id} className="border border-gray-200 rounded-lg p-4">
                                        <div className="flex justify-between items-center mb-3 border-b pb-3">
                                            <div>
                                                <p className="font-semibold text-lg">Order #{order.id}</p>
                                                <p className="text-sm text-gray-600">Date: {order.date}</p>
                                            </div>
                                            <div>
                                                <span className={`px-3 py-1 text-sm font-medium rounded-full
                                                    ${order.status === "Delivered" ? "bg-green-100 text-green-800" : ""}
                                                    ${order.status === "Shipped" ? "bg-blue-100 text-blue-800" : ""}
                                                    ${order.status === "Processing" ? "bg-yellow-100 text-yellow-800" : ""}
                                                    ${order.status === "Cancelled" ? "bg-red-100 text-red-800" : ""}
                                                `}>
                                                    {order.status}
                                                </span>
                                            </div>
                                        </div>
                                        <div className="mb-3">
                                            <p className="font-medium text-gray-700 mb-1">Items:</p>
                                            <ul className="list-disc pl-5 text-sm text-gray-600 space-y-1">
                                                {order.items.map((item) => (
                                                    <li key={item.id} className="flex items-center gap-2">
                                                        <img src={item.image} alt={item.name} className="h-8 w-8 object-cover rounded-md" />
                                                        <span>{item.name} (Qty: {item.quantity}) - ${(item.price * item.quantity).toFixed(2)}</span>
                                                    </li>
                                                ))}
                                            </ul>
                                        </div>
                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-y-2 text-sm text-gray-700 mt-4 pt-3 border-t">
                                            <div>
                                                <p className="font-medium flex items-center gap-1"><MapPin className="h-4 w-4 text-gray-500" /> Shipping To:</p>
                                                <p className="ml-5">{order.shippingAddress.address1}</p>
                                                <p className="ml-5">{order.shippingAddress.city}, {order.shippingAddress.state} {order.shippingAddress.zip}</p>
                                            </div>
                                            <div>
                                                <p className="font-medium flex items-center gap-1"><CreditCard className="h-4 w-4 text-gray-500" /> Payment:</p>
                                                <p className="ml-5">{order.paymentMethod}</p>
                                            </div>
                                            <div className="md:col-span-2 text-right">
                                                <p className="font-bold text-lg text-gray-800">Total: ${order.total.toFixed(2)}</p>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>
                );
            case "settings":
                return (
                    <div className="bg-white p-6 rounded-lg shadow-md">
                        <h2 className="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <Settings className="h-6 w-6 text-blue-600" /> Settings
                        </h2>
                        <p className="text-gray-700">This section is under construction. Here you could manage:</p>
                        <ul className="list-disc pl-6 mt-2 text-gray-600 space-y-1">
                            <li>Change Password</li>
                            <li>Notification Preferences</li>
                            <li>Connected Accounts</li>
                            <li>Privacy Settings</li>
                        </ul>
                    </div>
                );
            default:
                return null;
        }
    };

    return (
        <div>
            {/* Page Header with Breadcrumbs */}
            <Breadcrumbs
                title="Profile"
                breadcrumbs={[
                    { label: "Home", link: "/" },
                    { label: "Profile" }
                ]}
                backgroundColor="bg-blue-100" // A nicer gradient background
                containerClassName="py-10 md:py-16 shadow-sm"
                titleClassName="text-3xl md:text-3xl font-extrabold text-gray-900"
            />

            <section className="bg-gray-50 py-8">
                <div className="container mx-auto px-4 md:px-8">
                    <h1 className="text-3xl font-bold text-gray-800 mb-6">Welcome, {userProfile.firstName}!</h1>

                    <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
                        {/* Sidebar Navigation */}
                        <div className="lg:col-span-1 bg-white p-6 rounded-lg shadow-md h-fit sticky top-8">
                            <nav className="space-y-2">
                                <button
                                    onClick={() => { setActiveSection("profile"); setIsEditingProfile(false); }}
                                    className={`flex items-center gap-3 w-full text-left px-4 py-3 rounded-md transition-colors
                                ${activeSection === "profile" ? "bg-blue-100 text-blue-700 font-semibold" : "text-gray-700 hover:bg-gray-50"}`}
                                >
                                    <User className="h-5 w-5" /> Profile Information
                                </button>
                                <button
                                    onClick={() => setActiveSection("orders")}
                                    className={`flex items-center gap-3 w-full text-left px-4 py-3 rounded-md transition-colors
                                ${activeSection === "orders" ? "bg-blue-100 text-blue-700 font-semibold" : "text-gray-700 hover:bg-gray-50"}`}
                                >
                                    <ShoppingBag className="h-5 w-5" /> Order History
                                </button>
                                <button
                                    onClick={() => setActiveSection("settings")}
                                    className={`flex items-center gap-3 w-full text-left px-4 py-3 rounded-md transition-colors
                                ${activeSection === "settings" ? "bg-blue-100 text-blue-700 font-semibold" : "text-gray-700 hover:bg-gray-50"}`}
                                >
                                    <Settings className="h-5 w-5" /> Settings
                                </button>
                            </nav>
                        </div>

                        {/* Main Content Area */}
                        <div className="lg:col-span-3">
                            {renderSection()}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
}