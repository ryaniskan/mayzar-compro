<?php $download = $home_data['download'] ?? []; ?>
<section class="download-section style-4" id="<?php echo $download['anchor_id'] ?? 'contact'; ?>" data-scroll-index="8"
    style="padding-top: 100px;">
    <div class="container">
        <div class="section-head text-center style-4">
            <h2 class="mb-10">
                <?php echo $download['title'] ?? 'Ready To <span>Download</span>'; ?>
            </h2>
            <p>
                <?php echo htmlspecialchars($download['description'] ?? ''); ?>
            </p>
            <div class="d-flex align-items-center justify-content-center mt-50">
                <?php foreach (($download['buttons'] ?? []) as $btn): ?>
                    <a href="<?php echo htmlspecialchars($btn['url']); ?>" rel="noreferrer"
                        class="btn rounded-pill <?php echo !empty($btn['is_primary']) ? 'bg-blue4 text-white' : 'hover-blue4 border-blue4'; ?> fw-bold me-4"
                        target="_blank">
                        <small>
                            <?php echo render_icon($btn['icon'] ?? '', 'class="me-2 pe-2 border-end"'); ?>
                            <?php echo htmlspecialchars($btn['text'] ?? ''); ?>
                        </small>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>