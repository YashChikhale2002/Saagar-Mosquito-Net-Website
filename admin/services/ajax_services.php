<?php
// admin/services/ajax_services.php
require_once './../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
header('Content-Type: application/json');

if (!canAccess('services')) {
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
    SELECT COUNT(*) AS total FROM mosquito_services
    WHERE title          LIKE '$searchLike'
       OR short_desc     LIKE '$searchLike'
       OR slug           LIKE '$searchLike'
       OR focus_keyword  LIKE '$searchLike'
       OR schema_type    LIKE '$searchLike'
");
$totalRecords = $countRes ? (int)$countRes->fetch_assoc()['total'] : 0;
$totalPages   = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;

// ── Fetch ─────────────────────────────────────────────────────
$result = $conn->query("
    SELECT * FROM mosquito_services
    WHERE title         LIKE '$searchLike'
       OR short_desc    LIKE '$searchLike'
       OR slug          LIKE '$searchLike'
       OR focus_keyword LIKE '$searchLike'
       OR schema_type   LIKE '$searchLike'
    ORDER BY created_at DESC
    LIMIT $limit OFFSET $offset
");

// ── Helpers ───────────────────────────────────────────────────
function resolveServiceImgAjax($field) {
    if (empty($field)) return '';
    if (str_starts_with($field, 'http://') || str_starts_with($field, 'https://')) return $field;
    return '/Saagar-Mosquito-Net-Website/' . ltrim($field, '/');
}

function calcServiceSeoScoreAjax($service) {
    $score = 0; $issues = []; $good = [];

    // Title
    $title = $service['title'] ?? '';
    if (strlen($title) >= 40 && strlen($title) <= 70) { $score += 10; $good[] = 'Title ideal length (40–70 chars)'; }
    elseif (strlen($title) > 0)                       { $score += 5;  $issues[] = 'Title not ideal length (40–70 chars)'; }
    else                                               { $issues[] = 'Title missing'; }

    // Short Description
    $shortDesc = $service['short_desc'] ?? '';
    if (strlen($shortDesc) >= 80 && strlen($shortDesc) <= 200) { $score += 10; $good[] = 'Short description ideal length (80–200 chars)'; }
    elseif (strlen($shortDesc) > 0)                            { $score += 5;  $issues[] = 'Short description not ideal (80–200 chars)'; }
    else                                                       { $issues[] = 'Short description missing'; }

    // Full Description (word count)
    $description = $service['description'] ?? '';
    $wordCount   = str_word_count(strip_tags($description));
    if ($wordCount >= 500)     { $score += 10; $good[] = "Description 500+ words ($wordCount words)"; }
    elseif ($wordCount >= 200) { $score += 5;  $issues[] = "Description under 500 words ($wordCount words) — aim for 500+"; }
    else                       { $issues[] = 'Description too short or missing'; }

    // Slug
    if (!empty($service['slug']))          { $score += 5;  $good[] = 'URL slug set'; }
    else                                   { $issues[] = 'URL slug missing'; }

    // Focus Keyword
    if (!empty($service['focus_keyword'])) { $score += 10; $good[] = 'Focus keyword defined'; }
    else                                   { $issues[] = 'Focus keyword not set'; }

    // Main Image
    if (!empty($service['image']))         { $score += 10; $good[] = 'Main image uploaded'; }
    else                                   { $issues[] = 'No main image uploaded'; }

    // Meta Title
    if (!empty($service['meta_title']))    { $score += 5;  $good[] = 'Meta title set'; }
    else                                   { $issues[] = 'Meta title missing'; }

    // Meta Description
    $metaDesc = $service['meta_description'] ?? '';
    if (strlen($metaDesc) >= 120 && strlen($metaDesc) <= 160) { $score += 10; $good[] = 'Meta description perfect length (120–160 chars)'; }
    elseif (strlen($metaDesc) > 0)                            { $score += 5;  $issues[] = 'Meta description not ideal (120–160 chars)'; }
    else                                                      { $issues[] = 'Meta description missing'; }

    // Schema Type
    if (!empty($service['schema_type']))   { $score += 5;  $good[] = 'Schema / structured data type set'; }
    else                                   { $issues[] = 'Schema type not configured'; }

    // FAQs
    $faqs = json_decode($service['faqs'] ?? '[]', true);
    if (!empty($faqs) && count($faqs) >= 3) { $score += 10; $good[] = count($faqs) . ' FAQs added (rich result eligible)'; }
    elseif (!empty($faqs) && count($faqs) >= 1) { $score += 5; $issues[] = count($faqs) . ' FAQ(s) — add 3+ for Google rich snippets'; }
    else                                    { $issues[] = 'No FAQs added — add 3+ for rich results'; }

    // Canonical URL
    if (!empty($service['canonical_url'])) { $score += 5;  $good[] = 'Canonical URL set'; }
    else                                   { $issues[] = 'Canonical URL not set'; }

    // OG / Social
    if (!empty($service['og_title']) || !empty($service['og_description'])) { $score += 5; $good[] = 'Open Graph data filled'; }
    else                                                                     { $issues[] = 'Open Graph data missing'; }

    return ['score' => min(100, $score), 'issues' => $issues, 'good' => $good];
}

function serviceSeoGradeAjax($score) {
    if ($score >= 80) return ['A', 'text-warning'];
    if ($score >= 65) return ['B', 'text-primary'];
    if ($score >= 50) return ['C', 'text-info'];
    return ['F', 'text-danger'];
}

function serviceRankPotentialAjax($score) {
    if ($score >= 80) return 'Top 10';
    if ($score >= 65) return 'Top 30';
    if ($score >= 50) return 'Top 50';
    return 'Low';
}

// ── Build rows ────────────────────────────────────────────────
$rows       = [];
$seoDataMap = [];

if ($result && $result->num_rows > 0) {
    while ($service = $result->fetch_assoc()) {

        $seo    = calcServiceSeoScoreAjax($service);
        $score  = $seo['score'];
        [$grade, $gradeTextColor] = serviceSeoGradeAjax($score);
        $issueCount   = count($seo['issues']);
        $gradeBgClass = str_replace('text-', 'bg-', $gradeTextColor);

        $imgSrc      = resolveServiceImgAjax($service['image'] ?? '');
        $isActive    = (bool)($service['is_active'] ?? 0);
        $createdDate = !empty($service['created_at'])
            ? date('d M Y', strtotime($service['created_at']))
            : '—';

        // Decode JSON lists for counts
        $servicesList   = json_decode($service['services_list'] ?? '[]', true) ?: [];
        $featuresList   = json_decode($service['features_list']  ?? '[]', true) ?: [];
        $faqsList       = json_decode($service['faqs']           ?? '[]', true) ?: [];
        $totalListItems = count($servicesList) + count($featuresList);

        // Keywords array for badge display
        $keywords = array_slice(
            array_filter(array_map('trim', explode(',', $service['focus_keyword'] ?? ''))),
            0, 2
        );

        // SEO Data for JS modal
        $seoDataMap[$service['id']] = [
            'name'           => $service['title'],
            'score'          => (int)$score,
            'grade'          => $grade,
            'gradeTextClass' => $gradeTextColor,
            'issues'         => $seo['issues'],
            'good'           => $seo['good'],
            'rank'           => serviceRankPotentialAjax($score),
            'schema_type'    => $service['schema_type']     ?? '',
            'focus_keyword'  => $service['focus_keyword']   ?? '',
            'slug'           => $service['slug']            ?? '',
            'short_desc'     => $service['short_desc']      ?? '',
            'is_active'      => $isActive,
            'created_at'     => $createdDate,
            'faqs_count'     => count($faqsList),
            'editUrl'        => 'edit.php?id=' . $service['id'],
            'viewUrl'        => '/Saagar-Mosquito-Net-Website/service-details.php?slug=' . ($service['slug'] ?? ''),
        ];

        ob_start();
        ?>
        <tr class="border-bottom border-light">

            <!-- Service Title & Image -->
            <td class="ps-4 py-3" style="max-width:290px;">
                <div class="d-flex align-items-center gap-3">
                    <?php if (!empty($imgSrc)): ?>
                    <img src="<?= htmlspecialchars($imgSrc) ?>"
                        style="width:56px;height:56px;object-fit:cover;border-radius:10px;border:2px solid #bbf7d0;background:#fff;"
                        class="shadow-sm flex-shrink-0"
                        alt="<?= htmlspecialchars($service['title']) ?>"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div style="width:56px;height:56px;border-radius:10px;background:#dcfce7;display:none;align-items:center;justify-content:center;color:#16a34a;font-size:1.4rem;border:2px solid #bbf7d0;flex-shrink:0;">
                        <i class="fa fa-concierge-bell"></i>
                    </div>
                    <?php else: ?>
                    <div style="width:56px;height:56px;border-radius:10px;background:#dcfce7;display:flex;align-items:center;justify-content:center;color:#16a34a;font-size:1.4rem;border:2px solid #bbf7d0;flex-shrink:0;">
                        <i class="fa fa-concierge-bell"></i>
                    </div>
                    <?php endif; ?>

                    <div style="min-width:0;max-width:200px;">
                        <h6 class="mb-1 fw-bold text-dark" style="word-break:break-word;white-space:normal;line-height:1.3;"
                            title="<?= htmlspecialchars($service['title']) ?>">
                            <?= htmlspecialchars(mb_strimwidth($service['title'], 0, 55, '…')) ?>
                        </h6>
                        <?php if (!empty($service['slug'])): ?>
                        <div class="small text-muted" style="font-size:0.72rem;">
                            <i class="fa fa-link me-1" style="color:#16a34a;"></i><?= htmlspecialchars(mb_strimwidth($service['slug'], 0, 30, '…')) ?>
                        </div>
                        <?php endif; ?>
                        <div class="small text-muted" style="font-size:0.72rem;">
                            <i class="fa fa-calendar me-1"></i><?= $createdDate ?>
                        </div>
                    </div>
                </div>
            </td>

            <!-- Schema / Keyword -->
            <td class="py-3">
                <?php if (!empty($service['schema_type'])): ?>
                <span class="badge rounded-pill px-3 py-2 fw-medium border d-inline-block mb-1"
                    style="background:#dcfce7;color:#15803d;border-color:#bbf7d0;font-size:0.78rem;">
                    <i class="fa fa-code me-1"></i><?= htmlspecialchars($service['schema_type']) ?>
                </span>
                <?php else: ?>
                <span class="text-muted small fst-italic d-block mb-1">No schema</span>
                <?php endif; ?>
                <?php if (!empty($keywords)): ?>
                <div class="d-flex flex-wrap gap-1">
                    <?php foreach ($keywords as $kw): ?>
                    <span class="badge rounded-pill border fw-normal"
                        style="background:#f8f9fa;color:#6b7280;border-color:#e5e7eb;font-size:0.68rem;">
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
                <div class="d-inline-flex align-items-center gap-3"
                    onclick="openSeoModal(<?= $service['id'] ?>)"
                    data-bs-toggle="tooltip" title="Click for SEO details"
                    style="cursor:pointer;">
                    <div class="position-relative" style="width:44px;height:44px;">
                        <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#bbf7d0" stroke-width="3"></circle>
                            <circle cx="18" cy="18" r="15.9" fill="none" class="<?= $gradeTextColor ?>"
                                stroke="currentColor" stroke-width="3"
                                stroke-dasharray="100 100"
                                stroke-dashoffset="<?= 100 - $score ?>"
                                stroke-linecap="round"
                                style="transition:stroke-dashoffset 1s ease-out;"></circle>
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle fw-bold <?= $gradeTextColor ?>"
                            style="font-size:0.78rem;"><?= $score ?></div>
                    </div>
                    <div class="d-flex flex-column align-items-start">
                        <span class="badge <?= $gradeBgClass ?> text-white rounded-pill px-2 py-1 fw-bold mb-1"
                            style="font-size:0.72rem;">Grade <?= $grade ?></span>
                        <span class="badge rounded-pill fw-semibold <?= $issueCount === 0 ? 'bg-success-subtle text-success-emphasis' : '' ?>"
                            style="<?= $issueCount > 0 ? 'background:#dcfce7;color:#15803d;' : '' ?> font-size:0.7rem;">
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
                <div class="d-flex align-items-center gap-1 mb-1">
                    <i class="fa fa-list-ul" style="font-size:0.8rem;color:#16a34a;"></i>
                    <span class="small fw-bold text-dark ms-1"><?= $totalListItems ?></span>
                    <span class="small text-muted">list items</span>
                </div>
                <div class="small text-muted">
                    <i class="fa fa-question-circle me-1" style="color:#6366f1;"></i><?= count($faqsList) ?> FAQ<?= count($faqsList) !== 1 ? 's' : '' ?>
                </div>
                <?php if (!empty($service['schema_type'])): ?>
                <div class="small text-muted mt-1" style="font-size:0.72rem;">
                    <i class="fa fa-code me-1 text-info"></i><?= htmlspecialchars($service['schema_type']) ?>
                </div>
                <?php endif; ?>
            </td>

            <!-- Status -->
            <td class="py-3">
                <a href="./?toggle=<?= $service['id'] ?>" class="text-decoration-none">
                    <?php if ($isActive): ?>
                    <span class="badge rounded-pill py-1 px-2 fw-semibold border d-block mb-1"
                        style="background:#dcfce7;color:#15803d;border-color:#bbf7d0;font-size:0.72rem;width:fit-content;">
                        <span class="d-inline-block rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;background:#16a34a;"></span>Active
                    </span>
                    <?php else: ?>
                    <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle rounded-pill py-1 px-2 fw-semibold d-block mb-1"
                        style="font-size:0.72rem;width:fit-content;">
                        <span class="d-inline-block bg-secondary rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>Inactive
                    </span>
                    <?php endif; ?>
                </a>
                <?php
                    $robotsMeta = $service['robots_meta'] ?? 'index,follow';
                    $isIndexed  = !str_contains($robotsMeta, 'noindex');
                ?>
                <div class="mt-1">
                    <span class="badge rounded-pill py-1 px-2 fw-semibold border" style="font-size:0.7rem;
                        <?= $isIndexed
                            ? 'background:#dcfce7;color:#15803d;border-color:#bbf7d0;'
                            : 'background:#f8d7da;color:#842029;border-color:#f5c2c7;' ?>">
                        <i class="fa fa-<?= $isIndexed ? 'check' : 'ban' ?> me-1"></i><?= $isIndexed ? 'Indexed' : 'No-Index' ?>
                    </span>
                </div>
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
                        onclick="return confirm('Permanently delete &quot;<?= addslashes(htmlspecialchars($service['title'])) ?>&quot;? This cannot be undone.')"
                        data-bs-toggle="tooltip" title="Delete Service">
                        <i class="fa fa-trash-alt"></i>
                    </a>
                </div>
            </td>

        </tr>
        <?php
        $rows[] = ob_get_clean();
    }
}

// ── Empty State ───────────────────────────────────────────────
$emptyRow = '<tr><td colspan="6" class="text-center py-5">
    <div class="py-4">
        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle"
            style="width:80px;height:80px;background:#dcfce7;">
            <i class="fa fa-concierge-bell fs-1" style="color:#16a34a;opacity:0.6;"></i>
        </div>
        <h5 class="text-dark fw-bold">No services found</h5>
        <p class="text-muted mb-4">Try a different search or add a new service.</p>
        <a href="add" class="btn rounded-pill px-4 shadow-sm fw-semibold text-white"
            style="background:linear-gradient(135deg,#16a34a,#15803d);">
            <i class="fa fa-plus me-2"></i>Add Service
        </a>
    </div>
</td></tr>';

// ── Response ──────────────────────────────────────────────────
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