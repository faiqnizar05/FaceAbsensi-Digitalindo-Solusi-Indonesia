@extends('layouts.app')

@section('title', 'Riwayat Absensi - FaceAbsen')

@section('styles')
<style>
    .page-container {
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

    .page-header p {
        color: #9CA3AF;
        margin: 0;
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

    .filter-section {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
    }

    .filter-title {
        color: #3B82F6;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .filter-form {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 250px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #E5E7EB;
        font-weight: 500;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-input {
        width: 100%;
        padding: 0.8rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 8px;
        color: #fff;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .filter-input:focus {
        outline: none;
        border-color: #3B82F6;
        background: rgba(255, 255, 255, 0.08);
    }

    .filter-actions {
        display: flex;
        gap: 0.7rem;
    }

    .btn {
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .btn-filter {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
    }

    .btn-filter:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }

    .btn-reset {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #EF4444;
    }

    .btn-reset:hover {
        background: rgba(239, 68, 68, 0.25);
    }

    .section {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-header h2 {
        color: #3B82F6;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        margin: 0;
    }

    .result-info {
        color: #9CA3AF;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .result-info strong {
        color: #3B82F6;
    }

    .table-container {
        overflow-x: auto;
        margin-top: 1rem;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead {
        background: rgba(59, 130, 246, 0.1);
    }

    th {
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: #3B82F6;
        border-bottom: 2px solid rgba(59, 130, 246, 0.3);
        white-space: nowrap;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid rgba(59, 130, 246, 0.1);
        color: #D1D5DB;
    }

    tbody tr {
        transition: all 0.3s;
    }

    tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .username-cell {
        font-weight: 600;
        color: #E5E7EB;
    }

    .time-cell {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .date-text {
        color: #E5E7EB;
        font-weight: 500;
    }

    .time-text {
        color: #9CA3AF;
        font-size: 0.9rem;
    }

    .location-link {
        color: #3B82F6;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .location-link:hover {
        color: #60A5FA;
        text-decoration: underline;
    }

    .status-badge {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .status-success {
        background: rgba(34, 197, 94, 0.15);
        color: #22C55E;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-failed {
        background: rgba(239, 68, 68, 0.15);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .btn-danger {
        background: rgba(239, 68, 68, 0.15);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #EF4444;
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-danger:hover {
        background: rgba(239, 68, 68, 0.25);
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #9CA3AF;
    }

    .empty-state i {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
        color: #3B82F6;
    }

    .empty-state h3 {
        color: #D1D5DB;
        margin-bottom: 0.7rem;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .filter-section {
            padding: 1.5rem;
        }

        .filter-form {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
            min-width: auto;
        }

        .filter-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .section {
            padding: 1.5rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        table {
            font-size: 0.9rem;
        }

        th, td {
            padding: 0.7rem 0.5rem;
        }

        .time-cell {
            flex-direction: row;
            gap: 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1><i class="fas fa-clipboard-list"></i> Riwayat Absensi</h1>
        <p>Data riwayat absensi semua anggota</p>
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

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-title">
            <i class="fas fa-filter"></i>
            Filter Data Absensi
        </div>
        <form action="{{ route('absen.history') }}" method="GET" class="filter-form">
            <div class="filter-group">
                <label for="date">
                    <i class="fas fa-calendar-day"></i>
                    Tanggal Absensi
                </label>
                <input 
                    type="date" 
                    id="date" 
                    name="date" 
                    class="filter-input"
                    value="{{ request('date') }}"
                    max="{{ date('Y-m-d') }}"
                >
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-filter">
                    <i class="fas fa-search"></i>
                    Filter
                </button>
                <a href="{{ route('absen.history') }}" class="btn btn-reset">
                    <i class="fas fa-redo"></i>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Data Section -->
    <div class="section">
        <div class="section-header">
            <h2><i class="fas fa-list"></i> Data Absensi</h2>
            @if(request('date'))
            <div class="result-info">
                <i class="fas fa-info-circle"></i>
                Menampilkan data tanggal: <strong>{{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}</strong>
            </div>
            @else
            <div class="result-info">
                <i class="fas fa-database"></i>
                Total: <strong>{{ $absens->count() }}</strong> data
            </div>
            @endif
        </div>

        <div class="table-container">
            @if($absens->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 60px;">No</th>
                        <th>Username</th>
                        <th>Waktu Absen</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th style="width: 150px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($absens as $index => $absen)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="username-cell">{{ $absen->username }}</td>
                        <td>
                            <div class="time-cell">
                                <span class="date-text">{{ $absen->time_absen->format('d M Y') }}</span>
                                <span class="time-text">{{ $absen->time_absen->format('H:i') }} WIB</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ $absen->location }}" target="_blank" class="location-link">
                                <i class="fas fa-map-marker-alt"></i>
                                Lihat Maps
                            </a>
                        </td>
                        <td>
                            <span class="status-badge {{ $absen->status === 'success' ? 'status-success' : 'status-failed' }}">
                                <i class="fas fa-{{ $absen->status === 'success' ? 'check-circle' : 'times-circle' }}"></i>
                                {{ strtoupper($absen->status) }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <form action="{{ route('absen.destroy', $absen->id) }}" method="POST" onsubmit="return confirmDelete();" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-clipboard"></i>
                <h3>
                    @if(request('date'))
                        Tidak Ada Data Absensi
                    @else
                        Belum Ada Riwayat Absensi
                    @endif
                </h3>
                <p>
                    @if(request('date'))
                        Tidak ditemukan data absensi pada tanggal {{ \Carbon\Carbon::parse(request('date'))->format('d M Y') }}
                    @else
                        Data absensi akan muncul setelah ada yang melakukan absensi
                    @endif
                </p>
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function confirmDelete() {
        return confirm('Yakin ingin menghapus data absensi ini?\n\nData yang dihapus tidak dapat dikembalikan!');
    }

    // Auto focus on date input when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('date');
        if (!dateInput.value) {
            // Set today's date as default if no date is selected
            dateInput.value = new Date().toISOString().split('T')[0];
        }
    });
</script>
@endsection