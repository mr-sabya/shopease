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
import UserProfile from './pages/user/profile/Profile';
import OfferPage from './pages/offer/Offer';
import ServicePage from './pages/service/Service';
import FAQPage from './pages/Faq/Faq';
import PrivacyPolicyPage from './pages/privacy-policy/PrivacyPolicy';
import TermsOfServicePage from './pages/terms-of-service/TermsOfService';
import HelpPage from './pages/help/Help';

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
                    <Route path="/offers" element={<OfferPage />} />
                    <Route path="/services" element={<ServicePage />} />
                    <Route path="/faq" element={<FAQPage />} />
                    <Route path="/privacy-policy" element={<PrivacyPolicyPage />} />
                    <Route path="/terms-of-service" element={<TermsOfServicePage />} /> {/* New Route */}
                    <Route path="/help" element={<HelpPage />} />                 {/* New Route */}

                    <Route path="/profile" element={<UserProfile />} />
                </Routes>
            </div>
            <Footer />
        </Router>
    )
}

export default App
