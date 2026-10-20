@extends('layouts.app')

@section('title', 'Riwayat Absensi - FaceAbsen')

@section('styles')

<style>

    .page-container {
        max-width: 1600px;
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


    /* ============================= */
    /* FILTER */
    /* ============================= */

    .filter-section {

        background: rgba(30, 30, 30, 0.8);

        backdrop-filter: blur(10px);

        border: 1px solid rgba(59, 130, 246, 0.3);

        border-radius: 15px;

        padding: 1.5rem;

        margin-bottom: 2rem;
    }

    .filter-form {

        display: flex;

        align-items: end;

        gap: 1rem;

        flex-wrap: wrap;
    }

    .form-group {

        display: flex;

        flex-direction: column;

        gap: 0.5rem;
    }

    .form-group label {

        color: #D1D5DB;

        font-size: 0.9rem;

        font-weight: 500;
    }

    .form-control {

        padding: 0.7rem 1rem;

        background: rgba(255, 255, 255, 0.05);

        border: 1px solid rgba(59, 130, 246, 0.3);

        border-radius: 8px;

        color: white;

        min-width: 220px;
    }

    .form-control:focus {

        outline: none;

        border-color: #3B82F6;

        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .btn-filter {

        padding: 0.7rem 1.5rem;

        background: linear-gradient(
            135deg,
            #3B82F6,
            #2563EB
        );

        color: white;

        border: none;

        border-radius: 8px;

        cursor: pointer;

        font-weight: 500;

        display: inline-flex;

        align-items: center;

        gap: 0.5rem;
    }

    .btn-filter:hover {

        transform: translateY(-1px);

        box-shadow: 0 5px 15px rgba(
            59,
            130,
            246,
            0.3
        );
    }

    .btn-reset {

        padding: 0.7rem 1.5rem;

        background: rgba(
            107,
            114,
            128,
            0.2
        );

        color: #D1D5DB;

        border: 1px solid rgba(
            107,
            114,
            128,
            0.3
        );

        border-radius: 8px;

        text-decoration: none;

        display: inline-flex;

        align-items: center;

        gap: 0.5rem;
    }

    .btn-reset:hover {
        color: white;
        background: rgba(107, 114, 128, 0.3);
    }


    /* ============================= */
    /* EXCEL BUTTON */
    /* ============================= */

    .btn-excel {

        padding: 0.7rem 1.3rem;

        background: linear-gradient(
            135deg,
            #16A34A,
            #15803D
        );

        color: white;

        border: none;

        border-radius: 8px;

        text-decoration: none;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 0.5rem;

        font-weight: 600;

        cursor: pointer;

        transition: all 0.3s ease;
    }

    .btn-excel:hover {

        color: white;

        transform: translateY(-2px);

        box-shadow:
            0 5px 15px rgba(
                22,
                163,
                74,
                0.35
            );
    }


    /* ============================= */
    /* ALERT */
    /* ============================= */

    .alert {

        padding: 1rem 1.5rem;

        border-radius: 10px;

        margin-bottom: 1.5rem;

        display: flex;

        align-items: center;

        gap: 0.7rem;
    }

    .alert-success {

        background: rgba(
            34,
            197,
            94,
            0.15
        );

        border: 1px solid rgba(
            34,
            197,
            94,
            0.3
        );

        color: #22C55E;
    }

    .alert-error {

        background: rgba(
            239,
            68,
            68,
            0.15
        );

        border: 1px solid rgba(
            239,
            68,
            68,
            0.3
        );

        color: #EF4444;
    }


    /* ============================= */
    /* TABLE */
    /* ============================= */

    .section {

        background: rgba(
            30,
            30,
            30,
            0.8
        );

        backdrop-filter: blur(10px);

        border: 1px solid rgba(
            59,
            130,
            246,
            0.3
        );

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

    .table-container {

        overflow-x: auto;

        margin-top: 1rem;
    }

    table {

        width: 100%;

        border-collapse: collapse;

        min-width: 1200px;
    }

    thead {

        background: rgba(
            59,
            130,
            246,
            0.1
        );
    }

    th {

        padding: 1rem;

        text-align: left;

        font-weight: 600;

        color: #3B82F6;

        border-bottom: 2px solid rgba(
            59,
            130,
            246,
            0.3
        );

        white-space: nowrap;
    }

    td {

        padding: 1rem;

        border-bottom: 1px solid rgba(
            59,
            130,
            246,
            0.1
        );

        color: #D1D5DB;

        vertical-align: middle;
    }

    tbody tr {

        transition: all 0.3s;
    }

    tbody tr:hover {

        background: rgba(
            59,
            130,
            246,
            0.05
        );
    }


    /* ============================= */
    /* REGISTER */
    /* ============================= */

    .register-badge {

        display: inline-block;

        padding: 0.4rem 0.7rem;

        background: rgba(
            59,
            130,
            246,
            0.15
        );

        border: 1px solid rgba(
            59,
            130,
            246,
            0.3
        );

        border-radius: 6px;

        color: #60A5FA;

        font-weight: 600;
    }


    /* ============================= */
    /* JAM */
    /* ============================= */

    .jam-absen {

        display: inline-flex;

        align-items: center;

        gap: 0.4rem;

        padding: 0.5rem 0.8rem;

        background: rgba(
            34,
            197,
            94,
            0.12
        );

        border: 1px solid rgba(
            34,
            197,
            94,
            0.25
        );

        border-radius: 7px;

        color: #4ADE80;

        font-weight: 700;

        font-size: 0.95rem;
    }


    /* ============================= */
    /* STATUS */
    /* ============================= */

    .status-success {

        display: inline-flex;

        align-items: center;

        gap: 0.4rem;

        padding: 0.45rem 0.8rem;

        background: rgba(
            34,
            197,
            94,
            0.15
        );

        border: 1px solid rgba(
            34,
            197,
            94,
            0.3
        );

        color: #22C55E;

        border-radius: 6px;

        font-size: 0.85rem;

        font-weight: 600;
    }

    .status-failed {

        display: inline-flex;

        align-items: center;

        gap: 0.4rem;

        padding: 0.45rem 0.8rem;

        background: rgba(
            239,
            68,
            68,
            0.15
        );

        border: 1px solid rgba(
            239,
            68,
            68,
            0.3
        );

        color: #EF4444;

        border-radius: 6px;

        font-size: 0.85rem;

        font-weight: 600;
    }


    /* ============================= */
    /* MAPS */
    /* ============================= */

    .btn-maps {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 0.4rem;

        padding: 0.5rem 0.8rem;

        background: #2563EB;

        color: white;

        border-radius: 6px;

        text-decoration: none;

        font-size: 0.85rem;

        font-weight: 500;

        transition: all 0.3s;
    }

    .btn-maps:hover {

        background: #1D4ED8;

        color: white;

        transform: translateY(-1px);

        box-shadow: 0 5px 12px rgba(
            37,
            99,
            235,
            0.3
        );
    }


    /* ============================= */
    /* DELETE */
    /* ============================= */

    .btn-danger {

        background: rgba(
            239,
            68,
            68,
            0.15
        );

        border: 1px solid rgba(
            239,
            68,
            68,
            0.3
        );

        color: #EF4444;

        padding: 0.5rem 0.8rem;

        border-radius: 6px;

        font-size: 0.85rem;

        cursor: pointer;

        transition: all 0.3s;

        display: inline-flex;

        align-items: center;

        gap: 0.4rem;
    }

    .btn-danger:hover {

        background: rgba(
            239,
            68,
            68,
            0.25
        );

        transform: translateY(-1px);
    }


    /* ============================= */
    /* EMPTY */
    /* ============================= */

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


    /* ============================= */
    /* RESPONSIVE */
    /* ============================= */

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

        .filter-form {

            flex-direction: column;

            align-items: stretch;
        }

        .form-control {

            width: 100%;

            min-width: unset;
        }

        .btn-filter,
        .btn-reset {

            justify-content: center;

            width: 100%;
        }

        .section-header {

            flex-direction: column;

            align-items: stretch;
        }

        .btn-excel {

            width: 100%;
        }

    }

</style>

@endsection


@section('content')

<div class="page-container">


    {{-- ============================================ --}}
    {{-- HEADER --}}
    {{-- ============================================ --}}

    <div class="page-header">

        <div class="page-title">

            <h1>

                <i class="fas fa-clock"></i>

                Riwayat Absensi

            </h1>

            <p>

                Data riwayat absensi peserta

            </p>

        </div>


        <div class="stats-card">

            <span class="stats-number">

                {{ $absens->count() }}

            </span>

            <span class="stats-label">

                <i class="fas fa-user-check"></i>

                Total Absensi

            </span>

        </div>

    </div>


    {{-- ============================================ --}}
    {{-- SUCCESS --}}
    {{-- ============================================ --}}

    @if(session('success'))

        <div class="alert alert-success">

            <i class="fas fa-check-circle"></i>

            <span>

                {{ session('success') }}

            </span>

        </div>

    @endif


    {{-- ============================================ --}}
    {{-- ERROR --}}
    {{-- ============================================ --}}

    @if(session('error'))

        <div class="alert alert-error">

            <i class="fas fa-exclamation-circle"></i>

            <span>

                {{ session('error') }}

            </span>

        </div>

    @endif


    {{-- ============================================ --}}
    {{-- FILTER TANGGAL --}}
    {{-- ============================================ --}}
<style>
    /* =========================================
       FILTER SECTION - DARK BLUE MODERN
    ========================================= */

    .filter-section {
        width: 100%;
        margin-bottom: 25px;
        padding: 24px;
        background: linear-gradient(
            135deg,
            #0b1220 0%,
            #111827 100%
        );
        border: 1px solid #1e3a5f;
        border-radius: 16px;
        box-shadow:
            0 10px 30px rgba(0, 0, 0, 0.25),
            inset 0 1px 0 rgba(255, 255, 255, 0.03);
    }


    /* =========================================
       FORM
    ========================================= */

    .filter-form {
        display: grid;
        grid-template-columns:
            minmax(180px, 1fr)
            minmax(180px, 1fr)
            minmax(180px, 1fr)
            auto
            auto;

        gap: 16px;
        align-items: end;
    }


    /* =========================================
       FILTER GROUP
    ========================================= */

    .filter-group,
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }


    /* =========================================
       LABEL
    ========================================= */

    .filter-group label,
    .form-group label {
        display: flex;
        align-items: center;
        gap: 7px;

        color: #dbeafe;
        font-size: 13px;
        font-weight: 600;

        margin: 0;
    }


    .filter-group label i,
    .form-group label i {
        color: #3b82f6;
        font-size: 14px;
    }


    /* =========================================
       INPUT & SELECT
    ========================================= */

    .filter-input,
    .form-control {
        width: 100%;
        height: 46px;

        padding: 0 14px;

        color: #f8fafc;
        background: #0f172a;

        border: 1px solid #263b57;
        border-radius: 10px;

        outline: none;

        font-size: 14px;

        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }


    .filter-input:hover,
    .form-control:hover {
        border-color: #2563eb;
        background: #111c30;
    }


    .filter-input:focus,
    .form-control:focus {
        border-color: #3b82f6;

        background: #0b1528;

        box-shadow:
            0 0 0 3px rgba(59, 130, 246, 0.15),
            0 0 15px rgba(37, 99, 235, 0.08);
    }


    /* =========================================
       SELECT ARROW
    ========================================= */

    select.filter-input {
        cursor: pointer;
        appearance: auto;
    }


    select.filter-input option {
        background: #0f172a;
        color: #f8fafc;
    }


    /* =========================================
       DATE INPUT
    ========================================= */

    input[type="date"],
    input[type="month"] {
        color-scheme: dark;
    }


    /* =========================================
       BUTTON FILTER
    ========================================= */

    .btn-filter {
        height: 46px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 0 20px;

        border: 0;
        border-radius: 10px;

        color: #ffffff;
        background: linear-gradient(
            135deg,
            #2563eb,
            #1d4ed8
        );

        font-size: 14px;
        font-weight: 600;

        cursor: pointer;

        box-shadow:
            0 5px 15px rgba(37, 99, 235, 0.25);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;
    }


    .btn-filter:hover {
        transform: translateY(-2px);

        background: linear-gradient(
            135deg,
            #3b82f6,
            #2563eb
        );

        box-shadow:
            0 8px 20px rgba(37, 99, 235, 0.35);
    }


    .btn-filter:active {
        transform: translateY(0);
    }


    .btn-filter i {
        font-size: 13px;
    }


    /* =========================================
       BUTTON RESET
    ========================================= */

    .btn-reset {
        height: 46px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 8px;

        padding: 0 18px;

        border-radius: 10px;

        color: #cbd5e1;
        background: #111827;

        border: 1px solid #334155;

        text-decoration: none;

        font-size: 14px;
        font-weight: 600;

        transition:
            all 0.2s ease;
    }


    .btn-reset:hover {
        color: #ffffff;

        background: #1e293b;

        border-color: #3b82f6;

        transform: translateY(-2px);
    }


    .btn-reset i {
        color: #60a5fa;
    }


    /* =========================================
       RESPONSIVE - TABLET
    ========================================= */

    @media (max-width: 1100px) {

        .filter-form {
            grid-template-columns:
                repeat(2, 1fr);
        }

        .btn-filter,
        .btn-reset {
            width: 100%;
        }
    }


    /* =========================================
       RESPONSIVE - MOBILE
    ========================================= */

    @media (max-width: 650px) {

        .filter-section {
            padding: 18px;
            border-radius: 12px;
        }

        .filter-form {
            grid-template-columns: 1fr;
            gap: 14px;
        }

        .filter-input,
        .form-control,
        .btn-filter,
        .btn-reset {
            height: 44px;
        }
    }
</style>


<div class="filter-section">

    <form
        action="{{ route('absen.history') }}"
        method="GET"
        class="filter-form"
    >

        {{-- =========================================
             FILTER DEPARTEMENT
        ========================================== --}}

        <div class="filter-group">

            <label for="departement">

                <i class="fas fa-building"></i>

                Departement

            </label>


            <select
                id="departement"
                name="departement"
                class="filter-input"
            >

                <option value="">
                    Semua Departement
                </option>


                @foreach($departements as $departement)

                    <option
                        value="{{ $departement }}"
                        {{ request('departement') == $departement ? 'selected' : '' }}
                    >
                        {{ $departement }}
                    </option>

                @endforeach

            </select>

        </div>


        {{-- =========================================
             FILTER BULAN
        ========================================== --}}

        <div class="filter-group">

            <label for="month">

                <i class="fas fa-calendar-alt"></i>

                Bulan

            </label>


            <input
                type="month"
                id="month"
                name="month"
                class="filter-input"
                value="{{ request('month') }}"
            >

        </div>


        {{-- =========================================
             FILTER TANGGAL
        ========================================== --}}

        <div class="form-group">

            <label for="date">

                <i class="fas fa-calendar"></i>

                Filter Tanggal Absensi

            </label>


            <input
                type="date"
                name="date"
                id="date"
                class="form-control"
                value="{{ request('date') }}"
            >

        </div>


        {{-- =========================================
             BUTTON FILTER
        ========================================== --}}

        <button
            type="submit"
            class="btn-filter"
        >

            <i class="fas fa-filter"></i>

            Filter

        </button>


        {{-- =========================================
             BUTTON RESET
        ========================================== --}}

        <a
            href="{{ route('absen.history') }}"
            class="btn-reset"
        >

            <i class="fas fa-rotate-left"></i>

            Reset

        </a>

    </form>

</div>


    {{-- ============================================ --}}
    {{-- TABLE --}}
    {{-- ============================================ --}}

    <div class="section">

        <div class="section-header">

            <h2>

                <i class="fas fa-list"></i>

                Data Absensi

            </h2>


            {{-- ======================================== --}}
            {{-- DOWNLOAD EXCEL --}}
            {{-- ======================================== --}}

            <a
                href="{{ route('absen.export.excel', request()->query()) }}"
                class="btn-excel"
                title="Download data absensi ke Excel"
            >

                <i class="fas fa-file-excel"></i>

                Download Excel

            </a>

        </div>


        <div class="table-container">

            @if($absens->count() > 0)

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
                                Waktu Absen
                            </th>

                            <th>
                                Jam
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Maps
                            </th>

                            <th style="text-align:center;">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($absens as $index => $absen)

                            <tr>


                                {{-- ================= --}}
                                {{-- NO --}}
                                {{-- ================= --}}

                                <td>

                                    {{ $index + 1 }}

                                </td>


                                {{-- ================= --}}
                                {{-- REGISTER --}}
                                {{-- ================= --}}

                                <td>

                                    <span class="register-badge">

                                        {{ $absen->register ?? '-' }}

                                    </span>

                                </td>


                                {{-- ================= --}}
                                {{-- DEPARTEMENT --}}
                                {{-- ================= --}}

                                <td>

                                    {{ $absen->user->departement ?? '-' }}

                                </td>


                                {{-- ================= --}}
                                {{-- NAMA --}}
                                {{-- ================= --}}

                                <td>

                                    <strong>

                                        {{ $absen->user->nama ?? '-' }}

                                    </strong>

                                </td>


                                {{-- ================= --}}
                                {{-- TELEPON --}}
                                {{-- ================= --}}

                                <td>

                                    {{ $absen->user->no_telepon ?? '-' }}

                                </td>


                                {{-- ================= --}}
                                {{-- TANGGAL MULAI --}}
                                {{-- ================= --}}

                                <td>

                                    @if(
                                        $absen->user &&
                                        $absen->user->tanggal_mulai
                                    )

                                        {{ \Carbon\Carbon::parse(
                                            $absen->user->tanggal_mulai
                                        )->format('d-m-Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- ================= --}}
                                {{-- WAKTU ABSEN --}}
                                {{-- ================= --}}

                                <td>

                                    @if($absen->time_absen)

                                        {{ $absen->time_absen->format('d-m-Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- ================= --}}
                                {{-- JAM --}}
                                {{-- ================= --}}

                                <td>

                                    @if($absen->time_absen)

                                        <span class="jam-absen">

                                            <i class="fas fa-clock"></i>

                                            {{ $absen->time_absen->format('H:i:s') }}

                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- ================= --}}
                                {{-- STATUS --}}
                                {{-- ================= --}}

                                <td>

                                    @if($absen->status === 'success')

                                        <span class="status-success">

                                            <i class="fas fa-check-circle"></i>

                                            Berhasil

                                        </span>

                                    @else

                                        <span class="status-failed">

                                            <i class="fas fa-times-circle"></i>

                                            Gagal

                                        </span>

                                    @endif

                                </td>


                                {{-- ================= --}}
                                {{-- MAPS --}}
                                {{-- ================= --}}

                                <td>

                                    @if($absen->location)

                                        <a
                                            href="{{ $absen->location }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="btn-maps"
                                        >

                                            <i class="fas fa-map-marker-alt"></i>

                                            Maps

                                        </a>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- ================= --}}
                                {{-- AKSI --}}
                                {{-- ================= --}}

                                <td style="text-align:center;">

                                    <form
                                        action="{{ route(
                                            'absen.destroy',
                                            $absen->id
                                        ) }}"
                                        method="POST"
                                        onsubmit="return confirmDelete()"
                                        style="display:inline;"
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


                {{-- ================================= --}}
                {{-- EMPTY --}}
                {{-- ================================= --}}

                <div class="empty-state">

                    <i class="fas fa-calendar-xmark"></i>

                    <h3>

                        Belum Ada Data Absensi

                    </h3>

                    <p>

                        Belum terdapat data absensi
                        untuk tanggal yang dipilih.

                    </p>

                </div>

            @endif

        </div>

    </div>


</div>


<script>

    function confirmDelete()
    {

        return confirm(
            'Yakin ingin menghapus data absensi ini?\n\n' +
            'Data yang dihapus tidak dapat dikembalikan!'
        );

    }

</script>

@endsection