<?php
// ── Fetch Latest Blogs ──────────────────────────────
$latestBlogs = [];
$lbRes = $conn->query("
    SELECT 
        b.id, b.title, b.slug, b.excerpt, b.image,
        b.published_at, b.reading_time,
        bc.name AS category_name
    FROM blogs b
    LEFT JOIN blog_categories bc ON bc.id = b.categories
    WHERE b.is_published = 1
    ORDER BY b.published_at DESC
    LIMIT 3
");
if ($lbRes) {
    while ($lb = $lbRes->fetch_assoc()) {
        $latestBlogs[] = $lb;
    }
}
?>

<?php if (!empty($latestBlogs)): ?>
<!-- BLOG SECTION START -->
<section class="ul-2-blogs ul-2-banner ul-section-spacing">
    <div class="ul-container">

        <div class="ul-section-heading">
            <div>
                <span class="ul-2-section-sub-title">Latest Blog</span>
                <h2 class="ul-2-section-title mb-0 text-black">Our Latest Blog & News</h2>
            </div>
            <a href="blogs" class="ul-btn">View All Blogs <i class="flaticon-arrow-up-right"></i></a>
        </div>

        <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 g-3 g-lg-4 justify-content-center">

            <?php foreach ($latestBlogs as $lb): ?>
            <div class="col">
                <div class="ul-2-blog">
                    <div class="ul-2-blog-img">
                        <img src="<?php echo htmlspecialchars($lb['image']); ?>"
                             alt="<?php echo htmlspecialchars($lb['title']); ?>"
                             onerror="this.src='assets/img/blog-1.jpg'">
                    </div>
                    <div class="ul-2-blog-txt">
                        <div class="ul-2-blog-infos">
                            <span><i class="flaticon-calendar"></i> <?php echo date('d F Y', strtotime($lb['published_at'])); ?></span>
                            <span><i class="flaticon-clock"></i> <?php echo !empty($lb['reading_time']) ? $lb['reading_time'] . ' Min Read' : '1 Min Read'; ?></span>
                        </div>
                        <h3 class="ul-2-blog-title">
                            <a href="blog-details.php?slug=<?php echo urlencode($lb['slug']); ?>">
                                <?php echo htmlspecialchars($lb['title']); ?>
                            </a>
                        </h3>
                        <a href="blog-details.php?slug=<?php echo urlencode($lb['slug']); ?>" class="ul-2-blog-btn">
                            Read More <i class="flaticon-arrow-up-right-curve"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
<!-- BLOG SECTION END -->
<?php endif; ?>