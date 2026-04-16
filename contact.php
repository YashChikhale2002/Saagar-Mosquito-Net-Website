<?php
// ============================================================
// contact.php
// Works on: localhost/Saagar-Mosquito-Net-Website/ AND live domain
// ============================================================
session_start();
include __DIR__ . '/include/config.php';

// ── Dynamic base URL — auto-detects localhost vs live ────────
$protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host      = $_SERVER['HTTP_HOST'];
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
// e.g. on localhost: /Saagar-Mosquito-Net-Website
// e.g. on live:      (empty string)
define('BASE_URL', $protocol . '://' . $host . $scriptDir);

$page_title       = "Contact Us | Saagar Enterprises – Mosquito Net Dealer in Nagpur";
$meta_description = "Contact Saagar Enterprises – Nagpur's #1 mosquito net dealer since 2013. Visit us at Mahal or Raghuji Nagar, call +91 7719806088, or email saagarenterprises363@gmail.com. Book a FREE home measurement visit today!";
$meta_keywords    = "contact mosquito net Nagpur, Saagar Enterprises contact, mosquito net dealer Nagpur, mosquito net shop Nagpur, mosquito net Mahal Nagpur, book mosquito net installation Nagpur, saagarmosquitonet.com contact";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($meta_description); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($meta_keywords); ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://saagarmosquitonet.com/contact">

    <!-- Open Graph SEO -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Contact Saagar Enterprises | Mosquito Net Dealer Nagpur">
    <meta property="og:description" content="Visit our Mahal or Raghuji Nagar branch in Nagpur. Call +91 7719806088 or email saagarenterprises363@gmail.com. Book a FREE home measurement visit for mosquito nets.">
    <meta property="og:url" content="https://saagarmosquitonet.com/contact">
    <meta property="og:image" content="https://saagarmosquitonet.com/assets/img/mosquito-net-nagpur.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Contact Saagar Enterprises | Mosquito Net Nagpur">
    <meta name="twitter:description" content="Nagpur's trusted mosquito net dealer. Call +91 7719806088 to book a FREE home measurement visit.">

    <!-- Local Business Schema -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "LocalBusiness",
      "name": "Saagar Enterprises",
      "description": "Nagpur's most trusted mosquito net manufacturer and dealer since 2013.",
      "url": "https://saagarmosquitonet.com",
      "telephone": "+917719806088",
      "email": "saagarenterprises363@gmail.com",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Varshe Building, Mohan Motiramji, Kothi Road, Mahal",
        "addressLocality": "Nagpur",
        "addressRegion": "Maharashtra",
        "postalCode": "440032",
        "addressCountry": "IN"
      }
    }
    </script>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/vendor/animate-wow/animate.min.css">
    <link rel="stylesheet" href="assets/icon/flaticon_cashflow.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- ── Contact Form Styles ── -->
    <style>
        .ul-field-error {
            display: block;
            color: #e53935;
            font-size: 12px;
            margin-top: 5px;
            margin-left: 2px;
        }
        .ul-form .form-group input.input-error,
        .ul-form .form-group textarea.input-error {
            border-color: #e53935 !important;
        }
        .ul-form .form-group input.input-success,
        .ul-form .form-group textarea.input-success {
            border-color: #43a047 !important;
        }
        #contact-toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99999;
            min-width: 280px;
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #fff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.18);
            display: none;
            animation: slideIn 0.3s ease;
        }
        #contact-toast.toast-success { background: #43a047; }
        #contact-toast.toast-error   { background: #e53935; }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        #contact-submit-btn .btn-spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin-left: 8px;
            vertical-align: middle;
        }
        #contact-submit-btn.loading .btn-spinner { display: inline-block; }
        #contact-submit-btn.loading .btn-text    { opacity: 0.7; }
        @keyframes spin { to { transform: rotate(360deg); } }
        #wa-redirect-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.55);
            z-index: 999999;
            align-items: center;
            justify-content: center;
        }
        #wa-redirect-overlay.show { display: flex; }
        #wa-redirect-box {
            background: #fff;
            border-radius: 12px;
            padding: 36px 32px;
            text-align: center;
            max-width: 380px;
            width: 90%;
            box-shadow: 0 8px 40px rgba(0,0,0,0.2);
        }
        #wa-redirect-box .wa-icon { font-size: 48px; margin-bottom: 12px; }
        #wa-redirect-box h3 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #1a1a1a;
        }
        #wa-redirect-box p { font-size: 14px; color: #555; margin-bottom: 24px; }
        .wa-open-btn {
            display: inline-block;
            background: #25D366;
            color: #fff !important;
            padding: 12px 28px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            margin-bottom: 10px;
        }
        .wa-skip-btn {
            display: block;
            color: #888;
            font-size: 13px;
            cursor: pointer;
            margin-top: 8px;
            background: none;
            border: none;
            text-decoration: underline;
        }
        #wa-countdown { font-size: 13px; color: #aaa; margin-top: 6px; }
        /* ── CAPTCHA SECTION ── */
        #captcha-section {
            display: none;
            overflow: hidden;
        }
        #captcha-section.captcha-visible {
            display: block;
            animation: captchaSlideIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) both;
        }
        @keyframes captchaSlideIn {
            from { opacity: 0; transform: translateY(-20px) scale(0.95); }
            to   { opacity: 1; transform: translateY(0)    scale(1);    }
        }
        .captcha-box {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
            border: 2px solid #e0e7ff;
            border-radius: 14px;
            padding: 24px 28px;
            margin-bottom: 20px;
            position: relative;
        }
        .captcha-box::before {
            content: '🔐 Security Check';
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #6366f1;
            margin-bottom: 14px;
        }
        .captcha-question-row {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }
        .captcha-question-display {
            background: #fff;
            border: 2px solid #c7d2fe;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 22px;
            font-weight: 800;
            color: #312e81;
            letter-spacing: 2px;
            min-width: 140px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(99,102,241,0.10);
        }
        .captcha-answer-input {
            width: 110px !important;
            padding: 10px 14px !important;
            font-size: 18px !important;
            font-weight: 700 !important;
            text-align: center !important;
            border: 2px solid #c7d2fe !important;
            border-radius: 10px !important;
            outline: none !important;
            transition: border-color 0.2s !important;
            background: #fff !important;
        }
        .captcha-answer-input:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15) !important;
        }
        .captcha-answer-input.input-error  { border-color: #e53935 !important; }
        .captcha-answer-input.input-success{ border-color: #43a047 !important; }
        .captcha-equals {
            font-size: 22px;
            font-weight: 800;
            color: #6366f1;
        }
        .captcha-refresh-btn {
            background: none;
            border: 2px solid #c7d2fe;
            border-radius: 50%;
            width: 36px; height: 36px;
            cursor: pointer;
            font-size: 16px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
            color: #6366f1;
            flex-shrink: 0;
        }
        .captcha-refresh-btn:hover {
            background: #e0e7ff;
            border-color: #6366f1;
            transform: rotate(180deg);
        }
        .captcha-hint {
            font-size: 12px;
            color: #94a3b8;
            margin-top: 10px;
        }
        /* Submit button states */
        #contact-submit-btn.captcha-mode {
            background: #6366f1;
        }
        #verify-submit-btn {
            margin-top: 4px;
        }
    </style>
</head>

<body class="home-2">

    <!-- ── WhatsApp Redirect Overlay ── -->
    <div id="wa-redirect-overlay">
        <div id="wa-redirect-box">
            <div class="wa-icon">&#x2705;</div>
            <h3>Enquiry Submitted!</h3>
            <p>Your message has been saved. Now send it directly to us on <strong>WhatsApp</strong> for faster response!</p>
            <a href="#" id="wa-open-btn" class="wa-open-btn" target="_blank" rel="noopener noreferrer">
                &#x1F4F2; Open WhatsApp
            </a>
            <div id="wa-countdown">Auto-opening in <span id="wa-timer">5</span>s...</div>
            <button class="wa-skip-btn" id="wa-skip-btn">No thanks, skip</button>
        </div>
    </div>

    <!-- ── Toast Notification ── -->
    <div id="contact-toast" role="alert" aria-live="polite"></div>

    <!-- LOGIN FORM START -->
    <div class="ul-form-modal-bg" id="login-form-modal">
        <div class="ul-form-modal-content">
            <button class="ul-form-modal-closer"><i class="flaticon-close"></i></button>
            <div class="row row-cols-md-2 row-cols-1 g-0">
                <div class="col">
                    <div class="ul-form-modal-img">
                        <img src="assets/img/login-amico.svg" alt="Get Free Mosquito Net Quote Nagpur">
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
    <!-- LOGIN FORM END -->

    <!-- LOAN APPLY FORM START -->
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
                                <input type="text" name="name" placeholder="Your Full Name">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <textarea name="address" placeholder="Your Full Address in Nagpur"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" name="net_type" placeholder="Net Type (Window / Door / Bed)">
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" placeholder="Mobile Number">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date">
                            </div>
                            <div class="form-group">
                                <select name="net-system">
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
    <!-- LOAN APPLY FORM END -->

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

    <div class="ul-search-form-wrapper flex-grow-1 flex-shrink-0">
        <button class="ul-search-closer"><i class="flaticon-close"></i></button>
        <form action="#" class="ul-search-form">
            <div class="ul-search-form-right">
                <input type="search" name="search" placeholder="Search Mosquito Net Products...">
                <button type="submit"><span class="icon"><i class="flaticon-search"></i></span></button>
            </div>
        </form>
    </div>

    <?php include __DIR__ . '/include/header.php'; ?>

    <main>
        <!-- BREADCRUMB SECTION START -->
        <section class="ul-breadcrumb ul-2-banner">
            <div class="ul-container">
                <h1 class="ul-breadcrumb-title">Contact Us</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Contact Us</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->

        <!-- CONTACT SECTION START -->
        <section class="ul-inner-contact ul-section-spacing pb-0">
            <div class="ul-container">
                <div class="row gy-4">

                    <!-- ── Contact Form ── -->
                    <div class="col-lg-8">
                        <div class="ul-team-details-contact">
                            <form id="contact-form" class="ul-contact-form ul-form" novalidate>
                                <div class="row row-cols-2 row-cols-xxs-1 ul-bs-row">

                                    <!-- Name -->
                                    <div class="col">
                                        <div class="form-group">
                                            <input
                                                type="text"
                                                name="name"
                                                id="ul-contact-name"
                                                placeholder="Your Full Name"
                                                autocomplete="name"
                                                maxlength="100"
                                            >
                                            <span class="ul-field-error" id="err-name"></span>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col">
                                        <div class="form-group">
                                            <input
                                                type="email"
                                                name="email"
                                                id="ul-contact-email"
                                                placeholder="Email Address"
                                                autocomplete="email"
                                                maxlength="150"
                                            >
                                            <span class="ul-field-error" id="err-email"></span>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <input
                                                type="tel"
                                                name="phone"
                                                id="ul-contact-phone"
                                                placeholder="Mobile Number (10 digits)"
                                                autocomplete="tel"
                                                maxlength="10"
                                            >
                                            <span class="ul-field-error" id="err-phone"></span>
                                        </div>
                                    </div>

                                    <!-- Message -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea
                                                name="message"
                                                id="ul-contact-msg"
                                                placeholder="Tell us your mosquito net requirement (e.g. Window net for 2BHK, Nagpur)..."
                                                maxlength="1000"
                                                rows="5"
                                            ></textarea>
                                            <span class="ul-field-error" id="err-message"></span>
                                        </div>
                                    </div>
<!-- Message -->
                                    

                                    <!-- CAPTCHA — hidden initially -->
                                    <div class="col-12" id="captcha-section">
                                        <div class="captcha-box">
                                            <div class="captcha-question-row">
                                                <div class="captcha-question-display" id="captcha-question">...</div>
                                                <span class="captcha-equals">=</span>
                                                <input
                                                    type="number"
                                                    id="captcha-input"
                                                    class="captcha-answer-input"
                                                    placeholder="?"
                                                    autocomplete="off"
                                                >
                                                <button type="button" class="captcha-refresh-btn" id="captcha-refresh" title="New question">↻</button>
                                            </div>
                                            <span class="ul-field-error" id="err-captcha"></span>
                                            <div class="captcha-hint">Solve the math to prove you're human</div>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-12">
                                        <!-- Step 1: Show captcha -->
                                        <button type="button" class="ul-btn" id="contact-submit-btn">
                                            <span class="btn-text">SEND MESSAGE</span>
                                            <i class="flaticon-arrow-up-right"></i>
                                            <span class="btn-spinner"></span>
                                        </button>
                                        <!-- Step 2: Verify & Submit (hidden initially) -->
                                        <button type="submit" class="ul-btn" id="verify-submit-btn" style="display:none; background:#6366f1;">
                                            <span class="btn-text">VERIFY & SUBMIT</span>
                                            <i class="flaticon-arrow-up-right"></i>
                                            <span class="btn-spinner"></span>
                                        </button>
                                    </div>
                                   

                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ── Contact Info ── -->
                    <div class="col-lg-4">
                        <div class="ul-contact-infos">
                            <div class="ul-contact-infos-top">
                                <div class="ul-contact-infos-header">
                                    <span class="ul-contact-infos-title">Need Any Help?</span>
                                    <p class="ul-contact-infos-descr">Call Saagar Enterprises 24/7 for Free Quote & Booking</p>
                                </div>
                                <div class="ul-contact-infos-body">
                                    <div class="ul-contact-info">
                                        <div class="ul-contact-info-icon"><i class="flaticon-telephone"></i></div>
                                        <div class="ul-contact-info-txt">
                                            <span class="ul-contact-info-title">Call Us:</span>
                                            <span class="ul-contact-info-descr">
                                                <a href="tel:+917719806088">+91 7719806088</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ul-contact-info">
                                        <div class="ul-contact-info-icon"><i class="flaticon-mail"></i></div>
                                        <div class="ul-contact-info-txt">
                                            <span class="ul-contact-info-title">Mail Us:</span>
                                            <span class="ul-contact-info-descr">
                                                <a href="mailto:saagarenterprises363@gmail.com">saagarenterprises363@gmail.com</a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ul-contact-info">
                                        <div class="ul-contact-info-icon"><i class="flaticon-location-pin"></i></div>
                                        <div class="ul-contact-info-txt">
                                            <span class="ul-contact-info-title">Our Location:</span>
                                            <span class="ul-contact-info-descr">
                                                Varshe Building, Kothi Rd,<br>
                                                Mahal, Nagpur &ndash; 440032
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- CONTACT SECTION END -->

        <!-- MAP -->
        <div class="ul-contact-map ul-section-spacing">
            <div class="ul-container">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3721.837560000001!2d79.08558!3d21.14507!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x4219f0341a9b11e!2sSaagar%20Enterprises%2C%20Mosquito%20Net%20Dealer!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Saagar Enterprises Mosquito Net Dealer – Mahal, Nagpur">
                </iframe>
            </div>
        </div>
    </main>

    <?php include __DIR__ . '/include/footer.php'; ?>

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

    <!-- ══════════════════════════════════════════════════
         CONTACT FORM — AJAX + VALIDATION + WHATSAPP
         handler URL auto-detects localhost vs live server
    ══════════════════════════════════════════════════ -->
    <script>
const HANDLER_URL = '<?php echo BASE_URL; ?>/contact_handler.php';

(function () {
    'use strict';

    const form            = document.getElementById('contact-form');
    const btnShowCaptcha  = document.getElementById('contact-submit-btn');
    const btnVerifySubmit = document.getElementById('verify-submit-btn');
    const captchaSection  = document.getElementById('captcha-section');
    const toast           = document.getElementById('contact-toast');
    const waOverlay       = document.getElementById('wa-redirect-overlay');
    const waOpenBtn       = document.getElementById('wa-open-btn');
    const waSkipBtn       = document.getElementById('wa-skip-btn');
    const waTimer         = document.getElementById('wa-timer');

    let waCountdownInterval = null;
    let captchaAnswer       = 0;
    let captchaShown        = false;

    // ── CAPTCHA ───────────────────────────────────────────
    function generateCaptcha() {
        const a   = Math.floor(Math.random() * 10) + 1;
        const b   = Math.floor(Math.random() * 10) + 1;
        const ops = ['+', '-', '×'];
        const op  = ops[Math.floor(Math.random() * ops.length)];

        if (op === '+')       captchaAnswer = a + b;
        else if (op === '-')  captchaAnswer = a - b;
        else                  captchaAnswer = a * b;

        document.getElementById('captcha-question').textContent = `${a}  ${op}  ${b}`;
        document.getElementById('captcha-input').value = '';
        document.getElementById('err-captcha').textContent = '';
        document.getElementById('captcha-input').classList.remove('input-error', 'input-success');
    }

    function showCaptcha() {
        if (captchaShown) return;
        captchaShown = true;
        generateCaptcha();
        captchaSection.classList.add('captcha-visible');
        btnShowCaptcha.style.display  = 'none';
        btnVerifySubmit.style.display = 'inline-flex';
        // Smooth scroll to captcha
        setTimeout(function () {
            captchaSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            document.getElementById('captcha-input').focus();
        }, 150);
    }

    document.getElementById('captcha-refresh').addEventListener('click', generateCaptcha);

    // ── Fields ────────────────────────────────────────────
    const fields = {
        name    : document.getElementById('ul-contact-name'),
        email   : document.getElementById('ul-contact-email'),
        phone   : document.getElementById('ul-contact-phone'),
        message : document.getElementById('ul-contact-msg'),
    };

    const errorEls = {
        name    : document.getElementById('err-name'),
        email   : document.getElementById('err-email'),
        phone   : document.getElementById('err-phone'),
        message : document.getElementById('err-message'),
    };

    // ── Validators ────────────────────────────────────────
    const validators = {
        name(v) {
            if (!v)              return 'Please enter your full name.';
            if (v.length < 2)   return 'Name must be at least 2 characters.';
            if (v.length > 100) return 'Name must not exceed 100 characters.';
            if (!/^[a-zA-Z\s.\-']+$/.test(v)) return 'Name can only contain letters, spaces, dots, or hyphens.';
            return '';
        },
        email(v) {
            if (!v)   return 'Please enter your email address.';
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)) return 'Please enter a valid email address.';
            return '';
        },
        phone(v) {
            if (!v)   return 'Please enter your mobile number.';
            if (!/^[6-9][0-9]{9}$/.test(v)) return 'Please enter a valid 10-digit Indian mobile number.';
            return '';
        },
        message(v) {
            if (!v)              return 'Please describe your requirement.';
            if (v.length < 10)   return 'Message must be at least 10 characters.';
            if (v.length > 1000) return 'Message must not exceed 1000 characters.';
            return '';
        }
    };

    function showError(field, msg) {
        if (!errorEls[field]) return;
        errorEls[field].textContent = msg;
        fields[field].classList.add('input-error');
        fields[field].classList.remove('input-success');
    }

    function clearError(field) {
        if (!errorEls[field]) return;
        errorEls[field].textContent = '';
        fields[field].classList.remove('input-error');
        fields[field].classList.add('input-success');
    }

    // ── Live validation ───────────────────────────────────
    Object.keys(fields).forEach(key => {
        fields[key].addEventListener('blur', function () {
            const err = validators[key](this.value.trim());
            err ? showError(key, err) : clearError(key);
        });
        fields[key].addEventListener('input', function () {
            if (fields[key].classList.contains('input-error')) {
                const err = validators[key](this.value.trim());
                if (!err) clearError(key);
            }
        });
    });

    // ── Phone: digits only ────────────────────────────────
    fields.phone.addEventListener('keypress', function (e) {
        if (!/[0-9]/.test(e.key)) e.preventDefault();
    });

    // ── Captcha input: digits + minus only ───────────────
    document.getElementById('captcha-input').addEventListener('keypress', function (e) {
        if (!/[0-9\-]/.test(e.key)) e.preventDefault();
    });

    function validateFields() {
        let valid = true;
        Object.keys(fields).forEach(key => {
            const err = validators[key](fields[key].value.trim());
            if (err) { showError(key, err); valid = false; }
            else       clearError(key);
        });
        return valid;
    }

    function validateCaptcha() {
        const val = document.getElementById('captcha-input').value.trim();
        const el  = document.getElementById('captcha-input');
        const err = document.getElementById('err-captcha');
        if (!val) {
            err.textContent = 'Please solve the math question.';
            el.classList.add('input-error');
            return false;
        }
        if (parseInt(val) !== captchaAnswer) {
            err.textContent = '❌ Wrong answer! Try again.';
            el.classList.add('input-error');
            el.classList.remove('input-success');
            generateCaptcha();
            return false;
        }
        err.textContent = '';
        el.classList.remove('input-error');
        el.classList.add('input-success');
        return true;
    }

    // ── Toast ─────────────────────────────────────────────
    function showToast(msg, type) {
        toast.textContent    = msg;
        toast.className      = 'toast-' + (type || 'success');
        toast.style.display  = 'block';
        setTimeout(function () { toast.style.display = 'none'; }, 4000);
    }

    // ── WhatsApp Overlay ──────────────────────────────────
    function openWaOverlay(url) {
        waOpenBtn.href = url;
        waOverlay.classList.add('show');
        var count = 5;
        waTimer.textContent = count;
        waCountdownInterval = setInterval(function () {
            count--;
            waTimer.textContent = count;
            if (count <= 0) {
                clearInterval(waCountdownInterval);
                waOverlay.classList.remove('show');
                window.location.href = url;
            }
        }, 1000);
    }

    function closeWaOverlay() {
        clearInterval(waCountdownInterval);
        waOverlay.classList.remove('show');
    }

    waSkipBtn.addEventListener('click', closeWaOverlay);
    waOpenBtn.addEventListener('click', function () {
        clearInterval(waCountdownInterval);
        waOverlay.classList.remove('show');
    });

    // ── STEP 1: "SEND MESSAGE" — validate fields, show captcha ──
    btnShowCaptcha.addEventListener('click', function () {
        if (!validateFields()) {
            showToast('Please fill all fields correctly.', 'error');
            return;
        }
        showCaptcha();
    });

    // ── STEP 2: "VERIFY & SUBMIT" — verify captcha, submit form ──
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Re-validate fields (safety check)
        if (!validateFields()) {
            // Hide captcha, show main button again
            captchaShown = false;
            captchaSection.classList.remove('captcha-visible');
            btnShowCaptcha.style.display  = 'inline-flex';
            btnVerifySubmit.style.display = 'none';
            showToast('Please fix the errors above.', 'error');
            return;
        }

        // Validate captcha
        if (!validateCaptcha()) {
            showToast('❌ Wrong answer! A new question has been generated.', 'error');
            document.getElementById('captcha-input').focus();
            return;
        }

        // ── Loading state ─────────────────────────────────
        btnVerifySubmit.classList.add('loading');
        btnVerifySubmit.disabled = true;

        var formData = new FormData();
        formData.append('name',    fields.name.value.trim());
        formData.append('email',   fields.email.value.trim());
        formData.append('phone',   fields.phone.value.trim());
        formData.append('message', fields.message.value.trim());

        fetch(HANDLER_URL, { method: 'POST', body: formData })
        .then(function (res) {
            if (!res.ok) throw new Error('HTTP ' + res.status);
            return res.text();
        })
        .then(function (text) {
            var data;
            try { data = JSON.parse(text); }
            catch (e) {
                console.error('Non-JSON response:', text);
                throw new Error('Invalid server response');
            }

            btnVerifySubmit.classList.remove('loading');
            btnVerifySubmit.disabled = false;

            if (data.success) {
                // Reset form completely
                form.reset();
                Object.keys(fields).forEach(function (k) {
                    fields[k].classList.remove('input-success', 'input-error');
                });
                // Hide captcha, show original button
                captchaShown = false;
                captchaSection.classList.remove('captcha-visible');
                btnShowCaptcha.style.display  = 'inline-flex';
                btnVerifySubmit.style.display = 'none';
                generateCaptcha();

                showToast(data.message, 'success');
                if (data.whatsapp_url) {
                    setTimeout(function () { openWaOverlay(data.whatsapp_url); }, 800);
                }
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(function (key) {
                        if (errorEls[key]) showError(key, data.errors[key]);
                    });
                    showToast('Please fix the errors and try again.', 'error');
                } else {
                    showToast(data.message || 'Something went wrong.', 'error');
                }
                generateCaptcha();
            }
        })
        .catch(function (err) {
            btnVerifySubmit.classList.remove('loading');
            btnVerifySubmit.disabled = false;
            console.error('Contact form error:', err);
            showToast('Something went wrong. Please try again.', 'error');
            generateCaptcha();
        });
    });

})();
</script>

</body>
</html>