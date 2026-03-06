<!-- Products (About) Section -->
<section class="about section-padding style-4" id="<?php echo $home_data['products']['anchor_id'] ?? 'about'; ?>"
    data-scroll-index="2">
    <div class="content frs-content">
        <div class="container">
            <?php $pro = $home_data['products'] ?? []; ?>
            <div class="section-head text-center style-4 mb-60">
                <small class="title_small">
                    <?php echo htmlspecialchars($pro['header_slogan'] ?? ''); ?>
                </small>
                <h2 class="mb-20">
                    <?php echo $pro['header_title'] ?? ''; ?>
                </h2>
                <p>
                    <?php echo htmlspecialchars($pro['header_desc'] ?? ''); ?>
                </p>
            </div>

            <!-- Tabs Navigation -->
            <?php
            $tabs = $pro['tabs'] ?? [];
            $first_tab = reset($tabs);
            $first_id = $first_tab ? $first_tab['id'] : null;
            ?>
            <ul class="nav nav-pills justify-content-center mb-60" id="appTabs" role="tablist">
                <?php foreach ($tabs as $tab):
                    $tid = $tab['id'];
                    $is_active = ($tid === $first_id);
                    ?>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link <?php echo $is_active ? 'active' : ''; ?> px-5 py-3 rounded-pill <?php echo $is_active ? 'me-3' : ''; ?>"
                            id="tab-btn-<?php echo $tid; ?>" data-bs-toggle="pill"
                            data-bs-target="#tab-content-<?php echo $tid; ?>" type="button" role="tab"
                            aria-controls="tab-content-<?php echo $tid; ?>"
                            aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                            <?php echo render_icon($tab['nav_icon'] ?? '', 'class="me-2" style="width: 20px; height: 20px; object-fit: contain;"'); ?>
                            <?php echo htmlspecialchars($tab['nav_label'] ?? ''); ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content" id="appTabsContent">
                <?php foreach ($tabs as $tab):
                    $tid = $tab['id'];
                    $is_active = ($tid === $first_id);
                    ?>
                    <div class="tab-pane fade <?php echo $is_active ? 'show active' : ''; ?>"
                        id="tab-content-<?php echo $tid; ?>" role="tabpanel" aria-labelledby="tab-btn-<?php echo $tid; ?>">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-lg-6">
                                <div class="img mb-30 mb-lg-0">
                                    <?php $tab_img = (strpos($tab['main_image'] ?? '', 'http') === 0) ? ($tab['main_image'] ?? '') : BASE_URL . ($tab['main_image'] ?? ''); ?>
                                    <img src="<?php echo htmlspecialchars($tab_img); ?>" alt="" />
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="info">
                                    <div class="section-head style-4">
                                        <small class="title_small">
                                            <?php echo $tab['side_slogan'] ?? ''; ?>
                                        </small>
                                        <h2 class="mb-30">
                                            <?php echo $tab['side_title'] ?? ''; ?>
                                        </h2>
                                    </div>
                                    <p class="text mb-40">
                                        <?php echo $tab['side_desc'] ?? ''; ?>
                                    </p>
                                    <ul>
                                        <?php foreach (($tab['features'] ?? []) as $feat): ?>
                                            <li class="d-flex align-items-center mb-3">
                                                <small
                                                    class="icon-30 bg-gray rounded-circle color-blue4 d-inline-flex align-items-center justify-content-center me-3">
                                                    <?php echo render_icon($feat['icon'] ?? 'bi-check'); ?>
                                                </small>
                                                <h6 class="fw-bold">
                                                    <?php echo $feat['text'] ?? ''; ?>
                                                </h6>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                    <a href="<?php echo htmlspecialchars($tab['btn_url'] ?? '#'); ?>"
                                        class="btn rounded-pill bg-blue4 fw-bold text-white mt-50">
                                        <small>
                                            <?php echo htmlspecialchars($tab['btn_text'] ?? 'View More'); ?>
                                        </small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <img src="<?php echo BASE_URL; ?>/assets/img/about/about_s4_lines.png" alt="" class="lines" />
        </div>
        <img src="<?php echo BASE_URL; ?>/assets/img/about/about_s4_bubble.png" alt="" class="bubble" />
    </div>
</section>