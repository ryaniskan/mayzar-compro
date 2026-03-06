<?php
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/auth_check.php';
require_once __DIR__ . '/flash_helper.php';
require_once __DIR__ . '/validation_helper.php';
check_auth();

$current_page = 'hero';
$page_title = __('Hero Section');

$settings = db_get_flat('settings');
$hero = db_get_by_id('hero', 1);
$hero['features'] = db_get_children('hero_features', 'hero_id', 1);
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
                            <h1 class="m-0"><?php echo __('Hero Section'); ?></h1>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button type="submit" form="heroForm" class="btn btn-primary px-4 shadow-sm">
                                <i class="fas fa-save mr-2"></i> <?php echo __('Save Changes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <?php display_flash(); ?>

                    <form id="heroForm" action="hero_handler" method="POST" onsubmit="wysiwygSyncAll()">
                        <?php render_csrf_input(); ?>
                        <?php
                        require_once __DIR__ . '/partials/wysiwyg_editor.php';
                        // Hardcoded anchor_id is now handled in handler, no input needed here
                        ?>

                        <div class="row">
                            <div class="col-lg-7">
                                <!-- Main Content Card -->
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Main Content'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'heroTitle',
                                                'name' => 'title',
                                                'value' => $hero['title'] ?? '',
                                                'type' => 'oneliner',
                                                'label' => __('Title')
                                            ]); ?>
                                            <p class="text-muted small mt-n2">
                                                <?php echo __('Use the toolbar or <span>txt</span> for blue highlight.'); ?>
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'heroTagline',
                                                'name' => 'tagline',
                                                'value' => $hero['tagline'] ?? '',
                                                'type' => 'oneliner',
                                                'label' => __('Slogan (Upper Tagline)')
                                            ]); ?>
                                        </div>

                                        <div class="mb-3">
                                            <?php render_wysiwyg([
                                                'id' => 'heroDescription',
                                                'name' => 'description',
                                                'value' => $hero['description'] ?? '',
                                                'type' => 'paragraph',
                                                'label' => __('Subtitle / Description')
                                            ]); ?>
                                        </div>

                                        <hr>
                                        <h5 class="fw-bold mb-3 small"><?php echo __('Buttons'); ?></h5>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="small fw-bold"><?php echo __('Primary Button Text'); ?></label>
                                                <input type="text" name="button_text" class="form-control"
                                                    value="<?php echo htmlspecialchars($hero['button_text'] ?? 'Download App'); ?>">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="small fw-bold"><?php echo __('Primary Button Icon'); ?></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i
                                                                class="bi <?php echo htmlspecialchars($hero['button_icon'] ?? 'bi-apple'); ?>"></i></span>
                                                    </div>
                                                    <input type="hidden" name="button_icon"
                                                        value="<?php echo htmlspecialchars($hero['button_icon'] ?? 'bi-apple'); ?>">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            onclick="pickIcon(this)">Pick</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="small fw-bold"><?php echo __('Primary Button URL'); ?></label>
                                                <input type="text" name="app_store_url" class="form-control"
                                                    value="<?php echo htmlspecialchars($hero['app_store_url'] ?? ''); ?>">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="small fw-bold"><?php echo __('Promotion Video URL (Youtube)'); ?></label>
                                                <input type="text" name="video_url" class="form-control"
                                                    value="<?php echo htmlspecialchars($hero['video_url'] ?? ''); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Features Card -->
                                <div class="card card-indigo card-outline bg-indigo text-white shadow">
                                    <div class="card-header border-bottom-0">
                                        <h3 class="card-title"><?php echo __('Feature Highlights'); ?></h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-light btn-xs" onclick="addFeature()">
                                                <i class="fas fa-plus"></i> <?php echo __('Add New'); ?>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="featureList">
                                            <?php if (!empty($hero['features'])): ?>
                                                <?php foreach ($hero['features'] as $idx => $feat): ?>
                                                    <div class="feature-item p-3 mb-3 border rounded bg-white text-dark position-relative"
                                                        id="feat-<?php echo $idx; ?>">
                                                        <button type="button" class="btn btn-danger btn-xs position-absolute"
                                                            style="top: -10px; right: -10px;"
                                                            onclick="removeFeature('feat-<?php echo $idx; ?>')">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                        <div class="row align-items-end">
                                                            <div class="col-md-4">
                                                                <label class="small fw-bold"><?php echo __('Icon'); ?></label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text bg-white"><i
                                                                                class="bi <?php echo (strpos($feat['icon'], 'fa') !== false) ? 'bi-star' : $feat['icon']; ?>"></i></span>
                                                                    </div>
                                                                    <input type="hidden" name="feature_icons[]"
                                                                        value="<?php echo htmlspecialchars($feat['icon'] ?? ''); ?>">
                                                                    <div class="input-group-append">
                                                                        <button type="button"
                                                                            class="btn btn-outline-secondary btn-xs"
                                                                            onclick="pickIcon(this)"><?php echo __('Pick'); ?></button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-8">
                                                                <label class="small fw-bold"><?php echo __('Label'); ?></label>
                                                                <input type="text" name="feature_texts[]"
                                                                    class="form-control form-control-sm"
                                                                    value="<?php echo htmlspecialchars($feat['text'] ?? ''); ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <!-- Image Card -->
                                <div class="card card-primary card-outline">
                                    <div class="card-header">
                                        <h3 class="card-title"><?php echo __('Hero Drawing / Illustration'); ?></h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 text-center p-3 border rounded bg-light"
                                            style="min-height: 200px;">
                                            <img id="heroPreview"
                                                src="<?php echo BASE_URL . htmlspecialchars($hero['main_image'] ?? '/assets/img/header/header_4.png'); ?>"
                                                style="max-width: 100%; max-height: 400px; object-fit: contain;">
                                        </div>
                                        <input type="hidden" name="main_image" id="heroImagePath"
                                            value="<?php echo htmlspecialchars($hero['main_image'] ?? '/assets/img/header/header_4.png'); ?>">

                                        <button type="button" class="btn btn-outline-primary btn-block"
                                            onclick="openMediaBrowser()">
                                            <i class="fas fa-images mr-2"></i> <?php echo __('Change Illustration'); ?>
                                        </button>
                                    </div>
                                </div>

                                <div class="card shadow-sm">
                                    <div class="card-body text-center py-4">
                                        <p class="text-muted small mb-4"><?php echo __('Anda telah mengubah bagian hero. Klik simpan untuk menerbitkan perubahan.'); ?></p>
                                        <button type="submit" form="heroForm"
                                            class="btn btn-primary btn-lg btn-block shadow-sm">
                                            <i class="fas fa-check-circle mr-2"></i> Save Changes
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

    <!-- Modals -->
    <div class="modal fade" id="mediaModal" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo __('Select Hero Image'); ?></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php include __DIR__ . '/partials/media_browser.php'; ?>
                </div>
            </div>
        </div>
    </div>

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

    <?php include __DIR__ . '/partials/scripts.php'; ?>
    <script>
        let activeIconTrigger = null;

        function addFeature() {
            const list = document.getElementById('featureList');
            const id = 'feat-' + Date.now();
            const div = document.createElement('div');
            div.className = 'feature-item p-3 mb-3 border rounded bg-white text-dark position-relative';
            div.id = id;
            div.innerHTML = `
                <button type="button" class="btn btn-danger btn-xs position-absolute" style="top: -10px; right: -10px;" onclick="removeFeature('\${id}')">
                    <i class="fas fa-times"></i>
                </button>
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="small fw-bold">Icon</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white"><i class="bi bi-star"></i></span>
                            </div>
                            <input type="hidden" name="feature_icons[]" value="bi-star">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary btn-xs" onclick="pickIcon(this)">Pick</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label class="small fw-bold">Label</label>
                        <input type="text" name="feature_texts[]" class="form-control form-control-sm" placeholder="Feature name">
                    </div>
                </div>
            `;
            list.appendChild(div);
        }

        function removeFeature(id) {
            document.getElementById(id).remove();
        }

        function pickIcon(btn) {
            activeIconTrigger = btn;
            $('#iconModal').modal('show');
        }

        function openMediaBrowser() {
            $('#mediaModal').modal('show');
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof initMediaBrowser === 'function') {
                initMediaBrowser((path) => {
                    document.getElementById('heroImagePath').value = path;
                    document.getElementById('heroPreview').src = CONFIG.BASE_URL + path;
                    $('#mediaModal').modal('hide');
                });
            }

            if (typeof initIconPicker === 'function') {
                initIconPicker((icon) => {
                    const group = activeIconTrigger.closest('.input-group');
                    group.querySelector('i').className = 'bi ' + icon;
                    group.querySelector('input').value = icon;
                    $('#iconModal').modal('hide');
                });
            }
        });
    </script>
</body>

</html>