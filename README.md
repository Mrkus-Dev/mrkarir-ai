# MrKarir AI Indonesia

Portal informasi lowongan kerja berbasis web yang sedang dikembangkan untuk membantu pencari kerja menemukan lowongan dengan lebih mudah, cepat, dan aman.

## Status Proyek

**MVP / dalam pengembangan aktif.**

Proyek ini belum dirilis sebagai layanan produksi. Fitur dan struktur aplikasi dapat berubah selama proses pengembangan.

## Tujuan

- Menyajikan informasi lowongan dalam tampilan yang sederhana
- Memudahkan pencarian dan penyaringan lowongan
- Menyembunyikan lowongan yang sudah kedaluwarsa
- Menyediakan fondasi API yang aman untuk integrasi berikutnya
- Mengembangkan notifikasi lowongan melalui Telegram
- Membantu pengguna membuat CV dan mempelajari informasi karier

## Fitur yang Telah Dikerjakan

- Daftar lowongan kerja
- Halaman detail lowongan
- Pencarian dan filter
- Pagination
- Penyembunyian otomatis lowongan kedaluwarsa
- Validasi API key
- Rate limiting dengan respons HTTP 429
- Prepared statements
- Pengujian terhadap SQL injection
- Dokumentasi dasar proyek

## Hasil Pengujian

Hasil pengujian terakhir yang dicatat:

| Hasil | Jumlah |
|---|---:|
| PASS | 134 |
| FAIL | 0 |
| SKIP | 5 |

Hasil tersebut menggambarkan kondisi pada tahap pengembangan yang diuji, bukan jaminan bahwa aplikasi telah siap digunakan dalam produksi.

## Teknologi

- PHP 8.5
- Python 3.14
- JavaScript
- HTML dan CSS
- SQLite 3
- Git
- Bash dan Termux
- Cloudflare untuk rencana infrastruktur web

## Keamanan Dasar

Fondasi keamanan yang sudah diterapkan atau diuji:

- Prepared statements untuk query database
- Pemeriksaan API key
- Pembatasan permintaan API
- Respons HTTP 429 ketika batas permintaan terlampaui
- Pengujian input terhadap SQL injection
- Pemisahan konfigurasi rahasia melalui file environment

> Audit keamanan lanjutan tetap diperlukan sebelum deployment produksi.

## Roadmap

- [x] Fondasi MVP
- [x] Daftar, detail, pencarian, filter, dan pagination
- [x] Validasi API key dan rate limiting
- [x] Pengujian dasar aplikasi
- [x] Repositori publik proyek
- [ ] Publikasi source code yang sudah diaudit
- [ ] Integrasi sumber lowongan resmi
- [ ] Integrasi notifikasi Telegram
- [ ] Fitur pembuatan CV
- [ ] Artikel dan panduan karier
- [ ] Penyempurnaan UI/UX dan aksesibilitas
- [ ] Audit keamanan
- [ ] Deployment produksi

## Rencana Sumber Informasi Lowongan

Integrasi hanya akan dilakukan melalui API, RSS, sumber resmi, atau metode lain yang diizinkan oleh pemilik layanan.

Sumber yang dipertimbangkan:

- KarirHub Kemnaker
- Pasker ID Kemnaker
- SSCASN BKN
- FHCI BUMN
- JobStreet Indonesia
- LinkedIn Jobs
- Glints Indonesia
- Indeed Indonesia

## Website dan Kontak

- Website: [mrkarirai.web.id](https://mrkarirai.web.id)
- Telegram Bot: [@MrKarirAIBot](https://t.me/MrKarirAIBot)
- Instagram: [@m_rkus1](https://www.instagram.com/m_rkus1/)
- Telegram: [@null_mrk](https://t.me/null_mrk)
- Pengembang: [Mrkus-Dev](https://github.com/Mrkus-Dev)

## Catatan Keamanan dan Etika

MrKarir AI ditujukan sebagai alat bantu informasi. Setiap sumber lowongan harus digunakan sesuai izin, ketentuan layanan, dan kebijakan pemilik sumber.

Pengguna tetap perlu memverifikasi keaslian lowongan sebelum:

- Mengirim data pribadi
- Mengunggah dokumen identitas
- Mengikuti wawancara
- Melakukan pembayaran

MrKarir AI tidak mendukung lowongan palsu, penipuan rekrutmen, pengumpulan data tanpa izin, atau permintaan pembayaran yang mencurigakan.

## Lisensi

Lisensi belum ditetapkan. Seluruh hak atas source code tetap dimiliki pengembang sampai file lisensi resmi ditambahkan.
