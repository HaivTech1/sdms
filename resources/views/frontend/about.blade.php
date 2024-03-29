<x-base-layout>
    <x-slot name="header">
        <p>{{ $title }}</p>
    </x-slot>
    
     <div id="rs-about" class="rs-about style3 pt-100 md-pt-70">
        <div class="container">
            <div class="row y-middle">
                <div class="col-lg-4 lg-pr-0 md-mb-30">
                    <div class="about-intro">
                        <div class="sec-title">
                            <div class="sub-title orange">About Us</div>
                            <h2 class="title mb-21">{{ getAboutSetting('about_heading') }}</h2>
                            <div class="desc big">{{ getAboutSetting('about_description') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 pl-83 md-pl-15">
                    <div class="row rs-counter couter-area">
                        <div class="col-md-4 sm-mb-30">
                            <div class="counter-item one">
                                <img class="count-img" src="assets/images/about/style3/icons/1.png" alt="">
                                <h2 class="number rs-count kplus">{{ getAboutSetting('about_student_count')  }}</h2>
                                <h4 class="title mb-0">Students</h4>
                            </div>
                        </div>
                        <div class="col-md-4 sm-mb-30">
                            <div class="counter-item two">
                                <img class="count-img" src="assets/images/about/style3/icons/2.png" alt="">
                                <h2 class="number rs-count">{{ getAboutSetting('about_awards_count')  }}</h2>
                                <h4 class="title mb-0">Awards</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="counter-item three">
                                <img class="count-img" src="assets/images/about/style3/icons/3.png" alt="">
                                <h2 class="number rs-count kplus">{{ getAboutSetting('about_graduate_count')  }}</h2>
                                <h4 class="title mb-0">Graduates</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="rs-about-video" class="rs-about-video pt-100 pb-100 md-pt-70 md-pb-70">
        <div class="container">
            <div class="video-img-part media-icon orange-color2">
                <img src="{{ asset('storage/'.getAboutSetting('about_video_link_image')) }}" alt="{{ application('name') }}">
                <a class="popup-videos" href="{{ getAboutSetting('about_video_link') }}">
                    <i class="fa fa-play"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="rs-about style1 pt-100 pb-100 md-pt-70 md-pb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 padding-0 md-pl-15 md-pr-15 md-mb-30">
                    <div class="img-part">
                        <img class="" src="{{ asset('storage/'. getAboutSetting('about_background_image') ) }}" alt="About Image">
                    </div>
                    <ul class="nav nav-tabs histort-part" id="myTab" role="tablist">
                        <li class="nav-item tab-btns single-history">
                            <a class="nav-link tab-btn active" id="about-history-tab" data-toggle="tab" href="#about-history" role="tab" aria-controls="about-history" aria-selected="true"><span class="icon-part"><i class="flaticon-banknote"></i></span>History</a>
                        </li>
                        <li class="nav-item tab-btns single-history">
                            <a class="nav-link tab-btn" id="about-mission-tab" data-toggle="tab" href="#about-mission" role="tab" aria-controls="about-mission" aria-selected="false"><span class="icon-part"><i class="flaticon-flower"></i></span>Mission & Vission</a>
                        </li>
                        <li class="nav-item tab-btns single-history last-item">
                            <a class="nav-link tab-btn" id="about-admin-tab" data-toggle="tab" href="#about-admin" role="tab" aria-controls="about-admin" aria-selected="false"><span class="icon-part"><i class="flaticon-analysis"></i></span>Administration</a>
                        </li>
                    </ul>
                </div>
                <div class="offset-lg-1"></div>
                <div class="col-lg-5">
                    <div class="tab-content tabs-content" id="myTabContent">
                        <div class="tab-pane tab fade show active" id="about-history" role="tabpanel" aria-labelledby="about-history-tab">
                            <div class="sec-title mb-25">
                                <h2 class="title">{{ application('name') }} History</h2>
                                <div class="desc">{{ getAboutSetting('about_history') }}</div>
                            </div>
                            <div class="tab-img">
                                <img class="" src="{{ asset('storage/'. getAboutSetting('about_history_image') ) }}" alt="Tab Image">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="about-mission" role="tabpanel" aria-labelledby="about-mission-tab">
                            <div class="sec-title mb-25">
                                <h2 class="title">{{ application('name') }} Mission</h2>
                                <div class="desc">
                                    {!! getAboutSetting('about_mission_vision') !!}
                                </div>
                            </div>
                            <div class="tab-img">
                                <img class="" src="{{ asset('storage/'. getAboutSetting('about_mission_vision_image') ) }}" alt="Mission and vision Image">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="about-admin" role="tabpanel" aria-labelledby="about-admin-tab">
                            <div class="sec-title mb-25">
                                <h2 class="title">{{ application('name') }} Administration</h2>
                                <div class="desc">
                                    {!! getAboutSetting('about_administrative') !!}
                                </div>
                            </div>
                            <div class="tab-img">
                                <img class="" src="{{ asset('storage/'. getAboutSetting('about_administrative_image') ) }}" alt="Administrative Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Intro Info Tabs-->
            <div class="intro-info-tabs">
                
            </div>
        </div>
    </div>
</x-base-layout>