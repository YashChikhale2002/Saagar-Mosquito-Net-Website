<?php
session_start();
include __DIR__ . '/include/config.php';

$_base    = '/Saagar-Mosquito-Net-Website/';
$_svcBase = '/Saagar-Mosquito-Net-Website/service/';

$slug = trim($_GET['slug'] ?? '');

if (empty($slug)) {
    header("Location: " . $_base . "services");
    exit;
}

$slugEsc = $conn->real_escape_string($slug);
$result  = $conn->query("SELECT * FROM mosquito_services WHERE slug = '$slugEsc' AND is_active = 1 LIMIT 1");

if (!$result || $result->num_rows === 0) {
    header("HTTP/1.0 404 Not Found");
    include __DIR__ . '/404.php';
    exit;
}

$service = $result->fetch_assoc();

$services_list  = json_decode($service['services_list'],  true) ?? [];
$features_list  = json_decode($service['features_list'],  true) ?? [];
$why_choose     = json_decode($service['why_choose_list'], true) ?? [];
$faqs           = json_decode($service['faqs'],            true) ?? [];

$meta_title          = $service['meta_title']          ?: $service['title'];
$meta_description    = $service['meta_description']    ?: $service['short_desc'];
$og_title            = $service['og_title']            ?: $meta_title;
$og_description      = $service['og_description']      ?: $meta_description;
$twitter_title       = $service['twitter_title']       ?: $meta_title;
$twitter_description = $service['twitter_description'] ?: $meta_description;
$robots_meta         = $service['robots_meta']         ?: 'index,follow';
$canonical_url       = $service['canonical_url']       ?: ((!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_svcBase . $service['slug']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
    <?php if ($service['focus_keyword']): ?>
    <meta name="keywords" content="<?= htmlspecialchars($service['focus_keyword']) ?>">
    <?php endif; ?>
    <meta name="robots" content="<?= htmlspecialchars($robots_meta) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
<base href="/Saagar-Mosquito-Net-Website/">
    <!-- Open Graph -->
    <meta property="og:type"        content="<?= htmlspecialchars($service['og_type']) ?>">
    <meta property="og:title"       content="<?= htmlspecialchars($og_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og_description) ?>">
    <?php if ($service['og_image']): ?>
    <meta property="og:image"       content="<?= htmlspecialchars($service['og_image']) ?>">
    <?php elseif ($service['image']): ?>
    <meta property="og:image"       content="<?= htmlspecialchars($service['image']) ?>">
    <?php endif; ?>
    <meta property="og:url"         content="<?= htmlspecialchars($canonical_url) ?>">

    <!-- Twitter Card -->
    <meta name="twitter:card"        content="<?= htmlspecialchars($service['twitter_card']) ?>">
    <meta name="twitter:title"       content="<?= htmlspecialchars($twitter_title) ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($twitter_description) ?>">

    <!-- Schema JSON-LD -->
    <?php if (!empty($service['schema_json'])): ?>
    <script type="application/ld+json"><?= $service['schema_json'] ?></script>
    <?php endif; ?>

    <!-- Vendor CSS -->
   <!-- Vendor CSS -->
<link rel="stylesheet" href="/Saagar-Mosquito-Net-Website/assets/vendor/bootstrap/bootstrap.min.css">
<link rel="stylesheet" href="/Saagar-Mosquito-Net-Website/assets/vendor/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/Saagar-Mosquito-Net-Website/assets/vendor/animate-wow/animate.min.css">
<link rel="stylesheet" href="/Saagar-Mosquito-Net-Website/assets/icon/flaticon_cashflow.css">
<link rel="stylesheet" href="/Saagar-Mosquito-Net-Website/assets/css/style.css">
</head>

<body class="home-2">

    <?php include __DIR__ . '/include/header.php'; ?>

    <main>

        <!-- BREADCRUMB -->
        <section class="ul-breadcrumb ul-2-banner">
            <div class="ul-container">
                <h1 class="ul-breadcrumb-title"><?= htmlspecialchars($service['title']) ?></h1>
                <div class="ul-breadcrumb-nav">
                    <a href="<?= $_base ?>">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <a href="<?= $_base ?>services">Services</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current"><?= htmlspecialchars($service['title']) ?></span>
                </div>
            </div>
        </section>

        <!-- SERVICE DETAILS -->
        <section class="ul-service-details ul-section-spacing pb-4">
            <div class="ul-container">
                <div class="ul-service-details-txt">

                    <h2 class="ul-service-details-title">
                        <?= htmlspecialchars($service['title']) ?>
                    </h2>

                    <p class="ul-service-details-descr">
                        <?= htmlspecialchars($service['short_desc']) ?>
                    </p>

                    <?php if ($service['image']): ?>
                    <div class="ul-service-details-img">
                        <img src="<?= htmlspecialchars($service['image']) ?>" alt="<?= htmlspecialchars($service['title']) ?>">
                    </div>
                    <?php endif; ?>

                    <p class="ul-service-details-descr mt-4">
                        <?= nl2br(htmlspecialchars($service['description'])) ?>
                    </p>

                    <?php if (!empty($services_list) || !empty($features_list)): ?>
                    <div class="ul-service-details-blocks">
                        <?php if (!empty($services_list)): ?>
                        <div class="ul-service-details-block">
                            <h3 class="ul-service-details-block-title">Our Services</h3>
                            <ul>
                                <?php foreach ($services_list as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($features_list)): ?>
                        <div class="ul-service-details-block">
                            <h3 class="ul-service-details-block-title">Key Features</h3>
                            <ul>
                                <?php foreach ($features_list as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <?php if ($service['extra_block_title']): ?>
                    <div class="ul-service-details-block">
                        <h3 class="ul-service-details-block-title">
                            <?= htmlspecialchars($service['extra_block_title']) ?>
                        </h3>
                        <p class="ul-service-details-block-descr">
                            <?= htmlspecialchars($service['extra_block_desc']) ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <div class="d-flex align-items-end gap-4 flex-lg-nowrap flex-wrap">
                        <div class="ul-service-details-block">
                            <?php if (!empty($why_choose)): ?>
                            <h3 class="ul-service-details-block-title mt-0">Why Choose Us?</h3>
                            <ul class="d-flex flex-column">
                                <?php foreach ($why_choose as $item): ?>
                                <li><?= htmlspecialchars($item) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>

                            <?php if ($service['testimonial_text']): ?>
                            <blockquote>
                                <p class="descr"><?= htmlspecialchars($service['testimonial_text']) ?></p>
                                <div class="author">
                                    <?php if ($service['testimonial_image']): ?>
                                    <div class="author-img">
                                        <img src="<?= htmlspecialchars($service['testimonial_image']) ?>"
                                             alt="<?= htmlspecialchars($service['testimonial_name']) ?>">
                                    </div>
                                    <?php endif; ?>
                                    <div class="author-info">
                                        <h4 class="author-name"><?= htmlspecialchars($service['testimonial_name']) ?></h4>
                                        <span class="author-title"><?= htmlspecialchars($service['testimonial_role']) ?></span>
                                    </div>
                                </div>
                                <div class="quote-icon"><i class="flaticon-double-quotes"></i></div>
                                <img src="assets/img/service-details-quote-vector.svg" alt="vector" class="vector">
                            </blockquote>
                            <?php endif; ?>
                        </div>

                        <?php if ($service['inner_image']): ?>
                        <div class="ul-service-details-block-img">
                            <img src="<?= htmlspecialchars($service['inner_image']) ?>"
                                 alt="<?= htmlspecialchars($service['title']) ?>">
                        </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </section>

        <!-- FAQ SECTION -->
        <?php if (!empty($faqs)): ?>
        <section class="ul-inner-faq ul-section-spacing pt-0">
            <div class="ul-container">
                <div class="row">
                    <div class="col-5">
                        <div class="ul-inner-faq-img d-lg-block d-none">
                            <img src="assets/img/question.svg" alt="FAQ">
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="ul-2-faq-txt ms-lg-4 ms-0">
                            <div class="ul-2-faq-accordion ul-accordion">
                                <?php foreach ($faqs as $i => $faq): ?>
                                <div class="ul-single-accordion-item <?= $i === 0 ? 'open' : '' ?>">
                                    <div class="ul-single-accordion-item__header">
                                        <div class="left">
                                            <span class="ul-single-accordion-item__index">
                                                <?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>
                                            </span>
                                            <span class="ul-single-accordion-item__title">
                                                <?= htmlspecialchars($faq['question']) ?>
                                            </span>
                                        </div>
                                        <span class="ul-single-accordion-item__icon">
                                            <i class="flaticon-arrow-down-sign-to-navigate"></i>
                                        </span>
                                    </div>
                                    <div class="ul-single-accordion-item__body">
                                        <p class="ul-single-accordion-item__content">
                                            <?= htmlspecialchars($faq['answer']) ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php
        // ── Related Services ──
        $currentId = (int)$service['id'];
        $relResult = $conn->query("
            SELECT id, title, slug, short_desc, image
            FROM mosquito_services
            WHERE is_active = 1
              AND id != $currentId
            ORDER BY created_at DESC
            LIMIT 3
        ");
        $relatedServices = [];
        if ($relResult) while ($row = $relResult->fetch_assoc()) $relatedServices[] = $row;
        ?>

        <?php if (!empty($relatedServices)): ?>
        <section class="ul-related-services ul-section-spacing pt-0 pb-5">
            <div class="ul-container">

                <div class="ul-section-title text-center mb-5">
                    <h2 class="ul-section-title__title">Related Services</h2>
                </div>

                <div class="row g-4">
                    <?php foreach ($relatedServices as $rel): ?>
                    <?php
                        $relImg   = !empty($rel['image'])
                            ? htmlspecialchars($rel['image'])
                            : 'assets/img/service-placeholder.webp';
                        $relTitle = htmlspecialchars($rel['title']);
                        $relDesc  = htmlspecialchars(mb_strimwidth($rel['short_desc'] ?? '', 0, 100, '…'));
                        $relUrl   = $_svcBase . htmlspecialchars($rel['slug']); // ✅ /service/slug
                    ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="ul-related-service-card h-100">

                            <div class="ul-related-service-card__img">
                                <img src="<?= $relImg ?>" alt="<?= $relTitle ?>" loading="lazy">
                                <div class="ul-related-service-card__overlay">
                                    <a href="<?= $relUrl ?>" class="ul-related-service-card__view-btn">
                                        View Service
                                    </a>
                                </div>
                            </div>

                            <div class="ul-related-service-card__body">
                                <h3 class="ul-related-service-card__title">
                                    <a href="<?= $relUrl ?>"><?= $relTitle ?></a>
                                </h3>
                                <p class="ul-related-service-card__desc"><?= $relDesc ?></p>
                                <a href="<?= $relUrl ?>" class="ul-related-service-card__link">
                                    Read More <i class="flaticon-next"></i>
                                </a>
                            </div>

                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
        <?php endif; ?>

    </main>

    <?php include __DIR__ . '/include/footer.php'; ?>

<script src="/Saagar-Mosquito-Net-Website/assets/vendor/bootstrap/bootstrap.bundle.min.js"></script>
<script src="/Saagar-Mosquito-Net-Website/assets/vendor/animate-wow/wow.min.js"></script>
<script src="/Saagar-Mosquito-Net-Website/assets/vendor/splittype/index.min.js"></script>
<script src="/Saagar-Mosquito-Net-Website/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/Saagar-Mosquito-Net-Website/assets/vendor/fslightbox/fslightbox.js"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
<script src="/Saagar-Mosquito-Net-Website/assets/js/main.js"></script>
<script src="/Saagar-Mosquito-Net-Website/assets/js/tab.js"></script>
<script src="/Saagar-Mosquito-Net-Website/assets/js/accordion.js"></script>
</body>
</html>