<?php
// admin/blogs/add.php
require_once './../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
requireAccess('blogs');

$errors = [];

// ── Fetch Blog Categories ─────────────────────────────────────
$blogCategories = [];
$catRes = $conn->query("SELECT id, name, slug FROM blog_categories ORDER BY sort_order ASC");
if ($catRes) while ($r = $catRes->fetch_assoc()) $blogCategories[] = $r;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Core Fields ──────────────────────────────────────────────
    $title          = trim($_POST['title']          ?? '');
    $slug           = trim($_POST['slug']           ?? '');
    $excerpt        = trim($_POST['excerpt']        ?? '');
    $content        = $_POST['content']             ?? '';
    $image_alt      = trim($_POST['image_alt']      ?? '');
    $categories = !empty($_POST['categories']) && (int)$_POST['categories'] > 0 
              ? (int)$_POST['categories'] 
              : NULL;
    $tags           = trim($_POST['tags']           ?? '');
    $reading_time   = isset($_POST['reading_time']) ? (int)$_POST['reading_time'] : 0;
    $comments       = isset($_POST['comments'])     ? (int)$_POST['comments']     : 0;
    $is_published   = isset($_POST['is_published']) ? 1 : 0;
    $published_at   = trim($_POST['published_at']   ?? '');
    if (empty($published_at)) $published_at = date('Y-m-d H:i:s');

    // ── SEO Fields ───────────────────────────────────────────────
    $meta_title          = trim($_POST['meta_title']          ?? '');
    $meta_description    = trim($_POST['meta_description']    ?? '');
    $focus_keyword       = trim($_POST['focus_keyword']       ?? '');
    $canonical_url       = trim($_POST['canonical_url']       ?? '');
    $og_title            = trim($_POST['og_title']            ?? '');
    $og_description      = trim($_POST['og_description']      ?? '');
    $og_type             = trim($_POST['og_type']             ?? 'article');
    $twitter_title       = trim($_POST['twitter_title']       ?? '');
    $twitter_description = trim($_POST['twitter_description'] ?? '');
    $twitter_card        = trim($_POST['twitter_card']        ?? 'summary_large_image');
    $robots_index        = trim($_POST['robots_index']        ?? 'index');
    $robots_follow       = trim($_POST['robots_follow']       ?? 'follow');
    $schema_type         = trim($_POST['schema_type']         ?? 'Article');

    // ── Validation ───────────────────────────────────────────────
    if (empty($title))   $errors[] = 'Blog title is required.';
    if (empty($excerpt)) $errors[] = 'Excerpt is required.';
    if (!empty($meta_title) && mb_strlen($meta_title) > 70)
        $errors[] = 'Meta title should not exceed 70 characters.';
    if (!empty($meta_description) && mb_strlen($meta_description) > 180)
        $errors[] = 'Meta description should not exceed 180 characters.';

    // ── Slug Generation ──────────────────────────────────────────
    if (empty($slug)) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
    } else {
        $slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $slug));
    }
    $slug    = trim($slug, '-');
    $slugEsc = $conn->real_escape_string($slug);

    $chk = $conn->query("SELECT id FROM blogs WHERE slug = '$slugEsc'");
    if ($chk && $chk->num_rows > 0) {
        $errors[] = 'Slug already exists. Please use a different one.';
    }

    // ── Auto-fill SEO Defaults ───────────────────────────────────
    if (empty($meta_title))          $meta_title          = $title;
    if (empty($meta_description))    $meta_description    = $excerpt;
    if (empty($og_title))            $og_title            = $meta_title;
    if (empty($og_description))      $og_description      = $meta_description;
    if (empty($twitter_title))       $twitter_title       = $meta_title;
    if (empty($twitter_description)) $twitter_description = $meta_description;

    // ── Auto Reading Time ─────────────────────────────────────────
    if ($reading_time <= 0 && !empty($content)) {
        $wordCount    = str_word_count(strip_tags($content));
        $reading_time = max(1, (int)ceil($wordCount / 200));
    }

    // ── WebP Converter ───────────────────────────────────────────
    function convertToWebp($source, $destination, $quality = 82) {
        $info = @getimagesize($source);
        if (!$info) return false;
        switch ($info['mime']) {
            case 'image/jpeg': $img = imagecreatefromjpeg($source); break;
            case 'image/png':
                $img = imagecreatefrompng($source);
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
                break;
            case 'image/gif':  $img = imagecreatefromgif($source);  break;
            case 'image/webp': $img = imagecreatefromwebp($source); break;
            default: return false;
        }
        $success = imagewebp($img, $destination, $quality);
        imagedestroy($img);
        return $success;
    }

    // ── Image Upload ─────────────────────────────────────────────
    $image    = '';
    $og_image = '';
    $uploadDir = '../../assets/img/blog/';
    if (!empty($_FILES['image']['name'])) {
        $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
        $mime    = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($mime, $allowed)) {
            $errors[] = 'Invalid image type. JPG, PNG, WEBP, GIF only.';
        } elseif ($_FILES['image']['size'] > 3 * 1024 * 1024) {
            $errors[] = 'Image exceeds 3MB limit.';
        } else {
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $fileName  = $slug . '-' . uniqid() . '.webp';
            $targetPath = $uploadDir . $fileName;
            if (convertToWebp($_FILES['image']['tmp_name'], $targetPath, 85)) {
                $image    = 'assets/img/blog/' . $fileName;
                $og_image = $image;
            } else {
                $errors[] = 'Failed to convert image to WebP.';
            }
        }
    }

    // ── Schema JSON ──────────────────────────────────────────────
    $schema_json = '';
    if (!empty($schema_type)) {
        $schemaData = [
            '@context'         => 'https://schema.org',
            '@type'            => $schema_type,
            'headline'         => $title,
            'description'      => $meta_description ?: $excerpt,
            'image'            => $og_image ? (SITE_URL . '/' . $og_image) : '',
            'author'           => ['@type' => 'Organization', 'name' => 'Niraj Industries'],
            'publisher'        => ['@type' => 'Organization', 'name' => 'Niraj Industries'],
            'datePublished'    => $published_at,
            'dateModified'     => date('Y-m-d H:i:s'),
            'url'              => $canonical_url ?: '',
            'keywords'         => $tags,
        ];
        $schema_json = json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // ── Insert ───────────────────────────────────────────────────
    if (empty($errors)) {
        $robots_meta = $robots_index . ',' . $robots_follow;

        $stmt = $conn->prepare("
            INSERT INTO blogs (
                title, slug, excerpt, content,
                image, image_alt, categories, tags,
                views, comments, is_published, published_at, reading_time,
                meta_title, meta_description, focus_keyword, canonical_url,
                og_title, og_description, og_image, og_type,
                twitter_title, twitter_description, twitter_card,
                robots_meta, schema_type, schema_json,
                created_at, updated_at
            ) VALUES (
                ?, ?, ?, ?,
                ?, ?, ?, ?,
                0, ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?, ?,
                ?, ?, ?,
                ?, ?, ?,
                NOW(), NOW()
            )
        ");

        $stmt->bind_param(
            "ssss" . "ssis" . "iiss" . "ssss" . "ssss" . "sss" . "sss",
            $title, $slug, $excerpt, $content,
            $image, $image_alt, $categories, $tags,
            $comments, $is_published, $published_at, $reading_time,
            $meta_title, $meta_description, $focus_keyword, $canonical_url,
            $og_title, $og_description, $og_image, $og_type,
            $twitter_title, $twitter_description, $twitter_card,
            $robots_meta, $schema_type, $schema_json
        );

        if ($stmt->execute()) {
            // Log activity
            $newId     = $conn->insert_id;
            $adminId   = $_ADMIN['id'];
            $detail    = "Blog created: $title";
            $ip        = $_SERVER['REMOTE_ADDR'] ?? '';
            $logStmt   = $conn->prepare("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES (?, 'blog_created', ?, ?, NOW())");
            $logStmt->bind_param("iss", $adminId, $detail, $ip);
            $logStmt->execute();
            $logStmt->close();

            header("Location: ./?msg=added");
            exit;
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
}

// Repopulate helper
$p = fn($k) => htmlspecialchars($_POST[$k] ?? '');

$pageTitle  = 'Add Blog';
$activePage = 'blogs-add';
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
    body, .page-wrapper { background-color: #f0f7ff !important; }

    .form-label {
        font-size: 0.75rem; font-weight: 700; color: #6c757d;
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem;
    }
    .form-control, .form-select {
        font-size: 0.88rem; padding: 0.6rem 1rem;
        border-color: #bae6fd;
        background-color: #f8fcff;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--blue-primary);
        box-shadow: 0 0 0 0.2rem rgba(3,105,161,0.15);
        background-color: #fff;
    }

    .char-counter { display:flex; justify-content:space-between; margin-top:5px; font-size:0.7rem; color:#adb5bd; font-family:monospace; }
    .char-counter .count { font-weight:700; }
    .char-counter .count.ok   { color:#198754; }
    .char-counter .count.warn { color:var(--blue-dark); }
    .char-counter .count.bad  { color:#dc3545; }
    .char-bar { height:4px; background:#e0f2fe; border-radius:4px; margin-top:5px; overflow:hidden; }
    .char-bar-fill { height:100%; border-radius:4px; transition:width .3s, background .3s; }

    /* Image Upload Zone */
    .img-upload-zone {
        border: 2px dashed var(--blue-border);
        border-radius: 0.75rem; padding: 2rem 1rem;
        text-align: center; cursor: pointer;
        transition: all 0.2s; background: var(--blue-light);
    }
    .img-upload-zone:hover { border-color: var(--blue-primary); background: var(--blue-subtle); }
    .img-upload-zone .upload-icon { font-size: 2.5rem; color: var(--blue-primary); margin-bottom: 0.4rem; }
    .img-upload-zone p { font-size: 0.8rem; color: #6c757d; margin: 0; font-weight: 500; }
    .img-upload-zone .preview-img { width:100%; border-radius:0.5rem; object-fit:cover; display:none; margin-top:8px; max-height:220px; }

    /* SERP Preview */
    .serp-preview { background:#fff; border:1px solid #dfe1e5; border-radius:0.5rem; padding:1rem; margin-top:0.25rem; }
    .serp-url   { font-size:0.72rem; color:#202124; font-family:Arial,sans-serif; margin-bottom:2px; }
    .serp-title { font-size:1.1rem; color:#1a0dab; font-family:Arial,sans-serif; line-height:1.3; margin-bottom:2px; }
    .serp-desc  { font-size:0.83rem; color:#4d5156; font-family:Arial,sans-serif; line-height:1.5; }
    .serp-placeholder { color:#9aa0a6 !important; font-style:italic; }

    /* Tabs */
    .nav-pills .nav-link { color:#6c757d; border-radius:20px; font-size:0.83rem; font-weight:600; padding:0.45rem 1rem; transition:all 0.2s; }
    .nav-pills .nav-link.active { background-color:var(--blue-subtle); color:var(--blue-dark); border:1px solid var(--blue-border); }

    /* Schema / Robots */
    .schema-options, .robots-group { display:flex; flex-wrap:wrap; gap:8px; margin-top:6px; }
    .schema-opt, .robots-btn { padding:6px 14px; border-radius:20px; font-size:0.73rem; font-weight:600; cursor:pointer; border:1px solid #bae6fd; color:#6c757d; background:#fff; transition:all 0.15s; flex:1; text-align:center; }
    .schema-opt.active { border-color:var(--blue-primary); color:var(--blue-dark); background:var(--blue-subtle); }
    .robots-btn.active-index, .robots-btn.active-follow { border-color:#198754; color:#198754; background:rgba(25,135,84,0.06); }
    .robots-btn.active-noindex, .robots-btn.active-nofollow { border-color:#dc3545; color:#dc3545; background:rgba(220,53,69,0.06); }

    .form-check-input:checked { background-color:var(--blue-primary); border-color:var(--blue-primary); }
    .card-section-header { border-left:4px solid var(--blue-primary); }

    .btn-save-blog {
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-dark));
        border:none; color:#fff; font-weight:700; transition: all .2s;
    }
    .btn-save-blog:hover { background:linear-gradient(135deg, var(--blue-dark), #023e63); color:#fff; transform:translateY(-1px); box-shadow:0 4px 12px rgba(3,105,161,.4); }

    #seoScoreBadge { transition: all .3s; }

    .page-title-icon {
        width:42px; height:42px;
        background:linear-gradient(135deg, var(--blue-primary), var(--blue-dark));
        border-radius:10px; display:flex; align-items:center; justify-content:center;
        color:#fff; font-size:1.1rem;
    }
    .breadcrumb-item a { color:var(--blue-dark) !important; }

    /* Rich text area */
    #contentEditor { min-height: 320px; }
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
                    <div class="page-title-icon shadow-sm"><i class="fa fa-plus"></i></div>
                    <div>
                        <h3 class="fw-bolder text-dark mb-1">Add Blog</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb small bg-transparent p-0 m-0">
                                <li class="breadcrumb-item"><a href="../" class="text-decoration-none fw-medium">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="./" class="text-decoration-none fw-medium">Blogs</a></li>
                                <li class="breadcrumb-item active text-secondary fw-medium">Add New</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-3 mt-md-0">
                    <a href="./" class="btn btn-light rounded-pill px-4 py-2 shadow-sm fw-semibold border d-inline-flex align-items-center gap-2">
                        <i class="fa fa-arrow-left"></i> Back to Blogs
                    </a>
                </div>
            </div>

            <!-- Errors -->
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger border-0 shadow-sm rounded-4 d-flex align-items-start gap-3 mb-4" role="alert">
                <i class="fa fa-exclamation-triangle mt-1 fs-5"></i>
                <div>
                    <div class="fw-bold mb-1">Please fix the following errors:</div>
                    <ul class="mb-0 ps-3 small">
                        <?php foreach ($errors as $e): ?>
                        <li><?= htmlspecialchars($e) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="blogForm">
                <div class="row g-4">

                    <!-- ── LEFT COLUMN ─────────────────────────────────── -->
                    <div class="col-xl-8 col-lg-7">

                        <!-- ① Basic Info -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--blue-subtle);">
                                    <i class="fa fa-file-alt" style="color:var(--blue-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Blog Information</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Blog Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="blogTitle" class="form-control"
                                            placeholder="e.g. Top 5 High-Strength Steel Grades for Commercial Construction"
                                            value="<?= $p('title') ?>" required>
                                        <div class="char-counter"><span>Title</span><span class="count" id="titleCount">0 chars</span></div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">URL Slug</label>
                                        <div class="input-group">
                                            <input type="text" name="slug" id="blogSlug" class="form-control"
                                                placeholder="auto-from-title" value="<?= $p('slug') ?>">
                                            <button type="button" class="btn btn-light border" id="generateSlug" title="Generate from title">
                                                <i class="fa fa-sync-alt"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted" style="font-size:0.72rem;">Lowercase, hyphens only. e.g. high-strength-steel-grades</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Reading Time (mins)</label>
                                        <input type="number" name="reading_time" class="form-control" min="1"
                                            placeholder="Auto-calculated" value="<?= $p('reading_time') ?>">
                                        <small class="text-muted" style="font-size:0.72rem;">Leave 0 to auto-calculate from content</small>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Excerpt <span class="text-danger">*</span> <small class="text-muted fw-normal text-lowercase">(shown in blog listings)</small></label>
                                        <textarea name="excerpt" id="blogExcerpt" class="form-control" rows="3"
                                            placeholder="A compelling summary that appears in blog listings and search results..."><?= $p('excerpt') ?></textarea>
                                        <div class="char-counter"><span>Ideal: 120–200 chars</span><span class="count" id="excerptCount">0 chars</span></div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Full Content</label>
                                        <textarea name="content" id="contentEditor" class="form-control" rows="14"
                                            placeholder="Write the full blog content here. HTML is supported..."><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                                        <div class="char-counter"><span>Word count</span><span class="count" id="wordCount">0 words</span></div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Image Alt Text</label>
                                        <input type="text" name="image_alt" class="form-control"
                                            placeholder="Descriptive alt text for SEO and accessibility..."
                                            value="<?= $p('image_alt') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tags <small class="text-muted fw-normal text-lowercase">(comma separated)</small></label>
                                        <input type="text" name="tags" class="form-control"
                                            placeholder="steel, construction, nagpur, tmt bars..."
                                            value="<?= $p('tags') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Published At</label>
                                        <input type="datetime-local" name="published_at" class="form-control"
                                            value="<?= $p('published_at') ?: date('Y-m-d\TH:i') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ④ SEO Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between card-section-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--blue-subtle);">
                                        <i class="fa fa-search" style="color:var(--blue-primary);"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">SEO Settings</h6>
                                </div>
                                <span class="badge border rounded-pill px-3 py-1 fw-bold" id="seoScoreBadge"
                                    style="background:var(--blue-subtle); color:var(--blue-dark); border-color:var(--blue-border) !important;">Score: 0 / 100</span>
                            </div>
                            <div class="card-body p-4">

                                <ul class="nav nav-pills mb-4 gap-1 border-bottom pb-3" role="tablist">
                                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-meta" type="button"><i class="fa fa-tag me-1"></i>Meta</button></li>
                                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-og" type="button"><i class="fab fa-facebook me-1"></i>Open Graph</button></li>
                                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-twitter" type="button"><i class="fab fa-twitter me-1"></i>Twitter</button></li>
                                    <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-technical" type="button"><i class="fa fa-code me-1"></i>Technical</button></li>
                                </ul>

                                <div class="tab-content">

                                    <!-- Meta Tab -->
                                    <div class="tab-pane fade show active" id="tab-meta">
                                        <div class="mb-4 p-3 rounded-3" style="background:var(--blue-light); border:1px solid var(--blue-border);">
                                            <label class="form-label" style="color:var(--blue-dark);"><i class="fa fa-key me-1"></i>Focus Keyword</label>
                                            <input type="text" name="focus_keyword" id="focusKeyword" class="form-control fw-bold"
                                                style="background:#f0f9ff; border-color:var(--blue-border); color:var(--blue-dark);"
                                                placeholder="e.g. high strength steel grades nagpur, construction materials..."
                                                value="<?= $p('focus_keyword') ?>">
                                            <small class="text-muted mt-1 d-block" style="font-size:0.72rem;">Primary keyword — used to calculate SEO score in real-time.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title" id="metaTitle" class="form-control"
                                                placeholder="SEO title shown in Google results..."
                                                value="<?= $p('meta_title') ?>" maxlength="70">
                                            <div class="char-bar"><div class="char-bar-fill" id="metaTitleBar" style="width:0%;"></div></div>
                                            <div class="char-counter"><span>Ideal: 50–60 chars</span><span class="count" id="metaTitleCount">0 / 60</span></div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Meta Description</label>
                                            <textarea name="meta_description" id="metaDesc" class="form-control" rows="3"
                                                placeholder="Compelling snippet shown in Google (120–160 chars)..." maxlength="180"><?= $p('meta_description') ?></textarea>
                                            <div class="char-bar"><div class="char-bar-fill" id="metaDescBar" style="width:0%;"></div></div>
                                            <div class="char-counter"><span>Ideal: 120–160 chars</span><span class="count" id="metaDescCount">0 / 160</span></div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Canonical URL</label>
                                            <input type="text" name="canonical_url" class="form-control"
                                                placeholder="https://nirajindustries.com/blog/high-strength-steel-grades"
                                                value="<?= $p('canonical_url') ?>">
                                        </div>
                                        <!-- SERP Preview -->
                                        <div class="mt-3">
                                            <label class="form-label"><i class="fab fa-google text-muted me-1"></i>Google SERP Preview</label>
                                            <div class="serp-preview">
                                                <div class="serp-url">nirajindustries.com › blog › <span id="serpSlug">blog-slug</span></div>
                                                <div class="serp-title" id="serpTitle"><span class="serp-placeholder">Your meta title will appear here...</span></div>
                                                <div class="serp-desc"  id="serpDesc"><span class="serp-placeholder">Your meta description will appear here. Make it compelling to improve click-through rate.</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- OG Tab -->
                                    <div class="tab-pane fade" id="tab-og">
                                        <div class="alert border-0 rounded-3 p-3 mb-4 d-flex gap-2 align-items-center" style="background:var(--blue-subtle); color:var(--blue-dark);">
                                            <i class="fa fa-info-circle"></i>
                                            <small class="fw-medium">Leave blank to auto-inherit from Meta Title / Description on save.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Title</label>
                                            <input type="text" name="og_title" class="form-control" placeholder="Title on Facebook / LinkedIn shares..." value="<?= $p('og_title') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Description</label>
                                            <textarea name="og_description" class="form-control" rows="2" placeholder="Description on social media shares..."><?= $p('og_description') ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Type</label>
                                            <select name="og_type" class="form-select">
                                                <option value="article" <?= ($p('og_type') ?: 'article') === 'article' ? 'selected' : '' ?>>article (Recommended for Blogs)</option>
                                                <option value="website" <?= $p('og_type') === 'website' ? 'selected' : '' ?>>website</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Twitter Tab -->
                                    <div class="tab-pane fade" id="tab-twitter">
                                        <div class="alert border-0 rounded-3 p-3 mb-4 d-flex gap-2 align-items-center" style="background:var(--blue-subtle); color:var(--blue-dark);">
                                            <i class="fa fa-lightbulb"></i>
                                            <small class="fw-medium">Leave blank to auto-inherit from Meta Title / Description on save.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Title</label>
                                            <input type="text" name="twitter_title" class="form-control" placeholder="Title on Twitter card..." value="<?= $p('twitter_title') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Description</label>
                                            <textarea name="twitter_description" class="form-control" rows="3" placeholder="Description on Twitter card..."><?= $p('twitter_description') ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Card Type</label>
                                            <select name="twitter_card" class="form-select">
                                                <option value="summary_large_image" selected>summary_large_image (Recommended)</option>
                                                <option value="summary">summary</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Technical Tab -->
                                    <div class="tab-pane fade" id="tab-technical">
                                        <div class="mb-4">
                                            <label class="form-label">Robots Meta Tag</label>
                                            <div class="row g-2">
                                                <div class="col-6">
                                                    <div class="robots-group" id="robotsIndexGroup">
                                                        <button type="button" class="robots-btn active-index shadow-sm" onclick="setRobots('index',this)">✅ INDEX</button>
                                                        <button type="button" class="robots-btn shadow-sm" onclick="setRobots('noindex',this)">🚫 NOINDEX</button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="robots-group" id="robotsFollowGroup">
                                                        <button type="button" class="robots-btn active-follow shadow-sm" onclick="setFollow('follow',this)">🔗 FOLLOW</button>
                                                        <button type="button" class="robots-btn shadow-sm" onclick="setFollow('nofollow',this)">⛔ NOFOLLOW</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="robots_index"  id="robotsIndex"  value="index">
                                            <input type="hidden" name="robots_follow" id="robotsFollow" value="follow">
                                            <small class="text-success fw-medium mt-2 d-block" id="robotsHint">✅ This page will be indexed and links followed by search engines.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Schema / Structured Data Type</label>
                                            <div class="schema-options">
                                                <?php foreach (['Article','BlogPosting','NewsArticle','WebPage','HowTo'] as $s): ?>
                                                <button type="button" class="schema-opt shadow-sm <?= ($p('schema_type') ?: 'Article') === $s ? 'active' : '' ?>"
                                                    onclick="setSchema('<?= $s ?>',this)"><?= $s ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                            <input type="hidden" name="schema_type" id="schemaType" value="<?= $p('schema_type') ?: 'Article' ?>">
                                            <small class="text-muted mt-2 d-block" style="font-size:0.72rem;">For blogs, <strong>Article</strong> or <strong>BlogPosting</strong> gives the best rich-result coverage in Google.</small>
                                        </div>
                                    </div>

                                </div><!-- /tab-content -->
                            </div>
                        </div>

                    </div><!-- /col-xl-8 -->

                    <!-- ── RIGHT SIDEBAR ───────────────────────────────── -->
                    <div class="col-xl-4 col-lg-5">

                        <!-- Publish Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--blue-subtle);">
                                    <i class="fa fa-paper-plane" style="color:var(--blue-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Publish</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div>
                                        <div class="fw-semibold text-dark small">Publish Blog</div>
                                        <div class="text-muted" style="font-size:0.72rem;">Make this blog visible on the website</div>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="is_published" id="isPublished"
                                            style="width:3rem;height:1.5rem;"
                                            <?= !isset($_POST['is_published']) || !empty($_POST['is_published']) ? 'checked' : '' ?>>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-save-blog w-100 rounded-pill py-2 shadow-sm">
                                    <i class="fa fa-save me-2"></i>Save Blog
                                </button>
                                <a href="./" class="btn btn-light w-100 rounded-pill py-2 fw-semibold border mt-2">
                                    Cancel
                                </a>
                            </div>
                        </div>

                        <!-- Category Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--blue-subtle);">
                                    <i class="fa fa-layer-group" style="color:var(--blue-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Category</h6>
                            </div>
                            <div class="card-body p-4">
                                <label class="form-label">Blog Category</label>
                                <select name="categories" class="form-select">
                                    <option value="0">— Select Category —</option>
                                    <?php foreach ($blogCategories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= (int)($p('categories') ?: 0) === $cat['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted mt-2 d-block" style="font-size:0.72rem;">
                                    Don't see your category?
                                    <a href="../blog-categories/" style="color:var(--blue-primary);">Manage Categories</a>
                                </small>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--blue-subtle);">
                                    <i class="fa fa-camera" style="color:var(--blue-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Featured Image</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="img-upload-zone" id="zone_image" onclick="document.getElementById('input_image').click()">
                                    <div class="upload-icon"><i class="fa fa-image"></i></div>
                                    <p>Click to upload featured image</p>
                                    <small class="text-muted d-block mt-1">JPG, PNG, WEBP — max 3MB<br>Auto-converted to WebP</small>
                                    <img id="preview_image" class="preview-img" alt="Featured image preview">
                                </div>
                                <input type="file" name="image" id="input_image" accept="image/*" class="d-none">
                            </div>
                        </div>

                        <!-- SEO Tips -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 card-section-header">
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">
                                    <i class="fa fa-lightbulb me-2" style="color:var(--blue-primary);"></i>SEO Tips for Blogs
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <ul class="list-unstyled mb-0 small text-muted" style="line-height:2.2;">
                                    <li>✅ Include focus keyword in title & excerpt</li>
                                    <li>✅ Write 800+ words for better rankings</li>
                                    <li>✅ Add relevant tags for discoverability</li>
                                    <li>✅ Use <strong>Article</strong> or <strong>BlogPosting</strong> schema</li>
                                    <li>✅ Clean slug: <code>top-5-steel-grades</code></li>
                                    <li>✅ Upload a high-quality featured image</li>
                                    <li>✅ Fill meta description (120–160 chars)</li>
                                    <li>✅ Set correct published date for freshness</li>
                                </ul>
                            </div>
                        </div>

                    </div><!-- /col-xl-4 -->

                </div><!-- /row -->
            </form>

        </div>
    </div>
</div>

<script>
// ── Title → Slug ──────────────────────────────────────────────
document.getElementById('blogTitle').addEventListener('input', function () {
    document.getElementById('titleCount').textContent = this.value.length + ' chars';
    if (!document.getElementById('blogSlug').dataset.edited) {
        document.getElementById('blogSlug').value = autoSlug(this.value);
        document.getElementById('serpSlug').textContent = autoSlug(this.value) || 'blog-slug';
    }
});
document.getElementById('generateSlug').addEventListener('click', function () {
    const slug = autoSlug(document.getElementById('blogTitle').value);
    document.getElementById('blogSlug').value = slug;
    document.getElementById('blogSlug').dataset.edited = '';
    document.getElementById('serpSlug').textContent = slug || 'blog-slug';
});
document.getElementById('blogSlug').addEventListener('input', function () {
    this.dataset.edited = '1';
    document.getElementById('serpSlug').textContent = this.value || 'blog-slug';
});
function autoSlug(str) {
    return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
}

// ── Excerpt Counter ───────────────────────────────────────────
document.getElementById('blogExcerpt').addEventListener('input', function () {
    const c = document.getElementById('excerptCount');
    c.textContent = this.value.length + ' chars';
    c.className   = 'count ' + (this.value.length <= 200 ? 'ok' : 'warn');
});

// ── Word Count ────────────────────────────────────────────────
document.getElementById('contentEditor').addEventListener('input', function () {
    const words = this.value.trim() ? this.value.trim().split(/\s+/).length : 0;
    const c = document.getElementById('wordCount');
    c.textContent = words + ' words';
    c.className   = 'count ' + (words >= 800 ? 'ok' : words >= 300 ? 'warn' : 'bad');
    calcSeoScore();
});

// ── Meta Char Counters ────────────────────────────────────────
function setupCharCounter(inputId, countId, barId, max) {
    const el  = document.getElementById(inputId);
    const cnt = document.getElementById(countId);
    const bar = barId ? document.getElementById(barId) : null;
    if (!el) return;
    el.addEventListener('input', function () {
        const len = this.value.length;
        const pct = Math.min((len / max) * 100, 100);
        cnt.textContent = len + ' / ' + max;
        cnt.className   = 'count ' + (len < max * 0.7 ? 'ok' : len <= max ? 'warn' : 'bad');
        if (bar) {
            bar.style.width      = pct + '%';
            bar.style.background = len < max * 0.7 ? '#198754' : len <= max ? '#0369a1' : '#dc3545';
        }
        if (inputId === 'metaTitle') {
            const t = document.getElementById('serpTitle');
            t.innerHTML = this.value ? this.value : '<span class="serp-placeholder">Your meta title will appear here...</span>';
        }
        if (inputId === 'metaDesc') {
            const d = document.getElementById('serpDesc');
            d.innerHTML = this.value ? this.value : '<span class="serp-placeholder">Your meta description will appear here.</span>';
        }
    });
}
setupCharCounter('metaTitle', 'metaTitleCount', 'metaTitleBar', 60);
setupCharCounter('metaDesc',  'metaDescCount',  'metaDescBar',  160);

// ── SEO Score ─────────────────────────────────────────────────
function calcSeoScore() {
    let score = 0;
    const title    = document.getElementById('blogTitle').value.trim();
    const excerpt  = document.getElementById('blogExcerpt').value.trim();
    const keyword  = document.getElementById('focusKeyword').value.trim();
    const metaT    = document.getElementById('metaTitle').value.trim();
    const metaD    = document.getElementById('metaDesc').value.trim();
    const slug     = document.getElementById('blogSlug').value.trim();
    const content  = document.getElementById('contentEditor').value.trim();
    const words    = content ? content.split(/\s+/).length : 0;

    if (title)   score += 15;
    if (excerpt) score += 15;
    if (keyword) score += 20;
    if (metaT)   score += 15;
    if (metaD)   score += 15;
    if (slug)    score += 10;
    if (words >= 800) score += 10;

    const badge = document.getElementById('seoScoreBadge');
    badge.textContent = 'Score: ' + score + ' / 100';
    if (score >= 80) {
        badge.style.background = '#d1e7dd'; badge.style.color = '#0a3622'; badge.style.borderColor = '#badbcc';
    } else if (score >= 50) {
        badge.style.background = '#cff4fc'; badge.style.color = '#055160'; badge.style.borderColor = '#b6effb';
    } else {
        badge.style.background = '#f8d7da'; badge.style.color = '#58151c'; badge.style.borderColor = '#f5c2c7';
    }
}
['blogTitle','blogExcerpt','focusKeyword','metaTitle','metaDesc','blogSlug'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', calcSeoScore);
});

// ── Image Preview ─────────────────────────────────────────────
document.getElementById('input_image').addEventListener('change', function () {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        const zone    = document.getElementById('zone_image');
        const preview = document.getElementById('preview_image');
        preview.src   = e.target.result;
        preview.style.display = 'block';
        zone.querySelectorAll('.upload-icon, p, small').forEach(el => el.style.display = 'none');
    };
    reader.readAsDataURL(file);
});

// ── Robots ────────────────────────────────────────────────────
function setRobots(val, btn) {
    document.querySelectorAll('#robotsIndexGroup .robots-btn').forEach(b => b.className = 'robots-btn shadow-sm');
    btn.classList.add(val === 'index' ? 'active-index' : 'active-noindex');
    document.getElementById('robotsIndex').value = val;
    updateRobotsHint();
}
function setFollow(val, btn) {
    document.querySelectorAll('#robotsFollowGroup .robots-btn').forEach(b => b.className = 'robots-btn shadow-sm');
    btn.classList.add(val === 'follow' ? 'active-follow' : 'active-nofollow');
    document.getElementById('robotsFollow').value = val;
    updateRobotsHint();
}
function updateRobotsHint() {
    const i = document.getElementById('robotsIndex').value;
    const f = document.getElementById('robotsFollow').value;
    const h = document.getElementById('robotsHint');
    const ok = i === 'index' && f === 'follow';
    h.className   = (ok ? 'text-success' : 'text-danger') + ' fw-medium mt-2 d-block small';
    h.textContent = ok ? '✅ This page will be indexed and links followed by search engines.'
                       : '⚠️ This page is restricted from indexing or link-following.';
}

// ── Schema ────────────────────────────────────────────────────
function setSchema(val, btn) {
    document.querySelectorAll('.schema-opt').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('schemaType').value = val;
}
</script>

<?php require_once '../include/footer.php'; ?>