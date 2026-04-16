<?php
session_start();
include 'include/config.php';

$_base    = '/';
$_svcBase = '/service/';

$services = [];
$result = $conn->query("
    SELECT id, title, slug, short_desc, banner_image, sort_order 
    FROM mosquito_services 
    WHERE is_active = 1 
    ORDER BY sort_order ASC
");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | Mosquito Net Solutions</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/vendor/animate-wow/animate.min.css">
    <link rel="stylesheet" href="assets/icon/flaticon_cashflow.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="home-2">

    <!-- LOGIN FORM -->
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
                                <button class="ul-btn w-100 justify-content-center">
                                    Login <i class="flaticon-arrow-up-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="ul-sidebar">
        <div class="ul-sidebar-header">
            <div class="ul-sidebar-header-logo">
                <a href="<?= $_base ?>">
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

        <!-- BREADCRUMB -->
        <section class="ul-breadcrumb ul-2-banner">
            <div class="ul-container">
                <h1 class="ul-breadcrumb-title">Services</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="<?= $_base ?>">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Services</span>
                </div>
            </div>
        </section>

        <!-- SERVICES LISTING -->
        <section class="ul-inner-services ul-section-spacing">
            <div class="ul-container">

                <?php if (empty($services)): ?>
                <div class="text-center py-5">
                    <p class="text-muted fs-5">No services found. Please check back later.</p>
                </div>

                <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($services as $index => $service): ?>
                    <?php
                        // ✅ Now uses banner_image as the card thumbnail
                        $img   = !empty($service['banner_image'])
                                    ? htmlspecialchars($service['banner_image'])
                                    : 'assets/img/investment-img.jpg';
                        $title = htmlspecialchars($service['title']);
                        $desc  = htmlspecialchars(mb_strimwidth($service['short_desc'] ?? '', 0, 100, '…'));
                        $url   = $_svcBase . htmlspecialchars($service['slug']);
                        $num   = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="ul-service-blog-card">
                            <div class="ul-service-blog-card__img">
                                <a href="<?= $url ?>">
                                    <img src="<?= $img ?>" alt="<?= $title ?>" loading="lazy">
                                </a>
                            </div>
                            <div class="ul-service-blog-card__body">
                                <div class="ul-service-blog-card__meta">
                                    <span class="ul-service-blog-card__num">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                        Service <?= $num ?>
                                    </span>
                                    <span class="ul-service-blog-card__badge">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        Mosquito Net
                                    </span>
                                </div>
                                <h3 class="ul-service-blog-card__title">
                                    <a href="<?= $url ?>"><?= $title ?></a>
                                </h3>
                                <p class="ul-service-blog-card__desc"><?= $desc ?></p>
                                <a href="<?= $url ?>" class="ul-service-blog-card__link">
                                    Read More
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <line x1="7" y1="17" x2="17" y2="7"/>
                                        <polyline points="7 7 17 7 17 17"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

            </div>
        </section>

    </main>

    <?php include 'include/footer.php'; ?>

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