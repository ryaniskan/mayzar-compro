<!-- Features Section -->
<section class="features pt-70 pb-70 style-4" id="<?php echo $home_data['features']['anchor_id'] ?? 'features'; ?>"
    data-scroll-index="1">
    <div class="container">
        <div class="section-head text-center style-4">
            <small class="title_small bg-white">
                <?php echo $home_data['features']['tagline']; ?>
            </small>
            <h2 class="mb-70">
                <?php echo $home_data['features']['title']; ?>
            </h2>
        </div>
        <div class="content">
            <?php foreach (($home_data['features']['items'] ?? []) as $item):
                $icon_src = (strpos($item['icon'], '/') === false) ? BASE_URL . "/assets/img/icons/" . $item['icon'] : ((strpos($item['icon'], 'http') === 0) ? $item['icon'] : BASE_URL . $item['icon']);
                $badge_color = $item['label_color'] ?? '#5842bc';
                ?>
                <div class="features-card">
                    <div class="icon img-contain">
                        <?php echo render_icon($item['icon'], 'style="width: 72px; height: 72px; object-fit: contain;"'); ?>
                        <?php if (!empty($item['label'])): ?>
                            <span class="label icon-40 rounded-circle small text-uppercase fw-bold"
                                style="background: <?php echo htmlspecialchars($badge_color); ?>; color: #fff;">
                                <?php echo htmlspecialchars($item['label']); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <h6>
                        <?php echo $item['title']; ?>
                    </h6>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <img src="<?php echo BASE_URL; ?>/assets/img/feat_circle.png" alt="" class="img-circle" />
</section>