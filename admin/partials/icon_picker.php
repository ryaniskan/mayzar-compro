<?php
require_once __DIR__ . '/../icon_helper.php';
$icons = icon_get_list();
?>
<div class="icon-picker-container">
    <div class="mb-3">
        <input type="text" class="form-control" id="iconSearch" placeholder="<?php echo __('Search icons...'); ?>"
            onkeyup="filterIcons()">
    </div>
    <div class="icon-grid" id="iconGrid">
        <?php foreach ($icons as $icon): ?>
            <div class="icon-item" onclick="selectIcon('<?php echo $icon; ?>', this)">
                <i class="bi <?php echo $icon; ?>"></i>
                <div class="small text-muted mt-1 text-truncate" style="font-size: 9px;">
                    <?php echo str_replace('bi-', '', $icon); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 10px;
        max-height: 300px;
        overflow-y: auto;
        padding: 5px;
    }

    .icon-item {
        border: 1px solid #eee;
        border-radius: 10px;
        padding: 10px 5px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s;
    }

    .icon-item:hover {
        background: #f0eff5;
        border-color: #5842bc;
    }

    .icon-item.active {
        background: #5842bc;
        color: #fff;
        border-color: #5842bc;
    }

    .icon-item.active .text-muted {
        color: #eee !important;
    }

    .icon-item i {
        font-size: 24px;
        display: block;
    }
</style>

<script>
    let currentIconCallback = null;

    function initIconPicker(callback) {
        currentIconCallback = callback;
    }

    function selectIcon(icon, el) {
        document.querySelectorAll('.icon-item').forEach(i => i.classList.remove('active'));
        el.classList.add('active');
        if (currentIconCallback) currentIconCallback(icon);
    }

    function filterIcons() {
        const q = document.getElementById('iconSearch').value.toLowerCase();
        document.querySelectorAll('.icon-item').forEach(item => {
            const name = item.innerText.toLowerCase();
            item.style.display = name.includes(q) ? 'block' : 'none';
        });
    }
</script>