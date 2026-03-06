<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'themes';
$page_title = __('Themes Section');

$settings = db_get_flat('settings');
$themes = db_get_by_id('themes', 1) ?: [];
$themes['bullets'] = array_column(db_get_children('themes_bullets', 'theme_id', 1), 'text');
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
                            <h1 class="m-0"><?php echo __('Themes / Promotional Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="themesForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="themesForm" action="themes_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php require_once __DIR__ . '/partials/wysiwyg_editor.php'; ?>

                        <div class="row">
                            <div class="col-lg-7">
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Content Settings'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'themeTagline',
                                                'name' => 'tagline',
                                                'value' => $themes['tagline'] ?? '',
                                                'type' => 'oneliner',
                                                'label' => __('Tagline')
                                            ]); ?>
                                        </div>
                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'themeTitle',
                                                'name' => 'title',
                                                'value' => $themes['title'] ?? '',
                                                'type' => 'oneliner',
                                                'label' => __('Title')
                                            ]); ?>
                                            <p class="text-muted small mt-n2">
                                                <?php echo __('Use the toolbar or <code>&lt;span&gt;txt&lt;/span&gt;</code> for highlight.'); ?>
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'themeDesc',
                                                'name' => 'description',
                                                'value' => $themes['description'] ?? '',
                                                'type' => 'paragraph',
                                                'label' => __('Description')
                                            ]); ?>
                                        </div>

                                        <hr class="my-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-primary font-weight-bold mb-0 small uppercase">
                                                <?php echo __('Bullet Points'); ?>
                                            </h6>
                                            <button type="button" class="btn btn-outline-info btn-xs rounded-pill"
                                                onclick="addBullet()">
                                                <i class="fas fa-plus mr-1"></i> <?php echo __('Add Bullet'); ?>
                                            </button>
                                        </div>
                                        <div id="bulletContainer">
                                            <?php foreach (($themes['bullets'] ?? []) as $idx => $bullet): ?>
                                                <div class="mb-3 position-relative bullet-item"
                                                    id="bullet-<?php echo $idx; ?>">
                                                    <div class="d-flex align-items-start">
                                                        <div class="flex-grow-1 mr-2">
                                                            <?php render_wysiwyg([
                                                                'id' => "bullet_wysiwyg_{$idx}",
                                                                'name' => "bullets[]",
                                                                'value' => $bullet,
                                                                'type' => 'oneliner'
                                                            ]); ?>
                                                        </div>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            style="z-index: 10;"
                                                            onclick="this.closest('.bullet-item').remove()">
                                                            <i class="fas fa-times" style="pointer-events: none;"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="card card-info card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Assets & Actions'); ?></h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <h6 class="text-left font-weight-bold small uppercase">
                                            <?php echo __('Main Image'); ?></h6>
                                        <div class="mb-3 border rounded p-2 bg-light d-flex align-items-center justify-content-center"
                                            style="height: 250px;">
                                            <img id="imgPreview"
                                                src="<?php echo BASE_URL . htmlspecialchars($themes['main_image'] ?? ''); ?>"
                                                style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        </div>
                                        <input type="hidden" name="main_image" id="imgPath"
                                            value="<?php echo htmlspecialchars($themes['main_image'] ?? ''); ?>">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-block mb-4"
                                            onclick="openMediaBrowser()">
                                            <i class="fas fa-image mr-1"></i> <?php echo __('Change Image'); ?>
                                        </button>

                                        <hr>
                                        <h6 class="text-left font-weight-bold small uppercase mb-3">
                                            <?php echo __('Button Style'); ?></h6>
                                        <div class="mb-3 text-left">
                                            <label class="small fw-bold"><?php echo __('Button Text'); ?></label>
                                            <input type="text" name="btn_text" class="form-control form-control-sm"
                                                value="<?php echo htmlspecialchars($themes['btn_text'] ?? 'Discovery Now'); ?>">
                                        </div>
                                        <div class="mb-3 text-left">
                                            <label class="small fw-bold"><?php echo __('Button URL'); ?></label>
                                            <input type="text" name="btn_url" class="form-control form-control-sm"
                                                value="<?php echo htmlspecialchars($themes['btn_url'] ?? '#'); ?>">
                                        </div>
                                        <div class="mb-0 text-left">
                                            <label class="small fw-bold"><?php echo __('Button Color'); ?></label>
                                            <div class="d-flex align-items-center">
                                                <input type="color" name="btn_color"
                                                    class="form-control form-control-color w-25 mr-3"
                                                    value="<?php echo htmlspecialchars($themes['btn_color'] ?? '#5842bc'); ?>">
                                                <span
                                                    class="text-muted small"><?php echo __('Brand accent color'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-block shadow-sm">
                                            <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                                        </button>
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

    <!-- Media Modal -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold"><?php echo __('Select Asset'); ?></h5>
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
        function openMediaBrowser() {
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            initMediaBrowser((path) => {
                document.getElementById('imgPath').value = path;
                document.getElementById('imgPreview').src = CONFIG.BASE_URL + path;
                $('#mediaModal').modal('hide');
            });
        });

        function addBullet() {
            const container = document.getElementById('bulletContainer');
            const idx = Date.now();
            const div = document.createElement('div');
            div.className = 'mb-3 position-relative bullet-item';
            div.id = 'bullet-' + idx;
            div.innerHTML = `
                <div class="d-flex align-items-start">
                    <div class="flex-grow-1 mr-2">
                        <div class="wysiwyg-container mb-0" id="container_bullet_${idx}">
                            <div class="wysiwyg-toolbar btn-group mb-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygExec('bullet_${idx}', 'bold')" title="Bold"><i class="fas fa-bold"></i></button>
                                <button type="button" class="btn btn-xs btn-outline-secondary" onclick="wysiwygApplyClass('bullet_${idx}', 'editor-span')" title="Span Highlight"><span>&lt;span&gt;</span></button>
                                <button type="button" class="btn btn-xs btn-outline-primary" onclick="wysiwygApplyClass('bullet_${idx}', 'color-blue4')" title="Blue Text"><span class="text-primary text-xs">B</span></button>
                                <button type="button" class="btn btn-xs btn-outline-info ml-1" onclick="wysiwygToggleSource('bullet_${idx}')" title="Source"><i class="fas fa-code"></i></button>
                            </div>
                            <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
                                <div id="visual_bullet_${idx}" class="wysiwyg-visual p-1" contenteditable="true" style="min-height: 38px; height: auto; font-size: 0.875rem;" oninput="wysiwygSync('bullet_${idx}', 'toSource')"></div>
                                <textarea id="source_bullet_${idx}" name="bullets[]" class="wysiwyg-source form-control d-none" style="min-height: 38px; height: auto; border: none; border-radius: 0; font-size: 0.875rem;" oninput="wysiwygSync('bullet_${idx}', 'toVisual')"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" style="z-index: 10;" onclick="this.closest('.bullet-item').remove()">
                        <i class="fas fa-times" style="pointer-events: none;"></i>
                    </button>
                </div>
            `;
            container.appendChild(div);
        }

    </script>
</body>

</html>