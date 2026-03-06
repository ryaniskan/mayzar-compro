<!-- Navigation -->
<?php
$navbar = $header['navbar'] ?? [];
$nav_links = $navbar['nav_links'] ?? [];
$cta = $navbar['cta'] ?? [];
$top_bar_visible = !empty($header['top_bar']['show']);
?>
<nav class="navbar navbar-expand-lg navbar-light style-4 <?php echo !$top_bar_visible ? 'no-top-bar' : ''; ?>">
    <div class="container">
        <a class="navbar-brand" href="<?php echo BASE_URL; ?>/"><img
                src="<?php echo htmlspecialchars((strpos($settings['site_logo'] ?? '', 'http') === 0) ? ($settings['site_logo'] ?: BASE_URL . '/assets/img/logo_lgr.png') : BASE_URL . ($settings['site_logo'] ?: '/assets/img/logo_lgr.png')); ?>"
                alt="" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto mb-2 mb-lg-0 text-uppercase">
                <?php foreach ($nav_links as $link): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($link['url'] === '#home') ? 'active' : ''; ?>"
                            href="<?php echo (strpos($link['url'], '#') === 0 && $link['url'] !== '#') ? BASE_URL . '/' . $link['url'] : htmlspecialchars($link['url']); ?>">
                            <?php if (!empty($link['icon'])): ?>
                                <?php $nav_icon = (strpos($link['icon'], 'http') === 0) ? $link['icon'] : BASE_URL . $link['icon']; ?>
                                <img src="<?php echo htmlspecialchars($nav_icon); ?>" alt="" class="icon-15 me-2" />
                            <?php endif; ?>
                            <?php echo htmlspecialchars($link['label']); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="nav-side">
                <div class="d-flex align-items-center">
                    <a class="btn rounded-pill brd-gray hover-blue4 sm-butn fw-bold"
                        href="<?php echo (strpos($cta['url'] ?? '', '#') === 0 && ($cta['url'] ?? '') !== '#') ? BASE_URL . '/' . $cta['url'] : htmlspecialchars($cta['url'] ?? '#'); ?>">
                        <span><?php echo htmlspecialchars($cta['text'] ?? 'Join iteck Hub'); ?> <i
                                class="bi bi-arrow-right ms-1"></i> </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>