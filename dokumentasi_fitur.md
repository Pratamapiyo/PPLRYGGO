# Dokumentasi Fitur Aplikasi (Berdasarkan PBI)

Berikut adalah rincian fitur (PBI) beserta komponen-komponen terkait (Routes, Controllers, Views, Models) berdasarkan analisis codebase yang disediakan.

## PBI-UC15A: Mengirimkan Feedback
* **User Story**: "Sebagai pengguna, saya ingin dapat mengirimkan feedback mengenai aplikasi agar pengembang dapat menerima masukan untuk perbaikan dan pengembangan lebih lanjut."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /feedback
   * Method: POST (untuk mengirim feedback)
* **Controllers**:
   * File: app/Http/Controllers/FeedbackController.php
   * Method: store (Menangani penyimpanan feedback dari pengguna)
* **Views**:
   * File: resources/views/feedback/create.blade.php
   * Deskripsi: Halaman yang berisi formulir untuk mengirimkan feedback.
* **Models**:
   * File: app/Models/Feedback.php
   * Deskripsi: Model yang merepresentasikan data feedback dan berinteraksi dengan tabel feedback.

## PBI-UC15B: Melihat Feedback dari Pengguna Lain
* **User Story**: "Sebagai pengguna, saya ingin melihat feedback dari pengguna lain agar saya dapat mengetahui pengalaman mereka dengan aplikasi."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /feedback
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/FeedbackController.php
   * Method: index (Menampilkan daftar feedback dari pengguna)
* **Views**:
   * File: resources/views/feedback/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar feedback dari pengguna lain.
* **Models**:
   * File: app/Models/Feedback.php
   * Deskripsi: Model yang merepresentasikan data feedback dan berinteraksi dengan tabel feedback.

## PBI-UC15C: Melihat Daftar Feedback Terkirim
* **User Story**: "Sebagai pengguna, saya ingin melihat daftar feedback yang pernah saya kirim agar dapat memantau masukan yang telah diberikan."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /my-feedback
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/FeedbackController.php
   * Method: myFeedback (Menampilkan daftar feedback yang dikirim oleh pengguna yang sedang login)
* **Views**:
   * File: resources/views/feedback/my-feedback.blade.php
   * Deskripsi: Halaman yang menampilkan daftar feedback yang pernah dikirim oleh pengguna.
* **Models**:
   * File: app/Models/Feedback.php
   * Deskripsi: Model yang merepresentasikan data feedback dan berinteraksi dengan tabel feedback.

## PBI-001A: Registrasi Akun
* **User Story**: "Sebagai pengguna baru, saya ingin dapat mendaftarkan diri pada sistem agar dapat mengakses fitur-fitur aplikasi."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /register
   * Method: GET (untuk menampilkan form registrasi), POST (untuk memproses data registrasi)
* **Controllers**:
   * File: app/Http/Controllers/Auth/RegisterController.php
* **Views**:
   * File: resources/views/auth/register.blade.php
   * Deskripsi: Halaman yang berisi formulir untuk memasukkan detail registrasi pengguna.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model yang merepresentasikan data pengguna dan berinteraksi dengan tabel users.

## PBI-001B: Login dengan Akun Terdaftar
* **User Story**: "Sebagai pengguna yang terdaftar, saya ingin dapat login ke sistem agar dapat mengakses fitur-fitur yang tersedia."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /login
   * Method: GET (untuk menampilkan form login), POST (untuk memproses data login)
   * Endpoint: /logout
   * Method: POST (untuk keluar dari sesi login)
* **Controllers**:
   * File: app/Http/Controllers/Auth/LoginController.php
* **Views**:
   * File: resources/views/auth/login.blade.php
   * Deskripsi: Halaman yang berisi formulir untuk memasukkan kredensial login.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model yang digunakan untuk validasi kredensial pengguna.

## PBI-011A: Melihat Daftar Event Campaign
* **User Story**: "Sebagai pengguna, saya ingin melihat daftar event campaign agar dapat memilih event yang ingin saya ikuti."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /events
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/EventController.php
   * Method: index (Menampilkan daftar event campaign)
* **Views**:
   * File: resources/views/events/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar event campaign yang tersedia.
* **Models**:
   * File: app/Models/Event.php
   * Deskripsi: Model yang merepresentasikan data event dan berinteraksi dengan tabel events.

## PBI-011B: Memilih Event Campaign
* **User Story**: "Sebagai pengguna, saya ingin memilih salah satu event campaign agar dapat melihat detail event tersebut"
* **Routes**:
   * File: routes/web.php
   * Endpoint: /events/{id}
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/EventController.php
   * Method: show (Menampilkan detail event campaign)
* **Views**:
   * File: resources/views/events/show.blade.php
   * Deskripsi: Halaman yang menampilkan detail dari sebuah event campaign.
* **Models**:
   * File: app/Models/Event.php
   * Deskripsi: Model yang merepresentasikan data event dan berinteraksi dengan tabel events.

## PBI-011C: Melakukan Pendaftaran pada Event Campaign
* **User Story**: "Sebagai pengguna, saya ingin mendaftar pada event campaign agar dapat berpartisipasi dalam kegiatan tersebut."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /events/{id}/register
   * Method: POST
* **Controllers**:
   * File: app/Http/Controllers/EventController.php
   * Method: register (Menangani pendaftaran pengguna untuk event)
* **Views**:
   * File: resources/views/events/show.blade.php
   * Deskripsi: Bagian dari halaman detail event yang berisi tombol untuk mendaftar.
* **Models**:
   * File: app/Models/Event.php
   * Deskripsi: Model yang merepresentasikan data event.
   * File: app/Models/EventRegistration.php
   * Deskripsi: Model yang merepresentasikan data pendaftaran event dan berinteraksi dengan tabel event_registrations.

## PBI-007A: Storefront Display
* **User Story**: "Sebagai pengguna, saya ingin dapat melihat daftar produk yang tersedia di toko agar saya tahu apa saja yang bisa saya dapatkan dengan poin saya."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /vendor-products
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/VendorProductController.php
   * Method: index (Menampilkan daftar produk vendor)
* **Views**:
   * File: resources/views/vendor-products/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar produk yang tersedia di toko.
* **Models**:
   * File: app/Models/VendorProduct.php
   * Deskripsi: Model yang merepresentasikan data produk vendor dan berinteraksi dengan tabel vendor_products.

## PBI-007B: Points Redemption
* **User Story**: "Sebagai pengguna, saya ingin dapat menukar poin saya dengan hadiah atau voucher agar saya mendapatkan manfaat dari partisipasi saya dalam mendaur ulang sampah."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /vendor-products/{id}/redeem
   * Method: POST
* **Controllers**:
   * File: app/Http/Controllers/VendorTransactionController.php
   * Method: store (Menangani proses penukaran poin dengan produk)
* **Views**:
   * File: resources/views/vendor-products/show.blade.php
   * Deskripsi: Halaman detail produk dengan tombol untuk menukarkan poin.
* **Models**:
   * File: app/Models/VendorTransaction.php
   * Deskripsi: Model yang merepresentasikan data transaksi produk vendor dan berinteraksi dengan tabel vendor_transactions.
   * File: app/Models/VendorProduct.php
   * Deskripsi: Model yang merepresentasikan data produk vendor.

## PBI-007C: Transaction History
* **User Story**: "Sebagai pengguna, saya ingin melihat riwayat transaksi saya di toko agar saya bisa melacak penggunaan poin saya dan status pemesanan hadiah."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /transactions
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/VendorTransactionController.php
   * Method: index (Menampilkan riwayat transaksi pengguna)
* **Views**:
   * File: resources/views/transactions/index.blade.php
   * Deskripsi: Halaman yang menampilkan riwayat transaksi pengguna.
* **Models**:
   * File: app/Models/VendorTransaction.php
   * Deskripsi: Model yang merepresentasikan data transaksi dan berinteraksi dengan tabel vendor_transactions.

## PBI-012A: Menampilkan Daftar Program Donasi
* **User Story**: "Sebagai pengguna, saya ingin melihat daftar barang donasi agar saya bisa memilih ke mana poin saya akan disumbangkan."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /donation-programs
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/DonationProgramController.php
   * Method: index (Menampilkan daftar program donasi)
* **Views**:
   * File: resources/views/donation-programs/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar program donasi yang tersedia.
* **Models**:
   * File: app/Models/DonationProgram.php
   * Deskripsi: Model yang merepresentasikan data program donasi dan berinteraksi dengan tabel donation_programs.

## PBI-012B: Halaman Detail Program Donasi
* **User Story**: "Sebagai pengguna, saya ingin melihat detail program donasi agar saya bisa memahami tujuan dan dampak dari donasi saya."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /donation-programs/{id}
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/DonationProgramController.php
   * Method: show (Menampilkan detail program donasi)
* **Views**:
   * File: resources/views/donation-programs/show.blade.php
   * Deskripsi: Halaman yang menampilkan detail dari sebuah program donasi.
* **Models**:
   * File: app/Models/DonationProgram.php
   * Deskripsi: Model yang merepresentasikan data program donasi.

## PBI-012C: Fitur Donasi Poin
* **User Story**: "Sebagai pengguna, saya ingin dapat menukarkan poin saya untuk berdonasi agar saya bisa berkontribusi terhadap program lingkungan atau sosial."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /donation-programs/{id}/donate
   * Method: POST
* **Controllers**:
   * File: app/Http/Controllers/DonationController.php
   * Method: store (Menangani proses donasi poin)
* **Views**:
   * File: resources/views/donation-programs/show.blade.php
   * Deskripsi: Bagian dari halaman detail program donasi dengan formulir untuk berdonasi.
* **Models**:
   * File: app/Models/Donation.php
   * Deskripsi: Model yang merepresentasikan data donasi dan berinteraksi dengan tabel donations.
   * File: app/Models/DonationProgram.php
   * Deskripsi: Model yang merepresentasikan data program donasi.

## PBI-012D: Riwayat Donasi Poin
* **User Story**: "Sebagai pengguna, saya ingin melihat riwayat donasi saya agar saya bisa mengetahui ke mana poin saya telah digunakan."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /donations
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/DonationController.php
   * Method: index (Menampilkan riwayat donasi pengguna)
* **Views**:
   * File: resources/views/donations/index.blade.php
   * Deskripsi: Halaman yang menampilkan riwayat donasi pengguna.
* **Models**:
   * File: app/Models/Donation.php
   * Deskripsi: Model yang merepresentasikan data donasi dan berinteraksi dengan tabel donations.

## PBI-006A: Menampilkan Poin dari Aktivitas Daur Ulang
* **User Story**: "Sebagai pengguna, saya ingin melihat jumlah poin yang saya dapatkan dari aktivitas daur ulang agar saya bisa mengetahui kontribusi saya dan menukarkannya dengan hadiah."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /points
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/PointController.php
   * Method: index (Menampilkan jumlah poin pengguna)
* **Views**:
   * File: resources/views/points/index.blade.php
   * Deskripsi: Halaman yang menampilkan jumlah poin yang dimiliki pengguna.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model yang menyimpan data poin pengguna dalam kolom points.

## PBI-006B: Riwayat Perolehan Poin
* **User Story**: "Sebagai pengguna, saya ingin melihat riwayat perolehan poin saya agar saya dapat mengetahui sumber dan jumlah poin yang telah saya kumpulkan."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /points/history
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/PointHistoryController.php
   * Method: index (Menampilkan riwayat perolehan poin)
* **Views**:
   * File: resources/views/points/history.blade.php
   * Deskripsi: Halaman yang menampilkan riwayat perolehan poin pengguna.
* **Models**:
   * File: app/Models/PointHistory.php
   * Deskripsi: Model yang merepresentasikan data riwayat poin dan berinteraksi dengan tabel point_histories.

## PBI-006C: Klaim Hadiah dengan Poin
* **User Story**: "Sebagai pengguna, saya ingin dapat menukarkan poin yang saya miliki dengan hadiah agar saya bisa mendapatkan manfaat dari aktivitas daur ulang yang telah saya lakukan."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /products/{id}/redeem
   * Method: POST
* **Controllers**:
   * File: app/Http/Controllers/TransactionController.php
   * Method: store (Menangani proses penukaran poin dengan hadiah)
* **Views**:
   * File: resources/views/products/show.blade.php
   * Deskripsi: Halaman detail hadiah dengan tombol untuk mengklaim hadiah.
* **Models**:
   * File: app/Models/Transaction.php
   * Deskripsi: Model yang merepresentasikan data transaksi dan berinteraksi dengan tabel transactions.
   * File: app/Models/Product.php
   * Deskripsi: Model yang merepresentasikan data hadiah.

## PBI-006D: Notifikasi Klaim Hadiah
* **User Story**: "Sebagai pengguna, saya ingin mendapatkan notifikasi setelah saya mengklaim hadiah agar saya mengetahui status dan proses pengiriman hadiah yang saya pilih."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /notifications
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/NotificationController.php
   * Method: index (Menampilkan daftar notifikasi)
* **Views**:
   * File: resources/views/notifications/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar notifikasi pengguna.
* **Models**:
   * File: app/Models/Notification.php
   * Deskripsi: Model yang merepresentasikan data notifikasi dan berinteraksi dengan tabel notifications.

## PBI-006E: Katalog Hadiah
* **User Story**: "Sebagai pengguna, saya ingin melihat daftar hadiah yang tersedia agar saya dapat memilih hadiah yang sesuai dengan jumlah poin saya."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /products
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/ProductController.php
   * Method: index (Menampilkan daftar hadiah)
* **Views**:
   * File: resources/views/products/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar hadiah yang tersedia.
* **Models**:
   * File: app/Models/Product.php
   * Deskripsi: Model yang merepresentasikan data hadiah dan berinteraksi dengan tabel products.

## PBI-010A: Membuat dan Membalas Diskusi
* **User Story**: "Sebagai pengguna, saya ingin dapat membuat diskusi baru dan membalas diskusi orang lain agar saya bisa berbagi informasi tentang daur ulang."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /discussions
   * Method: GET (untuk melihat daftar diskusi), POST (untuk membuat diskusi baru)
   * Endpoint: /discussions/{id}
   * Method: GET (untuk melihat detail diskusi)
   * Endpoint: /discussions/{id}/replies
   * Method: POST (untuk menambahkan balasan)
* **Controllers**:
   * File: app/Http/Controllers/DiscussionController.php
   * Method: index (Menampilkan daftar diskusi)
   * Method: store (Menyimpan diskusi baru)
   * Method: show (Menampilkan detail diskusi)
   * File: app/Http/Controllers/ReplyController.php
   * Method: store (Menyimpan balasan diskusi)
* **Views**:
   * File: resources/views/discussions/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar diskusi.
   * File: resources/views/discussions/create.blade.php
   * Deskripsi: Halaman untuk membuat diskusi baru.
   * File: resources/views/discussions/show.blade.php
   * Deskripsi: Halaman detail diskusi dengan daftar balasan dan formulir untuk menambahkan balasan.
* **Models**:
   * File: app/Models/Discussion.php
   * Deskripsi: Model yang merepresentasikan data diskusi dan berinteraksi dengan tabel discussions.
   * File: app/Models/Reply.php
   * Deskripsi: Model yang merepresentasikan data balasan diskusi dan berinteraksi dengan tabel replies.

## PBI-010B: Moderasi Forum Diskusi
* **User Story**: "Sebagai moderator, saya ingin memiliki fitur untuk menghapus pesan atau memblokir pengguna agar forum tetap rapi dan informatif."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /discussions/{id}
   * Method: DELETE (untuk menghapus diskusi)
   * Endpoint: /replies/{id}
   * Method: DELETE (untuk menghapus balasan)
   * Endpoint: /admin/users/{id}/block
   * Method: PUT (untuk memblokir pengguna)
* **Controllers**:
   * File: app/Http/Controllers/DiscussionController.php
   * Method: destroy (Menghapus diskusi)
   * File: app/Http/Controllers/ReplyController.php
   * Method: destroy (Menghapus balasan)
   * File: app/Http/Controllers/Admin/UserController.php
   * Method: block (Memblokir pengguna)
* **Views**:
   * File: resources/views/discussions/show.blade.php
   * Deskripsi: Tampilan diskusi dengan tombol hapus untuk moderator.
   * File: resources/views/admin/users.blade.php
   * Deskripsi: Panel admin untuk mengelola pengguna.
* **Models**:
   * File: app/Models/Discussion.php
   * File: app/Models/Reply.php
   * File: app/Models/User.php
   * Deskripsi: Model-model terkait yang memiliki kolom status untuk menandai pengguna yang diblokir.

## PBI-010C: Memberikan Like pada Komentar
* **User Story**: "Sebagai pengguna, saya ingin bisa memberikan like pada komentar yang menarik agar komentar tersebut lebih mudah ditemukan oleh pengguna lain."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /discussions/{id}/like
   * Method: POST (untuk memberikan like pada diskusi)
   * Endpoint: /discussions/{id}/unlike
   * Method: DELETE (untuk menghapus like pada diskusi)
* **Controllers**:
   * File: app/Http/Controllers/LikeController.php
   * Method: store (Memberikan like)
   * Method: destroy (Menghapus like)
* **Views**:
   * File: resources/views/discussions/show.blade.php
   * Deskripsi: Tampilan diskusi dengan tombol like untuk setiap diskusi.
* **Models**:
   * File: app/Models/Like.php
   * Deskripsi: Model yang merepresentasikan data like dan berinteraksi dengan tabel likes.
   * File: app/Models/Discussion.php
   * Deskripsi: Model yang memiliki relasi ke likes.

## PBI-013A: Menampilkan Lokasi Vendor Terdekat
* **User Story**: "Sebagai pengguna, saya ingin melihat daftar vendor daur ulang terdekat agar saya bisa memilih lokasi yang paling sesuai."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /vendors
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/VendorController.php
   * Method: index (Menampilkan daftar vendor terdekat)
* **Views**:
   * File: resources/views/vendors/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar vendor terdekat, mungkin dengan peta.
* **Models**:
   * File: app/Models/Vendor.php
   * Deskripsi: Model yang merepresentasikan data vendor dan berinteraksi dengan tabel vendors.

## PBI-013B: Mengajukan Permintaan Daur Ulang ke Vendor
* **User Story**: "Sebagai pengguna, saya ingin dapat mengajukan permintaan daur ulang ke vendor yang saya pilih agar proses daur ulang dapat dilakukan dengan lebih mudah."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /ecocycle/store
   * Method: POST
* **Controllers**:
   * File: app/Http/Controllers/EcoCycleController.php
   * Method: store (Menyimpan permintaan daur ulang)
* **Views**:
   * File: resources/views/ecocycle-home.blade.php
   * Deskripsi: Halaman dengan formulir untuk mengajukan permintaan daur ulang.
* **Models**:
   * File: app/Models/EcoCycle.php
   * Deskripsi: Model yang merepresentasikan data permintaan daur ulang dan berinteraksi dengan tabel eco_cycles.
   * File: app/Models/Vendor.php
   * Deskripsi: Model yang merepresentasikan data vendor.

## PBI-013C: Filter Vendor Berdasarkan Jenis Daur Ulang
* **User Story**: "Sebagai pengguna, saya ingin bisa memfilter vendor berdasarkan jenis daur ulang yang mereka terima agar saya bisa menemukan tempat yang sesuai dengan barang yang ingin saya daur ulang."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /vendors
   * Method: GET (dengan parameter filter)
* **Controllers**:
   * File: app/Http/Controllers/VendorController.php
   * Method: index (Menampilkan daftar vendor dengan filter)
* **Views**:
   * File: resources/views/vendors/index.blade.php
   * Deskripsi: Halaman yang menampilkan daftar vendor dengan opsi filter berdasarkan jenis daur ulang.
* **Models**:
   * File: app/Models/Vendor.php
   * Deskripsi: Model yang merepresentasikan data vendor.

## PBI-014A: Menampilkan Peringkat dalam Komunitas
* **User Story**: "Sebagai pengguna, saya ingin melihat peringkat teratas dalam komunitas berdasarkan perolehan poin agar saya dapat mengetahui posisi saya dibandingkan dengan anggota lainnya."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /leaderboard
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/LeaderboardController.php
   * Method: index (Menampilkan peringkat dalam komunitas)
* **Views**:
   * File: resources/views/leaderboard/index.blade.php
   * Deskripsi: Halaman yang menampilkan peringkat pengguna dalam komunitas.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model yang menyimpan data poin pengguna.

## PBI-014B: Filter Leaderboard Berdasarkan Asal Daerah
* **User Story**: "Sebagai pengguna, saya ingin dapat menyaring leaderboard berdasarkan asal daerah agar saya bisa melihat peringkat anggota dari daerah tertentu."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /leaderboard
   * Method: GET (dengan parameter region)
* **Controllers**:
   * File: app/Http/Controllers/LeaderboardController.php
   * Method: index (Menampilkan peringkat dengan filter daerah)
* **Views**:
   * File: resources/views/leaderboard/index.blade.php
   * Deskripsi: Halaman leaderboard dengan opsi filter berdasarkan daerah.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model pengguna dengan kolom region untuk menyimpan daerah asal.

## PBI-014C: Filter Leaderboard Berdasarkan Perolehan Poin
* **User Story**: "Sebagai pengguna, saya ingin dapat menyaring leaderboard berdasarkan jumlah poin yang diperoleh agar saya dapat membandingkan peringkat dengan pengguna lain dalam kategori tertentu."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /leaderboard
   * Method: GET (dengan parameter points)
* **Controllers**:
   * File: app/Http/Controllers/LeaderboardController.php
   * Method: index (Menampilkan peringkat dengan filter poin)
* **Views**:
   * File: resources/views/leaderboard/index.blade.php
   * Deskripsi: Halaman leaderboard dengan opsi filter berdasarkan jumlah poin.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model pengguna dengan kolom points untuk menyimpan jumlah poin.

## PBI-014D: Menampilkan Top 5/10 Peringkat
* **User Story**: "Sebagai pengguna, saya ingin melihat daftar peringkat teratas (Top 5/10) dalam komunitas agar saya dapat mengetahui siapa yang memiliki kontribusi paling tinggi."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /leaderboard/top
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/LeaderboardController.php
   * Method: top (Menampilkan peringkat teratas)
* **Views**:
   * File: resources/views/leaderboard/top.blade.php
   * Deskripsi: Halaman yang menampilkan daftar peringkat teratas dalam komunitas.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model pengguna dengan kolom points untuk menyimpan jumlah poin.

## PBI-002A: Edit Profile Information
* **User Story**: "Sebagai pengguna, saya ingin dapat mengubah informasi profil saya agar data pribadi saya tetap akurat dan terkini."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /profile/update
   * Method: PUT
* **Controllers**:
   * File: app/Http/Controllers/UserController.php
   * Method: updateProfile (Menangani update nama, email, dan data lainnya)
* **Views**:
   * File: resources/views/edit-profile.blade.php
   * Deskripsi: Berisi formulir untuk mengedit informasi profil pengguna.
* **Models**:
   * File: app/Models/User.php
   * Deskripsi: Model yang bertanggung jawab untuk menangani update data pengguna.

## PBI-003A: Menampilkan Daftar Artikel
* **User Story**: "Sebagai pengguna, saya ingin melihat daftar artikel tentang eco-friendly agar saya mendapatkan informasi dan edukasi tentang daur ulang."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /econews
   * Method: GET
* **Controllers**:
   * File: app/Http/Controllers/NewsController.php
   * Method: index (Menangani pengambilan dan menampilkan daftar artikel berita)
* **Views**:
   * File: resources/views/econews.blade.php
   * Deskripsi: Menampilkan daftar artikel berita dengan fitur paginasi.
* **Models**:
   * File: app/Models/News.php
   * Deskripsi: Model yang menangani data artikel berita.

## PBI-004A: Penjadwalan Pengambilan Sampah
* **User Story**: "Sebagai pengguna, saya ingin dapat menjadwalkan pengambilan sampah daur ulang agar proses daur ulang lebih terorganisir."
* **Routes**:
   * File: routes/web.php
   * Endpoint: /ecocycle/store
   * Method: POST
* **Controllers**:
   * File: app/Http/Controllers/EcoCycleController.php
   * Method: store (Menangani proses penjadwalan pengambilan sampah)
* **Views**:
   * File: resources/views/ecocycle-home.blade.php
   * Deskripsi: Berisi formulir untuk menjadwalkan pengambilan sampah.
* **Models**:
   * File: app/Models/EcoCycle.php
   * Deskripsi: Model yang menangani data terkait siklus daur ulang.
