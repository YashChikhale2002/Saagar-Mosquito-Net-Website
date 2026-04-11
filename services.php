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
                <h1 class="ul-breadcrumb-title">Services</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index.html">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Services</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- INVESTMENT SECTION START -->
        <section class="ul-inner-services ul-section-spacing">
            <div class="ul-container">
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
                            <img src="assets/img/blog-big-3.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">02</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Government Bonds & Treasury</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/blog-big-2.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">03</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Corporate Real Estate</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/blog-3.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">04</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Private Equity / Venture Capital</a></h3>
                        </div>
                    </div>
                </div>
                <div class="ul-2-investments-wrapper">
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/blog-2.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">05</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Stock Market (Equities)</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/blog-1.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">06</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Government Bonds & Treasury</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/banner-2-slide-1.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">07</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Corporate Real Estate</a></h3>
                        </div>
                    </div>
                    <!-- single investment -->
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="assets/img/banner-bg.jpg" alt="Investment Item Image">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">08</span>
                            <h3 class="ul-2-investment-item-title"><a href="service-details.html">Private Equity / Venture Capital</a></h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- INVESTMENT SECTION END -->


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
                                        <button class="ul-btn">Apply For Loan <i class="flaticon-arrow-up-right"></i></button>
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


        <!-- CLIENTS SECTION START -->
        <section class="ul-2-clients ul-section-spacing pt-0">
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