<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'faq';
$page_title = __('FAQ Section');

$faq = db_get_by_id('faq', 1) ?: [];
$faq['list'] = db_get_children('faq_list', 'faq_id', 1);
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
                            <h1 class="m-0"><?php echo __('FAQ Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="faqForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="faqForm" action="faq_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Section Header'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'faqTagline',
                                            'name' => 'tagline',
                                            'value' => $faq['tagline'] ?? '',
                                            'type' => 'oneliner',
                                            'label' => __('Tagline')
                                        ]); ?>
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'faqTitle',
                                            'name' => 'title',
                                            'value' => $faq['title'] ?? '',
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
                                <h3 class="card-title"><?php echo __('Questions List'); ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                                        <i class="fas fa-plus"></i> <?php echo __('Add Question'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="itemsContainer">
                                    <?php foreach (($faq['list'] ?? []) as $idx => $item): ?>
                                        <div class="faq-item border rounded p-3 mb-3 bg-light position-relative"
                                            id="item-<?php echo $idx; ?>">
                                            <button type="button" class="btn btn-tool text-danger position-absolute"
                                                style="top: 10px; right: 10px; z-index: 10;"
                                                onclick="this.closest('.faq-item').remove()">
                                                <i class="fas fa-trash-alt" style="pointer-events: none;"></i>
                                            </button>
                                            <div class="mb-3">
                                                <?php render_wysiwyg([
                                                    'id' => "faq_q_{$idx}",
                                                    'name' => "list[{$idx}][question]",
                                                    'value' => $item['question'] ?? '',
                                                    'type' => 'oneliner',
                                                    'label' => __('Question')
                                                ]); ?>
                                            </div>
                                            <div>
                                                <?php render_wysiwyg([
                                                    'id' => "faq_a_{$idx}",
                                                    'name' => "list[{$idx}][answer]",
                                                    'value' => $item['answer'] ?? '',
                                                    'type' => 'paragraph',
                                                    'label' => __('Answer')
                                                ]); ?>
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

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <script>
        function addItem() {
            const container = document.getElementById('itemsContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'faq-item border rounded p-3 mb-3 bg-light position-relative';
            div.innerHTML = `
                <button type="button" class="btn btn-tool text-danger position-absolute" style="top: 10px; right: 10px; z-index: 10;" onclick="this.closest('.faq-item').remove()">
                    <i class="fas fa-trash-alt" style="pointer-events: none;"></i>
                </button>
                <div class="mb-3">
                    <div class="wysiwyg-container mb-0" id="container_faq_q_${idx}">
                        <label class="small fw-bold mb-1">Question</label>
                        <div class="wysiwyg-toolbar btn-group mb-1">
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('faq_q_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('faq_q_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                            <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('faq_q_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                        </div>
                        <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                            <div id="visual_faq_q_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 31px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('faq_q_${idx}', 'toSource')"></div>
                            <textarea id="source_faq_q_${idx}" name="list[${idx}][question]" class="wysiwyg-source form-control d-none" style="min-height: 31px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('faq_q_${idx}', 'toVisual')"></textarea>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="wysiwyg-container mb-0" id="container_faq_a_${idx}">
                        <label class="small fw-bold mb-1">Answer</label>
                        <div class="wysiwyg-toolbar btn-group mb-1">
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('faq_a_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('faq_a_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                            <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('faq_a_${idx}', 'insertHTML', '&lt;br&gt;')" title="New Line">New Line</button>
                            <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('faq_a_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                        </div>
                        <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                            <div id="visual_faq_a_${idx}" class="wysiwyg-visual p-2" contenteditable="true" style="min-height: 80px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('faq_a_${idx}', 'toSource')"></div>
                            <textarea id="source_faq_a_${idx}" name="list[${idx}][answer]" class="wysiwyg-source form-control d-none" style="min-height: 80px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('faq_a_${idx}', 'toVisual')"></textarea>
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        }
    </script>
</body>

</html>