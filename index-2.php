<?php
// Start session (for login systems later)
session_start();

include 'include/config.php';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/vendor/animate-wow/animate.min.css">
    <link rel="stylesheet" href="assets/icon/flaticon_cashflow.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- LOGIN FORM START -->
    <div class="ul-form-modal-bg" id="login-form-modal">
        <div class="ul-form-modal-content">
            <!-- close button -->
            <button class="ul-form-modal-closer"><i class="flaticon-close"></i></button>

            <div class="row row-cols-md-2 row-cols-1 g-0">
                <div class="col">
                    <div class="ul-form-modal-img">
                        <img src="assets/img/login-amico.svg" alt="Illustration">
                    </div>
                </div>

                <div class="col">
                    <div class="ul-form-modal-form-wrapper">
                        <form action="#" class="ul-form-modal-form">
                            <h2 class="ul-form-modal-title">Welcome Back!</h2>
                            <p class="ul-form-modal-sub-title">Log in to your account</p>
                            <div class="form-group">
                                <!-- <label for="name"></label> -->
                                <input type="text" name="name" id="name" placeholder="Username or Email">
                            </div>

                            <div class="form-group">
                                <!-- <label for="password"></label> -->
                                <input type="password" name="password" id="password" placeholder="Password">
                            </div>

                            <div class="form-group d-flex justify-content-between">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                                <a href="#">Forgot Password?</a>
                            </div>

                            <div class="form-group mt-4">
                                <button class="ul-btn w-100 justify-content-center">Login <i class="flaticon-arrow-up-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGIN FORM END -->


    <!-- LOAN APPLY FORM START -->
    <div class="ul-form-modal-bg" id="loan-apply-form-modal">
        <div class="ul-form-modal-content">
            <!-- close button -->
            <button class="ul-form-modal-closer"><i class="flaticon-close"></i></button>

            <div class="row row-cols-md-2 row-cols-1 g-0">
                <div class="col">
                    <div class="ul-form-modal-img">
                        <img src="assets/img/Manage money-pana.svg" alt="Illustration">
                    </div>
                </div>

                <div class="col">
                    <div class="ul-form-modal-form-wrapper">
                        <form action="#" class="ul-form-modal-form">
                            <h2 class="ul-form-modal-title">Apply for Loan</h2>
                            <p class="ul-form-modal-sub-title">Fill the form to apply for a loan</p>
                            <!-- name -->
                            <div class="form-group">
                                <!-- <label for="name"></label> -->
                                <input type="text" name="name" id="name" placeholder="Username or Email">
                            </div>

                            <!-- email -->
                            <div class="form-group">
                                <!-- <label for="email"></label> -->
                                <input type="email" name="email" id="email" placeholder="Email Address">
                            </div>

                            <!-- address -->
                            <div class="form-group">
                                <!-- <label for="address"></label> -->
                                <textarea type="text" name="address" id="address" placeholder="Full Address"></textarea>
                            </div>

                            <!-- amount -->
                            <div class="form-group">
                                <!-- <label for="amount"></label> -->
                                <input type="text" name="amount" id="amount" placeholder="Loan Amount">
                            </div>

                            <!-- phone -->
                            <div class="form-group">
                                <!-- <label for="phone"></label> -->
                                <input type="text" name="phone" id="phone" placeholder="Phone Number">
                            </div>

                            <!-- date -->
                            <div class="form-group">
                                <!-- <label for="date"></label> -->
                                <input type="date" name="date" id="date" placeholder="Select Date">
                            </div>

                            <!-- password -->
                            <div class="form-group">
                                <!-- <label for="password"></label> -->
                                <input type="password" name="password" id="password" placeholder="Password">
                            </div>

                            <!-- checkbox -->
                            <div class="form-group">
                                <div>
                                    <input class="form-check-input" type="checkbox" id="terms">
                                    <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                                </div>
                            </div>

                            <!-- radio -->
                            <div class="form-group d-flex gap-3">
                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" name="gender" id="male">
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <input type="radio" name="gender" id="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                            </div>

                            <!-- select -->
                            <div class="form-group">
                                <select name="loan-type" id="loan-type">
                                    <option value="" disabled selected>Select Loan Type</option>
                                    <option value="personal-loan">Personal Loan</option>
                                    <option value="home-loan">Home Loan</option>
                                    <option value="auto-loan">Auto Loan</option>
                                    <option value="student-loan">Student Loan</option>
                                </select>
                            </div>

                            <div class="form-group mt-4">
                                <button class="ul-btn w-100 justify-content-center">Apply <i class="flaticon-arrow-up-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- LOAN APPLY FORM END -->


    <div class="ul-sidebar">
        <!-- header -->
        <div class="ul-sidebar-header">
            <div class="ul-sidebar-header-logo">
                <a href="index.html">
                    <img src="assets/img/logo.svg" alt="logo" class="logo">
                </a>
            </div>
            <!-- sidebar closer -->
            <button class="ul-sidebar-closer"><i class="flaticon-close"></i></button>
        </div>

        <div class="ul-sidebar-header-nav-wrapper d-block d-lg-none"></div>


        <!-- sidebar footer -->
        <div class="ul-sidebar-footer">
            <span class="ul-sidebar-footer-title">Follow us</span>

            <div class="ul-sidebar-footer-social">
                <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                <a href="#"><i class="flaticon-twitter"></i></a>
                <a href="#"><i class="flaticon-linkedin"></i></a>
                <a href="#"><i class="flaticon-instagram"></i></a>
            </div>
        </div>
    </div>

    <!-- search -->
    <div class="ul-search-form-wrapper flex-grow-1 flex-shrink-0">
        <button class="ul-search-closer"><i class="flaticon-close"></i></button>

        <form action="#" class="ul-search-form">
            <div class="ul-search-form-right">
                <input type="search" name="search" id="ul-search" placeholder="Search Here">
                <button type="submit"><span class="icon"><i class="flaticon-search"></i></span></button>
            </div>
        </form>
    </div>

    <header class="ul-header">
        <div class="ul-ticker" id="ul-header-top-ticker">
            <div id="ticker-tape-container"></div>
        </div>

        <!-- header bottom -->
        <div class="ul-2-header-bottom">
            <div class="ul-2-header-container">
                <div class="logo-container">
                    <a href="index-2.html"><img src="assets/img/logo.svg" alt="logo"></a>
                </div>

                <div class="ul-2-header-bottom-right">
                    <!-- header nav -->
                    <div class="ul-header-nav-wrapper">

                        <div class="to-go-to-sidebar-in-mobile">
                            <nav class="ul-header-nav">
                                <div class="has-sub-menu">
                                    <a role="button">Home</a>

                                    <div class="ul-header-submenu">
                                        <ul>
                                            <li><a href="index.html">Home 1</a></li>
                                            <li><a href="index-2.html">Home 2</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <a href="about.html">About</a>
                                <div class="has-sub-menu">
                                    <a role="button">Services</a>

                                    <div class="ul-header-submenu">
                                        <ul>
                                            <li><a href="services.html">Services</a></li>
                                            <li><a href="service-details.html">Service Details</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="has-sub-menu">
                                    <a role="button">Blogs</a>

                                    <div class="ul-header-submenu">
                                        <ul>
                                            <li><a href="blogs.html">Blogs Grid</a></li>
                                            <li><a href="blog-list.html">Blogs List</a></li>
                                            <li><a href="blog-details.html">Blog Details</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="has-sub-menu">
                                    <a role="button">Pages</a>

                                    <div class="ul-header-submenu">
                                        <ul>
                                            <li><a href="testimonials.html">Testimonials</a></li>
                                            <li><a href="team.html">Team Members</a></li>
                                            <li><a href="team-details.html">Team Member Details</a></li>
                                            <li><a href="404.html">404</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <a href="contact.html">Contact us</a>
                            </nav>
                        </div>
                    </div>

                    <button class="ul-header-search-opener"><i class="flaticon-search"></i></button>

                    <div class="ul-2-header-bottom-btns">
                        <a href="#" class="ul-btn d-xl-flex d-none login-opener">Login <i class="flaticon-arrow-up-right"></i></a>
                        <a href="#" class="ul-btn d-xxs-none loan-apply-opener ">Apply For Loan <i class="flaticon-arrow-up-right"></i></a>
                    </div>
                    <button class="ul-header-sidebar-opener d-lg-none d-flex"><i class="flaticon-hamburger"></i></button>
                </div>
            </div>
        </div>
    </header>

    <main>
        <!-- BANNER SECTION START -->
        <section class="ul-banner">
            <div class="swiper ul-banner-slider">
                <div class="swiper-wrapper">
                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-banner-slide">
                            <div class="ul-banner-container">
                                <div class="row gy-4 align-items-center">
                                    <!-- text -->
                                    <div class="col-lg-6 col-md-8">
                                        <div class="ul-banner-txt">
                                            <span class="ul-banner-sub-title">Trade with Intelligence.</span>
                                            <h1 class="ul-banner-title">MASTER THE MARKETS. TRADE WITH <span class="styled">INNOVATION.</span></h1>
                                            <p class="ul-banner-descr">Join thousands of traders who choose <span class="styled">AceMax Global</span> for lightning-fast execution
                                                razor-sharp spreads, and institutional-grade trading technology.</p>

                                            <div class="ul-banner-btns">
                                                <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading Now</a>
                                                <a href="#" class="ul-btn ul-banner-btn-2"><i class="flaticon-arrow-up-right"></i> Try Demo Free</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- imgs -->
                                    <div class="col">
                                        <div class="ul-banner-bg"><img src="assets/img/banner-bg.jpg" alt="Banner-Image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-banner-slide">
                            <div class="ul-banner-container">
                                <div class="row gy-4 align-items-center">
                                    <!-- text -->
                                    <div class="col-lg-6 col-md-8">
                                        <div class="ul-banner-txt">
                                            <span class="ul-banner-sub-title">Trade with Intelligence.</span>
                                            <h1 class="ul-banner-title">MASTER THE MARKETS. TRADE WITH <span class="styled">INNOVATION.</span></h1>
                                            <p class="ul-banner-descr">Join thousands of traders who choose <span class="styled">AceMax Global</span> for lightning-fast execution
                                                razor-sharp spreads, and institutional-grade trading technology.</p>

                                            <div class="ul-banner-btns">
                                                <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading Now</a>
                                                <a href="#" class="ul-btn ul-banner-btn-2"><i class="flaticon-arrow-up-right"></i> Try Demo Free</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- imgs -->
                                    <div class="col">
                                        <div class="ul-banner-bg"><img src="assets/img/banner-2-slide-1.jpg" alt="Banner-Image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-banner-slide">
                            <div class="ul-banner-container">
                                <div class="row gy-4 align-items-center">
                                    <!-- text -->
                                    <div class="col-lg-6 col-md-8">
                                        <div class="ul-banner-txt">
                                            <span class="ul-banner-sub-title">Trade with Intelligence.</span>
                                            <h1 class="ul-banner-title">MASTER THE MARKETS. TRADE WITH <span class="styled">INNOVATION.</span></h1>
                                            <p class="ul-banner-descr">Join thousands of traders who choose <span class="styled">AceMax Global</span> for lightning-fast execution
                                                razor-sharp spreads, and institutional-grade trading technology.</p>

                                            <div class="ul-banner-btns">
                                                <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading Now</a>
                                                <a href="#" class="ul-btn ul-banner-btn-2"><i class="flaticon-arrow-up-right"></i> Try Demo Free</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- imgs -->
                                    <div class="col">
                                        <div class="ul-banner-bg"><img src="assets/img/banner-bg.jpg" alt="Banner-Image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ul-banner-slider-pagination"></div>
            </div>
        </section>
        <!-- BANNER SECTION END -->


        <!-- TradingView Widget BEGIN -->

        <!-- TradingView Widget BEGIN -->


        <!-- FEATURES SECTION START -->
        <div class="ul-section-spacing">
            <div class="ul-container">
                <div class="ul-features">
                    <!-- feature -->
                    <div class="ul-feature wow animate__fadeInUp">
                        <span class="ul-feature-title">0.0</span>
                        <span class="ul-feature-sub-title">Pips Spreads</span>
                    </div>
                    <!-- feature -->
                    <div class="ul-feature wow animate__fadeInUp" data-wow-delay="0.1s">
                        <span class="ul-feature-title">50ms</span>
                        <span class="ul-feature-sub-title">Execution</span>
                    </div>
                    <!-- feature -->
                    <div class="ul-feature wow animate__fadeInUp" data-wow-delay="0.2s">
                        <span class="ul-feature-title">500+</span>
                        <span class="ul-feature-sub-title">Instruments</span>
                    </div>
                    <!-- feature -->
                    <div class="ul-feature wow animate__fadeInUp" data-wow-delay="0.3s">
                        <span class="ul-feature-title">24/7</span>
                        <span class="ul-feature-sub-title">Support</span>
                    </div>

                    <div class="ul-features-vector vector-1"></div>
                    <div class="ul-features-vector vector-2"></div>
                </div>
            </div>
        </div>
        <!-- FEATURES SECTION END -->


        <!-- MARKET SECTION START -->
        <section class="ul-market">
            <div class="ul-container">
                <div class="row gx-0 gy-4">
                    <!-- text -->
                    <div class="col-lg-8">
                        <div class="ul-market-txt">
                            <div>
                                <span class="ul-section-sub-title">What We Offer</span>
                                <h2 class="ul-section-title">Provide All Your Need</h2>
                            </div>

                            <div class="ul-market-accordion-wrapper">
                                <!-- market accordion -->
                                <div class="ul-accordion">
                                    <!-- market accordion item -->
                                    <div class="ul-single-accordion-item open" data-img="assets/img/market-img.jpg">
                                        <div class=" ul-single-accordion-item__header">
                                            <div class="left">
                                                <h3 class="ul-single-accordion-item__title"><i class="flaticon-check"></i> Trading Accounts</h3>
                                            </div>
                                            <span class="icon"><i class="ul-plus"></i></span>
                                        </div>

                                        <div class="ul-single-accordion-item__body">
                                            <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam. Vestibulum eltum leo id scelerisque</p>
                                            <a href="#"><i class="flaticon-arrow-right-double"></i> Read More</a>
                                        </div>
                                    </div>

                                    <!-- market accordion item -->
                                    <div class="ul-single-accordion-item" data-img="assets/img/highlight-img.jpg">
                                        <div class="ul-single-accordion-item__header">
                                            <div class="left">
                                                <h3 class="ul-single-accordion-item__title"><i class="flaticon-check"></i> Monitoring & Support</h3>
                                            </div>
                                            <span class="icon"><i class="ul-plus"></i></span>
                                        </div>

                                        <div class="ul-single-accordion-item__body">
                                            <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam. Vestibulum eltum leo id scelerisque</p>
                                            <a href="#"><i class="flaticon-arrow-right-double"></i> Read More</a>
                                        </div>
                                    </div>

                                    <!-- market accordion item -->
                                    <div class="ul-single-accordion-item" data-img="assets/img/banner-img-1.jpg">
                                        <div class="ul-single-accordion-item__header">
                                            <div class="left">
                                                <h3 class="ul-single-accordion-item__title"><i class="flaticon-check"></i> Platforms & Tools</h3>
                                            </div>
                                            <span class="icon"><i class="ul-plus"></i></span>
                                        </div>

                                        <div class="ul-single-accordion-item__body">
                                            <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam. Vestibulum eltum leo id scelerisque</p>
                                            <a href="#"><i class="flaticon-arrow-right-double"></i> Read More</a>
                                        </div>
                                    </div>

                                    <!-- market accordion item -->
                                    <div class="ul-single-accordion-item" data-img="assets/img/offer-5.jpg">
                                        <div class="ul-single-accordion-item__header">
                                            <div class="left">
                                                <h3 class="ul-single-accordion-item__title"><i class="flaticon-check"></i> Education & Training</h3>
                                            </div>
                                            <span class="icon"><i class="ul-plus"></i></span>
                                        </div>

                                        <div class="ul-single-accordion-item__body">
                                            <p>Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam. Vestibulum eltum leo id scelerisque</p>
                                            <a href="#"><i class="flaticon-arrow-right-double"></i> Read More</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="ul-market-img">
                                    <img src="assets/img/market-img.jpg" alt="Image" id="ul-market-accordion-img">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- market overview -->
                    <div class="col-lg-4">
                        <div class="ul-market-overview">
                            <span class="ul-market-overview-title">Market Overview</span>
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container" id="ul-market-overview-widget-wrapper">
                                <script></script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- MARKET SECTION END -->


        <!-- CTA -->
        <div class="ul-cta">
            <div class="ul-container">
                <div class="ul-cta-content">
                    <div class="ul-cta-left">
                        <!-- single card -->
                        <div class="ul-cta-card wow animate__fadeInUp">
                            <span class="ul-cta-card-title">Payout Details</span>
                            <span class="ul-cta-card-descr">Useourfundstotrademore,redu</span>
                        </div>
                        <!-- single card -->
                        <div class="ul-cta-card wow animate__fadeInUp" data-wow-delay="0.1s">
                            <span class="ul-cta-card-title">50% Bonus</span>
                            <span class="ul-cta-card-descr">Useourfundstotrademore,redu</span>
                        </div>
                        <!-- single card -->
                        <div class="ul-cta-card-2 wow animate__fadeInUp" data-wow-delay="0.2s">
                            <span class="ul-cta-card-icon"><img src="assets/img/cta-24-7.png" alt="icon"></span>
                            <span class="ul-cta-card-descr">We provide <br> 24/7 suppports</span>
                        </div>
                    </div>

                    <div class="ul-cta-right">
                        <img src="assets/img/cta-img.png" alt="Image" class="ul-cta-img">
                        <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i>Start Trading Now</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- CTA -->


        <!-- HIGHTLIGHT SECTION START -->
        <section class="ul-highlight ul-section-spacing">
            <div class="ul-container">
                <div class="row gy-4">
                    <!-- widget -->
                    <div class="col-lg-4">
                        <div class="ul-highlight-widget-wrapper h-100">
                            <!-- TradingView Widget BEGIN -->
                            <span class="ul-market-overview-title">Economic Calendar</span>
                            <div class="tradingview-widget-container" id="ul-event-widget-wrapper">
                                <script></script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                    </div>

                    <!-- text -->
                    <div class="col-lg-8">
                        <div class="ul-highlight-content">
                            <div class="ul-highlight-txt">
                                <div>
                                    <span class="ul-section-sub-title">Key Highlight</span>
                                    <h2 class="ul-section-title">Reasons For Choosing Us</h2>
                                </div>
                                <div class="ul-highlight-reasons">
                                    <!-- single reason -->
                                    <div class="ul-highlight-reason">
                                        <div class="ul-highlight-reason-icon"><img src="assets/img/highlight-1.svg" alt=""></div>
                                        <div class="ul-highlight-reason-txt">
                                            <span class="ul-highlight-reason-title">Lightning Execution</span>
                                            <p class="ul-highlight-reason-descr">Trade execution under 50ms with institutional-grade infrastructure</p>
                                        </div>
                                    </div>

                                    <!-- single reason -->
                                    <div class="ul-highlight-reason">
                                        <div class="ul-highlight-reason-icon"><img src="assets/img/highlight-2.svg" alt=""></div>
                                        <div class="ul-highlight-reason-txt">
                                            <span class="ul-highlight-reason-title">Advanced Tools</span>
                                            <p class="ul-highlight-reason-descr">Trade execution under 50ms with institutional-grade infrastructure</p>
                                        </div>
                                    </div>

                                    <!-- single reason -->
                                    <div class="ul-highlight-reason">
                                        <div class="ul-highlight-reason-icon"><img src="assets/img/highlight-3.svg" alt=""></div>
                                        <div class="ul-highlight-reason-txt">
                                            <span class="ul-highlight-reason-title">No Hidden Fees</span>
                                            <p class="ul-highlight-reason-descr">Bank-grade security with 24/7 global market access</p>
                                        </div>
                                    </div>

                                    <!-- single reason -->
                                    <div class="ul-highlight-reason">
                                        <div class="ul-highlight-reason-icon"><img src="assets/img/highlight-4.svg" alt=""></div>
                                        <div class="ul-highlight-reason-txt">
                                            <span class="ul-highlight-reason-title">Secure Platform</span>
                                            <p class="ul-highlight-reason-descr">Bank-grade security with 24/7 global market access</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ul-highlight-img">
                                <img src="assets/img/highlight-img.jpg" alt="highlight image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- HIGHTLIGHT SECTION END -->


        <!-- OFFER SECTION START -->
        <section class="ul-offers ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading">
                    <div class="left">
                        <span class="ul-section-sub-title">What We Offer</span>
                        <h2 class="ul-section-title">Empowering Your Trading Journey with us</h2>
                    </div>
                    <p class="mb-0 ul-section-descr">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam. Vestibulum eltum leo id scelerisque primis in faucibus. Aenean</p>
                </div>


                <div class="ul-offers-wrapper">
                    <!-- single offer -->
                    <div class="ul-offer">
                        <h3 class="ul-offer-title">Indices</h3>
                        <p class="ul-offer-descr">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam.</p>
                        <div class="ul-offer-img">
                            <img src="assets/img/offer-1.jpg" alt="Offering Image">
                            <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading</a>
                        </div>
                    </div>

                    <!-- single offer -->
                    <div class="ul-offer">
                        <h3 class="ul-offer-title">Stocks</h3>
                        <p class="ul-offer-descr">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam.</p>
                        <div class="ul-offer-img">
                            <img src="assets/img/offer-2.jpg" alt="Offering Image">
                            <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading</a>
                        </div>
                    </div>

                    <!-- single offer -->
                    <div class="ul-offer">
                        <h3 class="ul-offer-title">Metals</h3>
                        <p class="ul-offer-descr">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam.</p>
                        <div class="ul-offer-img">
                            <img src="assets/img/offer-3.jpg" alt="Offering Image">
                            <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading</a>
                        </div>
                    </div>

                    <!-- single offer -->
                    <div class="ul-offer">
                        <h3 class="ul-offer-title">Commodities</h3>
                        <p class="ul-offer-descr">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam.</p>
                        <div class="ul-offer-img">
                            <img src="assets/img/offer-4.jpg" alt="Offering Image">
                            <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading</a>
                        </div>
                    </div>

                    <!-- single offer -->
                    <div class="ul-offer">
                        <h3 class="ul-offer-title">Crypto</h3>
                        <p class="ul-offer-descr">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam.</p>
                        <div class="ul-offer-img">
                            <img src="assets/img/offer-5.jpg" alt="Offering Image">
                            <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading</a>
                        </div>
                    </div>

                    <!-- single offer -->
                    <div class="ul-offer">
                        <h3 class="ul-offer-title">Forex</h3>
                        <p class="ul-offer-descr">Interdum et malesuada fames ac ante ipsum primis in faucibus. Aenean ornare vehia augue, vitae ullamcorper lacus dignissim in. Nullam non nulla diam.</p>
                        <div class="ul-offer-img">
                            <img src="assets/img/offer-6.jpg" alt="Offering Image">
                            <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> Start Trading</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- OFFER SECTION END -->


        <!-- PLATFORM SECTION START -->
        <section class="ul-platform ul-section-spacing pb-0">
            <div class="ul-container">
                <div class="ul-section-heading mb-0 justify-content-center text-center">
                    <div>
                        <span class="ul-section-sub-title">Platform</span>
                        <h2 class="ul-section-title">Get Exclusive <span class="colored">MT-5</span> Tools With Acemax</h2>
                        <p class="ul-section-descr">Denouncing pleasure and praising pain was born and will give you a complete account of the system, and expound the actual teachings.</p>
                    </div>
                </div>

                <div class="ul-platform-pills">
                    <span class="ul-platform-pill">Ultra fast trade execution</span>
                    <span class="ul-platform-pill">Trading from a smartphone or tablet</span>
                    <span class="ul-platform-pill">No dealing desk, no requotes</span>
                </div>

                <a href="#" class="ul-btn"><i class="flaticon-arrow-up-right"></i> START TRADING</a>

                <div class="ul-platform-img">
                    <img src="assets/img/platform-img.png" alt="Image" class="main-img wow animate__slideInUp">
                    <img src="assets/img/platform-img-vector.svg" alt="vector" class="vector wow animate__fadeInBottomLeft" data-wow-delay="0.6s">
                </div>
            </div>
        </section>
        <!-- PLATFORM SECTION END -->


        <!-- ACCOUNT TYPES SECTION START -->
        <section class="ul-account-types ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading justify-content-center text-center">
                    <div>
                        <span class="ul-section-sub-title">Account Type</span>
                        <h2 class="ul-section-title">Choose Your Account Type</h2>
                    </div>
                </div>

                <!-- table -->
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th></th>
                            <th>Standard Plan</th>
                            <th class="popular">Elite Plan</th>
                            <th>Pro Plan</th>
                        </tr>
                        <tr>
                            <td>Spreads</td>
                            <td>Raw + 15 Pips</td>
                            <td>Raw + 15 Pips</td>
                            <td>Raw + 15 Pips</td>
                        </tr>
                        <tr>
                            <td>Commission</td>
                            <td>None</td>
                            <td>None</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>Swaps</td>
                            <td>None</td>
                            <td>None</td>
                            <td>None</td>
                        </tr>
                        <tr>
                            <td>Minimum Trade Size</td>
                            <td>0.01 Lots Fx & Metals</td>
                            <td>0.01 Lots Fx & Metals</td>
                            <td>0.01 Lots Fx & Metals</td>
                        </tr>
                        <tr>
                            <td>Minimum Deposit</td>
                            <td>0.01 Lots Fx & Metals</td>
                            <td>0.01 Lots Fx & Metals</td>
                            <td>0.01 Lots Fx & Metals</td>
                        </tr>
                        <tr>
                            <td>Account Currency</td>
                            <td>Usa</td>
                            <td>Usa</td>
                            <td>Usa</td>
                        </tr>
                        <tr>
                            <td>Products</td>
                            <td>290+ CFDs</td>
                            <td>290+ CFDs</td>
                            <td>290+ CFDs</td>
                        </tr>
                        <tr>
                            <td>Pricing</td>
                            <td>5 Digit Pricing</td>
                            <td>5 Digit Pricing</td>
                            <td>5 Digit Pricing</td>
                        </tr>
                        <tr>
                            <td>Margin/Leverage</td>
                            <td>Up To 500:1</td>
                            <td>Up To 500:1</td>
                            <td>Up To 500:1</td>
                        </tr>
                        <tr>
                            <td>EA Compatibility</td>
                            <td>No</td>
                            <td>No</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><a href="#" class="ul-btn d-inline-flex"><i class="flaticon-arrow-up-right"></i> Open Account</a></td>
                            <td><a href="#" class="ul-btn d-inline-flex"><i class="flaticon-arrow-up-right"></i> Open Account</a></td>
                            <td><a href="#" class="ul-btn d-inline-flex"><i class="flaticon-arrow-up-right"></i> Open Account</a></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="ul-account-types-vector vector-1"></div>
            <div class="ul-account-types-vector vector-2"></div>
        </section>
        <!-- ACCOUNT TYPES SECTION END -->


        <!-- FAQ SECTION START -->
        <section class="ul-faq ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading justify-content-center text-center">
                    <div>
                        <span class="ul-section-sub-title">FAQ</span>
                        <h2 class="ul-section-title">Frequently Ask Question</h2>
                    </div>
                </div>

                <!-- accordion -->
                <div class="ul-accordion">
                    <!-- accordion item -->
                    <div class="ul-single-accordion-item open">
                        <div class="ul-single-accordion-item__header">
                            <div class="left">
                                <h3 class="ul-single-accordion-item__title">What is Trading?</h3>
                            </div>
                            <span class="icon"><i class="ul-plus"></i></span>
                        </div>

                        <div class="ul-single-accordion-item__body">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, </p>
                        </div>
                    </div>

                    <!-- accordion item -->
                    <div class="ul-single-accordion-item">
                        <div class="ul-single-accordion-item__header">
                            <div class="left">
                                <h3 class="ul-single-accordion-item__title">What's The Difference Between Trading And Investing?</h3>
                            </div>
                            <span class="icon"><i class="ul-plus"></i></span>
                        </div>

                        <div class="ul-single-accordion-item__body">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, </p>
                        </div>
                    </div>

                    <!-- accordion item -->
                    <div class="ul-single-accordion-item">
                        <div class="ul-single-accordion-item__header">
                            <div class="left">
                                <h3 class="ul-single-accordion-item__title">What Markets Can I Trade in?</h3>
                            </div>
                            <span class="icon"><i class="ul-plus"></i></span>
                        </div>

                        <div class="ul-single-accordion-item__body">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, </p>
                        </div>
                    </div>

                    <!-- accordion item -->
                    <div class="ul-single-accordion-item">
                        <div class="ul-single-accordion-item__header">
                            <div class="left">
                                <h3 class="ul-single-accordion-item__title">What Do I Need to Start Trading?</h3>
                            </div>
                            <span class="icon"><i class="ul-plus"></i></span>
                        </div>

                        <div class="ul-single-accordion-item__body">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, </p>
                        </div>
                    </div>

                    <!-- accordion item -->
                    <div class="ul-single-accordion-item">
                        <div class="ul-single-accordion-item__header">
                            <div class="left">
                                <h3 class="ul-single-accordion-item__title">What Are Pips in Forex Trading?</h3>
                            </div>
                            <span class="icon"><i class="ul-plus"></i></span>
                        </div>

                        <div class="ul-single-accordion-item__body">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered. Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ SECTION END -->
    </main>

    <!-- FOOTER SECTION START -->
    <footer class="ul-footer">
        <!-- cta -->
        <div class="ul-footer-cta-wrapper">
            <div class="ul-container">
                <div class="ul-footer-cta">
                    <div class="ul-footer-about ul-footer-logo-wrapper flex-grow-1">
                        <a href="index.html"><img src="assets/img/logo-white.svg" alt="logo"></a>
                    </div>
                    <div class="ul-footer-cta-form-wrapper">
                        <p class="ul-footer-cta-descr">Want to receive news and updates?</p>
                        <form action="#" class="ul-footer-cta-form">
                            <input type="email" class="ul-footer-cta-form-input" placeholder="Enter Your Email">
                            <button type="submit" class="ul-btn ul-footer-cta-form-btn"><i class="flaticon-arrow-up-right"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="ul-footer-bg">
            <div class="ul-container">
                <!-- footer top -->
                <div class="ul-footer-top">
                    <div class="ul-footer-top-wrapper">
                        <div class="ul-footer-about">
                            <h3 class="ul-footer-widget-title">About Company</h3>
                            <p class="ul-footer-about-txt">Your trusted partner in global financial markets. Trade with confidence using our advanced platforms. Trade with power, trade with AceMax.</p>
                            <div class="ul-footer-socials">
                                <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                                <a href="#"><i class="flaticon-twitter"></i></a>
                                <a href="#"><i class="flaticon-linkedin"></i></a>
                                <a href="#"><i class="flaticon-instagram"></i></a>
                            </div>
                        </div>

                        <div class="ul-footer-widget">
                            <h3 class="ul-footer-widget-title">Quick Links</h3>

                            <div class="ul-footer-widget-links">
                                <a href="#">About Us</a>
                                <a href="#">MT5 Platform</a>
                                <a href="#">Account Types</a>
                                <a href="#">Education</a>
                                <a href="#">Partner Program</a>
                                <a href="#">Contact Us</a>
                            </div>
                        </div>

                        <div class="ul-footer-widget">
                            <h3 class="ul-footer-widget-title">Legal</h3>

                            <div class="ul-footer-widget-links">
                                <a href="#">Legal Documents</a>
                                <a href="#">Terms & Conditions</a>
                                <a href="#">Privacy Policy</a>
                                <a href="#">Risk Disclosure</a>
                                <a href="#">AML/KYC Policy</a>
                                <a href="#">Security</a>
                            </div>
                        </div>

                        <div class="ul-footer-widget ul-footer-contact-widget">
                            <h3 class="ul-footer-widget-title">Contact Info</h3>

                            <div class="ul-footer-contact-infos">
                                <div class="ul-footer-contact-info">
                                    <span class="ul-footer-contact-info-icon"><i class="flaticon-location-pin"></i></span>
                                    <span class="ul-footer-contact-info-txt">Level 3, 62 Taharoto Road, Takapuna, Auckland 0622, New Zealand</span>
                                </div>
                                <div class="ul-footer-contact-info">
                                    <span class="ul-footer-contact-info-icon"><i class="flaticon-mail-open"></i></span>
                                    <span class="ul-footer-contact-info-address"><a href="mailto:support@acemaxglobal.com">support@acemaxglobal.com</a></span>
                                </div>
                            </div>

                            <h3 class="ul-footer-widget-title">We Accept</h3>

                            <div class="ul-footer-contact-infos">
                                <img src="assets/img/payment-methods.png" alt="Payment Methods" class="ul-footer-payment-methods">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- footer bottom -->
                <div class="ul-footer-bottom">
                    <p class="copyright">&copy; 2025 Finantics All rights reserved.</p>
                    <p class="credit">Developed with <span class="text-danger">❤</span> in BD by UMR LABS</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- FOOTER SECTION END -->

    <!-- Vendor JS -->
    <script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/animate-wow/wow.min.js"></script>
    <script src="assets/vendor/splittype/index.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/accordion.js"></script>
    <script src="assets/js/stacking-cards.js"></script>
</body>

</html>