<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();
$user = get_logged_in_user();

$current_page = 'clients';
$page_title = __('Clients Section');

// Modular data
$clients_data = db_get_by_id('clients', 1);
$clients_list = db_get_children('clients_logos', 'client_id', 1);
$clients_title = $clients_data['title'] ?? 'Trusted by World Leading Companies';
$anchor_id = $clients_data['anchor_id'] ?? 'clients';

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
                            <h1 class="m-0"><?php echo __('Clients Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="clientsForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="clientsForm" action="clients_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>

                        <?php
                        require_once __DIR__ . '/partials/wysiwyg_editor.php';
                        // Hardcoded anchor_id is now handled in handler, no input needed here
                        ?>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Section Configuration'); ?></h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <?php render_wysiwyg([
                                            'id' => 'clientsTitle',
                                            'name' => 'title',
                                            'value' => $clients_title,
                                            'type' => 'oneliner',
                                            'label' => 'Title'
                                        ]); ?>
                                        <p class="text-muted small mt-n2">Use
                                            the toolbar or <code>&lt;span&gt;txt&lt;/span&gt;</code> for blue highlight.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><?php echo __('Clients / Partners'); ?></h3>
                                <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="addClient()">
                                            <i class="fas fa-plus mr-1"></i> <?php echo __('Add One'); ?>
                                        </button>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="addMultiple(5)">+5</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="addMultiple(10)">+10</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-striped table-valign-middle">
                                    <thead>
                                        <tr>
                                            <th style="width: 150px;"><?php echo __('Preview'); ?></th>
                                            <th><?php echo __('Logo Path'); ?></th>
                                            <th style="width: 100px;"><?php echo __('Actions'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="clientsContainer">
                                        <?php foreach ($clients_list as $idx => $logoRow):
                                            $logo = is_array($logoRow) ? ($logoRow['logo_path'] ?? '') : $logoRow;
                                            $logo_path = (strpos($logo, '/') === false && !empty($logo)) ? "/assets/img/logos/$logo" : $logo;
                                            ?>
                                            <tr id="client-<?php echo $idx; ?>">
                                                <td class="text-center bg-white">
                                                    <img src="<?php echo BASE_URL . htmlspecialchars($logo_path ?: '/assets/img/placeholder.png'); ?>"
                                                        id="preview-<?php echo $idx; ?>" class="img-thumbnail"
                                                        style="height: 60px; width: 100px; object-fit: contain; background: #f9f9f9;">
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" name="logos[]" class="form-control"
                                                            value="<?php echo htmlspecialchars($logo); ?>"
                                                            id="img-<?php echo $idx; ?>"
                                                            placeholder="/assets/img/logos/...">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-primary"
                                                                onclick="browseMedia('img-<?php echo $idx; ?>', 'preview-<?php echo $idx; ?>')">
                                                                <i class="fas fa-image mr-1"></i> <?php echo __('Pick'); ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="this.closest('tr').remove()">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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
                    <h5 class="modal-title">Media Browser</h5>
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
        let activeInputId = null;
        let activePreviewId = null;

        function addClient() {
            const container = document.getElementById('clientsContainer');
            const idx = Date.now();
            const tr = document.createElement('tr');
            tr.id = 'client-' + idx;
            tr.innerHTML = `
                <td class="text-center bg-white">
                    <img src="<?php echo BASE_URL; ?>/assets/img/placeholder.png" id="preview-${idx}" 
                         class="img-thumbnail" style="height: 60px; width: 100px; object-fit: contain; background: #f9f9f9;">
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="logos[]" class="form-control" placeholder="/assets/img/logos/..." id="img-${idx}">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" onclick="browseMedia('img-${idx}', 'preview-${idx}')">
                                <i class="fas fa-image mr-1"></i> Pick
                            </button>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            container.appendChild(tr);
        }

        function addMultiple(count) {
            for (let i = 0; i < count; i++) {
                setTimeout(() => addClient(), i * 10);
            }
        }

        function browseMedia(inputId, previewId) {
            activeInputId = inputId;
            activePreviewId = previewId;
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initMediaBrowser === 'function') {
                initMediaBrowser((path) => {
                    const input = document.getElementById(activeInputId);
                    const preview = document.getElementById(activePreviewId);
                    if (input) input.value = path;
                    if (preview) preview.src = CONFIG.BASE_URL + path;
                    $('#mediaModal').modal('hide');
                });
            }
        });
    </script>
</body>

</html>