<x-base-layout>
    
    <section class="slider_area slider-active">
        <div class="single_slider bg_cover d-flex align-items-center" style="background-image: url({{ asset('storage/' . banner('wide_banner')) }})">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="slider_content text-center">
                            <h4 class="sub_title" data-animation="fadeInUp" data-delay="0.2s">{{ banner('sub_title') }} </h4>
                            <h2 class="main_title" data-animation="fadeInUp" data-delay="0.5s">{{ banner('title') }}</h2>
                            <p data-animation="fadeInUp" data-delay="0.8s">{{ banner('description') }}</p>
                            <a class="main-btn" href="#" data-animation="fadeInUp" data-delay="1.1s">{{ banner('button_text') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features_area ">
        <div class="container">
            <div class="features_wrapper">
                <div class="row no-gutters">
                    <div class="col-md-4 features_col">
                        <div class="single_features text-center">
                            <div class="features_icon">
                                <img src="{{ asset('frontend/images/f-icon-1.png') }}" alt="Icon">
                            </div>
                            <div class="features_content">
                                <h4 class="features_title"><a href="#">{{ banner('feature_one_title') }}</a></h4>
                                <p>{{ banner('feature_one') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 features_col">
                        <div class="single_features text-center">
                            <div class="features_icon">
                                <img src="{{ asset('frontend/images/f-icon-2.png') }}" alt="Icon">
                            </div>
                            <div class="features_content">
                                <h4 class="features_title"><a href="#">{{ banner('feature_two_title') }}</a></h4>
                                <p>{{ banner('feature_two') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 features_col">
                        <div class="single_features text-center">
                            <div class="features_icon">
                                <img src="{{ asset('frontend/images/f-icon-3.png') }}" alt="Icon">
                            </div>
                            <div class="features_content">
                                <h4 class="features_title"><a href="#">{{ banner('feature_three_title') }}</a></h4>
                                <p>{{ banner('feature_three') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about_area pt-80">
        <img class="shap_1" src="{{ asset('frontend/images/shape/shape-1.png') }}" alt="shape">
        <img class="shap_2" src="{{ asset('frontend/images/shape/shape-2.png') }}" alt="shape">
        <img class="shap_3" src="{{ asset('frontend/images/shape/shape-3.png') }}" alt="shape">
        <img class="shap_4" src="{{ asset('frontend/images/shape/shape-4.png') }}" alt="shape">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about_content mt-45">
                        <h3 class="about_title">{{ about('title') }}</h3>
                        <p class="text">{{ about('description_one') }}</p>
                        <p>{{ about('description_two') }}</p>
                        <a href="#" class="main-btn">Learn More</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about_image mt-50">
                        <img src="{{ asset('storage/'. about('big_image')) }}" alt="about" class="about_image-1">
                        <img src="{{ asset('storage/'. about('small_image_one')) }}" alt="about" class="about_image-2">
                        <img src="{{ asset('storage/'. about('small_image_two')) }}" alt="about" class="about_image-3">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- @php
        $classes = \App\Models\Grade::all();
        $students = \App\Models\Student::all();
        $teachers = \App\Models\user::whereType(3)->get();
    @endphp

    <section class="counter_area pt-10 pb-60">
        <div class="container">
            <div class="row counter_wrapper">
                <div class="col-lg-3 col-sm-6 counter_col">
                    <div class="single_counter text-center mt-50">
                        <div class="counter_icon">
                            <div class="icon_wrapper">
                                <img src="{{ asset('frontend/images/count_icon-1.png') }}" alt="Icon">
                            </div>
                        </div>
                        <div class="counter_content">
                            <span class="cont"><span class="counter">{{ $classes->count() ?? 0 }}</span>+</span>
                            <p>Subjects</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 counter_col">
                    <div class="single_counter text-center mt-50">
                        <div class="counter_icon">
                            <div class="icon_wrapper">
                                <img src="{{ asset('frontend/images/count_icon-2.png') }}" alt="Icon">
                            </div>
                        </div>
                        <div class="counter_content">
                            <span class="cont"><span class="counter">{{ $students->count() ?? 0 }}</span>k+</span>
                            <p>Total Students</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 counter_col">
                    <div class="single_counter text-center mt-50">
                        <div class="counter_icon">
                            <div class="icon_wrapper">
                                <img src="{{ asset('frontend/images/count_icon-2.png') }}" alt="Icon">
                            </div>
                        </div>
                        <div class="counter_content">
                            <span class="cont"><span class="counter">{{ $teachers->count() ?? 0 }}</span>k</span>
                            <p>Total Teachers</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 counter_col">
                    <div class="single_counter text-center mt-50">
                        <div class="counter_icon">
                            <div class="icon_wrapper">
                                <img src="{{ asset('frontend/images/count_icon-4.png') }}" alt="Icon">
                            </div>
                        </div>
                        <div class="counter_content">
                            <span class="cont"><span class="counter">15</span></span>
                            <p>Awards won</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="counter_area pb-10">
         <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <div class="about_certified mt-45">
                        <h4 class="title">{{ application('slogan') }}</h4>
                        <p>{{ application('description') }}</p>
                        <span><img src="{{ asset('frontend/images/call-3.png') }}" alt="call">  {{ application('line1') }}</span>
                    </div> 
                </div>
                <div class="col-lg-9">
                    <div class="about_welcome mt-50">
                        <div class="welcome_circle">
                            <h4 class="circle_title">{{ application('name') }}</h4>
                        </div>
                        <div class="welcome_info">
                            <div class="info_time">
                                <div class="info_wrapper d-flex">
                                    <div class="info_icon">
                                        <img src="{{ asset('frontend/images/clock.png') }}" alt="clock">
                                    </div>
                                    <div class="info_content media-body">
                                        <h5 class="info_title">7:00AM  -  05:00 PM</h5>
                                        <p>Monday - Friday</p>
                                    </div>
                                </div>
                            </div>
                            <div class="info_location">
                                <div class="info_wrapper d-flex">
                                    <div class="info_icon">
                                        <img src="{{ asset('frontend/images/location.png') }}" alt="location">
                                    </div>
                                    <div class="info_content media-body">
                                        <h5 class="info_title">{{ application('address') }}</h5>
                                        <p>School Address</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="why_choose_area pt-120" style="margin-bottom: 350px">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="why_choose_content">
                        <div class="section_title pb-20">
                            <h3 class="main_title">Why choose us?</h3>
                            <p>{{ application('description') }}</p>
                        </div>

                        @php
                            $chooses = \App\Models\Choose::all();
                        @endphp
                        <div class="row">
                            @foreach ($chooses as $choose)
                                <div class="col-sm-6 choose_col">
                                    <div class="single_choose mt-30">
                                        <div class="choose_icon">
                                            <img src="{{ asset('storage/' .$choose->logo) }}" alt="Icon">
                                        </div>
                                        <div class="choose_content">
                                            <h5 class="title"><a href="#">{{ $choose->topic }}</a></h5>
                                            <p>{{ $choose->intention }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="why_choose_image d-none d-lg-table">
            <div class="image">
                <img src="{{ asset('frontend/images/choose_bg.png') }}" alt="">
            </div>
        </div>
    </section>

    {{-- <section class="about_area_4 pt-80">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-8 col-sm-10">
                    <div class="about_image_4 mt-50">
                        <img src="{{ asset('frontend/images/about-6.jpg') }}" alt="about">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about_content_4">
                        <div class="section_title mt-40">
                            <h3 class="main_title">Make your  poor language skill high</h3>
                            <p>What do you think is better to receive after each lesson: a lovely looking badge or important skills you can immediately put into practice? We thought you might choose the latter.</p>
                        </div>
                        <a href="#" class="main-btn main-btn-2">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="blog_area pt-120 pb-130">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section_title text-center pb-20">
                        <h3 class="main_title">Top Teachers</h3>
                        <p>What do you think is better to receive after each lesson: a lovely looking badge or important skills you can immediately put into practice.</p>
                    </div>
                </div>
            </div>
            @php
                $teachers = \App\Models\User::whereType(3)->inRandomOrder()->limit(3)->get();
            @endphp
            <div class="row justify-content-center">
                @foreach ($teachers as $teacher)
                    <div class="col-lg-4 col-md-7">
                        <div class="single_blog mt-30">
                            <div class="blog_image">
                                <img src="{{ asset('storage/'.$teacher->image()) }}" alt="blog">
                            </div>
                            <div class="blog_content">
                                <span class="date"><span>{{ $teacher->title() }}</span></span>
                                
                                <div class="blog_content_wrapper">
                                    <ul class="blog_meta">
                                        <li><a href="#">{{ $teacher->name() }}</a></li>
                                        <li><a href="#">{{ $teacher->phone() }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section> --}}
</x-base-layout>
