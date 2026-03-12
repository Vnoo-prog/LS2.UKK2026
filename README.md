

##  Fitur Utama

Aplikasi ini menggunakan arsitektur *Role-Based Access Control* (RBAC) yang membagi hak akses menjadi 3 level pengguna:

###  1. Admin
* **Manajemen Pengguna:** Menambahkan dan menghapus (memecat) akun Petugas.
* **Katalog Buku:** Mengelola data buku (CRUD) beserta jumlah stok fisik.
* **Laporan Terintegrasi:** Melihat seluruh riwayat transaksi, memfilter berdasarkan tanggal, dan mencetak laporan ke format PDF/Printer.
* **Persetujuan (Approval):** Menerima atau menolak pengajuan pengembalian buku dari siswa/peminjam.

###  2. Petugas
* **Katalog Buku:** Menambah, mengedit, dan menghapus data buku.
* **Validasi Pengembalian:** Memverifikasi pengembalian buku fisik, yang otomatis akan mengembalikan stok buku ke dalam sistem.
* **Sistem Denda Otomatis:** Sistem secara otomatis menghitung denda keterlambatan (Rp 1.000/hari) saat petugas menyetujui pengembalian yang melewati tenggat waktu (7 hari).
* **Cetak Laporan:** Memiliki akses penuh ke fitur filter dan cetak laporan peminjaman.

###  3. Peminjam (Siswa/Anggota)
* **Eksplorasi Katalog:** Melihat daftar buku yang tersedia lengkap dengan informasi sisa stok.
* **Peminjaman Cerdas:** Meminjam buku dengan 1 klik. Sistem otomatis menolak jika stok habis atau jika peminjam mencoba meminjam buku yang sama lebih dari satu kali secara bersamaan.
* **Riwayat & Pengembalian:** Melacak status peminjaman dan menekan tombol "Ajukan Pengembalian" saat ingin mengembalikan buku fisik ke perpustakaan.
* **Ulasan & Rating (Review):** Memberikan rating (Bintang 1-5) dan ulasan pada buku. (Fitur ini terkunci dan hanya terbuka jika *user* sudah pernah meminjam buku tersebut).

###  Keamanan & Logika Sistem
* **Anti-Back History:** Implementasi *middleware* khusus yang mencegah pengguna kembali ke halaman *dashboard* setelah melakukan *logout* menggunakan tombol *Back* pada *browser*.
* **Real-time Stock Management:** Stok buku berkurang otomatis saat dipinjam dan bertambah otomatis saat pengembalian disetujui petugas.

---

##  Teknologi yang Digunakan

* **Backend:** PHP 8.x, Laravel 11/12
* **Frontend:** HTML5, CSS3, Bootstrap 5, Blade Templating
* **Database:** MySQL
* **Lainnya:** Carbon (Manipulasi Tanggal), JavaScript (Print Interface)

---

##  Panduan Instalasi (Lokal)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di komputer lokal Anda:

1. **Clone Repository / Siapkan Folder Project**
   Pastikan Anda sudah menginstal PHP, Composer, dan XAMPP (atau sejenisnya).

2. **Instal Dependensi**
   Buka terminal di dalam folder project dan jalankan:
   ```bash
   composer install

```

3. **Konfigurasi Environment**
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env

```


Buka file `.env` dan sesuaikan koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Dipus
DB_USERNAME=root
DB_PASSWORD=

```


4. **Generate Application Key**
```bash
php artisan key:generate

```


5. **Migrasi dan Seeding Database**
Perintah ini akan membuat struktur tabel beserta akun Admin *default*:
```bash
php artisan migrate:fresh --seed

```


6. **Jalankan Server Lokal**
```bash
php artisan serve

```


Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

---

##  Akun Default (Testing)

Setelah menjalankan proses *seeding*, Anda dapat masuk menggunakan akun Admin utama berikut:

* **Username:** `min`
* **Password:** `123`
* **Role:** Admin

*(Catatan: Aplikasi ini dirancang menggunakan plain-text password sesuai spesifikasi awal kebutuhan project agar mempermudah pengujian saat sidang/demo).*
