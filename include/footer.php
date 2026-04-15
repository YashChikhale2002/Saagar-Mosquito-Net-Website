<?php
/**
 * Footer File - Saagar Enterprises
 */

$company_name = "Saagar Enterprises";
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
                    <a href="/" class="logo-wrapper">
                        <img src="assets/img/home/logo.png"  style="max-width: 190px; height:70px ;" alt="<?= $company_name ?>  Mosquito Net Dealer Nagpur">
                    </a>

                    <p class="ul-2-footer-about-txt">
                        <?= $company_name ?> is Nagpur's most trusted mosquito net manufacturer & dealer since 2013. We provide custom-fitted mosquito nets for windows, doors, balconies & beds with professional installation across all areas of Nagpur.
                    </p>

                    <!-- SOCIAL -->
                    <div class="ul-2-footer-socials">
                        <a href="https://www.facebook.com/sagarenterprisesnagpur" aria-label="Facebook"><i class="flaticon-facebook-app-symbol"></i></a>
                       
                        <a href="https://www.instagram.com/saagar.enterprises/" aria-label="Instagram"><i class="flaticon-instagram"></i></a>
                    </div>
                </div>

                <!-- USEFUL LINKS -->
                <div class="ul-2-footer-widget">
                    <h3 class="ul-2-footer-widget-title">Useful Links</h3>

                    <div class="ul-2-footer-widget-links">
                       
                                                    <a href="<?= $_base ?>" <?= navActive('home') ?>>Home</a>
                                                          <a href="about-us">About</a> 

                        <a href="services">Services</a> 
                  
                        <a href="blogs">Blogs</a>
                        <a href="contact">Contact Us</a>
                    </div>
                </div>

                <!-- CONTACT -->
                <div class="ul-2-footer-widget ul-2-footer-contact-widget">
                    <h3 class="ul-2-footer-widget-title">Contact Us</h3>

                    <div class="ul-2-footer-contact-infos">

                        <div class="ul-2-footer-contact-info">
                            <span class="ul-2-footer-contact-info-icon">
                                <i class="flaticon-location-pin"></i>
                            </span>
                            <span class="ul-2-footer-contact-info-txt">
                                Varshe Building, Kothi Rd, Mahal,<br>Nagpur – 440032, Maharashtra
                            </span>
                        </div>

                        <div class="ul-2-footer-contact-info">
                            <span class="ul-2-footer-contact-info-icon">
                                <i class="flaticon-telephone"></i>
                            </span>
                            <span class="ul-2-footer-contact-info-txt">
                                <a href="tel:+917719806088" style="color:inherit;">+91 7719806088</a><br>
                               
                            </span>
                        </div>

                        <div class="ul-2-footer-contact-info">
                            <span class="ul-2-footer-contact-info-icon">
                                <i class="flaticon-mail"></i>
                            </span>
                            <span class="ul-2-footer-contact-info-txt">
                                <a href="mailto:saagarenterprises363@gmail.com" style="color:inherit;">saagarenterprises363@gmail.com</a>
                            </span>
                        </div>

                        <div class="ul-2-footer-contact-info">
                            <span class="ul-2-footer-contact-info-icon">
                                <i class="flaticon-clock"></i>
                            </span>
                            <span class="ul-2-footer-contact-info-address">
                                Monday : Closed<br>
                                Tuesday – Sunday : 10:00 AM – 7:00 PM
                            </span>
                        </div>

                    </div>
                </div>

                <!-- NEWSLETTER -->
                <div class="ul-2-footer-widget ul-2-footer-nwsltr-widget">
                    <h3 class="ul-2-footer-widget-title">Get Newsletter</h3>

                    <form action="/subscribe" method="post" class="ul-2-footer-nwsltr-form">
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
        <img src="assets/img/footer-2-vector-1.svg" alt="vector" class="ul-2-footer-vector vector-1">
        <div class="ul-2-footer-vector vector-2">
            <img src="assets/img/footer-2-vector-2.svg" alt="vector">
        </div>
    </div>

</footer>
<!-- FOOTER SECTION END -->