<?php
/**
 * WYSIWYG Editor Partial
 * 
 * Usage:
 * include 'partials/wysiwyg_editor.php';
 * render_wysiwyg([
 *     'id' => 'editor_id',
 *     'name' => 'field_name',
 *     'value' => $value,
 *     'type' => 'paragraph', // or 'oneliner'
 *     'label' => 'Field Label'
 * ]);
 */

function render_wysiwyg($options)
{
    $id = $options['id'] ?? 'wysiwyg_' . uniqid();
    $name = $options['name'] ?? 'content';
    $value = trim($options['value'] ?? '');
    $type = $options['type'] ?? 'paragraph';
    $label = $options['label'] ?? '';
    $height = ($type === 'oneliner') ? 'auto' : '200px';
    $min_height = ($type === 'oneliner') ? '40px' : '150px';
    ?>
    <div class="wysiwyg-container mb-3" id="container_<?php echo $id; ?>">
        <?php if ($label): ?>
            <label>
                <?php echo htmlspecialchars($label); ?>
            </label>
        <?php endif; ?>

        <div class="wysiwyg-toolbar btn-group mb-1">
            <button type="button" class="btn btn-sm btn-outline-secondary"
                onclick="wysiwygExec('<?php echo $id; ?>', 'bold')" title="<?php echo __('Bold'); ?>">
                <i class="fas fa-bold"></i>
            </button>
            <?php if ($type === 'paragraph'): ?>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="wysiwygInsertBR('<?php echo $id; ?>')"
                    title="<?php echo __('New Line'); ?>">
                    <i class="fas fa-level-down-alt"></i>
                </button>
            <?php endif; ?>
            <button type="button" class="btn btn-sm btn-outline-secondary"
                onclick="wysiwygApplyClass('<?php echo $id; ?>', 'editor-span')"
                title="<?php echo __('Span Highlight'); ?>">
                <span>&lt;span&gt;</span>
            </button>
            <button type="button" class="btn btn-sm btn-outline-primary"
                onclick="wysiwygApplyClass('<?php echo $id; ?>', 'color-blue4')" title="<?php echo __('Blue Text'); ?>">
                <span class="text-primary"><?php echo __('Blue Text'); ?></span>
            </button>
            <button type="button" class="btn btn-sm btn-outline-info ml-2"
                onclick="wysiwygToggleSource('<?php echo $id; ?>')" title="<?php echo __('Toggle Source'); ?>">
                <i class="fas fa-code"></i> <?php echo __('Source'); ?>
            </button>
        </div>

        <div class="wysiwyg-editor-wrapper border rounded" style="background: #fff;">
            <div id="visual_<?php echo $id; ?>" class="wysiwyg-visual p-2" contenteditable="true"
                style="min-height: <?php echo $min_height; ?>; height: <?php echo $height; ?>; overflow-y: auto;"
                oninput="wysiwygSync('<?php echo $id; ?>', 'toSource')"><?php echo $value; ?></div>

            <textarea id="source_<?php echo $id; ?>" name="<?php echo $name; ?>" class="wysiwyg-source form-control d-none"
                style="min-height: <?php echo $min_height; ?>; height: <?php echo $height; ?>; border: none; border-radius: 0;"
                oninput="wysiwygSync('<?php echo $id; ?>', 'toVisual')"><?php echo htmlspecialchars($value); ?></textarea>
        </div>
    </div>

    <?php if (!defined('WYSIWYG_JS_LOADED')):
        define('WYSIWYG_JS_LOADED', true); ?>
        <script>
            function wysiwygExec(id, command, value = null) {
                document.execCommand(command, false, value);
                wysiwygSync(id, 'toSource');
                document.getElementById('visual_' + id).focus();
            }

            function wysiwygInsertBR(id) {
                const selection = window.getSelection();
                if (selection.rangeCount > 0) {
                    const range = selection.getRangeAt(0);
                    range.deleteContents();
                    const br = document.createElement('br');
                    range.insertNode(br);
                    range.setStartAfter(br);
                    range.setEndAfter(br);
                    selection.removeAllRanges();
                    selection.addRange(range);
                }
                wysiwygSync(id, 'toSource');
            }

            function wysiwygApplyClass(id, className) {
                const selection = window.getSelection();
                if (!selection.isCollapsed) {
                    const selectedText = selection.toString();
                    const html = `<span class="${className}">${selectedText}</span>`;
                    document.execCommand('insertHTML', false, html);
                }
                wysiwygSync(id, 'toSource');
            }

            function wysiwygToggleSource(id) {
                const visual = document.getElementById('visual_' + id);
                const source = document.getElementById('source_' + id);

                if (visual.classList.contains('d-none')) {
                    visual.classList.remove('d-none');
                    source.classList.add('d-none');
                } else {
                    visual.classList.add('d-none');
                    source.classList.remove('d-none');
                }
            }

            function wysiwygSync(id, direction) {
                const visual = document.getElementById('visual_' + id);
                const source = document.getElementById('source_' + id);

                if (direction === 'toSource') {
                    source.value = visual.innerHTML;
                } else {
                    visual.innerHTML = source.value;
                }
            }

            function wysiwygSyncAll() {
                document.querySelectorAll('.wysiwyg-visual').forEach(visual => {
                    const id = visual.id.replace('visual_', '');
                    wysiwygSync(id, 'toSource');
                });
            }

            // Clean on paste and sync
            document.addEventListener('paste', function (e) {
                if (e.target.classList.contains('wysiwyg-visual')) {
                    e.preventDefault();
                    const text = e.clipboardData.getData('text/plain');
                    document.execCommand('insertText', false, text);

                    const id = e.target.id.replace('visual_', '');
                    wysiwygSync(id, 'toSource');
                }
            });

            // Ensure newline handled correctly in contenteditable
            document.addEventListener('keydown', function (e) {
                if (e.target.classList.contains('wysiwyg-visual') && e.key === 'Enter') {
                    const id = e.target.id.replace('visual_', '');
                    const container = e.target.closest('.wysiwyg-container');
                    const visual = container.querySelector('.wysiwyg-visual');
                    const isOneLiner = visual.style.height === 'auto' || visual.classList.contains('oneliner');

                    if (isOneLiner) {
                        e.preventDefault();
                    }
                }
            });
        </script>
        <style>
            .wysiwyg-visual:focus {
                outline: none;
            }

            /* Highlight all spans in editor to show they are special */
            .wysiwyg-visual span,
            .wysiwyg-visual .editor-span,
            .wysiwyg-visual .color-blue4,
            .editor-span {
                color: #5842bc;
                font-weight: 600;
                background-color: rgba(88, 66, 188, 0.1);
                padding: 0 2px;
                border-radius: 3px;
                border-bottom: 1px dashed #5842bc;
            }
        </style>
    <?php endif; ?>
<?php
}
?>