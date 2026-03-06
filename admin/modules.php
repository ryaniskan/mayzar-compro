<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'modules';
$page_title = __('Module Manager');

$modules = db_get_all('modules');
// Map module_id to id for template compatibility
foreach ($modules as &$m) {
    $m['id'] = $m['module_id'];
}
unset($m);
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
                            <h1 class="m-0"><?php echo __('Module Manager'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="modulesForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Layout'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title"><?php echo __('Homepage Section Order & Visibility'); ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info alert-dismissible shadow-sm">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-info"></i> <?php echo __('Reordering'); ?></h5>
                                <?php echo __('Drag and drop the handles to reorder sections. Use the toggles to show or hide modules on the homepage.'); ?>
                            </div>

                            <form id="modulesForm" action="modules_handler" method="POST">
                                <?php render_csrf_input(); ?>
                                <div id="moduleList" class="list-group list-group-flush border rounded overflow-hidden shadow-sm">
                                    <?php foreach ($modules as $idx => $module): ?>
                                        <div class="list-group-item d-flex align-items-center py-3 bg-white module-row" data-id="<?php echo $module['id']; ?>">
                                            <div class="handle mr-3 text-muted cursor-move" style="cursor: move; font-size: 1.2rem;">
                                                <i class="fas fa-grip-vertical"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0 font-weight-bold"><?php echo htmlspecialchars($module['name']); ?></h6>
                                                <small class="text-muted"><?php echo __('Section ID'); ?>: <?php echo htmlspecialchars($module['id']); ?></small>
                                            </div>
                                            <div class="custom-control custom-switch">
                                                <input type="hidden" name="modules[<?php echo $idx; ?>][id]" value="<?php echo $module['id']; ?>">
                                                <input type="hidden" name="modules[<?php echo $idx; ?>][name]" value="<?php echo htmlspecialchars($module['name']); ?>">
                                                <input type="checkbox" class="custom-control-input" id="switch-<?php echo $module['id']; ?>"
                                                    name="modules[<?php echo $idx; ?>][visible]" value="1"
                                                    <?php echo !empty($module['visible']) ? 'checked' : ''; ?>>
                                                <label class="custom-control-label cursor-pointer" for="switch-<?php echo $module['id']; ?>"></label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" form="modulesForm" class="btn btn-primary btn-lg px-5 shadow-sm">
                                <i class="fas fa-check-circle mr-2"></i> <?php echo __('Update Module Configuration'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <!-- SortableJS included via CDN as in original but let's see if we have it in scripts.php or assets -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('moduleList');
        if (el) {
            Sortable.create(el, {
                handle: '.handle',
                animation: 150,
                ghostClass: 'bg-light',
                onEnd: function() {
                    updateInputNames();
                }
            });
        }

        function updateInputNames() {
            const items = el.querySelectorAll('.module-row');
            items.forEach((item, index) => {
                const inputs = item.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        input.setAttribute('name', name.replace(/modules\[\d+\]/, 'modules[' + index + ']'));
                    }
                });
            });
        }
    });
    </script>
</body>

</html>
