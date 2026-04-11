<?php
// admin/products/index.php
require_once __DIR__ . '/../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
requireAccess('products');

$limit  = 10;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search     = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchLike = '%' . $conn->real_escape_string($search) . '%';

// ── Delete ───────────────────────────────────────────────────
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $deleteId");
    header("Location: ./?msg=deleted");
    exit;
}

// ── Toggle Active ─────────────────────────────────────────────
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $toggleId = (int)$_GET['toggle'];
    $conn->query("UPDATE products SET is_active = NOT is_active WHERE id = $toggleId");
    header("Location: ./");
    exit;
}

// ── Fetch Products ─────────────────────────────────────────────
$sql = "SELECT * FROM products
        WHERE name LIKE '$searchLike'
           OR category LIKE '$searchLike'
           OR brand LIKE '$searchLike'
           OR sku LIKE '$searchLike'
           OR tags LIKE '$searchLike'
        ORDER BY created_at DESC
        LIMIT $limit OFFSET $offset";

$result   = $conn->query($sql);
$products = [];
if ($result) { while ($row = $result->fetch_assoc()) { $products[] = $row; } }

$countResult  = $conn->query("SELECT COUNT(*) AS total FROM products
    WHERE name LIKE '$searchLike' OR category LIKE '$searchLike' OR brand LIKE '$searchLike' OR sku LIKE '$searchLike' OR tags LIKE '$searchLike'");
$totalRecords = $countResult ? (int)$countResult->fetch_assoc()['total'] : 0;
$totalPages   = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;

// ── Stats ─────────────────────────────────────────────────────
$statsRes = $conn->query("SELECT
    COUNT(*) as total,
    SUM(is_active) as active_count,
    SUM(!is_active) as inactive_count,
    SUM(in_stock) as in_stock_count,
    AVG(rating) as avg_rating,
    SUM(reviews) as total_reviews,
    COUNT(DISTINCT category) as total_categories
    FROM products");
$stats = $statsRes ? $statsRes->fetch_assoc() : [];

// ── Helpers ───────────────────────────────────────────────────
define('BASE_PATH', '/nirajindustries/');

function resolveImageSrc($field) {
    if (empty($field)) return '';
    if (str_starts_with($field, 'http://') || str_starts_with($field, 'https://')) return $field;
    return BASE_PATH . ltrim($field, '/');
}

function calcProductSeoScore($prod) {
    $score = 0; $issues = []; $good = [];

    // Name (acts as title)
    $name = $prod['name'] ?? '';
    if (strlen($name) >= 30 && strlen($name) <= 70) { $score += 10; $good[] = 'Product name ideal length'; }
    elseif (strlen($name) > 0)                      { $score += 5;  $issues[] = 'Product name length not ideal (30–70 chars)'; }
    else                                             { $issues[] = 'Product name missing'; }

    // Description (short)
    $desc = $prod['description'] ?? '';
    if (strlen($desc) >= 80 && strlen($desc) <= 200) { $score += 10; $good[] = 'Short description perfect'; }
    elseif (strlen($desc) > 0)                       { $score += 5;  $issues[] = 'Short description not ideal (80–200 chars)'; }
    else                                              { $issues[] = 'Short description missing'; }

    // Full description
    if (!empty($prod['full_description']) && strlen($prod['full_description']) >= 200) { $score += 10; $good[] = 'Full description filled'; }
    else { $issues[] = 'Full description missing or too short'; }

    // Slug
    $slug = $prod['slug'] ?? '';
    if (!empty($slug)) { $score += 5; $good[] = 'URL slug set'; }
    else               { $issues[] = 'URL slug missing'; }

    // Category
    if (!empty($prod['category'])) { $score += 5; $good[] = 'Category assigned'; }
    else { $issues[] = 'No category assigned'; }

    // Image
    if (!empty($prod['image']) && $prod['image'] !== 'default.jpg') { $score += 10; $good[] = 'Main product image uploaded'; }
    else { $issues[] = 'No main product image'; }

    // Tags
    if (!empty($prod['tags'])) { $score += 10; $good[] = 'Tags added'; }
    else { $issues[] = 'No tags added'; }

    // Brand
    if (!empty($prod['brand'])) { $score += 5; $good[] = 'Brand specified'; }
    else { $issues[] = 'Brand not set'; }

    // SKU
    if (!empty($prod['sku'])) { $score += 5; $good[] = 'SKU defined'; }
    else { $issues[] = 'SKU missing'; }

    // Specifications
    if (!empty($prod['specifications'])) { $score += 10; $good[] = 'Specifications added'; }
    else { $issues[] = 'No specifications'; }

    // Features
    if (!empty($prod['features'])) { $score += 5; $good[] = 'Features listed'; }
    else { $issues[] = 'Features not listed'; }

    // Applications
    if (!empty($prod['applications'])) { $score += 5; $good[] = 'Applications described'; }
    else { $issues[] = 'Applications not described'; }

    // Certifications (bonus)
    if (!empty($prod['certifications'])) { $score += 5; $good[] = 'Certifications added'; }
    else { $issues[] = 'No certifications listed'; }

    // Additional images (bonus)
    if (!empty($prod['image2']) || !empty($prod['image3'])) { $score += 5; $good[] = 'Multiple images uploaded'; }
    else { $issues[] = 'Only one image uploaded'; }

    return ['score' => min(100, $score), 'issues' => $issues, 'good' => $good];
}

function seoGrade($score) {
    if ($score >= 80) return ['A', 'text-warning'];
    if ($score >= 65) return ['B', 'text-primary'];
    if ($score >= 50) return ['C', 'text-info'];
    return ['F', 'text-danger'];
}

function rankPotential($score) {
    if ($score >= 80) return 'Top 10';
    if ($score >= 65) return 'Top 30';
    if ($score >= 50) return 'Top 50';
    return 'Low';
}

function getBadgeHtml($badge, $badgeType) {
    if (empty($badge)) return '';
    $colorMap = [
        'bestseller' => 'bg-warning text-dark',
        'new'        => 'bg-success text-white',
        'sale'       => 'bg-danger text-white',
        'featured'   => 'bg-primary text-white',
        'hot'        => 'bg-orange text-white',
    ];
    $key = strtolower($badgeType ?? $badge);
    $cls = $colorMap[$key] ?? 'bg-secondary text-white';
    return '<span class="badge ' . $cls . ' rounded-pill px-2 py-1 fw-semibold" style="font-size:0.65rem;">' . htmlspecialchars($badge) . '</span>';
}

// ── Page Setup ─────────────────────────────────────────────────
$pageTitle  = 'Manage Products';
$activePage = 'products-index';
$assetBase  = '../';

$extraCSS = '
<style>
    :root {
        --yellow-primary: #F5A623;
        --yellow-dark:    #E08E00;
        --yellow-light:   #FFF8E7;
        --yellow-subtle:  #FEF3CD;
        --yellow-border:  #FDDFA0;
    }

    body { background-color: #f9f5ee !important; }
    .page-wrapper { background-color: #f9f5ee !important; min-height: 100vh; }

    /* Stat Cards */
    .stat-card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card-hover:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(245,166,35,.15)!important; }

    /* Yellow accent icon circle */
    .icon-yellow {
        background-color: var(--yellow-subtle) !important;
        color: var(--yellow-primary) !important;
    }

    /* Table */
    .table-hover-soft tbody tr { transition: background-color 0.15s ease; }
    .table-hover-soft tbody tr:hover { background-color: var(--yellow-light) !important; }
    #productsTableBody td { white-space: normal !important; }

    /* Product thumb */
    .product-thumb {
        width: 56px; height: 56px; object-fit: cover;
        border-radius: 10px; flex-shrink: 0;
        border: 2px solid var(--yellow-border);
        background: #fff;
    }
    .product-thumb-placeholder {
        width: 56px; height: 56px; border-radius: 10px; flex-shrink: 0;
        background: var(--yellow-subtle); display: flex; align-items: center;
        justify-content: center; color: var(--yellow-primary); font-size: 1.4rem;
        border: 2px solid var(--yellow-border);
    }

    /* Loader */
    #tableLoader {
        display: none;
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,248,231,0.8);
        z-index: 10; align-items: center; justify-content: center;
        border-radius: 0 0 1rem 1rem;
    }
    #tableLoader.active { display: flex; }
    .table-wrapper { position: relative; min-height: 200px; }

    /* Search */
    .search-bar-wrap { position: relative; width: 340px; max-width: 100%; }
    #searchSpinner { display: none; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); }
    #searchSpinner.active { display: block; }

    /* Pagination */
    .page-link { transition: all 0.15s ease; }
    .pagination .page-item.active .page-link { 
        background-color: var(--yellow-primary) !important; 
        border-color: var(--yellow-primary) !important; 
        color: #fff !important; 
    }
    .page-link:hover { background-color: var(--yellow-subtle) !important; color: var(--yellow-dark) !important; }

    /* Card header accent */
    .card-header-accent { border-left: 4px solid var(--yellow-primary); }

    /* Add product btn */
    .btn-add-product {
        background: linear-gradient(135deg, var(--yellow-primary), var(--yellow-dark));
        border: none; color: #fff;
    }
    .btn-add-product:hover { 
        background: linear-gradient(135deg, var(--yellow-dark), #c07a00);
        color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(245,166,35,.4);
    }

    /* SEO circle */
    .seo-circle-wrap { cursor: pointer; }
    .seo-circle-wrap:hover { opacity: 0.85; }

    /* Stock badge */
    .stock-dot-green { background: #28a745; }
    .stock-dot-red   { background: #dc3545; }

    /* Breadcrumb */
    .breadcrumb-item a { color: var(--yellow-dark) !important; }

    /* Page title */
    .page-title-icon {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, var(--yellow-primary), var(--yellow-dark));
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 1.1rem;
    }
</style>
';

require_once '../include/head.php';
?>

<div class="main-wrapper">

    <?php require_once '../include/header.php'; ?>
    <?php require_once '../include/sidebar.php'; ?>

    <div class="page-wrapper">
        <div class="content container-fluid pt-4 pb-5">

            <!-- Page Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="page-title-icon shadow-sm">
                        <i class="fa fa-box-open"></i>
                    </div>
                    <div>
                        <h3 class="fw-bolder text-dark mb-1">Products Directory</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb small bg-transparent p-0 m-0">
                                <li class="breadcrumb-item"><a href="../" class="text-decoration-none fw-medium">Dashboard</a></li>
                                <li class="breadcrumb-item active text-secondary fw-medium">Products</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="add" class="btn btn-add-product rounded-pill px-4 py-2 shadow fw-semibold d-inline-flex align-items-center gap-2" style="transition:all .2s;">
                        <i class="fa fa-plus"></i> Add Product
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (isset($_GET['msg'])):
                $msgMap = [
                    'deleted' => ['danger',  'Product removed permanently.', 'fa-trash-alt'],
                    'added'   => ['success', 'New product added successfully.', 'fa-check-circle'],
                    'updated' => ['success', 'Product updated successfully.', 'fa-check-circle'],
                ];
                [$msgType, $msgText, $msgIcon] = $msgMap[$_GET['msg']] ?? ['success', 'Action completed.', 'fa-check'];
            ?>
            <div class="alert alert-<?= $msgType ?> border-0 shadow-sm alert-dismissible fade show d-flex align-items-center gap-3 rounded-3" role="alert">
                <i class="fa <?= $msgIcon ?> fs-4"></i>
                <div class="fw-medium"><?= htmlspecialchars($msgText) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5">

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Total Products</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['total'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= (int)($stats['active_count'] ?? 0) ?> active</p>
                            </div>
                            <div class="icon-yellow rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-boxes fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#fdedb0;">
                                <div class="progress-bar rounded-pill" style="background:var(--yellow-primary); width:<?= $stats['total'] > 0 ? round(($stats['active_count']/$stats['total'])*100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">In Stock</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['in_stock_count'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= (int)($stats['total'] ?? 0) - (int)($stats['in_stock_count'] ?? 0) ?> out of stock</p>
                            </div>
                            <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-check-circle fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#d4edda;">
                                <div class="progress-bar bg-success rounded-pill" style="width:<?= $stats['total'] > 0 ? round(($stats['in_stock_count']/$stats['total'])*100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Categories</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['total_categories'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1">across all products</p>
                            </div>
                            <div class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-tags fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#d1ecf1;">
                                <div class="progress-bar bg-info rounded-pill" style="width:100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Avg Rating</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= number_format((float)($stats['avg_rating'] ?? 0), 1) ?> <span class="fs-5 text-warning">★</span></h2>
                                <p class="small text-muted mb-0 mt-1"><?= number_format((int)($stats['total_reviews'] ?? 0)) ?> total reviews</p>
                            </div>
                            <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-star fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#fff3cd;">
                                <div class="progress-bar bg-warning rounded-pill" style="width:<?= min(100, round(((float)($stats['avg_rating'] ?? 0)/5)*100)) ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Table Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background:#fff;">

                <!-- Card Header -->
                <div class="card-header bg-white border-bottom py-4 px-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 card-header-accent">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="mb-0 fw-bold text-dark">All Products</h5>
                        <span id="totalBadge" class="badge rounded-pill px-3 py-1 fw-semibold border"
                            style="background:var(--yellow-subtle); color:var(--yellow-dark); border-color:var(--yellow-border) !important;">
                            <?= $totalRecords ?> products
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="search-bar-wrap">
                            <div class="input-group input-group-sm rounded-pill border p-1" style="background:var(--yellow-light); border-color:var(--yellow-border) !important;">
                                <span class="input-group-text bg-transparent border-0 ps-3" style="color:var(--yellow-dark);">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" id="searchInput"
                                    class="form-control border-0 shadow-none ps-1"
                                    style="background:transparent;"
                                    placeholder="Search by name, category, brand, SKU..."
                                    value="<?= htmlspecialchars($search) ?>" autocomplete="off">
                                <span id="searchSpinner">
                                    <span class="spinner-border spinner-border-sm" role="status" style="color:var(--yellow-primary);"></span>
                                </span>
                            </div>
                        </div>
                        <button id="clearSearchBtn" class="btn btn-sm rounded-pill px-3 fw-medium border"
                            style="background:var(--yellow-subtle); color:var(--yellow-dark); border-color:var(--yellow-border); display:<?= $search ? 'inline-block' : 'none' ?>;">
                            <i class="fa fa-times me-1"></i>Clear
                        </button>
                    </div>
                </div>

                <!-- Table Wrapper -->
                <div class="table-wrapper">
                    <div id="tableLoader">
                        <div class="d-flex flex-column align-items-center gap-2">
                            <div class="spinner-border" role="status" style="width:2rem;height:2rem;color:var(--yellow-primary);"></div>
                            <span class="small fw-medium" style="color:var(--yellow-dark);">Loading…</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover-soft table-borderless align-middle mb-0">
                            <thead style="background:var(--yellow-light);">
                                <tr class="text-uppercase text-muted" style="font-size:0.72rem;letter-spacing:0.5px;">
                                    <th class="ps-4 py-3 fw-bold">Product</th>
                                    <th class="py-3 fw-bold">Category / Brand</th>
                                    <th class="py-3 fw-bold text-center">SEO Health</th>
                                    <th class="py-3 fw-bold">Rating &amp; Reviews</th>
                                    <th class="py-3 fw-bold">Stock / Status</th>
                                    <th class="py-3 fw-bold text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-5">
                                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width:80px;height:80px;background:var(--yellow-subtle);">
                                                <i class="fa fa-box-open fs-1" style="color:var(--yellow-primary); opacity:0.6;"></i>
                                            </div>
                                            <h5 class="text-dark fw-bold">No products found</h5>
                                            <p class="text-muted mb-4">Add your first product to get started.</p>
                                            <a href="add" class="btn btn-add-product rounded-pill px-4 shadow-sm fw-semibold">
                                                <i class="fa fa-plus me-2"></i>Add Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($products as $prod):
                                    $seo     = calcProductSeoScore($prod);
                                    $score   = $seo['score'];
                                    [$grade, $gradeTextColor] = seoGrade($score);
                                    $issueCount   = count($seo['issues']);
                                    $gradeBgClass = str_replace('text-', 'bg-', $gradeTextColor);
                                    $imgSrc       = resolveImageSrc($prod['image'] ?? '');
                                    $rating       = (float)($prod['rating'] ?? 0);
                                    $reviews      = (int)($prod['reviews'] ?? 0);
                                    $inStock      = (bool)($prod['in_stock'] ?? 0);
                                    $isActive     = (bool)($prod['is_active'] ?? 0);
                                ?>
                                <tr class="border-bottom border-light">

                                    <!-- Product Name & Image -->
                                    <td class="ps-4 py-3" style="max-width:270px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (!empty($imgSrc) && $prod['image'] !== 'default.jpg'): ?>
                                            <img src="<?= htmlspecialchars($imgSrc) ?>"
                                                class="product-thumb shadow-sm"
                                                alt="<?= htmlspecialchars($prod['name']) ?>"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="product-thumb-placeholder" style="display:none;"><i class="fa fa-image"></i></div>
                                            <?php else: ?>
                                            <div class="product-thumb-placeholder"><i class="fa fa-image"></i></div>
                                            <?php endif; ?>

                                            <div style="min-width:0; max-width:190px;">
                                                <h6 class="mb-1 fw-bold text-dark" style="word-break:break-word; white-space:normal; line-height:1.3;"
                                                    title="<?= htmlspecialchars($prod['name']) ?>">
                                                    <?= htmlspecialchars($prod['name']) ?>
                                                </h6>
                                                <?php if (!empty($prod['badge'])): ?>
                                                <div class="mb-1">
                                                    <?= getBadgeHtml($prod['badge'], $prod['badge_type'] ?? '') ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($prod['sku'])): ?>
                                                <div class="small text-muted" style="font-size:0.72rem;">
                                                    <i class="fa fa-barcode me-1"></i>SKU: <?= htmlspecialchars($prod['sku']) ?>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (!empty($prod['moq'])): ?>
                                                <div class="small text-muted" style="font-size:0.72rem;">
                                                    <i class="fa fa-cubes me-1" style="color:var(--yellow-primary);"></i>MOQ: <?= htmlspecialchars($prod['moq']) ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category / Brand -->
                                    <td class="py-3">
                                        <?php if (!empty($prod['category'])): ?>
                                        <span class="badge rounded-pill px-3 py-2 fw-medium border d-inline-block mb-1"
                                            style="background:var(--yellow-subtle); color:var(--yellow-dark); border-color:var(--yellow-border); font-size:0.78rem;">
                                            <i class="fa fa-tag me-1"></i><?= htmlspecialchars($prod['category']) ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted small fst-italic">No category</span>
                                        <?php endif; ?>
                                        <?php if (!empty($prod['brand'])): ?>
                                        <div class="small text-muted mt-1" style="font-size:0.75rem;">
                                            <i class="fa fa-building me-1"></i><?= htmlspecialchars($prod['brand']) ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php if (!empty($prod['country_of_origin'])): ?>
                                        <div class="small text-muted" style="font-size:0.72rem;">
                                            <i class="fa fa-globe me-1 text-info"></i><?= htmlspecialchars($prod['country_of_origin']) ?>
                                        </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- SEO Health -->
                                    <td class="py-3 text-center">
                                        <div class="d-inline-flex align-items-center gap-3 seo-circle-wrap"
                                            onclick="openSeoModal(<?= $prod['id'] ?>)"
                                            data-bs-toggle="tooltip" title="Click for SEO details">
                                            <div class="position-relative" style="width:44px;height:44px;">
                                                <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#fdedb0" stroke-width="3"></circle>
                                                    <circle cx="18" cy="18" r="15.9" fill="none" class="<?= $gradeTextColor ?>"
                                                        stroke="currentColor" stroke-width="3"
                                                        stroke-dasharray="100 100"
                                                        stroke-dashoffset="<?= 100 - $score ?>"
                                                        stroke-linecap="round"
                                                        style="transition:stroke-dashoffset 1s ease-out;"></circle>
                                                </svg>
                                                <div class="position-absolute top-50 start-50 translate-middle fw-bold <?= $gradeTextColor ?>" style="font-size:0.78rem;"><?= $score ?></div>
                                            </div>
                                            <div class="d-flex flex-column align-items-start">
                                                <span class="badge <?= $gradeBgClass ?> text-white rounded-pill px-2 py-1 fw-bold mb-1" style="font-size:0.72rem;">Grade <?= $grade ?></span>
                                                <span class="badge rounded-pill fw-semibold <?= $issueCount === 0 ? 'bg-success-subtle text-success-emphasis' : '' ?>"
                                                    style="<?= $issueCount > 0 ? 'background:var(--yellow-subtle); color:var(--yellow-dark);' : '' ?>; font-size:0.7rem;">
                                                    <?php if ($issueCount === 0): ?>
                                                    <i class="fa fa-check me-1"></i>Perfect
                                                    <?php else: ?>
                                                    <i class="fa fa-exclamation-triangle me-1"></i><?= $issueCount ?> Issues
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Rating & Reviews -->
                                    <td class="py-3" style="min-width:140px;">
                                        <div class="d-flex align-items-center gap-1 mb-1">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fa fa-star" style="font-size:0.75rem; color:<?= $i <= round($rating) ? 'var(--yellow-primary)' : '#dee2e6' ?>;"></i>
                                            <?php endfor; ?>
                                            <span class="small fw-bold text-dark ms-1"><?= number_format($rating, 1) ?></span>
                                        </div>
                                        <div class="small text-muted">
                                            <i class="fa fa-comment me-1" style="color:var(--yellow-primary);"></i><?= number_format($reviews) ?> reviews
                                        </div>
                                        <?php if (!empty($prod['availability'])): ?>
                                        <div class="small text-muted mt-1" style="font-size:0.72rem;">
                                            <i class="fa fa-clock me-1 text-info"></i><?= htmlspecialchars($prod['availability']) ?>
                                        </div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Stock / Status -->
                                    <td class="py-3">
                                        <!-- Stock -->
                                        <div class="mb-2">
                                            <?php if ($inStock): ?>
                                            <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle rounded-pill py-1 px-2 fw-semibold" style="font-size:0.72rem;">
                                                <span class="d-inline-block bg-success rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>In Stock
                                            </span>
                                            <?php else: ?>
                                            <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle rounded-pill py-1 px-2 fw-semibold" style="font-size:0.72rem;">
                                                <span class="d-inline-block bg-danger rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>Out of Stock
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        <!-- Active Toggle -->
                                        <a href="./?toggle=<?= $prod['id'] ?>" class="text-decoration-none">
                                            <?php if ($isActive): ?>
                                            <span class="badge rounded-pill py-1 px-2 fw-semibold border" style="background:var(--yellow-subtle); color:var(--yellow-dark); border-color:var(--yellow-border); font-size:0.72rem;">
                                                <span class="d-inline-block rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;background:var(--yellow-primary);"></span>Active
                                            </span>
                                            <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle rounded-pill py-1 px-2 fw-semibold" style="font-size:0.72rem;">
                                                <span class="d-inline-block bg-secondary rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>Inactive
                                            </span>
                                            <?php endif; ?>
                                        </a>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-end pe-4">
                                        <div class="btn-group shadow-sm border rounded-pill overflow-hidden bg-white">
                                            <a href="<?= SITE_URL ?>/products/<?= htmlspecialchars($prod['slug'] ?? '') ?>"
                                                target="_blank"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-secondary"
                                                data-bs-toggle="tooltip" title="View Product">
                                                <i class="fa fa-external-link-alt"></i>
                                            </a>
                                            <div class="border-start border-light"></div>
                                            <a href="edit?id=<?= $prod['id'] ?>"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-secondary"
                                                data-bs-toggle="tooltip" title="Edit Product">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <div class="border-start border-light"></div>
                                            <a href="./?delete=<?= $prod['id'] ?>"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-danger"
                                                onclick="return confirm('Permanently delete \"<?= addslashes(htmlspecialchars($prod['name'])) ?>\"? This cannot be undone.')"
                                                data-bs-toggle="tooltip" title="Delete Product">
                                                <i class="fa fa-trash-alt"></i>
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /table-wrapper -->

                <!-- Pagination Footer -->
                <div id="paginationFooter"
                    class="card-footer bg-white border-top py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3"
                    style="display: <?= $totalPages > 1 ? 'flex' : 'none' ?> !important;">
                    <div class="small text-muted fw-medium" id="entriesInfo">
                        Showing <span class="text-dark fw-bold" id="entryFrom"><?= $offset + 1 ?></span>
                        to <span class="text-dark fw-bold" id="entryTo"><?= min($offset + $limit, $totalRecords) ?></span>
                        of <span id="entryTotal"><?= $totalRecords ?></span> products
                    </div>
                    <nav aria-label="Table navigation">
                        <ul class="pagination pagination-sm mb-0" id="paginationList"></ul>
                    </nav>
                </div>

            </div><!-- /card -->

        </div>
    </div>
</div>

<!-- SEO Modal -->
<div class="modal fade" id="seoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4 overflow-hidden">
            <div class="modal-header border-bottom py-3 px-4" style="background:var(--yellow-light); border-color:var(--yellow-border) !important;">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-center rounded" style="width:32px;height:32px;background:var(--yellow-primary);">
                        <i class="fa fa-chart-line text-white" style="font-size:0.85rem;"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="modalTitle">SEO Analysis</h5>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 bg-white" id="modalBody"></div>
        </div>
    </div>
</div>

<?php
// Build SEO data for JS
$initialSeoData = [];
foreach ($products as $prod) {
    $seo   = calcProductSeoScore($prod);
    $score = $seo['score'];
    [$grade, $gradeTextColor] = seoGrade($score);
    $ratingBase = (float)($prod['rating'] ?? 0);
    $reviewBase = (int)($prod['reviews'] ?? 0);
    $initialSeoData[$prod['id']] = [
        'name'           => $prod['name'],
        'score'          => (int)$score,
        'grade'          => $grade,
        'gradeTextClass' => $gradeTextColor,
        'issues'         => $seo['issues'],
        'good'           => $seo['good'],
        'rating'         => $ratingBase,
        'reviews'        => $reviewBase,
        'rank'           => rankPotential($score),
        'category'       => $prod['category'] ?? '',
        'brand'          => $prod['brand'] ?? '',
        'sku'            => $prod['sku'] ?? '',
        'slug'           => $prod['slug'] ?? '',
        'tags'           => $prod['tags'] ?? '',
        'moq'            => $prod['moq'] ?? '',
        'warranty'       => $prod['warranty'] ?? '',
        'certifications' => $prod['certifications'] ?? '',
        'editUrl'        => 'edit.php?id=' . $prod['id'],
        'viewUrl'        => '/nirajindustries/products/' . ($prod['slug'] ?? ''),
    ];
}

$extraJS = '<script>
window._seoData    = ' . json_encode($initialSeoData) . ';
var _currentPage   = ' . (int)$page . ';
var _currentSearch = ' . json_encode($search) . ';
var _totalPages    = ' . (int)$totalPages . ';
var _totalRecords  = ' . (int)$totalRecords . ';
var _limit         = ' . (int)$limit . ';
var _searchTimer   = null;

// ── AJAX Loader ───────────────────────────────────────────────
function loadProducts(page, search) {
    page   = page || 1;
    search = (search === undefined) ? _currentSearch : search;
    var loader  = document.getElementById("tableLoader");
    var spinner = document.getElementById("searchSpinner");
    var tbody   = document.getElementById("productsTableBody");
    loader.classList.add("active");
    spinner.classList.add("active");
    var params = new URLSearchParams({ page: page, search: search });
    fetch("ajax_products.php?" + params.toString())
        .then(r => r.json())
        .then(data => {
            if (data.seoData) Object.assign(window._seoData, data.seoData);
            tbody.innerHTML = data.rows;
            tbody.querySelectorAll("[data-bs-toggle=\'tooltip\']").forEach(el => new bootstrap.Tooltip(el));
            _currentPage   = data.currentPage;
            _currentSearch = data.search;
            _totalPages    = data.totalPages;
            _totalRecords  = data.totalRecords;
            document.getElementById("totalBadge").textContent = data.totalRecords + " products";
            var from = data.totalRecords === 0 ? 0 : data.offset + 1;
            var to   = Math.min(data.offset + data.limit, data.totalRecords);
            document.getElementById("entryFrom").textContent  = from;
            document.getElementById("entryTo").textContent    = to;
            document.getElementById("entryTotal").textContent = data.totalRecords;
            document.getElementById("paginationFooter").style.display = data.totalPages > 1 ? "flex" : "none";
            renderPagination(data.currentPage, data.totalPages, data.search);
            window.history.replaceState({page, search}, "", "index.php?" + params.toString());
            document.getElementById("clearSearchBtn").style.display = search ? "inline-block" : "none";
            loader.classList.remove("active");
            spinner.classList.remove("active");
        })
        .catch(err => {
            console.error("AJAX error:", err);
            loader.classList.remove("active");
            spinner.classList.remove("active");
        });
}

// ── Pagination ────────────────────────────────────────────────
function renderPagination(currentPage, totalPages, search) {
    var ul = document.getElementById("paginationList");
    if (!ul) return;
    ul.innerHTML = "";
    var maxVisible = 5, half = Math.floor(maxVisible / 2);
    var start = Math.max(1, currentPage - half);
    var end   = Math.min(totalPages, start + maxVisible - 1);
    if (end - start + 1 < maxVisible) start = Math.max(1, end - maxVisible + 1);

    var prevLi = document.createElement("li");
    prevLi.className = "page-item" + (currentPage <= 1 ? " disabled" : "");
    var prevA = document.createElement("a");
    prevA.className = "page-link text-dark shadow-sm rounded-start-pill px-3";
    prevA.href = "#"; prevA.textContent = "Previous";
    if (currentPage > 1) prevA.addEventListener("click", e => { e.preventDefault(); loadProducts(currentPage - 1, search); });
    prevLi.appendChild(prevA); ul.appendChild(prevLi);

    if (start > 1) {
        ul.appendChild(makePagerItem(1, currentPage, search));
        if (start > 2) { var d = document.createElement("li"); d.className = "page-item disabled"; d.innerHTML = "<span class=\'page-link shadow-sm\'>…</span>"; ul.appendChild(d); }
    }
    for (var p = start; p <= end; p++) ul.appendChild(makePagerItem(p, currentPage, search));
    if (end < totalPages) {
        if (end < totalPages - 1) { var d2 = document.createElement("li"); d2.className = "page-item disabled"; d2.innerHTML = "<span class=\'page-link shadow-sm\'>…</span>"; ul.appendChild(d2); }
        ul.appendChild(makePagerItem(totalPages, currentPage, search));
    }

    var nextLi = document.createElement("li");
    nextLi.className = "page-item" + (currentPage >= totalPages ? " disabled" : "");
    var nextA = document.createElement("a");
    nextA.className = "page-link text-dark shadow-sm rounded-end-pill px-3";
    nextA.href = "#"; nextA.textContent = "Next";
    if (currentPage < totalPages) nextA.addEventListener("click", e => { e.preventDefault(); loadProducts(currentPage + 1, search); });
    nextLi.appendChild(nextA); ul.appendChild(nextLi);
}

function makePagerItem(p, currentPage, search) {
    var li = document.createElement("li");
    li.className = "page-item" + (p === currentPage ? " active" : "");
    var a = document.createElement("a");
    a.className = "page-link shadow-sm" + (p === currentPage ? "" : " text-dark");
    a.href = "#"; a.textContent = p;
    if (p !== currentPage) a.addEventListener("click", e => { e.preventDefault(); loadProducts(p, search); });
    li.appendChild(a); return li;
}

// ── DOMContentLoaded ──────────────────────────────────────────
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-bs-toggle=\'tooltip\']").forEach(el => new bootstrap.Tooltip(el));
    renderPagination(_currentPage, _totalPages, _currentSearch);

    var searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", function () {
        clearTimeout(_searchTimer);
        var q = this.value.trim();
        _searchTimer = setTimeout(() => loadProducts(1, q), 400);
    });
    document.getElementById("clearSearchBtn").addEventListener("click", function () {
        document.getElementById("searchInput").value = "";
        loadProducts(1, "");
    });
    window.addEventListener("popstate", function (e) {
        if (e.state) {
            document.getElementById("searchInput").value = e.state.search || "";
            loadProducts(e.state.page || 1, e.state.search || "");
        }
    });
});

// ── SEO Modal ─────────────────────────────────────────────────
function openSeoModal(id) {
    var d = window._seoData[id];
    if (!d) return;
    var modal = new bootstrap.Modal(document.getElementById("seoModal"));
    var shortName = d.name.length > 40 ? d.name.substring(0, 40) + "..." : d.name;
    document.getElementById("modalTitle").textContent = "SEO Audit: " + shortName;

    var verdicts = {
        "A": "Excellent! Product is fully optimized to rank.",
        "B": "Solid SEO. Minor improvements recommended.",
        "C": "Average. Needs focused improvements.",
        "F": "Failing SEO. Requires a full overhaul."
    };

    var goodHtml  = d.good.map(g => `<div class="p-2 mb-2 rounded-3 bg-success-subtle text-success-emphasis border border-success-subtle d-flex align-items-start gap-2 small fw-medium"><i class="fa fa-check-circle mt-1 text-success"></i><span>${g}</span></div>`).join("");
    var issueHtml = d.issues.map(i => `<div class="p-2 mb-2 rounded-3 bg-danger-subtle text-danger-emphasis border border-danger-subtle d-flex align-items-start gap-2 small fw-medium"><i class="fa fa-exclamation-circle mt-1 text-danger"></i><span>${i}</span></div>`).join("");

    var rankMap = {"Top 10": 90, "Top 30": 65, "Top 50": 40, "Low": 15};
    var rankPct  = rankMap[d.rank] || 15;
    var rankBg   = rankPct > 60 ? "bg-success"   : (rankPct > 30 ? "bg-warning"   : "bg-danger");
    var rankTxt  = rankPct > 60 ? "text-success" : (rankPct > 30 ? "text-warning" : "text-danger");

    var gradeBg  = d.gradeTextClass.replace("text-", "bg-");

    var tips = [];
    if (!d.tags)         tips.push("Add relevant tags for better search discoverability");
    if (!d.slug)         tips.push("Set a clean URL slug — e.g. \"heavy-duty-steel-bars\"");
    if (!d.certifications) tips.push("Add certifications — boosts trust & SEO authority");
    var tipsHtml = tips.length
        ? "<h6 class=\'text-uppercase fw-bold text-muted small mb-3 mt-4\' style=\'letter-spacing:0.5px;\'>Actionable Advice</h6>"
          + tips.map(t => `<div class="p-2 mb-2 rounded-3 d-flex align-items-start gap-2 small fw-medium border" style="background:var(--yellow-subtle);color:var(--yellow-dark);border-color:var(--yellow-border) !important;"><i class="fa fa-lightbulb mt-1" style="color:var(--yellow-primary);"></i><span>${t}</span></div>`).join("")
        : "";

    // Build star rating html
    var starsHtml = "";
    for (var s = 1; s <= 5; s++) {
        starsHtml += `<i class="fa fa-star" style="font-size:1rem;color:${s <= Math.round(d.rating) ? "var(--yellow-primary)" : "#dee2e6"};"></i>`;
    }

    var searchPreview = d.slug
        ? `<div class="card mb-4 border rounded-3 shadow-none" style="background:#f8f9fa;"><div class="card-body p-3">
            <div class="small text-muted mb-1 font-monospace" style="font-size:0.75rem;">nirajindustries.com › products › ${d.slug}</div>
            <div class="fs-5 fw-medium mb-1" style="color:#1a0dab;">${d.name}</div>
            <div class="small text-dark" style="line-height:1.4;">${d.category ? d.category + " — " : ""}${d.brand ? "by " + d.brand : ""}</div>
           </div></div>`
        : "";

    document.getElementById("modalBody").innerHTML = `
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 mb-4 shadow-sm rounded-4" style="background:var(--yellow-light);">
                    <div class="card-body p-4 d-flex align-items-center gap-4">
                        <div class="position-relative" style="width:86px;height:86px;flex-shrink:0;">
                            <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#fdedb0" stroke-width="4"></circle>
                                <circle cx="18" cy="18" r="15.9" fill="none" class="${d.gradeTextClass}" stroke="currentColor" stroke-width="4" stroke-dasharray="100 100" stroke-dashoffset="${100 - d.score}" stroke-linecap="round"></circle>
                            </svg>
                            <div class="position-absolute top-50 start-50 translate-middle text-center">
                                <div class="fw-bold fs-3 lh-1 ${d.gradeTextClass}">${d.score}</div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge ${gradeBg} text-white px-2 py-1 fs-6">${d.grade}</span>
                                <span class="text-dark fw-bold fs-5">SEO Health</span>
                            </div>
                            <p class="text-muted small mb-0 fw-medium">${verdicts[d.grade] || "Review required."}</p>
                        </div>
                    </div>
                    <div class="card-footer bg-white p-3 border-top d-flex justify-content-between small text-center rounded-bottom-4">
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Category</div><div class="fw-bold text-dark text-truncate" style="max-width:80px;">${d.category || "—"}</div></div>
                        <div class="border-start border-light"></div>
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Brand</div><div class="fw-bold text-dark">${d.brand || "—"}</div></div>
                        <div class="border-start border-light"></div>
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">MOQ</div><div class="fw-bold text-dark">${d.moq || "—"}</div></div>
                    </div>
                </div>

                <h6 class="text-uppercase fw-bold text-muted small mb-3" style="letter-spacing:0.5px;">Search Preview</h6>
                ${searchPreview}

                <div class="card border border-light shadow-sm bg-white rounded-4">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase fw-bold text-muted small mb-4" style="letter-spacing:0.5px;">Product Performance</h6>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-dark fw-medium">Customer Rating</span>
                                <span class="fw-bold" style="color:var(--yellow-dark);">${d.rating}/5 (${d.reviews} reviews)</span>
                            </div>
                            <div class="d-flex gap-1 mb-2">${starsHtml}</div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-dark fw-medium">Ranking Potential</span>
                                <span class="fw-bold ${rankTxt}">${d.rank}</span>
                            </div>
                            <div class="progress rounded-pill" style="height:6px; background:#fdedb0;">
                                <div class="progress-bar rounded-pill ${rankBg}" style="width:${rankPct}%"></div>
                            </div>
                        </div>
                        ${d.warranty ? `<div class="mt-3 small text-muted"><i class="fa fa-shield-alt me-1" style="color:var(--yellow-primary);"></i>Warranty: <strong>${d.warranty}</strong></div>` : ""}
                        ${d.certifications ? `<div class="mt-1 small text-muted"><i class="fa fa-certificate me-1 text-success"></i>Certified: <strong>${d.certifications}</strong></div>` : ""}
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="d-flex flex-column h-100">
                    <div class="flex-grow-1">
                        ${goodHtml  ? `<h6 class="text-uppercase fw-bold text-muted small mb-3" style="letter-spacing:0.5px;">Passed Checks (${d.good.length})</h6>${goodHtml}` : ""}
                        ${issueHtml ? `<h6 class="text-uppercase fw-bold text-muted small mb-3 mt-4" style="letter-spacing:0.5px;">Issues (${d.issues.length})</h6>${issueHtml}` : ""}
                        ${tipsHtml}
                    </div>
                    <div class="d-flex gap-2 mt-4 pt-4 border-top">
                        <a href="${d.editUrl}" class="btn w-100 shadow-sm rounded-pill fw-semibold text-white btn-add-product">
                            <i class="fa fa-wrench me-2"></i> Fix Issues
                        </a>
                        <a href="${d.viewUrl}" target="_blank" class="btn btn-light w-100 shadow-sm rounded-pill border fw-semibold" style="color:var(--yellow-dark);">
                            <i class="fa fa-external-link-alt me-2"></i> View Product
                        </a>
                    </div>
                </div>
            </div>
        </div>`;
    modal.show();
}
</script>';

require_once '../include/footer.php';
?>