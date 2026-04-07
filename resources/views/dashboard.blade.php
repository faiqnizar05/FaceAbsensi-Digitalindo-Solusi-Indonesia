@extends('layouts.app')

@section('title', 'Dashboard - AbsensiPintar')

@section('styles')
<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .welcome-card {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 3rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px #1e1e1e;
        text-align: center;
    }

    .welcome-card h1 {
        color: #3B82F6;
        font-size: 2.5rem;
        margin-bottom: 1rem;
    }

    .welcome-card p {
        color: #9CA3AF;
        font-size: 1.1rem;
    }

    .role-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        margin-top: 1rem;
    }

    .badge-admin {
        background: rgba(239, 68, 68, 0.2);
        color: #EF4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    .badge-guru {
        background: rgba(34, 197, 94, 0.2);
        color: #22C55E;
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .menu-card {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s;
        text-decoration: none;
        display: block;
    }

    .menu-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(59, 130, 246, 0.3);
        border-color: #3B82F6;
    }

    .menu-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #3B82F6;
    }

    .menu-card h3 {
        color: #fff;
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }

    .menu-card p {
        color: #9CA3AF;
        font-size: 0.9rem;
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

    .alert-success {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #22C55E;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="welcome-card">
        <h1>
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </h1>
        <p>Selamat datang, <strong>{{ $username }}</strong>!</p>
        
        @if($role === 'admin')
            <span class="role-badge badge-admin">
                <i class="fas fa-user-shield"></i> ADMIN UTAMA
            </span>
        @elseif($role === 'guru')
            <span class="role-badge badge-guru">
                <i class="fas fa-chalkboard-teacher"></i> WALI KELAS {{ $kelas_wali }}
            </span>
        @endif
    </div>

    <div class="menu-grid">
        <a href="{{ route('dashboard.kelas') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
            <h3>Data Kelas</h3>
            <p>Lihat data absensi siswa hari ini</p>
        </a>

        <a href="{{ route('dashboard.permintaan-izin') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <h3>Permintaan Izin</h3>
            <p>Approve/reject izin siswa</p>
        </a>

        @if($role === 'admin')
        <a href="{{ route('user.add') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <h3>Tambah Anggota</h3>
            <p>Daftarkan siswa baru</p>
        </a>

        <a href="{{ route('user.index') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-users"></i>
            </div>
            <h3>Data Anggota</h3>
            <p>Kelola data siswa</p>
        </a>

        <a href="{{ route('absen.history') }}" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-history"></i>
            </div>
            <h3>Riwayat Absensi</h3>
            <p>Lihat riwayat absensi lengkap</p>
        </a>

        <a href="#" class="menu-card">
            <div class="menu-icon">
                <i class="fas fa-download"></i>
            </div>
            <h3>Backup Data</h3>
            <p>Export dan backup data</p>
        </a>
        @endif
    </div>
</div>
@endsection