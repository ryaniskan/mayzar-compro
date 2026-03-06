<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'features';
$page_title = __('Features Section');

$settings = db_get_flat('settings');
$features = db_get_by_id('features', 1);
$items = db_get_children('features_items', 'feature_id', 1);
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
                            <h1 class="m-0"><?php echo __('Features Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="featuresForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="featuresForm" action="features_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Section Configuration'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'featTagline',
                                            'name' => 'tagline',
                                            'value' => $features['tagline'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Slogan (Upper Tagline)')
                                        ]); ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'featTitle',
                                            'name' => 'title',
                                            'value' => $features['title'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Title')
                                        ]); ?>
                                        <p class="text-muted small mt-n2">
                                            <?php echo __('Use the toolbar or <span>txt</span> for blue highlight.'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Feature Items'); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                                        <i class="fas fa-plus"></i> <?php echo __('Add Item'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="featList">
                                    <?php if (!empty($items)): ?>
                                        <?php foreach ($items as $idx => $item): ?>
                                            <div class="feat-item border rounded p-3 mb-3 bg-light position-relative"
                                                id="feat-<?php echo $idx; ?>">
                                                <button type="button" class="btn btn-danger btn-sm position-absolute"
                                                    style="top: 10px; right: 10px; z-index: 10;"
                                                    onclick="this.closest('.feat-item').remove()">
                                                    <i class="fas fa-times" style="pointer-events: none;"></i>
                                                </button>
                                                <div class="row">
                                                    <div class="col-md-2 text-center border-right">
                                                        <label class="small fw-bold d-block"><?php echo __('Icon'); ?></label>
                                                        <div class="icon-preview mb-2 d-flex align-items-center justify-content-center bg-white border rounded"
                                                            style="height: 60px;">
                                                            <?php
                                                            $icon_src = (strpos($item['icon'], '/') === false) ? '/assets/img/icons/' . $item['icon'] : $item['icon'];
                                                            ?>
                                                            <img src="<?php echo BASE_URL . htmlspecialchars($icon_src); ?>"
                                                                alt="Icon" style="max-height: 40px; max-width: 40px;">
                                                        </div>
                                                        <input type="hidden" name="items_icons[]"
                                                            value="<?php echo htmlspecialchars($item['icon']); ?>">
                                                        <button type="button" class="btn btn-outline-secondary btn-xs"
                                                            onclick="pickIcon(this)"><?php echo __('Change'); ?></button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <?php render_wysiwyg([
                                                            'id' => 'featItem_' . $idx,
                                                            'name' => 'items_titles[]',
                                                            'value' => $item['title'] ?? '',
                                                            'type' => 'oneliner',
                                                            'label' => __('Feature Title')
                                                        ]); ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <div class="col-12 mb-2">
                                                                <label
                                                                    class="small fw-bold"><?php echo __('Badge Text'); ?></label>
                                                                <input type="text" name="items_badges[]"
                                                                    class="form-control form-control-sm"
                                                                    value="<?php echo htmlspecialchars($item['label'] ?? ''); ?>"
                                                                    placeholder="<?php echo __('e.g. New'); ?>">
                                                            </div>
                                                            <div class="col-12">
                                                                <label
                                                                    class="small fw-bold"><?php echo __('Badge Color'); ?></label>
                                                                <input type="color" name="items_badge_colors[]"
                                                                    class="form-control form-control-sm"
                                                                    value="<?php echo htmlspecialchars($item['label_color'] ?? '#5842bc'); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
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
                    <h5 class="modal-title"><?php echo __('Select Icon'); ?></h5>
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
        let activeIconTrigger = null;

        function addItem() {
            const list = document.getElementById('featList');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'feat-item border rounded p-3 mb-3 bg-light position-relative';
            div.id = 'feat-' + idx;
            div.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px; z-index: 10;" onclick="this.closest('.feat-item').remove()">
                    <i class="fas fa-times" style="pointer-events: none;"></i>
                </button>
                <div class="row">
                    <div class="col-md-2 text-center border-right">
                        <label class="small fw-bold d-block">Icon</label>
                        <div class="icon-preview mb-2 d-flex align-items-center justify-content-center bg-white border rounded" style="height: 60px;">
                            <img src="<?php echo BASE_URL; ?>/assets/img/icons/image_placeholder.png" alt="Icon" style="max-height: 40px; max-width: 40px;">
                        </div>
                        <input type="hidden" name="items_icons[]" value="">
                        <button type="button" class="btn btn-outline-secondary btn-xs" onclick="pickIcon(this)">Change</button>
                    </div>
                    <div class="col-md-6">
                        <div class="wysiwyg-container mb-3" id="container_featItem_${idx}">
                            <label><?php echo __('Feature Title'); ?></label>
                            <div class="wysiwyg-toolbar btn-group mb-1">
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygExec('featItem_${idx}', 'bold')" title="Bold">
                                    <i class="fas fa-bold"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygApplyClass('featItem_${idx}', 'editor-span')" title="Span Highlight">
                                    <span>&lt;span&gt;</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="wysiwygApplyClass('featItem_${idx}', 'color-blue4')" title="Blue Text">
                                    <span class="text-primary">Blue</span>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="wysiwygToggleSource('featItem_${idx}')" title="Toggle Source">
                                    <i class="fas fa-code"></i> Source
                                </button>
                            </div>
                            <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                <div id="visual_featItem_${idx}" class="wysiwyg-visual p-2" contenteditable="true"
                                    style="min-height: 40px; height: auto; overflow-y: auto;"
                                    oninput="wysiwygSync('featItem_${idx}', 'toSource')"></div>
                                <textarea id="source_featItem_${idx}" name="items_titles[]" class="wysiwyg-source form-control d-none"
                                    style="min-height: 40px; height: auto; border: none; border-radius: 0;"
                                    oninput="wysiwygSync('featItem_${idx}', 'toVisual')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <label class="small fw-bold">Badge Text</label>
                                <input type="text" name="items_badges[]" class="form-control form-control-sm" placeholder="e.g. New">
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold">Badge Color</label>
                                <input type="color" name="items_badge_colors[]" class="form-control form-control-sm" value="#5842bc">
                            </div>
                        </div>
                    </div>
                </div>
            `;
            list.appendChild(div);
        }


        function pickIcon(btn) {
            activeIconTrigger = btn;
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            initMediaBrowser((path) => {
                const row = activeIconTrigger.closest('.row');
                row.querySelector('input[type="hidden"]').value = path;
                row.querySelector('.icon-preview').innerHTML = `<img src="${CONFIG.BASE_URL + path}" alt="Icon" style="max-height: 40px; max-width: 40px;">`;
                $('#mediaModal').modal('hide');
            });
        });
    </script>
</body>

</html>