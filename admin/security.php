<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'security';
$page_title = __('Security Section');

$sec = db_get_by_id('security', 1) ?: [];
$sec['items'] = db_get_children('security_items', 'security_id', 1);
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
                            <h1 class="m-0"><?php echo __('Security Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="secForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="secForm" action="security_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>

                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Main Content'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <?php render_wysiwyg([
                                                    'id' => 'secTagline',
                                                    'name' => 'tagline',
                                                    'value' => $sec['tagline'] ?? '',
                                                    'type' => 'oneliner',
                                                    'label' => __('Tagline')
                                                ]); ?>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <?php render_wysiwyg([
                                                    'id' => 'secTitle',
                                                    'name' => 'title',
                                                    'value' => $sec['title'] ?? '',
                                                    'type' => 'oneliner',
                                                    'label' => __('Title')
                                                ]); ?>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="small fw-bold"><?php echo __('Description'); ?></label>
                                                <textarea name="description" class="form-control"
                                                    rows="4"><?php echo htmlspecialchars($sec['description'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Benefits / Features (Accordion)'); ?></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-primary btn-sm" onclick="addItem()">
                                                <i class="fas fa-plus"></i> <?php echo __('Add Item'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="itemsContainer">
                                            <?php foreach (($sec['items'] ?? []) as $idx => $item): ?>
                                                <div class="sec-item border rounded p-3 mb-3 bg-light position-relative"
                                                    id="item-<?php echo $idx; ?>">
                                                    <button type="button" class="btn btn-tool text-danger position-absolute"
                                                        style="top: 10px; right: 10px; z-index: 10;"
                                                        onclick="this.closest('.sec-item').remove()">
                                                        <i class="fas fa-trash-alt" style="pointer-events: none;"></i>
                                                    </button>
                                                    <div class="mb-3">
                                                        <label class="small fw-bold"><?php echo __('Item Title'); ?></label>
                                                        <input type="text" name="items[<?php echo $idx; ?>][title]"
                                                            class="form-control"
                                                            value="<?php echo htmlspecialchars($item['title'] ?? ''); ?>">
                                                    </div>
                                                    <div>
                                                        <label
                                                            class="small fw-bold"><?php echo __('Item Content'); ?></label>
                                                        <textarea name="items[<?php echo $idx; ?>][content]"
                                                            class="form-control"
                                                            rows="2"><?php echo htmlspecialchars($item['content'] ?? ''); ?></textarea>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Call to Action Button'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="small fw-bold"><?php echo __('Show Button'); ?></label>
                                            <select name="show_btn" class="form-control">
                                                <option value="1" <?php echo ($sec['show_btn'] ?? '1') == '1' ? 'selected' : ''; ?>><?php echo __('Yes'); ?></option>
                                                <option value="0" <?php echo ($sec['show_btn'] ?? '1') == '0' ? 'selected' : ''; ?>><?php echo __('No'); ?></option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small fw-bold"><?php echo __('Button Small Text'); ?></label>
                                            <input type="text" name="btn_small" class="form-control"
                                                value="<?php echo htmlspecialchars($sec['btn_small'] ?? 'Available in the'); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="small fw-bold"><?php echo __('Button Label'); ?></label>
                                            <input type="text" name="btn_label" class="form-control"
                                                value="<?php echo htmlspecialchars($sec['btn_label'] ?? 'Chrome Web Store'); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="small fw-bold"><?php echo __('Button URL'); ?></label>
                                            <input type="text" name="btn_url" class="form-control"
                                                value="<?php echo htmlspecialchars($sec['btn_url'] ?? ''); ?>">
                                        </div>
                                        <div class="mb-3">
                                            <label class="small fw-bold"><?php echo __('Button Icon Image'); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="btn_icon" id="btn_icon" class="form-control"
                                                    value="<?php echo htmlspecialchars($sec['btn_icon'] ?? 'chrome_icon.png'); ?>">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        onclick="openMediaBrowser()"><?php echo __('Browse'); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card card-secondary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Advanced'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="small fw-bold">Anchor ID</label>
                                            <input type="text" name="anchor_id" class="form-control"
                                                value="<?php echo htmlspecialchars($sec['anchor_id'] ?? 'security'); ?>">
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

    <!-- Media Browser Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo __('Select Icon Image'); ?></h5>
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
        function addItem() {
            const container = document.getElementById('itemsContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'sec-item border rounded p-3 mb-3 bg-light position-relative';
            div.innerHTML = `
                <button type="button" class="btn btn-tool text-danger position-absolute" style="top: 10px; right: 10px; z-index: 10;" onclick="this.closest('.sec-item').remove()">
                    <i class="fas fa-trash-alt" style="pointer-events: none;"></i>
                </button>
                <div class="mb-3">
                    <label class="small fw-bold">Item Title</label>
                    <input type="text" name="items[${idx}][title]" class="form-control" placeholder="E.g. Safe and Secure">
                </div>
                <div>
                    <label class="small fw-bold">Item Content</label>
                    <textarea name="items[${idx}][content]" class="form-control" rows="2"></textarea>
                </div>
            `;
            container.appendChild(div);
        }

        function openMediaBrowser() {
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initMediaBrowser === 'function') {
                initMediaBrowser((path) => {
                    document.getElementById('btn_icon').value = path;
                    $('#mediaModal').modal('hide');
                });
            }
        });
    </script>
</body>

</html>