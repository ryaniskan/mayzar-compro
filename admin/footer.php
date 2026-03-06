<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();
$user = get_logged_in_user();

$current_page = 'footer';
$page_title = __('Footer Section');

// Load homepage data
$footer = db_get_by_id('footer', 1) ?: [];
$footer['links'] = db_get_children('footer_links', 'footer_id', 1);

// List of available anchor IDs for the dropdown
$anchors = [
    '#hero' => __('Hero Section') . ' (#hero)',
    '#clients' => __('Clients Section') . ' (#clients)',
    '#features' => __('Features Section') . ' (#features)',
    '#products' => __('Products Section') . ' (#products)',
    '#security' => __('Security Section') . ' (#security)',
    '#themes' => __('Themes Section') . ' (#themes)',
    '#integrations' => __('Integrations Section') . ' (#integrations)',
    '#screenshots' => __('Screenshots Section') . ' (#screenshots)',
    '#testimonials' => __('Testimonials Section') . ' (#testimonials)',
    '#pricing' => __('Pricing Section') . ' (#pricing)',
    '#faq' => __('FAQ Section') . ' (#faq)',
    '#community' => __('Community Section') . ' (#community)',
    '#download' => __('Download Section') . ' (#download)',
    '#contact' => __('Contact / Footer') . ' (#contact)'
];
?>
<!DOCTYPE html>
<html lang="en">

<?php include __DIR__ . '/partials/head.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <?php include __DIR__ . '/partials/navbar.php'; ?>
        <?php include __DIR__ . '/partials/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?php echo __('Footer Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="footerForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="footerForm" action="footer_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Footer Links'); ?></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addLink()">
                                                <i class="fas fa-plus"></i> <?php echo __('Add Link'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="linksContainer">
                                            <?php foreach (($footer['links'] ?? []) as $idx => $link): ?>
                                                <div class="callout callout-info mb-3 item-row"
                                                    id="link-<?php echo $idx; ?>">
                                                    <button type="button" class="close"
                                                        style="position: relative; z-index: 10;"
                                                        onclick="removeLink(this)">&times;</button>
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label
                                                                class="form-label small fw-bold"><?php echo __('Label'); ?></label>
                                                            <input type="text" name="links[<?php echo $idx; ?>][label]"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($link['label']); ?>"
                                                                placeholder="Home">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label
                                                                class="form-label small fw-bold"><?php echo __('URL / Anchor'); ?></label>
                                                            <input type="text" name="links[<?php echo $idx; ?>][url]"
                                                                class="form-control"
                                                                value="<?php echo htmlspecialchars($link['url']); ?>"
                                                                list="anchorList"
                                                                placeholder="e.g. #hero or https://google.com">
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Copyright Text'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <?php render_wysiwyg([
                                            'id' => 'ftCopy',
                                            'name' => 'copyright',
                                            'label' => __('Copyright (HTML allowed)'),
                                            'value' => $footer['copyright'] ?? '',
                                            'type' => 'paragraph',
                                            'helper' => 'Use &lt;a&gt; tags for links and &lt;span&gt; for styling.'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <datalist id="anchorList">
                    <?php foreach ($anchors as $val => $label): ?>
                        <option value="<?php echo $val; ?>"><?php echo $label; ?></option>
                    <?php endforeach; ?>
                </datalist>
                </form>
        </div>
        </section>
    </div>

    <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <script>
        function addLink() {
            const container = document.getElementById('linksContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'callout callout-info mb-3 item-row';
            div.id = 'link-' + idx;
            div.innerHTML = `
                <button type="button" class="close" style="position: relative; z-index: 10;" onclick="removeLink(this)">&times;</button>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Label</label>
                        <input type="text" name="links[\${idx}][label]" class="form-control" placeholder="Label">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">URL / Anchor</label>
                        <input type="text" name="links[\${idx}][url]" class="form-control" 
                            list="anchorList" placeholder="e.g. #hero or https://google.com">
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        function removeLink(btn) {
            btn.closest('.item-row').remove();
        }
    </script>
</body>

</html>