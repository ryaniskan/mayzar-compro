<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'community';
$page_title = __('Community Hub');

$community = db_get_by_id('community', 1) ?: [];
$community['list'] = db_get_children('community_list', 'community_id', 1);
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
                            <h1 class="m-0"><?php echo __('Community Hub'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="communityForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="communityForm" action="community_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php
                        require_once __DIR__ . '/partials/wysiwyg_editor.php';
                        ?>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Section Configuration'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'commTagline',
                                            'name' => 'tagline',
                                            'value' => $community['tagline'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Tagline')
                                        ]); ?>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'commTitle',
                                            'name' => 'title',
                                            'value' => $community['title'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Title')
                                        ]); ?>
                                        <p class="text-muted small mt-n2">
                                            <?php echo __('Use the toolbar or <code>&lt;span&gt;txt&lt;/span&gt;</code> for highlight.'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Social Cards'); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                                        <i class="fas fa-plus"></i> <?php echo __('Add Card'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="itemsContainer">
                                    <?php foreach (($community['list'] ?? []) as $idx => $item): ?>
                                        <div class="social-item border rounded p-3 mb-3 bg-light position-relative"
                                            id="item-<?php echo $idx; ?>">
                                            <button type="button" class="btn btn-tool text-danger position-absolute"
                                                style="top: 10px; right: 10px; z-index: 10;"
                                                onclick="this.closest('.social-item').remove()">
                                                <i class="fas fa-trash-alt" style="pointer-events: none;"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label class="small fw-bold"><?php echo __('Icon'); ?></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i
                                                                    class="<?php echo htmlspecialchars($item['icon'] ?? 'bi-share'); ?>"></i></span>
                                                        </div>
                                                        <input type="hidden" name="list[<?php echo $idx; ?>][icon]"
                                                            value="<?php echo htmlspecialchars($item['icon'] ?? 'bi-share'); ?>">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                onclick="pickIcon(this)"><?php echo __('Pick'); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <?php render_wysiwyg([
                                                        'id' => "comm_name_{$idx}",
                                                        'name' => "list[{$idx}][title]",
                                                        'value' => $item['title'] ?? '',
                                                        'type' => 'oneliner',
                                                        'label' => __('Title / Platform')
                                                    ]); ?>
                                                </div>
                                                <div class="col-md-5">
                                                    <?php render_wysiwyg([
                                                        'id' => "comm_desc_{$idx}",
                                                        'name' => "list[{$idx}][description]",
                                                        'value' => $item['description'] ?? '',
                                                        'type' => 'oneliner',
                                                        'label' => __('Description')
                                                    ]); ?>
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <label class="small fw-bold"><?php echo __('URL'); ?></label>
                                                    <input type="text" name="list[<?php echo $idx; ?>][url]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($item['url'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <!-- Icon Picker Modal -->
    <div class="modal fade" id="iconModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><?php echo __('Pick Icon'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php
                    // No need to include again if already included at top, 
                    // but we need to ensure the HTML is inside the modal body
                    ?>
                    <div id="iconPickerWrapper">
                        <?php include_once __DIR__ . '/partials/icon_picker.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <script>
        let activeIconTrigger = null;

        function addItem() {
            const container = document.getElementById('itemsContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'social-item border rounded p-3 mb-3 bg-light position-relative';
            div.innerHTML = `
                <button type="button" class="btn btn-tool text-danger position-absolute" style="top: 10px; right: 10px; z-index: 10;" onclick="this.closest('.social-item').remove()">
                    <i class="fas fa-trash-alt" style="pointer-events: none;"></i>
                </button>
                <div class="row">
                    <div class="col-md-3">
                        <label class="small fw-bold">Icon</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="bi bi-share"></i></span>
                            </div>
                            <input type="hidden" name="list[${idx}][icon]" value="bi-share">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary" onclick="pickIcon(this)">Pick</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="wysiwyg-container mb-0" id="container_comm_name_${idx}">
                            <label class="small fw-bold mb-1">Title / Platform</label>
                            <div class="wysiwyg-toolbar btn-group mb-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('comm_name_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('comm_name_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('comm_name_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                            </div>
                            <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                <div id="visual_comm_name_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 31px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('comm_name_${idx}', 'toSource')"></div>
                                <textarea id="source_comm_name_${idx}" name="list[${idx}][title]" class="wysiwyg-source form-control d-none" style="min-height: 31px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('comm_name_${idx}', 'toVisual')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="wysiwyg-container mb-0" id="container_comm_desc_${idx}">
                            <label class="small fw-bold mb-1">Description</label>
                            <div class="wysiwyg-toolbar btn-group mb-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('comm_desc_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('comm_desc_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('comm_desc_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                            </div>
                            <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                <div id="visual_comm_desc_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 31px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('comm_desc_${idx}', 'toSource')"></div>
                                <textarea id="source_comm_desc_${idx}" name="list[${idx}][description]" class="wysiwyg-source form-control d-none" style="min-height: 31px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('comm_desc_${idx}', 'toVisual')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-2">
                        <label class="small fw-bold">URL</label>
                        <input type="text" name="list[${idx}][url]" class="form-control form-control-sm" placeholder="https://...">
                    </div>
                </div>
            `;
            container.appendChild(div);
        }

        function pickIcon(btn) {
            activeIconTrigger = btn;
            $('#iconModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initIconPicker === 'function') {
                initIconPicker((icon) => {
                    if (activeIconTrigger) {
                        const group = activeIconTrigger.closest('.input-group');
                        group.querySelector('i').className = 'bi ' + icon;
                        group.querySelector('input').value = 'bi ' + icon; // Prepend 'bi ' because our picker returns bi-name
                        $('#iconModal').modal('hide');
                    }
                });
            }
        });
    </script>
</body>

</html>