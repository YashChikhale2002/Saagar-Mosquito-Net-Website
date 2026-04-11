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
        <!-- BREADCRUMB SECTION START -->
        <section class="ul-breadcrumb ul-2-banner">
            <div class="ul-container">
                <h1 class="ul-breadcrumb-title">About Us</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index.html">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">About Us</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- ABOUT SECTION START -->
        <section class="ul-2-about ul-section-spacing bg-white">
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


        <!-- HISTORY SECTION START -->
        <section class="ul-history ul-section-spacing">
            <div class="ul-container">
                <!-- section heading -->
                <div class="ul-section-heading">
                    <div class="left">
                        <span class="ul-2-section-sub-title">Company Histroy</span>
                        <h2 class="ul-2-section-title">Years of Dedication A Legacy in the Making</h2>
                    </div>

                    <div class="right">
                        <div class="ul-history-slider-nav ul-2-team-slider-nav">
                            <button class="prev"><i class="flaticon-back"></i></button>
                            <button class="next"><i class="flaticon-next"></i></button>
                        </div>
                    </div>
                </div>

                <!-- history slider -->
                <div class="ul-history-slider swiper">
                    <div class="swiper-wrapper">
                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">01</div>

                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2005 - Internet Banking Launch</h3>
                                        <p class="ul-history-slide-descr">Rolled out secure online banking, allowing customers to access accounts and manage finances remotely.</p>
                                    </div>
                                </div>

                                <div class="ul-history-slide-img">
                                    <img src="assets/img/history-slide-1.jpg" alt="Image">
                                </div>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">02</div>

                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2010 - Internet Banking Launch</h3>
                                        <p class="ul-history-slide-descr">Rolled out secure online banking, allowing customers to access accounts and manage finances remotely.</p>
                                    </div>
                                </div>

                                <div class="ul-history-slide-img">
                                    <img src="assets/img/banner-2-slide-1.jpg" alt="Image">
                                </div>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">03</div>

                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2015 - Internet Banking Launch</h3>
                                        <p class="ul-history-slide-descr">Rolled out secure online banking, allowing customers to access accounts and manage finances remotely.</p>
                                    </div>
                                </div>

                                <div class="ul-history-slide-img">
                                    <img src="assets/img/investment-bg.jpg" alt="Image">
                                </div>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">04</div>

                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2020 - Internet Banking Launch</h3>
                                        <p class="ul-history-slide-descr">Rolled out secure online banking, allowing customers to access accounts and manage finances remotely.</p>
                                    </div>
                                </div>

                                <div class="ul-history-slide-img">
                                    <img src="assets/img/history-slide-1.jpg" alt="Image">
                                </div>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">05</div>

                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2023 - Internet Banking Launch</h3>
                                        <p class="ul-history-slide-descr">Rolled out secure online banking, allowing customers to access accounts and manage finances remotely.</p>
                                    </div>
                                </div>

                                <div class="ul-history-slide-img">
                                    <img src="assets/img/banner-2-slide-1.jpg" alt="Image">
                                </div>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">06</div>

                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2024 - Internet Banking Launch</h3>
                                        <p class="ul-history-slide-descr">Rolled out secure online banking, allowing customers to access accounts and manage finances remotely.</p>
                                    </div>
                                </div>

                                <div class="ul-history-slide-img">
                                    <img src="assets/img/investment-bg.jpg" alt="Image">
                                </div>
                            </div>
                        </div>

                        <!-- single slide -->
                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">07</div>

                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2025 - Internet Banking Launch</h3>
                                        <p class="ul-history-slide-descr">Rolled out secure online banking, allowing customers to access accounts and manage finances remotely.</p>
                                    </div>
                                </div>

                                <div class="ul-history-slide-img">
                                    <img src="assets/img/history-slide-1.jpg" alt="Image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ul-history-years-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">2005</div>
                        <div class="swiper-slide">2010</div>
                        <div class="swiper-slide">2015</div>
                        <div class="swiper-slide">2020</div>
                        <div class="swiper-slide">2023</div>
                        <div class="swiper-slide">2024</div>
                        <div class="swiper-slide">2025</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- HISTORY SECTION END -->


        <!-- MISSION SECTION START  -->
        <section class="ul-mission ul-section-spacing">
            <div class="ul-container">
                <div class="row gx-0 gy-4 align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="ul-mission-txt">
                            <div class="tab-group">
                                <div class="ul-mission-tab-navs">
                                    <button class="tab-nav active" data-tab="tab-1">Our Mission</button>
                                    <button class="tab-nav" data-tab="tab-2">Our Vision</button>
                                    <button class="tab-nav" data-tab="tab-3">Why Choose us</button>
                                </div>

                                <div class="tabs-wrapper">
                                    <div class="ul-tab active" id="tab-1">
                                        <div class="ul-mission-tab-content">
                                            <p class="ul-mission-tab-descr">Our mission is to empower businesses through best innovative IT solutions that drive growth, efficiency digital transformation. We committed to delivering digital transformation. We committed to delivering digital transformation. We committed to delivering digital transformation. We committed to delivering digital transformation. </p>
                                            <a href="contact.html" class="ul-btn"> Contact Us <i class="flaticon-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="ul-tab" id="tab-2">
                                        <div class="ul-mission-tab-content">
                                            <p class="ul-mission-tab-descr">Our vision is to empower businesses through best innovative IT solutions that drive growth, efficiency digital transformation. We committed to delivering digital transformation. We committed to delivering digital transformation. We committed to delivering digital transformation. We committed to delivering digital transformation. </p>
                                            <a href="contact.html" class="ul-btn"> Contact Us <i class="flaticon-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="ul-tab" id="tab-3">
                                        <div class="ul-mission-tab-content">
                                            <p class="ul-mission-tab-descr">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt facilis placeat voluptates omnis maxime, debitis commodi, praesentium aut, facere eos nobis. Porro non voluptatum ab dolores iusto enim, vitae aperiam ipsam est facilis! Consectetur rerum eaque ipsam atque voluptatum nobis.</p>
                                            <a href="contact.html" class="ul-btn"> Contact Us <i class="flaticon-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-6">
                        <div class="ul-mission-img">
                            <img src="assets/img/mission-img.jpg" alt="Image">
                            <a href="https://youtu.be/EEX0EHTTePE?si=TxbhzBCGoTx64WEe" data-fslightbox="mission-video" class="ul-2-about-play-btn"><i class="flaticon-play-button-arrowhead"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- MISSION SECTION END -->


        <!-- STATS SECTION START -->
        <div class="ul-container">
            <div class="ul-2-stats ul-section-spacing pt-0 border-0">
                <div class="ul-2-stats-wrapper wow animate__fadeInUp">
                    <div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 ul-bs-row justify-content-center">
                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">9.6K</span>
                                <span class="txt">Happy Customers World Wide.</span>
                            </div>
                        </div>

                        <div class="col">
                            <div class="ul-2-stats-item">
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


        <!-- TESTIMONIALS SECTION START -->
        <section class="ul-2-testimonials ul-section-spacing pt-0">
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
                    <a href="#" class="ul-btn">View All Blogs <i class="flaticon-arrow-up-right"></i></a>
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

    <?php include 'include/footer.php'; ?>


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
    <script src="assets/js/progressbar.js"></script>
    <script src="assets/js/accordion.js"></script>
</body>

</html>