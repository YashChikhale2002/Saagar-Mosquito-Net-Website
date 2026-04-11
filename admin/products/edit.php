<?php
// admin/products/edit.php
require_once './../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
requireAccess('products');

$id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$res = $conn->query("SELECT * FROM products WHERE id = $id");
$product = $res ? $res->fetch_assoc() : null;
if (!$product) { header("Location: ./"); exit; }

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ── Core Fields ──────────────────────────────────────────────
    $name              = trim($_POST['name'] ?? '');
    $slug              = trim($_POST['slug'] ?? '');
    $category          = trim($_POST['category'] ?? '');
    $description       = trim($_POST['description'] ?? '');
    $full_description  = $_POST['full_description'] ?? '';
    $specifications    = trim($_POST['specifications'] ?? '');
    $features          = trim($_POST['features'] ?? '');
    $applications      = trim($_POST['applications'] ?? '');
    $brand             = trim($_POST['brand'] ?? '');
    $sku               = trim($_POST['sku'] ?? '');
    $weight            = trim($_POST['weight'] ?? '');
    $dimensions        = trim($_POST['dimensions'] ?? '');
    $material          = trim($_POST['material'] ?? '');
    $color             = trim($_POST['color'] ?? '');
    $warranty          = trim($_POST['warranty'] ?? '');
    $certifications    = trim($_POST['certifications'] ?? '');
    $in_stock          = isset($_POST['in_stock']) ? 1 : 0;
    $availability      = trim($_POST['availability'] ?? '');
    $delivery_info     = trim($_POST['delivery_info'] ?? '');
    $country_of_origin = trim($_POST['country_of_origin'] ?? '');
    $tags              = trim($_POST['tags'] ?? '');
    $badge             = trim($_POST['badge'] ?? '');
    $badge_type        = trim($_POST['badge_type'] ?? '');
    $moq               = trim($_POST['moq'] ?? '');
    $rating            = isset($_POST['rating']) ? (float)$_POST['rating'] : 0;
    $reviews           = isset($_POST['reviews']) ? (int)$_POST['reviews'] : 0;
    $is_active         = isset($_POST['is_active']) ? 1 : 0;
    $sort_order        = isset($_POST['sort_order']) ? (int)$_POST['sort_order'] : 0;

    // ── SEO Fields ───────────────────────────────────────────────
    $meta_title          = trim($_POST['meta_title'] ?? '');
    $meta_description    = trim($_POST['meta_description'] ?? '');
    $focus_keyword       = trim($_POST['focus_keyword'] ?? '');
    $canonical_url       = trim($_POST['canonical_url'] ?? '');
    $og_title            = trim($_POST['og_title'] ?? '');
    $og_description      = trim($_POST['og_description'] ?? '');
    $og_type             = trim($_POST['og_type'] ?? 'product');
    $twitter_title       = trim($_POST['twitter_title'] ?? '');
    $twitter_description = trim($_POST['twitter_description'] ?? '');
    $twitter_card        = trim($_POST['twitter_card'] ?? 'summary_large_image');
    $robots_index        = trim($_POST['robots_index'] ?? 'index');
    $robots_follow       = trim($_POST['robots_follow'] ?? 'follow');
    $schema_type         = trim($_POST['schema_type'] ?? 'Product');

    // ── Validation ───────────────────────────────────────────────
    if (empty($name))     $errors[] = 'Product name is required.';
    if (empty($category)) $errors[] = 'Category is required.';
    if (!empty($meta_title) && mb_strlen($meta_title) > 70)
        $errors[] = 'Meta title should not exceed 70 characters.';
    if (!empty($meta_description) && mb_strlen($meta_description) > 180)
        $errors[] = 'Meta description should not exceed 180 characters.';

    // ── Slug Generation ──────────────────────────────────────────
    if (empty($slug)) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
    } else {
        $slug = strtolower(preg_replace('/[^a-z0-9-]+/', '-', $slug));
    }
    $slug    = trim($slug, '-');
    $slugEsc = $conn->real_escape_string($slug);

    // Allow same slug as current record
    $chk = $conn->query("SELECT id FROM products WHERE slug = '$slugEsc' AND id != $id");
    if ($chk && $chk->num_rows > 0) {
        $errors[] = 'Slug already exists. Please use a different one.';
    }

    // ── SEO Auto-fill Defaults ───────────────────────────────────
    if (empty($meta_title))          $meta_title          = $name;
    if (empty($meta_description))    $meta_description    = $description;
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
        $success = imagewebp($img, $destination, $quality);
        imagedestroy($img);
        return $success;
    }

    // ── Image Upload Helper ──────────────────────────────────────
    function uploadProductImage($fileKey, $prefix, $uploadDir) {
        if (empty($_FILES[$fileKey]['name'])) return null;
        $allowed = ['image/jpeg','image/png','image/webp','image/gif'];
        $mime    = mime_content_type($_FILES[$fileKey]['tmp_name']);
        if (!in_array($mime, $allowed))                    return ['error' => "Invalid file type for $fileKey."];
        if ($_FILES[$fileKey]['size'] > 3 * 1024 * 1024)  return ['error' => "Image $fileKey exceeds 3MB."];
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName   = $prefix . '-' . uniqid() . '.webp';
        $targetPath = $uploadDir . $fileName;
        if (convertToWebp($_FILES[$fileKey]['tmp_name'], $targetPath, 85))
            return 'assets/img/products/' . $fileName;
        return ['error' => "Failed to convert $fileKey to WebP."];
    }

    // ── Process Images (keep existing if no new upload) ───────────
    $uploadDir = '../../assets/img/products/';
    $seoBase   = !empty($slug) ? $slug : 'product';

    $image  = $product['image']  ?? 'default.jpg';
    $image2 = $product['image2'] ?? '';
    $image3 = $product['image3'] ?? '';
    $image4 = $product['image4'] ?? '';
    $og_image = $product['og_image'] ?? '';

    foreach ([
        ['image',  $seoBase,        &$image,  'Main image'],
        ['image2', $seoBase.'-2',   &$image2, 'Image 2'],
        ['image3', $seoBase.'-3',   &$image3, 'Image 3'],
        ['image4', $seoBase.'-4',   &$image4, 'Image 4'],
    ] as [$key, $prefix, &$var, $label]) {
        if (!empty($_FILES[$key]['name'])) {
            $result = uploadProductImage($key, $prefix, $uploadDir);
            if (is_array($result)) {
                $errors[] = $result['error'];
            } elseif ($result) {
                // Delete old file if exists and not default
                if (!empty($var) && $var !== 'default.jpg') {
                    $oldPath = '../../' . ltrim($var, '/');
                    if (file_exists($oldPath)) @unlink($oldPath);
                }
                $var = $result;
            }
        }
    }
    if (!$image) $image = 'default.jpg';
    if ($image !== 'default.jpg') $og_image = $image;

    // ── Schema JSON ──────────────────────────────────────────────
    $schema_json = '';
    if (!empty($schema_type)) {
        $schemaData = [
            '@context'    => 'https://schema.org',
            '@type'       => $schema_type,
            'name'        => $name,
            'description' => $meta_description ?: $description,
            'image'       => $og_image ? (SITE_URL . '/' . $og_image) : '',
            'brand'       => ['@type' => 'Brand', 'name' => $brand ?: 'Niraj Industries'],
            'sku'         => $sku,
            'url'         => $canonical_url ?: '',
            'category'    => $category,
        ];
        $schema_json = json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // ── Update ───────────────────────────────────────────────────
    if (empty($errors)) {
        $robots_meta = $robots_index . ',' . $robots_follow;

        $stmt = $conn->prepare("
            UPDATE products SET
                name=?, slug=?, category=?, description=?, full_description=?,
                specifications=?, features=?, applications=?,
                brand=?, sku=?, weight=?, dimensions=?, material=?, color=?,
                warranty=?, certifications=?,
                image=?, image2=?, image3=?, image4=?,
                in_stock=?, availability=?, delivery_info=?, country_of_origin=?,
                tags=?, badge=?, badge_type=?, moq=?,
                rating=?, reviews=?, is_active=?, sort_order=?,
                meta_title=?, meta_description=?, focus_keyword=?, canonical_url=?,
                og_title=?, og_description=?, og_image=?, og_type=?,
                twitter_title=?, twitter_description=?, twitter_card=?,
                robots_meta=?, schema_type=?, schema_json=?,
                updated_at=NOW()
            WHERE id=?
        ");

        $stmt->bind_param(
            // name slug category description full_description = 5s
            // specifications features applications = 3s
            // brand sku weight dimensions material color = 6s
            // warranty certifications = 2s
            // image image2 image3 image4 = 4s
            // in_stock(i) availability delivery_info country_of_origin = 1i+3s
            // tags badge badge_type moq = 4s
            // rating(d) reviews(i) is_active(i) sort_order(i) = 1d+3i
            // meta_title meta_description focus_keyword canonical_url = 4s
            // og_title og_description og_image og_type = 4s
            // twitter_title twitter_description twitter_card = 3s
            // robots_meta schema_type schema_json = 3s
            // id(i) = 1i
            "sssss" . "sss" . "ssssss" . "ss" . "ssss" . "isss" . "ssss" . "dsii" . "ssss" . "ssss" . "sss" . "sss" . "i",
            $name, $slug, $category, $description, $full_description,
            $specifications, $features, $applications,
            $brand, $sku, $weight, $dimensions, $material, $color,
            $warranty, $certifications,
            $image, $image2, $image3, $image4,
            $in_stock, $availability, $delivery_info, $country_of_origin,
            $tags, $badge, $badge_type, $moq,
            $rating, $reviews, $is_active, $sort_order,
            $meta_title, $meta_description, $focus_keyword, $canonical_url,
            $og_title, $og_description, $og_image, $og_type,
            $twitter_title, $twitter_description, $twitter_card,
            $robots_meta, $schema_type, $schema_json,
            $id
        );

        if ($stmt->execute()) {
            header("Location: ./?msg=updated");
            exit;
        } else {
            $errors[] = 'Database error: ' . $stmt->error;
        }
    }
} else {
    // ── Pre-fill from DB on GET ───────────────────────────────────
    $_POST = $product;
}

// ── Helpers ───────────────────────────────────────────────────
$p = fn($k) => htmlspecialchars($_POST[$k] ?? $product[$k] ?? '');

// Current robots
$robotsParts  = explode(',', $product['robots_meta'] ?? 'index,follow');
$currentIndex = trim($robotsParts[0] ?? 'index');
$currentFollow= trim($robotsParts[1] ?? 'follow');

$pageTitle  = 'Edit Product — ' . htmlspecialchars($product['name']);
$activePage = 'products-edit';
$assetBase  = '../';

$extraCSS = '
<style>
    :root {
        --yellow-primary: #F5A623;
        --yellow-dark:    #E08E00;
        --yellow-light:   #FFF8E7;
        --yellow-subtle:  #FEF3CD;
        --yellow-border:  #FDDFA0;
        --success: #198754;
        --warning: #ffc107;
        --danger:  #dc3545;
    }
    body, .page-wrapper { background-color: #f9f5ee !important; }

    .form-label {
        font-size: 0.75rem; font-weight: 700; color: #6c757d;
        text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem;
    }
    .form-control, .form-select {
        font-size: 0.88rem; padding: 0.6rem 1rem;
        border-color: #e2d9c8;
        background-color: #fffdf8;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--yellow-primary);
        box-shadow: 0 0 0 0.2rem rgba(245,166,35,0.2);
        background-color: #fff;
    }

    .char-counter { display:flex; justify-content:space-between; margin-top:5px; font-size:0.7rem; color:#adb5bd; font-family:monospace; }
    .char-counter .count { font-weight:700; }
    .char-counter .count.ok   { color:#198754; }
    .char-counter .count.warn { color:var(--yellow-dark); }
    .char-counter .count.bad  { color:#dc3545; }
    .char-bar { height:4px; background:#f0e9d8; border-radius:4px; margin-top:5px; overflow:hidden; }
    .char-bar-fill { height:100%; border-radius:4px; transition:width .3s, background .3s; }

    /* Image Upload Zone */
    .img-upload-zone {
        border: 2px dashed var(--yellow-border);
        border-radius: 0.75rem; padding: 1.5rem 1rem;
        text-align: center; cursor: pointer;
        transition: all 0.2s; background: var(--yellow-light);
    }
    .img-upload-zone:hover { border-color: var(--yellow-primary); background: var(--yellow-subtle); }
    .img-upload-zone .upload-icon { font-size: 1.8rem; color: var(--yellow-primary); margin-bottom: 0.4rem; }
    .img-upload-zone p { font-size: 0.8rem; color: #6c757d; margin: 0; font-weight: 500; }
    .img-upload-zone .preview-img { width:100%; border-radius:0.5rem; object-fit:cover; display:none; margin-top:8px; max-height:180px; }
    .img-upload-zone.main-zone { padding: 1.5rem 1rem; }

    /* Current Image thumbs */
    .current-thumb { width:80px; height:80px; border-radius:0.5rem; object-fit:cover; border:3px solid var(--yellow-border); }
    .current-thumb-sm { width:56px; height:56px; border-radius:0.4rem; object-fit:cover; border:2px solid var(--yellow-border); }

    /* SERP Preview */
    .serp-preview { background:#fff; border:1px solid #dfe1e5; border-radius:0.5rem; padding:1rem; margin-top:0.25rem; }
    .serp-url   { font-size:0.72rem; color:#202124; font-family:Arial,sans-serif; margin-bottom:2px; }
    .serp-title { font-size:1.1rem; color:#1a0dab; font-family:Arial,sans-serif; line-height:1.3; margin-bottom:2px; }
    .serp-desc  { font-size:0.83rem; color:#4d5156; font-family:Arial,sans-serif; line-height:1.5; }
    .serp-placeholder { color:#9aa0a6 !important; font-style:italic; }

    /* Tabs */
    .nav-pills .nav-link { color:#6c757d; border-radius:20px; font-size:0.83rem; font-weight:600; padding:0.45rem 1rem; transition:all 0.2s; }
    .nav-pills .nav-link.active { background-color:var(--yellow-subtle); color:var(--yellow-dark); border:1px solid var(--yellow-border); }

    /* Schema / Robots */
    .schema-options, .robots-group { display:flex; flex-wrap:wrap; gap:8px; margin-top:6px; }
    .schema-opt, .robots-btn { padding:6px 14px; border-radius:20px; font-size:0.73rem; font-weight:600; cursor:pointer; border:1px solid #e2d9c8; color:#6c757d; background:#fff; transition:all 0.15s; flex:1; text-align:center; }
    .schema-opt.active { border-color:var(--yellow-primary); color:var(--yellow-dark); background:var(--yellow-subtle); }
    .robots-btn.active-index, .robots-btn.active-follow { border-color:#198754; color:#198754; background:rgba(25,135,84,0.06); }
    .robots-btn.active-noindex, .robots-btn.active-nofollow { border-color:#dc3545; color:#dc3545; background:rgba(220,53,69,0.06); }

    /* Publish toggle */
    .form-check-input:checked { background-color:var(--yellow-primary); border-color:var(--yellow-primary); }

    /* Card section header accent */
    .card-section-header { border-left:4px solid var(--yellow-primary); }

    /* Save button */
    .btn-save-product {
        background: linear-gradient(135deg, var(--yellow-primary), var(--yellow-dark));
        border:none; color:#fff; font-weight:700; transition: all .2s;
    }
    .btn-save-product:hover { background:linear-gradient(135deg, var(--yellow-dark), #c07a00); color:#fff; transform:translateY(-1px); box-shadow:0 4px 12px rgba(245,166,35,.4); }

    /* Page title icon */
    .page-title-icon {
        width:42px; height:42px;
        background:linear-gradient(135deg, var(--yellow-primary), var(--yellow-dark));
        border-radius:10px; display:flex; align-items:center; justify-content:center;
        color:#fff; font-size:1.1rem;
    }
    .breadcrumb-item a { color:var(--yellow-dark) !important; }

    textarea.form-control { resize: vertical; }
    #seoScoreBadge { transition: all .3s; }
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
                        <h3 class="fw-bolder text-dark mb-1">Edit Product</h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb small bg-transparent p-0 m-0">
                                <li class="breadcrumb-item"><a href="../" class="text-decoration-none fw-medium">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="./" class="text-decoration-none fw-medium">Products</a></li>
                                <li class="breadcrumb-item active text-secondary fw-medium"><?= htmlspecialchars($product['name']) ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <a href="<?= SITE_URL ?>/products/<?= htmlspecialchars($product['slug'] ?? '') ?>" target="_blank"
                       class="btn btn-light rounded-pill px-4 py-2 shadow-sm fw-semibold border d-inline-flex align-items-center gap-2">
                        <i class="fa fa-external-link-alt"></i> View Product
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

            <form method="POST" enctype="multipart/form-data" id="productForm">
                <div class="row g-4">

                    <!-- ── LEFT COLUMN ─────────────────────────────────── -->
                    <div class="col-xl-8 col-lg-7">

                        <!-- ① Basic Info -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--yellow-subtle);">
                                    <i class="fa fa-box-open" style="color:var(--yellow-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Product Information</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <label class="form-label">Product Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="productName" class="form-control"
                                               value="<?= $p('name') ?>" required>
                                        <div class="char-counter"><span>Name length</span><span class="count" id="nameCount"><?= mb_strlen($product['name']) ?> chars</span></div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Category <span class="text-danger">*</span></label>
                                        <input type="text" name="category" class="form-control"
                                               placeholder="Construction, Electrical..."
                                               value="<?= $p('category') ?>" required>
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">URL Slug</label>
                                        <div class="input-group">
                                            <input type="text" name="slug" id="productSlug" class="form-control"
                                                   value="<?= $p('slug') ?>">
                                            <button type="button" class="btn btn-light border text-secondary" id="generateSlug" title="Re-generate from name">
                                                <i class="fa fa-refresh"></i>
                                            </button>
                                        </div>
                                        <small class="text-muted" style="font-size:0.72rem;">⚠️ Changing slug will break existing links to this product.</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" class="form-control" placeholder="SKU-ST-001" value="<?= $p('sku') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Brand</label>
                                        <input type="text" name="brand" class="form-control" placeholder="Tata Steel, Finolex..." value="<?= $p('brand') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Country of Origin</label>
                                        <input type="text" name="country_of_origin" class="form-control" placeholder="India" value="<?= $p('country_of_origin') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">MOQ <small class="text-muted fw-normal text-lowercase">(min order)</small></label>
                                        <input type="text" name="moq" class="form-control" placeholder="1 Ton, 100 Bags..." value="<?= $p('moq') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Weight</label>
                                        <input type="text" name="weight" class="form-control" placeholder="50 kg/bag" value="<?= $p('weight') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Dimensions</label>
                                        <input type="text" name="dimensions" class="form-control" placeholder="12000 × 20 mm" value="<?= $p('dimensions') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Material</label>
                                        <input type="text" name="material" class="form-control" placeholder="Fe500D TMT Steel" value="<?= $p('material') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Color</label>
                                        <input type="text" name="color" class="form-control" placeholder="Silver Grey, Orange..." value="<?= $p('color') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Sort Order</label>
                                        <input type="number" name="sort_order" class="form-control" value="<?= $p('sort_order') ?: 0 ?>" min="0">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Short Description <small class="text-muted fw-normal text-lowercase">(shown in listings)</small></label>
                                        <textarea name="description" id="shortDesc" class="form-control" rows="2"
                                                  placeholder="One or two lines for catalogue listings..."><?= $p('description') ?></textarea>
                                        <div class="char-counter"><span>Ideal: 80–200 chars</span><span class="count" id="shortDescCount"><?= mb_strlen($product['description'] ?? '') ?> chars</span></div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Full Description</label>
                                        <textarea name="full_description" class="form-control" rows="6"
                                                  placeholder="Detailed product description..."><?= $p('full_description') ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ② Technical Details -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--yellow-subtle);">
                                    <i class="fa fa-cogs" style="color:var(--yellow-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Technical Details</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label">Specifications <small class="text-muted fw-normal text-lowercase">(one per line: Label: Value)</small></label>
                                        <textarea name="specifications" class="form-control" rows="5"
                                                  placeholder="Grade: Fe500D&#10;Diameter: 8mm–32mm&#10;Tensile Strength: 545 N/mm²"><?= $p('specifications') ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Key Features <small class="text-muted fw-normal text-lowercase">(one per line)</small></label>
                                        <textarea name="features" class="form-control" rows="5"
                                                  placeholder="High tensile strength&#10;Corrosion resistant&#10;BIS certified"><?= $p('features') ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Applications <small class="text-muted fw-normal text-lowercase">(one per line)</small></label>
                                        <textarea name="applications" class="form-control" rows="5"
                                                  placeholder="Residential buildings&#10;Bridges and flyovers&#10;Foundation reinforcement"><?= $p('applications') ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Warranty</label>
                                        <input type="text" name="warranty" class="form-control" placeholder="1 Year Manufacturing Warranty" value="<?= $p('warranty') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Certifications</label>
                                        <input type="text" name="certifications" class="form-control" placeholder="BIS IS:1786, ISI Mark, ISO 9001" value="<?= $p('certifications') ?>">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Tags <small class="text-muted fw-normal text-lowercase">(comma separated)</small></label>
                                        <input type="text" name="tags" class="form-control"
                                               placeholder="steel bars, tmt, construction, nagpur..."
                                               value="<?= $p('tags') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ③ Stock & Delivery -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--yellow-subtle);">
                                    <i class="fa fa-truck" style="color:var(--yellow-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Stock & Delivery</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Availability Text</label>
                                        <input type="text" name="availability" class="form-control"
                                               placeholder="Ships in 1–2 days" value="<?= $p('availability') ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Delivery Info</label>
                                        <input type="text" name="delivery_info" class="form-control"
                                               placeholder="Free delivery above ₹50,000" value="<?= $p('delivery_info') ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Rating (0–5)</label>
                                        <input type="number" name="rating" class="form-control"
                                               value="<?= $p('rating') ?: '0.0' ?>" min="0" max="5" step="0.1">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Review Count</label>
                                        <input type="number" name="reviews" class="form-control"
                                               value="<?= $p('reviews') ?: 0 ?>" min="0">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Stock Status</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" name="in_stock" id="inStock"
                                                   style="width:3rem;height:1.5rem;"
                                                   <?= $product['in_stock'] ? 'checked' : '' ?>>
                                            <label class="form-check-label fw-semibold small ms-2" for="inStock">In Stock</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ④ SEO Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center justify-content-between card-section-header">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--yellow-subtle);">
                                        <i class="fa fa-search" style="color:var(--yellow-primary);"></i>
                                    </div>
                                    <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">SEO Settings</h6>
                                </div>
                                <span class="badge border rounded-pill px-3 py-1 fw-bold" id="seoScoreBadge"
                                      style="background:var(--yellow-subtle); color:var(--yellow-dark); border-color:var(--yellow-border) !important;">Score: 0 / 100</span>
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
                                        <div class="mb-4 p-3 rounded-3" style="background:var(--yellow-light); border:1px solid var(--yellow-border);">
                                            <label class="form-label" style="color:var(--yellow-dark);"><i class="fa fa-key me-1"></i>Focus Keyword</label>
                                            <input type="text" name="focus_keyword" id="focusKeyword" class="form-control fw-bold"
                                                   style="background:#fffbe8; border-color:var(--yellow-border); color:var(--yellow-dark);"
                                                   placeholder="e.g. heavy duty steel bars nagpur, fe500d tmt..."
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
                                            <input type="text" name="canonical_url" id="canonicalUrl" class="form-control"
                                                   placeholder="https://nirajindustries.com/products/..."
                                                   value="<?= $p('canonical_url') ?>">
                                        </div>
                                        <!-- SERP Preview -->
                                        <div class="mt-3">
                                            <label class="form-label"><i class="fab fa-google text-muted me-1"></i>Google SERP Preview</label>
                                            <div class="serp-preview">
                                                <div class="serp-url">nirajindustries.com › products › <span id="serpSlug"><?= htmlspecialchars($product['slug'] ?? '') ?></span></div>
                                                <div class="serp-title" id="serpTitle">
                                                    <?php if (!empty($product['meta_title'])): ?>
                                                        <?= htmlspecialchars($product['meta_title']) ?>
                                                    <?php else: ?>
                                                        <span class="serp-placeholder">Your meta title will appear here...</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="serp-desc" id="serpDesc">
                                                    <?php if (!empty($product['meta_description'])): ?>
                                                        <?= htmlspecialchars($product['meta_description']) ?>
                                                    <?php else: ?>
                                                        <span class="serp-placeholder">Your meta description will appear here.</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- OG Tab -->
                                    <div class="tab-pane fade" id="tab-og">
                                        <div class="alert border-0 rounded-3 p-3 mb-4 d-flex gap-2 align-items-center"
                                             style="background:var(--yellow-subtle); color:var(--yellow-dark);">
                                            <i class="fa fa-info-circle"></i>
                                            <small class="fw-medium">Leave blank to auto-inherit from Meta Title / Description on save.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Title</label>
                                            <input type="text" name="og_title" class="form-control"
                                                   placeholder="Title on Facebook / LinkedIn shares..."
                                                   value="<?= $p('og_title') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Description</label>
                                            <textarea name="og_description" class="form-control" rows="2"
                                                      placeholder="Description on social media shares..."><?= $p('og_description') ?></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">OG Type</label>
                                            <select name="og_type" class="form-select">
                                                <option value="product" <?= ($p('og_type') ?: 'product') === 'product' ? 'selected' : '' ?>>product (Recommended)</option>
                                                <option value="website" <?= $p('og_type') === 'website' ? 'selected' : '' ?>>website</option>
                                                <option value="article" <?= $p('og_type') === 'article' ? 'selected' : '' ?>>article</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Twitter Tab -->
                                    <div class="tab-pane fade" id="tab-twitter">
                                        <div class="alert border-0 rounded-3 p-3 mb-4 d-flex gap-2 align-items-center"
                                             style="background:var(--yellow-subtle); color:var(--yellow-dark);">
                                            <i class="fa fa-lightbulb"></i>
                                            <small class="fw-medium">Leave blank to auto-inherit from Meta Title / Description on save.</small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Title</label>
                                            <input type="text" name="twitter_title" class="form-control"
                                                   value="<?= $p('twitter_title') ?>"
                                                   placeholder="Title shown on Twitter card...">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Twitter Description</label>
                                            <textarea name="twitter_description" class="form-control" rows="3"
                                                      placeholder="Description on Twitter card..."><?= $p('twitter_description') ?></textarea>
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
                                                        <button type="button"
                                                            class="robots-btn shadow-sm <?= $currentIndex === 'index' ? 'active-index' : '' ?>"
                                                            onclick="setRobots('index',this)">✅ INDEX</button>
                                                        <button type="button"
                                                            class="robots-btn shadow-sm <?= $currentIndex === 'noindex' ? 'active-noindex' : '' ?>"
                                                            onclick="setRobots('noindex',this)">🚫 NOINDEX</button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="robots-group" id="robotsFollowGroup">
                                                        <button type="button"
                                                            class="robots-btn shadow-sm <?= $currentFollow === 'follow' ? 'active-follow' : '' ?>"
                                                            onclick="setFollow('follow',this)">🔗 FOLLOW</button>
                                                        <button type="button"
                                                            class="robots-btn shadow-sm <?= $currentFollow === 'nofollow' ? 'active-nofollow' : '' ?>"
                                                            onclick="setFollow('nofollow',this)">⛔ NOFOLLOW</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="robots_index"  id="robotsIndex"  value="<?= $currentIndex ?>">
                                            <input type="hidden" name="robots_follow" id="robotsFollow" value="<?= $currentFollow ?>">
                                            <small class="fw-medium mt-2 d-block <?= $currentIndex === 'index' && $currentFollow === 'follow' ? 'text-success' : 'text-danger' ?>" id="robotsHint">
                                                <?= $currentIndex === 'index' && $currentFollow === 'follow'
                                                    ? '✅ This page will be indexed and links followed by search engines.'
                                                    : '⚠️ This page is restricted from indexing or link-following.' ?>
                                            </small>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Schema / Structured Data Type</label>
                                            <div class="schema-options">
                                                <?php foreach (['Product','ItemPage','WebPage','LocalBusiness','Offer'] as $s): ?>
                                                <button type="button"
                                                    class="schema-opt shadow-sm <?= ($p('schema_type') ?: 'Product') === $s ? 'active' : '' ?>"
                                                    onclick="setSchema('<?= $s ?>',this)"><?= $s ?></button>
                                                <?php endforeach; ?>
                                            </div>
                                            <input type="hidden" name="schema_type" id="schemaType" value="<?= $p('schema_type') ?: 'Product' ?>">
                                            <small class="text-muted mt-2 d-block" style="font-size:0.72rem;">For products, <strong>Product</strong> or <strong>Offer</strong> gives the best rich-result coverage in Google Shopping.</small>
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
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--yellow-subtle);">
                                    <i class="fa fa-paper-plane" style="color:var(--yellow-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Publish</h6>
                            </div>
                            <div class="card-body p-4">
                                <!-- Last Updated Info -->
                                <div class="d-flex align-items-center gap-2 mb-3 p-3 bg-light rounded-3 small text-muted">
                                    <i class="fa fa-clock" style="color:var(--yellow-primary);"></i>
                                    <span>Last updated: <strong class="text-dark">
                                        <?= !empty($product['updated_at']) ? date('M d, Y H:i', strtotime($product['updated_at'])) : 'Never' ?>
                                    </strong></span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div>
                                        <div class="fw-semibold text-dark small">Activate Product</div>
                                        <div class="text-muted" style="font-size:0.72rem;">Show this product on the website</div>
                                    </div>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="is_active" id="isActive"
                                               style="width:3rem;height:1.5rem;cursor:pointer;"
                                               <?= $product['is_active'] ? 'checked' : '' ?>>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-save-product w-100 rounded-pill py-2 shadow-sm">
                                    <i class="fa fa-save me-2"></i> Update Product
                                </button>
                                <a href="./" class="btn btn-light w-100 rounded-pill py-2 fw-semibold border mt-2">Cancel</a>
                            </div>
                        </div>

                        <!-- Badge Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--yellow-subtle);">
                                    <i class="fa fa-award" style="color:var(--yellow-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Product Badge</h6>
                            </div>
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <label class="form-label">Badge Label</label>
                                    <input type="text" name="badge" id="badgeLabel" class="form-control"
                                           placeholder="Bestseller, New, Sale..."
                                           value="<?= $p('badge') ?>">
                                </div>
                                <div>
                                    <label class="form-label">Badge Type</label>
                                    <div class="d-flex flex-wrap gap-2 mt-1" id="badgeTypeGroup">
                                        <?php
                                        $badgeOptions = [
                                            'bestseller' => 'bg-warning text-dark',
                                            'new'        => 'bg-success text-white',
                                            'sale'       => 'bg-danger text-white',
                                            'featured'   => 'bg-primary text-white',
                                            'hot'        => 'bg-dark text-white',
                                        ];
                                        $currentBadgeType = $product['badge_type'] ?? '';
                                        foreach ($badgeOptions as $bt => $cls): ?>
                                        <button type="button"
                                            class="btn btn-sm badge-type-btn rounded-pill fw-semibold <?= $cls ?>"
                                            style="opacity:<?= $currentBadgeType === $bt ? '1' : '0.4' ?>; font-size:0.72rem;"
                                            data-val="<?= $bt ?>"
                                            onclick="setBadgeType('<?= $bt ?>',this)">
                                            <?= ucfirst($bt) ?>
                                        </button>
                                        <?php endforeach; ?>
                                    </div>
                                    <input type="hidden" name="badge_type" id="badgeTypeInput" value="<?= $p('badge_type') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Product Images Card -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                            <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-3 card-section-header">
                                <div class="rounded d-flex align-items-center justify-content-center" style="width:32px;height:32px;background:var(--yellow-subtle);">
                                    <i class="fa fa-camera" style="color:var(--yellow-primary);"></i>
                                </div>
                                <h6 class="mb-0 fw-bold text-dark text-uppercase small" style="letter-spacing:0.5px;">Product Images</h6>
                            </div>
                            <div class="card-body p-4">

                                <!-- Main Image -->
                                <label class="form-label mb-2">Main Image</label>
                                <?php
                                    $mainPhotoSrc = '';
                                    if (!empty($product['image']) && $product['image'] !== 'default.jpg') {
                                        $raw = $product['image'];
                                        $mainPhotoSrc = str_starts_with($raw, 'http') ? $raw : SITE_URL . '/' . ltrim($raw, '/');
                                    }
                                ?>
                                <?php if ($mainPhotoSrc): ?>
                                <div class="mb-2 text-center">
                                    <img src="<?= htmlspecialchars($mainPhotoSrc) ?>"
                                         id="currentMainImg"
                                         class="current-thumb shadow-sm"
                                         alt="Current main image">
                                    <div class="text-muted mt-1" style="font-size:0.7rem;">Current</div>
                                </div>
                                <?php endif; ?>
                                <div class="img-upload-zone main-zone mb-3" id="zone_image" onclick="document.getElementById('input_image').click()">
                                    <div class="upload-icon" id="uploadIcon_image"><i class="fa fa-image"></i></div>
                                    <p id="uploadLabel_image">Click to replace main image</p>
                                    <small class="text-muted d-block mt-1" id="uploadHint_image">JPG, PNG, WEBP — max 3MB. Auto-converted to WebP</small>
                                    <img id="preview_image" class="preview-img" alt="Main preview">
                                </div>
                                <input type="file" name="image" id="input_image" accept="image/*" class="d-none">

                                <!-- Additional Images -->
                                <label class="form-label mb-2">Additional Images</label>
                                <div class="row g-2">
                                    <?php
                                    $extraImages = [
                                        2 => $product['image2'] ?? '',
                                        3 => $product['image3'] ?? '',
                                        4 => $product['image4'] ?? '',
                                    ];
                                    foreach ($extraImages as $n => $imgPath):
                                        $extraSrc = '';
                                        if (!empty($imgPath)) {
                                            $extraSrc = str_starts_with($imgPath, 'http') ? $imgPath : SITE_URL . '/' . ltrim($imgPath, '/');
                                        }
                                    ?>
                                    <div class="col-4">
                                        <?php if ($extraSrc): ?>
                                        <div class="text-center mb-1">
                                            <img src="<?= htmlspecialchars($extraSrc) ?>"
                                                 id="currentImg<?= $n ?>"
                                                 class="current-thumb-sm shadow-sm"
                                                 alt="Image <?= $n ?>">
                                        </div>
                                        <?php endif; ?>
                                        <div class="img-upload-zone" id="zone_image<?= $n ?>"
                                             onclick="document.getElementById('input_image<?= $n ?>').click()">
                                            <div class="upload-icon" id="uploadIcon_image<?= $n ?>" style="font-size:1.2rem;">
                                                <i class="fa fa-<?= $extraSrc ? 'refresh' : 'plus' ?>"></i>
                                            </div>
                                            <p style="font-size:0.7rem;" id="uploadLabel_image<?= $n ?>">Image <?= $n ?></p>
                                            <img id="preview_image<?= $n ?>" class="preview-img" alt="Image <?= $n ?>">
                                        </div>
                                        <input type="file" name="image<?= $n ?>" id="input_image<?= $n ?>" accept="image/*" class="d-none">
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <small class="text-muted mt-2 d-block text-center" style="font-size:0.7rem;">
                                    ⚠️ Uploading replaces existing image. Leave blank to keep current.
                                </small>
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
                                <p class="text-muted small mb-3">Permanently delete this product. This action cannot be undone and will remove all associated data.</p>
                                <a href="./?delete=<?= $id ?>"
                                   class="btn btn-outline-danger w-100 rounded-pill fw-semibold"
                                   onclick="return confirm('Permanently delete <?= addslashes(htmlspecialchars($product['name'])) ?>? This cannot be undone.')">
                                    <i class="fa fa-trash-alt me-2"></i> Delete Product
                                </a>
                            </div>
                        </div>

                    </div><!-- /col-xl-4 -->

                </div><!-- /row -->
            </form>

        </div>
    </div>
</div>

<script>
// ── Slug ──────────────────────────────────────────────────────
document.getElementById('productName').addEventListener('input', function () {
    document.getElementById('nameCount').textContent = this.value.length + ' chars';
    document.getElementById('serpSlug').textContent  = autoSlug(this.value) || '<?= htmlspecialchars($product['slug'] ?? '') ?>';
});
document.getElementById('generateSlug').addEventListener('click', function () {
    const slug = autoSlug(document.getElementById('productName').value);
    document.getElementById('productSlug').value = slug;
    document.getElementById('serpSlug').textContent = slug || '<?= htmlspecialchars($product['slug'] ?? '') ?>';
});
document.getElementById('productSlug').addEventListener('input', function () {
    document.getElementById('serpSlug').textContent = this.value || '<?= htmlspecialchars($product['slug'] ?? '') ?>';
});
function autoSlug(str) {
    return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
}

// ── Short Desc Counter ────────────────────────────────────────
document.getElementById('shortDesc').addEventListener('input', function () {
    const c = document.getElementById('shortDescCount');
    c.textContent = this.value.length + ' chars';
    c.className   = 'count ' + (this.value.length < 200 ? 'ok' : 'warn');
});

// ── Char Counters (meta) ──────────────────────────────────────
function setupCharCounter(inputId, countId, barId, max) {
    const el  = document.getElementById(inputId);
    const cnt = document.getElementById(countId);
    const bar = barId ? document.getElementById(barId) : null;
    if (!el) return;
    // Init on load
    const initLen = el.value.length;
    updateCounter(initLen, max, cnt, bar);
    el.addEventListener('input', function () {
        updateCounter(this.value.length, max, cnt, bar);
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
function updateCounter(len, max, cnt, bar) {
    cnt.textContent = len + ' / ' + max;
    cnt.className   = 'count ' + (len < max * 0.7 ? 'ok' : len <= max ? 'warn' : 'bad');
    if (bar) {
        const pct = Math.min((len / max) * 100, 100);
        bar.style.width      = pct + '%';
        bar.style.background = len < max * 0.7 ? '#198754' : len <= max ? '#F5A623' : '#dc3545';
    }
}
setupCharCounter('metaTitle', 'metaTitleCount', 'metaTitleBar', 60);
setupCharCounter('metaDesc',  'metaDescCount',  'metaDescBar',  160);

// ── SEO Score ─────────────────────────────────────────────────
function calcSeoScore() {
    let score = 0;
    if (document.getElementById('productName').value.trim())  score += 15;
    if (document.getElementById('shortDesc').value.trim())    score += 15;
    if (document.getElementById('focusKeyword').value.trim()) score += 20;
    if (document.getElementById('metaTitle').value.trim())    score += 20;
    if (document.getElementById('metaDesc').value.trim())     score += 20;
    if (document.getElementById('productSlug').value.trim())  score += 10;
    const badge = document.getElementById('seoScoreBadge');
    badge.textContent = 'Score: ' + score + ' / 100';
    if (score >= 80) {
        badge.style.background = '#d1e7dd'; badge.style.color = '#0a3622'; badge.style.borderColor = '#badbcc';
    } else if (score >= 50) {
        badge.style.background = '#fff3cd'; badge.style.color = '#664d03'; badge.style.borderColor = '#ffecb5';
    } else {
        badge.style.background = '#f8d7da'; badge.style.color = '#58151c'; badge.style.borderColor = '#f5c2c7';
    }
}
['productName','shortDesc','focusKeyword','metaTitle','metaDesc','productSlug'].forEach(id => {
    const el = document.getElementById(id);
    if (el) el.addEventListener('input', calcSeoScore);
});
calcSeoScore(); // run on load

// ── Image Preview ─────────────────────────────────────────────
['image','image2','image3','image4'].forEach(function(key) {
    const input = document.getElementById('input_' + key);
    if (!input) return;
    input.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const zone    = document.getElementById('zone_' + key);
            const preview = document.getElementById('preview_' + key);
            preview.src           = e.target.result;
            preview.style.display = 'block';
            const icon  = document.getElementById('uploadIcon_' + key);
            const label = document.getElementById('uploadLabel_' + key);
            const hint  = document.getElementById('uploadHint_' + key);
            if (icon)  icon.style.display  = 'none';
            if (label) label.style.display = 'none';
            if (hint)  hint.style.display  = 'none';
            // Also update current img display
            const cur = document.getElementById('current' + (key === 'image' ? 'MainImg' : 'Img' + key.replace('image','')));
            if (cur) cur.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
});

// ── Badge Type ────────────────────────────────────────────────
function setBadgeType(val, btn) {
    document.querySelectorAll('.badge-type-btn').forEach(b => b.style.opacity = '0.4');
    btn.style.opacity = '1';
    document.getElementById('badgeTypeInput').value = val;
    document.getElementById('badgeLabel').value = val.charAt(0).toUpperCase() + val.slice(1);
}

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