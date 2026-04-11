<?php
require_once __DIR__ . '/../include/config.php';
require_once __DIR__ . '/include/auth.php';

// ── Products Stats ────────────────────────────────────────────────────────────
$totalProducts    = (int)$conn->query("SELECT COUNT(*) AS c FROM products")->fetch_assoc()['c'];
$activeProducts   = (int)$conn->query("SELECT COUNT(*) AS c FROM products WHERE is_active=1")->fetch_assoc()['c'];
$inactiveProducts = $totalProducts - $activeProducts;

// ── Products by Category ──────────────────────────────────────────────────────
$catStats = [];
$res = $conn->query("SELECT category, COUNT(*) AS total FROM products WHERE is_active=1 GROUP BY category ORDER BY total DESC");
if ($res) while ($r = $res->fetch_assoc()) $catStats[] = $r;

// ── In Stock vs Out of Stock ──────────────────────────────────────────────────
$inStock    = (int)$conn->query("SELECT COUNT(*) AS c FROM products WHERE in_stock=1 AND is_active=1")->fetch_assoc()['c'];
$outOfStock = (int)$conn->query("SELECT COUNT(*) AS c FROM products WHERE in_stock=0 AND is_active=1")->fetch_assoc()['c'];

// ── Admin Users ───────────────────────────────────────────────────────────────
$totalUsers  = (int)$conn->query("SELECT COUNT(*) AS c FROM admin_users")->fetch_assoc()['c'];
$activeUsers = (int)$conn->query("SELECT COUNT(*) AS c FROM admin_users WHERE status=1")->fetch_assoc()['c'];

// ── Blog Stats ────────────────────────────────────────────────────────────────
$totalBlogs     = (int)$conn->query("SELECT COUNT(*) AS c FROM blogs")->fetch_assoc()['c'];
$publishedBlogs = (int)$conn->query("SELECT COUNT(*) AS c FROM blogs WHERE is_published=1")->fetch_assoc()['c'];
$draftBlogs     = $totalBlogs - $publishedBlogs;
$totalViews     = (int)$conn->query("SELECT COALESCE(SUM(views),0) AS c FROM blogs")->fetch_assoc()['c'];

// ── Blog Categories Stats ─────────────────────────────────────────────────────
$blogCatStats = [];
$res = $conn->query("
    SELECT bc.name, COUNT(b.id) AS total
    FROM blog_categories bc
    LEFT JOIN blogs b ON b.categories = bc.id AND b.is_published = 1
    GROUP BY bc.id
    ORDER BY bc.sort_order ASC
");
if ($res) while ($r = $res->fetch_assoc()) $blogCatStats[] = $r;

// ── Recent Products ───────────────────────────────────────────────────────────
$recentProducts = [];
$res = $conn->query("
    SELECT id, name, category, image, badge, badge_type, moq, rating, reviews, in_stock, is_active, created_at
    FROM products
    ORDER BY created_at DESC
    LIMIT 8
");
if ($res) while ($r = $res->fetch_assoc()) $recentProducts[] = $r;

// ── Recent Blogs ──────────────────────────────────────────────────────────────
$recentBlogs = [];
$res = $conn->query("
    SELECT b.id, b.title, b.slug, b.image, b.views, b.comments, b.is_published,
           b.published_at, b.reading_time, b.created_at,
           bc.name AS cat_name
    FROM blogs b
    LEFT JOIN blog_categories bc ON bc.id = b.categories
    ORDER BY b.created_at DESC
    LIMIT 8
");
if ($res) while ($r = $res->fetch_assoc()) $recentBlogs[] = $r;

// ── Recent Activity Log ───────────────────────────────────────────────────────
$activityLog = [];
$res = $conn->query("
    SELECT l.action, l.detail, l.ip, l.created_at, u.name AS user_name
    FROM admin_activity_log l
    LEFT JOIN admin_users u ON u.id = l.user_id
    ORDER BY l.created_at DESC
    LIMIT 8
");
if ($res) while ($r = $res->fetch_assoc()) $activityLog[] = $r;

// ── Admin Users List ──────────────────────────────────────────────────────────
$adminUsers = [];
$res = $conn->query("SELECT id, name, email, role, status, login_count, last_login FROM admin_users ORDER BY created_at DESC");
if ($res) while ($r = $res->fetch_assoc()) $adminUsers[] = $r;

// ── Page Meta ─────────────────────────────────────────────────────────────────
$pageTitle  = 'Dashboard';
$activePage = 'dashboard';
require_once __DIR__ . '/include/head.php';
?>

    <?php require_once __DIR__ . '/include/header.php'; ?>
    <?php require_once __DIR__ . '/include/sidebar.php'; ?>

    <div class="page-wrapper" style="background:#f4f6f9;min-height:100vh;">
        <div class="content container-fluid pt-4 pb-5">

            <?php if (isset($_GET['err']) && $_GET['err'] === 'noperm'): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
                <i class="fa fa-lock me-2"></i>
                <strong>Access Denied.</strong> You don't have permission to access that section.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold text-dark mb-1" style="font-size:1.5rem;">
                        Welcome back, <?= htmlspecialchars($_ADMIN['name']) ?>! 👋
                    </h3>
                    <p class="text-muted mb-0" style="font-size:.85rem;">
                        <i class="fa fa-calendar-alt me-1"></i><?= date('l, d M Y') ?>
                    </p>
                </div>
                <div class="d-flex gap-2">
                    <?php if (canAccess('blogs') && !hasRole('viewer')): ?>
                    <a href="<?= SITE_URL ?>/admin/blogs/add" class="btn fw-semibold px-3" style="border-radius:10px;background:#e0f2fe;border:none;color:#0369a1;font-size:.85rem;">
                        <i class="fa fa-plus me-1"></i>Add Blog
                    </a>
                    <?php endif; ?>
                    <?php if (canAccess('products') && !hasRole('viewer')): ?>
                    <a href="<?= SITE_URL ?>/admin/products/add" class="btn btn-warning fw-semibold px-4" style="border-radius:10px;background:#f5c518;border:none;color:#1a1a1a;">
                        <i class="fa fa-plus me-2"></i>Add Product
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ── Row 1: Product Stat Cards ── -->
            <p class="text-muted fw-semibold mb-2" style="font-size:.75rem;letter-spacing:.08em;text-transform:uppercase;">
                <i class="fa fa-box me-1"></i> Products Overview
            </p>
            <div class="row g-3 mb-4">

                <!-- Total Products -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#fffbeb;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-box" style="color:#f5c518;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#fffbeb;color:#d4a017;font-size:.72rem;font-weight:600;">
                                    <?= $activeProducts ?> active
                                </span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= $totalProducts ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">Total Products</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:<?= $totalProducts > 0 ? round(($activeProducts/$totalProducts)*100) : 0 ?>%;background:#f5c518;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;"><?= $totalProducts > 0 ? round(($activeProducts/$totalProducts)*100) : 0 ?>% active</p>
                        </div>
                    </div>
                </div>

                <!-- In Stock -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#f0fdf4;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-check-circle" style="color:#22c55e;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#f0fdf4;color:#16a34a;font-size:.72rem;font-weight:600;">in stock</span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= $inStock ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">In Stock</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:<?= $activeProducts > 0 ? round(($inStock/$activeProducts)*100) : 0 ?>%;background:#22c55e;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;"><?= $outOfStock ?> out of stock</p>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#eff6ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-tags" style="color:#3b82f6;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#eff6ff;color:#1d4ed8;font-size:.72rem;font-weight:600;">categories</span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= count($catStats) ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">Product Categories</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:100%;background:#3b82f6;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;">across all products</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Users -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#fdf4ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-users" style="color:#a855f7;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#fdf4ff;color:#7e22ce;font-size:.72rem;font-weight:600;"><?= $activeUsers ?> active</span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= $totalUsers ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">Admin Users</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:<?= $totalUsers > 0 ? round(($activeUsers/$totalUsers)*100) : 0 ?>%;background:#a855f7;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;"><?= $totalUsers > 0 ? round(($activeUsers/$totalUsers)*100) : 0 ?>% active</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── Row 2: Blog Stat Cards ── -->
            <?php if (canAccess('blogs')): ?>
            <p class="text-muted fw-semibold mb-2" style="font-size:.75rem;letter-spacing:.08em;text-transform:uppercase;">
                <i class="fa fa-file-alt me-1"></i> Blogs Overview
            </p>
            <div class="row g-3 mb-4">

                <!-- Total Blogs -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#f0f9ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-file-alt" style="color:#0ea5e9;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#f0f9ff;color:#0369a1;font-size:.72rem;font-weight:600;">
                                    <?= $publishedBlogs ?> published
                                </span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= $totalBlogs ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">Total Blogs</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:<?= $totalBlogs > 0 ? round(($publishedBlogs/$totalBlogs)*100) : 0 ?>%;background:#0ea5e9;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;"><?= $draftBlogs ?> drafts</p>
                        </div>
                    </div>
                </div>

                <!-- Published -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#f0fdf4;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-check-circle" style="color:#22c55e;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#f0fdf4;color:#16a34a;font-size:.72rem;font-weight:600;">live</span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= $publishedBlogs ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">Published</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:<?= $totalBlogs > 0 ? round(($publishedBlogs/$totalBlogs)*100) : 0 ?>%;background:#22c55e;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;"><?= $draftBlogs ?> unpublished</p>
                        </div>
                    </div>
                </div>

                <!-- Total Views -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#fff7ed;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-eye" style="color:#f97316;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#fff7ed;color:#c2410c;font-size:.72rem;font-weight:600;">all time</span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= number_format($totalViews) ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">Total Views</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:100%;background:#f97316;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;">across all blogs</p>
                        </div>
                    </div>
                </div>

                <!-- Blog Categories -->
                <div class="col-xl-3 col-sm-6">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div style="width:48px;height:48px;background:#fdf4ff;border-radius:12px;display:flex;align-items:center;justify-content:center;">
                                    <i class="fa fa-layer-group" style="color:#a855f7;font-size:1.2rem;"></i>
                                </div>
                                <span class="badge rounded-pill" style="background:#fdf4ff;color:#7e22ce;font-size:.72rem;font-weight:600;">categories</span>
                            </div>
                            <h2 class="fw-bold mb-1" style="font-size:2rem;color:#1a1a1a;"><?= count($blogCatStats) ?></h2>
                            <p class="text-muted mb-2" style="font-size:.82rem;">Blog Categories</p>
                            <div class="progress" style="height:4px;border-radius:4px;background:#f0f0f0;">
                                <div class="progress-bar" style="width:100%;background:#a855f7;border-radius:4px;"></div>
                            </div>
                            <p class="text-muted mt-1 mb-0" style="font-size:.72rem;">across all blogs</p>
                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>

            <!-- ── Row 3: Recent Products + Category Breakdown ── -->
            <div class="row g-3 mb-4">

                <!-- Recent Products Table -->
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3 d-flex align-items-center justify-content-between" style="border-radius:14px 14px 0 0;">
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">Recent Products</h5>
                                <p class="text-muted mb-0" style="font-size:.78rem;">Latest added products</p>
                            </div>
                            <a href="<?= SITE_URL ?>/admin/products/" class="btn btn-sm fw-semibold" style="background:#fffbeb;color:#d4a017;border:1px solid #fcd34d;border-radius:8px;font-size:.8rem;">
                                View All <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" style="font-size:.85rem;">
                                    <thead style="background:#f8f9fa;">
                                        <tr>
                                            <th class="px-4 py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Product</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Category</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">MOQ</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Rating</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Stock</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentProducts)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5">
                                                <i class="fa fa-box-open fa-2x mb-2 d-block" style="color:#e5e7eb;"></i>
                                                No products found.
                                            </td>
                                        </tr>
                                        <?php else: foreach ($recentProducts as $p):
                                            $imgUrl = !empty($p['image'])
                                                ? SITE_URL . '/' . ltrim($p['image'], '/')
                                                : SITE_URL . '/assets/img/all-images/service/service-img13.png';
                                            $badgeColors = [
                                                'new'  => ['#eff6ff','#1d4ed8'],
                                                'hot'  => ['#fef2f2','#dc2626'],
                                                'best' => ['#fffbeb','#d4a017'],
                                                'sale' => ['#f0fdf4','#16a34a'],
                                            ];
                                            $bc = $badgeColors[$p['badge_type']] ?? ['#f3f4f6','#6b7280'];
                                        ?>
                                        <tr>
                                            <td class="px-4 py-3" style="border:none;">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="<?= htmlspecialchars($imgUrl) ?>"
                                                         alt="<?= htmlspecialchars($p['name']) ?>"
                                                         onerror="this.src='<?= SITE_URL ?>/assets/img/all-images/service/service-img13.png'"
                                                         style="width:44px;height:44px;object-fit:cover;border-radius:10px;border:1px solid #f0f0f0;">
                                                    <div>
                                                        <div class="fw-semibold text-dark" style="font-size:.85rem;line-height:1.3;">
                                                            <?= htmlspecialchars(mb_strimwidth($p['name'], 0, 32, '…')) ?>
                                                        </div>
                                                        <?php if (!empty($p['badge'])): ?>
                                                        <span style="font-size:.65rem;font-weight:700;background:<?= $bc[0] ?>;color:<?= $bc[1] ?>;padding:2px 7px;border-radius:20px;">
                                                            <?= htmlspecialchars($p['badge']) ?>
                                                        </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <span style="font-size:.75rem;background:#f3f4f6;color:#374151;padding:3px 10px;border-radius:20px;font-weight:500;">
                                                    <?= ucfirst(htmlspecialchars($p['category'])) ?>
                                                </span>
                                            </td>
                                            <td class="py-3 text-muted" style="border:none;font-size:.82rem;"><?= htmlspecialchars($p['moq']) ?></td>
                                            <td class="py-3" style="border:none;">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="fa fa-star" style="color:#f5c518;font-size:.75rem;"></i>
                                                    <span style="font-size:.82rem;font-weight:600;"><?= number_format($p['rating'], 1) ?></span>
                                                    <span class="text-muted" style="font-size:.72rem;">(<?= $p['reviews'] ?>)</span>
                                                </div>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <?php if ($p['in_stock']): ?>
                                                <span style="font-size:.72rem;background:#f0fdf4;color:#16a34a;padding:3px 8px;border-radius:20px;font-weight:600;">
                                                    <i class="fa fa-circle me-1" style="font-size:.45rem;"></i>In Stock
                                                </span>
                                                <?php else: ?>
                                                <span style="font-size:.72rem;background:#fef2f2;color:#dc2626;padding:3px 8px;border-radius:20px;font-weight:600;">
                                                    <i class="fa fa-circle me-1" style="font-size:.45rem;"></i>Out
                                                </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <?php if ($p['is_active']): ?>
                                                <span style="font-size:.72rem;background:#fffbeb;color:#d4a017;padding:3px 8px;border-radius:20px;font-weight:600;">Active</span>
                                                <?php else: ?>
                                                <span style="font-size:.72rem;background:#f3f4f6;color:#6b7280;padding:3px 8px;border-radius:20px;font-weight:600;">Inactive</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category Breakdown -->
                <div class="col-xl-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-radius:14px 14px 0 0;">
                            <h5 class="fw-bold mb-0 text-dark">By Category</h5>
                            <p class="text-muted mb-0" style="font-size:.78rem;">Active products per category</p>
                        </div>
                        <div class="card-body px-4">
                            <?php
                            $catColors = ['#f5c518','#3b82f6','#22c55e','#a855f7','#ef4444','#f97316','#06b6d4'];
                            $maxCat = max(array_column($catStats,'total') ?: [1]);
                            foreach ($catStats as $ci => $cat):
                                $pct = $maxCat > 0 ? round(($cat['total']/$maxCat)*100) : 0;
                                $col = $catColors[$ci % count($catColors)];
                            ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span style="font-size:.83rem;font-weight:600;color:#1a1a1a;">
                                        <?= ucfirst(htmlspecialchars($cat['category'])) ?>
                                    </span>
                                    <span style="font-size:.75rem;color:#6b7280;font-weight:500;">
                                        <?= $cat['total'] ?> product<?= $cat['total'] != 1 ? 's' : '' ?>
                                    </span>
                                </div>
                                <div style="height:6px;background:#f0f0f0;border-radius:4px;overflow:hidden;">
                                    <div style="width:<?= $pct ?>%;height:100%;background:<?= $col ?>;border-radius:4px;transition:width .6s;"></div>
                                </div>
                            </div>
                            <?php endforeach;
                            if (empty($catStats)): ?>
                            <p class="text-muted text-center py-4" style="font-size:.85rem;">No categories found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ── Row 4: Recent Blogs + Blog Categories ── -->
            <?php if (canAccess('blogs')): ?>
            <div class="row g-3 mb-4">

                <!-- Recent Blogs Table -->
                <div class="col-xl-8">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3 d-flex align-items-center justify-content-between" style="border-radius:14px 14px 0 0;">
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">Recent Blogs</h5>
                                <p class="text-muted mb-0" style="font-size:.78rem;">Latest added articles</p>
                            </div>
                            <a href="<?= SITE_URL ?>/admin/blogs/" class="btn btn-sm fw-semibold" style="background:#f0f9ff;color:#0369a1;border:1px solid #bae6fd;border-radius:8px;font-size:.8rem;">
                                View All <i class="fa fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" style="font-size:.85rem;">
                                    <thead style="background:#f8f9fa;">
                                        <tr>
                                            <th class="px-4 py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Blog</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Category</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Views</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Read Time</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Published</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($recentBlogs)): ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-5">
                                                <i class="fa fa-newspaper fa-2x mb-2 d-block" style="color:#e5e7eb;"></i>
                                                No blogs found.
                                            </td>
                                        </tr>
                                        <?php else: foreach ($recentBlogs as $b):
                                            $bImgUrl = !empty($b['image'])
                                                ? SITE_URL . '/' . ltrim($b['image'], '/')
                                                : SITE_URL . '/assets/img/blog/blog-placeholder.jpg';
                                        ?>
                                        <tr>
                                            <td class="px-4 py-3" style="border:none;">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="<?= htmlspecialchars($bImgUrl) ?>"
                                                         alt="<?= htmlspecialchars($b['title']) ?>"
                                                         onerror="this.src='<?= SITE_URL ?>/assets/img/blog/blog-placeholder.jpg'"
                                                         style="width:44px;height:44px;object-fit:cover;border-radius:10px;border:1px solid #f0f0f0;">
                                                    <div>
                                                        <div class="fw-semibold text-dark" style="font-size:.85rem;line-height:1.3;">
                                                            <?= htmlspecialchars(mb_strimwidth($b['title'], 0, 36, '…')) ?>
                                                        </div>
                                                        <div class="text-muted" style="font-size:.72rem;">
                                                            <?= date('d M Y', strtotime($b['created_at'])) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <span style="font-size:.75rem;background:#f0f9ff;color:#0369a1;padding:3px 10px;border-radius:20px;font-weight:500;">
                                                    <?= htmlspecialchars($b['cat_name'] ?? 'General') ?>
                                                </span>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <div class="d-flex align-items-center gap-1">
                                                    <i class="fa fa-eye" style="color:#f97316;font-size:.75rem;"></i>
                                                    <span style="font-size:.82rem;font-weight:600;"><?= number_format($b['views']) ?></span>
                                                </div>
                                            </td>
                                            <td class="py-3 text-muted" style="border:none;font-size:.82rem;">
                                                <i class="fa fa-clock me-1" style="color:#9ca3af;"></i><?= $b['reading_time'] ?> min
                                            </td>
                                            <td class="py-3 text-muted" style="border:none;font-size:.78rem;">
                                                <?= $b['published_at'] ? date('d M Y', strtotime($b['published_at'])) : '—' ?>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <?php if ($b['is_published']): ?>
                                                <span style="font-size:.72rem;background:#f0fdf4;color:#16a34a;padding:3px 8px;border-radius:20px;font-weight:600;">
                                                    <i class="fa fa-circle me-1" style="font-size:.45rem;"></i>Published
                                                </span>
                                                <?php else: ?>
                                                <span style="font-size:.72rem;background:#f3f4f6;color:#6b7280;padding:3px 8px;border-radius:20px;font-weight:600;">
                                                    <i class="fa fa-circle me-1" style="font-size:.45rem;"></i>Draft
                                                </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Category Breakdown -->
                <div class="col-xl-4">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-radius:14px 14px 0 0;">
                            <h5 class="fw-bold mb-0 text-dark">Blog Categories</h5>
                            <p class="text-muted mb-0" style="font-size:.78rem;">Published blogs per category</p>
                        </div>
                        <div class="card-body px-4">
                            <?php
                            $blogCatColors = ['#0ea5e9','#a855f7','#22c55e','#f97316','#ef4444','#f5c518','#06b6d4'];
                            $maxBlogCat = max(array_column($blogCatStats,'total') ?: [1]);
                            foreach ($blogCatStats as $bi => $bcat):
                                $bpct = $maxBlogCat > 0 ? round(($bcat['total']/$maxBlogCat)*100) : 0;
                                $bcol = $blogCatColors[$bi % count($blogCatColors)];
                            ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span style="font-size:.83rem;font-weight:600;color:#1a1a1a;">
                                        <?= htmlspecialchars($bcat['name']) ?>
                                    </span>
                                    <span style="font-size:.75rem;color:#6b7280;font-weight:500;">
                                        <?= $bcat['total'] ?> blog<?= $bcat['total'] != 1 ? 's' : '' ?>
                                    </span>
                                </div>
                                <div style="height:6px;background:#f0f0f0;border-radius:4px;overflow:hidden;">
                                    <div style="width:<?= $bpct ?>%;height:100%;background:<?= $bcol ?>;border-radius:4px;transition:width .6s;"></div>
                                </div>
                            </div>
                            <?php endforeach;
                            if (empty($blogCatStats)): ?>
                            <p class="text-muted text-center py-4" style="font-size:.85rem;">No blog categories found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>

            <!-- ── Row 5: Activity Log + Admin Users ── -->
            <div class="row g-3">

                <!-- Recent Activity -->
                <div class="col-xl-5">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3" style="border-radius:14px 14px 0 0;">
                            <h5 class="fw-bold mb-0 text-dark">Recent Activity</h5>
                            <p class="text-muted mb-0" style="font-size:.78rem;">Latest admin actions</p>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($activityLog)): ?>
                            <p class="text-muted text-center py-5" style="font-size:.85rem;">No activity yet.</p>
                            <?php else:
                            $actionColors = [
                                'login'           => ['#f0fdf4','#16a34a'],
                                'logout'          => ['#f3f4f6','#6b7280'],
                                'user_created'    => ['#eff6ff','#1d4ed8'],
                                'user_updated'    => ['#eff6ff','#1d4ed8'],
                                'product_created' => ['#fffbeb','#d4a017'],
                                'product_updated' => ['#fffbeb','#d4a017'],
                                'blog_created'    => ['#f0f9ff','#0369a1'],
                                'blog_updated'    => ['#f0f9ff','#0369a1'],
                                'blog_deleted'    => ['#fef2f2','#dc2626'],
                            ];
                            foreach ($activityLog as $log):
                                $ac = $actionColors[$log['action']] ?? ['#f3f4f6','#374151'];
                            ?>
                            <div class="d-flex align-items-start gap-3 px-4 py-3" style="border-bottom:1px solid #f8f9fa;">
                                <span style="font-size:.68rem;font-weight:700;background:<?= $ac[0] ?>;color:<?= $ac[1] ?>;padding:3px 8px;border-radius:20px;white-space:nowrap;margin-top:2px;">
                                    <?= htmlspecialchars(str_replace('_', ' ', $log['action'])) ?>
                                </span>
                                <div style="min-width:0;">
                                    <div style="font-size:.82rem;color:#1a1a1a;font-weight:500;line-height:1.3;">
                                        <?= htmlspecialchars(mb_strimwidth($log['detail'] ?? '', 0, 50, '…')) ?>
                                    </div>
                                    <div style="font-size:.72rem;color:#9ca3af;margin-top:2px;">
                                        <?= htmlspecialchars($log['user_name'] ?? 'System') ?>
                                        &nbsp;·&nbsp;<?= date('d M, H:i', strtotime($log['created_at'])) ?>
                                        <?php if (!empty($log['ip'])): ?>
                                        &nbsp;·&nbsp;<span style="font-family:monospace;"><?= htmlspecialchars($log['ip']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Admin Users -->
                <div class="col-xl-7">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:14px;">
                        <div class="card-header bg-white border-0 px-4 pt-4 pb-3 d-flex align-items-center justify-content-between" style="border-radius:14px 14px 0 0;">
                            <div>
                                <h5 class="fw-bold mb-0 text-dark">Admin Users</h5>
                                <p class="text-muted mb-0" style="font-size:.78rem;"><?= $totalUsers ?> total, <?= $activeUsers ?> active</p>
                            </div>
                            <?php if (canAccess('users') && hasRole(['superadmin','admin'])): ?>
                            <a href="<?= SITE_URL ?>/admin/users/add" class="btn btn-sm fw-semibold" style="background:#fffbeb;color:#d4a017;border:1px solid #fcd34d;border-radius:8px;font-size:.8rem;">
                                + Add User
                            </a>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" style="font-size:.84rem;">
                                    <thead style="background:#f8f9fa;">
                                        <tr>
                                            <th class="px-4 py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Name</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Role</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Logins</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Last Login</th>
                                            <th class="py-3 text-muted fw-semibold" style="font-size:.72rem;letter-spacing:.05em;text-transform:uppercase;border:none;">Status</th>
                                            <th class="py-3" style="border:none;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($adminUsers)): ?>
                                        <tr><td colspan="6" class="text-center text-muted py-5">No users found.</td></tr>
                                        <?php else:
                                        $roleBadge = [
                                            'superadmin' => ['#fef2f2','#dc2626'],
                                            'admin'      => ['#fffbeb','#d4a017'],
                                            'editor'     => ['#eff6ff','#1d4ed8'],
                                            'viewer'     => ['#f3f4f6','#6b7280'],
                                        ];
                                        foreach ($adminUsers as $u):
                                            $rb = $roleBadge[$u['role']] ?? ['#f3f4f6','#6b7280'];
                                        ?>
                                        <tr>
                                            <td class="px-4 py-3" style="border:none;">
                                                <div class="fw-semibold text-dark" style="font-size:.85rem;"><?= htmlspecialchars($u['name']) ?></div>
                                                <div class="text-muted" style="font-size:.72rem;"><?= htmlspecialchars($u['email']) ?></div>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <span style="font-size:.72rem;font-weight:700;background:<?= $rb[0] ?>;color:<?= $rb[1] ?>;padding:3px 10px;border-radius:20px;">
                                                    <?= ucfirst(htmlspecialchars($u['role'])) ?>
                                                </span>
                                            </td>
                                            <td class="py-3 text-muted" style="border:none;font-size:.82rem;"><?= number_format($u['login_count']) ?></td>
                                            <td class="py-3 text-muted" style="border:none;font-size:.78rem;">
                                                <?= $u['last_login'] ? date('d M, H:i', strtotime($u['last_login'])) : '<span class="text-muted">Never</span>' ?>
                                            </td>
                                            <td class="py-3" style="border:none;">
                                                <?= $u['status']
                                                    ? '<span style="font-size:.72rem;background:#f0fdf4;color:#16a34a;padding:3px 8px;border-radius:20px;font-weight:600;">Active</span>'
                                                    : '<span style="font-size:.72rem;background:#fef2f2;color:#dc2626;padding:3px 8px;border-radius:20px;font-weight:600;">Inactive</span>' ?>
                                            </td>
                                            <td class="py-3 pe-4" style="border:none;">
                                                <?php if (canAccess('users')): ?>
                                                <a href="<?= SITE_URL ?>/admin/users/edit?id=<?= $u['id'] ?>" class="btn btn-sm" style="background:#f8f9fa;border:1px solid #e5e7eb;border-radius:8px;padding:4px 10px;">
                                                    <i class="fa fa-pencil" style="color:#6b7280;font-size:.75rem;"></i>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

<?php require_once __DIR__ . '/include/footer.php'; ?>