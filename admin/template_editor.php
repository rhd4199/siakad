<?php
require_once __DIR__ . '/../config.php';
require_login(['admin']);

$user         = current_user();
$title        = 'Editor Template';
$currentPage  = 'template-raport'; // Keep parent menu active
$roleBasePath = '/admin';
$baseUrl      = '/siakad';

// Mock get data by ID
$templateId = $_GET['id'] ?? 'new';

$templates = [
    1 => ['name' => 'Sertifikat Standar 2024', 'type' => 'sertifikat'],
    2 => ['name' => 'Raport Semester Ganjil', 'type' => 'raport'],
    3 => ['name' => 'Sertifikat Workshop', 'type' => 'sertifikat']
];

$template = $templates[$templateId] ?? ['name' => 'Template Baru', 'type' => 'sertifikat'];
$templateName = $template['name'];
$templateType = $_GET['type'] ?? $template['type'];

ob_start();
?>

<style>
    .editor-container {
        display: flex;
        height: 70vh;
        border: 1px solid #dee2e6;
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
    }
    .editor-sidebar {
        width: 250px;
        background: white;
        border-right: 1px solid #dee2e6;
        padding: 1rem;
        display: flex;
        flex-direction: column;
    }
    .editor-canvas-wrapper {
        flex-grow: 1;
        overflow: auto;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        background-image: radial-gradient(#dee2e6 1px, transparent 1px);
        background-size: 20px 20px;
    }
    .editor-canvas {
        width: 794px; /* A4 Width at 96 DPI */
        height: 1123px; /* A4 Height */
        background: white;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
        position: relative;
        transform-origin: top center;
        transition: transform 0.2s;
        background-size: cover;
        background-position: center;
    }
    .canvas-item {
        position: absolute;
        padding: 4px 8px;
        background: rgba(13, 110, 253, 0.1);
        border: 1px dashed #0d6efd;
        color: #0d6efd;
        cursor: move;
        font-size: 14px;
        user-select: none;
        white-space: nowrap;
    }
    .canvas-item:hover, .canvas-item.active {
        background: rgba(13, 110, 253, 0.2);
        border-style: solid;
        z-index: 10;
    }
    .draggable-source {
        padding: 8px 12px;
        margin-bottom: 8px;
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        cursor: grab;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .draggable-source:hover {
        background: #f8f9fa;
        border-color: #adb5bd;
    }
    .zoom-controls {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: white;
        padding: 5px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        display: flex;
        gap: 5px;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex align-items-center gap-3">
        <a href="template_raport.php" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h4 class="fw-bold mb-0">Editor: <?= htmlspecialchars($templateName) ?></h4>
            <p class="text-muted small mb-0">Sesuaikan tata letak dan variabel dokumen.</p>
        </div>
    </div>
    <div class="d-flex gap-2">
        <select class="form-select form-select-sm" id="templateType" onchange="switchTemplate()">
            <option value="sertifikat" <?= $templateType === 'sertifikat' ? 'selected' : '' ?>>Template Sertifikat (Landscape)</option>
            <option value="raport" <?= $templateType === 'raport' ? 'selected' : '' ?>>Template Raport (Portrait)</option>
        </select>
        <button class="btn btn-primary btn-sm" onclick="saveTemplate()">
            <i class="bi bi-save me-1"></i> Simpan Template
        </button>
    </div>
</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body p-0">
        <!-- Toolbar -->
        <div class="border-bottom p-2 bg-light d-flex gap-2 align-items-center">
            <button class="btn btn-sm btn-outline-secondary bg-white" onclick="document.getElementById('bgUpload').click()">
                <i class="bi bi-image me-1"></i> Upload Background
            </button>
            <input type="file" id="bgUpload" hidden accept="image/*" onchange="handleBgUpload(this)">
            
            <div class="vr mx-2"></div>
            
            <span class="small text-muted" id="currentSizeInfo">A4 Landscape (1123 x 794 px)</span>
        </div>

        <div class="editor-container">
            <!-- Sidebar: Variables -->
            <div class="editor-sidebar">
                <h6 class="fw-bold mb-3 small text-uppercase text-muted">Variabel Tersedia</h6>
                
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="text" data-var="{nama_siswa}">
                    <i class="bi bi-person"></i> Nama Siswa
                </div>
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="text" data-var="{nomor_induk}">
                    <i class="bi bi-card-text"></i> Nomor Induk
                </div>
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="text" data-var="{program_kelas}">
                    <i class="bi bi-easel"></i> Program / Kelas
                </div>
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="text" data-var="{nilai_akhir}">
                    <i class="bi bi-123"></i> Nilai Akhir
                </div>
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="text" data-var="{predikat}">
                    <i class="bi bi-award"></i> Predikat (A/B/C)
                </div>
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="text" data-var="{tanggal_lulus}">
                    <i class="bi bi-calendar"></i> Tanggal Lulus
                </div>
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="text" data-var="{no_sertifikat}">
                    <i class="bi bi-hash"></i> No. Sertifikat
                </div>
                <div class="draggable-source" draggable="true" ondragstart="drag(event)" data-type="qr" data-var="{qr_validasi}">
                    <i class="bi bi-qr-code"></i> QR Code Validasi
                </div>

                <div class="mt-auto">
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-info-circle me-1"></i> Drag & Drop variabel ke canvas di sebelah kanan.
                    </div>
                </div>
            </div>

            <!-- Canvas -->
            <div class="editor-canvas-wrapper" id="canvasWrapper">
                <div class="editor-canvas" id="editorCanvas" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <!-- Items will be placed here -->
                    <div class="canvas-item" style="top: 40%; left: 40%;" id="sample-item-1" onmousedown="initDrag(event, this)">
                        {nama_siswa}
                    </div>
                </div>
                
                <div class="zoom-controls">
                    <button class="btn btn-sm btn-light border" onclick="zoomOut()"><i class="bi bi-dash"></i></button>
                    <span class="small align-self-center px-2" id="zoomLevel">100%</span>
                    <button class="btn btn-sm btn-light border" onclick="zoomIn()"><i class="bi bi-plus"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let currentZoom = 1;
    let draggedType = null;
    let draggedVar = null;

    function switchTemplate() {
        const type = document.getElementById('templateType').value;
        const canvas = document.getElementById('editorCanvas');
        const info = document.getElementById('currentSizeInfo');
        
        if (type === 'sertifikat') {
            canvas.style.width = '1123px';
            canvas.style.height = '794px';
            info.innerText = 'A4 Landscape (1123 x 794 px)';
        } else {
            canvas.style.width = '794px';
            canvas.style.height = '1123px';
            info.innerText = 'A4 Portrait (794 x 1123 px)';
        }
        // Reset items or load specific template items here
    }

    function handleBgUpload(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('editorCanvas').style.backgroundImage = `url('${e.target.result}')`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        draggedType = ev.target.dataset.type;
        draggedVar = ev.target.dataset.var;
    }

    function drop(ev) {
        ev.preventDefault();
        const canvas = document.getElementById('editorCanvas');
        const rect = canvas.getBoundingClientRect();
        
        // Calculate position relative to canvas (considering zoom)
        const x = (ev.clientX - rect.left) / currentZoom;
        const y = (ev.clientY - rect.top) / currentZoom;

        createCanvasItem(draggedVar, x, y);
    }

    function createCanvasItem(text, x, y) {
        const div = document.createElement('div');
        div.className = 'canvas-item';
        div.innerText = text;
        div.style.left = x + 'px';
        div.style.top = y + 'px';
        div.onmousedown = function(e) { initDrag(e, div); };
        
        document.getElementById('editorCanvas').appendChild(div);
    }

    // Canvas Item Drag Logic (Mouse Events)
    let activeItem = null;
    let startX, startY, initialLeft, initialTop;

    function initDrag(e, item) {
        e.preventDefault();
        e.stopPropagation();
        activeItem = item;
        startX = e.clientX;
        startY = e.clientY;
        initialLeft = parseInt(item.style.left || 0);
        initialTop = parseInt(item.style.top || 0);
        
        item.classList.add('active');
        document.addEventListener('mousemove', doDrag);
        document.addEventListener('mouseup', stopDrag);
    }

    function doDrag(e) {
        if (!activeItem) return;
        const dx = (e.clientX - startX) / currentZoom;
        const dy = (e.clientY - startY) / currentZoom;
        
        activeItem.style.left = (initialLeft + dx) + 'px';
        activeItem.style.top = (initialTop + dy) + 'px';
    }

    function stopDrag() {
        if (activeItem) {
            activeItem.classList.remove('active');
            activeItem = null;
        }
        document.removeEventListener('mousemove', doDrag);
        document.removeEventListener('mouseup', stopDrag);
    }

    // Zoom Logic
    function zoomIn() {
        if (currentZoom < 1.5) {
            currentZoom += 0.1;
            applyZoom();
        }
    }
    function zoomOut() {
        if (currentZoom > 0.5) {
            currentZoom -= 0.1;
            applyZoom();
        }
    }
    function applyZoom() {
        const canvas = document.getElementById('editorCanvas');
        canvas.style.transform = `scale(${currentZoom})`;
        document.getElementById('zoomLevel').innerText = Math.round(currentZoom * 100) + '%';
    }

    function saveTemplate() {
        // Collect all items
        const items = [];
        document.querySelectorAll('.canvas-item').forEach(el => {
            items.push({
                text: el.innerText,
                left: el.style.left,
                top: el.style.top
            });
        });
        
        console.log('Saving template:', items);
        alert('Template berhasil disimpan! (Simulasi)');
    }
    
    // Initialize
    switchTemplate();
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>