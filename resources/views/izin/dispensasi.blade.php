@extends('layouts.app')

@section('title', 'Dispensasi - AbsensiPintar')

@section('styles')
<style>
    .izin-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 146, 60, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
        text-align: center;
    }

    .page-header h1 {
        color: #FB923C;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.7rem;
    }

    .page-header p {
        color: #9CA3AF;
        margin: 0;
    }

    .form-section {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(251, 146, 60, 0.3);
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
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
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

    .form-control, .form-textarea {
        width: 100%;
        padding: 0.9rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(251, 146, 60, 0.3);
        border-radius: 10px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus, .form-textarea:focus {
        outline: none;
        border-color: #FB923C;
        background: rgba(255, 255, 255, 0.08);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
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
        background: rgba(251, 146, 60, 0.05);
        border: 2px dashed rgba(251, 146, 60, 0.3);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        text-align: center;
    }

    .file-input-label:hover {
        background: rgba(251, 146, 60, 0.1);
        border-color: #FB923C;
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
        border: 2px solid rgba(251, 146, 60, 0.3);
        margin: 0 auto;
        display: block;
    }

    .file-info {
        margin-top: 0.7rem;
        padding: 0.7rem;
        background: rgba(251, 146, 60, 0.1);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
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
        background: linear-gradient(135deg, #FB923C, #F97316);
        color: white;
        width: 100%;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(251, 146, 60, 0.3);
    }

    .btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .help-text {
        color: #9CA3AF;
        font-size: 0.85rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .durasi-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 0.7rem;
    }

    .durasi-option {
        position: relative;
    }

    .durasi-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .durasi-label {
        display: block;
        padding: 0.8rem;
        background: rgba(255, 255, 255, 0.05);
        border: 2px solid rgba(251, 146, 60, 0.3);
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        color: #D1D5DB;
    }

    .durasi-option input[type="radio"]:checked + .durasi-label {
        background: rgba(251, 146, 60, 0.2);
        border-color: #FB923C;
        color: #FB923C;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .durasi-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>
@endsection

@section('content')
<div class="izin-container">
    <div class="page-header">
        <h1><i class="fas fa-clock"></i> Form Dispensasi</h1>
        <p>Ajukan dispensasi dengan mengisi form di bawah ini</p>
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
        <form action="{{ route('izin.submit') }}" method="POST" enctype="multipart/form-data" id="izinForm">
            @csrf
            <input type="hidden" name="status_izin" value="dispensasi">
            
            <div class="form-group">
                <label for="username">
                    <i class="fas fa-user"></i> Username
                </label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    class="form-control" 
                    placeholder="Masukkan username Anda"
                    value="{{ old('username') }}"
                    required
                >
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Username yang terdaftar di sistem absensi
                </div>
            </div>

            <div class="form-group">
                <label for="kelas">
                    <i class="fas fa-graduation-cap"></i> Kelas
                </label>
                <input 
                    type="text" 
                    id="kelas" 
                    name="kelas" 
                    class="form-control" 
                    placeholder="Contoh: XII PPLG 1"
                    value="{{ old('kelas') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-calendar-alt"></i> Durasi Dispensasi
                </label>
                <div class="durasi-grid">
                    @for($i = 1; $i <= 5; $i++)
                    <div class="durasi-option">
                        <input 
                            type="radio" 
                            name="durasi_hari" 
                            value="{{ $i }}" 
                            id="durasi{{ $i }}"
                            {{ old('durasi_hari') == $i ? 'checked' : ($i == 1 ? 'checked' : '') }}
                            required
                        >
                        <label for="durasi{{ $i }}" class="durasi-label">
                            {{ $i }} Hari
                        </label>
                    </div>
                    @endfor
                </div>
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Pilih berapa hari Anda butuh dispensasi
                </div>
            </div>

            <div class="form-group">
                <label for="penjelasan">
                    <i class="fas fa-comment-dots"></i> Alasan Dispensasi
                </label>
                <textarea 
                    id="penjelasan" 
                    name="penjelasan" 
                    class="form-textarea" 
                    placeholder="Jelaskan alasan dispensasi (min. 10 karakter)"
                    required
                    minlength="10"
                >{{ old('penjelasan') }}</textarea>
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Contoh: Mengikuti lomba, keperluan sekolah, dll.
                </div>
            </div>

            <div class="form-group">
                <label>
                    <i class="fas fa-image"></i> Upload Surat Dispensasi (Opsional)
                </label>
                <div class="file-input-wrapper">
                    <label for="foto" class="file-input-label" id="fileLabel">
                        <div>
                            <i class="fas fa-cloud-upload-alt" style="font-size: 2.5rem; color: #FB923C;"></i>
                            <div>
                                <span style="display: block; font-weight: 600; color: #FB923C; margin-bottom: 0.3rem;">
                                    Klik untuk upload foto surat
                                </span>
                                <span style="font-size: 0.85rem; color: #D1D5DB;">
                                    Format: JPEG, JPG, PNG (Max: 2MB) - Opsional
                                </span>
                            </div>
                        </div>
                    </label>
                    <input 
                        type="file" 
                        id="foto" 
                        name="foto" 
                        accept="image/jpeg,image/png,image/jpg"
                    >
                </div>
                <div class="preview-container" id="previewContainer">
                    <img src="" alt="Preview" class="image-preview" id="imagePreview">
                    <div class="file-info">
                        <span style="color: #D1D5DB; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-file-image"></i>
                            <span id="fileName"></span>
                        </span>
                        <button type="button" class="btn-remove" id="removeImage">
                            <i class="fas fa-times"></i> Hapus
                        </button>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-paper-plane"></i> Kirim Pengajuan Dispensasi
            </button>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('foto');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const fileName = document.getElementById('fileName');
    const removeBtn = document.getElementById('removeImage');
    const fileLabel = document.getElementById('fileLabel');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                imageInput.value = '';
                return;
            }

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

    removeBtn.addEventListener('click', function() {
        imageInput.value = '';
        imagePreview.src = '';
        fileName.textContent = '';
        previewContainer.classList.remove('active');
        fileLabel.style.display = 'flex';
    });

    document.getElementById('izinForm').addEventListener('submit', function() {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
    });
</script>
@endsection