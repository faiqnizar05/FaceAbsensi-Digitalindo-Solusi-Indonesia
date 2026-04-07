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
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="step-label">Username & Kelas</div>
                </div>
                <div class="step" id="step2">
                    <div class="step-circle">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div class="step-label">Verifikasi Wajah</div>
                </div>
            </div>
        </div>

        <div class="progress-content active" id="content1">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <span>Masukkan username dan kelas Anda untuk melanjutkan</span>
            </div>

            <div class="form-group">
                <label for="username"><i class="fas fa-user"></i> Username</label>
                <input type="text" id="username" class="form-control" placeholder="Masukkan username Anda">
            </div>

            <div class="form-group">
                <label for="kelas"><i class="fas fa-graduation-cap"></i>Program</label>
                <input type="text" id="kelas" class="form-control" placeholder="Contoh: Peserta Reguler Content Creator">
            </div>

            <button type="button" class="btn btn-primary" id="btnGetLocation">
                <i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi
            </button>

            <div class="location-info" id="locationInfo">
                <p><strong><i class="fas fa-check-circle"></i> Data Valid & Lokasi Berhasil Diambil!</strong></p>
                <p id="locationText"></p>
                <p id="distanceText"></p>
            </div>
        </div>

        <div class="progress-content" id="content2">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <span>Posisikan wajah Anda di depan kamera untuk verifikasi</span>
            </div>

            <div class="camera-container">
                <video id="video" autoplay muted playsinline></video>
                <canvas id="canvas"></canvas>
            </div>

            <div id="loadingModels" class="loading">
                <i class="fas fa-spinner"></i>
                <p>Memuat model AI...</p>
            </div>

            <button type="button" class="btn btn-success" id="btnCapture" disabled>
                <i class="fas fa-camera"></i> Ambil Foto & Verifikasi
            </button>
        </div>
    </div>
</div>

<script>
    // --- UPDATE KOORDINAT KE JATIJAJAR ---
    const CENTER_LAT = -6.425838;
    const CENTER_LNG = 106.866504;
    
    // --- RADIUS DIPERLEBAR JADI 100 KM SUPAYA BISA TES DARI RUMAH ---
    const MAX_RADIUS_METERS = 100000; 

    let currentStep = 1;
    let username = '';
    let kelas = '';
    let latitude = null;
    let longitude = null;
    let referenceImage = null;
    let video = null;
    let canvas = null;
    let modelsLoaded = false;

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('btnGetLocation').addEventListener('click', getLocationAndValidate);
        document.getElementById('btnCapture').addEventListener('click', captureAndVerify);
    });

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; 
        const φ1 = lat1 * Math.PI / 180;
        const φ2 = lat2 * Math.PI / 180;
        const Δφ = (lat2 - lat1) * Math.PI / 180;
        const Δλ = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        return R * c; 
    }

    async function getLocationAndValidate() {
        username = document.getElementById('username').value.trim();
        kelas = document.getElementById('kelas').value.trim();

        if (!username || !kelas) {
            showAlert('error', 'Silakan isi username dan kelas!');
            return;
        }

        document.getElementById('btnGetLocation').disabled = true;
        document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                async function(position) {
                    latitude = position.coords.latitude;
                    longitude = position.coords.longitude;

                    const distance = calculateDistance(CENTER_LAT, CENTER_LNG, latitude, longitude);

                    if (distance > MAX_RADIUS_METERS) {
                        showAlert('error', `Lokasi Anda terlalu jauh! (${distance.toFixed(0)}m). Maksimal ${MAX_RADIUS_METERS} meter.`);
                        document.getElementById('btnGetLocation').disabled = false;
                        document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';
                        return;
                    }

                    document.getElementById('locationText').textContent = `Lat: ${latitude.toFixed(6)}, Long: ${longitude.toFixed(6)}`;
                    document.getElementById('distanceText').textContent = `Jarak: ${distance.toFixed(2)} meter (Toleransi OK) ✓`;
                    document.getElementById('locationInfo').classList.add('active');

                    await checkUsernameAndKelas();
                },
                function(error) {
                    showAlert('error', 'Gagal mengambil lokasi: ' + error.message);
                    document.getElementById('btnGetLocation').disabled = false;
                    document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';
                }
            );
        } else {
            showAlert('error', 'Browser tidak mendukung Geolocation!');
            document.getElementById('btnGetLocation').disabled = false;
        }
    }

    async function checkUsernameAndKelas() {
        try {
            const response = await fetch('{{ route("absen.checkUsername") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ username: username, kelas: kelas })
            });

            const data = await response.json();

            if (data.status) {
                referenceImage = data.data.image;
                showAlert('success', 'Data valid! Menuju verifikasi wajah...');
                setTimeout(() => {
                    goToStep(2);
                    initCamera();
                }, 1500);
            } else {
                showAlert('error', data.message);
                document.getElementById('btnGetLocation').disabled = false;
                document.getElementById('btnGetLocation').innerHTML = '<i class="fas fa-map-marker-alt"></i> Validasi & Ambil Lokasi';
            }
        } catch (error) {
            showAlert('error', 'Terjadi kesalahan: ' + error.message);
            document.getElementById('btnGetLocation').disabled = false;
        }
    }

    async function initCamera() {
        video = document.getElementById('video');
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { width: { ideal: 640 }, height: { ideal: 480 } } 
            });
            video.srcObject = stream;
            window.localStream = stream;
            await loadModels();
        } catch (error) {
            showAlert('error', 'Gagal mengakses kamera: ' + error.message);
        }
    }

    async function loadModels() {
        try {
            const MODEL_URL = '/models';
            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
            await faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URL);
            await faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URL);

            modelsLoaded = true;
            document.getElementById('loadingModels').style.display = 'none';
            document.getElementById('btnCapture').disabled = false;
            showAlert('success', 'Model AI Siap!');
        } catch (error) {
            showAlert('error', 'Gagal memuat model: ' + error.message);
        }
    }

    async function captureAndVerify() {
        if (!modelsLoaded) return;
        document.getElementById('btnCapture').disabled = true;
        document.getElementById('btnCapture').innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memverifikasi...';

        try {
            const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();

            if (!detections) {
                showAlert('error', 'Wajah tidak terdeteksi!');
                document.getElementById('btnCapture').disabled = false;
                document.getElementById('btnCapture').innerHTML = '<i class="fas fa-camera"></i> Ambil Foto & Verifikasi';
                return;
            }

            const referenceImg = await faceapi.fetchImage(referenceImage);
            const referenceDetection = await faceapi.detectSingleFace(referenceImg, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks().withFaceDescriptor();

            if (!referenceDetection) {
                showAlert('error', 'Gagal mendeteksi wajah referensi!');
                document.getElementById('btnCapture').disabled = false;
                return;
            }

            const distance = faceapi.euclideanDistance(detections.descriptor, referenceDetection.descriptor);
            const similarity = ((1 - distance) * 100).toFixed(2);
            const status = similarity >= 50 ? 'success' : 'failed';

            await submitAbsen(status);

        } catch (error) {
            showAlert('error', 'Error: ' + error.message);
            document.getElementById('btnCapture').disabled = false;
        }
    }

    async function submitAbsen(status) {
        try {
            const response = await fetch('{{ route("absen.submit") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    username: username,
                    latitude: latitude,
                    longitude: longitude,
                    status: status
                })
            });

            const data = await response.json();
            showAlert(data.status ? 'success' : 'error', data.message);
            
            if (data.status && status === 'success') {
                setTimeout(() => { window.location.href = '{{ route("dashboard") }}'; }, 2000);
            } else {
                setTimeout(() => { window.location.reload(); }, 2000);
            }
        } catch (error) {
            showAlert('error', 'Submit Gagal: ' + error.message);
        }
    }

    function goToStep(step) {
        currentStep = step;
        for (let i = 1; i <= 2; i++) {
            const stepEl = document.getElementById('step' + i);
            const contentEl = document.getElementById('content' + i);
            if (i < step) {
                stepEl.classList.add('completed');
                stepEl.classList.remove('active');
                contentEl.classList.remove('active');
            } else if (i === step) {
                stepEl.classList.add('active');
                contentEl.classList.add('active');
            }
        }
    }

    function showAlert(type, message) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'error' : type}`;
        alertDiv.innerHTML = `<span>${message}</span>`;
        const container = document.querySelector('.progress-content.active');
        container.insertBefore(alertDiv, container.firstChild);
        setTimeout(() => { alertDiv.remove(); }, 5000);
    }
</script>
@endsection