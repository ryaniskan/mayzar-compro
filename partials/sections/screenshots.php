<?php
$screenshots = $home_data['screenshots'] ?? [];
// Compatibility: check if it's the old array format or new object format
if (isset($screenshots['images'])) {
    $screenshot_list = $screenshots['images'];
    $screenshot_id = $screenshots['anchor_id'] ?? 'screenshots';
} else {
    $screenshot_list = $screenshots;
    $screenshot_id = 'screenshots';
}
?>
<div class="screenshots style-4" id="<?php echo htmlspecialchars($screenshot_id); ?>" data-scroll-index="4">
    <div class="screenshots-slider style-4">
        <div class="swiper-container screenshots-swiper">
            <div class="swiper-wrapper">
                <?php foreach (($screenshot_list ?? []) as $screenshot): ?>
                    <div class="swiper-slide">
                        <div class="img">
                            <?php $screenshot_img = (strpos($screenshot, 'http') === 0) ? $screenshot : BASE_URL . $screenshot; ?>
                            <img src="<?php echo htmlspecialchars($screenshot_img); ?>" alt="" />
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <img src="<?php echo BASE_URL; ?>/assets/img/screenshots/hand.png" alt="" class="mob-hand" />
</div>