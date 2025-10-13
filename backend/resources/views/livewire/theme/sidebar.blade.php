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
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Management</h4>
                </li>

                <li class="nav-item {{ request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('coupons.*') || request()->routeIs('tags.*') ? 'active submenu' : '' }}">
                    <a data-bs-toggle="collapse" href="#productsManagement" class="collapsed" aria-expanded="{{ request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('coupons.*') || request()->routeIs('tags.*') ? 'true' : 'false' }}">
                        <i class="fas fa-cubes"></i>
                        <p>Product Catalog</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('coupons.*') || request()->routeIs('tags.*') ? 'show' : '' }}" id="productsManagement">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->routeIs('categories.*') ? 'active' : '' }}" >
                                <a href="{{ route('categories.index') }}" wire:navigate>
                                    <span class="sub-item">Categories</span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('brands.*') ? 'active' : '' }}">
                                <a href="{{ route('brands.index') }}" wire:navigate>
                                    <span class="sub-item">Brands</span>
                                </a>
                            </li>
                            <!-- coupons -->
                            <li class="{{ request()->routeIs('coupons.*') ? 'active' : '' }}">
                                <a href="{{ route('coupons.index') }}" wire:navigate>
                                    <span class="sub-item">Coupons</span>
                                </a>
                            </li>

                            <!-- tags -->
                            <li class="{{ request()->routeIs('tags.*') ? 'active' : '' }}">
                                <a href="{{ route('tags.index') }}" wire:navigate>
                                    <span class="sub-item">Tags</span>
                                </a>
                            </li>
                            {{-- Add other product-related items here, e.g., Products, Attributes --}}
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

                {{-- Original "Components" and other demo links are removed/commented --}}
                {{-- as they are not part of your application's current routes. --}}
                {{-- You can re-add them if you have actual routes for these pages. --}}

                {{-- <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fas fa-layer-group"></i>
                        <p>Base</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li><a href="components/avatars.html"><span class="sub-item">Avatars</span></a></li>
                            <li><a href="components/buttons.html"><span class="sub-item">Buttons</span></a></li>
                            <li><a href="components/gridsystem.html"><span class="sub-item">Grid System</span></a></li>
                            <li><a href="components/panels.html"><span class="sub-item">Panels</span></a></li>
                            <li><a href="components/notifications.html"><span class="sub-item">Notifications</span></a></li>
                            <li><a href="components/sweetalert.html"><span class="sub-item">Sweet Alert</span></a></li>
                            <li><a href="components/font-awesome-icons.html"><span class="sub-item">Font Awesome Icons</span></a></li>
                            <li><a href="components/simple-line-icons.html"><span class="sub-item">Simple Line Icons</span></a></li>
                            <li><a href="components/typography.html"><span class="sub-item">Typography</span></a></li>
                        </ul>
                    </div>
                </li> --}}
                {{-- ... other demo items ... --}}

            
            </ul>
        </div>
    </div>
</div>
