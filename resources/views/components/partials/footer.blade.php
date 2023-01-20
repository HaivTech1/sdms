<footer class="footer_area bg_cover" style="background-image: url({{ asset('storage/' .banner('wide_banner')) }})">
    <div class="footer_widget pt-20 pb-130">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="footer_about mt-50">
                        <a href="#"><img src="{{ asset('storage/' . application('image')) }}" style="width: 100px; border-radius: 100%" alt="{{ application('name') }}"></a>

                        <p>{{ application('description') }}</p>

                            @php
                                $application = \App\Models\Application::first()
                            @endphp
                         {{-- Social Share --}}
                        <x-social.links :application="$application" url="{{ Request::url() }}" />
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
                                    <li><a href="{{ url('registration') }}">Register with us!</a></li>
                                </ul>
                                <ul class="link">
                                    <li><a href="#">Our Team</a></li>
                                    <li><a href="#">Latest News</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="footer_contact mt-50">
                            <h5 class="footer_title">Contact</h5>

                            <ul class="contact">
                                <li>Location : {{ application('address') }}</li>
                                <li>Emal : <a href="mailTo:{{ application('email') }}">{{ application('email') }}</a></li>
                                <li>Phone : <a href="tel:{{ application('line1') }}">{{ application('line1') }}</a></li>
                                <!--<li>Fax: {{ application('line2') }}</li>-->
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
                    <p style="font-size: 12px">&copy; Copyrights {{ date('Y') }} {{ application('name') }}. All rights reserved. </p>
                </div>
                <div class="copyright">
                    <p style="font-size: 10px">Haiv Technology Support Limited</p>
                </div>
            </div>
        </div>
    </div>
</footer>