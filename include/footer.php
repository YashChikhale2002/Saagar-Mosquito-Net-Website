<?php
/**
 * Footer File - Niraj Industries
 * Fully Dynamic + New UI Integrated
 */


// Optional dynamic settings (you can later fetch from DB)
$company_name = "Niraj Industries";
$year = date("Y");
?>
<!-- FOOTER SECTION START -->
<footer class="ul-2-footer">
    <div class="ul-container">

        <!-- FOOTER TOP -->
        <div class="ul-2-footer-top">
            <div class="ul-2-footer-top-wrapper">

                <!-- ABOUT -->
                <div class="ul-2-footer-about">
                    <a href="<?= $base_url ?>" class="logo-wrapper">
                        <img src="<?= $base_url ?>assets/img/logo-white.svg" alt="<?= $company_name ?>">
                    </a>

                    <p class="ul-2-footer-about-txt">
                        At <?= $company_name ?>, we deliver high-quality industrial solutions with innovation,
                        reliability, and a strong commitment to customer satisfaction.
                    </p>

                    <!-- SOCIAL -->
                    <div class="ul-2-footer-socials">
                        <a href="#" aria-label="Facebook"><i class="flaticon-facebook-app-symbol"></i></a>
                        <a href="#" aria-label="Twitter"><i class="flaticon-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="flaticon-linkedin"></i></a>
                        <a href="#" aria-label="Instagram"><i class="flaticon-instagram"></i></a>
                    </div>
                </div>

                <!-- USEFUL LINKS -->
                <div class="ul-2-footer-widget">
                    <h3 class="ul-2-footer-widget-title">Useful Links</h3>

                    <div class="ul-2-footer-widget-links">
                        <a href="<?= $base_url ?>">Home</a>
                        <a href="<?= $base_url ?>about-us">About Us</a>
                        <a href="<?= $base_url ?>products">Products</a>
                        <a href="<?= $base_url ?>blogs">Blogs</a>
                        <a href="<?= $base_url ?>contact-us">Contact Us</a>
                    </div>
                </div>

                <!-- CONTACT -->
                <div class="ul-2-footer-widget ul-2-footer-contact-widget">
                    <h3 class="ul-2-footer-widget-title">Contact us</h3>

                    <div class="ul-2-footer-contact-infos">

                        <div class="ul-2-footer-contact-info">
                            <span class="ul-2-footer-contact-info-icon">
                                <i class="flaticon-location-pin"></i>
                            </span>
                            <span class="ul-2-footer-contact-info-txt">
                                Nagpur, Maharashtra, India
                            </span>
                        </div>

                        <div class="ul-2-footer-contact-info">
                            <span class="ul-2-footer-contact-info-icon">
                                <i class="flaticon-clock"></i>
                            </span>
                            <span class="ul-2-footer-contact-info-address">
                                Monday - Saturday : 9:00 AM - 7:00 PM
                            </span>
                        </div>

                    </div>
                </div>

                <!-- NEWSLETTER -->
                <div class="ul-2-footer-widget ul-2-footer-nwsltr-widget">
                    <h3 class="ul-2-footer-widget-title">Get Newsletter</h3>

                    <form action="<?= $base_url ?>subscribe" method="post" class="ul-2-footer-nwsltr-form">
                        <input type="email" name="email" placeholder="Your Email Address" required>
                        <button type="submit">
                            <i class="flaticon-arrow-up-right"></i> SUBSCRIBE NOW
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- FOOTER BOTTOM -->
        <div class="ul-2-footer-bottom justify-content-center">
            <p class="copyright">
                &copy; <?= $year ?> <?= $company_name ?>. All rights reserved.
            </p>
        </div>

    </div>

    <!-- BACKGROUND VECTORS -->
    <div class="ul-2-footer-vectors">
        <img src="<?= $base_url ?>assets/img/footer-2-vector-1.svg" alt="vector" class="ul-2-footer-vector vector-1">
        <div class="ul-2-footer-vector vector-2">
            <img src="<?= $base_url ?>assets/img/footer-2-vector-2.svg" alt="vector">
        </div>
    </div>

</footer>
<!-- FOOTER SECTION END -->