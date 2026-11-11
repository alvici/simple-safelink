<section class="section reveal">
    <div class="container">
        <div class="section-head">
            <h2>Latest Articles</h2>
            <span class="count"><?= count($allPost); ?> articles</span>
        </div>

        <?php if (empty($allPost)): ?>
        <div class="card empty">
            <div class="code">0</div>
            <p>No articles available yet.</p>
        </div>
        <?php else: ?>
        <div class="post-grid">
            <?php $no = 1; foreach ($allPost as $item): ?>
            <a class="post-card" href="<?= base_url($item['slug']); ?>">
                <span class="post-index"><?= str_pad($no, 2, '0', STR_PAD_LEFT); ?></span>
                <h3><?= htmlspecialchars(unslug($item['slug']), ENT_QUOTES, 'UTF-8'); ?></h3>
                <div class="post-foot">
                    <span><?= date('d M Y', $item['date']); ?></span>
                    <span class="arrow" aria-hidden="true">&rarr;</span>
                </div>
            </a>
            <?php $no++; endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
