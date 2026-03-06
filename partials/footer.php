<!-- Footer -->
<footer class="style-4" id="<?php echo $download['anchor_id'] ?? 'contact'; ?>" data-scroll-index="8">
    <div class="container">
        <?php
        $download = $home_data['download'] ?? [];
        $footer_data = $home_data['footer'] ?? [];
        ?>

        <div class="foot mt-80">
            <div class="row align-items-center">
                <div class="col-lg-2">
                    <?php $footer_logo = (strpos($settings['site_logo'], 'http') === 0) ? $settings['site_logo'] : BASE_URL . $settings['site_logo']; ?>
                    <div class="logo"><img src="<?php echo htmlspecialchars($footer_logo); ?>" alt="" /></div>
                </div>
                <div class="col-lg-10">
                    <ul class="links">
                        <?php foreach (($footer_data['links'] ?? []) as $link): ?>
                            <li><a
                                    href="<?php echo (strpos($link['url'] ?? '', '#') === 0) ? BASE_URL . '/' . htmlspecialchars($link['url']) : htmlspecialchars($link['url'] ?? '#'); ?>"><?php echo htmlspecialchars($link['label'] ?? ''); ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="copywrite text-center">
            <small class="small">
                <?php echo $footer_data['copyright'] ?? ''; ?>
            </small>
        </div>
    </div>
    <img src="<?php echo BASE_URL; ?>/assets/img/footer/footer_4_wave.png" alt="" class="wave" />
</footer>

<!-- Back to Top Button -->
<a href="#" class="to_top bg-gray rounded-circle icon-40 d-inline-flex align-items-center justify-content-center">
    <i class="bi bi-chevron-up fs-6 text-dark"></i>
</a>