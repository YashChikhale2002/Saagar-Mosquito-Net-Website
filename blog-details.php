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
                <h1 class="ul-breadcrumb-title">Blog Details</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index.html">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Blog Details</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- BLOG DETAILS SECTION START -->
        <section class="ul-blog-details ul-section-spacing">
            <div class="ul-container">
                <div class="row ul-bs-row gy-5 gx-4">
                    <!-- left/blog details -->
                    <div class="col-lg-8 col-md-7">
                        <div class="ul-blog-details">
                            <div class="ul-blog-details-top">
                                <div class="ul-blog-details-img">
                                    <img src="assets/img/blog-details-img.jpg" alt="Image">
                                    <span class="ul-blog-details-tag">Corporate</span>
                                </div>

                                <div class="ul-blog-details-txt">
                                    <h2 class="ul-blog-details-title">Why Budgeting Is the First Step Toward Financial Freedom</h2>
                                    <p class="ul-blog-details-descr">Financial freedom doesn't happen overnight—it starts with one simple habit: budgeting. Creating a budget helps you take control of your money, avoid debt, and plan for a better future.</p>
                                    <blockquote>
                                        <p class="quote-descr">I've been following this blog for months now — clear, simple, and packed with useful tips. Helped me start budgeting and saving smarter!</p>
                                        <span class="quote-author">
                                            <span class="quote-author-name">Amina R.</span>
                                            <span class="quote-author-title">Small Business Owner</span>
                                        </span>
                                    </blockquote>
                                    <h3 class="ul-blog-details-inner-title">Why Budgeting Matters</h3>
                                    <p class="ul-blog-details-descr">Budgeting is more than tracking expenses; it’s about aligning your spending with your goals. Whether you're saving for a house, paying off loans, or building an emergency fund, a well-planned budget is the foundation.</p>
                                    <h4 class="ul-blog-details-inner-title-2">Key Benefits of Budgeting:</h4>
                                    <ul class="ul-blog-details-list">
                                        <li>
                                            <span class="key">Clear Spending Awareness:</span>
                                            <span class="value">Know exactly where your money goes each month.</span>
                                        </li>
                                        <li>
                                            <span class="key">Debt Control:</span>
                                            <span class="value">Allocate money toward loan payments and avoid unnecessary borrowing.</span>
                                        </li>
                                        <li>
                                            <span class="key">Savings Growth:</span>
                                            <span class="value">Set aside money for future needs, investments, or emergencies.</span>
                                        </li>
                                        <li>
                                            <span class="key">Stress Reduction:</span>
                                            <span class="value">Financial clarity reduces anxiety and helps you feel more secure.</span>
                                        </li>
                                    </ul>

                                    <div class="ul-blog-details-inner-img">
                                        <img src="assets/img/blog-2.jpg" alt="image">
                                        <img src="assets/img/blog-3.jpg" alt="image">
                                    </div>

                                    <h4 class="ul-blog-details-inner-title-2">Getting Started with a Simple Budget</h4>
                                    <ul class="ul-blog-details-list">
                                        <li>
                                            <span class="key">Track Your Income:</span>
                                            <span class="value">List all monthly income sources.</span>
                                        </li>
                                        <li>
                                            <span class="key">List Your Expenses:</span>
                                            <span class="value">Include fixed (rent, utilities) and variable (groceries, transport) costs.</span>
                                        </li>
                                        <li>
                                            <span class="key">Set Financial Goals:</span>
                                            <span class="value">Short-term and long-term.</span>
                                        </li>
                                        <li>
                                            <span class="key">Adjust and Monitor:</span>
                                            <span class="value">Review your budget regularly and make changes as needed.</span>
                                        </li>
                                    </ul>

                                    <h4 class="ul-blog-details-inner-title-2">Conclusion</h4>
                                    <p class="ul-blog-details-descr">Budgeting is the first, and perhaps most important, step on the road to financial independence. With a clear plan, you gain the power to make smart decisions and achieve lasting financial freedom.</p>
                                </div>
                            </div>

                            <!-- actions -->
                            <div class="ul-blog-details-actions">
                                <!-- tags -->
                                <div class="tags-wrapper">
                                    <h4 class="actions-title">Tags: </h4>
                                    <div class="ul-blog-sidebar-tags tags">
                                        <a href="#">Reseller</a>
                                        <a href="#">Hosting</a>
                                        <a href="#">WP Hosting</a>
                                    </div>
                                </div>

                                <!-- share -->
                                <div class="shares-wrapper">
                                    <div class="share-options">
                                        <a href="#"><i class="flaticon-facebook-app-symbol"></i></a>
                                        <a href="#"><i class="flaticon-twitter"></i></a>
                                        <a href="#"><i class="flaticon-linkedin"></i></a>
                                        <a href="#"><i class="flaticon-instagram"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="ul-blog-details-bottom">
                                <!-- reviews -->
                                <div class="ul-blog-details-reviews">
                                    <h3 class="ul-blog-details-inner-title">02 Comments</h3>

                                    <!-- single review -->
                                    <div class="ul-blog-details-review">
                                        <!-- reviewer image -->
                                        <div class="ul-blog-details-review-reviewer-img">
                                            <img src="assets/img/team-member-2.jpg" alt="Reviewer Image">
                                        </div>

                                        <div class="ul-blog-details-review-txt">
                                            <div class="header">
                                                <div class="left">
                                                    <span class="review-date">March 20, 2023 at 2:37 pm</span>
                                                    <h4 class="reviewer-name">Leslie Alexander</h4>
                                                </div>

                                                <div class="right"><button class="ul-blog-details-review-reply-btn">Reply</button></div>
                                            </div>

                                            <p>Neque porro est qui dolorem ipsum quia quaed inventor veritatis et quasi architecto var sed efficitur turpis gilla sed sit amet finibus eros. Lorem Ipsum is simply dummy</p>
                                        </div>
                                    </div>

                                    <!-- single review -->
                                    <div class="ul-blog-details-review">
                                        <!-- reviewer image -->
                                        <div class="ul-blog-details-review-reviewer-img">
                                            <img src="assets/img/team-member-1.jpg" alt="Reviewer Image">
                                        </div>

                                        <div class="ul-blog-details-review-txt">
                                            <div class="header">
                                                <div class="left">
                                                    <span class="review-date">March 20, 2023 at 2:37 pm</span>
                                                    <h4 class="reviewer-name">Ralph Edwards</h4>
                                                </div>

                                                <div class="right">
                                                    <button class="ul-blog-details-review-reply-btn">Reply</button>
                                                </div>
                                            </div>

                                            <p>Neque porro est qui dolorem ipsum quia quaed inventor veritatis et quasi architecto var sed efficitur turpis gilla sed sit amet finibus eros. Lorem Ipsum is simply dummys</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- review form -->
                                <div class="ul-blog-details-comment-form-wrapper">
                                    <h3 class="ul-blog-details-inner-title">Leave a Comment</h3>
                                    <form action="#" class="ul-blog-details-comment-form">
                                        <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="ul-blog-comment-name">Your Name</label>
                                                    <input type="text" name="name" id="ul-blog-comment-name" placeholder="Your Name">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="ul-blog-comment-email">Email Address</label>
                                                    <input type="email" name="email" id="ul-blog-comment-email" placeholder="Email Address">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="ul-blog-comment-msg">Your Message</label>
                                                    <textarea name="message" id="ul-blog-comment-msg" placeholder="Type your message"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <button class="ul-btn ul-btn--2"><span>POST COMMENT</span> <i class="flaticon-arrow-up-right"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- sidebar -->
                    <div class="col-lg-4 col-md-5">
                        <div class="ul-inner-sidebar">
                            <!-- single widget /search -->
                            <div class="ul-service-details-sidebar-widget ul-inner-sidebar-search">
                                <div class="ul-inner-sidebar-widget-content">
                                    <form action="#" class="ul-blog-search-form">
                                        <input type="search" name="blog-search" id="ul-blog-search" placeholder="Search Here">
                                        <button type="submit"><i class="flaticon-search"></i></button>
                                    </form>
                                </div>
                            </div>

                            <!-- single widget / Categories -->
                            <div class="ul-service-details-sidebar-widget">
                                <span class="ul-service-details-sidebar-widget-title">Categories</span>
                                <ul class="ul-service-details-sidebar-links">
                                    <li><a href="blog-2.html">Health & Wellness <span>(08)</span></a></li>
                                    <li><a href="blog-2.html">Preventive Care <span>(11)</span></a></li>
                                    <li><a href="blog-2.html">Nutrition & Lifestyle <span>(18)</span></a></li>
                                    <li><a href="blog-2.html">Senior & Geriatric Care <span>(11)</span></a></li>
                                    <li><a href="blog-2.html">Medical Education & Tips <span>(07)</span></a></li>
                                    <li><a href="blog-2.html">Surgery & Recovery <span>(07)</span></a></li>
                                </ul>
                            </div>

                            <!-- single widget / Recent Posts -->
                            <div class="ul-service-details-sidebar-widget ul-inner-sidebar-posts">
                                <h3 class="ul-service-details-sidebar-widget-title">Recent Posts</h3>
                                <div class="ul-inner-sidebar-widget-content">
                                    <div class="ul-inner-sidebar-posts">
                                        <!-- single post -->
                                        <div class="ul-inner-sidebar-post">
                                            <div class="img">
                                                <img src="assets/img/blog-2.jpg" alt="Post Image">
                                            </div>

                                            <div class="txt">
                                                <span class="date"><span>May 12, 2025</span></span>
                                                <h4 class="title"><a href="blog-details.html">A Day in the Life of a Hospital Nurse</a></h4>
                                            </div>
                                        </div>

                                        <!-- single post -->
                                        <div class="ul-inner-sidebar-post">
                                            <div class="img">
                                                <img src="assets/img/blog-1.jpg" alt="Post Image">
                                            </div>

                                            <div class="txt">
                                                <span class="date"><span>May 12, 2025</span></span>
                                                <h4 class="title"><a href="blog-details.html">Choosing the Right Doctor for Your Needs</a></h4>
                                            </div>
                                        </div>

                                        <!-- single post -->
                                        <div class="ul-inner-sidebar-post">
                                            <div class="img">
                                                <img src="assets/img/blog-3.jpg" alt="Post Image">
                                            </div>

                                            <div class="txt">
                                                <span class="date"><span>May 12, 2025</span></span>
                                                <h4 class="title"><a href="blog-details.html">Why Annual Health Screenings Are Essential</a></h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- single widget / Recent Posts -->
                            <div class="ul-service-details-sidebar-widget ul-inner-sidebar-tags">
                                <h3 class="ul-service-details-sidebar-widget-title">Tags</h3>
                                <div class="tags-wrapper">
                                    <a href="#">Savings Tips</a>
                                    <a href="#">Budgeting</a>
                                    <a href="#">Investment</a>
                                    <a href="#">Fixed Deposit</a>
                                    <a href="#">Mobile Banking</a>
                                    <a href="#">Loans</a>
                                    <a href="#">Digital Wallets</a>
                                    <a href="#">Tax Planning</a>
                                    <a href="#">Interest Rates</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- BLOG DETAILS SECTION END -->
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