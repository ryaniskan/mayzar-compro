<?php $community = $home_data['community'] ?? []; ?>
<section class="community section-padding pt-0 style-4" id="<?php echo $community['anchor_id'] ?? 'community'; ?>">
    <div class="container">
        <div class="section-head text-center style-4">
            <small class="title_small">
                <?php echo htmlspecialchars($community['tagline'] ?? ''); ?>
            </small>
            <h2 class="mb-30">
                <?php echo $community['title'] ?? ''; ?>
            </h2>
        </div>
        <div class="content">
            <?php foreach (($community['list'] ?? []) as $item): ?>
                <a href="<?php echo htmlspecialchars($item['url']); ?>" class="commun-card">
                    <div class="icon"><?php echo render_icon($item['icon']); ?></div>
                    <div class="inf">
                        <h5>
                            <?php echo htmlspecialchars($item['title']); ?>
                        </h5>
                        <p>
                            <?php echo htmlspecialchars($item['description']); ?>
                        </p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>