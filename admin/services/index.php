<?php
// admin/services/index.php
require_once __DIR__ . '/../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
requireAccess('services');

$limit  = 10;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search     = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchLike = '%' . $conn->real_escape_string($search) . '%';

// ── Delete ────────────────────────────────────────────────────
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    $delRes   = $conn->query("SELECT title FROM mosquito_services WHERE id = $deleteId");
    $delTitle = $delRes ? ($delRes->fetch_assoc()['title'] ?? 'Unknown') : 'Unknown';
    $conn->query("DELETE FROM mosquito_services WHERE id = $deleteId");
    // Log
    $adminId = $_ADMIN['id'];
    $detail  = "Service deleted: $delTitle";
    $ip      = $_SERVER['REMOTE_ADDR'] ?? '';
    $logStmt = $conn->prepare("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES (?, 'service_deleted', ?, ?, NOW())");
    $logStmt->bind_param("iss", $adminId, $detail, $ip);
    $logStmt->execute();
    $logStmt->close();
    header("Location: ./?msg=deleted");
    exit;
}

// ── Toggle Active ─────────────────────────────────────────────
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $toggleId = (int)$_GET['toggle'];
    $conn->query("UPDATE mosquito_services SET is_active = NOT is_active, updated_at = NOW() WHERE id = $toggleId");
    header("Location: ./");
    exit;
}

// ── Fetch Services ────────────────────────────────────────────
$sql = "
    SELECT *
    FROM mosquito_services
    WHERE title       LIKE '$searchLike'
       OR short_desc  LIKE '$searchLike'
       OR slug        LIKE '$searchLike'
       OR focus_keyword LIKE '$searchLike'
    ORDER BY created_at DESC
    LIMIT $limit OFFSET $offset
";
$result   = $conn->query($sql);
$services = [];
if ($result) while ($row = $result->fetch_assoc()) $services[] = $row;

$countResult = $conn->query("
    SELECT COUNT(*) AS total FROM mosquito_services
    WHERE title      LIKE '$searchLike'
       OR short_desc LIKE '$searchLike'
       OR slug       LIKE '$searchLike'
       OR focus_keyword LIKE '$searchLike'
");
$totalRecords = $countResult ? (int)$countResult->fetch_assoc()['total'] : 0;
$totalPages   = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;

// ── Stats ─────────────────────────────────────────────────────
$statsRes = $conn->query("
    SELECT
        COUNT(*)              AS total,
        SUM(is_active)        AS active_count,
        SUM(!is_active)       AS inactive_count,
        COUNT(DISTINCT schema_type) AS total_schema_types,
        SUM(CASE WHEN image != '' AND image IS NOT NULL THEN 1 ELSE 0 END) AS with_image
    FROM mosquito_services
");
$stats = $statsRes ? $statsRes->fetch_assoc() : [];

// ── Helpers ───────────────────────────────────────────────────
define('BASE_PATH_SERVICE', '/Saagar-Mosquito-Net-Website/');

function resolveImageSrcService($field) {
    if (empty($field)) return '';
    if (str_starts_with($field, 'http://') || str_starts_with($field, 'https://')) return $field;
    return BASE_PATH_SERVICE . ltrim($field, '/');
}

function calcServiceSeoScore($service) {
    $score = 0; $issues = []; $good = [];

    // Title
    $title = $service['title'] ?? '';
    if (strlen($title) >= 40 && strlen($title) <= 70) { $score += 10; $good[] = 'Title length is ideal (40–70 chars)'; }
    elseif (strlen($title) > 0)                       { $score += 5;  $issues[] = 'Title length not ideal (aim for 40–70 chars)'; }
    else                                               { $issues[] = 'Service title missing'; }

    // Short Desc
    $shortDesc = $service['short_desc'] ?? '';
    if (strlen($shortDesc) >= 80 && strlen($shortDesc) <= 200) { $score += 10; $good[] = 'Short description length is ideal'; }
    elseif (strlen($shortDesc) > 0)                            { $score += 5;  $issues[] = 'Short description not ideal length (80–200 chars)'; }
    else                                                       { $issues[] = 'Short description missing'; }

    // Description (word count)
    $description = $service['description'] ?? '';
    $wordCount   = str_word_count(strip_tags($description));
    if ($wordCount >= 500)     { $score += 15; $good[] = "Description length good ($wordCount words)"; }
    elseif ($wordCount >= 200) { $score += 8;  $issues[] = "Description too short ($wordCount words) — aim for 500+"; }
    else                       { $issues[] = 'Description missing or very short'; }

    // Slug
    if (!empty($service['slug'])) { $score += 5; $good[] = 'URL slug set'; }
    else                          { $issues[] = 'URL slug missing'; }

    // Focus Keyword
    if (!empty($service['focus_keyword'])) { $score += 10; $good[] = 'Focus keyword defined'; }
    else                                   { $issues[] = 'Focus keyword not set'; }

    // Main Image
    if (!empty($service['image'])) { $score += 10; $good[] = 'Main image uploaded'; }
    else                           { $issues[] = 'No main image uploaded'; }

    // Meta Title
    if (!empty($service['meta_title'])) { $score += 10; $good[] = 'Meta title set'; }
    else                                { $issues[] = 'Meta title missing'; }

    // Meta Description
    if (!empty($service['meta_description'])) { $score += 10; $good[] = 'Meta description set'; }
    else                                      { $issues[] = 'Meta description missing'; }

    // Schema Type
    if (!empty($service['schema_type'])) { $score += 10; $good[] = 'Schema / structured data type set'; }
    else                                 { $issues[] = 'Schema type not configured'; }

    // FAQs
    $faqs = json_decode($service['faqs'] ?? '[]', true);
    if (!empty($faqs) && count($faqs) >= 1) { $score += 10; $good[] = count($faqs) . ' FAQ(s) added (helps rich results)'; }
    else                                    { $issues[] = 'No FAQs added — add 3+ for rich results'; }

    return ['score' => min(100, $score), 'issues' => $issues, 'good' => $good];
}

function serviceSeoGrade($score) {
    if ($score >= 80) return ['A', 'text-warning'];
    if ($score >= 65) return ['B', 'text-primary'];
    if ($score >= 50) return ['C', 'text-info'];
    return ['F', 'text-danger'];
}

function serviceRankPotential($score) {
    if ($score >= 80) return 'Top 10';
    if ($score >= 65) return 'Top 30';
    if ($score >= 50) return 'Top 50';
    return 'Low';
}

// ── Page Setup ────────────────────────────────────────────────
$pageTitle  = 'Manage Services';
$activePage = 'services-index';
$assetBase  = '../';

$extraCSS = '
<style>
    :root {
        --green-primary: #16a34a;
        --green-dark:    #15803d;
        --green-light:   #f0fdf4;
        --green-subtle:  #dcfce7;
        --green-border:  #bbf7d0;
    }
    body { background-color: #f0fdf7 !important; }
    .page-wrapper { background-color: #f0fdf7 !important; min-height: 100vh; }

    .stat-card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card-hover:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(22,163,74,.15) !important; }

    .icon-green {
        background-color: var(--green-subtle) !important;
        color: var(--green-primary) !important;
    }

    .table-hover-soft tbody tr { transition: background-color 0.15s ease; }
    .table-hover-soft tbody tr:hover { background-color: var(--green-light) !important; }

    .service-thumb {
        width: 64px; height: 52px; object-fit: cover;
        border-radius: 10px; flex-shrink: 0;
        border: 2px solid var(--green-border);
        background: #fff;
    }
    .service-thumb-placeholder {
        width: 64px; height: 52px; border-radius: 10px; flex-shrink: 0;
        background: var(--green-subtle); display: flex; align-items: center;
        justify-content: center; color: var(--green-primary); font-size: 1.4rem;
        border: 2px solid var(--green-border);
    }

    #tableLoader {
        display: none;
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(240,253,244,0.8);
        z-index: 10; align-items: center; justify-content: center;
        border-radius: 0 0 1rem 1rem;
    }
    #tableLoader.active { display: flex; }
    .table-wrapper { position: relative; min-height: 200px; }

    .search-bar-wrap { position: relative; width: 340px; max-width: 100%; }
    #searchSpinner { display: none; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); }
    #searchSpinner.active { display: block; }

    .page-link { transition: all 0.15s ease; }
    .pagination .page-item.active .page-link {
        background-color: var(--green-primary) !important;
        border-color: var(--green-primary) !important;
        color: #fff !important;
    }
    .page-link:hover { background-color: var(--green-subtle) !important; color: var(--green-dark) !important; }

    .card-header-accent { border-left: 4px solid var(--green-primary); }

    .btn-add-service {
        background: linear-gradient(135deg, var(--green-primary), var(--green-dark));
        border: none; color: #fff;
    }
    .btn-add-service:hover {
        background: linear-gradient(135deg, var(--green-dark), #0f5c2e);
        color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(22,163,74,.4);
    }

    .seo-circle-wrap { cursor: pointer; }
    .seo-circle-wrap:hover { opacity: 0.85; }

    .breadcrumb-item a { color: var(--green-dark) !important; }

    .page-title-icon {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, var(--green-primary), var(--green-dark));
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
                        <i class="fa fa-concierge-bell"></i>
                    </div>
                    <div>
                        <h3 class="fw-bolder text-dark mb-1">Services Directory</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb small bg-transparent p-0 m-0">
                                <li class="breadcrumb-item"><a href="../" class="text-decoration-none fw-medium">Dashboard</a></li>
                                <li class="breadcrumb-item active text-secondary fw-medium">Services</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="add" class="btn btn-add-service rounded-pill px-4 py-2 shadow fw-semibold d-inline-flex align-items-center gap-2" style="transition:all .2s;">
                        <i class="fa fa-plus"></i> Add Service
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (isset($_GET['msg'])):
                $msgMap = [
                    'deleted' => ['danger',  'Service removed permanently.',    'fa-trash-alt'],
                    'added'   => ['success', 'New service added successfully.',  'fa-check-circle'],
                    'updated' => ['success', 'Service updated successfully.',    'fa-check-circle'],
                ];
                [$msgType, $msgText, $msgIcon] = $msgMap[$_GET['msg']] ?? ['success', 'Action completed.', 'fa-check'];
            ?>
            <div class="alert alert-<?= $msgType ?> border-0 shadow-sm alert-dismissible fade show d-flex align-items-center gap-3 rounded-3" role="alert">
                <i class="fa <?= $msgIcon ?> fs-4"></i>
                <div class="fw-medium"><?= htmlspecialchars($msgText) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <!-- Stats Cards -->
            <div class="row g-4 mb-5">

                <!-- Total Services -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Total Services</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['total'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= (int)($stats['active_count'] ?? 0) ?> active</p>
                            </div>
                            <div class="icon-green rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-concierge-bell fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#dcfce7;">
                                <div class="progress-bar rounded-pill" style="background:var(--green-primary); width:<?= ($stats['total'] ?? 0) > 0 ? round(($stats['active_count'] / $stats['total']) * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Services -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Active</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['active_count'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= (int)($stats['inactive_count'] ?? 0) ?> inactive</p>
                            </div>
                            <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-check-circle fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#d4edda;">
                                <div class="progress-bar bg-success rounded-pill" style="width:<?= ($stats['total'] ?? 0) > 0 ? round(($stats['active_count'] / $stats['total']) * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- With Images -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">With Images</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['with_image'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= (int)(($stats['total'] ?? 0) - ($stats['with_image'] ?? 0)) ?> without image</p>
                            </div>
                            <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-image fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#fff3cd;">
                                <div class="progress-bar bg-warning rounded-pill" style="width:<?= ($stats['total'] ?? 0) > 0 ? round(($stats['with_image'] / $stats['total']) * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schema Types -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Schema Types</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['total_schema_types'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1">structured data types</p>
                            </div>
                            <div class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-code fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#d1ecf1;">
                                <div class="progress-bar bg-info rounded-pill" style="width:100%"></div>
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
                        <h5 class="mb-0 fw-bold text-dark">All Services</h5>
                        <span id="totalBadge" class="badge rounded-pill px-3 py-1 fw-semibold border"
                            style="background:var(--green-subtle); color:var(--green-dark); border-color:var(--green-border) !important;">
                            <?= $totalRecords ?> services
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="search-bar-wrap">
                            <div class="input-group input-group-sm rounded-pill border p-1" style="background:var(--green-light); border-color:var(--green-border) !important;">
                                <span class="input-group-text bg-transparent border-0 ps-3" style="color:var(--green-dark);">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" id="searchInput"
                                    class="form-control border-0 shadow-none ps-1"
                                    style="background:transparent;"
                                    placeholder="Search by title, slug, keyword..."
                                    value="<?= htmlspecialchars($search) ?>" autocomplete="off">
                                <span id="searchSpinner">
                                    <span class="spinner-border spinner-border-sm" role="status" style="color:var(--green-primary);"></span>
                                </span>
                            </div>
                        </div>
                        <button id="clearSearchBtn" class="btn btn-sm rounded-pill px-3 fw-medium border"
                            style="background:var(--green-subtle); color:var(--green-dark); border-color:var(--green-border); display:<?= $search ? 'inline-block' : 'none' ?>;">
                            <i class="fa fa-times me-1"></i>Clear
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-wrapper">
                    <div id="tableLoader">
                        <div class="d-flex flex-column align-items-center gap-2">
                            <div class="spinner-border" role="status" style="width:2rem;height:2rem;color:var(--green-primary);"></div>
                            <span class="small fw-medium" style="color:var(--green-dark);">Loading…</span>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover-soft table-borderless align-middle mb-0">
                            <thead style="background:var(--green-light);">
                                <tr class="text-uppercase text-muted" style="font-size:0.72rem;letter-spacing:0.5px;">
                                    <th class="ps-4 py-3 fw-bold">Service</th>
                                    <th class="py-3 fw-bold">Schema / Keyword</th>
                                    <th class="py-3 fw-bold text-center">SEO Health</th>
                                    <th class="py-3 fw-bold">Lists &amp; FAQs</th>
                                    <th class="py-3 fw-bold">Status</th>
                                    <th class="py-3 fw-bold text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="servicesTableBody">
                                <?php if (empty($services)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-5">
                                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width:80px;height:80px;background:var(--green-subtle);">
                                                <i class="fa fa-concierge-bell fs-1" style="color:var(--green-primary); opacity:0.6;"></i>
                                            </div>
                                            <h5 class="text-dark fw-bold">No services found</h5>
                                            <p class="text-muted mb-4">Start by adding your first service!</p>
                                            <a href="add" class="btn btn-add-service rounded-pill px-4 shadow-sm fw-semibold">
                                                <i class="fa fa-plus me-2"></i>Add Service
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($services as $service):
                                    $seo    = calcServiceSeoScore($service);
                                    $score  = $seo['score'];
                                    [$grade, $gradeTextColor] = serviceSeoGrade($score);
                                    $issueCount   = count($seo['issues']);
                                    $gradeBgClass = str_replace('text-', 'bg-', $gradeTextColor);
                                    $imgSrc       = resolveImageSrcService($service['image'] ?? '');
                                    $isActive     = (bool)($service['is_active'] ?? 0);
                                    $createdDate  = $service['created_at'] ? date('d M Y', strtotime($service['created_at'])) : '—';

                                    // Decode JSON lists
                                    $servicesList = json_decode($service['services_list'] ?? '[]', true) ?: [];
                                    $featuresList = json_decode($service['features_list']  ?? '[]', true) ?: [];
                                    $faqsList     = json_decode($service['faqs']           ?? '[]', true) ?: [];
                                    $totalListItems = count($servicesList) + count($featuresList);
                                ?>
                                <tr class="border-bottom border-light">

                                    <!-- Service Title & Thumb -->
                                    <td class="ps-4 py-3" style="max-width:290px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (!empty($imgSrc)): ?>
                                            <img src="<?= htmlspecialchars($imgSrc) ?>"
                                                class="service-thumb shadow-sm"
                                                alt="<?= htmlspecialchars($service['title']) ?>"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="service-thumb-placeholder" style="display:none;"><i class="fa fa-concierge-bell"></i></div>
                                            <?php else: ?>
                                            <div class="service-thumb-placeholder"><i class="fa fa-concierge-bell"></i></div>
                                            <?php endif; ?>

                                            <div style="min-width:0; max-width:210px;">
                                                <h6 class="mb-1 fw-bold text-dark" style="word-break:break-word; white-space:normal; line-height:1.3;">
                                                    <?= htmlspecialchars(mb_strimwidth($service['title'], 0, 55, '…')) ?>
                                                </h6>
                                                <div class="small text-muted" style="font-size:0.72rem;">
                                                    <i class="fa fa-calendar me-1"></i><?= $createdDate ?>
                                                </div>
                                                <?php if (!empty($service['slug'])): ?>
                                                <div class="small text-muted mt-1" style="font-size:0.7rem; font-family:monospace; color:#9ca3af !important;">
                                                    /service/<?= htmlspecialchars(mb_strimwidth($service['slug'], 0, 28, '…')) ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Schema / Keyword -->
                                    <td class="py-3">
                                        <?php if (!empty($service['schema_type'])): ?>
                                        <span class="badge rounded-pill px-3 py-2 fw-medium border d-inline-block mb-2"
                                            style="background:var(--green-subtle); color:var(--green-dark); border-color:var(--green-border); font-size:0.78rem;">
                                            <i class="fa fa-code me-1"></i><?= htmlspecialchars($service['schema_type']) ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted small fst-italic d-block mb-2">No schema</span>
                                        <?php endif; ?>
                                        <?php if (!empty($service['focus_keyword'])): ?>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php foreach (array_slice(array_filter(array_map('trim', explode(',', $service['focus_keyword']))), 0, 2) as $kw): ?>
                                            <span class="badge rounded-pill border fw-normal" style="background:#f8f9fa; color:#6b7280; border-color:#e5e7eb; font-size:0.68rem;">
                                                🔑 <?= htmlspecialchars($kw) ?>
                                            </span>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php else: ?>
                                        <span class="text-muted small fst-italic" style="font-size:0.72rem;">No keyword set</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- SEO Health -->
                                    <td class="py-3 text-center">
                                        <div class="d-inline-flex align-items-center gap-3 seo-circle-wrap"
                                            onclick="openSeoModal(<?= $service['id'] ?>)"
                                            data-bs-toggle="tooltip" title="Click for SEO details">
                                            <div class="position-relative" style="width:44px;height:44px;">
                                                <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#dcfce7" stroke-width="3"></circle>
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
                                                    style="<?= $issueCount > 0 ? 'background:var(--green-subtle); color:var(--green-dark);' : '' ?>; font-size:0.7rem;">
                                                    <?php if ($issueCount === 0): ?>
                                                    <i class="fa fa-check me-1"></i>Perfect
                                                    <?php else: ?>
                                                    <i class="fa fa-exclamation-triangle me-1"></i><?= $issueCount ?> Issues
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Lists & FAQs -->
                                    <td class="py-3" style="min-width:130px;">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fa fa-list-ul" style="color:var(--green-primary); font-size:.85rem;"></i>
                                            <span class="fw-bold text-dark"><?= $totalListItems ?></span>
                                            <span class="text-muted small">list items</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa fa-question-circle" style="color:#6366f1; font-size:.8rem;"></i>
                                            <span class="text-muted small"><?= count($faqsList) ?> FAQ<?= count($faqsList) !== 1 ? 's' : '' ?></span>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3">
                                        <a href="./?toggle=<?= $service['id'] ?>" class="text-decoration-none">
                                            <?php if ($isActive): ?>
                                            <span class="badge rounded-pill py-1 px-2 fw-semibold border mb-1 d-block"
                                                style="background:var(--green-subtle); color:var(--green-dark); border-color:var(--green-border); font-size:0.72rem; width:fit-content;">
                                                <span class="d-inline-block rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;background:var(--green-primary);"></span>Active
                                            </span>
                                            <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle rounded-pill py-1 px-2 fw-semibold mb-1 d-block"
                                                style="font-size:0.72rem; width:fit-content;">
                                                <span class="d-inline-block bg-secondary rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>Inactive
                                            </span>
                                            <?php endif; ?>
                                        </a>
                                        <div class="small text-muted mt-1" style="font-size:0.7rem;">Click to toggle</div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-end pe-4">
                                        <div class="btn-group shadow-sm border rounded-pill overflow-hidden bg-white">
                                            <a href="<?= SITE_URL ?>/service-details.php?slug=<?= htmlspecialchars($service['slug'] ?? '') ?>"
                                                target="_blank"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-secondary"
                                                data-bs-toggle="tooltip" title="View Service">
                                                <i class="fa fa-external-link-alt"></i>
                                            </a>
                                            <div class="border-start border-light"></div>
                                            <a href="edit?id=<?= $service['id'] ?>"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-secondary"
                                                data-bs-toggle="tooltip" title="Edit Service">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <div class="border-start border-light"></div>
                                            <a href="./?delete=<?= $service['id'] ?>"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-danger"
                                                onclick="return confirm('Permanently delete \"<?= addslashes(htmlspecialchars($service['title'])) ?>\"? This cannot be undone.')"
                                                data-bs-toggle="tooltip" title="Delete Service">
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
                </div>

                <!-- Pagination Footer -->
                <div id="paginationFooter"
                    class="card-footer bg-white border-top py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3"
                    style="display: <?= $totalPages > 1 ? 'flex' : 'none' ?> !important;">
                    <div class="small text-muted fw-medium" id="entriesInfo">
                        Showing <span class="text-dark fw-bold" id="entryFrom"><?= $offset + 1 ?></span>
                        to <span class="text-dark fw-bold" id="entryTo"><?= min($offset + $limit, $totalRecords) ?></span>
                        of <span id="entryTotal"><?= $totalRecords ?></span> services
                    </div>
                    <nav>
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
            <div class="modal-header border-bottom py-3 px-4" style="background:var(--green-light); border-color:var(--green-border) !important;">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-center rounded" style="width:32px;height:32px;background:var(--green-primary);">
                        <i class="fa fa-chart-line text-white" style="font-size:0.85rem;"></i>
                    </div>
                    <h5 class="modal-title fw-bold text-dark mb-0" id="modalTitle">SEO Analysis</h5>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 bg-white" id="modalBody"></div>
        </div>
    </div>
</div>

<?php
// Build initial SEO data for JS (same pattern as blogs)
$initialSeoData = [];
foreach ($services as $service) {
    $seo   = calcServiceSeoScore($service);
    $score = $seo['score'];
    [$grade, $gradeTextColor] = serviceSeoGrade($score);
    $initialSeoData[$service['id']] = [
        'name'           => $service['title'],
        'score'          => (int)$score,
        'grade'          => $grade,
        'gradeTextClass' => $gradeTextColor,
        'issues'         => $seo['issues'],
        'good'           => $seo['good'],
        'rank'           => serviceRankPotential($score),
        'schema_type'    => $service['schema_type']   ?? '',
        'focus_keyword'  => $service['focus_keyword'] ?? '',
        'slug'           => $service['slug']          ?? '',
        'short_desc'     => $service['short_desc']    ?? '',
        'is_active'      => (bool)($service['is_active'] ?? 0),
        'created_at'     => $service['created_at'] ? date('d M Y', strtotime($service['created_at'])) : '—',
        'faqs_count'     => count(json_decode($service['faqs'] ?? '[]', true) ?: []),
        'editUrl'        => 'edit.php?id=' . $service['id'],
        'viewUrl'        => '/Saagar-Mosquito-Net-Website/service-details.php?slug=' . ($service['slug'] ?? ''),
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

function loadServices(page, search) {
    page   = page || 1;
    search = (search === undefined) ? _currentSearch : search;
    var loader  = document.getElementById("tableLoader");
    var spinner = document.getElementById("searchSpinner");
    var tbody   = document.getElementById("servicesTableBody");
    loader.classList.add("active");
    spinner.classList.add("active");
    var params = new URLSearchParams({ page: page, search: search });
    fetch("ajax_services.php?" + params.toString())
        .then(r => r.json())
        .then(data => {
            if (data.seoData) Object.assign(window._seoData, data.seoData);
            tbody.innerHTML = data.rows;
            tbody.querySelectorAll("[data-bs-toggle=\'tooltip\']").forEach(el => new bootstrap.Tooltip(el));
            _currentPage   = data.currentPage;
            _currentSearch = data.search;
            _totalPages    = data.totalPages;
            _totalRecords  = data.totalRecords;
            document.getElementById("totalBadge").textContent = data.totalRecords + " services";
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
    if (currentPage > 1) prevA.addEventListener("click", e => { e.preventDefault(); loadServices(currentPage - 1, search); });
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
    if (currentPage < totalPages) nextA.addEventListener("click", e => { e.preventDefault(); loadServices(currentPage + 1, search); });
    nextLi.appendChild(nextA); ul.appendChild(nextLi);
}

function makePagerItem(p, currentPage, search) {
    var li = document.createElement("li");
    li.className = "page-item" + (p === currentPage ? " active" : "");
    var a = document.createElement("a");
    a.className = "page-link shadow-sm" + (p === currentPage ? "" : " text-dark");
    a.href = "#"; a.textContent = p;
    if (p !== currentPage) a.addEventListener("click", e => { e.preventDefault(); loadServices(p, search); });
    li.appendChild(a); return li;
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-bs-toggle=\'tooltip\']").forEach(el => new bootstrap.Tooltip(el));
    renderPagination(_currentPage, _totalPages, _currentSearch);

    var searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", function () {
        clearTimeout(_searchTimer);
        var q = this.value.trim();
        _searchTimer = setTimeout(() => loadServices(1, q), 400);
    });
    document.getElementById("clearSearchBtn").addEventListener("click", function () {
        document.getElementById("searchInput").value = "";
        loadServices(1, "");
    });
    window.addEventListener("popstate", function (e) {
        if (e.state) {
            document.getElementById("searchInput").value = e.state.search || "";
            loadServices(e.state.page || 1, e.state.search || "");
        }
    });
});

function openSeoModal(id) {
    var d = window._seoData[id];
    if (!d) return;
    var modal     = new bootstrap.Modal(document.getElementById("seoModal"));
    var shortName = d.name.length > 45 ? d.name.substring(0, 45) + "..." : d.name;
    document.getElementById("modalTitle").textContent = "SEO Audit: " + shortName;

    var verdicts = {
        "A": "Excellent! Service is fully optimized for search engines.",
        "B": "Solid SEO. Minor improvements will boost rankings.",
        "C": "Average. Needs focused content & meta improvements.",
        "F": "Poor SEO. Requires a full content & meta overhaul."
    };

    var goodHtml  = d.good.map(g  => `<div class="p-2 mb-2 rounded-3 bg-success-subtle text-success-emphasis border border-success-subtle d-flex align-items-start gap-2 small fw-medium"><i class="fa fa-check-circle mt-1 text-success"></i><span>${g}</span></div>`).join("");
    var issueHtml = d.issues.map(i => `<div class="p-2 mb-2 rounded-3 bg-danger-subtle text-danger-emphasis border border-danger-subtle d-flex align-items-start gap-2 small fw-medium"><i class="fa fa-exclamation-circle mt-1 text-danger"></i><span>${i}</span></div>`).join("");

    var rankMap  = {"Top 10": 90, "Top 30": 65, "Top 50": 40, "Low": 15};
    var rankPct  = rankMap[d.rank] || 15;
    var rankBg   = rankPct > 60 ? "bg-success"   : (rankPct > 30 ? "bg-warning"   : "bg-danger");
    var rankTxt  = rankPct > 60 ? "text-success" : (rankPct > 30 ? "text-warning" : "text-danger");
    var gradeBg  = d.gradeTextClass.replace("text-", "bg-");

    var tips = [];
    if (!d.focus_keyword) tips.push("Set a focus keyword to target specific search queries");
    if (!d.slug)          tips.push("Set a clean URL slug — e.g. \"bedroom-mosquito-nets\"");
    if (!d.schema_type)   tips.push("Add schema type (Service / LocalBusiness) for rich results");
    if (d.faqs_count < 3) tips.push("Add " + (3 - d.faqs_count) + " more FAQ(s) — 3+ unlocks Google rich snippets");
    var tipsHtml = tips.length
        ? "<h6 class=\'text-uppercase fw-bold text-muted small mb-3 mt-4\' style=\'letter-spacing:0.5px;\'>Actionable Advice</h6>"
          + tips.map(t => `<div class="p-2 mb-2 rounded-3 d-flex align-items-start gap-2 small fw-medium border" style="background:var(--green-subtle);color:var(--green-dark);border-color:var(--green-border) !important;"><i class="fa fa-lightbulb mt-1" style="color:var(--green-primary);"></i><span>${t}</span></div>`).join("")
        : "";

    var searchPreview = d.slug
        ? `<div class="card mb-4 border rounded-3 shadow-none" style="background:#f8f9fa;"><div class="card-body p-3">
            <div class="small text-muted mb-1 font-monospace" style="font-size:0.75rem;">Saagar-Mosquito-Net-Website.com › service-details › ${d.slug}</div>
            <div class="fs-5 fw-medium mb-1" style="color:#1a0dab;">${d.name}</div>
            <div class="small text-dark" style="line-height:1.4;">${d.short_desc ? d.short_desc.substring(0, 120) + (d.short_desc.length > 120 ? "..." : "") : ""}</div>
           </div></div>`
        : "";

    document.getElementById("modalBody").innerHTML = `
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 mb-4 shadow-sm rounded-4" style="background:var(--green-light);">
                    <div class="card-body p-4 d-flex align-items-center gap-4">
                        <div class="position-relative" style="width:86px;height:86px;flex-shrink:0;">
                            <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#dcfce7" stroke-width="4"></circle>
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
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Schema</div><div class="fw-bold text-dark text-truncate" style="max-width:80px;">${d.schema_type || "—"}</div></div>
                        <div class="border-start border-light"></div>
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">FAQs</div><div class="fw-bold text-dark">${d.faqs_count}</div></div>
                        <div class="border-start border-light"></div>
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Status</div><div class="fw-bold ${d.is_active ? "text-success" : "text-secondary"}">${d.is_active ? "Active" : "Inactive"}</div></div>
                    </div>
                </div>

                <h6 class="text-uppercase fw-bold text-muted small mb-3" style="letter-spacing:0.5px;">Search Preview</h6>
                ${searchPreview}

                <div class="card border border-light shadow-sm bg-white rounded-4">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase fw-bold text-muted small mb-4" style="letter-spacing:0.5px;">Service Performance</h6>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-dark fw-medium">Created Date</span>
                                <span class="fw-bold" style="color:var(--green-dark);">${d.created_at}</span>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-dark fw-medium">Ranking Potential</span>
                                <span class="fw-bold ${rankTxt}">${d.rank}</span>
                            </div>
                            <div class="progress rounded-pill" style="height:6px; background:#dcfce7;">
                                <div class="progress-bar rounded-pill ${rankBg}" style="width:${rankPct}%"></div>
                            </div>
                        </div>
                        ${d.focus_keyword ? `<div class="mt-3 small text-muted"><i class="fa fa-key me-1" style="color:var(--green-primary);"></i>Keyword: <strong>${d.focus_keyword}</strong></div>` : ""}
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
                        <a href="${d.editUrl}" class="btn w-100 shadow-sm rounded-pill fw-semibold text-white btn-add-service">
                            <i class="fa fa-wrench me-2"></i>Fix Issues
                        </a>
                        <a href="${d.viewUrl}" target="_blank" class="btn btn-light w-100 shadow-sm rounded-pill border fw-semibold" style="color:var(--green-dark);">
                            <i class="fa fa-external-link-alt me-2"></i>View Service
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