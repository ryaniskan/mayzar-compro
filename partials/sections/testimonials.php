<?php $testi = $home_data['testimonials'] ?? []; ?>
<section class="testimonials style-4 pt-70" id="<?php echo $testi['anchor_id'] ?? 'testimonials'; ?>"
    data-scroll-index="5">
    <div class="container">
        <div class="content">
            <div class="row">
                <div class="col-lg-5">
                    <div class="section-head style-4">
                        <small class="title_small">
                            <?php echo htmlspecialchars($testi['tagline'] ?? ''); ?>
                        </small>
                        <h2 class="mb-30">
                            <?php echo $testi['title'] ?? ''; ?>
                        </h2>
                    </div>
                    <p class="text mb-40">
                        <?php echo htmlspecialchars($testi['description'] ?? ''); ?>
                    </p>
                    <div class="numbs">
                        <?php foreach (($testi['stats'] ?? []) as $stat): ?>
                            <div class="num-card">
                                <div class="icon img-contain">
                                    <?php echo render_icon($stat['icon']); ?>
                                </div>
                                <h2>
                                    <?php echo htmlspecialchars($stat['value']); ?>
                                </h2>
                                <p>
                                    <?php echo $stat['label']; ?>
                                </p>
                                <?php if (!empty($stat['show_stars'])): ?>
                                    <div class="stars">
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i><i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="testi-cards">
                        <?php foreach (($testi['list'] ?? []) as $item): ?>
                            <div class="client_card">
                                <div class="user_img">
                                    <?php echo render_icon($item['image']); ?>
                                </div>
                                <div class="inf_content">
                                    <div class="stars mb-2">
                                        <?php for ($i = 0; $i < (int) $item['stars']; $i++): ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <h6>
                                        <?php echo nl2br(htmlspecialchars($item['quote'])); ?>
                                    </h6>
                                    <p>
                                        <?php echo htmlspecialchars($item['name']); ?> <span class="text-muted">/
                                            <?php echo $item['position']; ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <img src="<?php echo BASE_URL; ?>/assets/img/contact_globe.svg" alt="" class="testi-globe" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>