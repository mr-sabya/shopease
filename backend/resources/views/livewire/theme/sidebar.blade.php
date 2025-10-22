<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('home') }}" class="logo">
                <img
                    src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}"
                    alt="navbar brand"
                    class="navbar-brand"
                    height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}" wire:navigate>
                        <i class="fas fa-chart-line"></i> <!-- Changed from fa-home to fa-chart-line for dashboard -->
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Management</h4>
                </li>

                <li class="nav-item {{ request()->routeIs('product.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#productsManagement" class="collapsed" aria-expanded="{{ request()->routeIs('product.*') ? 'true' : 'false' }}">
                        <i class="fas fa-boxes"></i> <!-- Changed from fa-cubes to fa-boxes for Product Catalog -->
                        <p>Product Catalog</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('product.*') ? 'show' : '' }}" id="productsManagement">
                        <ul class="nav nav-collapse">

                            <!-- products -->
                            <li class="{{ request()->routeIs('product.products.*') ? 'active' : '' }}">
                                <a href="{{ route('product.products.index') }}" wire:navigate>
                                    <span class="sub-item">Products</span>
                                </a>
                            </li>

                            <!-- categories -->
                            <li class="{{ request()->routeIs('product.categories.*') ? 'active' : '' }}">
                                <a href="{{ route('product.categories.index') }}" wire:navigate>
                                    <span class="sub-item">Categories</span>
                                </a>
                            </li>
                            <!-- brands -->
                            <li class="{{ request()->routeIs('product.brands.*') ? 'active' : '' }}">
                                <a href="{{ route('product.brands.index') }}" wire:navigate>
                                    <span class="sub-item">Brands</span>
                                </a>
                            </li>
                            <!-- coupons -->
                            <li class="{{ request()->routeIs('product.coupons.*') ? 'active' : '' }}">
                                <a href="{{ route('product.coupons.index') }}" wire:navigate>
                                    <span class="sub-item">Coupons</span>
                                </a>
                            </li>

                            <!-- tags -->
                            <li class="{{ request()->routeIs('product.tags.*') ? 'active' : '' }}">
                                <a href="{{ route('product.tags.index') }}" wire:navigate>
                                    <span class="sub-item">Tags</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <!-- Attributes -->
                <li class="nav-item {{ request()->routeIs('attribute.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#attributeManagement" class="collapsed" aria-expanded="{{ request()->routeIs('attribute.*') ? 'true' : 'false' }}">
                        <i class="fas fa-tags"></i> <!-- Changed from fa-cubes to fa-tags for Attributes -->
                        <p>Attributes</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('attribute.*') ? 'show' : '' }}" id="attributeManagement">
                        <ul class="nav nav-collapse">
                            <!-- attributes -->
                            <li class="{{ request()->routeIs('attribute.attributes.index') ? 'active' : '' }}">
                                <a href="{{ route('attribute.attributes.index') }}" wire:navigate>
                                    <span class="sub-item">Attributes</span>
                                </a>
                            </li>
                            <!-- attribute values -->
                            <li class="{{ request()->routeIs('attribute.attribute-values.index') ? 'active' : '' }}">
                                <a href="{{ route('attribute.attribute-values.index') }}" wire:navigate>
                                    <span class="sub-item">Attribute Values</span>
                                </a>
                            </li>
                            <!-- attribute sets -->
                            <li class="{{ request()->routeIs('attribute.attribute-sets.index') ? 'active' : '' }}">
                                <a href="{{ route('attribute.attribute-sets.index') }}" wire:navigate>
                                    <span class="sub-item">Attribute Sets</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ request()->routeIs('order.index') ? 'active' : '' }}">
                    <a href="{{ route('order.index') }}" wire:navigate>
                        <i class="fas fa-shopping-cart"></i>
                        <p>Orders</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('deal.index') ? 'active' : '' }}">
                    <a href="{{ route('deal.index') }}" wire:navigate>
                        <i class="fas fa-shopping-cart"></i>
                        <p>Deals</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('collection.index') ? 'active' : '' }}">
                    <a href="{{ route('collection.index') }}" wire:navigate>
                        <i class="fas fa-shopping-cart"></i>
                        <p>Collections</p>
                    </a>
                </li>

                <!-- users -->
                <li class="nav-item {{ request()->routeIs('users.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#userManagement" class="collapsed" aria-expanded="{{ request()->routeIs('users.*') ? 'true' : 'false' }}">
                        <i class="fas fa-users"></i> <!-- Changed from fa-cubes to fa-users for Users -->
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}" id="userManagement">
                        <ul class="nav nav-collapse">
                            <!-- customers -->
                            <li class="{{ request()->routeIs('users.customers.*') ? 'active' : '' }}">
                                <a href="{{ route('users.customers.index') }}" wire:navigate>
                                    <span class="sub-item">Customers</span>
                                </a>
                            </li>
                            <!-- investors -->
                            <li class="{{ request()->routeIs('users.investors.*') ? 'active' : '' }}">
                                <a href="{{ route('users.investors.index') }}" wire:navigate>
                                    <span class="sub-item">Investors</span>
                                </a>
                            </li>
                            <!-- vendors -->
                            <li class="{{ request()->routeIs('users.vendors.*') ? 'active' : '' }}">
                                <a href="{{ route('users.vendors.index') }}" wire:navigate>
                                    <span class="sub-item">Vendors</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <!-- blog -->
                <li class="nav-item {{ request()->routeIs('blog.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#blogManagement" class="collapsed" aria-expanded="{{ request()->routeIs('blog.*') ? 'true' : 'false' }}">
                        <i class="fas fa-users"></i> <!-- Changed from fa-cubes to fa-users for Users -->
                        <p>Blog</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('blog.*') ? 'show' : '' }}" id="blogManagement">
                        <ul class="nav nav-collapse">
                            <!-- category -->
                            <li class="{{ request()->routeIs('blog.category.index') ? 'active' : '' }}">
                                <a href="{{ route('blog.category.index') }}" wire:navigate>
                                    <span class="sub-item">Category</span>
                                </a>
                            </li>

                            <!-- tag -->
                            <li class="{{ request()->routeIs('blog.tag.index') ? 'active' : '' }}">
                                <a href="{{ route('blog.tag.index') }}" wire:navigate>
                                    <span class="sub-item">Tag</span>
                                </a>
                            </li>

                            <!-- post.index -->
                            <li class="{{ request()->routeIs('blog.post.index') ? 'active' : '' }}">
                                <a href="{{ route('blog.post.index') }}" wire:navigate>
                                    <span class="sub-item">Post</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                </li>

                <!-- locations -->
                <li class="nav-item {{ request()->routeIs('locations.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#locationManagement" class="collapsed" aria-expanded="{{ request()->routeIs('locations.*') ? 'true' : 'false' }}">
                        <i class="fas fa-globe-americas"></i> <!-- Changed from fa-cubes to fa-globe-americas for Locations -->
                        <p>Locations</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('locations.*') ? 'show' : '' }}" id="locationManagement">
                        <ul class="nav nav-collapse">
                            <!-- countries -->
                            <li class="{{ request()->routeIs('locations.countries') ? 'active' : '' }}">
                                <a href="{{ route('locations.countries') }}" wire:navigate>
                                    <span class="sub-item">Countries</span>
                                </a>
                            </li>
                            <!-- states -->
                            <li class="{{ request()->routeIs('locations.states') ? 'active' : '' }}">
                                <a href="{{ route('locations.states') }}" wire:navigate>
                                    <span class="sub-item">States</span>
                                </a>
                            </li>
                            <!-- cities -->
                            <li class="{{ request()->routeIs('locations.cities') ? 'active' : '' }}">
                                <a href="{{ route('locations.cities') }}" wire:navigate>
                                    <span class="sub-item">Cities</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <!-- Investment -->
                <li class="nav-item {{ request()->routeIs('investment.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#investmentManagement" class="collapsed" aria-expanded="{{ request()->routeIs('investment.*') ? 'true' : 'false' }}">
                        <i class="fas fa-hand-holding-usd"></i> <!-- Changed from fa-cubes to fa-hand-holding-usd for Investment -->
                        <p>Investment</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('investment.*') ? 'show' : '' }}" id="investmentManagement">
                        <ul class="nav nav-collapse">
                            <!-- projects -->
                            <li class="{{ request()->routeIs('investment.projects.index') ? 'active' : '' }}">
                                <a href="{{ route('investment.projects.index') }}" wire:navigate>
                                    <span class="sub-item">Projects</span>
                                </a>
                            </li>
                            <!-- projects -->
                            <li class="{{ request()->routeIs('investment.investments.index') ? 'active' : '' }}">
                                <a href="{{ route('investment.investments.index') }}" wire:navigate>
                                    <span class="sub-item">Investments</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                <!-- Website -->
                <li class="nav-item {{ request()->routeIs('website.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#websiteManagement" class="collapsed" aria-expanded="{{ request()->routeIs('website.*') ? 'true' : 'false' }}">
                        <i class="fas fa-globe"></i> <!-- Changed from fa-cubes to fa-globe for Website -->
                        <p>Website</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('website.*') ? 'show' : '' }}" id="websiteManagement">
                        <ul class="nav nav-collapse">
                            <!-- banner -->
                            <li class="{{ request()->routeIs('website.banner.index') ? 'active' : '' }}">
                                <a href="{{ route('website.banner.index') }}" wire:navigate>
                                    <span class="sub-item">Banner</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>


                {{-- Add other management sections as needed --}}

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">System</h4>
                </li>

                <li class="nav-item {{ request()->routeIs('settings.index') ? 'active' : '' }}">
                    <a href="{{ route('settings.index') }}" wire:navigate>
                        <i class="fas fa-cogs"></i>
                        <p>Settings</p>
                    </a>
                </li>


            </ul>
        </div>
    </div>
</div>