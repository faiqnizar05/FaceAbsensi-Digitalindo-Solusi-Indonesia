@extends('layouts.app')

@section('title', 'Permintaan Izin - AbsensiPintar')

@section('styles')
<style>
    .approval-container {
        max-width: 1400px;
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

    .izin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .izin-card {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 8px 32px #1e1e1e;
        transition: all 0.3s;
    }

    .izin-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(59, 130, 246, 0.2);
    }

    .izin-header {
        display: flex;
        justify-content: space-between;
        align-items: start;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .izin-type {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .type-sakit {
        background: rgba(59, 130, 246, 0.2);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .type-dispensasi {
        background: rgba(251, 146, 60, 0.2);
        color: #FB923C;
        border: 1px solid rgba(251, 146, 60, 0.3);
    }

    .type-keluarga {
        background: rgba(34, 197, 94, 0.2);
        color: #22C55E;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-badge {
        display: inline-block;
        padding: 0.3rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-ditangguhkan {
        background: rgba(156, 163, 175, 0.2);
        color: #9CA3AF;
        border: 1px solid rgba(156, 163, 175, 0.3);
    }

    .status-diterima {
        background: rgba(34, 197, 94, 0.2);
        color: #22C55E;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-ditolak {
        background: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .izin-info {
        margin-bottom: 1rem;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 0.7rem;
        margin-bottom: 0.7rem;
        color: #D1D5DB;
        font-size: 0.9rem;
    }

    .info-row i {
        color: #3B82F6;
        width: 20px;
        text-align: center;
    }

    .penjelasan-box {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.2);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .penjelasan-box p {
        color: #D1D5DB;
        margin: 0;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .foto-preview {
        width: 100%;
        border-radius: 10px;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid rgba(59, 130, 246, 0.3);
    }

    .foto-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .no-foto {
        text-align: center;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px dashed rgba(59, 130, 246, 0.3);
        border-radius: 10px;
        color: #9CA3AF;
        margin-bottom: 1rem;
    }

    .action-buttons {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.7rem;
    }

    .btn {
        padding: 0.7rem 1rem;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-weight: 500;
    }

    .btn-approve {
        background: linear-gradient(135deg, #22C55E, #16A34A);
        color: white;
    }

    .btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
    }

    .btn-reject {
        background: linear-gradient(135deg, #EF4444, #DC2626);
        color: white;
    }

    .btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .no-data {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        box-shadow: 0 8px 32px #1e1e1e;
    }

    .no-data i {
        font-size: 4rem;
        color: #3B82F6;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .no-data p {
        color: #9CA3AF;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .izin-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="approval-container">
    <div class="page-header">
        <h1>
            <i class="fas fa-clipboard-check"></i> 
            Permintaan Izin
        </h1>
        <p style="color: #9CA3AF; margin: 0.5rem 0 0 0;">
            Kelola dan approve permintaan izin siswa
        </p>
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

    @if($izinList->count() > 0)
    <div class="izin-grid">
        @foreach($izinList as $izin)
        <div class="izin-card">
            <div class="izin-header">
                @php
                    $typeClass = 'type-sakit';
                    if ($izin->status_izin === 'dispensasi') $typeClass = 'type-dispensasi';
                    elseif ($izin->status_izin === 'urusan_keluarga') $typeClass = 'type-keluarga';
                    
                    $statusClass = 'status-ditangguhkan';
                    if ($izin->cek_status === 'diterima') $statusClass = 'status-diterima';
                    elseif ($izin->cek_status === 'ditolak') $statusClass = 'status-ditolak';
                @endphp
                <span class="izin-type {{ $typeClass }}">
                    {{ $izin->getStatusText() }}
                </span>
                <span class="status-badge {{ $statusClass }}">
                    {{ ucfirst($izin->cek_status) }}
                </span>
            </div>

            <div class="izin-info">
                <div class="info-row">
                    <i class="fas fa-user"></i>
                    <span><strong>{{ $izin->username }}</strong></span>
                </div>
                <div class="info-row">
                    <i class="fas fa-graduation-cap"></i>
                    <span>{{ $izin->kelas }}</span>
                </div>
                <div class="info-row">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ $izin->durasi_hari }} Hari</span>
                </div>
                <div class="info-row">
                    <i class="fas fa-clock"></i>
                    <span>{{ $izin->tanggal_mulai->format('d M Y') }} - {{ $izin->tanggal_expired->format('d M Y') }}</span>
                </div>
            </div>

            <div class="penjelasan-box">
                <strong style="color: #3B82F6; display: block; margin-bottom: 0.5rem;">
                    <i class="fas fa-comment-dots"></i> Penjelasan:
                </strong>
                <p>{{ $izin->penjelasan }}</p>
            </div>

            @if($izin->foto)
                <img src="{{ asset($izin->foto) }}" alt="Surat" class="foto-preview" onclick="window.open('{{ asset($izin->foto) }}', '_blank')">
            @else
                <div class="no-foto">
                    <i class="fas fa-image" style="font-size: 2rem; margin-bottom: 0.5rem;"></i>
                    <p>Tidak ada foto surat</p>
                </div>
            @endif

            @if($izin->cek_status === 'ditangguhkan')
            <div class="action-buttons">
                <form action="{{ route('izin.update-status', $izin->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="cek_status" value="diterima">
                    <button type="submit" class="btn btn-approve">
                        <i class="fas fa-check"></i> Terima
                    </button>
                </form>
                <form action="{{ route('izin.update-status', $izin->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    <input type="hidden" name="cek_status" value="ditolak">
                    <button type="submit" class="btn btn-reject">
                        <i class="fas fa-times"></i> Tolak
                    </button>
                </form>
            </div>
            @else
            <div style="text-align: center; padding: 0.7rem; background: rgba(255, 255, 255, 0.05); border-radius: 8px;">
                <span style="color: #9CA3AF; font-size: 0.9rem;">
                    <i class="fas fa-info-circle"></i> 
                    Status: {{ ucfirst($izin->cek_status) }}
                </span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @else
    <div class="no-data">
        <i class="fas fa-inbox"></i>
        <p>Belum ada permintaan izin</p>
    </div>
    @endif
</div>
@endsection