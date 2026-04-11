<?php
/**
 * Dynamic Header (New UI Integrated)
 */

$_base        = rtrim(SITE_URL, '/') . '/';
$_headerClass = $headerClass ?? 'ul-2-header';

// Detect current URL
$_uri = rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

// Active menu helper
function navActive(string $segment): string {
    global $_uri;
    return (strpos($_uri, $segment) !== false) ? 'class="active"' : '';
}

// Fetch Doctors
$_navDoctors = [];
$_navDoctorsRes = $conn->query("SELECT name, slug FROM doctors WHERE is_published = 1 ORDER BY name ASC LIMIT 8");

if ($_navDoctorsRes) {
    while ($_dr = $_navDoctorsRes->fetch_assoc()) {
        $_navDoctors[] = $_dr;
    }
}
?>

<!-- HEADER START -->
<header class="<?= $_headerClass ?>">

    <div class="ul-2-header-bottom">
        <div class="ul-2-header-container">


             <div class="ul-2-header-logo-container">
                    <a href="index-2.html"><img src="assets/img/logo.svg" alt="logo"></a>
             </div>

            <!-- RIGHT SECTION -->
            <div class="ul-2-header-bottom-right">

                <!-- NAVIGATION -->
                <div class="ul-header-nav-wrapper">
                    <div class="to-go-to-sidebar-in-mobile">
                        <nav class="ul-header-nav">

                            <!-- HOME -->
                            <a href="<?= $_base ?>" <?= navActive('home') ?>>Home</a>

                            <!-- ABOUT -->
                            <a href="<?= $_base ?>about-us" <?= navActive('about') ?>>About</a>

                            <!-- SERVICES -->
                            <a href="<?= $_base ?>services" <?= navActive('service') ?>>Services</a>

                            <!-- DOCTORS (DYNAMIC) -->
                           

                            <!-- BLOG -->
                            <a href="<?= $_base ?>blogs" <?= navActive('blog') ?>>Blogs</a>

                            <!-- CONTACT -->
                            <a href="<?= $_base ?>contact-us" <?= navActive('contact') ?>>Contact us</a>

                        </nav>
                    </div>
                </div>

                <!-- SEARCH -->
                <button class="ul-header-search-opener">
                    <i class="flaticon-search"></i>
                </button>

                <!-- BUTTONS -->
                <div class="ul-2-header-bottom-btns">
                    <a href="<?= $_base ?>login" class="ul-btn d-xl-flex d-none">
                        Login <i class="flaticon-arrow-up-right"></i>
                    </a>

                    <a href="<?= $_base ?>contact-us" class="ul-btn d-xxs-none">
                        Book Appointment <i class="flaticon-arrow-up-right"></i>
                    </a>
                </div>

                <!-- MOBILE MENU -->
                <button class="ul-header-sidebar-opener d-lg-none d-flex">
                    <i class="flaticon-hamburger"></i>
                </button>

            </div>
        </div>
    </div>
</header>
<!-- HEADER END -->