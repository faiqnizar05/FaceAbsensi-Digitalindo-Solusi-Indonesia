@extends('layouts.app')

@section('title', 'Tambah Anggota - Absensi')

@section('styles')
<style>
    .page-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
    }

    .page-header h1 {
        color: #3B82F6;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .page-header p {
        color: #9CA3AF;
        margin: 0;
    }

    .form-section {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #22C55E;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #EF4444;
    }

    .alert i {
        font-size: 1.2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.7rem;
        color: #E5E7EB;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.9rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #3B82F6;
        background: rgba(255, 255, 255, 0.08);
    }

    .form-control::placeholder {
        color: #6B7280;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-input-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
        padding: 3rem;
        background: rgba(59, 130, 246, 0.05);
        border: 2px dashed rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }

    .file-input-label:hover {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3B82F6;
    }

    .file-input-label i {
        font-size: 2.5rem;
        color: #3B82F6;
    }

    .file-input-label span {
        color: #D1D5DB;
        font-size: 0.95rem;
    }

    .file-input-wrapper input[type="file"] {
        position: absolute;
        left: -9999px;
    }

    .preview-container {
        margin-top: 1rem;
        display: none;
    }

    .preview-container.active {
        display: block;
    }

    .image-preview {
        width: 100%;
        max-width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid rgba(59, 130, 246, 0.3);
        margin: 0 auto;
        display: block;
    }

    .file-info {
        margin-top: 0.7rem;
        padding: 0.7rem;
        background: rgba(59, 130, 246, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .file-info-text {
        color: #D1D5DB;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-remove {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #EF4444;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.3s;
    }

    .btn-remove:hover {
        background: rgba(239, 68, 68, 0.3);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.9rem 1.8rem;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        font-weight: 500;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
        flex: 1;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: #D1D5DB;
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: #3B82F6;
    }

    .help-text {
        color: #9CA3AF;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .help-text i {
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1><i class="fas fa-user-plus"></i> Tambah Anggota Baru</h1>
        <p>Daftarkan anggota baru untuk sistem absensi face recognition</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <div>
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="form-section">
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" id="addUserForm">
            @csrf
            
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i> Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-control" 
                    placeholder="Masukkan username (minimal 3 karakter)"
                    value="{{ old('username') }}"
                    required
                    minlength="3"
                >
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Username harus unik dan minimal 3 karakter
                </div>
            </div>

            <!-- FIELD KELAS BARU! -->
            <div class="form-group">
                <label for="kelas">
                    <i class="fas fa-graduation-cap"></i> Kelas
                </label>
                <input 
                    type="text" 
                    id="kelas" 
                    name="kelas" 
                    class="form-control" 
                    placeholder="Contoh: XII RPL 1, X TKJ 2, Kelas A"
                    value="{{ old('kelas') }}"
                    required
                    minlength="2"
                >
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Masukkan kelas anggota (minimal 2 karakter)
                </div>
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-image"></i> Upload Foto Wajah
                </label>
                <div class="file-input-wrapper">
                    <label for="image" class="file-input-label" id="fileLabel">
                        <div>
                            <i class="fas fa-cloud-upload-alt"></i>
                            <div>
                                <span style="display: block; font-weight: 600; color: #3B82F6; margin-bottom: 0.3rem;">
                                    Klik untuk upload foto
                                </span>
                                <span style="font-size: 0.85rem;">
                                    Format: JPEG, JPG, PNG (Max: 2MB)
                                </span>
                            </div>
                        </div>
                    </label>
                    <input 
                        type="file" 
                        id="image" 
                        name="image" 
                        accept="image/jpeg,image/png,image/jpg"
                        required
                    >
                </div>
                <div class="preview-container" id="previewContainer">
                    <img src="" alt="Preview" class="image-preview" id="imagePreview">
                    <div class="file-info">
                        <span class="file-info-text">
                            <i class="fas fa-file-image"></i>
                            <span id="fileName"></span>
                        </span>
                        <button type="button" class="btn-remove" id="removeImage">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </div>
                </div>
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Gunakan foto wajah yang jelas dan menghadap ke depan untuk akurasi terbaik
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="resetForm()">
                    <i class="fas fa-redo"></i> Reset
                </button>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const fileName = document.getElementById('fileName');
    const removeBtn = document.getElementById('removeImage');
    const fileLabel = document.getElementById('fileLabel');
    const submitBtn = document.getElementById('submitBtn');

    // Preview image
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                imageInput.value = '';
                return;
            }

            // Validate file type
            if (!file.type.match('image/jpeg') && !file.type.match('image/jpg') && !file.type.match('image/png')) {
                alert('Format file tidak didukung! Gunakan JPEG, JPG, atau PNG');
                imageInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                fileName.textContent = file.name;
                previewContainer.classList.add('active');
                fileLabel.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove image
    removeBtn.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.src = '';
        fileName.textContent = '';
        previewContainer.classList.remove('active');
        fileLabel.style.display = 'flex';
    });

    // Reset form
    function resetForm() {
        if (confirm('Yakin ingin mereset form?')) {
            document.getElementById('addUserForm').reset();
            imageInput.value = '';
            imagePreview.src = '';
            fileName.textContent = '';
            previewContainer.classList.remove('active');
            fileLabel.style.display = 'flex';
        }
    }

    // Form validation - UPDATE VALIDASI KELAS!
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const kelas = document.getElementById('kelas').value.trim();
        
        if (username.length < 3) {
            e.preventDefault();
            alert('Username minimal 3 karakter!');
            return;
        }

        // VALIDASI KELAS BARU!
        if (kelas.length < 2) {
            e.preventDefault();
            alert('Kelas minimal 2 karakter!');
            return;
        }

        if (!imageInput.files[0]) {
            e.preventDefault();
            alert('Silakan upload foto wajah!');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
    });
</script>
@endsection