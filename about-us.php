<?php
session_start();
include 'include/config.php';

$page_title       = "About Us | Saagar Enterprises – Mosquito Net Manufacturer & Dealer in Nagpur Since 2013";
$meta_description = "Learn about Saagar Enterprises – Nagpur's most trusted mosquito net manufacturer & dealer since 2013. 500+ happy customers, 5-star rated, expert installation across all areas of Nagpur. Custom-fitted pleated, roll-up, velcro & bed mosquito nets.";
$meta_keywords    = "about Saagar Enterprises, mosquito net manufacturer Nagpur, mosquito net dealer Nagpur since 2013, best mosquito net company Nagpur, Saagar Enterprises history, mosquito net installation Nagpur, saagarmosquitonet.com";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <meta name="keywords" content="<?php echo $meta_keywords; ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://saagarmosquitonet.com/about-us">

    <!-- Open Graph SEO -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="About Saagar Enterprises | Mosquito Net Dealer Nagpur Since 2013">
    <meta property="og:description" content="Nagpur's #1 mosquito net manufacturer & dealer since 2013. 500+ happy customers, custom-fitted nets, expert installation. Call +91 7719806088.">
    <meta property="og:url" content="https://saagarmosquitonet.com/about-us">
    <meta property="og:image" content="https://saagarmosquitonet.com/assets/img/mosquito-net-nagpur.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="About Saagar Enterprises | Mosquito Net Nagpur">
    <meta name="twitter:description" content="Nagpur's trusted mosquito net manufacturer since 2013. Expert installation, 500+ customers, 5-star rated.">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/vendor/animate-wow/animate.min.css">
    <link rel="stylesheet" href="assets/icon/flaticon_cashflow.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="home-2">
    <!-- ENQUIRY FORM START -->
    <div class="ul-form-modal-bg" id="login-form-modal">
        <div class="ul-form-modal-content">
            <button class="ul-form-modal-closer"><i class="flaticon-close"></i></button>
            <div class="row row-cols-md-2 row-cols-1 g-0">
                <div class="col">
                    <div class="ul-form-modal-img">
                        <img src="assets/img/login-amico.svg" alt="Get Free Mosquito Net Quote Nagpur">
                    </div>
                </div>
                <div class="col">
                    <div class="ul-form-modal-form-wrapper">
                        <form action="#" class="ul-form-modal-form">
                            <h2 class="ul-form-modal-title">Get Free Quote!</h2>
                            <p class="ul-form-modal-sub-title">Contact Saagar Enterprises Nagpur</p>
                            <div class="form-group">
                                <input type="text" name="name" id="name" placeholder="Your Full Name">
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" id="phone" placeholder="Mobile Number">
                            </div>
                            <div class="form-group mt-4">
                                <button class="ul-btn w-100 justify-content-center">Get Free Quote <i class="flaticon-arrow-up-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ENQUIRY FORM END -->


    <!-- MEASUREMENT BOOKING FORM START -->
    <div class="ul-form-modal-bg" id="loan-apply-form-modal">
        <div class="ul-form-modal-content">
            <button class="ul-form-modal-closer"><i class="flaticon-close"></i></button>
            <div class="row row-cols-md-2 row-cols-1 g-0">
                <div class="col">
                    <div class="ul-form-modal-img">
                        <img src="assets/img/Manage money-pana.svg" alt="Book Free Mosquito Net Measurement Nagpur">
                    </div>
                </div>
                <div class="col">
                    <div class="ul-form-modal-form-wrapper">
                        <form action="#" class="ul-form-modal-form">
                            <h2 class="ul-form-modal-title">Book Free Measurement</h2>
                            <p class="ul-form-modal-sub-title">We visit your home & measure for FREE!</p>
                            <div class="form-group">
                                <input type="text" name="name" id="mname" placeholder="Your Full Name">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <textarea name="address" id="address" placeholder="Your Full Address in Nagpur"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" name="net_type" id="net_type" placeholder="Net Type (Window / Door / Bed)">
                            </div>
                            <div class="form-group">
                                <input type="tel" name="phone" id="mphone" placeholder="Mobile Number">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date" id="date" placeholder="Preferred Visit Date">
                            </div>
                            <div class="form-group">
                                <select name="net-system" id="net-system">
                                    <option value="" disabled selected>Select Mosquito Net Type</option>
                                    <option value="pleated-net">Pleated Mosquito Net</option>
                                    <option value="roll-up-net">Roll-Up Mosquito Net</option>
                                    <option value="roll-a-side-net">Roll-A-Side Mosquito Net</option>
                                    <option value="velcro-net">Velcro Mosquito Net</option>
                                    <option value="fixed-frame-net">Fixed Frame Mosquito Net</option>
                                    <option value="openable-frame-net">Openable Frame Mosquito Net</option>
                                    <option value="bed-net">Bed Mosquito Net</option>
                                </select>
                            </div>
                            <div class="form-group mt-4">
                                <button class="ul-btn w-100 justify-content-center">Book Free Visit <i class="flaticon-arrow-up-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MEASUREMENT BOOKING FORM END -->


    <div class="ul-sidebar">
        <div class="ul-sidebar-header">
            <div class="ul-sidebar-header-logo">
                <a href="index">
                    <img src="assets/img/logo.svg" alt="Saagar Enterprises Mosquito Net Nagpur" class="logo">
                </a>
            </div>
            <button class="ul-sidebar-closer"><i class="flaticon-close"></i></button>
        </div>
        <div class="ul-sidebar-header-nav-wrapper d-block d-lg-none"></div>
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
                <input type="search" name="search" id="ul-search" placeholder="Search Mosquito Net Products...">
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
                    <a href="index">Home</a>
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
                            <img src="assets/img/about-2-img.png" alt="Saagar Enterprises Mosquito Net Dealer Nagpur" class="main-img">
                            <div class="ul-2-about-img-bgs">
                                <div class="ul-2-about-img-bg-1">
                                    <img src="assets/img/about-2-img-bg-1.jpg" alt="Mosquito Net Installation Nagpur">
                                </div>
                                <img src="assets/img/about-2-img-bg-2.jpg" alt="Window Mosquito Net Nagpur">
                            </div>
                            <a href="https://youtu.be/EEX0EHTTePE?si=TxbhzBCGoTx64WEe" data-fslightbox="video" class="ul-2-about-play-btn"><i class="flaticon-play-button-arrowhead"></i></a>
                            <div class="ul-2-about-img-txt"><img src="assets/img/about-2-img-logo.svg" alt="Saagar Enterprises Logo"><span class="txt">SINCE 2013</span></div>
                        </div>
                    </div>

                    <!-- txt -->
                    <div class="col">
                        <div class="ul-2-about-txt">
                            <span class="ul-2-section-sub-title">About Saagar Enterprises</span>
                            <h2 class="ul-2-section-title">Nagpur's Most Trusted Mosquito Net Manufacturer & Dealer Since 2013</h2>
                            <p class="ul-2-section-descr">Saagar Enterprises has been Nagpur's most trusted mosquito net manufacturer and dealer since 2013. We specialize in custom-fitted mosquito net systems for windows, doors, balconies, and beds — protecting your family from mosquitoes, dengue, and malaria all year round with premium quality and expert installation.</p>
                            <div class="ul-2-about-points">
                                <div class="ul-2-about-point">
                                    <img src="assets/img/tick-inside-circle.svg" alt="icon" class="icon">
                                    <span class="title">Custom Measurement & Zero-Gap Professional Installation Across All Areas of Nagpur</span>
                                </div>
                                <div class="ul-2-about-point">
                                    <img src="assets/img/tick-inside-circle.svg" alt="icon" class="icon">
                                    <span class="title">Premium Quality Nylon, HDPE & Aluminium Frame Mosquito Nets at Reasonable Prices</span>
                                </div>
                            </div>
                            <p class="ul-2-about-descr">With over 10 years of experience and 500+ happy customers across Nagpur, Saagar Enterprises is rated 5 stars for prompt service, honest pricing, and durable mosquito net installations. We serve Mahal, Raghuji Nagar, Dharampeth, Wardha Road, and all areas of Nagpur with on-site repair and after-sales support.</p>
                            <a href="contact" class="ul-btn">Book Free Home Visit <i class="flaticon-arrow-up-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ABOUT SECTION END -->


        <!-- HISTORY SECTION START -->
        <section class="ul-history ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading">
                    <div class="left">
                        <span class="ul-2-section-sub-title">Our Journey</span>
                        <h2 class="ul-2-section-title">10+ Years of Protecting Nagpur Homes from Mosquitoes</h2>
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

                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">01</div>
                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2013 – Saagar Enterprises Founded in Nagpur</h3>
                                        <p class="ul-history-slide-descr">Saagar Enterprises was established in Mahal, Nagpur with a mission to provide high-quality, custom-fitted mosquito nets for homes and offices at affordable prices.</p>
                                    </div>
                                </div>
                                <div class="ul-history-slide-img">
                                    <img src="assets/img/history-slide-1.jpg" alt="Saagar Enterprises Founded 2013 Nagpur">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">02</div>
                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2015 – Expanded to Pleated & Roll-Up Net Systems</h3>
                                        <p class="ul-history-slide-descr">We introduced advanced pleated mosquito net and roll-up screen systems for wider windows and balcony openings, serving growing demand across Nagpur.</p>
                                    </div>
                                </div>
                                <div class="ul-history-slide-img">
                                    <img src="assets/img/banner-2-slide-1.jpg" alt="Pleated Mosquito Net Nagpur 2015">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">03</div>
                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2018 – Opened Second Branch at Raghuji Nagar</h3>
                                        <p class="ul-history-slide-descr">Due to growing demand, Saagar Enterprises opened its second showroom at Raghuji Nagar, Nagpur — making mosquito net solutions even more accessible across the city.</p>
                                    </div>
                                </div>
                                <div class="ul-history-slide-img">
                                    <img src="assets/img/investment-bg.jpg" alt="Saagar Enterprises Raghuji Nagar Branch Nagpur">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">04</div>
                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2020 – 200+ Families Protected Across Nagpur</h3>
                                        <p class="ul-history-slide-descr">Crossed a major milestone of 200+ successful mosquito net installations across Nagpur — earning 5-star reviews for quality, punctuality, and professional service.</p>
                                    </div>
                                </div>
                                <div class="ul-history-slide-img">
                                    <img src="assets/img/history-slide-1.jpg" alt="Mosquito Net Installation Milestone Nagpur 2020">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">05</div>
                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2023 – 500+ Happy Customers & 5-Star Rating</h3>
                                        <p class="ul-history-slide-descr">Saagar Enterprises reached 500+ happy customers with a consistent 5-star Google rating — recognized as Nagpur's most trusted mosquito net dealer for window, door, and bed net solutions.</p>
                                    </div>
                                </div>
                                <div class="ul-history-slide-img">
                                    <img src="assets/img/banner-2-slide-1.jpg" alt="Saagar Enterprises 500 Customers Nagpur 2023">
                                </div>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="ul-history-slide">
                                <div class="ul-history-slide-txt">
                                    <div class="ul-history-slide-index">06</div>
                                    <div class="ul-history-slide-txt-bottom">
                                        <h3 class="ul-history-slide-title">2025 – Still Nagpur's #1 Mosquito Net Solution</h3>
                                        <p class="ul-history-slide-descr">Continuing to serve Nagpur with 7+ types of mosquito net systems — pleated, roll-up, roll-a-side, velcro, fixed frame, openable frame & bed nets — with free home measurement visits and on-site repair support.</p>
                                    </div>
                                </div>
                                <div class="ul-history-slide-img">
                                    <img src="assets/img/investment-bg.jpg" alt="Saagar Enterprises Mosquito Net Nagpur 2025">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="ul-history-years-slider swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">2013</div>
                        <div class="swiper-slide">2015</div>
                        <div class="swiper-slide">2018</div>
                        <div class="swiper-slide">2020</div>
                        <div class="swiper-slide">2023</div>
                        <div class="swiper-slide">2025</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- HISTORY SECTION END -->


        <!-- MISSION SECTION START -->
        <section class="ul-mission ul-section-spacing">
            <div class="ul-container">
                <div class="row gx-0 gy-4 align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="ul-mission-txt">
                            <div class="tab-group">
                                <div class="ul-mission-tab-navs">
                                    <button class="tab-nav active" data-tab="tab-1">Our Mission</button>
                                    <button class="tab-nav" data-tab="tab-2">Our Vision</button>
                                    <button class="tab-nav" data-tab="tab-3">Why Choose Us</button>
                                </div>
                                <div class="tabs-wrapper">
                                    <div class="ul-tab active" id="tab-1">
                                        <div class="ul-mission-tab-content">
                                            <p class="ul-mission-tab-descr">Our mission is to protect every home in Nagpur from mosquitoes, dengue, and malaria through high-quality, custom-fitted mosquito net solutions. We are committed to delivering precise installation, honest pricing, and exceptional after-sales service — ensuring every family in Nagpur lives comfortably and mosquito-free.</p>
                                            <a href="contact" class="ul-btn">Contact Us <i class="flaticon-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="ul-tab" id="tab-2">
                                        <div class="ul-mission-tab-content">
                                            <p class="ul-mission-tab-descr">Our vision is to be Nagpur's most trusted and preferred mosquito net company — known for premium quality products, professional installation, and lasting customer relationships. We aim to expand our reach to every corner of Nagpur and Maharashtra, making mosquito-free living accessible to all.</p>
                                            <a href="contact" class="ul-btn">Contact Us <i class="flaticon-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                    <div class="ul-tab" id="tab-3">
                                        <div class="ul-mission-tab-content">
                                            <p class="ul-mission-tab-descr">Saagar Enterprises stands apart with 10+ years of experience, free home measurement visits, zero-gap professional installation, and on-site repair support across all areas of Nagpur. With 500+ happy customers and a consistent 5-star rating, we are Nagpur's most reliable mosquito net dealer.</p>
                                            <a href="contact" class="ul-btn">Contact Us <i class="flaticon-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-6">
                        <div class="ul-mission-img">
                            <img src="assets/img/mission-img.jpg" alt="Saagar Enterprises Mission – Mosquito Net Nagpur">
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
                                <span class="number">500+</span>
                                <span class="txt">Happy Customers Across Nagpur</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">5★</span>
                                <span class="txt">Star Rating from 40+ Reviews</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">7+</span>
                                <span class="txt">Types of Mosquito Net Systems</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">10+</span>
                                <span class="txt">Years of Trusted Service in Nagpur</span>
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
                <div class="ul-section-heading justify-content-center text-center">
                    <div>
                        <span class="ul-2-section-sub-title">Customer Reviews</span>
                        <h2 class="ul-2-section-title mb-0">What Nagpur Customers Say About Saagar Enterprises</h2>
                    </div>
                </div>
            </div>

            <div class="ul-2-testimonials-slider swiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Paresh Thakur</span>
                                        <span class="ul-2-testimony-reviewer-role">Nagpur</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Quality work at a very reasonable price. The exceptional quality and timely completion of work are their key strengths. The service is excellent and truly lives up to the name. Highly recommended Saagar Enterprises.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Vishal Vinchurkar</span>
                                        <span class="ul-2-testimony-reviewer-role">Nagpur</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Excellent work done by Saagar Enterprises team. Harish Ture was highly responsive and responsible throughout the installation process. Highly recommended for mosquito net services.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Pravin Bire</span>
                                        <span class="ul-2-testimony-reviewer-role">Nagpur</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Saagar Enterprises is a trusted name for mosquito nets and wall hanging cloth dryers. Service is quick with well-trained and polite staff. Great experience overall.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Tishya Kewadkar</span>
                                        <span class="ul-2-testimony-reviewer-role">Nagpur</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Wonderful experience with this company. Service was prompt and hassle-free. The team completed installation quickly with a neat and professional finish.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Arun Karole</span>
                                        <span class="ul-2-testimony-reviewer-role">Nagpur</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Perfect job done for mosquito net installation in my 3BHK flat. Skilled professionals and clean work. Highly recommended service.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i><i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- TESTIMONIALS SECTION END -->


        <!-- BLOG SECTION START -->
        <!-- BLOG SECTION END -->
        <?php include 'include/latest-blog.php'; ?>

        <!-- CLIENTS SECTION START -->
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