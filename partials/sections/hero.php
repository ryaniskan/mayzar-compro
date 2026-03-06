<?php
// URL Normalization for App Store Link
$app_url = $hero['app_store_url'] ?? '#';
if (!empty($app_url) && $app_url !== '#' && strpos($app_url, 'http') !== 0 && strpos($app_url, '#') !== 0) {
    $app_url = 'https://' . $app_url;
}

// YouTube URL Normalization for Lity
$video_url = $hero['video_url'] ?? '';
if (!empty($video_url)) {
    // If it's just a YouTube ID (11 chars), convert to full URL
    if (strlen($video_url) === 11 && !strpos($video_url, '/')) {
        $video_url = 'https://www.youtube.com/watch?v=' . $video_url;
    } elseif (strpos($video_url, 'http') !== 0) {
        $video_url = 'https://' . $video_url;
    }
}
?>
<!-- Header -->
<header class="style-4" id="<?php echo $hero['anchor_id'] ?? 'home'; ?>" data-scroll-index="0"
    style="padding-bottom: 120px !important;">
    <div class="content">
        <div class="container">
            <div class="row gx-0">
                <div class="col-lg-6">
                    <div class="info">
                        <small class="mb-50 title_small">
                            <?php echo $hero['tagline']; ?>
                        </small>
                        <h1 class="mb-30">
                            <?php echo $hero['title']; ?>
                        </h1>
                        <p class="text">
                            <?php echo $hero['description']; ?>
                        </p>
                        <div class="d-flex align-items-center mt-50">
                            <a href="<?php echo $app_url; ?>" rel="noreferrer"
                                class="btn rounded-pill bg-blue4 fw-bold text-white me-4" target="_blank">
                                <small>
                                    <?php echo render_icon($hero['button_icon'] ?? 'bi-apple', 'class="me-2 pe-2 border-end"'); ?>
                                    <?php echo $hero['button_text'] ?? 'Download App'; ?>
                                </small>
                            </a>
                            <?php if (!empty($video_url)): ?>
                                <a href="<?php echo $video_url; ?>" data-lity class="play-btn">
                                    <span class="icon me-2"><i class="fas fa-play ms-1"></i></span>
                                    <strong class="small">View<br />Promotion</strong>
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="hero-features mt-60" style="position: relative; z-index: 40;">
                            <?php foreach (($hero['features'] ?? []) as $idx => $feature): ?>
                                <span class="d-inline-block <?php echo $idx === 0 ? 'me-5' : ''; ?> mb-3">
                                    <small
                                        class="icon-30 bg-gray rounded-circle color-blue4 d-inline-flex align-items-center justify-content-center me-2">
                                        <?php echo render_icon($feature['icon']); ?>
                                    </small>
                                    <small class="text-uppercase fw-bold">
                                        <?php echo $feature['text']; ?>
                                    </small>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="img">
                        <img src="<?php echo htmlspecialchars((strpos($hero['main_image'] ?? '', 'http') === 0) ? ($hero['main_image'] ?? BASE_URL . '/assets/img/header/header_4.png') : BASE_URL . ($hero['main_image'] ?? '/assets/img/header/header_4.png')); ?>"
                            alt="" />
                    </div>
                </div>
            </div>
        </div>
        <img src="<?php echo BASE_URL; ?>/assets/img/header/header_4_bubble.png" alt="" class="bubble" />
    </div>
    <img src="<?php echo BASE_URL; ?>/assets/img/header/header_4_wave.png" alt="" class="wave" />
</header>