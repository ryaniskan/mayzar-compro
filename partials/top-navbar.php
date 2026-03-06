<!-- Top Navbar -->
<?php
$header = $home_data['header'] ?? [];
$top_bar = $header['top_bar'] ?? [];
if (!empty($top_bar['show'])):
    ?>
    <div class="top-navbar style-4">
        <div class="container">
            <div class="content text-white">
                <span class="btn sm-butn bg-white py-0 px-2 me-2 fs-10px"><small class="fs-10px">
                        <?php echo htmlspecialchars($top_bar['badge'] ?? 'Special'); ?>
                    </small></span>
                <?php if (!empty($top_bar['icon'])): ?>
                    <img src="<?php echo htmlspecialchars($top_bar['icon']); ?>" alt="" class="icon-15 me-1" />
                <?php endif; ?>
                <?php echo $top_bar['text'] ?? ''; ?>
                <a class="fs-10px text-decoration-underline ms-2"
                    href="<?php echo htmlspecialchars($top_bar['link_url'] ?? '#'); ?>">
                    <?php echo htmlspecialchars($top_bar['link_text'] ?? ''); ?>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>