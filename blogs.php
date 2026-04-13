<?php
// Start session (for login systems later)
session_start();

include 'include/config.php';

// ── Filters ──
$active_cat   = isset($_GET['category']) ? intval($_GET['category'])  : 0;
$search_query = isset($_GET['search'])   ? trim($_GET['search'])      : '';

// ── Pagination ──
$per_page     = 6;
$current_page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset       = ($current_page - 1) * $per_page;

// ── WHERE clause ──
$where = "b.is_published = 1";
if ($active_cat > 0) {
    $where .= " AND b.categories = " . intval($active_cat);
}
if ($search_query !== '') {
    $safe_search = $conn->real_escape_string($search_query);
    $where .= " AND (b.title LIKE '%$safe_search%' OR b.excerpt LIKE '%$safe_search%')";
}

// ── Total count ──
$count_result = $conn->query("SELECT COUNT(*) as total FROM blogs b WHERE $where");
$total_blogs  = $count_result->fetch_assoc()['total'];
$total_pages  = max(1, ceil($total_blogs / $per_page));

// ── Fetch blogs ──
$blogs_result = $conn->query("
    SELECT b.*, bc.name as cat_name
    FROM blogs b
    LEFT JOIN blog_categories bc ON bc.id = b.categories
    WHERE $where
    ORDER BY b.published_at DESC
    LIMIT $per_page OFFSET $offset
");
$all_blogs = [];
while ($row = $blogs_result->fetch_assoc()) {
    $all_blogs[] = $row;
}
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
                <h1 class="ul-breadcrumb-title">Our Blogs</h1>
                <div class="ul-breadcrumb-nav">
                    <a href="index">Home</a>
                    <span class="separator"><i class="flaticon-next"></i></span>
                    <span class="current">Our Blogs</span>
                </div>
            </div>
        </section>
        <!-- BREADCRUMB SECTION END -->


        <!-- BLOG SECTION START -->
        <section class="ul-2-blogs ul-2-banner ul-section-spacing">
            <div class="ul-container">

                <!-- blogs -->
                <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 ul-bs-row">

                    <?php if (!empty($all_blogs)): ?>
                        <?php foreach ($all_blogs as $blog): ?>
                        <!-- single blog -->
                        <div class="col">
                            <div class="ul-2-blog">
                                <div class="ul-2-blog-img">
                                    <img src="<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                                </div>

                                <div class="ul-2-blog-txt">
                                    <div class="ul-2-blog-infos">
                                        <span><i class="flaticon-calendar"></i> <?php echo date('d F Y', strtotime($blog['published_at'])); ?></span>
                                        <span><i class="flaticon-clock"></i> <?php echo !empty($blog['reading_time']) ? $blog['reading_time'] . ' Min Read' : '1 Min Read'; ?></span>
                                    </div>
                                    <h3 class="ul-2-blog-title">
                                        <a href="<?= $_base ?><?php echo $blog['slug']; ?>">
                                            <?php echo htmlspecialchars($blog['title']); ?>
                                        </a>
                                    </h3>
                                    <a href="<?= $_base ?><?php echo $blog['slug']; ?>" class="ul-2-blog-btn">
                                        Read More <i class="flaticon-arrow-up-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center py-5">No blogs found.</p>
                        </div>
                    <?php endif; ?>

                </div>
                <!-- blogs end -->

                <!-- PAGINATION START -->
                <?php if ($total_pages > 1): ?>
                <div class="d-flex justify-content-center gap-2 mt-5">
                    <?php if ($current_page > 1): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page - 1])); ?>" class="ul-btn">
                        <i class="flaticon-back"></i>
                    </a>
                    <?php endif; ?>

                    <?php for ($pg = 1; $pg <= $total_pages; $pg++): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $pg])); ?>"
                       class="ul-btn <?php echo $pg == $current_page ? 'active' : ''; ?>">
                        <?php echo $pg; ?>
                    </a>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $current_page + 1])); ?>" class="ul-btn">
                        <i class="flaticon-next"></i>
                    </a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
                <!-- PAGINATION END -->

            </div>
        </section>
        <!-- BLOG SECTION END -->
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