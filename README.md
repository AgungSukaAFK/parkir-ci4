Berikut ini contoh update README.md untuk project parkir kamu, dengan tambahan penjelasan fitur dan struktur database yang kamu gunakan, termasuk fitur baru penghasilan:

---

# CodeIgniter 4 Application Starter - Parking Management

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter, built from the [development repository](https://github.com/codeigniter4/CodeIgniter4).

You can read the [user guide](https://codeigniter.com/user_guide/) corresponding to the latest version of the framework.

---

## Installation & updates

Run:

```bash
composer create-project codeigniter4/appstarter
composer update
```

Check release notes for updates related to the `app` folder.

---

## Setup

Copy `.env` from `env` and configure your `baseURL` and database settings.

---

## Important Change with index.php

`index.php` is inside the _public_ folder for security reasons.
Configure your web server to point to the _public_ folder, not project root.

---

## Repository Management

Bug reports and feature requests are handled on the [CodeIgniter forum](http://forum.codeigniter.com).

---

## Server Requirements

PHP 8.1+ with intl, mbstring, json, mysqlnd, and libcurl extensions enabled.

---

## Parking Management Application Features

- **Input Kendaraan Masuk**
  Input kendaraan baru dengan data nomor polisi, jenis kendaraan, dan waktu masuk.

- **Kendaraan Keluar**
  Proses keluar kendaraan dengan perhitungan biaya parkir berdasarkan durasi.
  Tarif dasar per jam tergantung jenis kendaraan, dengan biaya tambahan per jam setelah jam pertama.

- **Riwayat Parkir**
  Menampilkan daftar kendaraan yang masuk dan keluar beserta status, waktu, dan total bayar.

- **Penghasilan Parkir**
  Menampilkan ringkasan kendaraan yang sudah keluar dan total pendapatan dari parkir.

---

## Struktur Database

### Tabel utama: `parkir`

| Field             | Tipe Data                         | Keterangan                                 |
| ----------------- | --------------------------------- | ------------------------------------------ |
| `id`              | INT (Primary Key, Auto Increment) | ID unik setiap transaksi parkir            |
| `no_polisi`       | VARCHAR                           | Nomor polisi kendaraan                     |
| `jenis_kendaraan` | VARCHAR                           | Jenis kendaraan (Motor, Bus, dll)          |
| `harga_per_jam`   | INT                               | Tarif dasar per jam                        |
| `waktu`           | DATETIME                          | Waktu kendaraan masuk                      |
| `waktu_keluar`    | DATETIME NULL                     | Waktu kendaraan keluar (diisi saat keluar) |
| `status`          | ENUM('MASUK','KELUAR')            | Status kendaraan (masuk/keluar)            |
| `total_bayar`     | INT NULL                          | Total biaya parkir (diisi saat keluar)     |

---

### Tabel tambahan: `penghasilan_parkir`

| Field             | Tipe Data                          | Keterangan                                      |
| ----------------- | ---------------------------------- | ----------------------------------------------- |
| `id`              | INT (Primary Key, Auto Increment)  | ID unik data penghasilan                        |
| `parkir_id`       | INT                                | Relasi ke ID di tabel `parkir`                  |
| `no_polisi`       | VARCHAR                            | Nomor polisi kendaraan                          |
| `jenis_kendaraan` | VARCHAR                            | Jenis kendaraan (Motor, Mobil, dll)             |
| `waktu_masuk`     | DATETIME                           | Waktu kendaraan masuk                           |
| `waktu_keluar`    | DATETIME                           | Waktu kendaraan keluar                          |
| `durasi_jam`      | INT                                | Durasi total parkir dalam jam                   |
| `total_bayar`     | INT                                | Total biaya parkir yang dibayar                 |
| `created_at`      | DATETIME DEFAULT CURRENT_TIMESTAMP | Tanggal dan waktu data ini dicatat di tabel ini |

---

## Routes (Contoh)

```php
$routes->get('/', 'Parkir::index');
$routes->post('parkir/simpan', 'Parkir::simpan');
$routes->get('parkir/keluar/(:num)', 'Parkir::keluar/$1');
$routes->get('parkir/penghasilan', 'Parkir::penghasilan');
```

---

## Controller Highlight

- `Parkir::index()`
  Menampilkan halaman input dan riwayat parkir.

- `Parkir::simpan()`
  Proses simpan kendaraan masuk dan keluar dengan hitung biaya parkir.

- `Parkir::keluar($id)`
  Menandai kendaraan dengan `id` tertentu sebagai keluar, menghitung biaya, dan update data.

- `Parkir::penghasilan()`
  Menampilkan data riwayat kendaraan keluar dan total pendapatan.

---

## Notes

- Tarif dasar per jam disesuaikan dengan jenis kendaraan.
- Biaya tambahan Rp2.000 per jam setelah jam pertama dihitung saat keluar.
- `waktu_keluar` dan `total_bayar` diupdate saat kendaraan keluar.
- Fitur alert menggunakan AdminLTE demo.js sudah bisa diterapkan untuk notifikasi sukses/gagal operasi.

---

Kalau kamu mau aku buatkan contoh file SQL untuk bikin tabel `parkir` sesuai di atas, tinggal bilang ya!
