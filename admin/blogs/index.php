<?php
// admin/blogs/index.php
require_once __DIR__ . '/../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
requireAccess('blogs');

$limit  = 10;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$search     = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchLike = '%' . $conn->real_escape_string($search) . '%';

// ── Delete ────────────────────────────────────────────────────
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $deleteId = (int)$_GET['delete'];
    // Get title for activity log
    $delRes = $conn->query("SELECT title FROM blogs WHERE id = $deleteId");
    $delTitle = $delRes ? ($delRes->fetch_assoc()['title'] ?? 'Unknown') : 'Unknown';
    $conn->query("DELETE FROM blogs WHERE id = $deleteId");
    // Log
    $adminId = $_ADMIN['id'];
    $detail  = "Blog deleted: $delTitle";
    $ip      = $_SERVER['REMOTE_ADDR'] ?? '';
    $logStmt = $conn->prepare("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES (?, 'blog_deleted', ?, ?, NOW())");
    $logStmt->bind_param("iss", $adminId, $detail, $ip);
    $logStmt->execute();
    $logStmt->close();
    header("Location: ./?msg=deleted");
    exit;
}

// ── Toggle Published ──────────────────────────────────────────
if (isset($_GET['toggle']) && is_numeric($_GET['toggle'])) {
    $toggleId = (int)$_GET['toggle'];
    $conn->query("UPDATE blogs SET is_published = NOT is_published, updated_at = NOW() WHERE id = $toggleId");
    header("Location: ./");
    exit;
}

// ── Fetch Blogs ───────────────────────────────────────────────
$sql = "
    SELECT b.*, bc.name AS cat_name
    FROM blogs b
    LEFT JOIN blog_categories bc ON bc.id = b.categories
    WHERE b.title     LIKE '$searchLike'
       OR b.excerpt   LIKE '$searchLike'
       OR b.tags      LIKE '$searchLike'
       OR bc.name     LIKE '$searchLike'
    ORDER BY b.created_at DESC
    LIMIT $limit OFFSET $offset
";
$result = $conn->query($sql);
$blogs  = [];
if ($result) while ($row = $result->fetch_assoc()) $blogs[] = $row;

$countResult = $conn->query("
    SELECT COUNT(*) AS total FROM blogs b
    LEFT JOIN blog_categories bc ON bc.id = b.categories
    WHERE b.title LIKE '$searchLike' OR b.excerpt LIKE '$searchLike'
       OR b.tags LIKE '$searchLike' OR bc.name LIKE '$searchLike'
");
$totalRecords = $countResult ? (int)$countResult->fetch_assoc()['total'] : 0;
$totalPages   = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;

// ── Stats ─────────────────────────────────────────────────────
$statsRes = $conn->query("SELECT
    COUNT(*) as total,
    SUM(is_published) as published_count,
    SUM(!is_published) as draft_count,
    COALESCE(SUM(views), 0) as total_views,
    COALESCE(SUM(comments), 0) as total_comments,
    COUNT(DISTINCT categories) as total_categories
    FROM blogs");
$stats = $statsRes ? $statsRes->fetch_assoc() : [];

// ── Helpers ───────────────────────────────────────────────────
define('BASE_PATH_BLOG', '/nirajindustries/');

function resolveImageSrcBlog($field) {
    if (empty($field)) return '';
    if (str_starts_with($field, 'http://') || str_starts_with($field, 'https://')) return $field;
    return BASE_PATH_BLOG . ltrim($field, '/');
}

function calcBlogSeoScore($blog) {
    $score = 0; $issues = []; $good = [];

    // Title
    $title = $blog['title'] ?? '';
    if (strlen($title) >= 40 && strlen($title) <= 70) { $score += 10; $good[] = 'Title length is ideal (40–70 chars)'; }
    elseif (strlen($title) > 0)                        { $score += 5;  $issues[] = 'Title length not ideal (aim for 40–70 chars)'; }
    else                                                { $issues[] = 'Blog title missing'; }

    // Excerpt
    $excerpt = $blog['excerpt'] ?? '';
    if (strlen($excerpt) >= 80 && strlen($excerpt) <= 200) { $score += 10; $good[] = 'Excerpt length is ideal'; }
    elseif (strlen($excerpt) > 0)                          { $score += 5;  $issues[] = 'Excerpt not ideal length (80–200 chars)'; }
    else                                                   { $issues[] = 'Excerpt missing'; }

    // Content
    $content   = $blog['content'] ?? '';
    $wordCount = str_word_count(strip_tags($content));
    if ($wordCount >= 800)      { $score += 15; $good[] = "Content length good ($wordCount words)"; }
    elseif ($wordCount >= 300)  { $score += 8;  $issues[] = "Content too short ($wordCount words) — aim for 800+"; }
    else                        { $issues[] = 'Content missing or very short'; }

    // Slug
    if (!empty($blog['slug'])) { $score += 5; $good[] = 'URL slug set'; }
    else                       { $issues[] = 'URL slug missing'; }

    // Category
    if (!empty($blog['categories']) && $blog['categories'] > 0) { $score += 5; $good[] = 'Category assigned'; }
    else { $issues[] = 'No category assigned'; }

    // Featured image
    if (!empty($blog['image'])) { $score += 10; $good[] = 'Featured image uploaded'; }
    else                        { $issues[] = 'No featured image uploaded'; }

    // Image alt text
    if (!empty($blog['image_alt'])) { $score += 5; $good[] = 'Image alt text set'; }
    else                             { $issues[] = 'Image alt text missing'; }

    // Tags
    if (!empty($blog['tags'])) { $score += 10; $good[] = 'Tags added'; }
    else                       { $issues[] = 'No tags added'; }

    // Meta title
    if (!empty($blog['meta_title'])) { $score += 10; $good[] = 'Meta title set'; }
    else                             { $issues[] = 'Meta title missing'; }

    // Meta description
    if (!empty($blog['meta_description'])) { $score += 10; $good[] = 'Meta description set'; }
    else                                   { $issues[] = 'Meta description missing'; }

    // Focus keyword
    if (!empty($blog['focus_keyword'])) { $score += 10; $good[] = 'Focus keyword defined'; }
    else                                { $issues[] = 'Focus keyword not set'; }

    return ['score' => min(100, $score), 'issues' => $issues, 'good' => $good];
}

function blogSeoGrade($score) {
    if ($score >= 80) return ['A', 'text-warning'];
    if ($score >= 65) return ['B', 'text-primary'];
    if ($score >= 50) return ['C', 'text-info'];
    return ['F', 'text-danger'];
}

function blogRankPotential($score) {
    if ($score >= 80) return 'Top 10';
    if ($score >= 65) return 'Top 30';
    if ($score >= 50) return 'Top 50';
    return 'Low';
}

// ── Page Setup ─────────────────────────────────────────────────
$pageTitle  = 'Manage Blogs';
$activePage = 'blogs-index';
$assetBase  = '../';

$extraCSS = '
<style>
    :root {
        --blue-primary: #0369a1;
        --blue-dark:    #075985;
        --blue-light:   #f0f9ff;
        --blue-subtle:  #e0f2fe;
        --blue-border:  #bae6fd;
    }
    body { background-color: #f0f7ff !important; }
    .page-wrapper { background-color: #f0f7ff !important; min-height: 100vh; }

    .stat-card-hover { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-card-hover:hover { transform: translateY(-3px); box-shadow: 0 .5rem 1rem rgba(3,105,161,.15) !important; }

    .icon-blue {
        background-color: var(--blue-subtle) !important;
        color: var(--blue-primary) !important;
    }

    .table-hover-soft tbody tr { transition: background-color 0.15s ease; }
    .table-hover-soft tbody tr:hover { background-color: var(--blue-light) !important; }

    .blog-thumb {
        width: 64px; height: 52px; object-fit: cover;
        border-radius: 10px; flex-shrink: 0;
        border: 2px solid var(--blue-border);
        background: #fff;
    }
    .blog-thumb-placeholder {
        width: 64px; height: 52px; border-radius: 10px; flex-shrink: 0;
        background: var(--blue-subtle); display: flex; align-items: center;
        justify-content: center; color: var(--blue-primary); font-size: 1.4rem;
        border: 2px solid var(--blue-border);
    }

    #tableLoader {
        display: none;
        position: absolute; top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(240,249,255,0.8);
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
        background-color: var(--blue-primary) !important;
        border-color: var(--blue-primary) !important;
        color: #fff !important;
    }
    .page-link:hover { background-color: var(--blue-subtle) !important; color: var(--blue-dark) !important; }

    .card-header-accent { border-left: 4px solid var(--blue-primary); }

    .btn-add-blog {
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-dark));
        border: none; color: #fff;
    }
    .btn-add-blog:hover {
        background: linear-gradient(135deg, var(--blue-dark), #023e63);
        color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(3,105,161,.4);
    }

    .seo-circle-wrap { cursor: pointer; }
    .seo-circle-wrap:hover { opacity: 0.85; }

    .breadcrumb-item a { color: var(--blue-dark) !important; }

    .page-title-icon {
        width: 42px; height: 42px;
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-dark));
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
                        <i class="fa fa-newspaper"></i>
                    </div>
                    <div>
                        <h3 class="fw-bolder text-dark mb-1">Blogs Directory</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb small bg-transparent p-0 m-0">
                                <li class="breadcrumb-item"><a href="../" class="text-decoration-none fw-medium">Dashboard</a></li>
                                <li class="breadcrumb-item active text-secondary fw-medium">Blogs</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="add" class="btn btn-add-blog rounded-pill px-4 py-2 shadow fw-semibold d-inline-flex align-items-center gap-2" style="transition:all .2s;">
                        <i class="fa fa-plus"></i> Add Blog
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (isset($_GET['msg'])):
                $msgMap = [
                    'deleted' => ['danger',  'Blog removed permanently.',    'fa-trash-alt'],
                    'added'   => ['success', 'New blog added successfully.',  'fa-check-circle'],
                    'updated' => ['success', 'Blog updated successfully.',    'fa-check-circle'],
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

                <!-- Total Blogs -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Total Blogs</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['total'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= (int)($stats['published_count'] ?? 0) ?> published</p>
                            </div>
                            <div class="icon-blue rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-file-alt fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#e0f2fe;">
                                <div class="progress-bar rounded-pill" style="background:var(--blue-primary); width:<?= $stats['total'] > 0 ? round(($stats['published_count']/$stats['total'])*100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Published -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Published</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['published_count'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= (int)($stats['draft_count'] ?? 0) ?> drafts</p>
                            </div>
                            <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-check-circle fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#d4edda;">
                                <div class="progress-bar bg-success rounded-pill" style="width:<?= $stats['total'] > 0 ? round(($stats['published_count']/$stats['total'])*100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Views -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Total Views</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= number_format((int)($stats['total_views'] ?? 0)) ?></h2>
                                <p class="small text-muted mb-0 mt-1"><?= number_format((int)($stats['total_comments'] ?? 0)) ?> comments</p>
                            </div>
                            <div class="bg-warning-subtle text-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-eye fs-4"></i>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 px-4 pb-3 pt-0">
                            <div class="progress rounded-pill" style="height:4px; background:#fff3cd;">
                                <div class="progress-bar bg-warning rounded-pill" style="width:100%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card-hover border-0 shadow-sm rounded-4 h-100" style="background:#fff;">
                        <div class="card-body p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-muted text-uppercase small fw-bold mb-1" style="letter-spacing:0.5px;">Categories</p>
                                <h2 class="fw-bolder mb-0 text-dark"><?= (int)($stats['total_categories'] ?? 0) ?></h2>
                                <p class="small text-muted mb-0 mt-1">across all blogs</p>
                            </div>
                            <div class="bg-info-subtle text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width:54px;height:54px;">
                                <i class="fa fa-layer-group fs-4"></i>
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
                        <h5 class="mb-0 fw-bold text-dark">All Blogs</h5>
                        <span id="totalBadge" class="badge rounded-pill px-3 py-1 fw-semibold border"
                            style="background:var(--blue-subtle); color:var(--blue-dark); border-color:var(--blue-border) !important;">
                            <?= $totalRecords ?> blogs
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <div class="search-bar-wrap">
                            <div class="input-group input-group-sm rounded-pill border p-1" style="background:var(--blue-light); border-color:var(--blue-border) !important;">
                                <span class="input-group-text bg-transparent border-0 ps-3" style="color:var(--blue-dark);">
                                    <i class="fa fa-search"></i>
                                </span>
                                <input type="text" id="searchInput"
                                    class="form-control border-0 shadow-none ps-1"
                                    style="background:transparent;"
                                    placeholder="Search by title, tags, category..."
                                    value="<?= htmlspecialchars($search) ?>" autocomplete="off">
                                <span id="searchSpinner">
                                    <span class="spinner-border spinner-border-sm" role="status" style="color:var(--blue-primary);"></span>
                                </span>
                            </div>
                        </div>
                        <button id="clearSearchBtn" class="btn btn-sm rounded-pill px-3 fw-medium border"
                            style="background:var(--blue-subtle); color:var(--blue-dark); border-color:var(--blue-border); display:<?= $search ? 'inline-block' : 'none' ?>;">
                            <i class="fa fa-times me-1"></i>Clear
                        </button>
                    </div>
                </div>
                
                <!-- Table -->
                <div class="table-wrapper">
                    <div id="tableLoader">
                        <div class="d-flex flex-column align-items-center gap-2">
                            <div class="spinner-border" role="status" style="width:2rem;height:2rem;color:var(--blue-primary);"></div>
                            <span class="small fw-medium" style="color:var(--blue-dark);">Loading…</span>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover-soft table-borderless align-middle mb-0">
                            <thead style="background:var(--blue-light);">
                                <tr class="text-uppercase text-muted" style="font-size:0.72rem;letter-spacing:0.5px;">
                                    <th class="ps-4 py-3 fw-bold">Blog</th>
                                    <th class="py-3 fw-bold">Category / Tags</th>
                                    <th class="py-3 fw-bold text-center">SEO Health</th>
                                    <th class="py-3 fw-bold">Views &amp; Engagement</th>
                                    <th class="py-3 fw-bold">Status</th>
                                    <th class="py-3 fw-bold text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="blogsTableBody">
                                <?php if (empty($blogs)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-5">
                                            <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width:80px;height:80px;background:var(--blue-subtle);">
                                                <i class="fa fa-newspaper fs-1" style="color:var(--blue-primary); opacity:0.6;"></i>
                                            </div>
                                            <h5 class="text-dark fw-bold">No blogs found</h5>
                                            <p class="text-muted mb-4">Start writing your first blog post!</p>
                                            <a href="add" class="btn btn-add-blog rounded-pill px-4 shadow-sm fw-semibold">
                                                <i class="fa fa-plus me-2"></i>Add Blog
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php else: ?>
                                <?php foreach ($blogs as $blog):
                                    $seo    = calcBlogSeoScore($blog);
                                    $score  = $seo['score'];
                                    [$grade, $gradeTextColor] = blogSeoGrade($score);
                                    $issueCount   = count($seo['issues']);
                                    $gradeBgClass = str_replace('text-', 'bg-', $gradeTextColor);
                                    $imgSrc       = resolveImageSrcBlog($blog['image'] ?? '');
                                    $isPublished  = (bool)($blog['is_published'] ?? 0);
                                    $pubDate      = $blog['published_at'] ? date('d M Y', strtotime($blog['published_at'])) : '—';
                                    $tags         = array_filter(array_map('trim', explode(',', $blog['tags'] ?? '')));
                                ?>
                                <tr class="border-bottom border-light">

                                    <!-- Blog Title & Thumb -->
                                    <td class="ps-4 py-3" style="max-width:290px;">
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (!empty($imgSrc)): ?>
                                            <img src="<?= htmlspecialchars($imgSrc) ?>"
                                                class="blog-thumb shadow-sm"
                                                alt="<?= htmlspecialchars($blog['title']) ?>"
                                                onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                                            <div class="blog-thumb-placeholder" style="display:none;"><i class="fa fa-newspaper"></i></div>
                                            <?php else: ?>
                                            <div class="blog-thumb-placeholder"><i class="fa fa-newspaper"></i></div>
                                            <?php endif; ?>

                                            <div style="min-width:0; max-width:210px;">
                                                <h6 class="mb-1 fw-bold text-dark" style="word-break:break-word; white-space:normal; line-height:1.3;">
                                                    <?= htmlspecialchars(mb_strimwidth($blog['title'], 0, 55, '…')) ?>
                                                </h6>
                                                <div class="small text-muted" style="font-size:0.72rem;">
                                                    <i class="fa fa-calendar me-1"></i><?= $pubDate ?>
                                                    <?php if ($blog['reading_time']): ?>
                                                    &nbsp;·&nbsp;<i class="fa fa-clock me-1"></i><?= $blog['reading_time'] ?> min read
                                                    <?php endif; ?>
                                                </div>
                                                <?php if (!empty($blog['slug'])): ?>
                                                <div class="small text-muted mt-1" style="font-size:0.7rem; font-family:monospace; color:#9ca3af !important;">
                                                    /blog/<?= htmlspecialchars(mb_strimwidth($blog['slug'], 0, 28, '…')) ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Category / Tags -->
                                    <td class="py-3">
                                        <?php if (!empty($blog['cat_name'])): ?>
                                        <span class="badge rounded-pill px-3 py-2 fw-medium border d-inline-block mb-2"
                                            style="background:var(--blue-subtle); color:var(--blue-dark); border-color:var(--blue-border); font-size:0.78rem;">
                                            <i class="fa fa-layer-group me-1"></i><?= htmlspecialchars($blog['cat_name']) ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="text-muted small fst-italic d-block mb-2">No category</span>
                                        <?php endif; ?>
                                        <div class="d-flex flex-wrap gap-1">
                                            <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                                            <span class="badge rounded-pill border fw-normal" style="background:#f8f9fa; color:#6b7280; border-color:#e5e7eb; font-size:0.68rem;">
                                                #<?= htmlspecialchars($tag) ?>
                                            </span>
                                            <?php endforeach; ?>
                                            <?php if (count($tags) > 3): ?>
                                            <span class="badge rounded-pill border fw-normal" style="background:#f8f9fa; color:#9ca3af; font-size:0.65rem;">+<?= count($tags)-3 ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- SEO Health -->
                                    <td class="py-3 text-center">
                                        <div class="d-inline-flex align-items-center gap-3 seo-circle-wrap"
                                            onclick="openSeoModal(<?= $blog['id'] ?>)"
                                            data-bs-toggle="tooltip" title="Click for SEO details">
                                            <div class="position-relative" style="width:44px;height:44px;">
                                                <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                                                    <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e0f2fe" stroke-width="3"></circle>
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
                                                    style="<?= $issueCount > 0 ? 'background:var(--blue-subtle); color:var(--blue-dark);' : '' ?>; font-size:0.7rem;">
                                                    <?php if ($issueCount === 0): ?>
                                                    <i class="fa fa-check me-1"></i>Perfect
                                                    <?php else: ?>
                                                    <i class="fa fa-exclamation-triangle me-1"></i><?= $issueCount ?> Issues
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Views & Engagement -->
                                    <td class="py-3" style="min-width:130px;">
                                        <div class="d-flex align-items-center gap-2 mb-1">
                                            <i class="fa fa-eye" style="color:#f97316; font-size:.85rem;"></i>
                                            <span class="fw-bold text-dark"><?= number_format($blog['views']) ?></span>
                                            <span class="text-muted small">views</span>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fa fa-comment" style="color:var(--blue-primary); font-size:.8rem;"></i>
                                            <span class="text-muted small"><?= number_format($blog['comments']) ?> comments</span>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3">
                                        <a href="./?toggle=<?= $blog['id'] ?>" class="text-decoration-none">
                                            <?php if ($isPublished): ?>
                                            <span class="badge rounded-pill py-1 px-2 fw-semibold border mb-1 d-block" style="background:var(--blue-subtle); color:var(--blue-dark); border-color:var(--blue-border); font-size:0.72rem; width:fit-content;">
                                                <span class="d-inline-block rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;background:var(--blue-primary);"></span>Published
                                            </span>
                                            <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle rounded-pill py-1 px-2 fw-semibold mb-1 d-block" style="font-size:0.72rem; width:fit-content;">
                                                <span class="d-inline-block bg-secondary rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>Draft
                                            </span>
                                            <?php endif; ?>
                                        </a>
                                        <div class="small text-muted mt-1" style="font-size:0.7rem;">Click to toggle</div>
                                    </td>

                                    <!-- Actions -->
                                    <td class="py-3 text-end pe-4">
                                        <div class="btn-group shadow-sm border rounded-pill overflow-hidden bg-white">
                                            <a href="<?= SITE_URL ?>/<?= htmlspecialchars($blog['slug'] ?? '') ?>"

                                                target="_blank"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-secondary"
                                                data-bs-toggle="tooltip" title="View Blog">
                                                <i class="fa fa-external-link-alt"></i>
                                            </a>
                                            <div class="border-start border-light"></div>
                                            <a href="edit?id=<?= $blog['id'] ?>"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-secondary"
                                                data-bs-toggle="tooltip" title="Edit Blog">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <div class="border-start border-light"></div>
                                            <a href="./?delete=<?= $blog['id'] ?>"
                                                class="btn btn-sm btn-light border-0 py-2 px-3 text-danger"
                                                onclick="return confirm('Permanently delete \"<?= addslashes(htmlspecialchars($blog['title'])) ?>\"? This cannot be undone.')"
                                                data-bs-toggle="tooltip" title="Delete Blog">
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
                        of <span id="entryTotal"><?= $totalRecords ?></span> blogs
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
            <div class="modal-header border-bottom py-3 px-4" style="background:var(--blue-light); border-color:var(--blue-border) !important;">
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center justify-content-center rounded" style="width:32px;height:32px;background:var(--blue-primary);">
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
$initialSeoData = [];
foreach ($blogs as $blog) {
    $seo   = calcBlogSeoScore($blog);
    $score = $seo['score'];
    [$grade, $gradeTextColor] = blogSeoGrade($score);
    $initialSeoData[$blog['id']] = [
        'name'           => $blog['title'],
        'score'          => (int)$score,
        'grade'          => $grade,
        'gradeTextClass' => $gradeTextColor,
        'issues'         => $seo['issues'],
        'good'           => $seo['good'],
        'views'          => (int)$blog['views'],
        'comments'       => (int)$blog['comments'],
        'rank'           => blogRankPotential($score),
        'category'       => $blog['cat_name'] ?? '',
        'slug'           => $blog['slug'] ?? '',
        'tags'           => $blog['tags'] ?? '',
        'reading_time'   => $blog['reading_time'] ?? 0,
        'published_at'   => $blog['published_at'] ? date('d M Y', strtotime($blog['published_at'])) : '—',
        'editUrl'        => 'edit.php?id=' . $blog['id'],
        'viewUrl' => '/nirajindustries/' . ($blog['slug'] ?? ''),
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

function loadBlogs(page, search) {
    page   = page || 1;
    search = (search === undefined) ? _currentSearch : search;
    var loader  = document.getElementById("tableLoader");
    var spinner = document.getElementById("searchSpinner");
    var tbody   = document.getElementById("blogsTableBody");
    loader.classList.add("active");
    spinner.classList.add("active");
    var params = new URLSearchParams({ page: page, search: search });
    fetch("ajax_blogs.php?" + params.toString())
        .then(r => r.json())
        .then(data => {
            if (data.seoData) Object.assign(window._seoData, data.seoData);
            tbody.innerHTML = data.rows;
            tbody.querySelectorAll("[data-bs-toggle=\'tooltip\']").forEach(el => new bootstrap.Tooltip(el));
            _currentPage   = data.currentPage;
            _currentSearch = data.search;
            _totalPages    = data.totalPages;
            _totalRecords  = data.totalRecords;
            document.getElementById("totalBadge").textContent = data.totalRecords + " blogs";
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
    if (currentPage > 1) prevA.addEventListener("click", e => { e.preventDefault(); loadBlogs(currentPage - 1, search); });
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
    if (currentPage < totalPages) nextA.addEventListener("click", e => { e.preventDefault(); loadBlogs(currentPage + 1, search); });
    nextLi.appendChild(nextA); ul.appendChild(nextLi);
}

function makePagerItem(p, currentPage, search) {
    var li = document.createElement("li");
    li.className = "page-item" + (p === currentPage ? " active" : "");
    var a = document.createElement("a");
    a.className = "page-link shadow-sm" + (p === currentPage ? "" : " text-dark");
    a.href = "#"; a.textContent = p;
    if (p !== currentPage) a.addEventListener("click", e => { e.preventDefault(); loadBlogs(p, search); });
    li.appendChild(a); return li;
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-bs-toggle=\'tooltip\']").forEach(el => new bootstrap.Tooltip(el));
    renderPagination(_currentPage, _totalPages, _currentSearch);

    var searchInput = document.getElementById("searchInput");
    searchInput.addEventListener("input", function () {
        clearTimeout(_searchTimer);
        var q = this.value.trim();
        _searchTimer = setTimeout(() => loadBlogs(1, q), 400);
    });
    document.getElementById("clearSearchBtn").addEventListener("click", function () {
        document.getElementById("searchInput").value = "";
        loadBlogs(1, "");
    });
    window.addEventListener("popstate", function (e) {
        if (e.state) {
            document.getElementById("searchInput").value = e.state.search || "";
            loadBlogs(e.state.page || 1, e.state.search || "");
        }
    });
});

function openSeoModal(id) {
    var d = window._seoData[id];
    if (!d) return;
    var modal = new bootstrap.Modal(document.getElementById("seoModal"));
    var shortName = d.name.length > 45 ? d.name.substring(0, 45) + "..." : d.name;
    document.getElementById("modalTitle").textContent = "SEO Audit: " + shortName;

    var verdicts = {
        "A": "Excellent! Blog is fully optimized for search engines.",
        "B": "Solid SEO. Minor improvements will boost rankings.",
        "C": "Average. Needs focused content & meta improvements.",
        "F": "Poor SEO. Requires a full content & meta overhaul."
    };

    var goodHtml  = d.good.map(g => `<div class="p-2 mb-2 rounded-3 bg-success-subtle text-success-emphasis border border-success-subtle d-flex align-items-start gap-2 small fw-medium"><i class="fa fa-check-circle mt-1 text-success"></i><span>${g}</span></div>`).join("");
    var issueHtml = d.issues.map(i => `<div class="p-2 mb-2 rounded-3 bg-danger-subtle text-danger-emphasis border border-danger-subtle d-flex align-items-start gap-2 small fw-medium"><i class="fa fa-exclamation-circle mt-1 text-danger"></i><span>${i}</span></div>`).join("");

    var rankMap = {"Top 10": 90, "Top 30": 65, "Top 50": 40, "Low": 15};
    var rankPct  = rankMap[d.rank] || 15;
    var rankBg   = rankPct > 60 ? "bg-success"   : (rankPct > 30 ? "bg-warning"   : "bg-danger");
    var rankTxt  = rankPct > 60 ? "text-success" : (rankPct > 30 ? "text-warning" : "text-danger");

    var gradeBg  = d.gradeTextClass.replace("text-", "bg-");

    var tips = [];
    if (!d.tags)     tips.push("Add relevant tags for better search discoverability");
    if (!d.slug)     tips.push("Set a clean URL slug — e.g. \"top-5-steel-grades\"");
    if (!d.category) tips.push("Assign a category to help users navigate related content");
    var tipsHtml = tips.length
        ? "<h6 class=\'text-uppercase fw-bold text-muted small mb-3 mt-4\' style=\'letter-spacing:0.5px;\'>Actionable Advice</h6>"
          + tips.map(t => `<div class="p-2 mb-2 rounded-3 d-flex align-items-start gap-2 small fw-medium border" style="background:var(--blue-subtle);color:var(--blue-dark);border-color:var(--blue-border) !important;"><i class="fa fa-lightbulb mt-1" style="color:var(--blue-primary);"></i><span>${t}</span></div>`).join("")
        : "";

    var searchPreview = d.slug
        ? `<div class="card mb-4 border rounded-3 shadow-none" style="background:#f8f9fa;"><div class="card-body p-3">
            <div class="small text-muted mb-1 font-monospace" style="font-size:0.75rem;">nirajindustries.com › blog › ${d.slug}</div>
            <div class="fs-5 fw-medium mb-1" style="color:#1a0dab;">${d.name}</div>
            <div class="small text-dark" style="line-height:1.4;">${d.category ? d.category : ""} ${d.reading_time ? "· " + d.reading_time + " min read" : ""}</div>
           </div></div>`
        : "";

    document.getElementById("modalBody").innerHTML = `
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 mb-4 shadow-sm rounded-4" style="background:var(--blue-light);">
                    <div class="card-body p-4 d-flex align-items-center gap-4">
                        <div class="position-relative" style="width:86px;height:86px;flex-shrink:0;">
                            <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                                <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e0f2fe" stroke-width="4"></circle>
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
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Views</div><div class="fw-bold text-dark">${d.views.toLocaleString()}</div></div>
                        <div class="border-start border-light"></div>
                        <div><div class="text-muted text-uppercase fw-bold" style="font-size:0.65rem;">Read Time</div><div class="fw-bold text-dark">${d.reading_time || "—"} min</div></div>
                    </div>
                </div>

                <h6 class="text-uppercase fw-bold text-muted small mb-3" style="letter-spacing:0.5px;">Search Preview</h6>
                ${searchPreview}

                <div class="card border border-light shadow-sm bg-white rounded-4">
                    <div class="card-body p-4">
                        <h6 class="text-uppercase fw-bold text-muted small mb-4" style="letter-spacing:0.5px;">Blog Performance</h6>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-dark fw-medium">Published Date</span>
                                <span class="fw-bold" style="color:var(--blue-dark);">${d.published_at}</span>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between small mb-2">
                                <span class="text-dark fw-medium">Ranking Potential</span>
                                <span class="fw-bold ${rankTxt}">${d.rank}</span>
                            </div>
                            <div class="progress rounded-pill" style="height:6px; background:#e0f2fe;">
                                <div class="progress-bar rounded-pill ${rankBg}" style="width:${rankPct}%"></div>
                            </div>
                        </div>
                        ${d.comments ? `<div class="mt-3 small text-muted"><i class="fa fa-comment me-1" style="color:var(--blue-primary);"></i>Comments: <strong>${d.comments}</strong></div>` : ""}
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
                        <a href="${d.editUrl}" class="btn w-100 shadow-sm rounded-pill fw-semibold text-white btn-add-blog">
                            <i class="fa fa-wrench me-2"></i> Fix Issues
                        </a>
                        <a href="${d.viewUrl}" target="_blank" class="btn btn-light w-100 shadow-sm rounded-pill border fw-semibold" style="color:var(--blue-dark);">
                            <i class="fa fa-external-link-alt me-2"></i> View Blog
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