<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'download';
$page_title = __('Download Section');

$download = db_get_by_id('download', 1) ?: [];
$download['buttons'] = db_get_children('download_buttons', 'download_id', 1);
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
                            <h1 class="m-0"><?php echo __('Download Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="downloadForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="downloadForm" action="download_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Content'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'dlTitle',
                                            'name' => 'title',
                                            'label' => __('Section Title'),
                                            'value' => $download['title'] ?? '',
                                            'type' => 'oneliner',
                                            'helper' => __('Use &lt;span&gt;txt&lt;/span&gt; for blue highlight.')
                                        ]); ?>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'dlDesc',
                                            'name' => 'description',
                                            'label' => __('Description'),
                                            'value' => $download['description'] ?? '',
                                            'type' => 'oneliner'
                                        ]); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Download Buttons'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php for ($i = 0; $i < 2; $i++):
                                        $btn = $download['buttons'][$i] ?? [];
                                        ?>
                                        <div class="col-md-6">
                                            <div class="btn-config border rounded p-3 bg-light mb-3">
                                                <h6 class="fw-bold mb-3 border-bottom pb-2"><?php echo __('Button'); ?>
                                                    #<?php echo $i + 1; ?>
                                                </h6>
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label small fw-bold"><?php echo __('Button Icon'); ?></label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text bg-white"><i
                                                                    class="<?php echo htmlspecialchars($btn['icon'] ?? 'bi bi-download'); ?>"></i></span>
                                                        </div>
                                                        <input type="text" name="buttons[<?php echo $i; ?>][icon]"
                                                            class="form-control"
                                                            value="<?php echo htmlspecialchars($btn['icon'] ?? 'bi bi-download'); ?>"
                                                            readonly>
                                                        <div class="input-group-append">
                                                            <button class="btn btn-outline-primary" type="button"
                                                                onclick="pickIcon(this)"><?php echo __('Pick'); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label small fw-bold"><?php echo __('Button Text'); ?></label>
                                                    <input type="text" name="buttons[<?php echo $i; ?>][text]"
                                                        class="form-control"
                                                        value="<?php echo htmlspecialchars($btn['text'] ?? ''); ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label
                                                        class="form-label small fw-bold"><?php echo __('Download URL'); ?></label>
                                                    <input type="text" name="buttons[<?php echo $i; ?>][url]"
                                                        class="form-control"
                                                        value="<?php echo htmlspecialchars($btn['url'] ?? ''); ?>">
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" name="primary_btn"
                                                        value="<?php echo $i; ?>" id="primary-<?php echo $i; ?>" <?php echo (!empty($btn['is_primary']) || ($i === 0 && empty(array_filter($download['buttons'] ?? [], fn($b) => !empty($b['is_primary']))))) ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label small fw-bold"
                                                        for="primary-<?php echo $i; ?>">
                                                        <?php echo __('Primary Style (Filled Background)'); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <div class="modal fade" id="iconModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><?php echo __('Pick Icon'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
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
                        group.querySelector('input').value = 'bi ' + icon;
                        $('#iconModal').modal('hide');
                    }
                });
            }
        });
    </script>
</body>

</html>