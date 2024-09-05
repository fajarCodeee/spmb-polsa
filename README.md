
**SPMB** merupakan sistem yang digunakan untuk melakukan pendaftaraan **Penerimaan Mahasiswa Baru** online di suatu kampus. Tujuan dari sistem antara lain: 

1. Memudahkan calon peserta untuk melakukan pendaftaran secara online.
2. Memudahkan CS/Akademik untuk memanipulasi data peserta pendaftaran.


- **📝Typo**
	- [*] Ganti nama kolom `nilai dibawah` menjadi `nilai dibawah rata - rata ijazah`  
	- [*] Ganti field `nomer telepon` menjadi `Nomer Whatsapp Aktif` 
	- [*] Ganti pilihan jenis pembayaran `['Formulir', 'Registrasi']` menjadi `['Pendaftaran', 'Registrasi']

	- [*] Hapus tulisan `Pilihan Fakultas` di menu pembayaran *(admin)* 
	- [*] Hapus informasi sejarah dari Kampus
	- [ ] *coming soon* 

- **⚠Validasi**
	- [ ] Validasi input NIK 16 Digits
	- [ ] *coming soon*

- **👾Bugs & Errors**
	- Terjadi error saat meload  table pembayaran. `property prodi is null` 
	- Pada tampilan pembayaran tidak muncul identitas dari peserta yang melakukan pembayaran `Kode Pembayaran!` 
	
- **🛠Fitur yang perlu direvisi**
	- Fitur export data peserta yang telah melakukan pembayaran biaya pendaftaran
	- Tambah menu untuk **laporan** data peserta yang telah berhasil melakukan pembayaran registrasi dengan filter berdasarkan gelombang, prodi, dan tahun akademik
	- Fitur untuk mengedit informasi brosur dan rincian harga
	- Realtime Notifikasi *jika memungkinkan*
	
- **💎Fitur yang ditekankan pada sistem**
	- [ ] Membuat notifikasi atau pemberitahuan melalui WhatsApp
		- Peserta mengirimkan pembayaran pendaftaran, kirim notif ke Admin
		- Admin menerima dan menyetujui/menolak pembayaran, kirim notif ke Peserta
		- Peserta mengajukan pendaftaran setelah melengkapi data diri dst, kirim notif ke Admin
		- Admin menyetujui/menolak kelengkapan data peserta, kirim notif ke Peserta
		- Peserta mengirimkan hasil ujian, kirim notif ke Admin
		- Admin memeriksa hasil ujian dan kirim notif ke Peserta
		- Peserta melakukan pembayaran registrasi, kirim ke notif Admin
		- Admin melakukan verifikasi pembayaran, kirim ke notif Peserta
	- [ ] Generate NIM secara otomatis jika pembayaran terverifikasi. Opsi NIM `(kode_jurusan:tahun_akademik:kelas['pagi','sore']:no_urut)`
	
