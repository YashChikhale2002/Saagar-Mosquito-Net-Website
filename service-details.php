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
                <h1 class="ul-breadcrumb-title">Services Details</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index.html">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Service Details</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- SERVICE DETAILS SECTION START -->
        <section class="ul-service-details ul-section-spacing pb-4">
            <div class="ul-container">
                <div class="ul-service-details-txt">
                    <h2 class="ul-service-details-title">Comprehensive Corporate Real Estate Solutions</h2>
                    <p class="ul-service-details-descr">-We offer strategic, end-to-end real estate solutions tailored for corporate clients. From acquisition and financing to portfolio management and asset optimization, our dedicated team ensures your business spaces align with your financial goals. Whether expanding, relocating, or consolidating operations, we provide expert guidance every step of the way — backed by deep industry insights and secure financial structuring.</p>
                    <div class="ul-service-details-img">
                        <img src="assets/img/service-details-img.jpg" alt="Service Details">
                    </div>
                    <div class="ul-service-details-blocks">
                        <div class="ul-service-details-block">
                            <h3 class="ul-service-details-block-title">Our Services</h3>
                            <ul>
                                <li>Real estate acquisition & disposition</li>
                                <li>Lease advisory & negotiation</li>
                                <li>Property financing & refinancing</li>
                                <li>Portfolio & asset management</li>
                                <li>Construction project financing</li>
                                <li>Market analysis & investment strategy</li>
                            </ul>
                        </div>
                        <div class="ul-service-details-block">
                            <h3 class="ul-service-details-block-title">Industries We Serve</h3>
                            <ul>
                                <li>Office & Corporate Headquarters</li>
                                <li>Logistics & Industrial Warehousing</li>
                                <li>Retail & Commercial Spaces</li>
                                <li>Hospitality & Mixed-Use Developments</li>
                                <li>Healthcare & Education Facilities</li>
                                <li>Technology Parks & Data Centers</li>
                            </ul>
                        </div>
                    </div>
                    <div class="ul-service-details-block">
                        <h3 class="ul-service-details-block-title">Real Estate Financing Solutions</h3>
                        <p class="ul-service-details-block-descr">Access competitive loan options for commercial property acquisition, refinancing, or development. We structure custom financing packages to suit your timeline, budget, and cash flow needs.</p>
                    </div>
                    <div class="d-flex align-items-end gap-4 flex-lg-nowrap flex-wrap">
                        <div class="ul-service-details-block">
                            <h3 class="ul-service-details-block-title mt-0">Why Choose Us?</h3>
                            <ul class="d-flex flex-column">
                                <li>Dedicated Corporate Real Estate Banking Team</li>
                                <li>Customized Financing Structures</li>
                                <li>Market & Regulatory Expertise</li>
                                <li>End-to-End Project Support</li>
                                <li>Local & Global Market Reach</li>
                            </ul>

                            <blockquote>
                                <p class="descr">Professional, fast, and SEO-friendly content. Our website now ranks higher and converts better. Great experience from start to finish!</p>

                                <div class="author">
                                    <div class="author-img">
                                        <img src="assets/img/user-3.png" alt="User">
                                    </div>
                                    <div class="author-info">
                                        <h4 class="author-name">John Doe</h4>
                                        <span class="author-title">Marketing Director, EcoBrand Solutions</span>
                                    </div>
                                </div>

                                <div class="quote-icon"><i class="flaticon-double-quotes"></i></div>
                                <img src="assets/img/service-details-quote-vector.svg" alt="vector" class="vector">
                            </blockquote>
                        </div>
                        <div class="ul-service-details-block-img"><img src="assets/img/service-inner-img.jpg" alt="Inner Image"></div>
                    </div>

                    <div class="ul-service-details-block">
                        <h3 class="ul-service-details-block-title">Real Estate Financing</h3>
                        <p class="ul-service-details-block-descr">We provide tailored financing for commercial real estate acquisition, construction, and refinancing. Choose from a range of loan products including term loans, revolving credit, and structured finance options.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- SERVICE DETAILS SECTION END -->


        <!-- FAQ SECTION START -->
        <section class="ul-inner-faq ul-section-spacing pt-0">
            <div class="ul-container">
                <div class="row">
                    <div class="col-5">
                        <div class="ul-inner-faq-img d-lg-block d-none">
                            <img src="assets/img/question.svg" alt="Icon">
                        </div>
                    </div>
                    <!-- txt -->
                    <div class="col-lg-7 col-12">
                        <div class="ul-2-faq-txt ms-lg-4 ms-0">
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
        </section>
        <!-- FAQ SECTION END -->
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