<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'products';
$page_title = __('Products Section');

$settings = db_get_flat('settings');
$products = db_get_by_id('products', 1) ?: [];
$tabs = db_get_children('product_tabs', 'product_id', 1);

foreach ($tabs as &$tab) {
    $tab['features'] = db_get_children('product_features', 'tab_id', $tab['id']);
}
unset($tab); // Clean up the reference to prevent replication issues
$products['tabs'] = $tabs;
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
                            <h1 class="m-0"><?php echo __('Products Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="productsForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="productsForm" action="products_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>

                        <!-- Global Header Card -->
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Section Header'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'prodHeadSlogan',
                                            'name' => 'header_slogan',
                                            'value' => $products['header_slogan'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Upper Slogan')
                                        ]); ?>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'prodHeadTitle',
                                            'name' => 'header_title',
                                            'value' => $products['header_title'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Header Title')
                                        ]); ?>
                                        <p class="text-muted small mt-n2">
                                            <?php echo __('Use the toolbar or <span>txt</span> for blue highlight.'); ?>
                                        </p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'prodHeadDesc',
                                            'name' => 'header_desc',
                                            'value' => $products['header_desc'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Description')
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="tabsContainer">
                            <?php foreach (($products['tabs'] ?? []) as $tab):
                                $tIndex = $tab['id']; ?>
                                <div class="card card-outline card-info tab-item shadow-sm"
                                    id="tab_container_<?php echo $tIndex; ?>">
                                    <div class="card-header border-bottom-0">
                                        <h3 class="card-title font-weight-bold"><?php echo __('Product Tab'); ?></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-danger btn-xs" style="z-index: 10;"
                                                onclick="this.closest('.tab-item').remove()">
                                                <i class="fas fa-trash" style="pointer-events: none;"></i>
                                                <?php echo __('Remove Tab'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <!-- Sidebar/Nav Info -->
                                            <div class="col-md-3 border-right">
                                                <h6 class="text-primary font-weight-bold mb-3 small uppercase">
                                                    <?php echo __('Tab Navigation'); ?></h6>
                                                <div class="mb-3">
                                                    <label class="small fw-bold"><?php echo __('Menu Label'); ?></label>
                                                    <input type="text" name="tabs[<?php echo $tIndex; ?>][nav_label]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($tab['nav_label'] ?? ''); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small fw-bold"><?php echo __('Menu Icon'); ?></label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <?php if (strpos($tab['nav_icon'] ?? '', '/') !== false || strpos($tab['nav_icon'] ?? '', 'assets') !== false): ?>
                                                                    <img src="<?php echo BASE_URL . $tab['nav_icon']; ?>"
                                                                        style="width: 16px; height: 16px; object-fit: contain;">
                                                                <?php else: ?>
                                                                    <i
                                                                        class="bi <?php echo htmlspecialchars($tab['nav_icon'] ?? 'bi-star'); ?>"></i>
                                                                <?php endif; ?>
                                                            </span>
                                                        </div>
                                                        <input type="hidden" name="tabs[<?php echo $tIndex; ?>][nav_icon]"
                                                            value="<?php echo htmlspecialchars($tab['nav_icon'] ?? ''); ?>">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                onclick="pickTabIcon(this)"><?php echo __('Icon'); ?></button>
                                                            <button type="button" class="btn btn-outline-primary"
                                                                onclick="pickTabImageIcon(this, '<?php echo $tIndex; ?>')">Img</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="small fw-bold"><?php echo __('Main Image'); ?></label>
                                                    <div class="preview-img mb-2 bg-light border rounded text-center"
                                                        style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                                        <img src="<?php echo BASE_URL . htmlspecialchars($tab['main_image'] ?? ''); ?>"
                                                            style="max-height: 100%; max-width: 100%; object-fit: contain;"
                                                            id="img-preview-<?php echo $tIndex; ?>">
                                                    </div>
                                                    <input type="hidden" name="tabs[<?php echo $tIndex; ?>][main_image]"
                                                        id="img-path-<?php echo $tIndex; ?>"
                                                        value="<?php echo htmlspecialchars($tab['main_image'] ?? ''); ?>">
                                                    <button type="button" class="btn btn-outline-primary btn-block btn-xs"
                                                        onclick="pickTabImage(this, '<?php echo $tIndex; ?>')">
                                                        <i class="fas fa-image mr-1"></i> <?php echo __('Change Image'); ?>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Content Info -->
                                            <div class="col-md-5 border-right">
                                                <h6 class="text-primary font-weight-bold mb-3 small uppercase">
                                                    <?php echo __('Tab Content'); ?>
                                                </h6>
                                                <div class="mb-3">
                                                    <?php render_wysiwyg([
                                                        'id' => 'tabSlogan_' . $tIndex,
                                                        'name' => "tabs[{$tIndex}][side_slogan]",
                                                        'value' => $tab['side_slogan'] ?? '',
                                                        'type' => 'oneliner',
                                                        'label' => __('Side Slogan')
                                                    ]); ?>
                                                </div>
                                                <div class="mb-3">
                                                    <?php render_wysiwyg([
                                                        'id' => 'tabTitle_' . $tIndex,
                                                        'name' => "tabs[{$tIndex}][side_title]",
                                                        'value' => $tab['side_title'] ?? '',
                                                        'type' => 'oneliner',
                                                        'label' => __('Side Title')
                                                    ]); ?>
                                                    <p class="text-muted small mt-n2">
                                                        <?php echo __('Use the toolbar or <span>txt</span> for highlighted text.'); ?>
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <?php render_wysiwyg([
                                                        'id' => 'tabDesc_' . $tIndex,
                                                        'name' => "tabs[{$tIndex}][side_desc]",
                                                        'value' => $tab['side_desc'] ?? '',
                                                        'type' => 'paragraph',
                                                        'label' => __('Description')
                                                    ]); ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="small fw-bold"><?php echo __('Btn Text'); ?></label>
                                                        <input type="text" name="tabs[<?php echo $tIndex; ?>][btn_text]"
                                                            class="form-control form-control-sm"
                                                            value="<?php echo htmlspecialchars($tab['btn_text'] ?? ''); ?>">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="small fw-bold"><?php echo __('Btn URL'); ?></label>
                                                        <input type="text" name="tabs[<?php echo $tIndex; ?>][btn_url]"
                                                            class="form-control form-control-sm"
                                                            value="<?php echo htmlspecialchars($tab['btn_url'] ?? ''); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Features List -->
                                            <div class="col-md-4">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="text-primary font-weight-bold mb-0 small uppercase">
                                                        <?php echo __('Features'); ?>
                                                    </h6>
                                                    <button type="button" class="btn btn-outline-info btn-xs rounded-pill"
                                                        onclick="addFeature(<?php echo $tIndex; ?>)">
                                                        <i class="fas fa-plus mr-1"></i> <?php echo __('Add'); ?>
                                                    </button>
                                                </div>
                                                <div id="features-<?php echo $tIndex; ?>">
                                                    <?php foreach (($tab['features'] ?? []) as $feat):
                                                        $fIndex = $feat['id']; ?>
                                                        <div
                                                            class="feature-row d-flex align-items-center mb-2 bg-light p-2 rounded position-relative">
                                                            <div class="input-group input-group-sm mr-2" style="width: 100px;">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                            class="bi <?php echo htmlspecialchars($feat['icon'] ?? 'bi-check'); ?>"></i></span>
                                                                </div>
                                                                <input type="hidden"
                                                                    name="tabs[<?php echo $tIndex; ?>][features][<?php echo $fIndex; ?>][icon]"
                                                                    value="<?php echo htmlspecialchars($feat['icon'] ?? ''); ?>">
                                                                <div class="input-group-append">
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        onclick="pickFeatIcon(this)">P</button>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 mr-2">
                                                                <?php render_wysiwyg([
                                                                    'id' => "feat_{$tIndex}_{$fIndex}",
                                                                    'name' => "tabs[{$tIndex}][features][{$fIndex}][text]",
                                                                    'value' => $feat['text'] ?? '',
                                                                    'type' => 'oneliner'
                                                                ]); ?>
                                                            </div>
                                                            <button type="button" class="btn btn-danger btn-xs"
                                                                style="z-index: 10;"
                                                                onclick="this.closest('.feature-row').remove()">
                                                                <i class="fas fa-times" style="pointer-events: none;"></i>
                                                            </button>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="text-center mb-4">
                            <button type="button" class="btn btn-outline-primary shadow-sm" onclick="addTab()">
                                <i class="fas fa-plus mr-2"></i> <?php echo __('Add New Product Tab'); ?>
                            </button>
                        </div>

                        <div class="card shadow-sm mb-5">
                            <div class="card-body p-4 text-center">
                                <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                                    <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="iconModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><?php echo __('Pick Icon'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php include __DIR__ . '/partials/icon_picker.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><?php echo __('Select Product Asset'); ?></h5>
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
        let prodMediaTrigger = null;
        let prodIconTrigger = null;
        let prodMediaMode = 'main'; // 'main' or 'icon'

        function pickTabIcon(btn) { prodIconTrigger = btn; $('#iconModal').modal('show'); }
        function pickFeatIcon(btn) { prodIconTrigger = btn; $('#iconModal').modal('show'); }

        function addTab() {
            const container = document.getElementById('tabsContainer');
            const idx = Date.now();
            const count = document.querySelectorAll('.tab-item').length + 1;
            const div = document.createElement('div');
            div.className = 'card card-outline card-info tab-item shadow-sm';
            div.id = 'tab-' + idx;
            div.innerHTML = `
                <div class="card-header border-bottom-0">
                    <h3 class="card-title font-weight-bold">Product Tab #${count}</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-danger btn-xs" style="z-index: 10;" onclick="this.closest('.tab-item').remove()">
                            <i class="fas fa-trash" style="pointer-events: none;"></i> Remove Tab
                        </button>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-md-3 border-right">
                            <h6 class="text-primary font-weight-bold mb-3 small uppercase">Tab Navigation</h6>
                            <div class="mb-3">
                                <label class="small fw-bold">Menu Label</label>
                                <input type="text" name="tabs[${idx}][nav_label]" class="form-control form-control-sm" placeholder="Notero - Notes App">
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold">Menu Icon</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="bi bi-star"></i></span>
                                    </div>
                                    <input type="hidden" name="tabs[${idx}][nav_icon]" value="bi-star">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary" onclick="pickTabIcon(this)">Icon</button>
                                        <button type="button" class="btn btn-outline-primary" onclick="pickTabImageIcon(this, '${idx}')">Img</button>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small fw-bold">Main Image</label>
                                <div class="preview-img mb-2 bg-light border rounded text-center" style="height: 120px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                <input type="hidden" name="tabs[${idx}][main_image]" id="img-path-${idx}" value="">
                                <button type="button" class="btn btn-outline-primary btn-block btn-xs" onclick="pickTabImage(this, '${idx}')">
                                    <i class="fas fa-image mr-1"></i> Change Image
                                </button>
                            </div>
                        </div>
                        <div class="col-md-5 border-right">
                            <h6 class="text-primary font-weight-bold mb-3 small uppercase">Tab Content</h6>
                            <div class="mb-3">
                                <div class="wysiwyg-container mb-3" id="container_tabSlogan_${idx}">
                                    <label>Side Slogan</label>
                                    <div class="wysiwyg-toolbar btn-group mb-1">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygExec('tabSlogan_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygApplyClass('tabSlogan_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="wysiwygApplyClass('tabSlogan_${idx}', 'color-blue4')" title="Blue Text"><span class="text-primary">Blue</span></button>
                                        <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="wysiwygToggleSource('tabSlogan_${idx}')" title="Toggle Source"><i class="fas fa-code"></i> Source</button>
                                    </div>
                                    <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                        <div id="visual_tabSlogan_${idx}" class="wysiwyg-visual p-2" contenteditable="true" style="min-height: 40px; height: auto; overflow-y: auto;" oninput="wysiwygSync('tabSlogan_${idx}', 'toSource')"></div>
                                        <textarea id="source_tabSlogan_${idx}" name="tabs[${idx}][side_slogan]" class="wysiwyg-source form-control d-none" style="min-height: 40px; height: auto; border: none; border-radius: 0;" oninput="wysiwygSync('tabSlogan_${idx}', 'toVisual')"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="wysiwyg-container mb-3" id="container_tabTitle_${idx}">
                                    <label>Side Title</label>
                                    <div class="wysiwyg-toolbar btn-group mb-1">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygExec('tabTitle_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygApplyClass('tabTitle_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="wysiwygApplyClass('tabTitle_${idx}', 'color-blue4')" title="Blue Text"><span class="text-primary">Blue</span></button>
                                        <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="wysiwygToggleSource('tabTitle_${idx}')" title="Toggle Source"><i class="fas fa-code"></i> Source</button>
                                    </div>
                                    <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                        <div id="visual_tabTitle_${idx}" class="wysiwyg-visual p-2" contenteditable="true" style="min-height: 40px; height: auto; overflow-y: auto;" oninput="wysiwygSync('tabTitle_${idx}', 'toSource')"></div>
                                        <textarea id="source_tabTitle_${idx}" name="tabs[${idx}][side_title]" class="wysiwyg-source form-control d-none" style="min-height: 40px; height: auto; border: none; border-radius: 0;" oninput="wysiwygSync('tabTitle_${idx}', 'toVisual')"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="wysiwyg-container mb-3" id="container_tabDesc_${idx}">
                                    <label>Description</label>
                                    <div class="wysiwyg-toolbar btn-group mb-1">
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygExec('tabDesc_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygInsertBR('tabDesc_${idx}')" title="New Line"><i class="fas fa-level-down-alt"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygApplyClass('tabDesc_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="wysiwygApplyClass('tabDesc_${idx}', 'color-blue4')" title="Blue Text"><span class="text-primary">Blue</span></button>
                                        <button type="button" class="btn btn-sm btn-outline-info ml-2" onclick="wysiwygToggleSource('tabDesc_${idx}')" title="Toggle Source"><i class="fas fa-code"></i> Source</button>
                                    </div>
                                    <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                        <div id="visual_tabDesc_${idx}" class="wysiwyg-visual p-2" contenteditable="true" style="min-height: 150px; height: 200px; overflow-y: auto;" oninput="wysiwygSync('tabDesc_${idx}', 'toSource')"></div>
                                        <textarea id="source_tabDesc_${idx}" name="tabs[${idx}][side_desc]" class="wysiwyg-source form-control d-none" style="min-height: 150px; height: 200px; border: none; border-radius: 0;" oninput="wysiwygSync('tabDesc_${idx}', 'toVisual')"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <label class="small fw-bold">Btn Text</label>
                                    <input type="text" name="tabs[${idx}][btn_text]" class="form-control form-control-sm">
                                </div>
                                <div class="col-6">
                                    <label class="small fw-bold">Btn URL</label>
                                    <input type="text" name="tabs[${idx}][btn_url]" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="text-primary font-weight-bold mb-0 small uppercase">Features</h6>
                                <button type="button" class="btn btn-outline-info btn-xs rounded-pill" onclick="addFeature('${idx}')">
                                    <i class="fas fa-plus mr-1"></i> Add
                                </button>
                            </div>
                            <div id="features-${idx}"></div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }


        function addFeature(tabIdx) {
            const list = document.getElementById('features-' + tabIdx);
            const fIdx = Date.now();
            const div = document.createElement('div');
            div.className = 'feature-row d-flex align-items-center mb-2 bg-light p-2 rounded position-relative';
            div.innerHTML = `
                <div class="input-group input-group-sm mr-2" style="width: 100px;">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="bi bi-check"></i></span>
                    </div>
                    <input type="hidden" name="tabs[${tabIdx}][features][${fIdx}][icon]" value="bi-check">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-secondary" onclick="pickFeatIcon(this)">P</button>
                    </div>
                </div>
                <div class="flex-grow-1 mr-2">
                    <div class="wysiwyg-container mb-0" id="container_feat_${tabIdx}_${fIdx}">
                        <div class="wysiwyg-toolbar btn-group mb-1">
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('feat_${tabIdx}_${fIdx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('feat_${tabIdx}_${fIdx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                            <button type="button" class="btn btn-xs btn-outline-primary" onclick="wysiwygApplyClass('feat_${tabIdx}_${fIdx}', 'color-blue4')" title="Blue Text"><span class="text-primary text-xs">B</span></button>
                            <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('feat_${tabIdx}_${fIdx}')" title="Source"><i class="fas fa-code"></i></button>
                        </div>
                        <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                            <div id="visual_feat_${tabIdx}_${fIdx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 38px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('feat_${tabIdx}_${fIdx}', 'toSource')"></div>
                            <textarea id="source_feat_${tabIdx}_${fIdx}" name="tabs[${tabIdx}][features][${fIdx}][text]" class="wysiwyg-source form-control d-none" style="min-height: 38px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('feat_${tabIdx}_${fIdx}', 'toVisual')"></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-xs" style="z-index: 10;" onclick="this.closest('.feature-row').remove()">
                    <i class="fas fa-times" style="pointer-events: none;"></i>
                </button>
            `;
            list.appendChild(div);
        }


        function pickTabImage(btn) {
            prodMediaTrigger = btn;
            prodMediaMode = 'main';
            $('#mediaModal').modal('show');
        }

        function pickTabImageIcon(btn) {
            prodMediaTrigger = btn;
            prodMediaMode = 'icon';
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initMediaBrowser === 'function') {
                initMediaBrowser((path) => {
                    if (prodMediaMode === 'icon') {
                        const group = prodMediaTrigger.closest('.input-group');
                        const iconWrapper = group.querySelector('.input-group-text');
                        iconWrapper.innerHTML = `<img src="${CONFIG.BASE_URL + path}" style="width: 16px; height: 16px; object-fit: contain;">`;
                        group.querySelector('input[type="hidden"]').value = path;
                    } else {
                        const col = prodMediaTrigger.closest('.col-md-3');
                        col.querySelector('input[id^="img-path-"]').value = path;
                        const preview = col.querySelector('.preview-img');
                        preview.innerHTML = `<img src="${CONFIG.BASE_URL + path}" style="max-height: 100%; max-width: 100%; object-fit: contain;">`;
                    }
                    $('#mediaModal').modal('hide');
                });
            }

            if (typeof initIconPicker === 'function') {
                initIconPicker((icon) => {
                    const group = prodIconTrigger.closest('.input-group');
                    const iconWrapper = group.querySelector('.input-group-text');
                    iconWrapper.innerHTML = `<i class="bi ${icon}"></i>`;
                    group.querySelector('input[type="hidden"]').value = icon;
                    $('#iconModal').modal('hide');
                });
            }
        });
    </script>
</body>

</html>