<?php
// admin/services/edit.php
require_once './../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
requireAccess('services');

$id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$res = $conn->query("SELECT * FROM mosquito_services WHERE id = $id");
$service = $res ? $res->fetch_assoc() : null;
if (!$service) { header("Location: ./"); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Core Fields ──────────────────────────────────────────────
    $title             = trim($_POST['title']             ?? '');
    $slug              = trim($_POST['slug']              ?? '');
    $short_desc        = trim($_POST['short_desc']        ?? '');
    $description       = trim($_POST['description']       ?? '');
    $extra_block_title = trim($_POST['extra_block_title'] ?? '');
    $extra_block_desc  = trim($_POST['extra_block_desc']  ?? '');
    $is_active         = isset($_POST['is_active']) ? 1 : 0;

    // ── JSON Fields ──────────────────────────────────────────────
    $services_raw  = array_filter(array_map('trim', explode("\n", $_POST['services_list']  ?? '')));
    $services_list = json_encode(array_values($services_raw));

    $features_raw  = array_filter(array_map('trim', explode("\n", $_POST['features_list']  ?? '')));
    $features_list = json_encode(array_values($features_raw));

    $why_raw         = array_filter(array_map('trim', explode("\n", $_POST['why_choose_list'] ?? '')));
    $why_choose_list = json_encode(array_values($why_raw));

    $faqs_raw = array_filter(array_map('trim', explode("\n", $_POST['faqs'] ?? '')));
    $faqs_arr = [];
    foreach ($faqs_raw as $line) {
        $parts = explode('|', $line, 2);
        if (count($parts) === 2 && !empty(trim($parts[0]))) {
            $faqs_arr[] = ['question' => trim($parts[0]), 'answer' => trim($parts[1])];
        }
    }
    $faqs = json_encode($faqs_arr);

    // ── Testimonial ──────────────────────────────────────────────
    $testimonial_text = trim($_POST['testimonial_text'] ?? '');
    $testimonial_name = trim($_POST['testimonial_name'] ?? '');
    $testimonial_role = trim($_POST['testimonial_role'] ?? '');

    // ── SEO Fields ───────────────────────────────────────────────
    $meta_title          = trim($_POST['meta_title']          ?? '');
    $meta_description    = trim($_POST['meta_description']    ?? '');
    $focus_keyword       = trim($_POST['focus_keyword']       ?? '');
    $canonical_url       = trim($_POST['canonical_url']       ?? '');
    $og_title            = trim($_POST['og_title']            ?? '');
    $og_description      = trim($_POST['og_description']      ?? '');
    $og_type             = trim($_POST['og_type']             ?? 'product');
    $twitter_title       = trim($_POST['twitter_title']       ?? '');
    $twitter_description = trim($_POST['twitter_description'] ?? '');
    $twitter_card        = trim($_POST['twitter_card']        ?? 'summary_large_image');
    $robots_index        = trim($_POST['robots_index']        ?? 'index');
    $robots_follow       = trim($_POST['robots_follow']       ?? 'follow');
    $schema_type         = trim($_POST['schema_type']         ?? 'Product');

    // ── Validation ───────────────────────────────────────────────
    if (empty($title))      $errors[] = 'Service title is required.';
    if (empty($short_desc)) $errors[] = 'Short description is required.';
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

    // Same slug allowed for current record
    $chk = $conn->query("SELECT id FROM mosquito_services WHERE slug = '$slugEsc' AND id != $id");
    if ($chk && $chk->num_rows > 0) {
        $errors[] = 'Slug already exists. Please use a different slug.';
    }

    // ── SEO Auto-fill Defaults ───────────────────────────────────
    if (empty($meta_title))          $meta_title          = $title;
    if (empty($meta_description))    $meta_description    = $short_desc;
    if (empty($og_title))            $og_title            = $meta_title;
    if (empty($og_description))      $og_description      = $meta_description;
    if (empty($twitter_title))       $twitter_title       = $meta_title;
    if (empty($twitter_description)) $twitter_description = $meta_description;

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
        $ok = imagewebp($img, $destination, $quality);
        imagedestroy($img);
        return $ok;
    }

    $uploadDir = '../../assets/img/services/';

    // ── Main Image Upload ────────────────────────────────────────
   $banner_image = $service['banner_image'] ?? '';
$og_image     = $service['og_image']     ?? '';
if (!empty($_FILES['banner_image']['name'])) {
    $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
    $mime    = mime_content_type($_FILES['banner_image']['tmp_name']);
    if (!in_array($mime, $allowed)) {
        $errors[] = 'Invalid banner image type.';
    } elseif ($_FILES['banner_image']['size'] > 3 * 1024 * 1024) {
        $errors[] = 'Banner image exceeds 3MB.';
    } else {
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName   = $slug . '-banner-' . uniqid() . '.webp';
        $targetPath = $uploadDir . $fileName;
        if (convertToWebp($_FILES['banner_image']['tmp_name'], $targetPath, 85)) {
            if (!empty($banner_image)) { $old = '../../' . ltrim($banner_image, '/'); if (file_exists($old)) @unlink($old); }
            $banner_image = 'assets/img/services/' . $fileName;
            $og_image     = $banner_image;
        } else {
            $errors[] = 'Failed to convert banner image to WebP.';
        }
    }
}

$focus_image = $service['focus_image'] ?? '';
if (!empty($_FILES['focus_image']['name'])) {
    $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
    $mime    = mime_content_type($_FILES['focus_image']['tmp_name']);
    if (!in_array($mime, $allowed)) {
        $errors[] = 'Invalid focus image type.';
    } elseif ($_FILES['focus_image']['size'] > 3 * 1024 * 1024) {
        $errors[] = 'Focus image exceeds 3MB.';
    } else {
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName   = $slug . '-focus-' . uniqid() . '.webp';
        $targetPath = $uploadDir . $fileName;
        if (convertToWebp($_FILES['focus_image']['tmp_name'], $targetPath, 85)) {
            if (!empty($focus_image)) { $old = '../../' . ltrim($focus_image, '/'); if (file_exists($old)) @unlink($old); }
            $focus_image = 'assets/img/services/' . $fileName;
        } else {
            $errors[] = 'Failed to convert focus image to WebP.';
        }
    }
}

$faq_image = $service['faq_image'] ?? '';
if (!empty($_FILES['faq_image']['name'])) {
    $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
    $mime    = mime_content_type($_FILES['faq_image']['tmp_name']);
    if (!in_array($mime, $allowed)) {
        $errors[] = 'Invalid FAQ image type.';
    } elseif ($_FILES['faq_image']['size'] > 3 * 1024 * 1024) {
        $errors[] = 'FAQ image exceeds 3MB.';
    } else {
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName   = $slug . '-faq-' . uniqid() . '.webp';
        $targetPath = $uploadDir . $fileName;
        if (convertToWebp($_FILES['faq_image']['tmp_name'], $targetPath, 85)) {
            if (!empty($faq_image)) { $old = '../../' . ltrim($faq_image, '/'); if (file_exists($old)) @unlink($old); }
            $faq_image = 'assets/img/services/' . $fileName;
        } else {
            $errors[] = 'Failed to convert FAQ image to WebP.';
        }
    }
}

    // ── Schema JSON ──────────────────────────────────────────────
    $schema_json = '';
    if (!empty($schema_type)) {
        $schemaData = [
            '@context'    => 'https://schema.org',
            '@type'       => $schema_type,
            'name'        => $title,
            'description' => $meta_description ?: $short_desc,
            'image'       => $og_image ? (SITE_URL . '/' . $og_image) : '',
            'provider'    => ['@type' => 'Organization', 'name' => 'Saagar Mosquito Net'],
            'url'         => $canonical_url ?: '',
            'keywords'    => $focus_keyword,
        ];
        $schema_json = json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // ── Update ───────────────────────────────────────────────────
    if (empty($errors)) {
        $robots_meta = $robots_index . ',' . $robots_follow;

      $stmt = $conn->prepare("
    UPDATE mosquito_services SET
        title=?, slug=?, short_desc=?, description=?,
        banner_image=?, focus_image=?, faq_image=?,
        services_list=?, features_list=?, why_choose_list=?, faqs=?,
        extra_block_title=?, extra_block_desc=?,
        testimonial_text=?, testimonial_name=?, testimonial_role=?, testimonial_image=?,
        is_active=?,
        meta_title=?, meta_description=?, focus_keyword=?, canonical_url=?,
        og_title=?, og_description=?, og_image=?, og_type=?,
        twitter_title=?, twitter_description=?, twitter_card=?,
        robots_meta=?, schema_type=?, schema_json=?,
        updated_at=NOW()
    WHERE id=?
");

$stmt->bind_param(
    "ssss" . "sss" . "ssss" . "ss" . "ssss" . "i" . "ssss" . "ssss" . "sss" . "sss" . "i",
    $title, $slug, $short_desc, $description,
    $banner_image, $focus_image, $faq_image,
    $services_list, $features_list, $why_choose_list, $faqs,
    $extra_block_title, $extra_block_desc,
    $testimonial_text, $testimonial_name, $testimonial_role, $testimonial_image,
    $is_active,
    $meta_title, $meta_description, $focus_keyword, $canonical_url,
    $og_title, $og_description, $og_image, $og_type,
    $twitter_title, $twitter_description, $twitter_card,
    $robots_meta, $schema_type, $schema_json,
    $id
);

        if ($stmt->execute()) {
            // ── Activity Log ──────────────────────────────────────
            $adminId = $_ADMIN['id'];
            $detail  = "Service updated: $title";
            $ip      = $_SERVER['REMOTE_ADDR'] ?? '';
            $logStmt = $conn->prepare("INSERT INTO admin_activity_log (user_id, action, detail, ip, created_at) VALUES (?, 'service_updated', ?, ?, NOW())");
            $logStmt->bind_param("iss", $adminId, $detail, $ip);
            $logStmt->execute();
            $logStmt->close();

            header("Location: ./?msg=updated");
            exit;
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }

} else {
    // ── Pre-fill from DB on GET ───────────────────────────────────
    $_POST = $service;
    // Convert JSON arrays back to textarea format
    $_POST['services_list']  = implode("\n", json_decode($service['services_list']  ?? '[]', true) ?: []);
    $_POST['features_list']  = implode("\n", json_decode($service['features_list']  ?? '[]', true) ?: []);
    $_POST['why_choose_list']= implode("\n", json_decode($service['why_choose_list']?? '[]', true) ?: []);
    // FAQs: convert back to question|answer format
    $faqsDecoded = json_decode($service['faqs'] ?? '[]', true) ?: [];
    $_POST['faqs'] = implode("\n", array_map(fn($f) => ($f['question'] ?? '') . '|' . ($f['answer'] ?? ''), $faqsDecoded));
}

// ── Helpers ───────────────────────────────────────────────────
$p = fn($k) => htmlspecialchars($_POST[$k] ?? $service[$k] ?? '');

// Current robots
$robotsParts   = explode(',', $service['robots_meta'] ?? 'index,follow');
$currentIndex  = trim($robotsParts[0] ?? 'index');
$currentFollow = trim($robotsParts[1] ?? 'follow');

// Current image URLs
$bannerImgUrl = '';
$focusImgUrl  = '';
$faqImgUrl    = '';
$testImgUrl   = '';
if (!empty($service['banner_image']))
    $bannerImgUrl = str_contains($service['banner_image'], 'http') ? $service['banner_image'] : SITE_URL . '/' . ltrim($service['banner_image'], '/');
if (!empty($service['focus_image']))
    $focusImgUrl  = str_contains($service['focus_image'], 'http') ? $service['focus_image'] : SITE_URL . '/' . ltrim($service['focus_image'], '/');
if (!empty($service['faq_image']))
    $faqImgUrl    = str_contains($service['faq_image'], 'http') ? $service['faq_image'] : SITE_URL . '/' . ltrim($service['faq_image'], '/');
if (!empty($service['testimonial_image']))
    $testImgUrl   = str_contains($service['testimonial_image'], 'http') ? $service['testimonial_image'] : SITE_URL . '/' . ltrim($service['testimonial_image'], '/');

$pageTitle  = 'Edit Service — ' . htmlspecialchars($service['title']);
$activePage = 'services-edit';
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
    body, .page-wrapper { background-color: #f0fdf7 !important; }
    .form-label { font-size:0.75rem; font-weight:700; color:#6c757d; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:0.4rem; }
    .form-control, .form-select { font-size:0.88rem; padding:0.6rem 1rem; border-color:var(--green-border); background-color:#f8fffe; }
    .form-control:focus, .form-select:focus { border-color:var(--green-primary); box-shadow:0 0 0 0.2rem rgba(22,163,74,0.15); background-color:#fff; }
    .char-counter { display:flex; justify-content:space-between; margin-top:5px; font-size:0.7rem; color:#adb5bd; font-family:monospace; }
    .char-counter .count { font-weight:700; }
    .char-counter .count.ok   { color:#16a34a; }
    .char-counter .count.warn { color:#ca8a04; }
    .char-counter .count.bad  { color:#dc3545; }
    .char-bar { height:4px; background:#dcfce7; border-radius:4px; margin-top:5px; overflow:hidden; }
    .char-bar-fill { height:100%; border-radius:4px; transition:width .3s, background .3s; }
    .img-upload-zone { border:2px dashed var(--green-border); border-radius:0.75rem; padding:1.5rem 1rem; text-align:center; cursor:pointer; transition:all 0.2s; background:var(--green-light); }
    .img-upload-zone:hover { border-color:var(--green-primary); background:var(--green-subtle); }
    .img-upload-zone .upload-icon { font-size:1.8rem; color:var(--green-primary); margin-bottom:0.4rem; }
    .img-upload-zone p { font-size:0.8rem; color:#6c757d; margin:0; font-weight:500; }
    .preview-img { width:100%; border-radius:0.5rem; object-fit:cover; display:none; margin-top:8px; max-height:200px; }
    .current-thumb { width:100%; max-height:200px; border-radius:0.6rem; object-fit:cover; border:3px solid var(--green-border); }
    .serp-preview { background:#fff; border:1px solid #dfe1e5; border-radius:0.5rem; padding:1rem; margin-top:0.25rem; }
    .serp-url   { font-size:0.72rem; color:#202124; font-family:Arial,sans-serif; margin-bottom:2px; }
    .serp-title { font-size:1.1rem; color:#1a0dab; font-family:Arial,sans-serif; line-height:1.3; margin-bottom:2px; }
    .serp-desc  { font-size:0.83rem; color:#4d5156; font-family:Arial,sans-serif; line-height:1.5; }
    .serp-placeholder { color:#9aa0a6 !important; font-style:italic; }
    .nav-pills .nav-link { color:#6c757d; border-radius:20px; font-size:0.83rem; font-weight:600; padding:0.45rem 1rem; transition:all 0.2s; }
    .nav-pills .nav-link.active { background-color:var(--green-subtle); color:var(--green-dark); border:1px solid var(--green-border); }
    .schema-options, .robots-group { display:flex; flex-wrap:wrap; gap:8px; margin-top:6px; }
    .schema-opt, .robots-btn { padding:6px 14px; border-radius:20px; font-size:0.73rem; font-weight:600; cursor:pointer; border:1px solid var(--green-border); color:#6c757d; background:#fff; transition:all 0.15s; flex:1; text-align:center; }
    .schema-opt.active { border-color:var(--green-primary); color:var(--green-dark); background:var(--green-subtle); }
    .robots-btn.active-index, .robots-btn.active-follow   { border-color:#16a34a; color:#16a34a; background:rgba(22,163,74,0.06); }
    .robots-btn.active-noindex, .robots-btn.active-nofollow { border-color:#dc3545; color:#dc3545; background:rgba(220,53,69,0.06); }
    .form-check-input:checked { background-color:var(--green-primary); border-color:var(--green-primary); }
    .card-section-header { border-left:4px solid var(--green-primary); }
    .btn-save-service { background:linear-gradient(135deg,var(--green-primary),var(--green-dark)); border:none; color:#fff; font-weight:700; transition:all .2s; }
    .btn-save-service:hover { background:linear-gradient(135deg,var(--green-dark),#0f5c2e); color:#fff; transform:translateY(-1px); box-shadow:0 4px 12px rgba(22,163,74,.4); }
    .page-title-icon { width:42px; height:42px; background:linear-gradient(135deg,var(--green-primary),var(--green-dark)); border-radius:10px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:1.1rem; }
    .breadcrumb-item a { color:var(--green-dark) !important; }
    .json-hint { font-size:0.7rem; color:#6c757d; background:#f8f9fa; border-radius:6px; padding:6px 10px; margin-top:5px; border-left:3px solid var(--green-border); }
    textarea.list-input { font-family:monospace; font-size:0.82rem; }
    #seoScoreBadge { transition:all .3s; }
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
                    <div class="page-title-icon shadow-sm"><i class="fa fa-edit"></i></div>
                    <div>
                        <h3 class="fw-bolder text-dark mb-1">Edit Service</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb small bg-transparent p-0 m-0">
                                <li class="breadcrumb-item"><a href="../" class="text-decoration-none fw-medium">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="./" class="text-decoration-none fw-medium">Services</a></li>
                                <li class="breadcrumb-item active text-secondary fw-medium"><?= htmlspecialchars($service['title']) ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <a href="<?= SITE_URL ?>/service-details.php?slug=<?= htmlspecialchars($service['slug']) ?>" target="_blank"
                       class="btn btn-light rounded-pill px-4 py-2 shadow-sm fw-semibold border d-inline-flex align-items-center gap-2">
                        <i class="fa fa-external-link-alt"></i> View Service
                    </a>
                    <a href="./" class="btn btn-light rounded-pill px-4 py-2 shadow-sm fw-semibold border d-inline-flex align-items-center gap-2">
                        <i class="fa fa-arrow-left"></i> Back
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

            <form method="POST" enctype="multipart/form-data" id="serviceForm">
                <div class="row g-4">

                    <!-- ── LEFT COLUMN ─────────────────────────────────── -->
                    <div class="col-xl-8 col-lg-7">

                        <!-- ① Basic Info -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
                                    <i class="fa fa-concierge-bell" style="color:var(--green-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Service Information</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Service Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="serviceTitle" class="form-control"
                                               value="<?= $p('title') ?>" required>
                                        <div class="char-counter"><span>Title length</span><span class="count" id="titleCount"><?= mb_strlen($service['title']) ?> chars</span></div>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">URL Slug</label>
                                        <div class="input-group">
                                            <input type="text" name="slug" id="serviceSlug" class="form-control"
                                                   value="<?= $p('slug') ?>">
                                            <button type="button" class="btn btn-light border" id="generateSlug" title="Re-generate from title">
                                                <i class="fa fa-sync-alt"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted" style="font-size:0.72rem;">⚠️ Changing slug will break existing links to this service.</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Status</label>
                                        <div class="mt-2 d-flex align-items-center gap-2">
                                            <div class="form-check form-switch mb-0">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                                       style="width:3rem;height:1.5rem;"
                                                       <?= $service['is_active'] ? 'checked' : '' ?>>
                                            </div>
                                            <label class="form-check-label fw-semibold small" for="isActive">Active</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Short Description <span class="text-danger">*</span></label>
                                        <textarea name="short_desc" id="serviceShortDesc" class="form-control" rows="3"><?= $p('short_desc') ?></textarea>
                                        <div class="char-counter"><span>Ideal: 100–200 chars</span><span class="count" id="shortDescCount"><?= mb_strlen($service['short_desc'] ?? '') ?> chars</span></div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Full Description</label>
                                        <textarea name="description" id="serviceDesc" class="form-control" rows="8"><?= htmlspecialchars($_POST['description'] ?? $service['description'] ?? '') ?></textarea>
                                        <div class="char-counter"><span>Word count</span><span class="count" id="wordCount">0 words</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ② Lists -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
                                    <i class="fa fa-list-ul" style="color:var(--green-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Lists & Points</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Our Services List</label>
                                        <textarea name="services_list" class="form-control list-input" rows="8"><?= $p('services_list') ?></textarea>
                                        <div class="json-hint">📌 One item per line</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Key Features List</label>
                                        <textarea name="features_list" class="form-control list-input" rows="8"><?= $p('features_list') ?></textarea>
                                        <div class="json-hint">📌 One item per line</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Why Choose Us List</label>
                                        <textarea name="why_choose_list" class="form-control list-input" rows="8"><?= $p('why_choose_list') ?></textarea>
                                        <div class="json-hint">📌 One item per line</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ③ FAQs -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
                                    <i class="fa fa-question-circle" style="color:var(--green-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">FAQs</h6>
                            </div>
                            <div class="card-body p-4">
                                <textarea name="faqs" class="form-control list-input" rows="8"><?= $p('faqs') ?></textarea>
                                <div class="json-hint">📌 Format: <strong>Question|Answer</strong> — one FAQ per line</div>
                            </div>
                        </div>

                        <!-- ④ Extra Block -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
                                    <i class="fa fa-plus-square" style="color:var(--green-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Extra Block <span class="text-muted fw-normal text-lowercase">(optional)</span></h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Extra Block Title</label>
                                        <input type="text" name="extra_block_title" class="form-control" value="<?= $p('extra_block_title') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Extra Block Description</label>
                                        <textarea name="extra_block_desc" class="form-control" rows="4"><?= $p('extra_block_desc') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ⑤ Testimonial -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
                                    <i class="fa fa-quote-left" style="color:var(--green-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Testimonial <span class="text-muted fw-normal text-lowercase">(optional)</span></h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Testimonial Text</label>
                                        <textarea name="testimonial_text" class="form-control" rows="3"><?= $p('testimonial_text') ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Customer Name</label>
                                        <input type="text" name="testimonial_name" class="form-control" value="<?= $p('testimonial_name') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Customer Role / Location</label>
                                        <input type="text" name="testimonial_role" class="form-control" value="<?= $p('testimonial_role') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Testimonial Photo</label>
                                        <?php if ($testImgUrl): ?>
                                        <div class="mb-2 text-center">
                                            <img src="<?= htmlspecialchars($testImgUrl) ?>" id="currentTestImg" class="current-thumb shadow-sm" style="max-height:120px;width:120px;border-radius:50%;" alt="Current testimonial photo">
                                            <div class="text-muted mt-1" style="font-size:0.7rem;">Current Photo</div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="img-upload-zone" id="zone_testimonial" onclick="document.getElementById('input_testimonial').click()">
                                            <div class="upload-icon" id="uploadIcon_test"><i class="fa fa-user-circle"></i></div>
                                            <p id="uploadLabel_test">Click to replace customer photo</p>
                                            <small class="text-muted d-block mt-1" id="uploadHint_test">JPG, PNG, WEBP — max 2MB · Auto-converted to WebP</small>
                                            <img id="preview_testimonial" class="preview-img" alt="Testimonial photo preview">
                                        </div>
                                        <input type="file" name="testimonial_image" id="input_testimonial" accept="image/*" class="d-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ⑥ SEO Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between card-section-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
                                        <i class="fa fa-search" style="color:var(--green-primary);"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">SEO Settings</h6>
                                </div>
                                <span class="badge border rounded-pill px-3 py-1 fw-bold" id="seoScoreBadge"
                                      style="background:var(--green-subtle); color:var(--green-dark); border-color:var(--green-border) !important;">Score: 0 / 100</span>
                            </div>
                            <div class="card-body p-4">
                                <ul class="nav nav-pills mb-4 gap-1 border-bottom pb-3" role="tablist">
                                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-meta"      type="button"><i class="fa fa-tag me-1"></i>Meta</button></li>
                                    <li class="nav-item"><button class="nav-link"        data-bs-toggle="pill" data-bs-target="#tab-og"        type="button"><i class="fab fa-facebook me-1"></i>Open Graph</button></li>
                                    <li class="nav-item"><button class="nav-link"        data-bs-toggle="pill" data-bs-target="#tab-twitter"   type="button"><i class="fab fa-twitter me-1"></i>Twitter</button></li>
                                    <li class="nav-item"><button class="nav-link"        data-bs-toggle="pill" data-bs-target="#tab-technical" type="button"><i class="fa fa-code me-1"></i>Technical</button></li>
                                </ul>
                                <div class="tab-content">

                                    <!-- Meta Tab -->
                                    <div class="tab-pane fade show active" id="tab-meta">
                                        <div class="mb-4 p-3 rounded-3" style="background:var(--green-light); border:1px solid var(--green-border);">
                                            <label class="form-label" style="color:var(--green-dark);"><i class="fa fa-key me-1"></i>Focus Keyword</label>
                                            <input type="text" name="focus_keyword" id="focusKeyword" class="form-control fw-bold"
                                                   style="background:#f0fdf4; border-color:var(--green-border); color:var(--green-dark);"
                                                   value="<?= $p('focus_keyword') ?>">
                                            <small class="text-muted mt-1 d-block" style="font-size:0.72rem;">Primary keyword — SEO score calculator.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Meta Title</label>
                                            <input type="text" name="meta_title" id="metaTitle" class="form-control"
                                                   value="<?= $p('meta_title') ?>" maxlength="70">
                                            <div class="char-bar"><div class="char-bar-fill" id="metaTitleBar" style="width:0%;"></div></div>
                                            <div class="char-counter"><span>Ideal: 50–60 chars</span><span class="count" id="metaTitleCount">0 / 60</span></div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Meta Description</label>
                                            <textarea name="meta_description" id="metaDesc" class="form-control" rows="3" maxlength="180"><?= $p('meta_description') ?></textarea>
                                            <div class="char-bar"><div class="char-bar-fill" id="metaDescBar" style="width:0%;"></div></div>
                                            <div class="char-counter"><span>Ideal: 120–160 chars</span><span class="count" id="metaDescCount">0 / 160</span></div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Canonical URL</label>
                                            <input type="text" name="canonical_url" class="form-control" value="<?= $p('canonical_url') ?>">
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label"><i class="fab fa-google text-muted me-1"></i>Google SERP Preview</label>
                                            <div class="serp-preview">
                                                <div class="serp-url">saagarnet.com › service-details › <span id="serpSlug"><?= htmlspecialchars($service['slug'] ?? '') ?></span></div>
                                                <div class="serp-title" id="serpTitle">
                                                    <?php if (!empty($service['meta_title'])): ?>
                                                        <?= htmlspecialchars($service['meta_title']) ?>
                                                    <?php else: ?>
                                                        <span class="serp-placeholder">Your meta title will appear here...</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="serp-desc" id="serpDesc">
                                                    <?php if (!empty($service['meta_description'])): ?>
                                                        <?= htmlspecialchars($service['meta_description']) ?>
                                                    <?php else: ?>
                                                        <span class="serp-placeholder">Your meta description will appear here.</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- OG Tab -->
                                    <div class="tab-pane fade" id="tab-og">
                                        <div class="alert border-0 rounded-3 p-3 mb-4 d-flex gap-2 align-items-center" style="background:var(--green-subtle); color:var(--green-dark);">
                                            <i class="fa fa-info-circle"></i>
                                            <small class="fw-medium">Leave blank to auto-inherit from Meta Title / Description on save.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Title</label>
                                            <input type="text" name="og_title" class="form-control" value="<?= $p('og_title') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Description</label>
                                            <textarea name="og_description" class="form-control" rows="2"><?= $p('og_description') ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Type</label>
                                            <select name="og_type" class="form-select">
                                                <option value="product"  <?= ($p('og_type') ?: 'product') === 'product'  ? 'selected' : '' ?>>product (Recommended)</option>
                                                <option value="website"  <?= $p('og_type') === 'website'  ? 'selected' : '' ?>>website</option>
                                                <option value="article"  <?= $p('og_type') === 'article'  ? 'selected' : '' ?>>article</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Twitter Tab -->
                                    <div class="tab-pane fade" id="tab-twitter">
                                        <div class="alert border-0 rounded-3 p-3 mb-4 d-flex gap-2 align-items-center" style="background:var(--green-subtle); color:var(--green-dark);">
                                            <i class="fa fa-lightbulb"></i>
                                            <small class="fw-medium">Leave blank to auto-inherit from Meta on save.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Title</label>
                                            <input type="text" name="twitter_title" class="form-control" value="<?= $p('twitter_title') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Description</label>
                                            <textarea name="twitter_description" class="form-control" rows="3"><?= $p('twitter_description') ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Card Type</label>
                                            <select name="twitter_card" class="form-select">
                                                <option value="summary_large_image" <?= ($p('twitter_card') ?: 'summary_large_image') === 'summary_large_image' ? 'selected' : '' ?>>summary_large_image (Recommended)</option>
                                                <option value="summary" <?= $p('twitter_card') === 'summary' ? 'selected' : '' ?>>summary</option>
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
                                                        <button type="button" class="robots-btn shadow-sm <?= $currentIndex === 'index'   ? 'active-index'   : '' ?>" onclick="setRobots('index',this)">✅ INDEX</button>
                                                        <button type="button" class="robots-btn shadow-sm <?= $currentIndex === 'noindex' ? 'active-noindex' : '' ?>" onclick="setRobots('noindex',this)">🚫 NOINDEX</button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="robots-group" id="robotsFollowGroup">
                                                        <button type="button" class="robots-btn shadow-sm <?= $currentFollow === 'follow'   ? 'active-follow'   : '' ?>" onclick="setFollow('follow',this)">🔗 FOLLOW</button>
                                                        <button type="button" class="robots-btn shadow-sm <?= $currentFollow === 'nofollow' ? 'active-nofollow' : '' ?>" onclick="setFollow('nofollow',this)">⛔ NOFOLLOW</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="robots_index"  id="robotsIndex"  value="<?= $currentIndex ?>">
                                            <input type="hidden" name="robots_follow" id="robotsFollow" value="<?= $currentFollow ?>">
                                            <small class="fw-medium mt-2 d-block <?= $currentIndex === 'index' && $currentFollow === 'follow' ? 'text-success' : 'text-danger' ?>" id="robotsHint">
                                                <?= $currentIndex === 'index' && $currentFollow === 'follow'
                                                    ? '✅ This page will be indexed and links followed.'
                                                    : '⚠️ This page is restricted from indexing or link-following.' ?>
                                            </small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Schema / Structured Data Type</label>
                                            <div class="schema-options">
                                                <?php foreach (['Product','Service','LocalBusiness','WebPage','FAQPage'] as $s): ?>
                                                <button type="button" class="schema-opt shadow-sm <?= ($p('schema_type') ?: 'Product') === $s ? 'active' : '' ?>"
                                                        onclick="setSchema('<?= $s ?>',this)"><?= $s ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                            <input type="hidden" name="schema_type" id="schemaType" value="<?= $p('schema_type') ?: 'Product' ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div><!-- /col-xl-8 -->

                    <!-- ── RIGHT SIDEBAR ───────────────────────────────── -->
                    <div class="col-xl-4 col-lg-5">

                        <!-- Publish Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
                                    <i class="fa fa-paper-plane" style="color:var(--green-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Publish</h6>
                            </div>
                            <div class="card-body p-4">
                                <!-- Last Updated -->
                                <div class="d-flex align-items-center gap-2 mb-3 p-3 bg-light rounded-3 small text-muted">
                                    <i class="fa fa-clock" style="color:var(--green-primary);"></i>
                                    <span>Last updated: <strong class="text-dark">
                                        <?= !empty($service['updated_at']) ? date('M d, Y H:i', strtotime($service['updated_at'])) : 'Never' ?>
                                    </strong></span>
                                </div>
                                <button type="submit" class="btn btn-save-service w-100 rounded-pill py-2 shadow-sm">
                                    <i class="fa fa-save me-2"></i>Update Service
                                </button>
                                <a href="./" class="btn btn-light w-100 rounded-pill py-2 fw-semibold border mt-2">Cancel</a>
                            </div>
                        </div>

                    <!-- Banner Image -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
        <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
            <i class="fa fa-image" style="color:var(--green-primary);"></i>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Banner Image <small class="text-muted fw-normal text-lowercase">1820×450</small></h6>
    </div>
    <div class="card-body p-4">
        <?php if ($bannerImgUrl): ?>
        <div class="mb-3 text-center">
            <img src="<?= htmlspecialchars($bannerImgUrl) ?>" id="currentBannerImg" class="current-thumb shadow-sm" alt="Current banner image">
            <div class="text-muted mt-1" style="font-size:0.7rem;">Current Banner Image</div>
        </div>
        <?php endif; ?>
        <div class="img-upload-zone" id="zone_banner" onclick="document.getElementById('input_banner').click()">
            <div class="upload-icon" id="uploadIcon_banner"><i class="fa fa-image"></i></div>
            <p id="uploadLabel_banner">Click to replace banner image</p>
            <small class="text-muted d-block mt-1" id="uploadHint_banner">JPG, PNG, WEBP — max 3MB · Auto WebP</small>
            <img id="preview_banner" class="preview-img" alt="Banner preview">
        </div>
        <input type="file" name="banner_image" id="input_banner" accept="image/*" class="d-none">
        <small class="text-muted mt-2 d-block text-center" style="font-size:0.7rem;">⚠️ Leave blank to keep current image.</small>
    </div>
</div>

<!-- Focus Image -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
        <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
            <i class="fa fa-images" style="color:var(--green-primary);"></i>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Focus Image <small class="text-muted fw-normal text-lowercase">1410×504</small></h6>
    </div>
    <div class="card-body p-4">
        <?php if ($focusImgUrl): ?>
        <div class="mb-3 text-center">
            <img src="<?= htmlspecialchars($focusImgUrl) ?>" id="currentFocusImg" class="current-thumb shadow-sm" alt="Current focus image">
            <div class="text-muted mt-1" style="font-size:0.7rem;">Current Focus Image</div>
        </div>
        <?php endif; ?>
        <div class="img-upload-zone" id="zone_focus" onclick="document.getElementById('input_focus').click()">
            <div class="upload-icon" id="uploadIcon_focus"><i class="fa fa-photo-video"></i></div>
            <p id="uploadLabel_focus">Click to replace focus image</p>
            <small class="text-muted d-block mt-1" id="uploadHint_focus">JPG, PNG, WEBP — max 3MB · Auto WebP</small>
            <img id="preview_focus" class="preview-img" alt="Focus image preview">
        </div>
        <input type="file" name="focus_image" id="input_focus" accept="image/*" class="d-none">
        <small class="text-muted mt-2 d-block text-center" style="font-size:0.7rem;">⚠️ Leave blank to keep current image.</small>
    </div>
</div>

<!-- FAQ Image -->
<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
        <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--green-subtle);">
            <i class="fa fa-question-circle" style="color:var(--green-primary);"></i>
        </div>
        <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">FAQ Image <small class="text-muted fw-normal text-lowercase">704×532</small></h6>
    </div>
    <div class="card-body p-4">
        <?php if ($faqImgUrl): ?>
        <div class="mb-3 text-center">
            <img src="<?= htmlspecialchars($faqImgUrl) ?>" id="currentFaqImg" class="current-thumb shadow-sm" alt="Current FAQ image">
            <div class="text-muted mt-1" style="font-size:0.7rem;">Current FAQ Image</div>
        </div>
        <?php endif; ?>
        <div class="img-upload-zone" id="zone_faq" onclick="document.getElementById('input_faq').click()">
            <div class="upload-icon" id="uploadIcon_faq"><i class="fa fa-question"></i></div>
            <p id="uploadLabel_faq">Click to replace FAQ image</p>
            <small class="text-muted d-block mt-1" id="uploadHint_faq">JPG, PNG, WEBP — max 3MB · Auto WebP</small>
            <img id="preview_faq" class="preview-img" alt="FAQ image preview">
        </div>
        <input type="file" name="faq_image" id="input_faq" accept="image/*" class="d-none">
        <small class="text-muted mt-2 d-block text-center" style="font-size:0.7rem;">⚠️ Leave blank to keep current image.</small>
    </div>
</div>

                        <!-- SEO Tips -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 card-section-header">
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">
                                    <i class="fa fa-lightbulb me-2" style="color:var(--green-primary);"></i>SEO Tips
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <ul class="list-unstyled mb-0 small text-muted" style="line-height:2.2;">
                                    <li>✅ Include keyword in title & short desc</li>
                                    <li>✅ Write 500+ words in description</li>
                                    <li>✅ Add 5+ items to each list</li>
                                    <li>✅ Use <strong>Service</strong> or <strong>LocalBusiness</strong> schema</li>
                                    <li>✅ Clean slug: <code>bedroom-mosquito-nets</code></li>
                                    <li>✅ Upload high-quality images</li>
                                    <li>✅ Fill meta description (120–160 chars)</li>
                                    <li>✅ Add at least 3 FAQs for rich results</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Danger Zone -->
                        <div class="card border-0 shadow-sm rounded-4 border border-danger-subtle">
                            <div class="card-header bg-danger-subtle border-bottom py-3 px-4">
                                <h6 class="mb-0 fw-bold text-danger text-uppercase small" style="letter-spacing:0.5px;">
                                    <i class="fa fa-exclamation-triangle me-2"></i>Danger Zone
                                </h6>
                            </div>
                            <div class="card-body p-4">
                                <p class="text-muted small mb-3">Permanently delete this service. This action cannot be undone.</p>
                                <a href="./?delete=<?= $id ?>"
                                   class="btn btn-outline-danger w-100 rounded-pill fw-semibold"
                                   onclick="return confirm('Permanently delete &quot;<?= addslashes(htmlspecialchars($service['title'])) ?>&quot;? This cannot be undone.')">
                                    <i class="fa fa-trash-alt me-2"></i>Delete Service
                                </a>
                            </div>
                        </div>

                    </div><!-- /col-xl-4 -->

                </div>
            </form>

        </div>
    </div>
</div>

<script>
// ── Title → Slug ──────────────────────────────────────────────
document.getElementById('serviceTitle').addEventListener('input', function () {
    document.getElementById('titleCount').textContent = this.value.length + ' chars';
    document.getElementById('serpSlug').textContent   = autoSlug(this.value) || '<?= htmlspecialchars($service['slug'] ?? '') ?>';
    calcSeoScore();
});
document.getElementById('generateSlug').addEventListener('click', function () {
    const slug = autoSlug(document.getElementById('serviceTitle').value);
    document.getElementById('serviceSlug').value      = slug;
    document.getElementById('serpSlug').textContent   = slug || '<?= htmlspecialchars($service['slug'] ?? '') ?>';
});
document.getElementById('serviceSlug').addEventListener('input', function () {
    document.getElementById('serpSlug').textContent = this.value || '<?= htmlspecialchars($service['slug'] ?? '') ?>';
    calcSeoScore();
});
function autoSlug(str) {
    return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
}

// ── Short Desc Counter ────────────────────────────────────────
document.getElementById('serviceShortDesc').addEventListener('input', function () {
    const c = document.getElementById('shortDescCount');
    c.textContent = this.value.length + ' chars';
    c.className   = 'count ' + (this.value.length <= 200 ? 'ok' : 'warn');
    calcSeoScore();
});

// ── Word Count ────────────────────────────────────────────────
(function initWordCount() {
    const el = document.getElementById('serviceDesc');
    function update() {
        const words = el.value.trim() ? el.value.trim().split(/\s+/).length : 0;
        const c = document.getElementById('wordCount');
        c.textContent = words + ' words';
        c.className   = 'count ' + (words >= 500 ? 'ok' : words >= 200 ? 'warn' : 'bad');
        calcSeoScore();
    }
    el.addEventListener('input', update);
    update();
})();

// ── Meta Char Counters ────────────────────────────────────────
function setupCharCounter(inputId, countId, barId, max) {
    const el  = document.getElementById(inputId);
    const cnt = document.getElementById(countId);
    const bar = barId ? document.getElementById(barId) : null;
    if (!el) return;
    function update(len) {
        cnt.textContent = len + ' / ' + max;
        cnt.className   = 'count ' + (len < max * 0.7 ? 'ok' : len <= max ? 'warn' : 'bad');
        if (bar) {
            bar.style.width      = Math.min((len/max)*100, 100) + '%';
            bar.style.background = len < max*0.7 ? '#16a34a' : len <= max ? '#ca8a04' : '#dc3545';
        }
    }
    update(el.value.length);
    el.addEventListener('input', function () {
        update(this.value.length);
        if (inputId === 'metaTitle') {
            document.getElementById('serpTitle').innerHTML = this.value || '<span class="serp-placeholder">Your meta title will appear here...</span>';
        }
        if (inputId === 'metaDesc') {
            document.getElementById('serpDesc').innerHTML = this.value || '<span class="serp-placeholder">Your meta description will appear here.</span>';
        }
        calcSeoScore();
    });
}
setupCharCounter('metaTitle', 'metaTitleCount', 'metaTitleBar', 60);
setupCharCounter('metaDesc',  'metaDescCount',  'metaDescBar',  160);

// ── SEO Score ─────────────────────────────────────────────────
function calcSeoScore() {
    let score = 0;
    const words = (document.getElementById('serviceDesc').value.trim().split(/\s+/).filter(Boolean).length);
    if (document.getElementById('serviceTitle').value.trim())    score += 15;
    if (document.getElementById('serviceShortDesc').value.trim())score += 15;
    if (document.getElementById('focusKeyword').value.trim())    score += 20;
    if (document.getElementById('metaTitle').value.trim())       score += 15;
    if (document.getElementById('metaDesc').value.trim())        score += 15;
    if (document.getElementById('serviceSlug').value.trim())     score += 10;
    if (words >= 500)                                            score += 10;

    const badge = document.getElementById('seoScoreBadge');
    badge.textContent = 'Score: ' + score + ' / 100';
    if (score >= 80) {
        badge.style.background = '#d1e7dd'; badge.style.color = '#0a3622'; badge.style.borderColor = '#badbcc';
    } else if (score >= 50) {
        badge.style.background = '#d1fae5'; badge.style.color = '#065f46'; badge.style.borderColor = '#6ee7b7';
    } else {
        badge.style.background = '#f8d7da'; badge.style.color = '#58151c'; badge.style.borderColor = '#f5c2c7';
    }
}
document.getElementById('focusKeyword').addEventListener('input', calcSeoScore);
calcSeoScore();

// ── Image Previews ────────────────────────────────────────────
function setupImgPreview(inputId, previewId, iconId, labelId, hintId, currentId) {
    document.getElementById(inputId).addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById(previewId);
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (iconId)  document.getElementById(iconId).style.display  = 'none';
            if (labelId) document.getElementById(labelId).style.display = 'none';
            if (hintId)  document.getElementById(hintId).style.display  = 'none';
            if (currentId && document.getElementById(currentId))
                document.getElementById(currentId).src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}
setupImgPreview('input_banner', 'preview_banner', 'uploadIcon_banner', 'uploadLabel_banner', 'uploadHint_banner', 'currentBannerImg');
setupImgPreview('input_focus',  'preview_focus',  'uploadIcon_focus',  'uploadLabel_focus',  'uploadHint_focus',  'currentFocusImg');
setupImgPreview('input_faq',    'preview_faq',    'uploadIcon_faq',    'uploadLabel_faq',    'uploadHint_faq',    'currentFaqImg');

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
    const i  = document.getElementById('robotsIndex').value;
    const f  = document.getElementById('robotsFollow').value;
    const h  = document.getElementById('robotsHint');
    const ok = i === 'index' && f === 'follow';
    h.className   = (ok ? 'text-success' : 'text-danger') + ' fw-medium mt-2 d-block small';
    h.textContent = ok ? '✅ This page will be indexed and links followed.'
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