# 📱 Face Absensi System

Sistem absensi berbasis **pengenalan wajah (Face Recognition)** yang dibangun menggunakan **Laravel**, **Node.js**, dan **MySQL**.

Project ini dirancang untuk membantu proses absensi menjadi lebih cepat, efisien, dan akurat dengan memanfaatkan teknologi **computer vision**.  
Pengguna cukup menampilkan wajahnya ke kamera, dan sistem akan secara otomatis mengenali identitas serta mencatat waktu kehadiran mereka.

## Login Dashboard Admin
- username: admin
- password: admin123

## Requirements

- PHP >= 8.0
- Composer
- Node.js >= 16.x
- MySQL >= 5.7
- Laravel >= 11.x

## Instalasi

```bash
git clone https://github.com/AibyIlannn/FaceAbsensi.git
cd FaceAbsensi
```

### 2️⃣ Install Dependencies

```bash
composer install
```

### 3️⃣ Setup Database

Buat database baru di MySQL:

```sql
CREATE DATABASE absensi_db;
```

### 4️⃣ Konfigurasi Environment

Copy file environment example:

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=absensi_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5️⃣ Generate Application Key

```bash
php artisan key:generate --force
```

### 6️⃣ Migrasi & Seeding Database

Jalankan migrasi untuk membuat tabel dan seeding data awal:

```bash
php artisan migrate
php artisan db:seed
php artisan migrate:fresh --seed
```

### 7️⃣ Clear Cache & Optimize

```bash
php artisan optimize:clear
```

## 🎮 Cara Menjalankan

### Verifikasi Prerequisites

Pastikan semua software terinstall dengan benar:

```bash
# Cek versi PHP
php -v

# Cek versi Composer
composer -v

# Cek versi Node.js
node -v
```

### Jalankan Development Server

Buka terminal dan jalankan:

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

## 📁 Struktur Project

```
FaceAbsensi/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/               # Eloquent Models
│   └── Services/             # Business Logic
├── database/
│   ├── migrations/           # Database Migrations
│   └── seeders/              # Database Seeders
├── public/                   # Public Assets
├── resources/
│   ├── views/                # Blade Templates
│   └── js/                   # JavaScript Files
├── routes/
│   └── web.php               # Web Routes
└── .env                      # Environment Configuration
```

## 🔧 Troubleshooting

### Error saat instalasi Composer?
```bash
composer update --ignore-platform-reqs
```

### Error Database Connection?
- Pastikan MySQL service berjalan
- Cek konfigurasi database di file `.env`
- Verifikasi username dan password MySQL

### Error Permission Denied?
```bash
chmod -R 775 storage bootstrap/cache
```

### Cache Issue?
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## 📞 Butuh Bantuan?

Jika mengalami kendala atau error selama instalasi/penggunaan:

📱 **WhatsApp:** [+62 895-3866-92667](https://wa.me/6289538669267)

Jelaskan masalah Anda dengan detail agar dapat dibantu lebih cepat!

## 📝 Changelog

### Version 1.0.0 (Initial Release)
- ✅ Sistem autentikasi user
- ✅ Face recognition untuk absensi
- ✅ Dashboard analytics
- ✅ Manajemen data user
- ✅ Riwayat absensi

## 📄 License

Project ini menggunakan lisensi MIT. Bebas digunakan untuk keperluan pembelajaran dan pengembangan.

## 🌟 Credits

**Developed with ❤️ by:**

**[AibyIlannn](https://github.com/AibyIlannn)**

[![GitHub](https://img.shields.io/badge/GitHub-AibyIlannn-black?logo=github)](https://github.com/AibyIlannn)
[![WhatsApp](https://img.shields.io/badge/WhatsApp-Contact-green?logo=whatsapp)](https://wa.me/6289538669267)

---

⭐ **Jangan lupa berikan star jika project ini membantu!** ⭐# FaceAbsensi-Digitalindo-Solusi-Indonesia
