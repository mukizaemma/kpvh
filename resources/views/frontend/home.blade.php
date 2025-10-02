@extends('layouts.frontbase')

@section('content')


    <!--==============================
Hero Area
==============================-->
@include('frontend.includes.slide')

    <!--==============================
About Area  
==============================-->
    <div class="about-area position-relative overflow-hidden space-bottom mt-10" id="about-sec">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-6">
                    <div class="img-box10">
                        <div class="img1">
                            <img src="{{ asset('storage/images/about') . $about->image1 }}" alt="About">
                        </div>
                        {{-- <div class="about-shape2"></div> --}}
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class=" ps-xl-5">
                        <div class="title-area mb-20">
                            <h2 class="sec-title mb-20 heading">Your comfort, our commitment</h2>

                            <p class="sec-text mb-30">{!! $about->welcomeMessage !!}</p>
                        </div>

                        <div class="mt-35"><a href="{{ route('connect') }}" class="th-btn style3 th-icon">Book your Stay Now</a></div>
                    </div>
                </div>
            </div>
            <div class="shape-mockup about-shape movingX d-none d-xxl-block" data-bottom="0%" data-right="-11%">
                <img src="assets/img/normal/about-slide-img.png" alt="shape">
            </div>
            <div class="shape-mockup about-rating d-none d-xxl-block" data-bottom="50%" data-right="-20%">
                <i class="fa-sharp fa-solid fa-star"></i><span>4.9k</span>
            </div>
            <div class="shape-mockup about-emoji d-none d-xxl-block" data-bottom="25%" data-right="5%"><img src="assets/img/icon/emoji.png" alt="">
            </div>
            <div class="shape-mockup shape1 d-none d-xl-block" data-top="12%" data-left="-16%">
                <img src="assets/img/shape/shape_1.png" alt="shape">
            </div>
            <div class="shape-mockup shape2 d-none d-xl-block" data-top="20%" data-left="-16%">
                <img src="assets/img/shape/shape_2.png" alt="shape">
            </div>
            <div class="shape-mockup shape3 d-none d-xl-block" data-top="14%" data-left="-10%">
                <img src="assets/img/shape/shape_3.png" alt="shape">
            </div>
        </div>
        <div class="shape-mockup d-none d-xxl-block" data-bottom="15%" data-left="4%"><img src="assets/img/shape/car_2.png" alt="shape">
        </div>
    </div>

        <!--==============================
Rooms Area  
==============================-->

    <section class="tour-area position-relative bg-top-center overflow-hidden space" id="service-sec" data-bg-src="assets/img/bg/tour_bg_1.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="title-area text-center">
                        <h2 class="sec-title">Our Rooms</h2>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade active show" id="nav-step1" role="tabpanel">
                <div class="slider-area tour-slider slider-drag-wrap">
                    <div class="swiper th-slider has-shadow"
                        data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"},"1400":{"slidesPerView":"4"}}}'>
                        
                        <div class="swiper-wrapper">
                            @foreach($rooms as $room)
                                <div class="swiper-slide">
                                    <div class="tour-box th-ani gsap-cursor">
                                        <div class="tour-box_img global-img">
                                            <img src="{{ asset('storage/images/rooms/' . $room->image) }}" alt="{{ $room->title }}" height="200px">
                                        </div>
                                        <div class="tour-content">
                                            <h3 class="box-title">
                                                <a href="{{ route('rooms', $room->id) }}">{{ $room->title }}</a>
                                            </h3>

                                            {{-- <p class="text-sm text-gray-600 mb-2">
                                                {!! \Illuminate\Support\Str::limit($room->description, 100) !!}
                                            </p> --}}

                                            <h4 class="tour-box_price">
                                                <span class="currency">${{ number_format($room->price, 2) }}</span>/Night
                                            </h4>

                                            <div class="tour-action">
                                                <span><i class="fa-light fa-bed"></i> {{ $room->beds ?? '1' }} Beds</span>
                                                <a href="{{ route('rooms', $room->id) }}" class="th-btn style4 th-icon">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="slider-pagination"></div>
                    </div>
                </div>

                </div>

            </div>
        </div>
    </section>
    <div class=" space-bottom">
        <div class="container">
            <div class="row gy-4 align-items-center flex-row-reverse">
                <div class="col-lg-6">
                    <div class="ps-xl-5">
                        <div class="title-area">
                            <h2 class="sec-title">Why Choose Us</h2>
                        </div>

                        <!-- Prime Location -->
                        <div class="choose-about style2 hover-item item-active">
                            <div class="media-body">
                                <h3 class="box-title">Prime Location</h3>
                                <p class="choose-about_text">
                                    Situated at the entrance of Gisenyi, just steps from Lake Kivu and minutes
                                    from the Goma border, our hotel offers both convenience and stunning surroundings.
                                </p>
                            </div>
                        </div>

                        <!-- Variety of Comfortable Rooms -->
                        <div class="choose-about style2 hover-item">
                            <div class="media-body">
                                <h3 class="box-title">Variety of Comfortable Rooms</h3>
                                <p class="choose-about_text">
                                    From single rooms to family apartments, we provide tailored accommodation
                                    options for solo travelers, couples, families, and groups.
                                </p>
                            </div>
                        </div>

                        <!-- Exceptional Hospitality -->
                        <div class="choose-about style2 hover-item">
                            <div class="media-body">
                                <h3 class="box-title">Exceptional Hospitality</h3>
                                <p class="choose-about_text">
                                    Our friendly staff is committed to personalized service, ensuring your stay
                                    is enjoyable from check-in to check-out.
                                </p>
                            </div>
                        </div>

                        <!-- Business & Events Friendly -->
                        <div class="choose-about style2 hover-item">
                            <div class="media-body">
                                <h3 class="box-title">Business & Events Friendly</h3>
                                <p class="choose-about_text">
                                    With well-equipped meeting rooms and professional service, we’re the ideal
                                    choice for workshops, conferences, or private events.
                                </p>
                            </div>
                        </div>

                        <!-- Flexible Services -->
                        <div class="choose-about style2 hover-item">

                            <div class="media-body">
                                <h3 class="box-title">Flexible Services</h3>
                                <p class="choose-about_text">
                                    We go beyond accommodation by offering outside catering, event support,
                                    and transport assistance for your convenience.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="img-box11">
                        <div class="img1">
                            <img src="{{ asset('storage/images/about') . $about->image2 }}" alt="About">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


        <!--==============================
Facilities Area  
==============================-->

    <section class="position-relative bg-smoke overflow-hidden space" id="destination-sec">
        <div class="container">
            <div class="title-area text-center text-xl-start">
                <h2 class="sec-title">Our Special Services</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"},"1300":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        @foreach ($facilities as $facility)
                        <div class="swiper-slide">
                            <div class="destination-item4 th-ani">
                                <div class="destination-item4_img global-img" data-mask-src="assets/img/destination/shape.png">
                                    <img src="{{ asset('storage/images/facilities/' . $facility->image) }}" alt="image">
                                </div>
                                <div class="destination-content">
                                    <h3 class="box-title"><a href="{{ route('facility',['slug'=>$facility->slug]) }}"><img src="assets/img/icon/location-dot4.svg" alt="">{{ $facility->title }}</a></h3>
                                </div>
                                <a href="{{ route('facility',['slug'=>$facility->slug]) }}" class="icon-btn"><img src="assets/img/icon/left-arrow4.svg" alt=""></a>
                            </div>
                        </div>
                        @endforeach



                    </div>
                </div>
            </div>
            <div class="destination-btn text-center mt-60">
                <a href="{{ route('facilities') }}" class="th-btn style3 th-icon">View All</a>
            </div>
            <div class="shape-mockup movingX d-none d-xl-block" data-top="8%" data-left="-15%">
                <img src="assets/img/shape/shape_2_1.png" alt="shape">
            </div>
            <div class="shape-mockup jump d-none d-xl-block" data-top="23%" data-right="-14%">
                <img src="assets/img/shape/shape_2_2.png" alt="shape">
            </div>
            <div class="shape-mockup spin d-none d-xl-block" data-bottom="21%" data-left="-14%">
                <img src="assets/img/shape/shape_2_3.png" alt="shape">
            </div>
            <div class="shape-mockup movingX d-none d-xl-block" data-bottom="12%" data-right="-14%">
                <img src="assets/img/shape/shape_2_4.png" alt="shape">
            </div>
        </div>

    </section>

        <!--==============================
Blog Area  
==============================-->
    <section class=" overflow-hidden space" id="blog-sec">
        <div class="container">
            <div class="mb-30 text-center text-md-start">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-7">
                        <div class="title-area mb-md-0">
                            <h2 class="sec-title">Blog and Updates</h2>
                        </div>
                    </div>
                    <div class="col-md-auto">
                        <a href="{{ route('blogs') }}" class="th-btn style4 th-icon">See More Articles</a>
                    </div>
                </div>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow" id="blogSlider6" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
                    <div class="swiper-wrapper">

                        @foreach ($blogs as $blog)
                            <div class="swiper-slide">
                                <div class="blog-box style2 th-ani">
                                    <div class="blog-img global-img">
                                        <img src="{{ asset('storage/images/blogs/' . $blog->image) }}" alt="{{ $blog->title }}">
                                    </div>
                                    <div class="blog-box_content">
                                        <div class="blog-meta">
                                            <a class="author" href="{{ route('singleBlog',['slug'=>$blog->slug]) }}">
                                                {{ $blog->created_at->format('M d Y') }}
                                            </a>
                                            <a href="{{ route('singleBlog',['slug'=>$blog->slug]) }}">
                                                {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read
                                            </a>
                                        </div>
                                        <h3 class="box-title">
                                            <a href="{{ route('singleBlog',['slug'=>$blog->slug]) }}">{{ $blog->title }}</a>
                                        </h3>
                                        <a href="{{ route('singleBlog',['slug'=>$blog->slug]) }}" class="th-btn style4 th-icon">Read More</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach



                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection