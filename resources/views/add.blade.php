@extends('layouts.app')

@section('title', 'Tambah Anggota - Absensi')

@section('content')

<style>
    .form-container {
        max-width: 800px;
        margin: 30px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    }

    .form-title {
        font-size: 26px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #1e3a8a;
    }

    .form-subtitle {
        color: #64748b;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 15px;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-submit {
        width: 100%;
        padding: 13px;
        border: none;
        border-radius: 8px;
        background: #2563eb;
        color: white;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-submit:hover {
        background: #1d4ed8;
    }

    .alert {
        padding: 13px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .required {
        color: #dc2626;
    }

    .preview {
        margin-top: 10px;
        display: none;
    }

    .preview img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
    }
</style>

<div class="form-container">

    <div class="form-title">
        Tambah Anggota
    </div>

    <div class="form-subtitle">
        Silakan lengkapi data peserta untuk pendaftaran absensi.
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDATION ERROR --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin:0; padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('user.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        {{-- NO REGISTER --}}
        <div class="form-group">
            <label for="register">
                No Register <span class="required">*</span>
            </label>

            <input
                type="text"
                name="register"
                id="register"
                class="form-control"
                placeholder="Contoh: 1111"
                value="{{ old('register') }}"
                required
            >
        </div>

        {{-- DEPARTEMENT --}}
        <div class="form-group">
            <label for="departement">
                Departement <span class="required">*</span>
            </label>

            <input
                type="text"
                name="departement"
                id="departement"
                class="form-control"
                placeholder="Contoh: Content Creator"
                value="{{ old('departement') }}"
                required
            >
        </div>

        {{-- NAMA --}}
        <div class="form-group">
            <label for="nama">
                Nama <span class="required">*</span>
            </label>

            <input
                type="text"
                name="nama"
                id="nama"
                class="form-control"
                placeholder="Masukkan nama lengkap"
                value="{{ old('nama') }}"
                required
            >
        </div>

        {{-- NO TELEPON --}}
        <div class="form-group">
            <label for="no_telepon">
                No Telepon <span class="required">*</span>
            </label>

            <input
                type="text"
                name="no_telepon"
                id="no_telepon"
                class="form-control"
                placeholder="Contoh: 081234567890"
                value="{{ old('no_telepon') }}"
                required
            >
        </div>

        {{-- TANGGAL MULAI --}}
        <div class="form-group">
            <label for="tanggal_mulai">
                Tanggal Mulai <span class="required">*</span>
            </label>

            <input
                type="date"
                name="tanggal_mulai"
                id="tanggal_mulai"
                class="form-control"
                value="{{ old('tanggal_mulai') }}"
                required
            >
        </div>

        {{-- FOTO --}}
        <div class="form-group">
            <label for="image">
                Foto <span class="required">*</span>
            </label>

            <input
                type="file"
                name="image"
                id="image"
                class="form-control"
                accept="image/jpeg,image/jpg,image/png"
                required
            >

            <small style="color:#64748b;">
                Format JPG/JPEG/PNG, maksimal 2 MB.
            </small>

            <div class="preview" id="imagePreview">
                <img id="previewImage" src="" alt="Preview">
            </div>
        </div>

        {{-- SUBMIT --}}
        <button type="submit" class="btn-submit">
            <i class="fas fa-save"></i>
            Simpan Data Anggota
        </button>

    </form>

</div>

<script>
document.getElementById('image').addEventListener('change', function(event) {

    const file = event.target.files[0];

    if (!file) {
        document.getElementById('imagePreview').style.display = 'none';
        return;
    }

    const reader = new FileReader();

    reader.onload = function(e) {

        document.getElementById('previewImage').src = e.target.result;

        document.getElementById('imagePreview').style.display = 'block';
    };

    reader.readAsDataURL(file);
});
</script>

@endsection