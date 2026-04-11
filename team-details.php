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


    <!-- HEADER START -->
    <header class="ul-2-header">
        <!-- header top -->
        <div class="ul-2-header-top">
            <div class="ul-2-header-container">
                <div class="ul-2-header-top-left">
                    <p class="mb-0">Welcome to our online banking platform</p>
                </div>
                <div class="ul-2-header-top-right">
                    <a href="#">Money Exchange</a>
                    <a href="#">Life of cashflow</a>
                    <a href="#">ATM Booth</a>
                    <span class="helpline">Help line <a href="#"><i class="flaticon-telephone"></i> 203010</a></span>
                </div>
            </div>
        </div>

        <!-- header bottom -->
        <div class="ul-2-header-bottom">
            <div class="ul-2-header-container">
                <div class="ul-2-header-logo-container">
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
    <!-- HEADER END -->

    <main>
        <!-- BREADCRUMB SECTION START -->
        <section class="ul-breadcrumb ul-2-banner">
            <div class="ul-container">
                <h1 class="ul-breadcrumb-title">Team Details</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index.html">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Team Details</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- TEAM DETAILS SECTION START -->
        <section class="ul-team-details ul-section-spacing">
            <div class="ul-container">
                <div class="row justify-content-between gx-0 gy-3">
                    <div class="col-md-5">
                        <div class="ul-team-details-img wow animate__fadeInUp">
                            <img src="assets/img/team-details-img.jpg" alt="team member image">
                        </div>
                    </div>

                    <div class="col-md-7">
                        <!-- txt -->
                        <div class="txt wow animate__fadeInUp">
                            <h3 class="ul-team-details-name ul-section-title">Danial Frankie</h3>
                            <h6 class="ul-team-details-role">Co-Founder</h6>
                            <p class="ul-team-details-descr">An industry is a collection of profitable businesses or organizations that manufacture or provide goods, services, or revenue streams. Primary, secondary, tertiary, and quaternary industries are the general classifications used in economics; secondary industries are further divided into heavy and light categories. Marketing and advertising are two of the most evident and well-known sectors that require online content writing expertise. </p>

                            <ul class="ul-team-details-infos">
                                <li class="ul-team-details-info">
                                    <span class="ul-team-details-info-title">Email Address</span>
                                    <a href="mailto:thomas.tatum@example.com"><i class="flaticon-email"></i> thomas.tatum@example.com</a>
                                </li>
                                <li class="ul-team-details-info">
                                    <span class="ul-team-details-info-title">Phone Number</span>
                                    <a href="tel:2085550112"><i class="flaticon-telephone-call"></i> +208-555-0112</a>
                                </li>
                            </ul>

                            <!-- social links -->
                            <div class="ul-team-details-socials">
                                <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                                <a href="#"><i class="flaticon-instagram"></i></a>
                                <a href="#"><i class="flaticon-linkedin"></i></a>
                                <a href="#"><i class="flaticon-twitter"></i></a>
                            </div>


                            <!-- short bio -->
                            <h4 class="ul-team-details-inner-title">Short Biography</h4>
                            <p class="ul-team-details-descr">An industry is a collection of profitable businesses or organizations that manufacture or provide goods, services, or revenue streams. Primary, secondary, tertiary, and quaternary industries are the general classifications used in economics</p>
                        </div>
                    </div>
                </div>

                <div class="ul-team-details-bottom wow animate__fadeInUp">
                    <div class="row row-cols-lg-2 row-cols-1 gy-3">
                        <div class="col">
                            <div class="ul-team-details-contact">
                                <form action="#" class="ul-contact-form ul-form">
                                    <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="text" name="name" id="ul-contact-name" placeholder="Your Name">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <input type="email" name="email" id="ul-contact-email" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <input type="tel" name="phone" id="ul-contact-phone" placeholder="Phone Number">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <textarea name="message" id="ul-contact-msg" placeholder="Type your message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="ul-btn">SEND MESSAGE <i class="flaticon-arrow-up-right"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col">
                            <div class="ul-team-details-skills">
                                <h3 class="ul-team-details-bottom-title">Skills</h3>
                                <p class="ul-team-details-descr">An industry is a collection of profitable businesses or organizations that manufacture or provide goods, services, or revenue streams. Primary, secondary, tertiary, and quaternary industries are the general </p>

                                <div class="skills-wrapper">
                                    <div class="ul-team-details-skill">
                                        <h6 class="skills-title">Industrial Pulse Solution</h6>
                                        <div class="ul-skill-progress-2">
                                            <div class="ul-progress-container">
                                                <div class="skill-progressbar ul-progressbar" data-ul-progress-value="90">
                                                    <div class="skill-progress-label ul-progress-label"><span class="percent"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-team-details-skill">
                                        <h6 class="skills-title">Industry Forge innovations</h6>
                                        <div class="ul-skill-progress-2">
                                            <div class="ul-progress-container">
                                                <div class="skill-progressbar ul-progressbar" data-ul-progress-value="87">
                                                    <div class="skill-progress-label ul-progress-label"><span class="percent"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="ul-team-details-skill">
                                        <h6 class="skills-title">Machina Works Service</h6>
                                        <div class="ul-skill-progress-2">
                                            <div class="ul-progress-container">
                                                <div class="skill-progressbar ul-progressbar" data-ul-progress-value="65">
                                                    <div class="skill-progress-label ul-progress-label"><span class="percent"></span></div>
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
        </section>
        <!-- TEAM DETAILS SECTION END -->
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
    <script src="assets/js/progressbar.js"></script>
    <script src="assets/js/accordion.js"></script>
</body>

</html>