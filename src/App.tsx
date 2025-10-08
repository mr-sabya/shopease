import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import './App.css'
import Home from './pages/home/Home';
import About from './pages/about/About';
import Contact from './pages/contact/Contact';
import Header from './components/common/Header';
import Footer from './components/common/Footer/Footer';
import Shop from './pages/shop/Shop';
import Categories from './pages/categories/Categories';
import Login from './pages/login/Login';
import Register from './pages/register/Register';
import Blog from './pages/blog/Blog';
import Cart from './pages/cart/Cart';
import Checkout from './pages/checkout/Checkout';

function App() {
    return (
        <Router>
            <Header /> {/* Our navigation bar */}
            <div>
                <Routes>
                    <Route path="/" element={<Home />} />
                    <Route path="/shop" element={<Shop />} />
                    <Route path="/categories" element={<Categories />} />
                    <Route path="/blog" element={<Blog />} />
                    <Route path="/about" element={<About />} />
                    <Route path="/contact" element={<Contact />} />
                    <Route path="/login" element={<Login />} />
                    <Route path="/register" element={<Register />} />
                    <Route path="/cart" element={<Cart />} />
                    <Route path="/checkout" element={<Checkout />} />
                </Routes>
            </div>
            <Footer />
        </Router>
    )
}

export default App
