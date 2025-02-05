@extends('frontend_new.layouts.app')

@section('styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <style>
        .select2-container--default .select2-selection--multiple {
            border: none !important;
            background: transparent;
            padding: 0 !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field input::placeholder {
            font-size: 22px;
            font-weight: 500;
            color: #2a2a2a;
            vertical-align: middle;
            font-family: 'Barlow', sans-serif;
            cursor: pointer;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            height: auto;
            padding: 0 !important;
            padding-left: 5px !important;
            font-size: 16px;
            font-weight: 500;
            color: #2a2a2a;
            vertical-align: middle;
            border-radius: 0;
            box-shadow: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            transition: .3s ease-in-out;
            border: none;
            font-family: 'Barlow', sans-serif;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
            width: auto
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
            border: 0;
            background: none;
            font-size: 16px;
            font-weight: 500;
            color: #2a2a2a !important;
            font-family: 'Barlow', sans-serif;
            cursor: pointer;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered li span {
            display: none;
        }

        .blog-item::before {
            opacity: 1;
        }

        .slider-area {
            position: relative;
        }

        .booking-area {
            margin-top: 0;
        }

        #loader {
            border: 16px solid #f3f3f3;
            /* Light grey */
            border-top: 16px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            display: none;
            /* Initially hide the loader */
            position: absolute;
            top: 50%;
            left: 50%;
            margin-left: -60px;
            /* Half of width */
            margin-top: -60px;
            backdrop-filter: blur(10px);
            /* Half of height */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endsection

@section('content')
    <!-- slider-area -->
    <section class="slider-area">
        <!-- booking-area -->
        <div class="booking-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="booking-wrap">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="bOOKing-tab" data-bs-toggle="tab"
                                        data-bs-target="#bOOKing-tab-pane" type="button" role="tab"
                                        aria-controls="bOOKing-tab-pane" aria-selected="true"><i
                                            class="flaticon-flight"></i>Flights</button>
                                </li>
                                <li class="nav-item d-none" role="presentation" style="display: none;">
                                    <button class="nav-link" id="trips-tab" data-bs-toggle="tab"
                                        data-bs-target="#trips-tab-pane" type="button" role="tab"
                                        aria-controls="trips-tab-pane" aria-selected="false"><i class="flaticon-file"></i>
                                        Hotels (Coming Soon)</button>
                                </li>
                                <li class="nav-item d-none" role="presentation">
                                    <button class="nav-link" id="check-tab" data-bs-toggle="tab"
                                        data-bs-target="#check-tab-pane" type="button" role="tab"
                                        aria-controls="check-tab-pane" aria-selected="false"><i class="flaticon-tick"></i>
                                        check-in</button>
                                </li>
                                <li class="nav-item d-none" role="presentation">
                                    <button class="nav-link" id="flight-tab" data-bs-toggle="tab"
                                        data-bs-target="#flight-tab-pane" type="button" role="tab"
                                        aria-controls="flight-tab-pane" aria-selected="false"><i class="flaticon-clock"></i>
                                        Flight status</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="bOOKing-tab-pane" role="tabpanel"
                                    aria-labelledby="bOOKing-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="tab-content-wrap">
                                                <div class="content-top">
                                                    <ul>
                                                        <li>Search Cheap Flights World Wide</li>
                                                        {{--                                                    <li><span>Just from $12</span>Geair Stopover</li> --}}
                                                    </ul>
                                                </div>
                                                <form action="{{ route('flightResultsNew') }}" method="get"
                                                    id="getFlightForm" class="booking-form ifblur">
                                                    <ul>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByDep">FLYING FROM (Depart From)</label>
                                                                <select id="departure_airport_id"
                                                                    name="departure_airport_id"
                                                                    class="w-100 form-select js-example-basic-single ui-autocomplete-input"
                                                                    aria-label="Default select example" required multiple>
                                                                    @foreach ($airports as $airport)
                                                                        <option value="{{ $airport->id }}">
                                                                            {{ $airport->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </li>
                                                        
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByDes">FLYING TO (Destination)</label>
                                                                <select id="destination_airport_id"
                                                                    name="destination_airport_id"
                                                                    class="form-select js-example-basic-single ui-autocomplete-input"
                                                                    aria-label="Default select example" required multiple>
                                                                    @foreach ($airports as $airport)
                                                                        <option value="{{ $airport->id }}" @if(!empty($flight) && $airport->id == $flight->airport_id) selected @endif>
                                                                            {{ $airport->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByChange">Trip</label>
                                                                <select id="shortByChange" name="ticket_type"
                                                                    class="form-select" aria-label="Default select example"
                                                                    required>
                                                                    <option value="return">Round Trip</option>
                                                                    <option value="one-way">One Way</option>
                                                                </select>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp date">
                                                                <ul>
                                                                    <li>
                                                                        <label for="shortByDepart">Depart</label>
                                                                        <input class="" name="departure_date"
                                                                            type="text" placeholder="Departing Date"
                                                                            id="datepicker" autocomplete="off"
                                                                            {{-- onfocus="this.showPicker()" onclick="this.showPicker()" --}} required=""
                                                                            {{-- value="{{ date('Y-m-d') }}" --}}>
                                                                    </li>
                                                                    <li id="returnDateContainer">
                                                                        <label for="shortByReturn">Return</label>
                                                                        <input class="" name="return_date"
                                                                            type="text" placeholder="Returning Date"
                                                                            id="datepicker1" autocomplete="off"
                                                                            {{-- onfocus="this.showPicker()" onclick="this.showPicker()" --}} {{-- value="{{ date('Y-m-d', strtotime('+3 days')) }}" --}}
                                                                            required="">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByPass">Passengers (Adults)</label>
                                                                <select id="shortByPass" name="adult" class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="1">One Adult</option>
                                                                    <option value="2">Two Adults</option>
                                                                    <option value="3">Three Adults</option>
                                                                    <option value="4">Four Adults</option>
                                                                    <option value="5">Five Adults</option>
                                                                    <option value="6">Six Adults</option>
                                                                    <option value="7">Seven Adults</option>
                                                                    <option value="8">Eight Adults</option>
                                                                    <option value="9">Nine Adults</option>
                                                                    <option value="10">Ten Adults</option>
                                                                </select>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <ul>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <input type="text" placeholder="Name"  name="name"
                                                                    required>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp">
                                                                <input type="text" placeholder="Phone" type="tel"
                                                                    minlength="11" maxlength="11" name="phone"
                                                                    required>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp">
                                                                <input type="email" placeholder="Email" name="email"
                                                                    required>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByChil">Children</label>
                                                                <select id="shortByChil" name="child" class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="0">No Child</option>
                                                                    <option value="1">One Child</option>
                                                                    <option value="2">Two Children</option>
                                                                    <option value="3">Three Children</option>
                                                                    <option value="4">Four Children</option>
                                                                    <option value="5">Five Children</option>
                                                                    <option value="6">Six Children</option>
                                                                    <option value="7">Seven Children</option>
                                                                    <option value="8">Eight Children</option>
                                                                    <option value="9">Nine Children</option>
                                                                    <option value="10">Ten Children</option>
                                                                </select>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByInfant">Infants</label>
                                                                <select id="shortByInfant" name="infant" class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="0">No Infant</option>
                                                                    <option value="1">One Infant</option>
                                                                    <option value="2">Two Infants</option>
                                                                    <option value="3">Three Infants</option>
                                                                    <option value="4">Four Infants</option>
                                                                    <option value="5">Five Infants</option>
                                                                    <option value="6">Six Infants</option>
                                                                    <option value="7">Seven Infants</option>
                                                                    <option value="8">Eight Infants</option>
                                                                    <option value="9">Nine Infants</option>
                                                                    <option value="10">Ten Infants</option>
                                                                </select>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </form>
                                                <div class="content-bottom">
                                                    <button type="submit" class="btn" form="getFlightForm"
                                                        id="submitButtonForm">Show Flights <i
                                                            class="flaticon-flight-1"></i></button>
                                                    <div id="loader"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="trips-tab-pane" role="tabpanel"
                                    aria-labelledby="trips-tab" tabindex="0">
                                </div>
                                <div class="tab-pane fade d-none" id="check-tab-pane" role="tabpanel"
                                    aria-labelledby="check-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="tab-content-wrap">
                                                <div class="content-top">
                                                    <ul>
                                                        <li>Flights</li>
                                                        <li><span>Just from $12</span>Geair Stopover</li>
                                                    </ul>
                                                </div>
                                                <form action="#" class="booking-form">
                                                    <ul>
                                                        <li>
                                                            <div class="form-grp">
                                                                <input type="text" placeholder="From">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp">
                                                                <input type="text" placeholder="To">
                                                                <button class="exchange-icon"><i
                                                                        class="flaticon-exchange-1"></i></button>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByThree">Trip</label>
                                                                <select id="shortByThree" name="select"
                                                                    class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="">Tour type</option>
                                                                    <option>Adventure Travel</option>
                                                                    <option>Family Tours</option>
                                                                    <option>Newest Item</option>
                                                                    <option>Nature & wildlife</option>
                                                                </select>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp date">
                                                                <ul>
                                                                    <li>
                                                                        <label for="shortBy">Depart</label>
                                                                        <input type="text" class="date"
                                                                            placeholder="Select Date">
                                                                    </li>
                                                                    <li>
                                                                        <label for="shortBy">Return</label>
                                                                        <input type="text" class="date"
                                                                            placeholder="Select Date">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp economy">
                                                                <label for="textThree">Passenger/ Class</label>
                                                                <input type="text" id="textThree"
                                                                    placeholder="1 Passenger, Economy">
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </form>
                                                <div class="content-bottom">
                                                    <a href="booking-details.html" class="promo-code">+ Add Promo code</a>
                                                    <a href="booking-details.html" class="btn">Show Flights <i
                                                            class="flaticon-flight-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade d-none" id="flight-tab-pane" role="tabpanel"
                                    aria-labelledby="flight-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="tab-content-wrap">
                                                <div class="content-top">
                                                    <ul>
                                                        <li>Flights</li>
                                                        <li><span>Just from $12</span>Geair Stopover</li>
                                                    </ul>
                                                </div>
                                                <form action="#" class="booking-form">
                                                    <ul>
                                                        <li>
                                                            <div class="form-grp">
                                                                <input type="text" placeholder="From">
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp">
                                                                <input type="text" placeholder="To">
                                                                <button class="exchange-icon"><i
                                                                        class="flaticon-exchange-1"></i></button>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp select">
                                                                <label for="shortByFour">Trip</label>
                                                                <select id="shortByFour" name="select"
                                                                    class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="">Tour type</option>
                                                                    <option>Adventure Travel</option>
                                                                    <option>Family Tours</option>
                                                                    <option>Newest Item</option>
                                                                    <option>Nature & wildlife</option>
                                                                </select>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp date">
                                                                <ul>
                                                                    <li>
                                                                        <label for="shortBy">Depart</label>
                                                                        <input type="text" class="date"
                                                                            placeholder="Select Date">
                                                                    </li>
                                                                    <li>
                                                                        <label for="shortBy">Return</label>
                                                                        <input type="text" class="date"
                                                                            placeholder="Select Date">
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="form-grp economy">
                                                                <label for="textFour">Passenger/ Class</label>
                                                                <input type="text" id="textFour"
                                                                    placeholder="1 Passenger, Economy">
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </form>
                                                <div class="content-bottom">
                                                    <a href="booking-details.html" class="promo-code">+ Add Promo code</a>
                                                    <a href="booking-details.html" class="btn">Show Flights <i
                                                            class="flaticon-flight-1"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- booking-area-end -->
        <div class="slider-active d-none">
            <div class="single-slider slider-bg" data-background="frontend_assets_new/img/slider/slider_bg01.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-10">
                            <div class="slider-content d-none">
                                <h2 class="title" data-animation="fadeInUp" data-delay=".2s">A Lifetime of Discounts?
                                    It's Genius.</h2>
                                <p data-animation="fadeInUp" data-delay=".4s">Get rewarded for your travels – unlock
                                    instant savings of 10% or more with a free Geairinfo.com account</p>
                                <a href="{{ route('new.contact') }}" class="btn" data-animation="fadeInUp"
                                    data-delay=".6s">Sign in / Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider slider-bg" data-background="frontend_assets_new/img/slider/slider_bg02.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-10">
                            <div class="slider-content d-none">
                                <h2 class="title" data-animation="fadeInUp" data-delay=".2s">A Lifetime of Discounts?
                                    It's Genius.</h2>
                                <p data-animation="fadeInUp" data-delay=".4s">Get rewarded for your travels – unlock
                                    instant savings of 10% or more with a free Geairinfo.com account</p>
                                <a href="{{ route('new.contact') }}" class="btn" data-animation="fadeInUp"
                                    data-delay=".6s">Sign in / Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single-slider slider-bg" data-background="frontend_assets_new/img/slider/slider_bg03.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-8 col-lg-10">
                            <div class="slider-content d-none">
                                <h2 class="title" data-animation="fadeInUp" data-delay=".2s">A Lifetime of Discounts?
                                    It's Genius.</h2>
                                <p data-animation="fadeInUp" data-delay=".4s">Get rewarded for your travels – unlock
                                    instant savings of 10% or more with a free Geairinfo.com account</p>
                                <a href="{{ route('new.contact') }}" class="btn" data-animation="fadeInUp"
                                    data-delay=".6s">Sign in / Register</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- slider-area-end -->



    <!-- features-area -->
    <section class="features-area d-none">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-6 col-sm-10 mb-3">
                    <div class="features-item d-block">
                        <div class="features-icon  mb-3">
                            <i class="flaticon-help"></i>
                        </div>
                        <div class="features-content">
                            <h6 class="title">THE PREMIUM COMPANY</h6>
                            <p>GALAXY TRAVEL AND TOURS is a premium company and the key player in online
                                booking of
                                flights - serving the customers with useful tips, traveling information, and the best
                                airline travel
                                deals.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-10 mb-3">
                    <div class="features-item  d-block">
                        <div class="features-icon mb-3">
                            <i class="flaticon-plane"></i>
                        </div>
                        <div class="features-content">
                            <h6 class="title">ONE-STOP-SHOP FOR YOUR TRAVEL NEEDS</h6>
                            <p>We are fortunate to be called a one-stop-shop for all your travel needs.
                                Number of people all
                                around the world rely on our services to have the best travel deals and cheap international
                                Air
                                tickets around the globe.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-10 mb-3">
                    <div class="features-item  d-block">
                        <div class="features-icon mb-3">
                            <i class="flaticon-money-back-guarantee"></i>
                        </div>
                        <div class="features-content ">
                            <h6 class="title">HELPING YOU TO CREATE FANTASTIC HOLIDAY MOMENTS</h6>
                            <p>We are having a combination of both a world-wide network of partners and
                                the right set of
                                expertise to provide quality services and ensure an incredible holiday moment for you and
                                your
                                family.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-10 mb-3">
                    <div class="features-item d-block">
                        <div class="features-icon  mb-3">
                            <i class="flaticon-help"></i>
                        </div>
                        <div class="features-content">
                            <h6 class="title">LOW PRICE GUARANTEED</h6>
                            <p>Search for the lowest costs of International and National Air tickets to
                                your desired destinations.
                                Explore the globe for traveling here with the United Kingdom.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-10 mb-3">
                    <div class="features-item  d-block">
                        <div class="features-icon mb-3">
                            <i class="flaticon-plane"></i>
                        </div>
                        <div class="features-content">
                            <h6 class="title">CUSTOMER SERVICE SUPPORT</h6>
                            <p>We always prioritize the premium customer services. GALAXY TRAVEL AND
                                TOURS servers
                                remain active 24/7, and our customer agent responds to your queries at every instant of
                                time.</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6 col-sm-10 mb-3">
                    <div class="features-item  d-block">
                        <div class="features-icon mb-3">
                            <i class="flaticon-money-back-guarantee"></i>
                        </div>
                        <div class="features-content ">
                            <h6 class="title">HELPING YOU TO CREATE FANTASTIC HOLIDAY MOMENTS</h6>
                            <p>We are having a combination of both a world-wide network of partners and
                                the right set of
                                expertise to provide quality services and ensure an incredible holiday moment for you and
                                your
                                family.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- features-area-end -->

    @include('frontend_new.sections.top_designations')
    <!-- destination-area -->
     @include('frontend_new.sections.destination_area')
    <!-- destination-area-end -->

    <!-- fly-next-area -->
    <section class="fly-next-area d-none">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <span class="sub-title">Flynext Package</span>
                        <h2 class="title">Your Great Destination</h2>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="fly-next-nav">
                        <button class="active" data-filter="*">Flights <i class="flaticon-flight"></i></button>
                        <button class="" data-filter=".cat-one">Car Rentals <i class="flaticon-car-1"></i></button>
                        <button class="" data-filter=".cat-two">Taxis <i class="flaticon-taxi"></i></button>
                    </div>
                </div>
            </div>
            <div class="row fly-next-active justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-two">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img01.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Dubai (DXB)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon01.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Economy from</p>
                                <h4 class="price">$195</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-one cat-two">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img02.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Switzerland (SWL)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon02.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Business Class</p>
                                <h4 class="price">$800</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-two">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img03.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Denmark (DEK)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon03.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Economy from</p>
                                <h4 class="price">$ 350</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-one">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img04.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Jakarta (DXB)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon01.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Business Class</p>
                                <h4 class="price">$ 220</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-two">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img05.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Dubai (DXB)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon03.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Economy from</p>
                                <h4 class="price">$195</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-one">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img06.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Dubai (DXB)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon02.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Business Class</p>
                                <h4 class="price">$175</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-two cat-one">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img07.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Switzerland (SWL)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon01.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Economy from</p>
                                <h4 class="price">$195</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 grid-item grid-sizer cat-two">
                    <div class="fly-next-item">
                        <div class="fly-next-thumb">
                            <a href="booking-details.html"><img
                                    src="{{ asset('frontend_assets_new/img/images/fly_img08.jpg') }}" alt=""></a>
                        </div>
                        <div class="fly-next-content">
                            <span>09 Jun 2022 - 16 Jun 2022</span>
                            <h4 class="title">Turkish (SWL)</h4>
                            <a href="#" class="exchange-btn"><i class="flaticon-exchange-1"></i></a>
                            <h4 class="title">New York (USA)</h4>
                            <a href="booking-details.html" class="air-logo"><img
                                    src="{{ asset('frontend_assets_new/img/icon/fly_icon02.jpg') }}" alt=""></a>
                            <div class="content-bottom">
                                <p>Business Class</p>
                                <h4 class="price">$350</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- fly-next-area-end -->

    <!-- brand-area -->
    <div class="brand-area brand-bg">
        <div class="container">
            <div class="row brand-active">
                <div class="col-12">
                    <div class="brand-item">
                        <img src="{{ asset('frontend_assets_new/img/brand/brand_img01.png') }}" alt="">
                    </div>
                </div>
                <div class="col-12">
                    <div class="brand-item">
                        <img src="{{ asset('frontend_assets_new/img/brand/brand_img02.png') }}" alt="">
                    </div>
                </div>
                <div class="col-12">
                    <div class="brand-item">
                        <img src="{{ asset('frontend_assets_new/img/brand/brand_img03.png') }}" alt="">
                    </div>
                </div>
                <div class="col-12">
                    <div class="brand-item">
                        <img src="{{ asset('frontend_assets_new/img/brand/brand_img04.png') }}" alt="">
                    </div>
                </div>
                <div class="col-12">
                    <div class="brand-item">
                        <img src="{{ asset('frontend_assets_new/img/brand/brand_img05.png') }}" alt="">
                    </div>
                </div>
                <div class="col-12">
                    <div class="brand-item">
                        <img src="{{ asset('frontend_assets_new/img/brand/brand_img06.png') }}" alt="">
                    </div>
                </div>
                <div class="col-12">
                    <div class="brand-item">
                        <img src="{{ asset('frontend_assets_new/img/brand/brand_img03.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- brand-area-end -->

    @include('frontend_new.sections.services')

    <!-- blog-area -->
    <section class="blog-area blog-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <span class="sub-title">Hajj & Umrah</span>
                        <h2 class="title">Embark on a Sacred Journey: Discover Hajj and Umrah with Galaxy Travel and Tours
                        </h2>
                        <p>Galaxy Travel and Tours is honored to offer you the opportunity to embark on a profound spiritual
                            pilgrimage with our meticulously crafted Hajj and Umrah packages. As pioneers in Islamic travel
                            services, we understand the importance of these sacred journeys in the lives of Muslims
                            worldwide. Our dedicated team ensures that every aspect of your pilgrimage is meticulously
                            planned, allowing you to focus solely on the spiritual essence of the experience.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="blog-item">
                        <div class="blog-thumb">
                            <a href="blog-details.html"><img class="w-100"
                                    src="{{ asset('frontend_assets_new/img/images/hajj.jpg') }}" alt=""></a>
                        </div>
                        <div class="blog-content text-center w-100">
                            <h2 class="title text-center mb-2"><a href="blog-details.html">Journey to the Heart of
                                    Islam</a></h2>
                            <p class="text-white responsive7px">Join us as we facilitate your connection with the holy sites of Islam,
                                guiding you through the rituals and traditions with utmost care and reverence. At Galaxy
                                Travel and Tours, we're committed to ensuring your pilgrimage is a transformative and deeply
                                fulfilling experience, leaving you with cherished memories and a strengthened connection to
                                your faith. Begin your sacred journey today with Galaxy Travel and Tours, where spirituality
                                meets seamless travel expertise.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-area-end -->
@endsection


@section('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#departure_airport_id').select2({
                placeholder: 'From',
                maximumSelectionLength: 1
            });
            $('#destination_airport_id').select2({
                placeholder: 'To',
                maximumSelectionLength: 1
            });


        });
       
    </script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

    <script>
        // $(function () {
        //     $("#datepicker").datepicker({
        //         changeMonth: true,
        //         changeYear: true,
        //         numberOfMonths: 1,
        //         minDate:0,
        //         onSelect: function(selected) {
        //             $("#datepicker1").datepicker("option","minDate", selected)
        //             var date = $(this).datepicker('getDate');
        //             $('#datepicker1').datepicker('option', 'minDate', date); // Reset minimum date
        //             date.setDate(date.getDate() + 1); // Add 7 days
        //             $("#datepicker1").datepicker( "setDate",  date); // Set as default
        //         },
        //         dateFormat:'yy/mm/dd',
        //     });

        //     $("#datepicker1").datepicker({
        //         dateFormat:'yy/mm/dd',
        //     });


        // });


        $(function() {
            // Function to toggle return date visibility
            function toggleReturnDateVisibility() {
                var tripType = $("#shortByChange").val();
                if (tripType === "one-way") {
                    $("#returnDateContainer").hide();
                } else {
                    $("#returnDateContainer").show();
                }
            }

            // Initialize datepickers
            $("#datepicker").datepicker({
                changeMonth: true,
                changeYear: true,
                numberOfMonths: 1,
                minDate: 0,
                onSelect: function(selected) {
                    $("#datepicker1").datepicker("option", "minDate", selected);
                    var date = $(this).datepicker('getDate');
                    $('#datepicker1').datepicker('option', 'minDate', date);
                    date.setDate(date.getDate() + 1);
                    $("#datepicker1").datepicker("setDate", date);
                },
                dateFormat: 'yy/mm/dd',
            });

            $("#datepicker1").datepicker({
                dateFormat: 'yy/mm/dd',
            });

            // Toggle return date visibility on page load
            toggleReturnDateVisibility();

            // Toggle return date visibility on trip type change
            $("#shortByChange").change(function() {
                toggleReturnDateVisibility();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var backgrounds = [
                '{{ asset('frontend_assets_new/img/slider/slider_bg01.jpg') }}',
                '{{ asset('frontend_assets_new/img/slider/slider_bg02.jpg') }}',
                '{{ asset('frontend_assets_new/img/slider/slider_bg03.jpg') }}',
            ];
            var currentIndex = 0;

            function changeBackground() {
                $('.slider-area').css('background-image', 'url(' + backgrounds[currentIndex] + ')');
                currentIndex = (currentIndex + 1) % backgrounds.length;
            }

            // Initial background change
            changeBackground();

            // Change background every 3 seconds
            setInterval(changeBackground, 5000);
        });

        function handleSubmit(event) {
            // Disable the submit button
            document.getElementById("submitButtonForm").disabled = true;
            // Show the loader
            document.getElementById("loader").style.display = "block";
        }
        document.getElementById("getFlightForm").addEventListener("submit", handleSubmit)
    </script>
    
@endsection
