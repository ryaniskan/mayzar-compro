<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'testimonials';
$page_title = __('Testimonials Section');

$testi = db_get_by_id('testimonials', 1) ?: [];
$testi['stats'] = db_get_children('testimonial_stats', 'testimonials_id', 1);
$testi['list'] = db_get_children('testimonial_list', 'testimonials_id', 1);
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
                            <h1 class="m-0"><?php echo __('Testimonials Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="testimonialForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="testimonialsForm" action="testimonials_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Section Configuration'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'testiTagline',
                                            'name' => 'tagline',
                                            'value' => $testi['tagline'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Tagline')
                                        ]); ?>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'testiTitle',
                                            'name' => 'title',
                                            'value' => $testi['title'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Title')
                                        ]); ?>
                                        <p class="text-muted small mt-n2">Use
                                            the toolbar or <code>&lt;span&gt;txt&lt;/span&gt;</code> for highlight.
                                        </p>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'testiDesc',
                                            'name' => 'description',
                                            'value' => $testi['description'] ?? '',
                                            'type' => 'paragraph',
                                            'label' => __('Description')
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <?php for ($i = 0; $i < 2; $i++):
                                $stat = $testi['stats'][$i] ?? [];
                                ?>
                                <div class="col-md-6">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title"><?php echo __('Overall Stat'); ?> #<?php echo $i + 1; ?>
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="mr-3">
                                                    <img src="<?php echo BASE_URL . htmlspecialchars($stat['icon'] ?? '/assets/img/icons/image_placeholder.png'); ?>"
                                                        class="img-circle border" width="50" height="50"
                                                        id="stat-preview-<?php echo $i; ?>">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <input type="hidden" name="stats[<?php echo $i; ?>][icon]"
                                                        id="stat-path-<?php echo $i; ?>"
                                                        value="<?php echo htmlspecialchars($stat['icon'] ?? ''); ?>">
                                                    <button type="button" class="btn btn-outline-secondary btn-xs"
                                                        onclick="openMediaBrowser('stat-<?php echo $i; ?>')"><?php echo __('Change Icon'); ?></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="small fw-bold"><?php echo __('Value'); ?></label>
                                                    <input type="text" name="stats[<?php echo $i; ?>][value]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($stat['value'] ?? ''); ?>">
                                                </div>
                                                <div class="col-md-8 mb-2">
                                                    <label class="small fw-bold"><?php echo __('Label'); ?></label>
                                                    <input type="text" name="stats[<?php echo $i; ?>][label]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($stat['label'] ?? ''); ?>">
                                                </div>
                                                <div class="col-12 mt-2">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="stars-<?php echo $i; ?>"
                                                            name="stats[<?php echo $i; ?>][show_stars]" value="1" <?php echo !empty($stat['show_stars']) ? 'checked' : ''; ?>>
                                                        <label class="custom-control-label small fw-bold"
                                                            for="stars-<?php echo $i; ?>"><?php echo __('Show 5 Stars'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Testimonial Cards'); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                                        <i class="fas fa-plus"></i> <?php echo __('Add Testimonial'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="itemsContainer">
                                    <?php foreach (($testi['list'] ?? []) as $idx => $item): ?>
                                        <div class="testi-card border rounded p-3 mb-3 bg-light position-relative"
                                            id="item-<?php echo $idx; ?>">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute"
                                                style="top: 10px; right: 10px; z-index: 10;"
                                                onclick="this.closest('.testi-card').remove()">
                                                <i class="fas fa-times" style="pointer-events: none;"></i>
                                            </button>
                                            <div class="row">
                                                <div class="col-auto text-center border-right pr-3 mr-3">
                                                    <img src="<?php echo BASE_URL . htmlspecialchars($item['image'] ?? '/assets/img/icons/image_placeholder.png'); ?>"
                                                        class="img-circle border" width="60" height="60"
                                                        id="preview-<?php echo $idx; ?>">
                                                    <input type="hidden" name="list[<?php echo $idx; ?>][image]"
                                                        id="path-<?php echo $idx; ?>"
                                                        value="<?php echo htmlspecialchars($item['image'] ?? ''); ?>">
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-outline-secondary btn-xs"
                                                            onclick="openMediaBrowser('<?php echo $idx; ?>')"><?php echo __('Change'); ?></button>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-2">
                                                            <label
                                                                class="small fw-bold"><?php echo __('Stars (1-5)'); ?></label>
                                                            <input type="number" name="list[<?php echo $idx; ?>][stars]"
                                                                class="form-control form-control-sm"
                                                                value="<?php echo htmlspecialchars($item['stars'] ?? 5); ?>"
                                                                min="1" max="5">
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <?php render_wysiwyg([
                                                                'id' => "name_{$idx}",
                                                                'name' => "list[{$idx}][name]",
                                                                'value' => $item['name'] ?? '',
                                                                'type' => 'oneliner',
                                                                'label' => __('Name')
                                                            ]); ?>
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <?php render_wysiwyg([
                                                                'id' => "pos_{$idx}",
                                                                'name' => "list[{$idx}][position]",
                                                                'value' => $item['position'] ?? '',
                                                                'type' => 'oneliner',
                                                                'label' => __('Position/Company')
                                                            ]); ?>
                                                        </div>
                                                        <div class="col-12">
                                                            <?php render_wysiwyg([
                                                                'id' => "quote_{$idx}",
                                                                'name' => "list[{$idx}][quote]",
                                                                'value' => $item['quote'] ?? '',
                                                                'type' => 'paragraph',
                                                                'label' => __('Quote')
                                                            ]); ?>
                                                        </div>
                                                    </div>
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
            initMediaBrowser((path) => {
                const pathInput = document.getElementById(activeIdx.startsWith('stat-') ? 'stat-path-' + activeIdx.split('-')[1] : 'path-' + activeIdx);
                const previewImg = document.getElementById(activeIdx.startsWith('stat-') ? 'stat-preview-' + activeIdx.split('-')[1] : 'preview-' + activeIdx);
                if (pathInput) pathInput.value = path;
                if (previewImg) previewImg.src = CONFIG.BASE_URL + path;
                $('#mediaModal').modal('hide');
            });
        });

        function addItem() {
            const container = document.getElementById('itemsContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'testi-card border rounded p-3 mb-3 bg-light position-relative';
            div.id = 'item-' + idx;
            div.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: 10px; right: 10px; z-index: 10;" onclick="this.closest('.testi-card').remove()">
                    <i class="fas fa-times" style="pointer-events: none;"></i>
                </button>
                <div class="row">
                    <div class="col-auto text-center border-right pr-3 mr-3">
                        <img src="/assets/img/icons/image_placeholder.png" class="img-circle border" width="60" height="60" id="preview-${idx}">
                        <input type="hidden" name="list[${idx}][image]" id="path-${idx}" value="/assets/img/icons/image_placeholder.png">
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-secondary btn-xs" onclick="openMediaBrowser('${idx}')">Change</button>
                        </div>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label class="small fw-bold mb-1">Stars (1-5)</label>
                                <input type="number" name="list[${idx}][stars]" class="form-control form-control-sm" value="5" min="1" max="5">
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="wysiwyg-container mb-0" id="container_name_${idx}">
                                    <label class="small fw-bold mb-1">Name</label>
                                    <div class="wysiwyg-toolbar btn-group mb-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('name_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('name_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                        <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('name_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                                    </div>
                                    <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                        <div id="visual_name_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 31px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('name_${idx}', 'toSource')"></div>
                                        <textarea id="source_name_${idx}" name="list[${idx}][name]" class="wysiwyg-source form-control d-none" style="min-height: 31px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('name_${idx}', 'toVisual')"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="wysiwyg-container mb-0" id="container_pos_${idx}">
                                    <label class="small fw-bold mb-1">Position/Company</label>
                                    <div class="wysiwyg-toolbar btn-group mb-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('pos_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('pos_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                        <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('pos_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                                    </div>
                                    <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                        <div id="visual_pos_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 31px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('pos_${idx}', 'toSource')"></div>
                                        <textarea id="source_pos_${idx}" name="list[${idx}][position]" class="wysiwyg-source form-control d-none" style="min-height: 31px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('pos_${idx}', 'toVisual')"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="wysiwyg-container mb-0" id="container_quote_${idx}">
                                    <label class="small fw-bold mb-1">Quote</label>
                                    <div class="wysiwyg-toolbar btn-group mb-1">
                                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('quote_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                        <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('quote_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                        <button type="button" class="btn btn-xs btn-outline-primary" onclick="wysiwygApplyClass('quote_${idx}', 'color-blue4')" title="Blue Text"><span class="text-primary text-xs">B</span></button>
                                        <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('quote_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                                    </div>
                                    <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                        <div id="visual_quote_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 60px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('quote_${idx}', 'toSource')"></div>
                                        <textarea id="source_quote_${idx}" name="list[${idx}][quote]" class="wysiwyg-source form-control d-none" style="min-height: 60px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('quote_${idx}', 'toVisual')"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</body>

</html>