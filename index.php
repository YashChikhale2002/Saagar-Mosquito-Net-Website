<?php
// Start session (for login systems later)
session_start();

include 'include/config.php';

$page_title       = "Saagar Enterprises | Best Mosquito Net Dealer & Manufacturer in Nagpur";
$meta_description = "Saagar Enterprises – Nagpur's #1 mosquito net manufacturer & dealer since 2013. Custom window nets, door mesh, pleated nets, roll-up screens & bed mosquito nets. Expert installation. Call +91 7719806088 for FREE quote!";
$meta_keywords    = "mosquito net Nagpur, mosquito net dealer Nagpur, window mosquito net Nagpur, door mosquito net Nagpur, pleated mosquito net Nagpur, roll up mosquito net Nagpur, mosquito screen installation Nagpur, bed mosquito net Nagpur, velcro mosquito net, mosquito net for home Nagpur, best mosquito net Nagpur, Saagar Enterprises Nagpur, saagarmosquitonet.com, mosquito net manufacturer Nagpur, custom mosquito net Nagpur";

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
    <link rel="canonical" href="https://saagarmosquitonet.com/">

    <!-- Open Graph SEO -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Saagar Enterprises | Best Mosquito Net Dealer in Nagpur">
    <meta property="og:description" content="Custom mosquito net systems for homes & offices in Nagpur. Pleated, Roll-Up, Velcro & bed nets with professional installation. Call +91 7719806088 now!">
    <meta property="og:url" content="https://saagarmosquitonet.com/">
    <meta property="og:image" content="https://saagarmosquitonet.com/assets/img/mosquito-net-nagpur.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Saagar Enterprises | Best Mosquito Net in Nagpur">
    <meta name="twitter:description" content="Nagpur's trusted mosquito net manufacturer. Window nets, door mesh, pleated screens. Expert installation. Call +91 7719806088">

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/vendor/animate-wow/animate.min.css">
    <link rel="stylesheet" href="assets/icon/flaticon_cashflow.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

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
                        <img src="assets/img/login-amico.svg" alt="Mosquito Net Enquiry Nagpur">
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
        <!-- BANNER SECTION START -->
        <section class="ul-2-banner">
            <div class="swiper ul-2-banner-slider">
                <div class="swiper-wrapper">

                    <!-- Slide 1 -->
                    <div class="swiper-slide">
                        <div class="ul-2-banner-content">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <span class="ul-2-banner-sub-title"><span class="bg">Nagpur's #1</span> Mosquito Net Dealer Since 2013</span>
                                    <h1 class="ul-2-banner-title">Keep Your Home Mosquito-Free with Custom Net Solutions</h1>
                                    <p class="ul-2-banner-descr">Saagar Enterprises offers premium quality mosquito nets for windows, doors, and beds across Nagpur. Custom-fitted, professionally installed, and built to last — protecting your family from mosquitoes, dengue & malaria.</p>
                                    <div class="ul-2-banner-btns">
                                        <a href="about-us">About Us <i class="flaticon-arrow-up-right"></i></a>
                                        <a href="services">Our Services <i class="flaticon-arrow-up-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <img src="assets/img/home/banner1.jpeg" alt="Best Mosquito Net Dealer in Nagpur - Saagar Enterprises" class="ul-2-banner-slide-bg">
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide">
                        <div class="ul-2-banner-content">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <span class="ul-2-banner-sub-title"><span class="bg">Custom Fitted</span> Window & Door Mosquito Nets</span>
                                    <h1 class="ul-2-banner-title">Pleated, Roll-Up & Velcro Mosquito Nets for Every Home in Nagpur</h1>
                                    <p class="ul-2-banner-descr">From stylish pleated nets for balconies to easy velcro systems for windows — Saagar Enterprises provides the perfect mosquito protection solution for every corner of your home in Nagpur.</p>
                                    <div class="ul-2-banner-btns">
                                        <a href="about-us">Know More <i class="flaticon-arrow-up-right"></i></a>
                                        <a href="services">View Services <i class="flaticon-arrow-up-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <img src="assets/img/home/banner2.jpeg" alt="Custom Window Door Mosquito Net Nagpur" class="ul-2-banner-slide-bg">
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide">
                        <div class="ul-2-banner-content">
                            <div class="row">
                                <div class="col-lg-6 col-md-8 col-12">
                                    <span class="ul-2-banner-sub-title"><span class="bg">Free Home Visit</span> & Professional Installation</span>
                                    <h1 class="ul-2-banner-title">Expert Mosquito Net Installation at Your Doorstep in Nagpur</h1>
                                    <p class="ul-2-banner-descr">Our expert team visits your home, takes precise measurements, and installs mosquito nets with zero gaps — ensuring 100% protection. Serving Mahal, Raghuji Nagar, and all areas across Nagpur.</p>
                                    <div class="ul-2-banner-btns">
                                        <a href="contact">Book Free Visit <i class="flaticon-arrow-up-right"></i></a>
                                        <a href="services">Our Services <i class="flaticon-arrow-up-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <img src="assets/img/home/banner3.jpeg" alt="Mosquito Net Installation Service Nagpur" class="ul-2-banner-slide-bg">
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

            <div class="ul-2-feature">
                <div class="ul-2-feature-icon">
                    <!-- Pleated / Folded Net -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="40" height="40" fill="currentColor">
                        <rect x="8" y="10" width="48" height="6" rx="2"/>
                        <rect x="8" y="22" width="48" height="6" rx="2"/>
                        <rect x="8" y="34" width="48" height="6" rx="2"/>
                        <rect x="8" y="46" width="48" height="6" rx="2"/>
                    </svg>
                </div>
                <h3 class="ul-2-feature-title">Pleated Mosquito Net</h3>
            </div>

            <div class="ul-2-feature">
                <div class="ul-2-feature-icon">
                    <!-- Roll-Up Net -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="40" height="40" fill="currentColor">
                        <rect x="8" y="8" width="48" height="8" rx="3"/>
                        <rect x="12" y="20" width="40" height="6" rx="2"/>
                        <rect x="16" y="30" width="32" height="6" rx="2"/>
                        <ellipse cx="32" cy="48" rx="14" ry="8"/>
                    </svg>
                </div>
                <h3 class="ul-2-feature-title">Roll-Up Mosquito Net</h3>
            </div>

            <div class="ul-2-feature">
                <div class="ul-2-feature-icon">
                    <!-- Roll-A-Side Net -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="40" height="40" fill="currentColor">
                        <rect x="28" y="8" width="8" height="48" rx="3"/>
                        <polygon points="8,32 20,20 20,44"/>
                        <polygon points="56,32 44,20 44,44"/>
                    </svg>
                </div>
                <h3 class="ul-2-feature-title">Roll-A-Side Net</h3>
            </div>

            <div class="ul-2-feature">
                <div class="ul-2-feature-icon">
                    <!-- Velcro Net -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="40" height="40" fill="currentColor">
                        <rect x="8" y="10" width="48" height="10" rx="3"/>
                        <rect x="8" y="44" width="48" height="10" rx="3"/>
                        <line x1="16" y1="24" x2="16" y2="40" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                        <line x1="26" y1="24" x2="26" y2="40" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                        <line x1="36" y1="24" x2="36" y2="40" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                        <line x1="46" y1="24" x2="46" y2="40" stroke="currentColor" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>
                <h3 class="ul-2-feature-title">Velcro Mosquito Net</h3>
            </div>

            <div class="ul-2-feature">
                <div class="ul-2-feature-icon">
                    <!-- Bed Net -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="40" height="40" fill="currentColor">
                        <rect x="6" y="34" width="52" height="10" rx="3"/>
                        <rect x="6" y="44" width="6" height="12" rx="2"/>
                        <rect x="52" y="44" width="6" height="12" rx="2"/>
                        <rect x="10" y="20" width="44" height="16" rx="3"/>
                        <!-- Net lines on top -->
                        <line x1="10" y1="8" x2="54" y2="8" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                        <line x1="10" y1="8" x2="10" y2="20" stroke="currentColor" stroke-width="2"/>
                        <line x1="54" y1="8" x2="54" y2="20" stroke="currentColor" stroke-width="2"/>
                    </svg>
                </div>
                <h3 class="ul-2-feature-title">Bed Mosquito Net</h3>
            </div>

        </div>
    </div>
</section> 
        <!-- FEATURES SECTION END -->


        <!-- ABOUT SECTION START -->
        <section class="ul-2-about ul-section-spacing pt-0">
            <div class="ul-container">
                <div class="row g-4 row-cols-lg-2 row-cols-1 align-items-center">
                    <div class="col">
                        <div class="ul-2-about-img">
                            <img src="assets/img/home/why.webp" alt="Saagar Enterprises Mosquito Net Nagpur" class="main-img">
                            <div class="ul-2-about-img-bgs">
                                <div class="ul-2-about-img-bg-1">
                                    <img src="assets/img/home/why.webp" alt="Mosquito Net Installation Nagpur">
                                </div>
                               
                            </div>
                           
                           
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-2-about-txt">
                            <span class="ul-2-section-sub-title">About Saagar Enterprises</span>
                            <h2 class="ul-2-section-title">Nagpur's Most Trusted Mosquito Net Manufacturer & Dealer</h2>
                            <p class="ul-2-section-descr">Saagar Enterprises has been Nagpur's go-to mosquito net solution provider since 2013. We specialize in custom-fitted mosquito net systems for windows, doors, balconies, and beds — ensuring your family stays safe from mosquitoes, dengue, and malaria all year round.</p>
                            <div class="ul-2-about-points">
                                <div class="ul-2-about-point">
                                    <img src="assets/img/tick-inside-circle.svg" alt="icon" class="icon">
                                    <span class="title">Custom Measurement & Zero-Gap Professional Installation Across Nagpur</span>
                                </div>
                                <div class="ul-2-about-point">
                                    <img src="assets/img/tick-inside-circle.svg" alt="icon" class="icon">
                                    <span class="title">Premium Quality Nylon, HDPE & Aluminium Frame Mosquito Nets</span>
                                </div>
                            </div>
                            <p class="ul-2-about-descr">With over 10 years of experience and 500+ happy customers across Nagpur, Saagar Enterprises is rated 5 stars for prompt service, reasonable rates, and durable mosquito net installations. We serve Mahal, Raghuji Nagar, and all areas of Nagpur with on-site repair and after-sales support.</p>
                            <a href="about-us" class="ul-btn">Know More <i class="flaticon-arrow-up-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ABOUT SECTION END -->


        <!-- TICKER SECTION START -->
       
        <!-- TICKER SECTION END -->


        <!-- PRODUCTS / SOLUTIONS SECTION START -->
        <section class="ul-2-solutions ul-section-spacing">
            <div class="ul-container">
                <div class="row row-cols-md-2 row-cols-1 gy-4 align-items-center">
                    <div class="col">
                        <div class="ul-2-solutions-txt">
                            <span class="ul-2-section-sub-title">Our Mosquito Net Products</span>
                            <h2 class="ul-2-section-title">Complete Mosquito Protection Solutions for Your Home</h2>

                            <div class="tab-group">
                                <div class="ul-2-solutions-tab-navs">
                                    <button class="tab-nav active" data-tab="tab-1">Window Nets</button>
                                    <button class="tab-nav" data-tab="tab-2">Door Nets</button>
                                    <button class="tab-nav" data-tab="tab-3">Bed Nets</button>
                                    <button class="tab-nav" data-tab="tab-4">Balcony Nets</button>
                                </div>

                                <div class="tabs-wrapper">
                                    <div class="ul-tab active" id="tab-1">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Custom Window Mosquito Nets — Pleated, Roll-Up & Velcro Systems</span>
                                            <p class="descr">Saagar Enterprises provides perfectly fitted mosquito nets for every window size in Nagpur. Choose from pleated nets, roll-up screens, roll-a-side nets, fixed frames, and easy velcro systems — all custom-measured and professionally installed with zero gaps.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">500+</span>
                                                        <p class="descr">Windows Protected in Nagpur</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">5★</span>
                                                        <p class="descr">Rated by 40+ Customers</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-tab" id="tab-2">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Door Mosquito Net Systems — Openable Frame & Pleated Door Nets</span>
                                            <p class="descr">Keep mosquitoes out while keeping your doors functional. Our openable frame door nets and pleated door screens are designed for smooth operation and a perfect custom fit for all door sizes across Nagpur homes and offices.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">300+</span>
                                                        <p class="descr">Doors Fitted in Nagpur</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">100%</span>
                                                        <p class="descr">Zero-Gap Guarantee</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-tab" id="tab-3">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Bed Mosquito Nets — Single & Double Bed Nylon & HDPE Nets</span>
                                            <p class="descr">Our nylon and HDPE bed mosquito nets are durable, washable, and available in single (3.5' x 6.5') and double bed sizes. Lightweight, foldable, and easy to set up — ideal for complete night-time mosquito protection in Nagpur.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">1000+</span>
                                                        <p class="descr">Bed Nets Sold</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">₹696</span>
                                                        <p class="descr">Starting Price (Single Bed)</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-tab" id="tab-4">
                                        <div class="ul-2-solutions-tab-txt">
                                            <span class="title">Balcony & Large Opening Mosquito Nets — Pleated & Roll-A-Side</span>
                                            <p class="descr">Large balconies and open areas need special mosquito net solutions. Saagar Enterprises provides heavy-duty pleated nets and roll-a-side screens for wide balcony openings — custom-measured for a seamless, mosquito-proof finish in Nagpur homes.</p>
                                            <div class="ul-2-solutions-stats">
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-business-and-finance"></i></span>
                                                    <div class="txt">
                                                        <span class="number">200+</span>
                                                        <p class="descr">Balconies Covered</p>
                                                    </div>
                                                </div>
                                                <div class="ul-2-solutions-stat">
                                                    <span class="icon"><i class="flaticon-dashboard"></i></span>
                                                    <div class="txt">
                                                        <span class="number">Free</span>
                                                        <p class="descr">Home Measurement Visit</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="ul-2-solutions-txt-bottom">
                                <a href="services" class="ul-btn">View all services <i class="flaticon-arrow-up-right"></i></a>
                                <div class="ul-2-solutions-cta">
                                    <span class="ul-2-solutions-cta-title">Call Us Now</span>
                                    <span class="helpline">Free Quote <a href="tel:+917719806088"><i class="flaticon-telephone"></i> +91 7719806088</a></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="ul-2-solutions-img">
                            <img src="assets/img/home/1820x787.webp" alt="Mosquito Net Products Nagpur - Saagar Enterprises" class="w-100">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- PRODUCTS SECTION END -->


        <!-- STATS SECTION START -->
        <div class="ul-container">
            <div class="ul-2-stats ul-section-spacing">
                <div class="ul-2-stats-wrapper wow animate__fadeInUp">
                    <div class="row row-cols-md-4 row-cols-sm-3 row-cols-2 ul-bs-row justify-content-center">
                        <div class="col">
                            <div class="ul-2-stats-item">
                                <span class="number">500+</span>
                                <span class="txt">Happy Customers Across Nagpur</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="ul-2-stats-item active">
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


        <!-- QUOTE ESTIMATOR SECTION START -->
        
        <!-- QUOTE ESTIMATOR SECTION END -->


        <!-- PRODUCT TYPES SHOWCASE START -->
        <section class="ul-2-cards ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading justify-content-center text-center">
                    <div>
                        <span class="ul-2-section-sub-title">Our Mosquito Net Range</span>
                        <h2 class="ul-2-section-title">Explore All Types of Mosquito Net Systems <br> Available in Nagpur</h2>
                    </div>
                </div>

                <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 align-items-center">
                    <div class="col order-lg-1 order-2">
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Pleated Mosquito Net</h3>
                            <p class="ul-2-card-descr">Stylish accordion-style pleated nets that fold smoothly to the side. Ideal for large windows, balcony doors, and sliding openings. Custom-fitted and professionally installed across Nagpur with durable aluminium tracks.</p>
                        </div>
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Velcro Mosquito Net</h3>
                            <p class="ul-2-card-descr">A simple, affordable mosquito net solution. Attach the velcro strip to your window frame and fit the net — easy to remove for cleaning. Best for small windows and budget-friendly mosquito protection in Nagpur.</p>
                        </div>
                    </div>

                    <div class="col-lg col-sm-12 col-12 order-lg-2 order-1">
                        <div class="ul-2-cards-imgs">
                            <div class="img-1-wrapper">
                                <img src="assets/img/home/427X318.webp" alt="Mosquito Net Types Nagpur" class="ul-2-cards-img img-1 wow animate__fadeInUpBig">
                            </div>
                            <img src="assets/img/credit-card-2.png" alt="Window Door Mosquito Net Nagpur" class="ul-2-cards-img img-2 wow animate__bounceInUp">
                        </div>
                    </div>

                    <div class="col order-3">
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Roll-Up Mosquito Net</h3>
                            <p class="ul-2-card-descr">Retractable roll-up mosquito screens that roll up neatly when not in use. Perfect for windows and doors where you want unobstructed views during the day and full mosquito protection at night in Nagpur.</p>
                        </div>
                        <div class="ul-2-card">
                            <h3 class="ul-2-card-title">Fixed & Openable Frame Net</h3>
                            <p class="ul-2-card-descr">Heavy-duty aluminium or mild steel frame mosquito nets permanently fitted to your windows and doors. The openable frame design lets you operate it like a window — providing long-lasting mosquito protection for Nagpur homes and offices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- PRODUCT TYPES SHOWCASE END -->


        <!-- WHY CHOOSE US SECTION START -->
        <section class="ul-2-investments ul-2-banner ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading">
                    <div class="left">
                        <span class="ul-2-section-sub-title text-white">Why Choose Saagar Enterprises</span>
                        <h2 class="ul-2-section-title">Why Nagpur Trusts Saagar Enterprises for Mosquito Nets</h2>
                    </div>
                    <div class="right">
                        <p class="ul-2-section-descr">Over 10 years of experience, 500+ happy customers, 5-star ratings, and expert installation — Saagar Enterprises is Nagpur's most trusted mosquito net dealer and manufacturer.</p>
                        <a href="services" class="ul-btn">View All Services <i class="flaticon-arrow-up-right"></i></a>
                    </div>
                </div>

                <div class="ul-2-investments-wrapper">
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/home/img1.webp" alt="Custom Mosquito Net Nagpur">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">01</span>
                            <h3 class="ul-2-investment-item-title"><a href="services">100% Custom-Fitted Mosquito Nets</a></h3>
                        </div>
                    </div>
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/home/img2.webp" alt="Professional Mosquito Net Installation Nagpur">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">02</span>
                            <h3 class="ul-2-investment-item-title"><a href="services">Expert Installation — Zero Gap Guarantee</a></h3>
                        </div>
                    </div>
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/home/img3.webp" alt="Premium Quality Mosquito Net Nagpur">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">03</span>
                            <h3 class="ul-2-investment-item-title"><a href="services">Premium Nylon, HDPE & Aluminium Frame Nets</a></h3>
                        </div>
                    </div>
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/home/img3.webp" alt="After Sales Repair Service Mosquito Net Nagpur">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">04</span>
                            <h3 class="ul-2-investment-item-title"><a href="services">On-Site Repair & After-Sales Support in Nagpur</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- WHY CHOOSE US SECTION END -->


        <!-- TEAM SECTION START -->
        
        <!-- TEAM SECTION END -->


        <!-- FAQ SECTION START -->
        <section class="ul-2-faq ul-2-banner ul-section-spacing">
            <div class="ul-container">
                <div class="row">
                    <div class="col-lg-6 col-sm-9 col-12">
                        <div class="ul-2-faq-txt">
                            <span class="ul-2-section-sub-title">FAQ</span>
                            <h2 class="ul-2-section-title">Frequently Asked Questions About Mosquito Nets in Nagpur</h2>

                            <div class="ul-2-faq-accordion ul-accordion">
                                <div class="ul-single-accordion-item open">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">01</span>
                                            <span class="ul-single-accordion-item__title">Which is the best mosquito net for windows in Nagpur?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">Pleated mosquito nets and roll-up mosquito nets are the most popular choices for windows in Nagpur. Pleated nets are stylish and smooth to operate, while roll-up nets are compact and retractable. Saagar Enterprises recommends the best type based on your window size and usage during our free home measurement visit.</p>
                                    </div>
                                </div>

                                <div class="ul-single-accordion-item">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">02</span>
                                            <span class="ul-single-accordion-item__title">Does Saagar Enterprises provide mosquito net installation at home in Nagpur?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">Yes! Saagar Enterprises provides free home measurement visits and professional mosquito net installation across all areas of Nagpur. Our team visits, takes precise measurements, and installs with zero gaps for 100% protection. Call +91 7719806088 to book your free visit today.</p>
                                    </div>
                                </div>

                                <div class="ul-single-accordion-item">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">03</span>
                                            <span class="ul-single-accordion-item__title">What is the price of mosquito net for windows in Nagpur?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">The price of mosquito nets in Nagpur depends on the type (pleated, roll-up, velcro, fixed frame) and the size of your window or door. Bed mosquito nets start from ₹696. For window and door nets, Saagar Enterprises provides a free quote after measuring your openings. Call +91 7719806088 or +91 8424943602 for pricing.</p>
                                    </div>
                                </div>

                                <div class="ul-single-accordion-item">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">04</span>
                                            <span class="ul-single-accordion-item__title">Where is Saagar Enterprises mosquito net shop located in Nagpur?</span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon"><i class="flaticon-arrow-down-sign-to-navigate"></i></span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">Saagar Enterprises has two locations in Nagpur. Main branch: Mohan Motiramji Varshe Building, Kothi Road, Mahal, Nagpur – 440032 (Tue–Sun, 10 AM–7 PM). Second branch: Raghuji Nagar, opposite Kamla Nehru College Girls Gate (Mon–Sun, 10 AM–10 PM). Call +91 7719806088 for directions.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <img src="assets/img/home/faq.jpeg" alt="Mosquito Net FAQ Nagpur - Saagar Enterprises" class="ul-2-faq-bg">
        </section>
        <!-- FAQ SECTION END -->


        <!-- TESTIMONIALS SECTION START -->
       <section class="ul-2-testimonials ul-section-spacing">
    <div class="ul-container">
        <div class="ul-section-heading justify-content-center text-center">
            <div>
                <span class="ul-2-section-sub-title">Customer Reviews</span>
                <h2 class="ul-2-section-title mb-0">
                    What Nagpur Customers Say About Saagar Enterprises Mosquito Nets
                </h2>
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
                        <span class="ul-2-testimony-quote-icon">
                            <i class="flaticon-double-quotes"></i>
                        </span>
                    </div>
                    <p class="ul-2-testimony-txt">
                        Quality work at a very reasonable price. The exceptional quality and timely completion of work are their key strengths. The service is excellent and truly lives up to the name. Highly recommended Saagar Enterprises.
                    </p>
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
                        <span class="ul-2-testimony-quote-icon">
                            <i class="flaticon-double-quotes"></i>
                        </span>
                    </div>
                    <p class="ul-2-testimony-txt">
                        Excellent work done by Saagar Enterprises team. Harish Ture was highly responsive and responsible throughout the installation process. Highly recommended for mosquito net services.
                    </p>
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
                        <span class="ul-2-testimony-quote-icon">
                            <i class="flaticon-double-quotes"></i>
                        </span>
                    </div>
                    <p class="ul-2-testimony-txt">
                        Saagar Enterprises is a trusted name for mosquito nets and wall hanging cloth dryers. Service is quick with well-trained and polite staff. Great experience overall.
                    </p>
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
                        <span class="ul-2-testimony-quote-icon">
                            <i class="flaticon-double-quotes"></i>
                        </span>
                    </div>
                    <p class="ul-2-testimony-txt">
                        Wonderful experience with this company. Service was prompt and hassle-free. The team completed installation quickly with a neat and professional finish.
                    </p>
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
                                <span class="ul-2-testimony-reviewer-name">Shishir Sadhankar</span>
                                <span class="ul-2-testimony-reviewer-role">Nagpur</span>
                            </div>
                        </div>
                        <span class="ul-2-testimony-quote-icon">
                            <i class="flaticon-double-quotes"></i>
                        </span>
                    </div>
                    <p class="ul-2-testimony-txt">
                        One of the best mosquito net providers in Nagpur. Competitive pricing, professional service, and timely delivery. Suitable for both small homes and large projects.
                    </p>
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
                        <span class="ul-2-testimony-quote-icon">
                            <i class="flaticon-double-quotes"></i>
                        </span>
                    </div>
                    <p class="ul-2-testimony-txt">
                        Perfect job done for mosquito net installation in my 3BHK flat. Skilled professionals and clean work. Highly recommended service.
                    </p>
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
    <script src="assets/js/accordion.js"></script>
</body>

</html>


















