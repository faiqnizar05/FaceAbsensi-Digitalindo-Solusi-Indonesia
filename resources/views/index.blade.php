@extends('layouts.app')

@section('title', 'Sistem Absensi Digitalindo Academy ')

@section('styles')
<style>
    .absen-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .card {
        background: rgba(30, 30, 30, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 2rem;
        box-shadow: 0 8px 30px #1e1e1e;
    }

    .card-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .card-header h1 {
        color: #3B82F6;
        margin-bottom: 0.5rem;
    }

    .progress-bar-container {
        margin-bottom: 2rem;
    }

    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .step {
        flex: 1;
        text-align: center;
        position: relative;
    }

    .step::before {
        content: '';
        position: absolute;
        top: 15px;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(59, 130, 246, 0.2);
        z-index: -1;
    }

    .step:first-child::before {
        left: 50%;
    }

    .step:last-child::before {
        right: 50%;
    }

    .step-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: rgba(59, 130, 246, 0.3);
        border: 2px solid rgba(59, 130, 246, 0.5);
        margin: 0 auto 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .step.active .step-circle {
        background: #3B82F6;
        border-color: #3B82F6;
        box-shadow: 0 0 20px #1e1e1e;
    }

    .step.completed .step-circle {
        background: #22C55E;
        border-color: #22C55E;
    }

    .step-label {
        font-size: 0.85rem;
        color: #9CA3AF;
    }

    .step.active .step-label {
        color: #3B82F6;
        font-weight: 600;
    }

    .progress-content {
        display: none;
    }

    .progress-content.active {
        display: block;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #E5E7EB;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 8px;
        color: #fff;
        font-size: 1rem;
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: #3B82F6;
        box-shadow: 0 0 0 30px #1e1e1e;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-weight: 500;
        width: 100%;
        justify-content: center;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3B82F6, #2563EB);
        color: white;
    }

    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px #1e1e1e;
    }

    .btn-success {
        background: linear-gradient(135deg, #22C55E, #16A34A);
        color: white;
    }

    .btn-success:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px #1e1e1e;
    }

    .btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .camera-container {
        position: relative;
        width: 100%;
        max-width: 500px;
        margin: 0 auto 1rem;
        border-radius: 15px;
        overflow: hidden;
        border: 2px solid rgba(59, 130, 246, 0.3);
    }

    #video, #canvas {
        width: 100%;
        display: block;
    }

    #canvas {
        display: none;
    }

    .alert {
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.2);
        border: 1px solid #3B82F6;
        color: #3B82F6;
    }

    .alert-success {
        background: rgba(34, 197, 94, 0.2);
        border: 1px solid #22C55E;
        color: #22C55E;
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid #EF4444;
        color: #EF4444;
    }

    .alert-warning {
        background: rgba(251, 146, 60, 0.2);
        border: 1px solid #FB923C;
        color: #FB923C;
    }

    .loading {
        text-align: center;
        padding: 2rem;
        color: #9CA3AF;
    }

    .loading i {
        font-size: 2rem;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        100% { transform: rotate(360deg); }
    }

    .location-info {
        background: rgba(59, 130, 246, 0.1);
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
        display: none;
    }

    .location-info.active {
        display: block;
    }

    .location-info p {
        margin: 0.5rem 0;
        color: #E5E7EB;
    }
</style>
@endsection

@section('content')
<div class="absen-container">
    <div class="card">
        <div class="card-header">
            <h1><i class="fas fa-fingerprint"></i> Sistem Absensi Digitalindo Academy</h1>
            <p style="color: #9CA3AF;">Silakan ikuti langkah-langkah untuk melakukan absensi</p>
        </div>

     <div class="progress-bar-container">
    <div class="progress-steps">

        <div class="step active" id="step1">
            <div class="step-circle">
                <i class="fas fa-id-card"></i>
            </div>

            <div class="step-label">
                No Register
            </div>
        </div>

        <div class="step" id="step2">
            <div class="step-circle">
                <i class="fas fa-camera"></i>
            </div>

            <div class="step-label">
                Verifikasi Wajah
            </div>
        </div>

    </div>
</div>


<div class="progress-content active" id="content1">

    <div class="alert alert-info">

        <i class="fas fa-info-circle"></i>

        <span>
            Masukkan No Register Anda untuk melanjutkan
        </span>

    </div>


    <div class="form-group">

        <label for="register">

            <i class="fas fa-id-card"></i>

            No Register

        </label>

        <input
            type="text"
            id="register"
            class="form-control"
            placeholder="Masukkan No Register Anda"
            autocomplete="off"
        >

    </div>


    <button
        type="button"
        class="btn btn-primary"
        id="btnGetLocation"
    >

        <i class="fas fa-map-marker-alt"></i>

        Validasi & Ambil Lokasi

    </button>


    <div
        class="location-info"
        id="locationInfo"
    >

        <p>

            <strong>

                <i class="fas fa-check-circle"></i>

                Data Valid & Lokasi Berhasil Diambil!

            </strong>

        </p>

        <p id="locationText"></p>

        <p id="distanceText"></p>

    </div>

</div>


<div class="progress-content" id="content2">

    <div class="alert alert-info">

        <i class="fas fa-info-circle"></i>

        <span>
            Posisikan wajah Anda di depan kamera untuk verifikasi
        </span>

    </div>


    <div class="camera-container">

        <video
            id="video"
            autoplay
            muted
            playsinline
        ></video>

        <canvas id="canvas"></canvas>

    </div>


    <div
        id="loadingModels"
        class="loading"
    >

        <i class="fas fa-spinner"></i>

        <p>Memuat model AI...</p>

    </div>


    <button
        type="button"
        class="btn btn-success"
        id="btnCapture"
        disabled
    >

        <i class="fas fa-camera"></i>

        Ambil Foto & Verifikasi

    </button>

</div>
    </div>
</div>

<script>
    // =========================================================
    // SETTING LOKASI
    // =========================================================

    const CENTER_LAT = -6.425838;
    const CENTER_LNG = 106.866504;

    // 100 KM - untuk testing
    const MAX_RADIUS_METERS = 100000;


    // =========================================================
    // VARIABLE
    // =========================================================

    let currentStep = 1;

    // SUDAH DIGANTI DARI USERNAME MENJADI REGISTER
    let register = '';

    let latitude = null;
    let longitude = null;

    let referenceImage = null;

    let video = null;
    let canvas = null;

    let modelsLoaded = false;


    // =========================================================
    // DOM READY
    // =========================================================

    document.addEventListener('DOMContentLoaded', function () {

        const btnLocation =
            document.getElementById('btnGetLocation');

        const btnCapture =
            document.getElementById('btnCapture');


        if (btnLocation) {
            btnLocation.addEventListener(
                'click',
                getLocationAndValidate
            );
        }


        if (btnCapture) {
            btnCapture.addEventListener(
                'click',
                captureAndVerify
            );
        }

    });


    // =========================================================
    // HITUNG JARAK
    // =========================================================

    function calculateDistance(
        lat1,
        lon1,
        lat2,
        lon2
    ) {

        const R = 6371e3;

        const φ1 =
            lat1 * Math.PI / 180;

        const φ2 =
            lat2 * Math.PI / 180;

        const Δφ =
            (lat2 - lat1) * Math.PI / 180;

        const Δλ =
            (lon2 - lon1) * Math.PI / 180;


        const a =
            Math.sin(Δφ / 2) *
            Math.sin(Δφ / 2)
            +
            Math.cos(φ1) *
            Math.cos(φ2) *
            Math.sin(Δλ / 2) *
            Math.sin(Δλ / 2);


        const c =
            2 *
            Math.atan2(
                Math.sqrt(a),
                Math.sqrt(1 - a)
            );


        return R * c;
    }


    // =========================================================
    // VALIDASI REGISTER + GPS
    // =========================================================

    async function getLocationAndValidate() {

        // Ambil No Register
        const registerInput =
            document.getElementById('register');


        if (!registerInput) {

            showAlert(
                'error',
                'Input No Register tidak ditemukan!'
            );

            return;
        }


        register =
            registerInput.value.trim();


        // =====================================================
        // VALIDASI REGISTER
        // =====================================================

        if (!register) {

            showAlert(
                'error',
                'Silakan isi No Register terlebih dahulu!'
            );

            registerInput.focus();

            return;
        }


        // =====================================================
        // BUTTON LOADING
        // =====================================================

        const btn =
            document.getElementById(
                'btnGetLocation'
            );


        btn.disabled = true;

        btn.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...';


        // =====================================================
        // CEK GEOLOCATION
        // =====================================================

        if (!navigator.geolocation) {

            showAlert(
                'error',
                'Browser tidak mendukung Geolocation!'
            );


            btn.disabled = false;

            btn.innerHTML =
                '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';

            return;
        }


        navigator.geolocation.getCurrentPosition(

            async function (position) {

                try {

                    // =================================================
                    // AMBIL GPS
                    // =================================================

                    latitude =
                        position.coords.latitude;

                    longitude =
                        position.coords.longitude;


                    // =================================================
                    // HITUNG JARAK
                    // =================================================

                    const distance =
                        calculateDistance(
                            CENTER_LAT,
                            CENTER_LNG,
                            latitude,
                            longitude
                        );


                    // =================================================
                    // CEK RADIUS
                    // =================================================

                    if (
                        distance >
                        MAX_RADIUS_METERS
                    ) {

                        showAlert(
                            'error',
                            `Lokasi Anda terlalu jauh! (${distance.toFixed(0)}m). Maksimal ${MAX_RADIUS_METERS} meter.`
                        );


                        btn.disabled = false;

                        btn.innerHTML =
                            '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';

                        return;
                    }


                    // =================================================
                    // TAMPILKAN LOKASI
                    // =================================================

                    const locationText =
                        document.getElementById(
                            'locationText'
                        );


                    const distanceText =
                        document.getElementById(
                            'distanceText'
                        );


                    const locationInfo =
                        document.getElementById(
                            'locationInfo'
                        );


                    if (locationText) {

                        locationText.textContent =
                            `Lat: ${latitude.toFixed(6)}, Long: ${longitude.toFixed(6)}`;

                    }


                    if (distanceText) {

                        distanceText.textContent =
                            `Jarak: ${distance.toFixed(2)} meter (Toleransi OK) ✓`;

                    }


                    if (locationInfo) {

                        locationInfo.classList.add(
                            'active'
                        );

                    }


                    // =================================================
                    // CEK REGISTER KE DATABASE
                    // =================================================

                    await checkRegister();


                } catch (error) {

                    console.error(error);

                    showAlert(
                        'error',
                        'Terjadi kesalahan: ' +
                        error.message
                    );


                    btn.disabled = false;

                    btn.innerHTML =
                        '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';

                }

            },


            function (error) {

                let message =
                    'Gagal mengambil lokasi.';


                if (error.code === 1) {

                    message =
                        'Izin lokasi ditolak. Silakan aktifkan lokasi pada browser.';

                } else if (error.code === 2) {

                    message =
                        'Lokasi tidak tersedia.';

                } else if (error.code === 3) {

                    message =
                        'Waktu mengambil lokasi habis.';

                } else {

                    message +=
                        ' ' +
                        error.message;

                }


                showAlert(
                    'error',
                    message
                );


                btn.disabled = false;

                btn.innerHTML =
                    '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';

            },

            {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            }

        );

    }


    // =========================================================
    // CEK NO REGISTER KE DATABASE
    // =========================================================

    async function checkRegister() {

        try {

            const response =
                await fetch(
                    '{{ route("absen.checkUsername") }}',
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .content

                        },

                        body:
                            JSON.stringify({

                                register:
                                    register

                            })

                    }
                );


            const data =
                await response.json();


            console.log(
                'Response Register:',
                data
            );


            // =====================================================
            // REGISTER DITEMUKAN
            // =====================================================

            if (data.status) {

                // Simpan foto referensi
                referenceImage =
                    data.data.image;


                showAlert(
                    'success',
                    'No Register ditemukan! Menuju verifikasi wajah...'
                );


                setTimeout(
                    function () {

                        goToStep(2);

                        initCamera();

                    },
                    1500
                );


            } else {

                // =================================================
                // REGISTER TIDAK DITEMUKAN
                // =================================================

                showAlert(
                    'error',
                    data.message ||
                    'No Register tidak ditemukan!'
                );


                const btn =
                    document.getElementById(
                        'btnGetLocation'
                    );


                btn.disabled = false;

                btn.innerHTML =
                    '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';

            }


        } catch (error) {

            console.error(
                'Check Register Error:',
                error
            );


            showAlert(
                'error',
                'Terjadi kesalahan: ' +
                error.message
            );


            const btn =
                document.getElementById(
                    'btnGetLocation'
                );


            btn.disabled = false;

            btn.innerHTML =
                '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';

        }

    }


    // =========================================================
    // AKSES KAMERA
    // =========================================================

    async function initCamera() {

        video =
            document.getElementById(
                'video'
            );


        if (!video) {

            showAlert(
                'error',
                'Element kamera tidak ditemukan!'
            );

            return;
        }


        try {

            const stream =
                await navigator.mediaDevices.getUserMedia({

                    video: {

                        width: {
                            ideal: 640
                        },

                        height: {
                            ideal: 480
                        }

                    },

                    audio: false

                });


            video.srcObject =
                stream;


            window.localStream =
                stream;


            await loadModels();


        } catch (error) {

            console.error(error);


            showAlert(
                'error',
                'Gagal mengakses kamera: ' +
                error.message
            );

        }

    }


    // =========================================================
    // LOAD FACE API MODEL
    // =========================================================

    async function loadModels() {

        try {

            const MODEL_URL =
                '/models';


            await faceapi.nets
                .tinyFaceDetector
                .loadFromUri(
                    MODEL_URL
                );


            await faceapi.nets
                .faceLandmark68Net
                .loadFromUri(
                    MODEL_URL
                );


            await faceapi.nets
                .faceRecognitionNet
                .loadFromUri(
                    MODEL_URL
                );


            modelsLoaded =
                true;


            const loading =
                document.getElementById(
                    'loadingModels'
                );


            const btn =
                document.getElementById(
                    'btnCapture'
                );


            if (loading) {

                loading.style.display =
                    'none';

            }


            if (btn) {

                btn.disabled =
                    false;

            }


            showAlert(
                'success',
                'Model AI Siap!'
            );


        } catch (error) {

            console.error(error);


            showAlert(
                'error',
                'Gagal memuat model: ' +
                error.message
            );

        }

    }


    // =========================================================
    // FACE ID
    // =========================================================

    async function captureAndVerify() {

        if (!modelsLoaded) {

            showAlert(
                'error',
                'Model AI belum siap!'
            );

            return;
        }


        const btn =
            document.getElementById(
                'btnCapture'
            );


        btn.disabled =
            true;


        btn.innerHTML =
            '<i class="fas fa-spinner fa-spin"></i> Memverifikasi...';


        try {

            // =====================================================
            // DETEKSI WAJAH DARI KAMERA
            // =====================================================

            const detections =
                await faceapi
                    .detectSingleFace(
                        video,
                        new faceapi
                            .TinyFaceDetectorOptions()
                    )
                    .withFaceLandmarks()
                    .withFaceDescriptor();


            if (!detections) {

                showAlert(
                    'error',
                    'Wajah tidak terdeteksi! Pastikan wajah terlihat jelas di kamera.'
                );


                btn.disabled =
                    false;


                btn.innerHTML =
                    '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';


                return;
            }


            // =====================================================
            // CEK FOTO REFERENSI
            // =====================================================

            if (!referenceImage) {

                showAlert(
                    'error',
                    'Foto referensi tidak ditemukan!'
                );


                btn.disabled =
                    false;

                return;
            }


            // =====================================================
            // LOAD FOTO REFERENSI
            // =====================================================

            const referenceImg =
                await faceapi.fetchImage(
                    referenceImage
                );


            const referenceDetection =
                await faceapi
                    .detectSingleFace(
                        referenceImg,
                        new faceapi
                            .TinyFaceDetectorOptions()
                    )
                    .withFaceLandmarks()
                    .withFaceDescriptor();


            if (!referenceDetection) {

                showAlert(
                    'error',
                    'Gagal mendeteksi wajah referensi!'
                );


                btn.disabled =
                    false;


                btn.innerHTML =
                    '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';


                return;
            }


            // =====================================================
            // HITUNG FACE DISTANCE
            // =====================================================

            const distance =
                faceapi.euclideanDistance(
                    detections.descriptor,
                    referenceDetection.descriptor
                );


            // =====================================================
            // HITUNG SIMILARITY
            // =====================================================

            const similarity =
                ((1 - distance) * 100)
                    .toFixed(2);


            console.log(
                'Face Distance:',
                distance
            );


            console.log(
                'Face Similarity:',
                similarity + '%'
            );


            // =====================================================
            // BATAS KECocokan
            // =====================================================

            const status =
                similarity >= 50
                    ? 'success'
                    : 'failed';


            // =====================================================
            // SUBMIT ABSENSI
            // =====================================================

            await submitAbsen(
                status
            );


        } catch (error) {

            console.error(error);


            showAlert(
                'error',
                'Error: ' +
                error.message
            );


            btn.disabled =
                false;


            btn.innerHTML =
                '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';

        }

    }


    // =========================================================
    // SUBMIT ABSENSI
    // =========================================================

    async function submitAbsen(status) {

        try {

            const response =
                await fetch(
                    '{{ route("absen.submit") }}',
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                    .querySelector(
                                        'meta[name="csrf-token"]'
                                    )
                                    .content

                        },


                        // =================================================
                        // YANG DIKIRIM SEKARANG ADALAH REGISTER
                        // =================================================

                        body:
                            JSON.stringify({

                                register:
                                    register,

                                latitude:
                                    latitude,

                                longitude:
                                    longitude,

                                status:
                                    status

                            })

                    }
                );


            const data =
                await response.json();


            console.log(
                'Submit Absen:',
                data
            );


            showAlert(

                data.status
                    ? 'success'
                    : 'error',

                data.message

            );


            // =====================================================
            // ABSEN BERHASIL
            // =====================================================

            if (
                data.status &&
                status === 'success'
            ) {

                setTimeout(
                    function () {

                        window.location.href =
                            '{{ route("dashboard") }}';

                    },
                    2000
                );


            } else {

                // =================================================
                // ABSEN GAGAL
                // =================================================

                setTimeout(
                    function () {

                        window.location.reload();

                    },
                    2000
                );

            }


        } catch (error) {

            console.error(error);


            showAlert(
                'error',
                'Submit Gagal: ' +
                error.message
            );

        }

    }


    // =========================================================
    // PINDAH STEP
    // =========================================================

    function goToStep(step) {

        currentStep =
            step;


        for (
            let i = 1;
            i <= 2;
            i++
        ) {

            const stepEl =
                document.getElementById(
                    'step' + i
                );


            const contentEl =
                document.getElementById(
                    'content' + i
                );


            if (!stepEl || !contentEl) {
                continue;
            }


            // STEP SEBELUMNYA
            if (i < step) {

                stepEl.classList.add(
                    'completed'
                );

                stepEl.classList.remove(
                    'active'
                );

                contentEl.classList.remove(
                    'active'
                );

            }

            // STEP AKTIF
            else if (i === step) {

                stepEl.classList.add(
                    'active'
                );

                stepEl.classList.remove(
                    'completed'
                );

                contentEl.classList.add(
                    'active'
                );

            }

            // STEP BERIKUTNYA
            else {

                stepEl.classList.remove(
                    'active'
                );

                stepEl.classList.remove(
                    'completed'
                );

                contentEl.classList.remove(
                    'active'
                );

            }

        }

    }


    // =========================================================
    // ALERT
    // =========================================================

    function showAlert(
        type,
        message
    ) {

        const alertDiv =
            document.createElement(
                'div'
            );


        alertDiv.className =
            `alert alert-${
                type === 'error'
                    ? 'error'
                    : type
            }`;


        alertDiv.innerHTML =
            `<span>${message}</span>`;


        const container =
            document.querySelector(
                '.progress-content.active'
            );


        if (container) {

            container.insertBefore(
                alertDiv,
                container.firstChild
            );


            setTimeout(
                function () {

                    if (
                        alertDiv &&
                        alertDiv.parentNode
                    ) {

                        alertDiv.remove();

                    }

                },
                5000
            );

        }

    }

</script>
@endsection