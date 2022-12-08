<section class="header_area">
    <div class="header_top">
        <div class="container">
            <div class="header_top_wrapper d-flex justify-content-center justify-content-md-between">
                <div class="header_top_info d-none d-md-block">
                    <ul>
                        <li><img src="{{ asset('frontend/images/call.png') }}" alt="call"><a href="tel:{{ application('line1') }}">{{ application('line1') }}</a></li>
                        <li><img src="{{ asset('frontend/images/mail.png') }}" alt="mail"><a href="#">{{ application('email') }}</a></li>
                    </ul>
                </div>
                <div class="header_top_login">
                    <ul>
                        <li><a class="main-btn" href="{{ route('login') }}"><i class="fa fa-user-o"></i> Portal </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="header_menu">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('storage/'.application('image')) }}" alt="{{ application('name') }}" style="width: 100px">
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                    <span class="toggler-icon"></span>
                </button>

                {{-- <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                    <ul class="navbar-nav m-auto">
                        <li>
                            <a class="active" href="{{ url('/') }}">Home</a>
                        </li>
                        <li>
                            <a href="about.html">About</a>
                        </li>
                        <li>
                            <a href="blog.html">Blog</a>
                        </li>
                        <li>
                            <a href="contact.html">Contact</a>
                        </li>
                    </ul>
                </div> --}}

                {{-- <div class="navbar_meta">
                    <ul>
                        <li>
                            <a id="search" href="#"><img src="assets/images/search.png" alt="search"></a>
                            <div class="search_bar">
                                <input type="text" placeholder="Search">
                                <button><i class="fa fa-search"></i></button>
                            </div>
                        </li>
                        <li><a href="#"><img src="assets/images/cart.png" alt="cart"> <span>0</span></a></li>
                    </ul>
                </div> --}}
            </nav>
        </div>
    </div>
</section>