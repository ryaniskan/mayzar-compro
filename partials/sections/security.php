<?php $sec = $home_data['security'] ?? []; ?>
<section class="about style-4 pt-100" id="<?php echo $sec['anchor_id'] ?? 'security'; ?>">
    <div class="content sec-content">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-5 order-2 order-lg-0">
                    <div class="info">
                        <div class="section-head style-4">
                            <small class="title_small">
                                <?php echo htmlspecialchars($sec['tagline'] ?? ''); ?>
                            </small>
                            <h2 class="mb-30">
                                <?php echo $sec['title'] ?? ''; ?>
                            </h2>
                        </div>
                        <p class="text mb-40">
                            <?php echo nl2br(htmlspecialchars($sec['description'] ?? '')); ?>
                        </p>
                        <div class="faq style-3 style-4">
                            <div class="accordion" id="accordionExample">
                                <?php foreach (($sec['items'] ?? []) as $idx => $item): ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading<?php echo $idx; ?>">
                                            <button class="accordion-button <?php echo $idx === 0 ? '' : 'collapsed'; ?>"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse<?php echo $idx; ?>"
                                                aria-expanded="<?php echo $idx === 0 ? 'true' : 'false'; ?>"
                                                aria-controls="collapse<?php echo $idx; ?>">
                                                <?php echo htmlspecialchars($item['title'] ?? ''); ?>
                                            </button>
                                        </h2>
                                        <div id="collapse<?php echo $idx; ?>"
                                            class="accordion-collapse collapse <?php echo $idx === 0 ? 'show' : ''; ?>"
                                            aria-labelledby="heading<?php echo $idx; ?>" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <?php echo nl2br(htmlspecialchars($item['content'] ?? '')); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php if (($sec['show_btn'] ?? '1') == '1'): ?>
                            <a href="<?php echo htmlspecialchars($sec['btn_url'] ?? 'https://chrome.google.com/webstore/category/extensions'); ?>"
                                rel="noreferrer" class="btn btn-img mt-40 rounded-pill" target="_blank">
                                <div class="icon img-contain">
                                    <?php echo render_icon(!empty($sec['btn_icon']) ? $sec['btn_icon'] : 'chrome_icon.png'); ?>
                                </div>
                                <div class="inf">
                                    <small>
                                        <?php echo htmlspecialchars($sec['btn_small'] ?? 'Available in the'); ?>
                                    </small>
                                    <h6>
                                        <?php echo htmlspecialchars($sec['btn_label'] ?? 'Chrome Web Store'); ?>
                                    </h6>
                                </div>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 order-0 order-lg-2">
                    <div class="img mb-30 mb-lg-0">
                        <img src="<?php echo BASE_URL; ?>/assets/img/about/2mobiles.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <img src="<?php echo BASE_URL; ?>/assets/img/about/about_s4_bubble2.png" alt="" class="bubble2" />
    </div>
</section>