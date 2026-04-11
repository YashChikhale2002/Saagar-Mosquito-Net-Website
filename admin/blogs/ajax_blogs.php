<?php
// admin/blogs/ajax_blogs.php
require_once './../../include/config.php';
require_once __DIR__ . '/../include/auth.php';
header('Content-Type: application/json');

if (!canAccess('blogs')) {
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
    SELECT COUNT(*) AS total FROM blogs
    WHERE title LIKE '$searchLike'
       OR excerpt LIKE '$searchLike'
       OR tags LIKE '$searchLike'
       OR slug LIKE '$searchLike'
       OR focus_keyword LIKE '$searchLike'
");
$totalRecords = $countRes ? (int)$countRes->fetch_assoc()['total'] : 0;
$totalPages   = $totalRecords > 0 ? (int)ceil($totalRecords / $limit) : 1;

// ── Fetch ─────────────────────────────────────────────────────
$result = $conn->query("
    SELECT * FROM blogs
    WHERE title LIKE '$searchLike'
       OR excerpt LIKE '$searchLike'
       OR tags LIKE '$searchLike'
       OR slug LIKE '$searchLike'
       OR focus_keyword LIKE '$searchLike'
    ORDER BY created_at DESC
    LIMIT $limit OFFSET $offset
");

// ── Helpers ───────────────────────────────────────────────────
function resolveBlogImgAjax($field) {
    if (empty($field)) return '';
    if (str_starts_with($field, 'http://') || str_starts_with($field, 'https://')) return $field;
    return '/nirajindustries/' . ltrim($field, '/');
}

function calcBlogSeoScoreAjax($blog) {
    $score = 0; $issues = []; $good = [];

    // Title
    $title = $blog['title'] ?? '';
    if (strlen($title) >= 30 && strlen($title) <= 70) { $score += 10; $good[] = 'Title ideal length (30–70 chars)'; }
    elseif (strlen($title) > 0)                       { $score += 5;  $issues[] = 'Title not ideal length (30–70 chars)'; }
    else                                               { $issues[] = 'Title missing'; }

    // Excerpt
    $excerpt = $blog['excerpt'] ?? '';
    if (strlen($excerpt) >= 80 && strlen($excerpt) <= 200) { $score += 10; $good[] = 'Excerpt ideal length (80–200 chars)'; }
    elseif (strlen($excerpt) > 0)                          { $score += 5;  $issues[] = 'Excerpt not ideal (80–200 chars)'; }
    else                                                   { $issues[] = 'Excerpt missing'; }

    // Full content
    $content   = $blog['content'] ?? '';
    $wordCount = str_word_count(strip_tags($content));
    if ($wordCount >= 800)      { $score += 10; $good[] = 'Content 800+ words'; }
    elseif ($wordCount >= 300)  { $score += 5;  $issues[] = 'Content under 800 words (aim for 800+)'; }
    else                        { $issues[] = 'Content too short or missing'; }

    // Slug
    if (!empty($blog['slug']))           { $score += 5;  $good[] = 'URL slug set'; }
    else                                 { $issues[] = 'URL slug missing'; }

    // Category
    if (!empty($blog['categories']) && (int)$blog['categories'] > 0) { $score += 5; $good[] = 'Category assigned'; }
    else                                 { $issues[] = 'No category assigned'; }

    // Featured Image
    if (!empty($blog['image'])) { $score += 10; $good[] = 'Featured image uploaded'; }
    else                        { $issues[] = 'No featured image'; }

    // Tags
    if (!empty($blog['tags']))           { $score += 10; $good[] = 'Tags added'; }
    else                                 { $issues[] = 'No tags added'; }

    // Focus Keyword
    if (!empty($blog['focus_keyword'])) { $score += 10; $good[] = 'Focus keyword set'; }
    else                                { $issues[] = 'Focus keyword missing'; }

    // Meta Title
    if (!empty($blog['meta_title']))    { $score += 5;  $good[] = 'Meta title set'; }
    else                                { $issues[] = 'Meta title missing'; }

    // Meta Description
    $metaDesc = $blog['meta_description'] ?? '';
    if (strlen($metaDesc) >= 120 && strlen($metaDesc) <= 160) { $score += 10; $good[] = 'Meta description perfect length'; }
    elseif (strlen($metaDesc) > 0)                            { $score += 5;  $issues[] = 'Meta description not ideal (120–160 chars)'; }
    else                                                      { $issues[] = 'Meta description missing'; }

    // Schema
    if (!empty($blog['schema_type']))   { $score += 5;  $good[] = 'Schema type set'; }
    else                                { $issues[] = 'Schema type not set'; }

    // Canonical URL
    if (!empty($blog['canonical_url'])) { $score += 5;  $good[] = 'Canonical URL set'; }
    else                                { $issues[] = 'Canonical URL not set'; }

    // OG / Social
    if (!empty($blog['og_title']) || !empty($blog['og_description'])) { $score += 5; $good[] = 'Open Graph data filled'; }
    else { $issues[] = 'Open Graph data missing'; }

    return ['score' => min(100, $score), 'issues' => $issues, 'good' => $good];
}

function blogSeoGradeAjax($score) {
    if ($score >= 80) return ['A', 'text-warning'];
    if ($score >= 65) return ['B', 'text-primary'];
    if ($score >= 50) return ['C', 'text-info'];
    return ['F', 'text-danger'];
}

function blogRankPotentialAjax($score) {
    if ($score >= 80) return 'Top 10';
    if ($score >= 65) return 'Top 30';
    if ($score >= 50) return 'Top 50';
    return 'Low';
}

function getBlogCategoryName($conn, $catId) {
    if (empty($catId) || (int)$catId === 0) return '';
    $id  = (int)$catId;
    $res = $conn->query("SELECT name FROM blog_categories WHERE id = $id LIMIT 1");
    if ($res && $res->num_rows > 0) return $res->fetch_assoc()['name'];
    return '';
}

// ── Build rows ────────────────────────────────────────────────
$rows       = [];
$seoDataMap = [];

if ($result && $result->num_rows > 0) {
    while ($blog = $result->fetch_assoc()) {

        $seo    = calcBlogSeoScoreAjax($blog);
        $score  = $seo['score'];
        [$grade, $gradeTextColor] = blogSeoGradeAjax($score);
        $issueCount   = count($seo['issues']);
        $gradeBgClass = str_replace('text-', 'bg-', $gradeTextColor);

        $imgSrc      = resolveBlogImgAjax($blog['image'] ?? '');
        $isPublished = (bool)($blog['is_published'] ?? 0);
        $views       = (int)($blog['views']    ?? 0);
        $comments    = (int)($blog['comments'] ?? 0);
        $readingTime = (int)($blog['reading_time'] ?? 0);
        $catName     = getBlogCategoryName($conn, $blog['categories'] ?? 0);

        $publishedDate = !empty($blog['published_at'])
            ? date('d M Y', strtotime($blog['published_at']))
            : '—';

        // SEO Data for JS modal
        $seoDataMap[$blog['id']] = [
            'name'           => $blog['title'],
            'score'          => (int)$score,
            'grade'          => $grade,
            'gradeTextClass' => $gradeTextColor,
            'issues'         => $seo['issues'],
            'good'           => $seo['good'],
            'views'          => $views,
            'comments'       => $comments,
            'rank'           => blogRankPotentialAjax($score),
            'category'       => $catName,
            'tags'           => $blog['tags']          ?? '',
            'slug'           => $blog['slug']          ?? '',
            'focusKeyword'   => $blog['focus_keyword'] ?? '',
            'metaTitle'      => $blog['meta_title']    ?? '',
            'metaDesc'       => $blog['meta_description'] ?? '',
            'schemaType'     => $blog['schema_type']   ?? '',
            'readingTime'    => $readingTime,
            'publishedAt'    => $publishedDate,
            'editUrl'        => 'edit.php?id=' . $blog['id'],
            'viewUrl'        => '/nirajindustries/blog/' . ($blog['slug'] ?? ''),
        ];

        ob_start();
        ?>
        <tr class="border-bottom border-light">

            <!-- Blog Title & Image -->
            <td class="ps-4 py-3" style="max-width:290px;">
                <div class="d-flex align-items-center gap-3">
                    <?php if (!empty($imgSrc)): ?>
                    <img src="<?= htmlspecialchars($imgSrc) ?>"
                        style="width:56px;height:56px;object-fit:cover;border-radius:10px;border:2px solid #bae6fd;background:#fff;"
                        class="shadow-sm flex-shrink-0"
                        alt="<?= htmlspecialchars($blog['title']) ?>"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">
                    <div style="width:56px;height:56px;border-radius:10px;background:#e0f2fe;display:none;align-items:center;justify-content:center;color:#0369a1;font-size:1.4rem;border:2px solid #bae6fd;flex-shrink:0;">
                        <i class="fa fa-image"></i>
                    </div>
                    <?php else: ?>
                    <div style="width:56px;height:56px;border-radius:10px;background:#e0f2fe;display:flex;align-items:center;justify-content:center;color:#0369a1;font-size:1.4rem;border:2px solid #bae6fd;flex-shrink:0;">
                        <i class="fa fa-image"></i>
                    </div>
                    <?php endif; ?>

                    <div style="min-width:0;max-width:200px;">
                        <h6 class="mb-1 fw-bold text-dark" style="word-break:break-word;white-space:normal;line-height:1.3;"
                            title="<?= htmlspecialchars($blog['title']) ?>">
                            <?= htmlspecialchars($blog['title']) ?>
                        </h6>
                        <?php if (!empty($blog['slug'])): ?>
                        <div class="small text-muted" style="font-size:0.72rem;">
                            <i class="fa fa-link me-1" style="color:#0369a1;"></i><?= htmlspecialchars($blog['slug']) ?>
                        </div>
                        <?php endif; ?>
                        <?php if ($readingTime > 0): ?>
                        <div class="small text-muted" style="font-size:0.72rem;">
                            <i class="fa fa-clock me-1" style="color:#0369a1;"></i><?= $readingTime ?> min read
                        </div>
                        <?php endif; ?>
                        <div class="small text-muted" style="font-size:0.72rem;">
                            <i class="fa fa-calendar me-1"></i><?= $publishedDate ?>
                        </div>
                    </div>
                </div>
            </td>

            <!-- Category / Tags -->
            <td class="py-3">
                <?php if (!empty($catName)): ?>
                <span class="badge rounded-pill px-3 py-2 fw-medium border d-inline-block mb-1"
                    style="background:#e0f2fe;color:#0369a1;border-color:#bae6fd;font-size:0.78rem;">
                    <i class="fa fa-layer-group me-1"></i><?= htmlspecialchars($catName) ?>
                </span>
                <?php else: ?>
                <span class="text-muted small fst-italic">No category</span>
                <?php endif; ?>
                <?php if (!empty($blog['tags'])): ?>
                <div class="small text-muted mt-1" style="font-size:0.73rem;max-width:150px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"
                    title="<?= htmlspecialchars($blog['tags']) ?>">
                    <i class="fa fa-tags me-1" style="color:#0369a1;"></i><?= htmlspecialchars($blog['tags']) ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($blog['focus_keyword'])): ?>
                <div class="small text-muted mt-1" style="font-size:0.72rem;">
                    <i class="fa fa-key me-1 text-warning"></i><?= htmlspecialchars($blog['focus_keyword']) ?>
                </div>
                <?php endif; ?>
            </td>

            <!-- SEO Health -->
            <td class="py-3 text-center">
                <div class="d-inline-flex align-items-center gap-3"
                    onclick="openSeoModal(<?= $blog['id'] ?>)"
                    data-bs-toggle="tooltip" title="Click for SEO details"
                    style="cursor:pointer;">
                    <div class="position-relative" style="width:44px;height:44px;">
                        <svg viewBox="0 0 36 36" class="w-100 h-100" style="transform:rotate(-90deg);">
                            <circle cx="18" cy="18" r="15.9" fill="none" stroke="#bfdbfe" stroke-width="3"></circle>
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
                            style="<?= $issueCount > 0 ? 'background:#e0f2fe;color:#0369a1;' : '' ?> font-size:0.7rem;">
                            <?php if ($issueCount === 0): ?>
                            <i class="fa fa-check me-1"></i>Perfect
                            <?php else: ?>
                            <i class="fa fa-exclamation-triangle me-1"></i><?= $issueCount ?> Issues
                            <?php endif; ?>
                        </span>
                    </div>
                </div>
            </td>

            <!-- Views & Comments -->
            <td class="py-3" style="min-width:130px;">
                <div class="d-flex align-items-center gap-1 mb-1">
                    <i class="fa fa-eye" style="font-size:0.8rem;color:#0369a1;"></i>
                    <span class="small fw-bold text-dark ms-1"><?= number_format($views) ?></span>
                    <span class="small text-muted">views</span>
                </div>
                <div class="small text-muted">
                    <i class="fa fa-comment me-1" style="color:#0369a1;"></i><?= number_format($comments) ?> comments
                </div>
                <?php if (!empty($blog['schema_type'])): ?>
                <div class="small text-muted mt-1" style="font-size:0.72rem;">
                    <i class="fa fa-code me-1 text-info"></i><?= htmlspecialchars($blog['schema_type']) ?>
                </div>
                <?php endif; ?>
            </td>

            <!-- Status -->
            <td class="py-3">
                <a href="./?toggle=<?= $blog['id'] ?>" class="text-decoration-none">
                    <?php if ($isPublished): ?>
                    <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle rounded-pill py-1 px-2 fw-semibold" style="font-size:0.72rem;">
                        <span class="d-inline-block bg-success rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>Published
                    </span>
                    <?php else: ?>
                    <span class="badge bg-secondary-subtle text-secondary-emphasis border border-secondary-subtle rounded-pill py-1 px-2 fw-semibold" style="font-size:0.72rem;">
                        <span class="d-inline-block bg-secondary rounded-circle me-1" style="width:6px;height:6px;vertical-align:middle;"></span>Draft
                    </span>
                    <?php endif; ?>
                </a>
                <?php
                    $robotsMeta = $blog['robots_meta'] ?? 'index,follow';
                    $isIndexed  = str_contains($robotsMeta, 'noindex') ? false : true;
                ?>
                <div class="mt-1">
                    <span class="badge rounded-pill py-1 px-2 fw-semibold border" style="font-size:0.7rem;
                        <?= $isIndexed ? 'background:#e0f2fe;color:#0369a1;border-color:#bae6fd;' : 'background:#f8d7da;color:#842029;border-color:#f5c2c7;' ?>">
                        <i class="fa fa-<?= $isIndexed ? 'check' : 'ban' ?> me-1"></i><?= $isIndexed ? 'Indexed' : 'No-Index' ?>
                    </span>
                </div>
            </td>

            <!-- Actions -->
            <td class="py-3 text-end pe-4">
                <div class="btn-group shadow-sm border rounded-pill overflow-hidden bg-white">
                    <a href="<?= SITE_URL ?>/blog/<?= htmlspecialchars($blog['slug'] ?? '') ?>"
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
                        onclick="return confirm('Permanently delete &quot;<?= addslashes(htmlspecialchars($blog['title'])) ?>&quot;? This cannot be undone.')"
                        data-bs-toggle="tooltip" title="Delete Blog">
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
        <div class="d-inline-flex align-items-center justify-content-center mb-3 rounded-circle" style="width:80px;height:80px;background:#e0f2fe;">
            <i class="fa fa-newspaper fs-1" style="color:#0369a1;opacity:0.6;"></i>
        </div>
        <h5 class="text-dark fw-bold">No blogs found</h5>
        <p class="text-muted mb-4">Try a different search or write a new blog.</p>
        <a href="add" class="btn rounded-pill px-4 shadow-sm fw-semibold text-white" style="background:linear-gradient(135deg,#0369a1,#075985);">
            <i class="fa fa-plus me-2"></i>Add Blog
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