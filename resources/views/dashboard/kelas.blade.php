@extends('layouts.app')

@section('title', 'Dashboard Kelas - AbsensiPintar')

@section('styles')
<style>
    .dashboard-container {
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

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(59, 130, 246, 0.2);
    }

    .stat-card .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .stat-card.hadir .icon { color: #22C55E; }
    .stat-card.terlambat .icon { color: #FB923C; }
    .stat-card.izin .icon { color: #3B82F6; }
    .stat-card.tidak-masuk .icon { color: #EF4444; }

    .stat-card .number {
        font-size: 2rem;
        font-weight: bold;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .stat-card .label {
        color: #9CA3AF;
        font-size: 0.9rem;
    }

    .table-section {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
        overflow-x: auto;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .table-header h2 {
        color: #3B82F6;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        margin: 0;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background: rgba(59, 130, 246, 0.1);
    }

    .table th {
        padding: 1rem;
        text-align: left;
        color: #3B82F6;
        font-weight: 600;
        border-bottom: 2px solid rgba(59, 130, 246, 0.3);
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: #D1D5DB;
    }

    .table tbody tr {
        transition: all 0.3s;
    }

    .table tbody tr:hover {
        background: rgba(59, 130, 246, 0.05);
    }

    .user-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(59, 130, 246, 0.3);
    }

    .status-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .badge-hadir {
        background: rgba(34, 197, 94, 0.2);
        color: #22C55E;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .badge-terlambat {
        background: rgba(251, 146, 60, 0.2);
        color: #FB923C;
        border: 1px solid rgba(251, 146, 60, 0.3);
    }

    .badge-tidak-masuk {
        background: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .badge-izin {
        background: rgba(59, 130, 246, 0.2);
        color: #3B82F6;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }

    .no-data {
        text-align: center;
        padding: 3rem;
        color: #9CA3AF;
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .table-section {
            padding: 1rem;
        }

        .table {
            font-size: 0.85rem;
        }

        .table th, .table td {
            padding: 0.7rem 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <div class="page-header">
        <h1>
            <i class="fas fa-chalkboard-teacher"></i> 
            Dashboard Kelas {{ $kelasWali ?? 'Semua Kelas' }}
        </h1>
        <p style="color: #9CA3AF; margin: 0.5rem 0 0 0;">
            Data absensi hari ini - {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
        </p>
    </div>

    <!-- Statistik -->
    <div class="stats-grid">
        <div class="stat-card hadir">
            <div class="icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="number">{{ $stats['hadir'] }}</div>
            <div class="label">Hadir</div>
        </div>

        <div class="stat-card terlambat">
            <div class="icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="number">{{ $stats['terlambat'] }}</div>
            <div class="label">Terlambat</div>
        </div>

        <div class="stat-card izin">
            <div class="icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="number">{{ $stats['izin'] }}</div>
            <div class="label">Izin</div>
        </div>

        <div class="stat-card tidak-masuk">
            <div class="icon">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="number">{{ $stats['tidak_masuk'] }}</div>
            <div class="label">Tidak Masuk</div>
        </div>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="table-section">
        <div class="table-header">
            <h2>
                <i class="fas fa-list"></i> Data Absensi Siswa
            </h2>
        </div>

        @if($absensiToday->count() > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Username</th>
                    <th>Kelas</th>
                    <th>Waktu Absen</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensiToday as $index => $absen)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($absen->user && $absen->user->image)
                            <img src="{{ asset($absen->user->image) }}" alt="{{ $absen->username }}" class="user-photo">
                        @else
                            <div style="width: 50px; height: 50px; border-radius: 50%; background: rgba(59, 130, 246, 0.2); display: flex; align-items: center; justify-content: center; border: 2px solid rgba(59, 130, 246, 0.3);">
                                <i class="fas fa-user" style="color: #3B82F6;"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $absen->username }}</td>
                    <td>{{ $absen->kelas }}</td>
                    <td>
                        @if($absen->waktu_absen)
                            {{ \Carbon\Carbon::parse($absen->waktu_absen)->format('H:i') }}
                        @else
                            <span style="color: #6B7280;">-</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $badgeClass = 'badge-tidak-masuk';
                            if ($absen->status_absen === 'hadir') $badgeClass = 'badge-hadir';
                            elseif ($absen->status_absen === 'terlambat') $badgeClass = 'badge-terlambat';
                            elseif (in_array($absen->status_absen, ['izin_sakit', 'urusan_keluarga', 'dispensasi'])) $badgeClass = 'badge-izin';
                        @endphp
                        <span class="status-badge {{ $badgeClass }}">
                            {{ $absen->getStatusText() }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            <i class="fas fa-inbox"></i>
            <p>Belum ada data absensi hari ini</p>
        </div>
        @endif
    </div>
</div>
@endsection