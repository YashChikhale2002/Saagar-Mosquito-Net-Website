<?php
// admin/products/ajax_products.php
require_once './../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
header('Content-Type: application/json');

if (!canAccess('products')) {
    echo json_encode(['error' => 'Forbidden']);
    exit;
}

$limit  = 10;
$page   = isset($_GET['page']) && is_numeric($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$searchLike = '%' . $conn->real_escape_string($search) . '%';

// ── Count ─────────────────────────────────────────────────────
$countRes = $conn->query("
    SELECT COUNT(*) AS total FROM products
    WHERE name LIKE '$searchLike'
       OR category LIKE '$searchLike'
       OR brand LIKE '$searchLike'
       OR sku LIKE '$searchLike'
       OR tags LIKE '$searchLike'
");
$totalRecords = $countRes ? (int)$countRes->fetch_assoc()['total'] : 0;
$totalPages   = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;

// ── Fetch ─────────────────────────────────────────────────────
$result = $conn->query("
    SELECT * FROM products
    WHERE name LIKE '$searchLike'
       OR category LIKE '$searchLike'
       OR brand LIKE '$searchLike'
       OR sku LIKE '$searchLike'
       OR tags LIKE '$searchLike'
    ORDER BY created_at DESC
    LIMIT $limit OFFSET $offset
");

// ── Helpers (inline — no separate file needed) ────────────────
function resolveImgAjax($field) {
    if (empty($field)) return '';
    if (str_starts_with($field, 'http://') || str_starts_with($field, 'https://')) return $field;
    return '/nirajindustries/' . ltrim($field, '/');
}

function calcProductSeoScoreAjax($prod) {
    $score = 0; $issues = []; $good = [];

    $name = $prod['name'] ?? '';
    if (strlen($name) >= 30 && strlen($name) <= 70) { $score += 10; $good[] = 'Product name ideal length'; }
    elseif (strlen($name) > 0)                      { $score += 5;  $issues[] = 'Product name not ideal (30–70 chars)'; }
    else                                             { $issues[] = 'Product name missing'; }

    $desc = $prod['description'] ?? '';
    if (strlen($desc) >= 80 && strlen($desc) <= 200) { $score += 10; $good[] = 'Short description perfect'; }
    elseif (strlen($desc) > 0)                       { $score += 5;  $issues[] = 'Short description not ideal (80–200 chars)'; }
    else                                              { $issues[] = 'Short description missing'; }

    if (!empty($prod['full_description']) && strlen($prod['full_description']) >= 200) { $score += 10; $good[] = 'Full description filled'; }
    else { $issues[] = 'Full description missing or too short'; }

    if (!empty($prod['slug']))           { $score += 5;  $good[] = 'URL slug set'; }
    else                                 { $issues[] = 'URL slug missing'; }

    if (!empty($prod['category']))       { $score += 5;  $good[] = 'Category assigned'; }
    else                                 { $issues[] = 'No category assigned'; }

    if (!empty($prod['image']) && $prod['image'] !== 'default.jpg') { $score += 10; $good[] = 'Main image uploaded'; }
    else                                 { $issues[] = 'No main product image'; }

    if (!empty($prod['tags']))           { $score += 10; $good[] = 'Tags added'; }
    else                                 { $issues[] = 'No tags added'; }

    if (!empty($prod['brand']))          { $score += 5;  $good[] = 'Brand specified'; }
    else                                 { $issues[] = 'Brand not set'; }

    if (!empty($prod['sku']))            { $score += 5;  $good[] = 'SKU defined'; }
    else                                 { $issues[] = 'SKU missing'; }

    if (!empty($prod['specifications'])) { $score += 10; $good[] = 'Specifications added'; }
    else                                 { $issues[] = 'No specifications'; }

    if (!empty($prod['features']))       { $score += 5;  $good[] = 'Features listed'; }
    else                                 { $issues[] = 'Features not listed'; }

    if (!empty($prod['applications']))   { $score += 5;  $good[] = 'Applications described'; }
    else                                 { $issues[] = 'Applications not described'; }

    if (!empty($prod['certifications'])) { $score += 5;  $good[] = 'Certifications added'; }
    else                                 { $issues[] = 'No certifications listed'; }

    if (!empty($prod['image2']) || !empty($prod['image3'])) { $score += 5; $good[] = 'Multiple images uploaded'; }
    else                                 { $issues[] = 'Only one image uploaded'; }

    return ['score' => min(100, $score), 'issues' => $issues, 'good' => $good];
}

function seoGradeAjax($score) {
    if ($score >= 80) return ['A', 'text-warning'];
    if ($score >= 65) return ['B', 'text-primary'];
    if ($score >= 50) return ['C', 'text-info'];
    return ['F', 'text-danger'];
}

function rankPotentialAjax($score) {
    if ($score >= 80) return 'Top 10';
    if ($score >= 65) return 'Top 30';
    if ($score >= 50) return 'Top 50';
    return 'Low';
}

function getBadgeHtmlAjax($badge, $badgeType) {
    if (empty($badge)) return '';
    $colorMap = [
        'bestseller' => 'bg-warning text-dark',
        'new'        => 'bg-success text-white',
        'sale'       => 'bg-danger text-white',
        'featured'   => 'bg-primary text-white',
        'hot'        => 'bg-secondary text-white',
    ];
    $cls = $colorMap[strtolower($badgeType ?? $badge)] ?? 'bg-secondary text-white';
    return '<span class="badge ' . $cls . ' rounded-pill px-2 py-1 fw-semibold" style="font-size:0.65rem;">' . htmlspecialchars($badge) . '</span>';
}

// ── Build rows ────────────────────────────────────────────────
$rows       = [];
$seoDataMap = [];

if ($result && $result->num_rows > 0) {
    while ($prod = $result->fetch_assoc()) {

        $seo    = calcProductSeoScoreAjax($prod);
        $score  = $seo['score'];
        [$grade, $gradeTextColor] = seoGradeAjax($score);
        $issueCount   = count($seo['issues']);
        $gradeBgClass = str_replace('text-', 'bg-', $gradeTextColor);

        $imgSrc   = resolveImgAjax($prod['image'] ?? '');
        $rating   = (float)($prod['rating'] ?? 0);
        $reviews  = (int)($prod['reviews'] ?? 0);
        $inStock  = (bool)($prod['in_stock'] ?? 0);
        $isActive = (bool)($prod['is_active'] ?? 0);

        // SEO Data for JS modal
        $seoDataMap[$prod['id']] = [
            'name'           => $prod['name'],
            'score'          => (int)$score,
            'grade'          => $grade,
            'gradeTextClass' => $gradeTextColor,
            'issues'         => $seo['issues'],
            'good'           => $seo['good'],
            'rating'         => $rating,
            'reviews'        => $reviews,
            'rank'           => rankPotentialAjax($score),
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

        ob_start();
        ?>
        <tr class="border-bottom border-light">

            <!-- Product Name & Image -->
            <td class="ps-4 py-3" style="max-width:270px;">
                <div class="d-flex align-items-center gap-3">
                    <?php if (!empty($imgSrc) && ($prod['image'] ?? '') !== 'default.jpg'): ?>
                    <img src="<?= htmlspecialchars($imgSrc) ?>"
                        style="width:56px;height:56px;object-fit:cover;border-radius:10px;border:2px solid #FDDFA0;background:#fff;"
                        class="shadow-sm"
                        alt="<?= htmlspecialchars($prod['name']) ?>"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div style="width:56px;height:56px;border-radius:10px;background:#FEF3CD;display:none;align-items:center;justify-content:center;color:#F5A623;font-size:1.4rem;border:2px solid #FDDFA0;flex-shrink:0;">
                        <i class="fa fa-image"></i>
                    </div>
                    <?php else: ?>
                    <div style="width:56px;height:56px;border-radius:10px;background:#FEF3CD;display:flex;align-items:center;justify-content:center;color:#F5A623;font-size:1.4rem;border:2px solid #FDDFA0;flex-shrink:0;">
                        <i class="fa fa-image"></i>
                    </div>
                    <?php endif; ?>

                    <div style="min-width:0;max-width:190px;">
                        <h6 class="mb-1 fw-bold text-dark" style="word-break:break-word;white-space:normal;line-height:1.3;"
                            title="<?= htmlspecialchars($prod['name']) ?>">
                            <?= htmlspecialchars($prod['name']) ?>
                        </h6>
                        <?php if (!empty($prod['badge'])): ?>
                        <div class="mb-1"><?= getBadgeHtmlAjax($prod['badge'], $prod['badge_type'] ?? '') ?></div>
                        <?php endif; ?>
                        <?php if (!empty($prod['sku'])): ?>
                        <div class="small text-muted" style="font-size:0.72rem;">
                            <i class="fa fa-barcode me-1"></i>SKU: <?= htmlspecialchars($prod['sku']) ?>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($prod['moq'])): ?>
                        <div class="small text-muted" style="font-size:0.72rem;">
                            <i class="fa fa-cubes me-1" style="color:#F5A623;"></i>MOQ: <?= htmlspecialchars($prod['moq']) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </td>

            <!-- Category / Brand -->
            <td class="py-3">
                <?php if (!empty($prod['category'])): ?>
                <span class="badge rounded-pill px-3 py-2 fw-medium border d-inline-block mb-1"
                    style="background:#FEF3CD;color:#E08E00;border-color:#FDDFA0;font-size:0.78rem;">
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
                <div class="d-inline-flex align-items-center gap-3"
                    onclick="openSeoModal(<?= $prod['id'] ?>)"
                    data-bs-toggle="tooltip" title="Click for SEO details"
                    style="cursor:pointer;">
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
                            style="<?= $issueCount > 0 ? 'background:#FEF3CD;color:#E08E00;' : '' ?> font-size:0.7rem;">
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
                    <i class="fa fa-star" style="font-size:0.75rem;color:<?= $i <= round($rating) ? '#F5A623' : '#dee2e6' ?>;"></i>
                    <?php endfor; ?>
                    <span class="small fw-bold text-dark ms-1"><?= number_format($rating, 1) ?></span>
                </div>
                <div class="small text-muted">
                    <i class="fa fa-comment me-1" style="color:#F5A623;"></i><?= number_format($reviews) ?> reviews
                </div>
                <?php if (!empty($prod['availability'])): ?>
                <div class="small text-muted mt-1" style="font-size:0.72rem;">
                    <i class="fa fa-clock me-1 text-info"></i><?= htmlspecialchars($prod['availability']) ?>
                </div>
                <?php endif; ?>
            </td>

            <!-- Stock / Status -->
            <td class="py-3">
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
                <a href="./?toggle=<?= $prod['id'] ?>" class="text-decoration-none">
                    <?php if ($isActive): ?>
                    <span class="badge rounded-pill py-1 px-2 fw-semibold border" style="background:#FEF3CD;color:#E08E00;border-color:#FDDFA0;font-size:0.72rem;">
                        <span class="d-inline-block rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;background:#F5A623;"></span>Active
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
                        onclick="return confirm('Permanently delete &quot;<?= addslashes(htmlspecialchars($prod['name'])) ?>&quot;? This cannot be undone.')"
                        data-bs-toggle="tooltip" title="Delete Product">
                        <i class="fa fa-trash-alt"></i>
                    </a>
                </div>
            </td>

        </tr>
        <?php
        $rows[] = ob_get_clean();
    }
}

// ── Response ──────────────────────────────────────────────────
$emptyRow = '<tr><td colspan="6" class="text-center py-5">
    <div class="py-4">
        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width:80px;height:80px;background:#FEF3CD;">
            <i class="fa fa-box-open fs-1" style="color:#F5A623;opacity:0.6;"></i>
        </div>
        <h5 class="text-dark fw-bold">No products found</h5>
        <p class="text-muted mb-4">Try a different search or add a new product.</p>
        <a href="add" class="btn rounded-pill px-4 shadow-sm fw-semibold text-white" style="background:linear-gradient(135deg,#F5A623,#E08E00);">
            <i class="fa fa-plus me-2"></i>Add Product
        </a>
    </div>
</td></tr>';

echo json_encode([
    'rows'         => !empty($rows) ? implode('', $rows) : $emptyRow,
    'seoData'      => $seoDataMap,
    'totalRecords' => $totalRecords,
    'totalPages'   => $totalPages,
    'currentPage'  => $page,
    'offset'       => $offset,
    'limit'        => $limit,
    'search'       => $search,
]);