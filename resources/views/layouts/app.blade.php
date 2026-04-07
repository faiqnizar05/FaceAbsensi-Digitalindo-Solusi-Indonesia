<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('examples/images/logo-bulat-da.jpeg') }}">
    <title>@yield('title', 'Sistem Absensi Face Recognition')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- TensorFlow.js -->
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    
    <!-- Face-api.js -->
    <script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>
    
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Knewave&display=swap');
    
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #1E1E1E;
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Background Bubbles */
        .bubble {
            position: fixed;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(59, 130, 246, 0.15), rgba(37, 99, 235, 0.05));
            filter: blur(80px);
            animation: float 25s infinite ease-in-out;
            pointer-events: none;
            z-index: 0;
        }

        .bubble1 { width: 400px; height: 400px; top: 10%; left: 5%; animation-delay: 0s; }
        .bubble2 { width: 500px; height: 500px; top: 50%; right: 5%; animation-delay: 8s; }
        .bubble3 { width: 350px; height: 350px; bottom: 15%; left: 40%; animation-delay: 16s; }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(60px, -60px) scale(1.1); }
            66% { transform: translate(-40px, 40px) scale(0.9); }
        }
        
        .namawebsite {
          font-family: 'Knewave', Sans-Serif;
        }

        /* Navbar */
        nav {
            background: rgba(30, 30, 30, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(59, 130, 246, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #3B82F6;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            transition: transform 0.3s;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .logo i {
            font-size: 1.8rem;
        }

        .hamburger {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.6rem;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.3s, transform 1.3s;
            transform:rotate(270deg);
        }

        .hamburger:hover {
            color: #3B82F6;
            transform: rotate(90deg);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 280px;
            height: 100vh;
            background: rgba(25, 25, 25, 0.98);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(59, 130, 246, 0.1);
            padding: 2rem 0;
            transition: left 0.3s ease;
            z-index: 999;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
        }

        .sidebar-logo {
            font-size: 1.3rem;
            font-weight: bold;
            color: #3B82F6;
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .close-sidebar {
            display: block;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            padding: 0.3rem;
            transition: color 0.3s;
        }

        .close-sidebar:hover {
            color: #EF4444;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0 1rem;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.9rem 1rem;
            color: #D1D5DB;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3B82F6;
        }

        .sidebar-menu a.active {
            background: rgba(59, 130, 246, 0.15);
            color: #3B82F6;
        }

        .sidebar-menu i {
            width: 20px;
            text-align: center;
        }

        /* Dropdown Menu */
        .dropdown {
            position: relative;
        }

        .dropdown > a {
            justify-content: space-between;
        }

        .dropdown-icon {
            transition: transform 0.3s;
        }

        .dropdown.active .dropdown-icon {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            list-style: none;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            padding-left: 1rem;
        }

        .dropdown.active .dropdown-menu {
            max-height: 300px;
            margin-top: 0.5rem;
        }

        .dropdown-menu a {
            padding: 0.7rem 1rem;
            font-size: 0.9rem;
        }

        /* User Role Badge */
        .user-role-badge {
            display: inline-block;
            padding: 0.3rem 0.7rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
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

        .badge-siswa {
            background: rgba(59, 130, 246, 0.2);
            color: #3B82F6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 998;
        }

        .overlay.active {
            display: block;
        }

        /* Main Content */
        main {
            flex: 1;
            position: relative;
            z-index: 1;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        .content-wrapper {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Footer */
        footer {
            background: rgba(25, 25, 25, 0.98);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(59, 130, 246, 0.1);
            padding: 3rem 2rem 1.5rem;
            position: relative;
            z-index: 1;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            color: #3B82F6;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .footer-section p {
            color: #9CA3AF;
            line-height: 1.6;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.7rem;
        }

        .footer-links a {
            color: #D1D5DB;
            text-decoration: none;
            transition: color 0.3s;
            display: inline-block;
        }

        .footer-links a:hover {
            color: #3B82F6;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #9CA3AF;
        }

        .footer-bottom a {
            color: #3B82F6;
            text-decoration: none;
        }

        .footer-bottom a:hover {
            text-decoration: underline;
        }

        /* Responsive Desktop */
        @media (min-width: 768px) {
            .hamburger {
                display: none;
            }

            .sidebar {
                left: 0;
            }

            .close-sidebar {
                display: none;
            }

            main {
                margin-left: 280px;
            }
            
            footer {
                margin-left: 280px;
            }

            .overlay {
                display: none !important;
            }
        }

        /* Responsive Mobile */
        @media (max-width: 767px) {
            .hamburger {
                display: block;
            }

            nav {
                padding: 1rem 1.5rem;
            }

            main {
                padding: 1.5rem 1rem;
            }

            .footer-container {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            footer {
                padding: 2rem 1.5rem 1rem;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.3);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(59, 130, 246, 0.5);
        }
    </style>
    @yield('styles')
    
    <script src="{{ asset('js/notification.js') }}"></script>
</head>
<body>
    <!-- Background Bubbles -->
    <div class="bubble bubble1"></div>
    <div class="bubble bubble2"></div>
    <div class="bubble bubble3"></div>

    <!-- Navbar -->
    <nav>
        <div class="nav-container">
            <a href="{{ route('absen.index') }}" class="logo">
                <em>
    <img src="{{ asset('examples/images/logo-bulat-da.jpeg') }}"
         alt="Logo Digitalindo"
         style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
</em>
                <span class="namawebsite">Digitalindo Academy!</span>
            </a>
            <button class="hamburger" id="hamburger">
                <i class="fa-solid fa-chart-simple"></i>
            </button>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <button class="close-sidebar" id="closeSidebar">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <!-- Absen - Semua Role -->
            <li>
                <a href="{{ route('absen.index') }}" class="{{ request()->routeIs('absen.index') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Absen</span>
                </a>
            </li>

            <!-- Dashboard Dropdown - Admin & Guru Only -->
            @if(Session::has('user_logged_in') && in_array(Session::get('user_role'), ['admin', 'guru']))
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <span style="display: flex; align-items: center; gap: 0.8rem;">
                        <i class="fa-solid fa-chart-bar"></i>
                        <span>Dashboard</span>
                        @if(Session::get('user_role') === 'admin')
                            <span class="user-role-badge badge-admin">ADMIN</span>
                        @elseif(Session::get('user_role') === 'guru')
                            <span class="user-role-badge badge-guru">GURU</span>
                        @endif
                    </span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('dashboard.kelas') }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Kelas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dashboard.permintaan-izin') }}">
                            <i class="fas fa-clipboard-check"></i>
                            <span>Permintaan Izin</span>
                        </a>
                    </li>
                    @if(Session::get('user_role') === 'admin')
                    <li>
                        <a href="#">
                            <i class="fas fa-database"></i>
                            <span>Backup Data</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif

            <!-- Dropdown Izin Sekolah - Semua Role -->
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <span style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-file-medical"></i>
                        <span>Izin Absensi</span>
                    </span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('izin.sakit') }}">
                            <i class="fas fa-user-injured"></i>
                            <span>Izin Sakit</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('izin.urusan-keluarga') }}">
                            <i class="fas fa-users"></i>
                            <span>Urusan Keluarga</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('izin.dispensasi') }}">
                            <i class="fas fa-clock"></i>
                            <span>Dispensasi</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Dropdown Data Management - Admin Only -->
            @if(Session::has('user_logged_in') && Session::get('user_role') === 'admin')
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <span style="display: flex; align-items: center; gap: 1rem;">
                        <i class="fas fa-database"></i>
                        <span>Data Management</span>
                    </span>
                    <i class="fas fa-chevron-down dropdown-icon"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('user.add') }}">
                            <i class="fas fa-user-plus"></i>
                            <span>Tambah Anggota</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Data Anggota</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('absen.history') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <span>Riwayat Absensi</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            <!-- Login/Logout -->
            <li>
              @if(Session::has('user_logged_in'))
              <!-- Jika sudah login, tampilkan menu Logout -->
              <form action="{{ route('logout') }}" method="POST" id="logoutForm" style="margin: 0;">
              @csrf
                <a href="#" onclick="event.preventDefault(); confirmLogout();" style="display: flex; align-items: center; gap: 1rem; padding: 0.9rem 1rem; color: #D1D5DB; text-decoration: none; border-radius: 8px; transition: all 0.3s;">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
              </form>

              <script>
                function confirmLogout() {
                  if(confirm('Apakah Anda yakin ingin keluar dari dashboard?')) {
                    document.getElementById('logoutForm').submit();
                  }
                }
              </script>
              @else
                <!-- Jika belum login, tampilkan menu Login -->
                <a href="{{ route('login') }}">
                  <i class="fas fa-sign-in-alt"></i>
                  <span>Login</span>
                </a>
              @endif
            </li>
        </ul>
    </aside>

    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Main Content -->
    <main>
      <div class="content-wrapper">
        @yield('content')
      </div>
    </main>
    
    <footer>
        <div class="footer-container">
            <div class="footer-section">
                <h3> <em>
    <img src="{{ asset('examples/images/logo-bulat-da.jpeg') }}"
         alt="Logo Digitalindo"
         style="width:50px; height:50px; object-fit:cover; border-radius:50%;">
</em> <span class="namawebsite"><span></h3>
                <p>Sistem absensi modern berbasis Mendeteksi wajah dari gambar atau kamera yang aman, cepat, dan akurat</p>
            </div>
            
            <div class="footer-section">
                <h3>Navigasi</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('absen.index') }}">Absen</a></li>
                    @if(Session::has('user_logged_in'))
                        <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        @if(Session::get('user_role') === 'admin')
                            <li><a href="{{ route('absen.history') }}">Riwayat Absensi</a></li>
                            <li><a href="{{ route('user.index') }}">Data Anggota</a></li>
                        @endif
                    @endif
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Halaman Lainnya</h3>
                <ul class="footer-links">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">About Us</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; 2025 AbsensiPintar System. Developed by <a href="https://github.com/aibyilannn" target="_blank">AibyIlann</a></p>
        </div>
    </footer>

    <script>
        // Sidebar Toggle
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const closeSidebar = document.getElementById('closeSidebar');
        const overlay = document.getElementById('overlay');

        hamburger.addEventListener('click', () => {
            sidebar.classList.add('active');
            overlay.classList.add('active');
        });

        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });

        // Dropdown Toggle
        const dropdowns = document.querySelectorAll('.dropdown-toggle');
        dropdowns.forEach(dropdown => {
            dropdown.addEventListener('click', (e) => {
                e.preventDefault();
                const parent = dropdown.closest('.dropdown');
                parent.classList.toggle('active');
            });
        });

        // Active Menu Highlight
        const currentLocation = window.location.href;
        const menuItems = document.querySelectorAll('.sidebar-menu a');
        menuItems.forEach(item => {
            if(item.href === currentLocation) {
                item.classList.add('active');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>