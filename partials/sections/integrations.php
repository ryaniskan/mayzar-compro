<?php // Using $integ prepared in index.php ?>
<section class="about style-4 pb-100 wow fadeInUp">
    <div class="integration pt-60" id="<?php echo $integ['anchor_id'] ?? 'integrations'; ?>">
        <div class="section-head text-center style-4 mb-40">
            <small class="title_small">
                <?php echo $integ['tagline'] ?? ''; ?>
            </small>
            <h2 class="mb-20">
                <?php echo $integ['title'] ?? ''; ?>
            </h2>
            <p>
                <?php echo $integ['description'] ?? ''; ?>
            </p>
        </div>
        <div class="container">
            <div class="content">
                <?php foreach (($home_data['integrations']['items'] ?? []) as $item): ?>
                    <div class="col-6 col-lg-3 img">
                        <div class="integration-card text-center mb-50">
                            <div class="icon mb-20">
                                <?php echo render_icon($item['image'], 'style="height: 100px; width: auto; max-width: 100%; object-fit: contain;"'); ?>
                            </div>
                            <?php $name = trim($item['name'] ?? $item['title'] ?? ''); ?>
                            <?php if ($name): ?>
                                <h6><?php echo htmlspecialchars($name); ?></h6>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <img src="<?php echo BASE_URL; ?>/assets/img/about/intg_back.png" alt="" class="intg-back" />
    </div>
    <img src="<?php echo BASE_URL; ?>/assets/img/about/about_s4_wave.png" alt="" class="top-wave" />
    <img src="<?php echo BASE_URL; ?>/assets/img/about/about_s4_wave.png" alt="" class="bottom-wave" />
</section>