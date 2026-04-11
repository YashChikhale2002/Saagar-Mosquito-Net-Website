<?php
session_start();
include 'include/config.php';

// ── Fetch blog by slug ──
$slug = isset($_GET['slug']) ? trim($conn->real_escape_string($_GET['slug'])) : '';

if (!$slug) {
    header('Location: blog.php');
    exit;
}

$result = $conn->query("
    SELECT b.*, bc.name as cat_name, bc.slug as cat_slug
    FROM blogs b
    LEFT JOIN blog_categories bc ON bc.id = b.categories
    WHERE b.slug = '$slug' AND b.is_published = 1
    LIMIT 1
");
$blog = $result->fetch_assoc();

if (!$blog) {
    header('Location: blog.php');
    exit;
}

// ── Increment views ──
$conn->query("UPDATE blogs SET views = views + 1 WHERE id = " . intval($blog['id']));

// ── Prev post ──
$prev_result = $conn->query("
    SELECT id, title, slug FROM blogs
    WHERE is_published = 1 AND published_at < '" . $conn->real_escape_string($blog['published_at']) . "'
    ORDER BY published_at DESC LIMIT 1
");
$prev_post = $prev_result->fetch_assoc();

// ── Next post ──
$next_result = $conn->query("
    SELECT id, title, slug FROM blogs
    WHERE is_published = 1 AND published_at > '" . $conn->real_escape_string($blog['published_at']) . "'
    ORDER BY published_at ASC LIMIT 1
");
$next_post = $next_result->fetch_assoc();

// ── Latest posts for sidebar ──
$latest_result = $conn->query("
    SELECT id, title, image, published_at, slug
    FROM blogs WHERE is_published = 1
    ORDER BY published_at DESC LIMIT 4
");
$latest_posts = [];
while ($row = $latest_result->fetch_assoc()) $latest_posts[] = $row;

// ── Categories for sidebar ──
$categories_result = $conn->query("
    SELECT bc.id, bc.name, bc.slug, COUNT(b.id) as post_count
    FROM blog_categories bc
    LEFT JOIN blogs b ON b.categories = bc.id AND b.is_published = 1
    GROUP BY bc.id ORDER BY bc.sort_order ASC
");
$all_categories = [];
while ($row = $categories_result->fetch_assoc()) $all_categories[] = $row;

// ── Tags ──
$tags_arr = [];
if (!empty($blog['tags'])) {
    $tags_arr = array_filter(array_map('trim', explode(',', $blog['tags'])));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>

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

    <!-- LOAN APPLY FORM START -->
    <div class="ul-form-modal-bg" id="loan-apply-form-modal">
        <div class="ul-form-modal-content">
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
                            <div class="form-group">
                                <input type="text" name="name" id="loan_name" placeholder="Username or Email">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" id="email" placeholder="Email Address">
                            </div>
                            <div class="form-group">
                                <textarea name="address" id="address" placeholder="Full Address"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="text" name="amount" id="amount" placeholder="Loan Amount">
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone" id="phone" placeholder="Phone Number">
                            </div>
                            <div class="form-group">
                                <input type="date" name="date" id="date" placeholder="Select Date">
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" id="loan_password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div>
                                    <input class="form-check-input" type="checkbox" id="terms">
                                    <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
                                </div>
                            </div>
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
        <div class="ul-sidebar-header">
            <div class="ul-sidebar-header-logo">
                <a href="index.html">
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
        <section class="ul-breadcrumb ul-2-banner" <?php if (!empty($blog['image'])): ?>style="background-image: url('<?php echo htmlspecialchars($blog['image']); ?>'); background-size: cover; background-position: center; background-repeat: no-repeat;"<?php endif; ?>>
            <div class="ul-container">
                <h1 class="ul-breadcrumb-title">Blog Details</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index.php">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <a href="blog.php">Our Blogs</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current"><?php echo htmlspecialchars(mb_strimwidth($blog['title'], 0, 40, '...')); ?></span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- BLOG DETAILS SECTION START -->
        <section class="ul-blog-details ul-section-spacing">
            <div class="ul-container">
                <div class="row ul-bs-row gy-5 gx-4">

                    <!-- LEFT / BLOG DETAILS -->
                    <div class="col-lg-8 col-md-7">
                        <div class="ul-blog-details">
                            <div class="ul-blog-details-top">
                                <div class="ul-blog-details-img">
                                    <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                    <?php if (!empty($blog['cat_name'])): ?>
                                    <span class="ul-blog-details-tag"><?php echo htmlspecialchars($blog['cat_name']); ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="ul-blog-details-txt">
                                    <!-- Meta info -->
                                    <div class="ul-2-blog-infos mb-3">
                                        <span><i class="flaticon-calendar"></i> <?php echo date('d F Y', strtotime($blog['published_at'])); ?></span>
                                        <span><i class="flaticon-clock"></i> <?php echo !empty($blog['reading_time']) ? $blog['reading_time'] . ' Min Read' : '1 Min Read'; ?></span>
                                        <span><i class="flaticon-eye"></i> <?php echo number_format($blog['views']); ?> Views</span>
                                    </div>

                                    <h2 class="ul-blog-details-title"><?php echo htmlspecialchars($blog['title']); ?></h2>
                                    <p class="ul-blog-details-descr"><?php echo htmlspecialchars($blog['excerpt']); ?></p>

                                    <!-- Blog content from DB -->
                                    <div class="ul-blog-details-content">
                                        <?php echo $blog['content']; ?>
                                    </div>
                                </div>
                            </div>

                            <!-- ACTIONS: Tags & Share -->
                            <div class="ul-blog-details-actions">
                                <!-- Tags -->
                                <?php if (!empty($tags_arr)): ?>
                                <div class="tags-wrapper">
                                    <h4 class="actions-title">Tags: </h4>
                                    <div class="ul-blog-sidebar-tags tags">
                                        <?php foreach ($tags_arr as $tag): ?>
                                        <a href="blog.php?search=<?php echo urlencode($tag); ?>"><?php echo htmlspecialchars($tag); ?></a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!-- Share -->
                                <div class="shares-wrapper">
                                    <div class="share-options">
                                        <?php $share_url = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" target="_blank"><i class="flaticon-facebook-app-symbol"></i></a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo $share_url; ?>&text=<?php echo urlencode($blog['title']); ?>" target="_blank"><i class="flaticon-twitter"></i></a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank"><i class="flaticon-linkedin"></i></a>
                                        <a href="https://www.instagram.com/" target="_blank"><i class="flaticon-instagram"></i></a>
                                    </div>
                                </div>
                            </div>

                            <!-- PREV / NEXT -->
                            <?php if ($prev_post || $next_post): ?>
                            <div class="ul-blog-details-bottom">
                                <div class="d-flex justify-content-between gap-3 flex-wrap">
                                    <?php if ($prev_post): ?>
                                    <a href="blog-details.php?slug=<?php echo urlencode($prev_post['slug']); ?>" class="ul-btn">
                                        <i class="flaticon-back"></i> Previous Post
                                    </a>
                                    <?php endif; ?>
                                    <?php if ($next_post): ?>
                                    <a href="blog-details.php?slug=<?php echo urlencode($next_post['slug']); ?>" class="ul-btn ul-btn--2">
                                        Next Post <i class="flaticon-arrow-up-right"></i>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>

                    <!-- SIDEBAR -->
                    <div class="col-lg-4 col-md-5">
                        <div class="ul-inner-sidebar">

                            <!-- Search Widget -->
                            <div class="ul-service-details-sidebar-widget ul-inner-sidebar-search">
                                <div class="ul-inner-sidebar-widget-content">
                                    <form action="blog.php" method="GET" class="ul-blog-search-form">
                                        <input type="search" name="search" id="ul-blog-search" placeholder="Search Here">
                                        <button type="submit"><i class="flaticon-search"></i></button>
                                    </form>
                                </div>
                            </div>

                            <!-- Categories Widget -->
                            <?php if (!empty($all_categories)): ?>
                            <div class="ul-service-details-sidebar-widget">
                                <span class="ul-service-details-sidebar-widget-title">Categories</span>
                                <ul class="ul-service-details-sidebar-links">
                                    <?php foreach ($all_categories as $cat): ?>
                                    <li>
                                        <a href="blog.php?category=<?php echo $cat['id']; ?>">
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                            <span>(<?php echo str_pad($cat['post_count'], 2, '0', STR_PAD_LEFT); ?>)</span>
                                        </a>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <?php endif; ?>

                            <!-- Recent Posts Widget -->
                            <?php if (!empty($latest_posts)): ?>
                            <div class="ul-service-details-sidebar-widget ul-inner-sidebar-posts">
                                <h3 class="ul-service-details-sidebar-widget-title">Recent Posts</h3>
                                <div class="ul-inner-sidebar-widget-content">
                                    <div class="ul-inner-sidebar-posts">
                                        <?php foreach ($latest_posts as $lp): ?>
                                        <div class="ul-inner-sidebar-post">
                                            <div class="img">
                                                <img src="<?php echo htmlspecialchars($lp['image']); ?>" alt="<?php echo htmlspecialchars($lp['title']); ?>">
                                            </div>
                                            <div class="txt">
                                                <span class="date"><span><?php echo date('M d, Y', strtotime($lp['published_at'])); ?></span></span>
                                                <h4 class="title">
                                                    <a href="blog-details.php?slug=<?php echo urlencode($lp['slug']); ?>">
                                                        <?php echo htmlspecialchars($lp['title']); ?>
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Tags Widget -->
                            <?php if (!empty($tags_arr)): ?>
                            <div class="ul-service-details-sidebar-widget ul-inner-sidebar-tags">
                                <h3 class="ul-service-details-sidebar-widget-title">Tags</h3>
                                <div class="tags-wrapper">
                                    <?php foreach ($tags_arr as $tag): ?>
                                    <a href="blog.php?search=<?php echo urlencode($tag); ?>"><?php echo htmlspecialchars($tag); ?></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <!-- SIDEBAR END -->

                </div>
            </div>
        </section>
        <!-- BLOG DETAILS SECTION END -->
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
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/tab.js"></script>
    <script src="assets/js/progressbar.js"></script>
    <script src="assets/js/accordion.js"></script>
</body>

</html>