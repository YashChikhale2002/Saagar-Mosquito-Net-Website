<?php
// Start session (for login systems later)
session_start();

include 'include/config.php';

$page_title       = "Niraj Industries | PVC Pipe Manufacturer in Nagpur";
$meta_description = "Niraj Industries — trusted PVC pipe manufacturer in Nagpur. We supply PVC, UPVC, SWR, agriculture & plumbing pipes across Maharashtra. Get bulk pricing & free quote today.";
$meta_keywords    = "PVC pipe manufacturer in Nagpur, UPVC pipe manufacturer Nagpur, SWR drainage pipe Nagpur, agriculture PVC pipe Nagpur, wholesale PVC pipe Nagpur, plumbing pipe dealer Nagpur";

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

<body class="home-2">
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

   <?php include 'include/header.php'; ?>

 

    <main>
        <!-- BANNER SECTION START -->
        <section class="ul-2-banner">
            <div class="swiper ul-2-banner-slider">
                <div class="swiper-wrapper">
                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-banner-content">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <!-- banner txt -->
                                    <span class="ul-2-banner-sub-title"><span class="bg">Home Loan</span> only 5% interest rate</span>
                                    <h1 class="ul-2-banner-title">Your Financial Partner for your better Life</h1>
                                    <p class="ul-2-banner-descr">With years of experience and a client-first approach, we provide honest, insightful financial guidance tailored to your goals—ensuring every decision supports your long-term success and peace of mind.</p>
                                    <div class="ul-2-banner-btns">
                                        <a href="about.html">Know More <i class="flaticon-arrow-up-right"></i></a>
                                        <a href="services.html">Media Tour <i class="flaticon-arrow-up-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <img src="assets/img/banner-2-slide-1.jpg" alt="Banner Slide Background" class="ul-2-banner-slide-bg">
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-banner-content">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <!-- banner txt -->
                                    <span class="ul-2-banner-sub-title"><span class="bg">Home Loan</span> only 5% interest rate</span>
                                    <h1 class="ul-2-banner-title">Your Financial Partner for your better Life</h1>
                                    <p class="ul-2-banner-descr">With years of experience and a client-first approach, we provide honest, insightful financial guidance tailored to your goals—ensuring every decision supports your long-term success and peace of mind.</p>
                                    <div class="ul-2-banner-btns">
                                        <a href="about.html">Know More <i class="flaticon-arrow-up-right"></i></a>
                                        <a href="services.html">Media Tour <i class="flaticon-arrow-up-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <img src="assets/img/banner-2-slide-1.jpg" alt="Banner Slide Background" class="ul-2-banner-slide-bg">
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-banner-content">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <!-- banner txt -->
                                    <span class="ul-2-banner-sub-title"><span class="bg">Home Loan</span> only 5% interest rate</span>
                                    <h1 class="ul-2-banner-title">Your Financial Partner for your better Life</h1>
                                    <p class="ul-2-banner-descr">With years of experience and a client-first approach, we provide honest, insightful financial guidance tailored to your goals—ensuring every decision supports your long-term success and peace of mind.</p>
                                    <div class="ul-2-banner-btns">
                                        <a href="about.html">Know More <i class="flaticon-arrow-up-right"></i></a>
                                        <a href="services.html">Media Tour <i class="flaticon-arrow-up-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <img src="assets/img/banner-2-slide-1.jpg" alt="Banner Slide Background" class="ul-2-banner-slide-bg">
                        </div>
                    </div>
                </div>

                <div class="ul-2-banner-slider-pagination"></div>
            </div>
        </section>
        <!-- BANNER SECTION END -->


        <!-- FEATURES SECTION START -->
        <section class="ul-2-features ul-section-spacing">
            <div class="ul-container">
                <div class="ul-2-features-content">
                    <!-- single feature -->
                    <div class="ul-2-feature">
                        <div class="ul-2-feature-icon"><i class="flaticon-insurance-agent"></i></div>
                        <h3 class="ul-2-feature-title">Life Insurance</h3>
                    </div>

                    <!-- single feature -->
                    <div class="ul-2-feature">
                        <div class="ul-2-feature-icon"><i class="flaticon-accounting"></i></div>
                        <h3 class="ul-2-feature-title">Fixed Deposit Account</h3>
                    </div>

                    <!-- single feature -->
                    <div class="ul-2-feature">
                        <div class="ul-2-feature-icon"><i class="flaticon-money"></i></div>
                        <h3 class="ul-2-feature-title">Business Investment</h3>
                    </div>

                    <!-- single feature -->
                    <div class="ul-2-feature">
                        <div class="ul-2-feature-icon"><i class="flaticon-pension"></i></div>
                        <h3 class="ul-2-feature-title">Pension Scheme</h3>
                    </div>

                    <!-- single feature -->
                    <div class="ul-2-feature">
                        <div class="ul-2-feature-icon"><i class="flaticon-mutual-fund"></i></div>
                        <h3 class="ul-2-feature-title">Mutual Funds</h3>
                    </div>
                </div>
            </div>
        </section>
        <!-- FEATURES SECTION END -->


        <!-- ABOUT SECTION START -->
        <section class="ul-2-about ul-section-spacing pt-0">
            <div class="ul-container">
                <div class="row g-4 row-cols-lg-2 row-cols-1 align-items-center">
                    <!-- img -->
                    <div class="col">
                        <div class="ul-2-about-img">
                            <img src="assets/img/about-2-img.png" alt="Image" class="main-img">

                            <div class="ul-2-about-img-bgs">
                                <div class="ul-2-about-img-bg-1">
                                    <img src="assets/img/about-2-img-bg-1.jpg" alt="Image background">
                                </div>
                                <img src="assets/img/about-2-img-bg-2.jpg" alt="Image background">
                            </div>

                            <a href="https://youtu.be/EEX0EHTTePE?si=TxbhzBCGoTx64WEe" data-fslightbox="video" class="ul-2-about-play-btn"><i class="flaticon-play-button-arrowhead"></i></a>

                            <div class="ul-2-about-img-txt"><img src="assets/img/about-2-img-logo.svg" alt="logo"><span class="txt">SINCE 1948</span></div>
                        </div>
                    </div>

                    <!-- txt -->
                    <div class="col">
                        <div class="ul-2-about-txt">
                            <span class="ul-2-section-sub-title">More About us</span>
                            <h2 class="ul-2-section-title">Committed to Your Safety And Better Security</h2>
                            <p class="ul-2-section-descr">Automation & workflow features include a drag & drop builder, automated task assignments, conditional with good triggers, & api integrations.</p>
                            <div class="ul-2-about-points">
                                <div class="ul-2-about-point">
                                    <img src="assets/img/tick-inside-circle.svg" alt="icon" class="icon">
                                    <span class="title">Great Explorer of The Master Builder Financial</span>
                                </div>
                                <div class="ul-2-about-point">
                                    <img src="assets/img/tick-inside-circle.svg" alt="icon" class="icon">
                                    <span class="title">Your Gateway to Financial Freedom in life</span>
                                </div>
                            </div>
                            <p class="ul-2-about-descr">With years of experience and a client-first approach, we provide honest, insightful financial guidance tailored to your goals—ensuring every decision supports your long-term success and peace of mind. Lorem ipsum dolor sit amet.</p>
                            <a href="about.html" class="ul-btn">Know More <i class="flaticon-arrow-up-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ABOUT SECTION END -->


        <!-- TICKER SECTION START -->
        <section class="ul-2-ticker">
            <div id="ticker-tape-container"></div>
            <div id="ticker-tape-container-2"></div>
        </section>
        <!-- TICKER SECTION END -->


        <!-- SOLUTIONS SECTION START -->
        <section class="ul-2-solutions ul-section-spacing">
            <div class="ul-container">
                <div class="row row-cols-md-2 row-cols-1 gy-4 align-items-center">
                    <div class="col">
                        <div class="ul-2-solutions-txt">
                            <span class="ul-2-section-sub-title">Our Financial Solutions</span>
                            <h2 class="ul-2-section-title">Personalize Financial Solutions</h2>


                            <div class="tab-group">
                                <div class="ul-2-solutions-tab-navs">
                                    <button class="tab-nav active" data-tab="tab-1">Savings Account</button>
                                    <button class="tab-nav" data-tab="tab-2">Consumer Loans</button>
                                    <button class="tab-nav" data-tab="tab-3">Credit Cards</button>
                                    <button class="tab-nav" data-tab="tab-4">Advisory Services</button>
                                </div>

                                <div class="tabs-wrapper">
                                    <div class="ul-tab active" id="tab-1">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Saving Made Simple for a Brighter Future Saving Today for What Matters</span>
                                            <p class="descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">2.5K</span>
                                                        <p class="descr">Live Savings Accounts</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">3.9B</span>
                                                        <p class="descr">In Customer Savings</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-tab" id="tab-2">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Consumer Loans</span>
                                            <p class="descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">2.5K</span>
                                                        <p class="descr">Live Savings Accounts</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">3.9B</span>
                                                        <p class="descr">In Customer Savings</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-tab" id="tab-3">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Saving Made Simple for a Brighter Future Saving Today for What Matters</span>
                                            <p class="descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">2.5K</span>
                                                        <p class="descr">Live Savings Accounts</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">3.9B</span>
                                                        <p class="descr">In Customer Savings</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-tab" id="tab-4">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Saving Made Simple for a Brighter Future Saving Today for What Matters</span>
                                            <p class="descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">2.5K</span>
                                                        <p class="descr">Live Savings Accounts</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">3.9B</span>
                                                        <p class="descr">In Customer Savings</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ul-2-solutions-txt-bottom">
                                <a href="services.html" class="ul-btn">View All Services <i class="flaticon-arrow-up-right"></i></a>

                                <div class="ul-2-solutions-cta">
                                    <span class="ul-2-solutions-cta-title">Get Support</span>
                                    <span class="helpline">Help line <a href="#"><i class="flaticon-telephone"></i> 203010</a></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- img -->
                    <div class="col">
                        <div class="ul-2-solutions-img">
                            <img src="assets/img/banner-2-slide-1.jpg" alt="Image" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- SOLUTIONS SECTION END -->


        <!-- STATS SECTION START -->
        <div class="ul-container">
            <div class="ul-2-stats ul-section-spacing">
                <div class="ul-2-stats-wrapper wow animate__fadeInUp">
                    <div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 ul-bs-row justify-content-center">
                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">9.6K</span>
                                <span class="txt">Happy Customers World Wide.</span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="ul-2-stats-item active">
                                <span class="number">1.9M</span>
                                <span class="txt">Transactions Processed Daily basis.</span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">9600+</span>
                                <span class="txt">ATMs and Branches Across Globally.</span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">25+</span>
                                <span class="txt">Years of Trusted Banking Service.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- STATS SECTION END -->


        <!-- CALCULATOR SECTION START -->
        <section class="ul-calculator overflow-hidden">
            <div class="ul-container">
                <div class="row justify-content-between align-items-end g-0">
                    <!-- calculator -->
                    <div class="col-md-7">
                        <div class="ul-calculator-txt">
                            <span class="ul-2-section-sub-title">Loan Calculator</span>
                            <h2 class="ul-2-section-title">Flexible Online Loan Calculator</h2>
                            <p class="ul-2-section-descr">Loan Questions? Check Our <a href="faq.html">Faq's</a> Page</p>
                            <div class="ul-calculator-form-wrapper">
                                <form action="#">
                                    <div class="form-group">
                                        <label for="amount">Loan Amount</label>
                                        <input type="text" id="amount" placeholder="$25,0000">
                                    </div>
                                    <div class="form-group">
                                        <label for="term">Loan Term (Years)</label>
                                        <input type="text" id="term" placeholder="5">
                                    </div>
                                    <div class="form-group">
                                        <label for="interest">Interest Rate</label>
                                        <input type="text" id="interest" placeholder="8.00%">
                                    </div>
                                    <div class="form-group">
                                        <label for="total">Total Payable Amount</label>
                                        <input type="text" id="total" placeholder="$27,0300">
                                    </div>

                                    <div>
                                        <button class="ul-btn loan-apply-opener">Apply For Loan <i class="flaticon-arrow-up-right"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <!-- img -->
                    <div class="col-md-5">
                        <div class="d-flex justify-content-start">
                            <div class="ul-calculator-img-wrapper">
                                <img src="assets/img/calculator-img.png" alt="Calculator Image" class="ul-calculator-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CALCULATOR SECTION END -->


        <!-- CREDIT CARD SECTION START -->
        <section class="ul-2-cards ul-section-spacing">
            <div class="ul-container">
                <!-- section heading -->
                <div class="ul-section-heading justify-content-center text-center">
                    <div>
                        <span class="ul-2-section-sub-title">Credit Cards</span>
                        <h2 class="ul-2-section-title">Discover Our Global Range <br> of Credit Cards</h2>
                    </div>
                </div>

                <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 align-items-center">
                    <div class="col order-lg-1 order-2">
                        <!-- single card -->
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Rewards Cards</h3>
                            <p class="ul-2-card-descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                        </div>
                        <!-- single card -->
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Cashback Cards</h3>
                            <p class="ul-2-card-descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                        </div>
                    </div>

                    <div class="col-lg col-sm-12 col-12 order-lg-2 order-1">
                        <div class="ul-2-cards-imgs">
                            <div class="img-1-wrapper">
                                <img src="assets/img/credit-card-1.png" alt="Card Image" class="ul-2-cards-img img-1 wow animate__fadeInUpBig">
                            </div>
                            <img src="assets/img/credit-card-2.png" alt="Card Image" class="ul-2-cards-img img-2 wow animate__bounceInUp">
                        </div>
                    </div>

                    <div class="col order-3">
                        <!-- single card -->
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Travel Cards</h3>
                            <p class="ul-2-card-descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                        </div>
                        <!-- single card -->
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Insurance Cards</h3>
                            <p class="ul-2-card-descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CREDIT CARD SECTION END -->


        <!-- INVESTMENT SECTION START -->
        <section class="ul-2-investments ul-2-banner">
            <div class="ul-container">
                <!-- section-heading -->
                <div class="ul-section-heading">
                    <div class="left">
                        <span class="ul-2-section-sub-title text-white">Investment</span>
                        <h2 class="ul-2-section-title">Financial cashflow Investment Sectors in toronto</h2>
                    </div>

                    <div class="right">
                        <p class="ul-2-section-descr">Frequently occur that pleasures have to repudiated and annoyances accepte the wise man always holds.</p>
                        <a href="services.html" class="ul-btn">View All <i class="flaticon-arrow-up-right"></i></a>
                    </div>
                </div>

                <div class="ul-2-investments-wrapper">
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/investment-img.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">01</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Stock Market (Equities)</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/investment-img.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">02</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Government Bonds & Treasury</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/investment-img.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">03</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Corporate Real Estate</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/investment-img.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">04</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Private Equity / Venture Capital</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- INVESTMENT SECTION END -->


        <!-- TEAM SECTION START -->
        <section class="ul-2-team ul-section-spacing">
            <div class="ul-container">
                <div class="row ul-bs-row flex-column-reverse flex-md-row">
                    <div class="col-lg-8 col-md-7">
                        <div class="ul-2-team-slider-wrapper">
                            <div class="ul-2-team-slider swiper">
                                <div class="swiper-wrapper">
                                    <!-- single team member -->
                                    <div class="swiper-slide">
                                        <div class="ul-2-team-member">
                                            <div class="ul-2-team-member-img">
                                                <img src="assets/img/team-member-1.jpg" alt="Team Member Image">
                                            </div>
                                            <div class="ul-2-team-member-info">
                                                <span class="ul-2-team-member-name"><a href="#">John Doe</a></span>
                                                <span class="ul-2-team-member-role">CEO & Founder</span>
                                            </div>
                                            <div class="ul-2-team-member-socials">
                                                <span class="icon"><i class="flaticon-share"></i></span>
                                                <div class="links">
                                                    <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                                    <a href="#"><i class="flaticon-linkedin"></i></a>
                                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single team member -->
                                    <div class="swiper-slide">
                                        <div class="ul-2-team-member">
                                            <div class="ul-2-team-member-img">
                                                <img src="assets/img/team-member-2.jpg" alt="Team Member Image">
                                            </div>
                                            <div class="ul-2-team-member-info">
                                                <span class="ul-2-team-member-name"><a href="#">Jasmin thomas</a></span>
                                                <span class="ul-2-team-member-role">Director</span>
                                            </div>
                                            <div class="ul-2-team-member-socials">
                                                <span class="icon"><i class="flaticon-share"></i></span>
                                                <div class="links">
                                                    <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                                    <a href="#"><i class="flaticon-linkedin"></i></a>
                                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single team member -->
                                    <div class="swiper-slide">
                                        <div class="ul-2-team-member">
                                            <div class="ul-2-team-member-img">
                                                <img src="assets/img/team-member-3.jpg" alt="Team Member Image">
                                            </div>
                                            <div class="ul-2-team-member-info">
                                                <span class="ul-2-team-member-name"><a href="#">Ashley Smith</a></span>
                                                <span class="ul-2-team-member-role">Manager</span>
                                            </div>
                                            <div class="ul-2-team-member-socials">
                                                <span class="icon"><i class="flaticon-share"></i></span>
                                                <div class="links">
                                                    <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                                    <a href="#"><i class="flaticon-linkedin"></i></a>
                                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- single team member -->
                                    <div class="swiper-slide">
                                        <div class="ul-2-team-member">
                                            <div class="ul-2-team-member-img">
                                                <img src="assets/img/team-member-4.jpg" alt="Team Member Image">
                                            </div>
                                            <div class="ul-2-team-member-info">
                                                <span class="ul-2-team-member-name"><a href="#">Peter Smith</a></span>
                                                <span class="ul-2-team-member-role">Designer</span>
                                            </div>
                                            <div class="ul-2-team-member-socials">
                                                <span class="icon"><i class="flaticon-share"></i></span>
                                                <div class="links">
                                                    <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                                                    <a href="#"><i class="flaticon-twitter"></i></a>
                                                    <a href="#"><i class="flaticon-linkedin"></i></a>
                                                    <a href="#"><i class="flaticon-instagram"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- section heading -->
                    <div class="col-lg-4 col-md-5">
                        <div class="ul-section-heading flex-column align-items-start gap-0">
                            <div>
                                <span class="ul-2-section-sub-title">Our Corporate Teams</span>
                                <h2 class="ul-2-section-title">Our Corporate Team Leaders</h2>
                                <p class="ul-2-section-descr">Every pleasure is to be welcomed and every pain avoided duty or the obligations of business our power of choice is untrammelled and when nothing prevents.</p>
                            </div>

                            <div class="ul-2-team-heading-bottom">
                                <div class="imgs">
                                    <img src="assets/img/user-1.png" alt="Person">
                                    <img src="assets/img/user-3.png" alt="Person">
                                    <img src="assets/img/user-2.png" alt="Person">
                                    <span class="number">+10</span>
                                </div>
                                <div class="ul-2-team-slider-nav" id="ul-2-team-slider-nav">
                                    <button class="prev"><i class="flaticon-back"></i></button>
                                    <button class="next"><i class="flaticon-next"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- TEAM SECTION END -->


        <!-- FAQ SECTION START -->
        <section class="ul-2-faq ul-2-banner ul-section-spacing">
            <div class="ul-container">
                <div class="row">
                    <!-- txt -->
                    <div class="col-lg-6 col-sm-9 col-12">
                        <div class="ul-2-faq-txt">
                            <span class="ul-2-section-sub-title">FAQ</span>
                            <h2 class="ul-2-section-title">Read Questions & Answers</h2>

                            <div class="ul-2-faq-accordion ul-accordion">
                                <div class="ul-single-accordion-item open">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">01</span>
                                            <span class="ul-single-accordion-item__title">How do I open a new account?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">Automation & workflow features include a drag & drop builder, automated task assignments, conditional with good triggers, & api integrations. Automation & workflow features include a drag & drop builder, automated.</p>
                                    </div>
                                </div>

                                <div class="ul-single-accordion-item">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">02</span>
                                            <span class="ul-single-accordion-item__title">How can I check my account balance?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">Automation & workflow features include a drag & drop builder, automated task assignments, conditional with good triggers, & api integrations. Automation & workflow features include a drag & drop builder, automated.</p>
                                    </div>
                                </div>

                                <div class="ul-single-accordion-item">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">03</span>
                                            <span class="ul-single-accordion-item__title">How do I open a new account?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">Automation & workflow features include a drag & drop builder, automated task assignments, conditional with good triggers, & api integrations. Automation & workflow features include a drag & drop builder, automated.</p>
                                    </div>
                                </div>

                                <div class="ul-single-accordion-item">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">04</span>
                                            <span class="ul-single-accordion-item__title">How do I open a new account?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">Automation & workflow features include a drag & drop builder, automated task assignments, conditional with good triggers, & api integrations. Automation & workflow features include a drag & drop builder, automated.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="assets/img/faq-bg.jpg" alt="background image" class="ul-2-faq-bg">
        </section>
        <!-- FAQ SECTION END -->


        <!-- TESTIMONIALS SECTION START -->
        <section class="ul-2-testimonials ul-section-spacing">
            <div class="ul-container">
                <!-- section heading -->
                <div class="ul-section-heading justify-content-center text-center">
                    <div>
                        <span class="ul-2-section-sub-title">Testimonials</span>
                        <h2 class="ul-2-section-title mb-0">What People Say About Us</h2>
                    </div>
                </div>
            </div>

            <!-- testimonials -->
            <div class="ul-2-testimonials-slider swiper">
                <div class="swiper-wrapper">
                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img//user-1.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Marvin McKinney</span>
                                        <span class="ul-2-testimony-reviewer-role">Lead Designer</span>
                                    </div>
                                </div>

                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>

                            <p class="ul-2-testimony-txt">Aonsectetur adipiscing elit Aenean scelerisque augue consequat Quisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod now</p>

                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img//user-2.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Marvin McKinney</span>
                                        <span class="ul-2-testimony-reviewer-role">Lead Designer</span>
                                    </div>
                                </div>

                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>

                            <p class="ul-2-testimony-txt">Aonsectetur adipiscing elit Aenean scelerisque augue consequat Quisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod now</p>

                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img//user-3.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Marvin McKinney</span>
                                        <span class="ul-2-testimony-reviewer-role">Lead Designer</span>
                                    </div>
                                </div>

                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>

                            <p class="ul-2-testimony-txt">Aonsectetur adipiscing elit Aenean scelerisque augue consequat Quisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod now</p>

                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img//user-1.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Marvin McKinney</span>
                                        <span class="ul-2-testimony-reviewer-role">Lead Designer</span>
                                    </div>
                                </div>

                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>

                            <p class="ul-2-testimony-txt">Aonsectetur adipiscing elit Aenean scelerisque augue consequat Quisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod now</p>

                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <!-- single slide -->
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img//user-2.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Marvin McKinney</span>
                                        <span class="ul-2-testimony-reviewer-role">Lead Designer</span>
                                    </div>
                                </div>

                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>

                            <p class="ul-2-testimony-txt">Aonsectetur adipiscing elit Aenean scelerisque augue consequat Quisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod now</p>

                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- TESTIMONIALS SECTION END -->


        <!-- BLOG SECTION START -->
        <section class="ul-2-blogs ul-2-banner ul-section-spacing">
            <div class="ul-container">
                <!-- section heading -->
                <div class="ul-section-heading">
                    <div>
                        <span class="ul-2-section-sub-title">Latest Blog</span>
                        <h2 class="ul-2-section-title mb-0 text-black">Our Latest Blog & News</h2>
                    </div>
                    <a href="blogs.html" class="ul-btn">View All Blogs <i class="flaticon-arrow-up-right"></i></a>
                </div>

                <!-- blogs  -->
                <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 g-3 g-lg-4 justify-content-center">
                    <!-- single blog -->
                    <div class="col">
                        <div class="ul-2-blog">
                            <div class="ul-2-blog-img">
                                <img src="assets/img/blog-1.jpg" alt="Blog Image">
                            </div>

                            <div class="ul-2-blog-txt">
                                <div class="ul-2-blog-infos">
                                    <span><i class="flaticon-calendar"></i> 11 March 2025</span>
                                    <span><i class="flaticon-sms"></i> 05 Comments</span>
                                </div>
                                <h3 class="ul-2-blog-title"><a href="blog-details.html">Meeting of business in modern office.</a></h3>
                                <a href="blog-details.html" class="ul-2-blog-btn">Read More <i class="flaticon-arrow-up-right-curve"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- single blog -->
                    <div class="col">
                        <div class="ul-2-blog">
                            <div class="ul-2-blog-img">
                                <img src="assets/img/blog-2.jpg" alt="Blog Image">
                            </div>

                            <div class="ul-2-blog-txt">
                                <div class="ul-2-blog-infos">
                                    <span><i class="flaticon-calendar"></i> 11 March 2025</span>
                                    <span><i class="flaticon-sms"></i> 05 Comments</span>
                                </div>
                                <h3 class="ul-2-blog-title"><a href="blog-details.html">Person looking over our finance graphs.</a></h3>
                                <a href="blog-details.html" class="ul-2-blog-btn">Read More <i class="flaticon-arrow-up-right-curve"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- single blog -->
                    <div class="col">
                        <div class="ul-2-blog">
                            <div class="ul-2-blog-img">
                                <img src="assets/img/blog-3.jpg" alt="Blog Image">
                            </div>

                            <div class="ul-2-blog-txt">
                                <div class="ul-2-blog-infos">
                                    <span><i class="flaticon-calendar"></i> 11 March 2025</span>
                                    <span><i class="flaticon-sms"></i> 05 Comments</span>
                                </div>
                                <h3 class="ul-2-blog-title"><a href="blog-details.html">Co-workers with pens pointing a bar chart.</a></h3>
                                <a href="blog-details.html" class="ul-2-blog-btn">Read More <i class="flaticon-arrow-up-right-curve"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- BLOG SECTION END -->


        <!-- CLIENTS SECTION START -->
        <section class="ul-2-clients ul-section-spacing">
            <div class="ul-container">
                <div class="ul-2-clients-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><img src="assets/img/client-1.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-2.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-3.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-4.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-5.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-6.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-7.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-8.svg" alt="Clients Image"></div>
                        <div class="swiper-slide"><img src="assets/img/client-1.svg" alt="Clients Image"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CLIENTS SECTION END -->
    </main>

    <!-- FOOTER SECTION START -->
    <footer class="ul-2-footer">
        <div class="ul-container">
            <!-- footer top -->
            <div class="ul-2-footer-top">
                <div class="ul-2-footer-top-wrapper">
                    <div class="ul-2-footer-about">
                        <a href="#" class="logo-wrapper"><img src="assets/img/logo-white.svg" alt="Logo"></a>
                        <p class="ul-2-footer-about-txt">Your trusted partner in global financial markets. Trade with confidence using our advanced platforms. Trade with power, trade with AceMax.</p>
                        <div class="ul-2-footer-socials">
                            <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                            <a href="#"><i class="flaticon-twitter"></i></a>
                            <a href="#"><i class="flaticon-linkedin"></i></a>
                            <a href="#"><i class="flaticon-instagram"></i></a>
                        </div>
                    </div>

                    <div class="ul-2-footer-widget">
                        <h3 class="ul-2-footer-widget-title">Useful Links</h3>

                        <div class="ul-2-footer-widget-links">
                            <a href="#">Financial Planning</a>
                            <a href="#">Economy</a>
                            <a href="#">Tax return</a>
                            <a href="#">Management</a>
                        </div>
                    </div>

                    <div class="ul-2-footer-widget ul-2-footer-contact-widget">
                        <h3 class="ul-2-footer-widget-title">Contact us</h3>

                        <div class="ul-2-footer-contact-infos">
                            <div class="ul-2-footer-contact-info">
                                <span class="ul-2-footer-contact-info-icon"><i class="flaticon-location-pin"></i></span>
                                <span class="ul-2-footer-contact-info-txt">3891 Ranchview Dr. Richardson, California 62639</span>
                            </div>
                            <div class="ul-2-footer-contact-info">
                                <span class="ul-2-footer-contact-info-icon"><i class="flaticon-clock"></i></span>
                                <span class="ul-2-footer-contact-info-address">Saturday - Thursday : 8:30 am - 10:30 pm</span>
                            </div>
                        </div>
                    </div>

                    <div class="ul-2-footer-widget ul-2-footer-nwsltr-widget">
                        <h3 class="ul-2-footer-widget-title">Get Newsletter</h3>

                        <form action="#" class="ul-2-footer-nwsltr-form">
                            <input type="email" id="email" name="email" placeholder="Your Email Address">
                            <button type="submit"><i class="flaticon-arrow-up-right"></i> SUBSCRIBE NOW</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- footer bottom -->
            <div class="ul-2-footer-bottom justify-content-center">
                <p class="copyright">&copy; 2025 Finantics All rights reserved.</p>
            </div>
        </div>
        <div class="ul-2-footer-vectors">
            <img src="assets/img/footer-2-vector-1.svg" alt="vector" class="ul-2-footer-vector vector-1">
            <div class="ul-2-footer-vector vector-2"><img src="assets/img/footer-2-vector-2.svg" alt="vector"></div>
        </div>
    </footer>
    <!-- FOOTER SECTION END -->

    <!-- Vendor JS -->
    <script src="assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/animate-wow/wow.min.js"></script>
    <script src="assets/vendor/splittype/index.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/fslightbox/fslightbox.js"></script>
    <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/tab.js"></script>
    <script src="assets/js/accordion.js"></script>
</body>

</html>