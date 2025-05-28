# User Stories Documentation

## Feedback System
### PBI-UC15A: Mengirimkan Feedback
- **User Story**: Sebagai pengguna, saya ingin dapat mengirimkan feedback mengenai aplikasi agar pengembang dapat menerima masukan untuk perbaikan dan pengembangan lebih lanjut.
- **Controller**: `FeedbackController.php`

### PBI-UC15B: Melihat Feedback dari Pengguna Lain
- **User Story**: Sebagai pengguna, saya ingin melihat feedback dari pengguna lain agar saya dapat mengetahui pengalaman mereka dengan aplikasi.
- **Controller**: `FeedbackController.php`

### PBI-UC15C: Melihat Daftar Feedback Terkirim
- **User Story**: Sebagai pengguna, saya ingin melihat daftar feedback yang pernah saya kirim agar dapat memantau masukan yang telah diberikan.
- **Controller**: `FeedbackController.php`

## Event Campaign System
### PBI-011A: Melihat Daftar Event Campaign
- **User Story**: Sebagai pengguna, saya ingin melihat daftar event campaign agar dapat memilih event yang ingin saya ikuti.
- **Controller**: `EventController.php`

### PBI-011B: Memilih Event Campaign
- **User Story**: Sebagai pengguna, saya ingin memilih salah satu event campaign agar dapat melihat detail event tersebut
- **Controller**: `EventController.php`

### PBI-011C: Melakukan Pendaftaran pada Event Campaign
- **User Story**: Sebagai pengguna, saya ingin mendaftar pada event campaign agar dapat berpartisipasi dalam kegiatan tersebut.
- **Controller**: `EventRegistrationController.php`

## Store System
### PBI-007A: Storefront Display
- **User Story**: Sebagai pengguna, saya ingin dapat melihat daftar produk yang tersedia di toko agar saya tahu apa saja yang bisa saya dapatkan dengan poin saya.
- **Controller**: `StoreController.php`

### PBI-007B: Points Redemption
- **User Story**: Sebagai pengguna, saya ingin dapat menukar poin saya dengan hadiah atau voucher agar saya mendapatkan manfaat dari partisipasi saya dalam mendaur ulang sampah.
- **Controller**: `StoreController.php`

### PBI-007C: Transaction History
- **User Story**: Sebagai pengguna, saya ingin melihat riwayat transaksi saya di toko agar saya bisa melacak penggunaan poin saya dan status pemesanan hadiah.
- **Controller**: `StoreController.php`

## Donation System
### PBI-012A: Menampilkan Daftar Program Donasi
- **User Story**: Sebagai pengguna, saya ingin melihat daftar barang donasi agar saya bisa memilih ke mana poin saya akan disumbangkan.
- **Controller**: `DonationProgramController.php`

### PBI-012B: Halaman Detail Program Donasi
- **User Story**: Sebagai pengguna, saya ingin melihat detail program donasi agar saya bisa memahami tujuan dan dampak dari donasi saya.
- **Controller**: `DonationProgramController.php`

### PBI-012C: Fitur Donasi Poin
- **User Story**: Sebagai pengguna, saya ingin dapat menukarkan poin saya untuk berdonasi agar saya bisa berkontribusi terhadap program lingkungan atau sosial.
- **Controller**: `DonationController.php`

### PBI-012D: Riwayat Donasi Poin
- **User Story**: Sebagai pengguna, saya ingin melihat riwayat donasi saya agar saya bisa mengetahui ke mana poin saya telah digunakan.
- **Controller**: `DonationController.php`

## Points System
### PBI-006A: Menampilkan Poin dari Aktivitas Daur Ulang
- **User Story**: Sebagai pengguna, saya ingin melihat jumlah poin yang saya dapatkan dari aktivitas daur ulang agar saya bisa mengetahui kontribusi saya dan menukarkannya dengan hadiah.
- **Controller**: `UserController.php`

### PBI-006B: Riwayat Perolehan Poin
- **User Story**: Sebagai pengguna, saya ingin melihat riwayat perolehan poin saya agar saya dapat mengetahui sumber dan jumlah poin yang telah saya kumpulkan.
- **Controller**: `UserController.php`

### PBI-006C: Klaim Hadiah dengan Poin
- **User Story**: Sebagai pengguna, saya ingin dapat menukarkan poin yang saya miliki dengan hadiah agar saya bisa mendapatkan manfaat dari aktivitas daur ulang yang telah saya lakukan.
- **Controller**: `StoreController.php`

### PBI-006D: Notifikasi Klaim Hadiah
- **User Story**: Sebagai pengguna, saya ingin mendapatkan notifikasi setelah saya mengklaim hadiah agar saya mengetahui status dan proses pengiriman hadiah yang saya pilih.
- **Controller**: `NotificationController.php`

### PBI-006E: Katalog Hadiah
- **User Story**: Sebagai pengguna, saya ingin melihat daftar hadiah yang tersedia agar saya dapat memilih hadiah yang sesuai dengan jumlah poin saya.
- **Controller**: `StoreController.php`

## Discussion System
### PBI-010A: Membuat dan Membalas Diskusi
- **User Story**: Sebagai pengguna, saya ingin dapat membuat diskusi baru dan membalas diskusi orang lain agar saya bisa berbagi informasi tentang daur ulang.
- **Controller**: `DiscussionController.php`

### PBI-010B: Moderasi Forum Diskusi
- **User Story**: Sebagai moderator, saya ingin memiliki fitur untuk menghapus pesan atau memblokir pengguna agar forum tetap rapi dan informatif.
- **Controller**: `AdminForumController.php`

### PBI-010C: Memberikan Like pada Komentar
- **User Story**: Sebagai pengguna, saya ingin bisa memberikan like pada komentar yang menarik agar komentar tersebut lebih mudah ditemukan oleh pengguna lain.
- **Controller**: `DiscussionController.php`

## Vendor System
### PBI-013A: Menampilkan Lokasi Vendor Terdekat
- **User Story**: Sebagai pengguna, saya ingin melihat daftar vendor daur ulang terdekat agar saya bisa memilih lokasi yang paling sesuai.
- **Controller**: `VendorController.php`

### PBI-013B: Mengajukan Permintaan Daur Ulang ke Vendor
- **User Story**: Sebagai pengguna, saya ingin dapat mengajukan permintaan daur ulang ke vendor yang saya pilih agar proses daur ulang dapat dilakukan dengan lebih mudah.
- **Controller**: `VendorController.php`

### PBI-013C: Filter Vendor Berdasarkan Jenis Daur Ulang
- **User Story**: Sebagai pengguna, saya ingin bisa memfilter vendor berdasarkan jenis daur ulang yang mereka terima agar saya bisa menemukan tempat yang sesuai dengan barang yang ingin saya daur ulang.
- **Controller**: `VendorController.php`

## Leaderboard System
### PBI-014A: Menampilkan Peringkat dalam Komunitas
- **User Story**: Sebagai pengguna, saya ingin melihat peringkat teratas dalam komunitas berdasarkan perolehan poin agar saya dapat mengetahui posisi saya dibandingkan dengan anggota lainnya.
- **Controller**: `UserController.php`

### PBI-014B: Filter Leaderboard Berdasarkan Asal Daerah
- **User Story**: Sebagai pengguna, saya ingin dapat menyaring leaderboard berdasarkan asal daerah agar saya bisa melihat peringkat anggota dari daerah tertentu.
- **Controller**: `UserController.php`

### PBI-014C: Filter Leaderboard Berdasarkan Perolehan Poin
- **User Story**: Sebagai pengguna, saya ingin dapat menyaring leaderboard berdasarkan jumlah poin yang diperoleh agar saya dapat membandingkan peringkat dengan pengguna lain dalam kategori tertentu.
- **Controller**: `UserController.php`

### PBI-014D: Menampilkan Top 5/10 Peringkat
- **User Story**: Sebagai pengguna, saya ingin melihat daftar peringkat teratas (Top 5/10) dalam komunitas agar saya dapat mengetahui siapa yang memiliki kontribusi paling tinggi.
- **Controller**: `UserController.php`
