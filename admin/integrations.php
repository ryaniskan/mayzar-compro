<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'integrations';
$page_title = __('Integrations Section');

$settings = db_get_flat('settings');
$integ = db_get_by_id('integrations', 1);
$integ['items'] = db_get_children('integrations_items', 'integration_id', 1);

// Default items if empty
if (empty($integ['items'])) {
    for ($i = 1; $i <= 5; $i++) {
        $integ['items'][] = [
            'image' => "/assets/img/about/intg$i.png",
            'spacing' => 30,
            'bg_color' => 'transparent'
        ];
    }
}
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
                            <h1 class="m-0"><?php echo __('Integrations Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="integrationsForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="integrationsForm" action="integrations_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php
                        require_once __DIR__ . '/partials/wysiwyg_editor.php';
                        // Hardcoded anchor_id is now handled in handler, no input needed here
                        ?>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Header Configuration'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'integTagline',
                                                'name' => 'tagline',
                                                'value' => $integ['tagline'] ?? '',
                                                'type' => 'oneliner',
                                                'label' => __('Tagline')
                                            ]); ?>
                                        </div>
                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'integTitle',
                                                'name' => 'title',
                                                'value' => $integ['title'] ?? '',
                                                'type' => 'oneliner',
                                                'label' => __('Title')
                                            ]); ?>
                                            <p class="text-muted small mt-n2">
                                                <?php echo __('Use the toolbar or <code>&lt;span&gt;txt&lt;/span&gt;</code> for blue highlight.'); ?>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'integDescription',
                                                'name' => 'description',
                                                'value' => $integ['description'] ?? '',
                                                'type' => 'paragraph',
                                                'label' => __('Description')
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card card-primary card-outline">
                                    <div class="card-header border-bottom-0">
                                        <h3 class="card-title"><?php echo __('App Icons (Max 5)'); ?></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-primary btn-xs" onclick="addItem()"
                                                id="addBtn">
                                                <i class="fas fa-plus"></i> <?php echo __('Add App'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="itemsContainer">
                                            <?php foreach (($integ['items'] ?? []) as $idx => $item): ?>
                                                <div class="integ-item-card border rounded p-3 mb-3 bg-light position-relative"
                                                    id="item-<?php echo $idx; ?>">
                                                    <button type="button" class="btn btn-danger btn-xs position-absolute"
                                                        style="top: -10px; right: -10px;"
                                                        onclick="removeItem('item-<?php echo $idx; ?>')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                    <div class="row align-items-center">
                                                        <div class="col-auto">
                                                            <div class="text-center">
                                                                <img src="<?php echo BASE_URL . htmlspecialchars($item['image']); ?>"
                                                                    class="img-thumbnail" id="preview-<?php echo $idx; ?>"
                                                                    width="64" height="64" style="background: white;">
                                                                <input type="hidden"
                                                                    name="items[<?php echo $idx; ?>][image]"
                                                                    id="path-<?php echo $idx; ?>"
                                                                    value="<?php echo htmlspecialchars($item['image']); ?>">
                                                                <div class="mt-2 text-center">
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary btn-xs"
                                                                        onclick="openMediaBrowser('<?php echo $idx; ?>')"><?php echo __('Change'); ?></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div class="mb-2">
                                                                <label
                                                                    class="small fw-bold"><?php echo __('Top Spacing (px)'); ?></label>
                                                                <input type="number"
                                                                    name="items[<?php echo $idx; ?>][spacing]"
                                                                    class="form-control form-control-sm"
                                                                    value="<?php echo (int) ($item['spacing'] ?? 30); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
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

    <!-- Media Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo __('Select Asset'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php include __DIR__ . '/partials/media_browser.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <script>
        let activeIdx = null;

        function openMediaBrowser(idx) {
            activeIdx = idx;
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initMediaBrowser === 'function') {
                initMediaBrowser((path) => {
                    const pathInput = document.getElementById('path-' + activeIdx);
                    const previewImg = document.getElementById('preview-' + activeIdx);
                    if (pathInput) pathInput.value = path;
                    if (previewImg) previewImg.src = CONFIG.BASE_URL + path;
                    $('#mediaModal').modal('hide');
                });
            }
            checkMaxItems();
        });

        function addItem() {
            const container = document.getElementById('itemsContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'integ-item-card border rounded p-3 mb-3 bg-light position-relative';
            div.id = 'item-' + idx;
            div.innerHTML = `
                <button type="button" class="btn btn-danger btn-xs position-absolute" style="top: -10px; right: -10px;" onclick="removeItem('item-\${idx}')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="text-center">
                            <img src="/assets/img/icons/image_placeholder.png" class="img-thumbnail" id="preview-\${idx}" width="64" height="64" style="background: white;">
                            <input type="hidden" name="items[\${idx}][image]" id="path-\${idx}" value="/assets/img/icons/image_placeholder.png">
                            <div class="mt-2 text-center">
                                <button type="button" class="btn btn-outline-secondary btn-xs" onclick="openMediaBrowser('\${idx}')">Change</button>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <label class="small fw-bold">Top Spacing (px)</label>
                            <input type="number" name="items[\${idx}][spacing]" class="form-control form-control-sm" value="30">
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
            checkMaxItems();
        }

        function removeItem(id) {
            document.getElementById(id).remove();
            checkMaxItems();
        }

        function checkMaxItems() {
            const items = document.querySelectorAll('.integ-item-card');
            const btn = document.getElementById('addBtn');
            if (items.length >= 5) {
                btn.disabled = true;
                btn.classList.add('disabled');
            } else {
                btn.disabled = false;
                btn.classList.remove('disabled');
            }
        }
    </script>
</body>

</html>