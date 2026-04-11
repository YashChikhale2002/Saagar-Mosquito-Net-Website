<?php
session_start();
include 'include/config.php';

// ── Fetch All Active Services ─────────────────────────────────
$services = [];
$result = $conn->query("SELECT id, title, slug, short_desc, image, sort_order FROM mosquito_services WHERE is_active = 1 ORDER BY sort_order ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}

// ── Split into chunks of 4 (for row-wise display) ─────────────
$serviceChunks = array_chunk($services, 4);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Mosquito Net Solutions</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/vendor/animate-wow/animate.min.css">
    <link rel="stylesheet" href="assets/icon/flaticon_cashflow.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="home-2">

    <!-- LOGIN FORM START -->
    <div class="ul-form-modal-bg" id="login-form-modal">
        <div class="ul-form-modal-content">
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
                                <input type="text" name="name" id="name" placeholder="Username or Email">
                            </div>
                            <div class="form-group">
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

    <!-- SIDEBAR -->
    <div class="ul-sidebar">
        <div class="ul-sidebar-header">
            <div class="ul-sidebar-header-logo">
                <a href="index.php">
                    <img src="assets/img/logo.svg" alt="logo" class="logo">
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

    <!-- SEARCH -->
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
                    <a href="index.php">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Services</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- SERVICES LISTING SECTION START -->
        <section class="ul-inner-services ul-section-spacing">
            <div class="ul-container">

                <?php if (empty($services)): ?>
                <!-- No services found -->
                <div class="text-center py-5">
                    <p class="text-muted fs-5">No services found. Please check back later.</p>
                </div>

                <?php else: ?>
                <!-- Loop chunks of 4 per row -->
                <?php foreach ($serviceChunks as $chunkIndex => $chunk): ?>
                <div class="ul-2-investments-wrapper">
                    <?php foreach ($chunk as $index => $service): ?>
                    <?php
                        // Global index for numbering (01, 02, 03...)
                        $globalIndex = ($chunkIndex * 4) + $index + 1;
                        // Fallback image if empty
                        $img = !empty($service['image']) ? $service['image'] : 'assets/img/investment-img.jpg';
                    ?>
                    <div class="ul-2-investment-item">
                        <div class="ul-2-investment-item-img">
                            <img src="<?= htmlspecialchars($img) ?>"
                                 alt="<?= htmlspecialchars($service['title']) ?>">
                        </div>
                        <div class="ul-2-investment-item-txt">
                            <span class="ul-2-investment-item-index">
                                <?= str_pad($globalIndex, 2, '0', STR_PAD_LEFT) ?>
                            </span>
                            <h3 class="ul-2-investment-item-title">
                                <a href="service-details.php?slug=<?= urlencode($service['slug']) ?>">
                                    <?= htmlspecialchars($service['title']) ?>
                                </a>
                            </h3>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </section>
        <!-- SERVICES LISTING SECTION END -->


        <!-- TESTIMONIALS SECTION START -->
        <section class="ul-2-testimonials ul-section-spacing">
            <div class="ul-container">
                <div class="ul-section-heading justify-content-center text-center">
                    <div>
                        <span class="ul-2-section-sub-title">Testimonials</span>
                        <h2 class="ul-2-section-title mb-0">What People Say About Us</h2>
                    </div>
                </div>
            </div>

            <div class="ul-2-testimonials-slider swiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img/user-1.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Marvin McKinney</span>
                                        <span class="ul-2-testimony-reviewer-role">Lead Designer</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Aonsectetur adipiscing elit Aenean scelerisque augue consequat Quisque eget congue velit in cursus leo sodales the turpis euismod quis sapien euismod now</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img/user-2.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Anjali Mehta</span>
                                        <span class="ul-2-testimony-reviewer-role">Mother of Infant, Pune</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Our baby had mosquito bites every morning before we found this net. Since we started using the crib dome net, not a single bite. The elastic base fits the cot perfectly.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img/user-3.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Rohan Deshmukh</span>
                                        <span class="ul-2-testimony-reviewer-role">Trek Leader, Nagpur</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">We took your hammock nets on a 12-day trek through Bastar. Zero mosquito bites across the entire group. The zippers held up perfectly through rain and rough handling.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img/user-1.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Priya Sharma</span>
                                        <span class="ul-2-testimony-reviewer-role">Homemaker, Nagpur</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">We replaced chemical coils with your bedroom nets and the difference is remarkable. No more burning smell, no more coughing at night. The whole family sleeps peacefully now.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="ul-2-testimony">
                            <div class="ul-2-testimony-top">
                                <div class="ul-2-testimony-reviewer">
                                    <img src="assets/img/user-2.png" alt="Reviewer Image">
                                    <div class="ul-2-testimony-reviewer-info">
                                        <span class="ul-2-testimony-reviewer-name">Suresh Patil</span>
                                        <span class="ul-2-testimony-reviewer-role">Farmer, Wardha</span>
                                    </div>
                                </div>
                                <span class="ul-2-testimony-quote-icon"><i class="flaticon-double-quotes"></i></span>
                            </div>
                            <p class="ul-2-testimony-txt">Living near fields means constant mosquito trouble. Your outdoor rooftop net changed everything. Easy to set up every evening and packs away quickly in the morning.</p>
                            <div class="ul-2-testimony-stars">
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
                                <i class="flaticon-star"></i><i class="flaticon-star"></i>
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
    <script src="assets/js/main.js"></script>
    <script src="assets/js/tab.js"></script>
    <script src="assets/js/progressbar.js"></script>
    <script src="assets/js/accordion.js"></script>
</body>
</html>