// app/components/Header.tsx
import { Link, NavLink } from "react-router-dom"; // Use react-router-dom for Link/NavLink
import { useState } from "react";
import { ShoppingCart, Heart, User, Menu, X, Search } from "lucide-react";
import SideCart from './SideCart/SideCart'; // Import our new SideCart component

export default function Header() {
    const [mobileOpen, setMobileOpen] = useState(false);
    const [menuOpen, setMenuOpen] = useState(false);
    const [isCartOpen, setIsCartOpen] = useState(false); // New state for cart visibility

    const menuItems = [
        { name: "Home", to: "/" },
        { name: "Shop", to: "/shop" },
        { name: "Categories", to: "/categories" },
        { name: "Blog", to: "/blog" },
    ];

    const importantLinks = [
        { name: "Offers", to: "/offers" },
        { name: "Help", to: "/help" },
        { name: "Contact", to: "/contact" },
    ];

    const toggleCart = () => {
        setIsCartOpen(!isCartOpen);
    };

    return (
        <header className="bg-white shadow-sm sticky top-0 z-50">
            {/* Top Header */}
            <div className="container mx-auto flex items-center justify-between px-4 py-3 md:px-8">
                {/* Logo */}
                <Link to="/" className="flex items-center space-x-2">
                    <img src="/logo.svg" alt="Logo" className="h-8 w-8" />
                    <span className="text-2xl font-bold text-blue-600">ShopEase</span>
                </Link>

                {/* Search Bar (Desktop) */}
                <div className="hidden md:flex flex-1 mx-8 justify-center">
                    <form className="w-1/2 flex items-center bg-gray-100 rounded-full px-4 py-2">
                        <Search className="h-5 w-5 text-gray-500" />
                        <input
                            type="text"
                            placeholder="Search for products..."
                            className="flex-1 bg-transparent outline-none ml-2 text-gray-700"
                        />
                    </form>
                </div>

                {/* Icons */}
                <div className="flex items-center space-x-5 text-gray-700 [&>a:hover]:text-blue-600 [&>button:hover]:text-blue-600 transition">
                    <NavLink to="/wishlist" className="relative">
                        <Heart className="h-6 w-6" />
                        <span className="absolute -top-2 -right-3 text-xs bg-blue-600 text-white rounded-full w-4 h-4 flex items-center justify-center">2</span>
                    </NavLink>

                    {/* Cart Button - changed from NavLink */}
                    <button onClick={toggleCart} className="relative cursor-pointer">
                        <ShoppingCart className="h-6 w-6" />
                        <span className="absolute -top-2 -right-3 text-xs bg-blue-600 text-white rounded-full w-4 h-4 flex items-center justify-center">3</span>
                    </button>

                    <NavLink to="/login">
                        <User className="h-6 w-6" />
                    </NavLink>

                    {/* Mobile menu toggle */}
                    <button onClick={() => setMobileOpen(!mobileOpen)} className="md:hidden text-gray-700 hover:text-blue-600">
                        {mobileOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
                    </button>
                </div>
            </div>

            {/* Search (Mobile) */}
            <div className="md:hidden px-4 pb-3 flex justify-center">
                <form className="w-2/3 flex items-center bg-gray-100 rounded-full px-4 py-2">
                    <Search className="h-5 w-5 text-gray-500" />
                    <input
                        type="text"
                        placeholder="Search for products..."
                        className="flex-1 bg-transparent outline-none ml-2 text-gray-700"
                    />
                </form>
            </div>

            {/* Main Menu Bar */}
            <div className="bg-blue-50 border-t border-b">
                <div className="container mx-auto flex justify-between items-center px-4 py-2 md:px-8">
                    {/* Left Menu Items */}
                    <nav className="hidden md:flex space-x-6 font-medium text-gray-700">
                        {menuItems.map((item) => (
                            <NavLink
                                key={item.name}
                                to={item.to}
                                className={({ isActive }) => isActive ? "text-blue-600" : "hover:text-blue-600"}
                            >
                                {item.name}
                            </NavLink>
                        ))}
                    </nav>

                    {/* Right Important Links */}
                    <div className="hidden md:flex space-x-4 text-sm font-medium text-gray-600">
                        {importantLinks.map((link) => (
                            <NavLink
                                key={link.name}
                                to={link.to}
                                className={({ isActive }) => isActive ? "text-blue-600" : "hover:text-blue-600"}
                            >
                                {link.name}
                            </NavLink>
                        ))}
                    </div>

                    {/* Mobile menu toggle for main menu */}
                    <button className="md:hidden text-gray-700" onClick={() => setMenuOpen(!menuOpen)}>
                        {menuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
                    </button>
                </div>

                {/* Mobile Menu Items */}
                {menuOpen && (
                    <div className="md:hidden bg-white border-t px-4 pb-4 flex flex-col space-y-2">
                        {menuItems.map((item) => (
                            <NavLink key={item.name} to={item.to} className="hover:text-blue-600">{item.name}</NavLink>
                        ))}
                        <hr className="my-2 border-gray-200" />
                        {importantLinks.map((link) => (
                            <NavLink key={link.name} to={link.to} className="hover:text-blue-600">{link.name}</NavLink>
                        ))}
                    </div>
                )}
            </div>

            {/* Optional Mobile menu below top header */}
            {mobileOpen && (
                <div className="md:hidden bg-white shadow-md border-t">
                    <nav className="flex flex-col space-y-3 p-4 text-gray-700">
                        <NavLink to="/" className="hover:text-blue-600">Home</NavLink>
                        <NavLink to="/shop" className="hover:text-blue-600">Shop</NavLink>
                        <NavLink to="/wishlist" className="hover:text-blue-600">Wishlist</NavLink>
                        <NavLink to="/cart" className="hover:text-blue-600">Cart</NavLink>
                        <NavLink to="/login" className="hover:text-blue-600">Account</NavLink>
                    </nav>
                </div>
            )}

            {/* Side Tray Cart Component */}
            <SideCart isOpen={isCartOpen} onClose={() => setIsCartOpen(false)} />
        </header>
    );
}