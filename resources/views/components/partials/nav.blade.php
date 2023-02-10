<section class="header_area">
    <div class="header_top">
        <div class="container">
            <div class="header_top_wrapper d-flex justify-content-center justify-content-md-between">
            <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ asset('storage/'.application('image')) }}" alt="{{ application('name') }}" style="width: 50px; border-radius: 100%">
                </a>
                <div class="header_top_info d-none d-md-block">
                    <ul>
                        <li><img src="{{ asset('frontend/images/call.png') }}" alt="call"><a href="tel:{{ application('line1') }}">{{ application('line1') }}</a></li>
                        <li><img src="{{ asset('frontend/images/mail.png') }}" alt="mail"><a href="#">{{ application('email') }}</a></li>
                        <li><i class="bx bx-edit text-white mr-1"></i><a href="{{ url('registration') }}">Register!</a></li>
                    </ul>
                </div>
                <div class="header_top_login">
                    <ul>
                        <li><a class="main-btn text-center" href="{{ route('login') }}"><i class="fa fa-user"></i> Portal </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    
</section>