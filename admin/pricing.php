<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'pricing';
$page_title = __('Pricing Plans');

$pricing = db_get_by_id('pricing', 1) ?: [];
$plans = db_get_children('pricing_plans', 'pricing_id', 1);
foreach ($plans as &$plan) {
    $plan['features'] = db_get_children('pricing_features', 'plan_id', $plan['id']);
}
unset($plan);
$pricing['plans'] = $plans;
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
                            <h1 class="m-0"><?php echo __('Pricing Plans'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="pricingForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="pricingForm" action="pricing_handler" method="POST" onsubmit="wysiwygSyncAll()">
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
                                            'id' => 'pricingTagline',
                                            'name' => 'tagline',
                                            'value' => $pricing['tagline'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Tagline')
                                        ]); ?>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'pricingTitle',
                                            'name' => 'title',
                                            'value' => $pricing['title'] ?? '',
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

                        <div class="row">
                            <?php foreach ($pricing['plans'] as $plan):
                                $i = $plan['id'];
                                ?>
                                <div class="col-lg-4">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h3 class="card-title"><?php echo __('Plan'); ?> #<?php echo $i + 1; ?></h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="text-center mb-3">
                                                <div class="mb-2">
                                                    <img src="<?php echo BASE_URL . htmlspecialchars($plan['icon'] ?? '/assets/img/icons/image_placeholder.png'); ?>"
                                                        class="border rounded" width="60"
                                                        id="plan-icon-preview-<?php echo $i; ?>">
                                                </div>
                                                <input type="hidden" name="plans[<?php echo $i; ?>][icon]"
                                                    id="plan-icon-path-<?php echo $i; ?>"
                                                    value="<?php echo htmlspecialchars($plan['icon'] ?? ''); ?>">
                                                <button type="button" class="btn btn-outline-secondary btn-xs"
                                                    onclick="openMediaBrowser('icon-<?php echo $i; ?>')"><?php echo __('Change Icon'); ?></button>
                                            </div>

                                            <div class="mb-3">
                                                <label class="small fw-bold"><?php echo __('Plan Name'); ?></label>
                                                <input type="text" name="plans[<?php echo $i; ?>][name]"
                                                    class="form-control form-control-sm"
                                                    value="<?php echo htmlspecialchars($plan['name'] ?? ''); ?>">
                                            </div>

                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold"><?php echo __('Price'); ?></label>
                                                    <input type="text" name="plans[<?php echo $i; ?>][price]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($plan['price'] ?? ''); ?>">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold"><?php echo __('Period'); ?></label>
                                                    <input type="text" name="plans[<?php echo $i; ?>][period]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($plan['period'] ?? ''); ?>"
                                                        placeholder="month">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <?php render_wysiwyg([
                                                    'id' => "plan_desc_{$i}",
                                                    'name' => "plans[{$i}][description]",
                                                    'value' => $plan['description'] ?? '',
                                                    'type' => 'paragraph',
                                                    'label' => __('Description')
                                                ]); ?>
                                            </div>

                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold"><?php echo __('Button Text'); ?></label>
                                                    <input type="text" name="plans[<?php echo $i; ?>][button_text]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($plan['button_text'] ?? ''); ?>">
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label class="small fw-bold"><?php echo __('Button URL'); ?></label>
                                                    <input type="text" name="plans[<?php echo $i; ?>][button_url]"
                                                        class="form-control form-control-sm"
                                                        value="<?php echo htmlspecialchars($plan['button_url'] ?? ''); ?>">
                                                </div>
                                            </div>

                                            <div class="border rounded p-2 mb-3 bg-light">
                                                <div class="custom-control custom-switch mb-2">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="popular-<?php echo $i; ?>"
                                                        name="plans[<?php echo $i; ?>][is_popular]" value="1" <?php echo !empty($plan['is_popular']) ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label small fw-bold"
                                                        for="popular-<?php echo $i; ?>"><?php echo __('Popular Tier'); ?></label>
                                                </div>
                                                <div class="mb-0">
                                                    <?php render_wysiwyg([
                                                        'id' => "plan_off_{$i}",
                                                        'name' => "plans[{$i}][off_text]",
                                                        'value' => $plan['off_text'] ?? '',
                                                        'type' => 'oneliner',
                                                        'label' => __('Off Label (Badge)')
                                                    ]); ?>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="small fw-bold mb-0"><?php echo __('Features'); ?></h6>
                                                <button type="button" class="btn btn-outline-primary btn-xs"
                                                    onclick="addFeature(<?php echo $i; ?>)">+
                                                    <?php echo __('Add'); ?></button>
                                            </div>
                                            <div id="features-container-<?php echo $i; ?>">
                                                <?php foreach (($plan['features'] ?? []) as $feature):
                                                    $fidx = $feature['id']; ?>
                                                    <div
                                                        class="feature-item border rounded p-2 mb-2 bg-light position-relative">
                                                        <button type="button"
                                                            class="btn btn-link btn-sm position-absolute p-0 text-danger"
                                                            style="top: 2px; right: 5px; z-index: 10;"
                                                            onclick="this.closest('.feature-item').remove()">
                                                            <i class="fas fa-times" style="pointer-events: none;"></i>
                                                        </button>
                                                        <div class="row g-1 align-items-center mt-1">
                                                            <div class="col-4">
                                                                <input type="text"
                                                                    name="plans[<?php echo $i; ?>][features][<?php echo $fidx; ?>][icon]"
                                                                    class="form-control form-control-sm"
                                                                    value="<?php echo htmlspecialchars($feature['icon'] ?? ''); ?>"
                                                                    placeholder="fa icon">
                                                            </div>
                                                            <div class="col">
                                                                <?php render_wysiwyg([
                                                                    'id' => "plan_{$i}_feat_{$fidx}",
                                                                    'name' => "plans[{$i}][features][{$fidx}][text]",
                                                                    'value' => $feature['text'] ?? '',
                                                                    'type' => 'oneliner'
                                                                ]); ?>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="feat-<?php echo $i; ?>-<?php echo $fidx; ?>"
                                                                        name="plans[<?php echo $i; ?>][features][<?php echo $fidx; ?>][active]"
                                                                        value="1" <?php echo !empty($feature['active']) ? 'checked' : ''; ?>>
                                                                    <label class="custom-control-label"
                                                                        for="feat-<?php echo $i; ?>-<?php echo $fidx; ?>"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
                    <h5 class="modal-title">Select Asset</h5>
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
                    const planIdx = activeIdx.split('-')[1];
                    document.getElementById('plan-icon-path-' + planIdx).value = path;
                    document.getElementById('plan-icon-preview-' + planIdx).src = CONFIG.BASE_URL + path;
                    $('#mediaModal').modal('hide');
                });
            }
        });

        function addFeature(planIdx) {
            const container = document.getElementById('features-container-' + planIdx);
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'feature-item border rounded p-2 mb-2 bg-light position-relative';
            div.innerHTML = `
                <button type="button" class="btn btn-link btn-sm position-absolute p-0 text-danger" style="top: 2px; right: 5px; z-index: 10;" onclick="this.closest('.feature-item').remove()">
                    <i class="fas fa-times" style="pointer-events: none;"></i>
                </button>
                <div class="row g-1 align-items-center mt-1">
                    <div class="col-4">
                        <input type="text" name="plans[${planIdx}][features][${idx}][icon]" class="form-control form-control-sm" placeholder="fa icon">
                    </div>
                    <div class="col">
                        <div class="wysiwyg-container mb-0" id="container_plan_${planIdx}_feat_${idx}">
                            <div class="wysiwyg-toolbar btn-group mb-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('plan_${planIdx}_feat_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('plan_${planIdx}_feat_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('plan_${planIdx}_feat_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                            </div>
                            <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                <div id="visual_plan_${planIdx}_feat_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 31px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('plan_${planIdx}_feat_${idx}', 'toSource')"></div>
                                <textarea id="source_plan_${planIdx}_feat_${idx}" name="plans[${planIdx}][features][${idx}][text]" class="wysiwyg-source form-control d-none" style="min-height: 31px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('plan_${planIdx}_feat_${idx}', 'toVisual')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="feat-${planIdx}-${idx}" name="plans[${planIdx}][features][${idx}][active]" value="1" checked>
                            <label class="custom-control-label" for="feat-${planIdx}-${idx}"></label>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</body>

</html>