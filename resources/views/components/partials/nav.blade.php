@php
    $galleries = \App\Models\Gallery::where('status', true)->get();
@endphp

<div class="full-width-header header-style2">
    <header id="rs-header" class="rs-header">
        <div class="topbar-area">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-md-7">
                        <ul class="topbar-contact">
                            <li>
                                <i class="flaticon-email"></i>
                                <a href="mailto:{{ application('email') }}">{{ application('email') }}</a>
                            </li>
                            <li>
                                <i class="flaticon-call"></i>
                                <a href="tel:{{ application('line1') }}">{{ application('line1') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5 text-right">
                        <ul class="topbar-right">
                            <li class="login-register">
                                <i class="fa fa-sign-in"></i>
                                <a href="{{ route('login') }}">Portal</a>
                            </li>
                            <li class="btn-part">
                                <a class="apply-btn" href="{{ url('registration') }}">Admission</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="menu-area menu-sticky">
            <div class="container">
                <div class="row y-middle">
                    <div class="col-lg-5">
                        <div class="logo-cat-wrap">
                            <div class="logo-part pr-90">
                                <a class="dark-logo" href="{{ url('/') }}">
                                    <img src="{{ asset('storage/'.application('image')) }}" style="width: 60px;" alt="{{ application('name') }}">
                                </a>
                                <a class="light-logo" href="{{ url('/') }}">
                                    <img src="{{ asset('storage/'.application('image')) }}"
                                        style="width: 60px;"  alt="{{ application('name') }}">
                                </a>
                            </div>
                            <!-- <div class="categories-btn">
                                <button type="button" class="cat-btn"><i class="fa fa-th"></i>Categories</button>
                            </div> -->
                        </div>
                    </div>

                    <div class="col-lg-7 text-center">
                        <div class="rs-menu-area">
                            <div class="main-menu pr-90">
                                <div class="mobile-menu">
                                    <a class="rs-menu-toggle">
                                        <i class="fa fa-bars"></i>
                                    </a>
                                </div>
                                <!-- current-menu-item -->
                                <nav class="rs-menu">
                                    <ul class="nav-menu">
                                        <li class="menu-item"> 
                                            <a href="{{ url('/') }}">Home</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ url('/about') }}">About</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ url('/gallery') }}">Gallery</a>
                                        </li>
                                        <li class="menu-item">
                                            <a href="{{ url('registration') }}">Admission</a>
                                        </li>
                                        @guest
                                            <li class="menu-item mobile-menu">
                                                <a href="{{ route('dashboard') }}">Portal</a>
                                            </li>
                                        @else
                                            <li class="menu-item mobile-menu">
                                                <a href="{{ route('login') }}">Login</a>
                                            </li>
                                        @endguest
                                    </ul>
                                </nav> 
                            </div>

                            <div class="expand-btn-inner">
                                <!-- <ul>
                                    <li>
                                        <a class="hidden-xs rs-search short-border" data-target=".search-modal" data-toggle="modal" href="#">
                                            <i class="flaticon-search"></i>
                                        </a>
                                    </li>
                                    <li class="icon-bar cart-inner no-border mini-cart-active">
                                        <a class="cart-icon">
                                            <span class="cart-count">2</span>
                                            <i class="flaticon-bag"></i>
                                        </a>
                                        <div class="woocommerce-mini-cart text-left">
                                            <div class="cart-bottom-part">
                                                <ul class="cart-icon-product-list">
                                                    <li class="display-flex">
                                                        <div class="icon-cart">
                                                            <a href="#"><i class="fa fa-times"></i></a>
                                                        </div>
                                                        <div class="product-info">
                                                            <a href="cart.html">Law Book</a><br>
                                                            <span class="quantity">1 × $30.00</span>
                                                        </div>
                                                        <div class="product-image">
                                                            <a href="cart.html"><img src="{{ asset('frontend/images/shop/1.jpg') }}" alt="Product Image"></a>
                                                        </div>
                                                    </li>
                                                </ul>

                                                <div class="total-price text-center">
                                                    <span class="subtotal">Subtotal:</span>
                                                    <span class="current-price">$85.00</span>
                                                </div>

                                                <div class="cart-btn text-center">
                                                    <a class="crt-btn btn1" href="{{ url('cart') }}">View Cart</a>
                                                    <a class="crt-btn btn2" href="{{ url('checkout') }}">Check Out</a>
                                                </div>
                                            </div>
                                        </div> 
                                    </li>
                                </ul> -->
                                <a id="nav-expander" class="nav-expander style3">
                                    <span class="dot1"></span>
                                    <span class="dot2"></span>
                                    <span class="dot3"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav class="right_menu_togle hidden-md">
            <div class="close-btn">
                <div id="nav-close">
                    <div class="line">
                        <span class="line1"></span><span class="line2"></span>
                    </div>
                </div>
            </div>
            <div class="canvas-logo">
                <a href="index.html"><img src="{{ asset('storage/'.application('image') ) }}" alt="logo"></a>
            </div>
            <div class="offcanvas-text">
                <p>{{ application('description') }}</p>
            </div>
            <div class="offcanvas-gallery">
                @foreach ($galleries as $gallery)
                    <div class="gallery-img">
                        <a class="image-popup" href="{{ asset($gallery->image()) }}"><img src="{{ asset($gallery->image()) }}" alt="{{ $gallery->title() }}"></a>
                    </div>
                @endforeach
            </div>
            <div class="canvas-contact">
                <ul class="social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                    <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                </ul>
            </div>
        </nav>
    </header>
</div>