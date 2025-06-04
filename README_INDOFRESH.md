# IndoFresh - Fresh Product Management System

IndoFresh adalah sistem manajemen produk segar yang dirancang khusus untuk industri agroindustri modern. Sistem ini menyediakan solusi lengkap untuk mengelola katalog produk, transaksi penjualan, dan analitik bisnis dengan teknologi AI.

## Fitur Utama

### 🔐 Sistem Role-Based Access Control
- **Admin**: Akses penuh ke semua fitur sistem
- **Employee/Pegawai**: Akses terbatas sesuai dengan tugas operasional

### 👨‍💼 Fitur Admin
- **Dashboard Analytics**: Overview lengkap performa bisnis
- **Manajemen Akun Admin**: 
  - Melihat dan mengubah data profil admin
  - Mengubah password
- **Manajemen Akun Pegawai**:
  - Membuat akun pegawai baru
  - Melihat daftar pegawai
  - Mengubah data pegawai
  - Menghapus akun pegawai
- **Manajemen Katalog Produk**:
  - Menambah produk baru
  - Melihat katalog produk
  - Mengubah informasi produk
  - Menghapus produk
  - Upload gambar produk
- **Manajemen Transaksi**:
  - Membuat transaksi baru
  - Melihat semua data transaksi
  - Update status pembayaran
- **AI Analytics Dashboard**:
  - Visualisasi data penjualan
  - Analisis tren pemasukan
  - Grafik performa produk
  - Insight pelanggan
  - Alert stok rendah

### 👨‍💻 Fitur Employee/Pegawai
- **Dashboard Personal**: Overview aktivitas dan statistik personal
- **Manajemen Profil**:
  - Melihat data akun pribadi
  - Mengubah informasi profil
  - Mengubah password
- **Katalog Produk**:
  - Melihat katalog produk (read-only)
  - Pencarian dan filter produk
  - Informasi stok real-time
- **Manajemen Transaksi**:
  - Membuat transaksi penjualan
  - Melihat riwayat transaksi pribadi
  - Sistem keranjang belanja

## Teknologi yang Digunakan

- **Framework**: Laravel 10
- **Frontend**: Blade Templates + Tailwind CSS
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Breeze
- **Charts**: Chart.js
- **Icons**: Heroicons
- **File Storage**: Laravel Storage

## Instalasi

### Prasyarat
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/SQLite

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd indofresh
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=indofresh
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Database Migration & Seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Build Assets**
   ```bash
   npm run build
   ```

8. **Start Development Server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

Setelah menjalankan seeder, gunakan kredensial berikut:

**Admin Account:**
- Email: `admin@example.com`
- Password: `adminpassword`

## Struktur Database

### Users Table
- `id`, `name`, `email`, `password`, `role`, `phone`, `address`
- Role: 'admin' atau 'employee'

### Catalogs Table
- `id`, `name`, `description`, `price`, `stock`, `category`, `image`, `status`

### Transactions Table
- `id`, `transaction_code`, `customer_name`, `customer_phone`, `customer_email`
- `total_amount`, `payment_method`, `payment_status`, `transaction_date`
- `notes`, `created_by`

### Transaction Items Table
- `id`, `transaction_id`, `catalog_id`, `product_name`, `quantity`
- `unit_price`, `subtotal`

## API Endpoints

### Authentication
- `POST /login` - Login
- `POST /logout` - Logout

### Admin Routes (Prefix: `/admin`)
- `GET /dashboard` - Admin Dashboard
- `GET /profile` - Admin Profile
- `PATCH /profile` - Update Admin Profile
- `GET|POST /employees` - Employee Management
- `GET|POST|PUT|DELETE /catalogs` - Catalog Management
- `GET|POST /transactions` - Transaction Management
- `GET /ai` - AI Analytics Dashboard

### Employee Routes (Prefix: `/employee`)
- `GET /dashboard` - Employee Dashboard
- `GET /profile` - Employee Profile
- `PATCH /profile` - Update Employee Profile

### Shared Routes
- `GET|POST /catalogs` - View Catalogs & Create Transactions
- `GET|POST /transactions` - Transaction Management

## Fitur AI Analytics

Sistem AI Analytics menyediakan:

1. **Sales Analytics**
   - Total transaksi dan revenue
   - Rata-rata nilai transaksi
   - Trend penjualan harian/bulanan

2. **Product Analytics**
   - Produk terlaris
   - Performa kategori
   - Alert stok rendah

3. **Customer Analytics**
   - Top customers
   - Analisis pelanggan baru vs returning

4. **Revenue Analytics**
   - Revenue berdasarkan metode pembayaran
   - Growth rate bulanan
   - Trend pendapatan

## System Requirements Compliance

✅ **Admin Features:**
- Login ✅
- Fitur Data Akun Admin (Melihat & Mengubah) ✅
- Fitur Data Akun Pegawai (Membuat, Melihat, Mengubah) ✅
- Fitur Katalog (Membuat, Melihat, Mengubah) ✅
- Fitur Transaksi (Membuat, Melihat) ✅
- Fitur AI (Visualisasi data penjualan & tren pemasukan) ✅
- Log Out ✅

✅ **Employee Features:**
- Login ✅
- Fitur Data Akun (Melihat data akun pegawai) ✅
- Fitur Katalog (Melihat Katalog) ✅
- Fitur Transaksi (Membuat & Melihat data transaksi) ✅
- Log Out ✅

## Kontribusi

Untuk berkontribusi pada project ini:

1. Fork repository
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## License

Project ini menggunakan [MIT License](https://opensource.org/licenses/MIT).

## Support

Untuk pertanyaan atau dukungan, silakan hubungi tim development atau buat issue di repository ini.
