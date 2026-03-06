<?php $pricing = $home_data['pricing'] ?? []; ?>
<section class="pricing section-padding pt-0 style-4" id="<?php echo $pricing['anchor_id'] ?? 'pricing'; ?>"
    data-scroll-index="6">
    <div class="container">
        <div class="section-head text-center style-4">
            <small class="title_small">
                <?php echo $pricing['tagline'] ?? ''; ?>
            </small>
            <h2 class="mb-70">
                <?php echo $pricing['title'] ?? ''; ?>
            </h2>
        </div>
        <div class="content">
            <div class="row justify-content-center">
                <?php foreach (($pricing['plans'] ?? []) as $plan): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="price-card <?php echo !empty($plan['is_popular']) ? 'popular' : ''; ?>">
                            <div class="price-header pb-4 text-center">
                                <h6>
                                    <?php echo render_icon($plan['icon'] ?? '', 'class="icon mb-2" style="width: 40px; height: 40px; object-fit: contain;"'); ?>
                                    <div class="mt-2"><?php echo htmlspecialchars($plan['name']); ?></div>
                                </h6>
                                <h2>
                                    <?php echo htmlspecialchars($plan['price']); ?>
                                    <small> /
                                        <?php echo htmlspecialchars($plan['period']); ?>
                                    </small>
                                </h2>
                                <p>
                                    <?php echo $plan['description']; ?>
                                </p>
                            </div>
                            <div class="price-body py-4">
                                <ul>
                                    <?php foreach (($plan['features'] ?? []) as $feature): ?>
                                        <li
                                            class="d-flex align-items-center mb-3 <?php echo empty($feature['active']) ? 'op-3' : ''; ?>">
                                            <small
                                                class="icon-30 bg-blue4 rounded-circle text-white d-inline-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                                <?php echo render_icon($feature['icon']); ?>
                                            </small>
                                            <p class="fw-bold">
                                                <?php echo $feature['text']; ?>
                                            </p>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                                <a class="btn rounded-pill <?php echo !empty($plan['is_popular']) ? 'bg-blue4 text-white' : 'border-blue4 hover-blue4'; ?> fw-bold mt-50 px-5"
                                    href="<?php echo htmlspecialchars($plan['button_url']); ?>">
                                    <small>
                                        <?php echo htmlspecialchars($plan['button_text']); ?>
                                    </small>
                                </a>
                            </div>
                            <?php if (!empty($plan['is_popular']) && !empty($plan['off_text'])): ?>
                                <div class="off">
                                    <span>
                                        <?php echo $plan['off_text']; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>