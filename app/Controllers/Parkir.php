<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ParkirModel;

class Parkir extends BaseController
{
    public function index()
    {
        $model = new ParkirModel();

        // Data untuk dropdown jenis kendaraan
        $jenisKendaraan = [
            ['jenis' => 'Motor', 'harga' => 3000],
            ['jenis' => 'Mini Bus', 'harga' => 5000],
            ['jenis' => 'Truck', 'harga' => 7000],
            ['jenis' => 'Bus', 'harga' => 10000],
        ];

        // Ambil data riwayat parkir
        $data['riwayat'] = $model->orderBy('id', 'DESC')->findAll();
        $data['kendaraanList'] = $jenisKendaraan;

        return view('parkir', $data);
    }

    public function simpan()
    {
        $model = new ParkirModel();
        $jenis = $this->request->getPost('jenis_kendaraan');
        $nopol = strtoupper($this->request->getPost('no_polisi'));
        $hargaPerJam = (int)$this->request->getPost('harga');
        $now = date('Y-m-d H:i:s');

        // Cek apakah kendaraan sudah masuk tapi belum keluar
        $existing = $model->where(['no_polisi' => $nopol, 'status' => 'MASUK'])->first();

        if (!$existing) {
            // Belum masuk → Simpan sebagai MASUK
            $model->save([
                'no_polisi' => $nopol,
                'jenis_kendaraan' => $jenis,
                'harga_per_jam' => $hargaPerJam,
                'waktu' => $now,
                'status' => 'MASUK'
            ]);
        } else {
            // Sudah masuk → hitung durasi dan simpan KELUAR
            $waktuMasuk = strtotime($existing['waktu']);
            $waktuKeluar = strtotime($now);
            $durasiJam = ceil(($waktuKeluar - $waktuMasuk) / 3600); // Jam dibulatkan ke atas

            $biaya = $hargaPerJam;
            if ($durasiJam > 1) {
                $biaya += ($durasiJam - 1) * 2000;
            }

            $model->save([
                'no_polisi' => $nopol,
                'jenis_kendaraan' => $existing['jenis_kendaraan'],
                'harga_per_jam' => $existing['harga_per_jam'],
                'waktu' => $now,
                'status' => 'KELUAR',
                'total_bayar' => $biaya
            ]);
        }

        return redirect()->to('/');
    }

    public function keluar($id)
    {
        $model = new ParkirModel();
        $data = $model->find($id);

        if (!$data || $data['status'] == 'KELUAR') {
            return redirect()->to('/')->with('error', 'Data tidak ditemukan atau kendaraan sudah keluar.');
        }

        $now = date('Y-m-d H:i:s');
        $waktuMasuk = strtotime($data['waktu']);
        $waktuKeluar = strtotime($now);
        $durasiJam = ceil(($waktuKeluar - $waktuMasuk) / 3600); // Dibulatkan ke atas

        $biaya = $data['harga_per_jam'];
        if ($durasiJam > 1) {
            $biaya += ($durasiJam - 1) * 2000;
        }

        $model->update($id, [
            'waktu_keluar' => $now,
            'status' => 'KELUAR',
            'total_bayar' => $biaya
        ]);

        return redirect()->to('/')->with('success', 'Kendaraan berhasil dikeluarkan.');
    }

    public function penghasilan()
    {
        $model = new ParkirModel();

        // Ambil semua data kendaraan yang sudah keluar
        $riwayatKeluar = $model->where('status', 'KELUAR')->orderBy('waktu_keluar', 'DESC')->findAll();

        // Hitung total pendapatan
        $totalPendapatan = 0;
        foreach ($riwayatKeluar as $item) {
            $totalPendapatan += $item['total_bayar'];
        }

        $data = [
            'riwayatKeluar' => $riwayatKeluar,
            'totalPendapatan' => $totalPendapatan
        ];

        return view('penghasilan', $data);
    }
}
