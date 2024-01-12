<x-base-layout>
    @php
        $choose = \App\Models\Choose::first();
        $parent_reviews = \App\Models\ParentReview::all();
    @endphp

    <div id="rs-banner" class="rs-banner style7">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="banner-content">
                        <h1 class="banner-title white-color">{{ getAboutSetting('home_title') }}</h1>
                        <div class="desc white-color mb-50">
                            {{ getAboutSetting('home_description') }}
                        </div>
                        <div class="btn-part">
                            <a class="readon border-less" href="{{ url('/about') }}">{{ getAboutSetting('home_button_text') }}</a>
                        </div>
                    </div>
                    <div class="icons one up-down">
                        <img src="{{ asset('frontend/images/banner/home7/icon/2.png') }}" alt="Images">
                    </div> 
                    <div class="icons two left-right">
                        <img src="{{ asset('frontend/images/banner/home7/icon/1.png') }}" alt="Images">
                    </div> 
                    <div class="icons three left-right">
                        <img src="{{ asset('frontend/images/banner/home7/icon/1.png') }}" alt="Images">
                    </div> 
                    <div class="icons four up-down">
                        <img src="{{ asset('frontend/images/banner/home7/icon/2.png') }}" alt="Images">
                    </div>
                </div>
                <div class="offset-lg-6"></div>
            </div>
        </div>
        <div class="img-part">
            <img src="{{ asset('storage/'.getAboutSetting('home_banner_image') ) }} }}" alt="Banner Image">
        </div>
    </div>

    <div class="rs-about style11 pt-100 md-pt-70 pb-100 md-pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 md-mb-30">
                    <div class="img-part js-tilt">
                        <img src="{{ asset('storage/'. getAboutSetting('about_background_image')) }}" alt="images">
                    </div>
                </div>
                <div class="col-lg-6 pl-65 md-pl-15 col-md-12">
                    <div class="sec-title2">
                        <div class="sub-title">
                            About us
                        </div>
                        <h2 class="title purple-color mb-30">{{ getAboutSetting('about_heading') }}</h2>
                        <p class="desc mb-45">
                            {{ getAboutSetting('about_description') }}
                        </p>
                    </div>
                    <div class="btn-part">
                        <a class="readon purple-btn" href="{{ url('/about') }}">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @registrationLinkEnabled
        <div class="rs-cta  style2 gray-bg3 pt-100 pb-100 md-pt-70 md-pb-70">
                <div class=" wow fadeInUp" data-wow-delay="300ms" data-wow-duration="2000ms">
                <div class="content  text-center">
                    <div class="sec-title2 mb-40 ">
                        <div class="sub-title purple-color">{{ application('name')}} Admission</div>
                        <h2 class="title purple-color">Admission Open for {{ date('Y') }}</h2>
                        <div class="desc purple-color">
                            {{ getAboutSetting('admission_description') }}
                        </div>
                    </div>
                    <div class="btn-part">
                        <a class="readon purple-color" href="{{ url('registration') }}">Contact Now</a>
                    </div>
                </div>
            </div>
        </div>
    @endregistrationLinkEnabled

    <div class="why-choose-us style2 gray-bg3 pt-100 pb-100 md-pt-70 md-pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 order-last">
                    <div class="video-wrap md-mb-40">
                        <img src="{{ asset('storage/'. getAboutSetting('choose_background_image')) }}" alt="">
                        <a class="popup-videos" href="{{ getAboutSetting('choose_link') }}">
                            <i class="fa fa-play"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="sec-title2 mb-40">
                        <div class="sub-title">Specialty</div>
                        <h2 class="title purple-color">{{ getAboutSetting('choose_title') }}</h2>
                        <div class="desc pr-124 md-pr-15">{{ getAboutSetting('choose_description') }}</div>
                    </div>
                    <div class="facilities-two">
                        <div class="row">
                            @foreach (convertStringToArray(getAboutSetting('choose_options')) as $option)
                                <div class="col-lg-6 mb-40 md-mb-25 col-md-6">
                                    <div class="content-part">
                                        <div class="icon-part purple-bg">
                                        <img src="{{ asset('frontend/images/choose/icons/2.png') }}" alt="">
                                        </div>
                                        <div class="text-part">
                                        <h4 class="title">{{ $option }}</h4> 
                                        </div>  
                                    </div>
                                </div> 
                            @endforeach
                        </div>
                    </div> 
                </div> 
            </div> 
        </div>
    </div>

    @if (count($parent_reviews) > 0)
        <div class="rs-testimonial home11-style pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="sec-title2 text-center mb-40">
                    <div class="sub-title">Testimonials</div>
                    <h2 class="title purple-color">Our Happy Parents</h2>
                </div>
                    <div class="rs-carousel owl-carousel" data-loop="true" data-items="2" data-margin="30" data-autoplay="true" data-autoplay-timeout="7000" data-smart-speed="2000" data-dots="true" data-nav="false" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="false" data-ipad-device="1" data-ipad-device-nav="false" data-ipad-device-dots="true" data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-md-device="2" data-md-device-nav="false" data-md-device-dots="true">
                    @foreach($parent_reviews as $review)
                        <div class="testi-item">
                            <div class="row">
                                <div class="col-lg-4 md-mb-30 col-md-4">
                                    <div class="user-img">
                                        <img src="{{ asset('storage/'.$review->image()) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8">
                                    <div class="user-info">
                                        <div class="desc">{{ $review->description() }}</div>
                                        <a class="name" href="#">{{ $review->name() }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    
    <div class="rs-gallery home11-style pt-100 md-pt-70 pb-100 md-pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 md-mb-30">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <img src="{{ asset('storage/'.getAboutSetting('home_gallery_image')) }}" alt="">
                                <div class="content-part">
                                    <h2 class="title">Our Gallery</h2>
                                </div>
                            <div class="gallery-info">
                                <h2 class="title-part">Our Gallery</h2>
                                <p>
                                    {{ getAboutSetting('home_gallery_description') }}
                                </p>
                                <div class="btn-part">
                                    <a href="{{ url('gallery') }}">View All<i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-4 md-mb-30">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <img src="{{ asset('storage/'.getAboutSetting('home_timetable_image')) }}" alt="">
                                <div class="content-part">
                                    <h2 class="title">Timetable</h2>
                                </div>
                            <div class="gallery-info">
                                <h2 class="title-part">Timetable</h2>
                                <p>
                                   {{ getAboutSetting('home_timetable_description') }}
                                </p>
                                <div class="btn-part">
                                    <a href="{{ route('timetable.index') }}">View All<i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-4">
                    <div class="gallery-part">
                        <div class="gallery-img">
                            <img src="{{ asset('frontend/'. getAboutSetting('home_tuition_image')) }}" alt="">
                                <div class="content-part">
                                    <h2 class="title">Tuition Fee</h2>
                                </div>
                            <div class="gallery-info">
                                <h2 class="title-part">Tuition Fee</h2>
                                <p>
                                   {{ getAboutSetting('home_tuition_description') }}
                                </p>
                                <div class="btn-part">
                                    <a href="{{ route('student.fees') }}">View All<i class="flaticon-right-arrow"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
