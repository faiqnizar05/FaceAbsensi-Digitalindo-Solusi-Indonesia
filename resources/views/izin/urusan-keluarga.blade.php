@extends('layouts.app')

@section('title', 'Urusan Keluarga - AbsensiPintar')

@section('styles')
<style>
    .izin-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .page-header {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(34, 197, 94, 0.3);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
        text-align: center;
    }

    .page-header h1 {
        color: #22C55E;
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
        border: 1px solid rgba(34, 197, 94, 0.3);
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
        border: 1px solid rgba(34, 197, 94, 0.3);
        border-radius: 10px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus, .form-textarea:focus {
        outline: none;
        border-color: #22C55E;
        background: rgba(255, 255, 255, 0.08);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
        font-family: inherit;
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
        background: linear-gradient(135deg, #22C55E, #16A34A);
        color: white;
        width: 100%;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
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
        border: 2px solid rgba(34, 197, 94, 0.3);
        border-radius: 8px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        color: #D1D5DB;
    }

    .durasi-option input[type="radio"]:checked + .durasi-label {
        background: rgba(34, 197, 94, 0.2);
        border-color: #22C55E;
        color: #22C55E;
        font-weight: 600;
    }

    .info-box {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: start;
        gap: 0.7rem;
    }

    .info-box i {
        color: #22C55E;
        font-size: 1.2rem;
        margin-top: 0.2rem;
    }

    .info-box p {
        color: #D1D5DB;
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.5;
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
        <h1><i class="fas fa-users"></i> Form Urusan Keluarga</h1>
        <p>Ajukan izin urusan keluarga dengan mengisi form di bawah ini</p>
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
        <div class="info-box">
            <i class="fas fa-info-circle"></i>
            <p>
                <strong>Catatan:</strong> Untuk izin urusan keluarga, Anda tidak perlu mengupload foto surat. 
                Cukup jelaskan alasan urusan keluarga dengan jelas.
            </p>
        </div>

        <form action="{{ route('izin.submit') }}" method="POST" id="izinForm">
            @csrf
            <input type="hidden" name="status_izin" value="urusan_keluarga">
            
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
                    <i class="fas fa-calendar-alt"></i> Durasi Izin
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
                    Pilih berapa hari Anda izin
                </div>
            </div>

            <div class="form-group">
                <label for="penjelasan">
                    <i class="fas fa-comment-dots"></i> Alasan Urusan Keluarga
                </label>
                <textarea 
                    id="penjelasan" 
                    name="penjelasan" 
                    class="form-textarea" 
                    placeholder="Jelaskan urusan keluarga Anda (min. 10 karakter)&#10;Contoh: Acara keluarga, keperluan mendadak, dll."
                    required
                    minlength="10"
                >{{ old('penjelasan') }}</textarea>
                <div class="help-text">
                    <i class="fas fa-info-circle"></i>
                    Jelaskan alasan urusan keluarga dengan sopan dan jelas
                </div>
            </div>

            <button type="submit" class="btn btn-primary" id="submitBtn">
                <i class="fas fa-paper-plane"></i> Kirim Pengajuan Izin
            </button>
        </form>
    </div>
</div>

<script>
    document.getElementById('izinForm').addEventListener('submit', function() {
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
    });
</script>
@endsection