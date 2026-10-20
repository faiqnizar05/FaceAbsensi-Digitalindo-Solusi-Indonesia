@extends('layouts.app')

@section('title', 'Data Anggota - FaceAbsen')

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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .page-title {
        flex: 1;
    }

    .page-title h1 {
        color: #3B82F6;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .page-title p {
        color: #9CA3AF;
        margin: 0;
    }

    .stats-card {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 1.5rem 2rem;
        text-align: center;
        min-width: 200px;
    }

    .stats-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #3B82F6;
        display: block;
        margin-bottom: 0.3rem;
    }

    .stats-label {
        color: #D1D5DB;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
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

    /* ==============================
       TOMBOL TAMBAH
    ============================== */

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        color: white;
    }

    /* ==============================
       TOMBOL EXPORT EXCEL
    ============================== */

    .btn-excel {
        display: inline-flex;
        align-items: center;
        gap: 0.7rem;
        padding: 0.7rem 1.5rem;
        background: linear-gradient(135deg, #16A34A, #15803D);
        color: white;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-excel:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(22, 163, 74, 0.3);
        color: white;
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

    .user-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-image {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #3B82F6;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        color: #E5E7EB;
        margin-bottom: 0.2rem;
    }

    .user-id {
        font-size: 0.85rem;
        color: #9CA3AF;
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

    .empty-state p {
        margin-bottom: 1.5rem;
    }

    /* ==============================
       RESPONSIVE
    ============================== */

    @media (max-width: 768px) {

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            padding: 1.5rem;
        }

        .stats-card {
            width: 100%;
        }

        .section {
            padding: 1.5rem;
        }

        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .button-group {
            width: 100%;
            flex-direction: column;
        }

        .btn-add,
        .btn-excel {
            width: 100%;
            justify-content: center;
        }

        table {
            font-size: 0.9rem;
        }

        th,
        td {
            padding: 0.7rem 0.5rem;
        }

        .user-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endsection


@section('content')

<div class="page-container">

    <!-- ==========================================
         HEADER
    =========================================== -->

    <div class="page-header">

        <div class="page-title">

            <h1>
                <i class="fas fa-users"></i>
                Data Anggota
            </h1>

            <p>
                Kelola data anggota terdaftar di sistem
            </p>

        </div>


        <!-- JUMLAH ANGGOTA -->

        <div class="stats-card">

            <span class="stats-number">
                {{ $users->count() }}
            </span>

            <span class="stats-label">

                <i class="fas fa-user-check"></i>

                Anggota Terdaftar

            </span>

        </div>

    </div>


    <!-- ==========================================
         ALERT SUCCESS
    =========================================== -->

    @if(session('success'))

        <div class="alert alert-success">

            <i class="fas fa-check-circle"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    <!-- ==========================================
         ALERT ERROR
    =========================================== -->

    @if(session('error'))

        <div class="alert alert-error">

            <i class="fas fa-exclamation-circle"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    <!-- ==========================================
         DATA ANGGOTA
    =========================================== -->

    <div class="section">

        <div class="section-header">

            <h2>
                <i class="fas fa-list"></i>
                Daftar Anggota
            </h2>


            <!-- BUTTON GROUP -->

            <div
                class="button-group"
                style="
                    display: flex;
                    gap: 0.8rem;
                    flex-wrap: wrap;
                "
            >

                <!-- ==================================
                     TAMBAH ANGGOTA
                =================================== -->

                <a
                    href="{{ route('user.add') }}"
                    class="btn-add"
                >

                    <i class="fas fa-plus"></i>

                    Tambah Anggota

                </a>


                <!-- ==================================
                     DOWNLOAD EXCEL
                =================================== -->

                <a
                    href="{{ route('user.export.excel') }}"
                    class="btn-excel"
                >

                    <i class="fas fa-file-excel"></i>

                    Download Excel

                </a>

            </div>

        </div>


        <!-- ==========================================
             TABLE
        =========================================== -->

        <div class="table-container">

            @if($users->count() > 0)

                <table>

                    <thead>

                        <tr>

                            <th style="width: 60px;">
                                No
                            </th>

                            <th>
                                No Register
                            </th>

                            <th>
                                Departement
                            </th>

                            <th>
                                Nama
                            </th>

                            <th>
                                No Telepon
                            </th>

                            <th>
                                Tanggal Mulai
                            </th>

                            <th>
                                Foto
                            </th>

                            <th
                                style="
                                    width: 150px;
                                    text-align: center;
                                "
                            >
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($users as $index => $user)

                            <tr>

                                <!-- NO -->

                                <td>
                                    {{ $index + 1 }}
                                </td>


                                <!-- NO REGISTER -->

                                <td>
                                    {{ $user->register ?? '-' }}
                                </td>


                                <!-- DEPARTEMENT -->

                                <td>
                                    {{ $user->departement ?? '-' }}
                                </td>


                                <!-- NAMA -->

                                <td>

                                    <div class="user-info">

                                        @if($user->image)

                                            <img
                                                src="{{ asset($user->image) }}"
                                                alt="{{ $user->nama }}"
                                                class="user-image"
                                            >

                                        @endif


                                        <div class="user-details">

                                            <span class="user-name">
                                                {{ $user->nama ?? '-' }}
                                            </span>


                                            <span class="user-id">

                                                ID:

                                                #{{ str_pad(
                                                    $user->id,
                                                    4,
                                                    '0',
                                                    STR_PAD_LEFT
                                                ) }}

                                            </span>

                                        </div>

                                    </div>

                                </td>


                                <!-- NO TELEPON -->

                                <td>
                                    {{ $user->no_telepon ?? '-' }}
                                </td>


                                <!-- TANGGAL MULAI -->

                                <td>

                                    @if($user->tanggal_mulai)

                                        {{ \Carbon\Carbon::parse(
                                            $user->tanggal_mulai
                                        )->format('d-m-Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <!-- FOTO -->

                                <td>

                                    @if($user->image)

                                        <img
                                            src="{{ asset($user->image) }}"
                                            alt="Foto {{ $user->nama }}"
                                            style="
                                                width: 50px;
                                                height: 50px;
                                                object-fit: cover;
                                                border-radius: 8px;
                                                border: 2px solid #3B82F6;
                                            "
                                        >

                                    @else

                                        <span>
                                            -
                                        </span>

                                    @endif

                                </td>


                                <!-- AKSI -->

                                <td style="text-align: center;">

                                    <form
                                        action="{{ route(
                                            'user.destroy',
                                            $user->id
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirmDelete(
                                            '{{ $user->nama }}'
                                        );"
                                        style="display: inline;"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn-danger"
                                        >

                                            <i class="fas fa-trash"></i>

                                            Hapus

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <!-- ======================================
                     EMPTY STATE
                ======================================= -->

                <div class="empty-state">

                    <i class="fas fa-user-slash"></i>

                    <h3>
                        Belum Ada Anggota Terdaftar
                    </h3>

                    <p>
                        Silakan tambah anggota baru untuk memulai
                    </p>

                    <a
                        href="{{ route('user.add') }}"
                        class="btn-add"
                    >

                        <i class="fas fa-plus"></i>

                        Tambah Anggota Pertama

                    </a>

                </div>

            @endif

        </div>

    </div>

</div>


<!-- ==========================================
     JAVASCRIPT
=========================================== -->

<script>

    function confirmDelete(username) {

        return confirm(
            `Yakin ingin menghapus anggota "${username}"?\n\n` +
            `Data yang dihapus tidak dapat dikembalikan!`
        );

    }

</script>

@endsection