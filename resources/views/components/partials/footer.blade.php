<footer class="footer_area bg_cover" style="background-image: url({{ asset('storage/' .banner('wide_banner')) }})">
    <div class="footer_widget pt-80 pb-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="footer_about mt-50">
                        <a href="#"><img src="{{ asset('storage/' . application('image')) }}" alt="{{ application('name') }}"></a>

                        <p>{{ application('description') }}</p>

                        <ul class="footer_social">
                            <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest-p"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="footer_widget_wrapper d-flex flex-wrap">
                        <div class="footer_link mt-50">
                            <h5 class="footer_title">Quick Links</h5>

                            <div class="footer_link_wrapper d-flex">
                                <ul class="link">
                                    <li><a href="#">Home</a></li>
                                    <li><a href="#">About us</a></li>
                                    <li><a href="#">Education</a></li>
                                    <li><a href="#">Our Events</a></li>
                                    <li><a href="#">Our Packages</a></li>
                                </ul>
                                <ul class="link">
                                    <li><a href="#">Our Team</a></li>
                                    <li><a href="#">Latest News</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Terms & Condations</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="footer_contact mt-50">
                            <h5 class="footer_title">Contact</h5>

                            <ul class="contact">
                                <li>Location : {{ application('address') }}</li>
                                <li>Emal : {{ application('email') }}</li>
                                <li>Phone : {{ application('line1') }}</li>
                                <li>Fax:{{ application('line2') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer_copyright">
        <div class="container">
            <div class="footer_copyright_wrapper text-center d-md-flex justify-content-between">
                <div class="copyright">
                    <p>Haiv Technology Support Limited</p>
                </div>
                <div class="copyright">
                    <p>&copy; Copyrights {{ date('Y') }} {{ application('name') }} All rights reserved. </p>
                </div>
            </div>
        </div>
    </div>
</footer>