<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
check_auth();

$header_row = db_get_by_id('header', 1) ?: [];
$nav_links = db_get_children('header_nav_links', 'header_id', 1);

// Reconstruct old structure for template compatibility
$top_bar = [
    'show' => !empty($header_row['top_bar_show']),
    'badge' => $header_row['top_bar_badge'] ?? '',
    'icon' => $header_row['top_bar_icon'] ?? '',
    'text' => $header_row['top_bar_text'] ?? '',
    'link_text' => $header_row['top_bar_link_text'] ?? '',
    'link_url' => $header_row['top_bar_link_url'] ?? ''
];
$navbar = [
    'nav_links' => $nav_links,
    'cta' => [
        'text' => $header_row['cta_text'] ?? '',
        'url' => $header_row['cta_url'] ?? ''
    ]
];
$header = ['top_bar' => $top_bar, 'navbar' => $navbar];
$cta = $navbar['cta'];

$settings = db_get_flat('settings');
$page_title = __('Header & Top Bar Section');

// List of available anchor IDs for the dropdown
$anchors = [
    '#hero' => 'Hero Section (#hero)',
    '#clients' => 'Clients Section (#clients)',
    '#features' => 'Features Section (#features)',
    '#products' => 'Products (About) Section (#products)',
    '#security' => 'Security Section (#security)',
    '#themes' => 'Themes Section (#themes)',
    '#integrations' => 'Integrations Section (#integrations)',
    '#screenshots' => 'Screenshots Section (#screenshots)',
    '#testimonials' => 'Testimonials Section (#testimonials)',
    '#pricing' => 'Pricing Section (#pricing)',
    '#faq' => 'FAQ Section (#faq)',
    '#community' => 'Community Hub (#community)',
    '#download' => __('Footer / Download') . ' (#download)',
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
                            <h1 class="m-0"><?php echo __('Header Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="headerForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="headerForm" action="header_handler" method="POST">
                        <?php render_csrf_input(); ?>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Top Bar Settings'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="custom-control custom-switch mb-3">
                                    <input type="checkbox" class="custom-control-input" name="top_bar[show]" value="1"
                                        id="topBarShow" <?php echo !empty($top_bar['show']) ? 'checked' : ''; ?>>
                                    <label class="custom-control-label"
                                        for="topBarShow"><?php echo __('Show Top Bar'); ?></label>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label class="form-label small"><?php echo __('Badge Text'); ?></label>
                                        <input type="text" name="top_bar[badge]" class="form-control"
                                            value="<?php echo htmlspecialchars($top_bar['badge'] ?? ''); ?>"
                                            placeholder="Special">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label
                                            class="form-label small"><?php echo __('Icon (Image or Bootstrap Icon)'); ?></label>
                                        <div class="input-group">
                                            <input type="text" name="top_bar[icon]" class="form-control"
                                                value="<?php echo htmlspecialchars($top_bar['icon'] ?? ''); ?>"
                                                id="topBarIcon" placeholder="Icon class or /path/to/img">
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="pickLinkIcon('topBarIcon')"><?php echo __('Icon'); ?></button>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    onclick="pickImage('topBarIcon')"><?php echo __('Img'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small"><?php echo __('Promo Text'); ?></label>
                                        <input type="text" name="top_bar[text]" class="form-control"
                                            value="<?php echo htmlspecialchars($top_bar['text'] ?? ''); ?>"
                                            placeholder="Get 20% Discount...">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small"><?php echo __('Link Text'); ?></label>
                                        <input type="text" name="top_bar[link_text]" class="form-control"
                                            value="<?php echo htmlspecialchars($top_bar['link_text'] ?? ''); ?>"
                                            placeholder="Register Now">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small"><?php echo __('Link URL'); ?></label>
                                        <input type="text" name="top_bar[link_url]" class="form-control"
                                            value="<?php echo htmlspecialchars($top_bar['link_url'] ?? ''); ?>"
                                            placeholder="#contact">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Navigation Links'); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addLink()">
                                        <i class="fas fa-plus"></i> <?php echo __('Add Link'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="links-container">
                                    <?php foreach ($nav_links as $idx => $link): ?>
                                        <div class="callout callout-info link-item mb-3" id="link-row-<?php echo $idx; ?>">
                                            <button type="button" class="close"
                                                onclick="this.parentElement.remove()">&times;</button>
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label class="form-label small"><?php echo __('Link Label'); ?></label>
                                                    <input type="text" name="navbar[nav_links][<?php echo $idx; ?>][label]"
                                                        class="form-control"
                                                        value="<?php echo htmlspecialchars($link['label'] ?? ''); ?>"
                                                        required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        class="form-label small"><?php echo __('Target Anchor / URL'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            name="navbar[nav_links][<?php echo $idx; ?>][url]"
                                                            class="form-control"
                                                            value="<?php echo htmlspecialchars($link['url'] ?? ''); ?>"
                                                            id="url-<?php echo $idx; ?>" required>
                                                        <div class="input-group-append">
                                                            <select class="form-control" style="max-width: 130px;"
                                                                onchange="document.getElementById('url-<?php echo $idx; ?>').value = this.value">
                                                                <option value=""><?php echo __('Select'); ?></option>
                                                                <?php foreach ($anchors as $aid => $aname): ?>
                                                                    <option value="<?php echo $aid; ?>"><?php echo $aname; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <label
                                                        class="form-label small"><?php echo __('Icon (Optional)'); ?></label>
                                                    <div class="input-group">
                                                        <input type="text"
                                                            name="navbar[nav_links][<?php echo $idx; ?>][icon]"
                                                            class="form-control" id="icon-<?php echo $idx; ?>"
                                                            value="<?php echo htmlspecialchars($link['icon'] ?? ''); ?>"
                                                            placeholder="bi-class or /img">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                onclick="pickLinkIcon('icon-<?php echo $idx; ?>')">Icon</button>
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                onclick="pickImage('icon-<?php echo $idx; ?>')">Img</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Main CTA Button'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small"><?php echo __('Button Text'); ?></label>
                                        <input type="text" name="navbar[cta][text]" class="form-control"
                                            value="<?php echo htmlspecialchars($cta['text'] ?? ''); ?>"
                                            placeholder="Join iteck Hub">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label small"><?php echo __('Button URL'); ?></label>
                                        <input type="text" name="navbar[cta][url]" class="form-control"
                                            value="<?php echo htmlspecialchars($cta['url'] ?? ''); ?>"
                                            placeholder="#contact">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </section>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo __('Media Browser'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php include __DIR__ . '/partials/media_browser.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="iconModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo __('Pick Icon'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php include __DIR__ . '/partials/icon_picker.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <script>
        let activeTargetId = null;

        let linkCounter = <?php echo count($nav_links); ?>;
        function addLink() {
            const container = document.getElementById('links-container');
            const id = 'link-row-' + Date.now();
            const idx = linkCounter;
            const div = document.createElement('div');
            div.className = 'callout callout-info link-item mb-3';
            div.id = id;
            div.innerHTML = `
                <button type="button" class="close" onclick="document.getElementById('${id}').remove()">&times;</button>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small">Link Label</label>
                        <input type="text" name="navbar[nav_links][${idx}][label]" class="form-control" required placeholder="e.g. Services">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Target Anchor / URL</label>
                        <div class="input-group">
                            <input type="text" name="navbar[nav_links][${idx}][url]" class="form-control" id="url-${idx}" required placeholder="#section">
                            <div class="input-group-append">
                                <select class="form-control" style="max-width: 130px;" onchange="document.getElementById('url-${idx}').value = this.value">
                                    <option value="">Select</option>
                                    <?php foreach ($anchors as $aid => $aname): ?>
                                        <option value="<?php echo $aid; ?>"><?php echo $aname; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small">Icon (Optional)</label>
                        <div class="input-group">
                            <input type="text" name="navbar[nav_links][${idx}][icon]" class="form-control" id="icon-${idx}" placeholder="bi-class or /img">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="pickLinkIcon('icon-${idx}')">Icon</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="pickImage('icon-${idx}')">Img</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
            linkCounter++;
        }

        function pickLinkIcon(targetId) {
            activeTargetId = targetId;
            $('#iconModal').modal('show');
        }

        function pickImage(targetId) {
            activeTargetId = targetId;
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initIconPicker === 'function') {
                initIconPicker((icon) => {
                    const target = document.getElementById(activeTargetId);
                    if (target) {
                        target.value = icon;
                    }
                    $('#iconModal').modal('hide');
                });
            }

            if (typeof initMediaBrowser === 'function') {
                initMediaBrowser((path) => {
                    const target = document.getElementById(activeTargetId);
                    if (target) {
                        target.value = path;
                    }
                    $('#mediaModal').modal('hide');
                });
            }
        });
    </script>
</body>

</html>