# 🎫 Ticketing Football UAS

<div align="center">
  Aplikasi pemesanan tiket pertandingan sepak bola berbasis Laravel, lengkap dengan integrasi payment gateway Midtrans.  
  <br />
  <a href="https://github.com/Blueberry221/ticketing_football_uas"><strong>Explore the Docs »</strong></a>
  <br />
  <br />
  · 🏗 Proyek UAS Mata Kuliah Platform  
  · ⚽ Tiket & Tim  
  · 📱 Midtrans Snap Payment
</div>

---

## 📖 Tentang Proyek

_Ticketing Football UAS_ adalah aplikasi berbasis web yang memudahkan pengguna untuk memesan tiket pertandingan sepak bola secara online. Dibangun menggunakan Laravel dan terintegrasi dengan Midtrans sebagai solusi pembayaran.

Fitur utama:

-   Registrasi dan login pengguna
-   Pemesanan tiket pertandingan
-   Pembayaran online via Midtrans (Snap)
-   Berita dan highlights pertandingan
-   Daftar tim peserta

---

## ⚙ Dibangun Dengan

| Teknologi                                    | Keterangan                   |
| -------------------------------------------- | ---------------------------- |
| [Laravel](https://laravel.com/)              | Backend Framework PHP        |
| [Midtrans](https://midtrans.com)             | Payment Gateway              |
| [Blade](https://laravel.com/docs/10.x/blade) | Templating engine            |
| [Bootstrap](https://getbootstrap.com/)       | UI Styling (opsional)        |
| MySQL                                        | Basis data lokal (via XAMPP) |

---

## 🚀 Memulai

### 📋 Prasyarat

Pastikan Anda sudah menginstal:

-   PHP >= 8.1
-   Composer
-   Node.js & npm
-   MySQL (melalui XAMPP atau sejenis)

### 💾 Instalasi

1. _Clone repo_

bash
git clone https://github.com/username/ticketing_football_uas.git
cd ticketing_football_uas

2. _Install dependency_

bash
composer install
npm install

3. _Copy file .env & generate key_

bash
copy .env.example .env
php artisan key:generate

4. _Setup database_

-   Jalankan XAMPP → Aktifkan MySQL
-   Buat database baru, contoh: ticketing_football
-   Edit file .env:

env
DB_DATABASE=ticketing_football
DB_USERNAME=root
DB_PASSWORD=

5. _Setup Midtrans_

-   Daftar akun di [Midtrans Sandbox](https://dashboard.sandbox.midtrans.com/)
-   Ambil _CLIENT_KEY_ dan _SERVER_KEY_
-   Tambahkan ke .env:

env
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_IS_PRODUCTION=false

6. _Migrasi database_

bash
php artisan migrate

7. _Jalankan server_

bash
php artisan serve

---

## 🧑‍💻 Penggunaan

Setelah server berjalan:

-   Daftar dan login sebagai pengguna
-   Pilih pertandingan dan pesan tiket
-   Lanjutkan ke checkout dan lakukan pembayaran via Midtrans Snap popup

---

## 📁 Struktur Proyek

```bash
📦 root/
├── 📁 app/
│   ├── 📁 Http/
│   │   ├── 📁 Controllers/
│   │   │   ├── 📁 Auth/
│   │   │   │   └── AreasController.php
│   │   │   ├── Controller.php
│   │   │   ├── MatchesController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── SeatsController.php
│   │   │   ├── TeamsController.php
│   │   │   ├── TicketController.php
│   │   │   └── UsersController.php
│   │   ├── 📁 Middleware/
│   │   └── 📁 Requests/
│   ├── 📁 Models/
│   ├── 📁 Providers/
│   └── 📁 View/
│
├── 📁 bootstrap/
│   └── 📁 cache/
│       ├── app.php
│       └── providers.php
│
├── 📁 config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── midtrans.php
│   ├── queue.php
│   ├── sanctum.php
│   ├── services.php
│   └── session.php
│
├── 📁 database/
│   ├── 📁 factories/
│   ├── 📁 migrations/
│   └── 📁 seeders/
│
├── 📁 public/
│
├── 📁 resources/
│   ├── 📁 css/
│   ├── 📁 js/
│   └── 📁 views/
│       ├── 📁 auth/
│       ├── 📁 components/
│       ├── 📁 layouts/
│       ├── 📁 order/
│       ├── 📁 profile/
│       └── 📁 tickets/
│           ├── dashboard.blade.php
│           ├── schedule.blade.php
│           └── welcome.blade.php
│
├── 📁 routes/
│   ├── api.php
│   ├── auth.php
│   ├── console.php
│   └── web.php
│
├── 📁 storage/
├── 📁 tests/
├── 📁 vendor/
│
│
│
├── composer.json
├── package.json
```

## 💳 Testing Pembayaran

1. Lakukan pemesanan seperti biasa
2. Di halaman checkout, Midtrans Snap akan muncul sebagai popup
3. Ikuti alur pembayaran via sandbox (gunakan kartu demo)

> Pastikan internet aktif agar Midtrans Snap dapat muncul dengan sempurna

---

## 🚨 Catatan Produksi

-   Ubah .env menjadi:

env
MIDTRANS_IS_PRODUCTION=true

-   Gunakan _Client Key_ dan _Server Key_ dari dashboard _Midtrans Production_

---

## 👥 Kontributor

-   Dennis /235314119
-   Mosses /235314092
-   Alogo /235314089
-   Calvin /235314116
-   Eto /235314118
