<!-- Clients Section -->
<section class="clients style-4" id="<?php echo $home_data['clients']['anchor_id'] ?? 'clients'; ?>">
    <div class="container">
        <div class="text-center">
            <h5 class="fw-bold mb-60">
                <?php echo $home_data['clients']['title']; ?>
            </h5>
        </div>
        <div class="client-logos pb-70">
            <div class="row align-items-center">
                <?php foreach (($home_data['clients']['logos'] ?? []) as $logo):
                    $logo_url = (strpos($logo, '/') === false) ? BASE_URL . "/assets/img/logos/$logo" : ((strpos($logo, 'http') === 0) ? $logo : BASE_URL . $logo);
                    ?>
                    <div class="col-6 col-lg-2">
                        <a href="#" class="img d-block text-center"><img src="<?php echo htmlspecialchars($logo_url); ?>"
                                alt="" style="height: 64px; width: auto; max-width: 100%; object-fit: contain;" /></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>