<?php $themes = $home_data['themes'] ?? []; ?>
<section class="about style-4 wow fadeInUp">
    <div class="content trd-content" id="<?php echo $themes['anchor_id'] ?? 'themes'; ?>">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="img mb-30 mb-lg-0">
                        <img src="<?php echo htmlspecialchars((strpos($themes['main_image'] ?? '', 'http') === 0) ? ($themes['main_image'] ?? BASE_URL . '/assets/img/about/about_s4_img3.png') : BASE_URL . ($themes['main_image'] ?? '/assets/img/about/about_s4_img3.png')); ?>"
                            alt="" />
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="info">
                        <div class="section-head style-4">
                            <small class="title_small">
                                <?php echo htmlspecialchars($themes['tagline'] ?? ''); ?>
                            </small>
                            <h2 class="mb-30">
                                <?php echo $themes['title'] ?? ''; ?>
                            </h2>
                        </div>
                        <p class="text mb-40">
                            <?php echo nl2br(htmlspecialchars($themes['description'] ?? '')); ?>
                        </p>
                        <ul>
                            <?php foreach (($themes['bullets'] ?? []) as $idx => $bullet): ?>
                                <li class="d-flex align-items-center mb-2 <?php echo $idx === 1 ? '' : 'op-4'; ?>">
                                    <span
                                        class="me-2"><?php echo render_icon($bullet['icon'] ?? 'bi-dot', 'class="fs-2 lh-1 color-blue4"'); ?></span>
                                    <h6 class="fw-bold">
                                        <?php echo htmlspecialchars($bullet['text'] ?? $bullet); ?>
                                    </h6>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="btn rounded-pill fw-bold text-white mt-50"
                            href="<?php echo htmlspecialchars($themes['btn_url'] ?? '#pricing'); ?>"
                            style="background-color: <?php echo htmlspecialchars($themes['btn_color'] ?? '#5842bc'); ?>;">
                            <small>
                                <?php echo htmlspecialchars($themes['btn_text'] ?? 'Discovery Now'); ?>
                            </small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <img src="<?php echo BASE_URL; ?>/assets/img/about/about_s4_bubble.png" alt="" class="bubble" />
    </div>
</section>