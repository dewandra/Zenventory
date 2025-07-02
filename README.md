# WMS Pro - Warehouse Management System

Sistem manajemen gudang standalone untuk operasional yang presisi dengan metode FIFO/FEFO, dibangun menggunakan Laravel & Livewire.

---

## 📖 Deskripsi Singkat

WMS Pro adalah aplikasi web yang dirancang untuk menggantikan pengelolaan inventaris manual atau berbasis Spreadsheet. Sistem ini ditujukan untuk UKM dan distributor yang sedang bertumbuh, yang membutuhkan kontrol, akurasi, dan efisiensi dalam operasional gudang mereka. Proyek ini mengimplementasikan disiplin dan visibilitas setara sistem enterprise tanpa memerlukan investasi pada hardware scanner atau integrasi software eksternal yang mahal.

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

* **Backend**: Laravel 11
* **Frontend**: Livewire 3 & Tailwind CSS
* **Database**: MySQL

---

## ✨ Fitur Utama (Key Features)

### Manajamen Data Master
* **Produk**: CRUD untuk produk, termasuk SKU, nama, satuan, dan penanda **wajib tanggal kedaluwarsa**.
* **Lokasi (Topologi Gudang)**: Pengelolaan hierarki gudang secara detail (`Zone > Aisle > Rack > Bin`) untuk penempatan barang yang presisi.
* **Pengguna & Peran**: Manajemen user dan hak akses (Admin, Manager, Staff).

### Proses Inbound (Penerimaan Barang)
* **Pencatatan Penerimaan**: Mencatat barang masuk berdasarkan Purchase Order (PO).
* **Generasi LPN (License Plate Number)**: Sistem otomatis membuat kode unik (LPN) untuk setiap batch barang yang diterima.
* **Put-Away Terarah (Directed Put-Away)**: Sistem secara cerdas memberikan rekomendasi lokasi penyimpanan (bin) terbaik untuk setiap LPN.

### Proses Outbound (Pengeluaran Barang)
* **Manajemen Pesanan**: Mencatat Sales Order (SO) dari customer.
* **Alokasi Stok Otomatis (FIFO/FEFO)**: Otak sistem yang secara otomatis memilih batch LPN tertua atau dengan tanggal kedaluwarsa terdekat.
* **Wave Picking**: Kemampuan untuk mengelompokkan beberapa pesanan untuk di-pick secara bersamaan demi efisiensi.
* **Picklist Teroptimasi**: Menghasilkan daftar pengambilan barang tercetak yang urutannya telah dioptimalkan berdasarkan rute terpendek di gudang.

### Kontrol Inventaris
* **Pelacakan LPN**: Kemampuan untuk mencari dan melihat riwayat lengkap setiap LPN.
* **Cycle Counting**: Fitur untuk melakukan penghitungan stok secara berkala dan terjadwal.
* **Penyesuaian & Perpindahan Stok**: Fitur untuk menyesuaikan stok dan mencatat perpindahan barang antar-bin.

### Dashboard & Laporan
* **Dashboard KPI**: Ringkasan visual kondisi gudang.
* **Laporan Kunci**: Laporan Umur Stok (Inventory Aging), riwayat transaksi, dan nilai inventaris.
* **Ekspor Data**: Semua laporan utama dapat diekspor ke format CSV/Excel.

---

## 🚀 Instalasi & Setup Lokal

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone repositori:**
    ```bash
    git clone [https://github.com/your-username/your-repo-name.git](https://github.com/your-username/your-repo-name.git)
    cd your-repo-name
    ```

2.  **Instal dependensi Composer:**
    ```bash
    composer install
    ```

3.  **Buat file `.env`:**
    ```bash
    cp .env.example .env
    ```

4.  **Generate application key:**
    ```bash
    php artisan key:generate
    ```

5.  **Konfigurasi database Anda di file `.env`:**
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=wms_pro
    DB_USERNAME=root
    DB_PASSWORD=
    ```

6.  **Jalankan migrasi database:**
    ```bash
    php artisan migrate
    ```

7.  **(Opsional) Jalankan seeder untuk data dummy:**
    ```bash
    php artisan db:seed
    ```

8.  **Jalankan server pengembangan:**
    ```bash
    php artisan serve
    ```

Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.