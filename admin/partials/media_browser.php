<div class="media-browser-container">
    <div class="media-browser-header d-flex justify-content-between align-items-center mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" id="mediaBreadcrumb">
                <li class="breadcrumb-item"><a href="#" onclick="loadMedia('')">
                        <?php echo __('Assets'); ?>
                    </a></li>
            </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
            <div class="small text-muted" id="mediaStatus">Loading...</div>
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill" id="deleteToggleBtn"
                onclick="toggleDeleteMode()">
                <i class="bi bi-trash"></i>
                <?php echo __('Delete'); ?>
            </button>
            <button type="button" class="btn btn-danger btn-sm rounded-pill d-none" id="confirmDeleteBtn"
                onclick="deleteSelectedMedia()">
                <?php echo __('Confirm Delete'); ?>
            </button>
            <button type="button" class="btn btn-primary btn-sm rounded-pill"
                onclick="document.getElementById('mediaUploadInput').click()">
                <i class="bi bi-upload"></i>
                <?php echo __('Upload'); ?>
            </button>
            <input type="file" id="mediaUploadInput" multiple style="display: none;" onchange="handleMediaUpload(this)">
        </div>
    </div>

    <div class="asset-grid" id="mediaGrid">
        <!-- JS will populate this -->
    </div>
</div>

<style>
    .asset-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 15px;
        max-height: 400px;
        overflow-y: auto;
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 15px;
        background: #fff;
    }

    .media-item {
        position: relative;
        border: 2px solid transparent;
        border-radius: 12px;
        cursor: pointer;
        transition: 0.2s;
        padding: 10px;
        text-align: center;
        background: #fbfbfb;
    }

    .media-item:hover {
        background: #f0eff5;
        border-color: #eee;
    }

    .media-item.selected {
        border-color: #5842bc;
        background: #f0eff5;
    }

    .media-item.to-delete {
        border-color: #dc3545;
        background: #fff5f5;
    }

    .media-item img {
        width: 100%;
        height: 80px;
        object-fit: contain;
        margin-bottom: 8px;
    }

    .media-item i {
        font-size: 40px;
        color: #5842bc;
        display: block;
        margin-bottom: 8px;
    }

    .media-item .name {
        font-size: 11px;
        color: #666;
        word-break: break-all;
        height: 32px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .delete-checkbox {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 18px;
        height: 18px;
        cursor: pointer;
        z-index: 2;
        display: none;
    }

    .delete-mode .delete-checkbox {
        display: block;
    }
</style>

<script>
    let currentMediaCallback = null;
    let currentPath = '';
    let isDeleteMode = false;

    function initMediaBrowser(callback) {
        currentMediaCallback = callback;
        loadMedia('');
    }

    function toggleDeleteMode() {
        isDeleteMode = !isDeleteMode;
        const grid = document.getElementById('mediaGrid');
        const toggleBtn = document.getElementById('deleteToggleBtn');
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        if (isDeleteMode) {
            grid.classList.add('delete-mode');
            toggleBtn.innerHTML = '<i class="bi bi-x-circle"></i> Cancel';
            toggleBtn.classList.remove('btn-outline-danger');
            toggleBtn.classList.add('btn-secondary');
            confirmBtn.classList.remove('d-none');
        } else {
            grid.classList.remove('delete-mode');
            toggleBtn.innerHTML = '<i class="bi bi-trash"></i> Delete';
            toggleBtn.classList.add('btn-outline-danger');
            toggleBtn.classList.remove('btn-secondary');
            confirmBtn.classList.add('d-none');
            // Uncheck all
            document.querySelectorAll('.delete-checkbox').forEach(cb => cb.checked = false);
            document.querySelectorAll('.media-item').forEach(item => item.classList.remove('to-delete'));
        }
    }

    async function deleteSelectedMedia() {
        const selected = Array.from(document.querySelectorAll('.delete-checkbox:checked')).map(cb => cb.dataset.path);

        if (selected.length === 0) {
            alert('Please select files to delete.');
            return;
        }

        if (!confirm(`Are you sure you want to delete ${selected.length} items? This action CANNOT be undone.`)) {
            return;
        }

        const confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.disabled = true;
        confirmBtn.innerText = 'Deleting...';

        try {
            const resp = await fetch(CONFIG.BASE_URL + '/admin/api_delete_media', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ items: selected, csrf_token: CONFIG.CSRF_TOKEN })
            });
            const result = await resp.json();

            if (result.success) {
                if (result.errors && result.errors.length > 0) {
                    alert('Some items could not be deleted:\n' + result.errors.join('\n'));
                }
                toggleDeleteMode();
                loadMedia(currentPath);
            } else {
                alert('Deletion failed: ' + result.message);
            }
        } catch (err) {
            alert('Error during deletion.');
        } finally {
            confirmBtn.disabled = false;
            confirmBtn.innerText = 'Confirm Delete';
        }
    }

    async function handleMediaUpload(input) {
        if (!input.files || input.files.length === 0) return;

        const formData = new FormData();
        formData.append('path', currentPath);
        formData.append('csrf_token', CONFIG.CSRF_TOKEN);
        for (let i = 0; i < input.files.length; i++) {
            formData.append('files[]', input.files[i]);
        }

        const status = document.getElementById('mediaStatus');
        status.innerText = 'Uploading...';

        try {
            const resp = await fetch(CONFIG.BASE_URL + '/admin/api_upload', {
                method: 'POST',
                body: formData
            });
            const result = await resp.json();

            if (result.success) {
                if (result.errors && result.errors.length > 0) {
                    alert('Uploaded with some errors:\n' + result.errors.join('\n'));
                }
                loadMedia(currentPath);
            } else {
                alert('Upload failed: ' + result.message + (result.errors ? '\n' + result.errors.join('\n') : ''));
            }
        } catch (err) {
            alert('Error during upload.');
        } finally {
            input.value = ''; // Reset input
        }
    }

    async function loadMedia(path) {
        currentPath = path;
        const grid = document.getElementById('mediaGrid');
        const status = document.getElementById('mediaStatus');
        const breadcrumb = document.getElementById('mediaBreadcrumb');

        status.innerText = 'Loading...';
        grid.innerHTML = '<div class="col-12 py-5 text-center text-muted"><i class="bi bi-arrow-repeat spin"></i> Loading assets...</div>';

        try {
            const resp = await fetch(CONFIG.BASE_URL + `/admin/api_media?path=${encodeURIComponent(path)}`);
            const data = await resp.json();

            status.innerText = `${data.items.length} <?php echo __('items'); ?>`;
            grid.innerHTML = '';

            // Update Breadcrumb
            breadcrumb.innerHTML = '<li class="breadcrumb-item"><a href="#" onclick="loadMedia(\'\'); return false;"><?php echo __('Assets'); ?></a></li>';
            if (path) {
                const parts = path.split('/');
                let currentPartPath = '';
                parts.forEach((p, i) => {
                    currentPartPath += (i > 0 ? '/' : '') + p;
                    breadcrumb.innerHTML += `<li class="breadcrumb-item active">${p}</li>`;
                });
            }

            // Parent Directory
            if (path !== '') {
                const parentItem = document.createElement('div');
                parentItem.className = 'media-item';
                parentItem.onclick = () => loadMedia(data.parent_path);
                parentItem.innerHTML = `<i class="bi bi-arrow-left-circle"></i><div class="name">.. <?php echo __('Back'); ?></div>`;
                grid.appendChild(parentItem);
            }

            data.items.forEach(item => {
                const div = document.createElement('div');
                div.className = 'media-item';

                // Add Checkbox
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.className = 'delete-checkbox form-check-input';
                checkbox.dataset.path = item.path.replace(/^\/assets\/img\//, '');
                checkbox.onclick = (e) => e.stopPropagation();
                checkbox.onchange = () => div.classList.toggle('to-delete', checkbox.checked);
                div.appendChild(checkbox);

                if (item.type === 'directory') {
                    div.onclick = () => {
                        if (isDeleteMode) {
                            checkbox.checked = !checkbox.checked;
                            div.classList.toggle('to-delete', checkbox.checked);
                        } else {
                            loadMedia(item.path);
                        }
                    };
                    div.innerHTML += `<i class="bi bi-folder-fill"></i><div class="name">${item.name}</div>`;
                } else {
                    div.onclick = () => {
                        if (isDeleteMode) {
                            checkbox.checked = !checkbox.checked;
                            div.classList.toggle('to-delete', checkbox.checked);
                        } else {
                            document.querySelectorAll('.media-item').forEach(i => i.classList.remove('selected'));
                            div.classList.add('selected');
                            if (currentMediaCallback) currentMediaCallback(item.path);
                        }
                    };
                    div.innerHTML += `<img src="${item.url}" alt="${item.name}"><div class="name">${item.name}</div>`;
                }
                grid.appendChild(div);
            });

            // Re-apply delete mode class if needed
            if (isDeleteMode) grid.classList.add('delete-mode');

        } catch (err) {
            grid.innerHTML = '<div class="col-12 py-5 text-center text-danger">Error loading media assets.</div>';
            status.innerText = 'Error';
        }
    }
</script>