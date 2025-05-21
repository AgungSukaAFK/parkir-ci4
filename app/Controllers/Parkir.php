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
    $no_polisi = $this->request->getPost('no_polisi');
    $jenis_kendaraan = $this->request->getPost('jenis_kendaraan');
    $harga_per_jam = $this->request->getPost('harga');

    $parkirModel = new \App\Models\ParkirModel();

    $dataMasuk = $parkirModel->where('no_polisi', $no_polisi)
                             ->where('status', 'MASUK')
                             ->first();

    if ($dataMasuk) {
    // Kendaraan keluar
    $waktu_masuk = new \DateTime($dataMasuk['waktu']);
    $waktu_keluar = new \DateTime();


    $selisih_jam = ceil(($waktu_keluar->getTimestamp() - $waktu_masuk->getTimestamp()) / 3600); // hitung jam dibulatkan ke atas
    $harga_per_jam = (int) $dataMasuk['harga_per_jam'];

    // Hitung total bayar
    if ($selisih_jam <= 1) {
        $total_bayar = $harga_per_jam;
    } else {
        $total_bayar = $harga_per_jam + (($selisih_jam - 1) * 2000);
    }

    $parkirModel->update($dataMasuk['id'], [
        'waktu_keluar' => $waktu_keluar->format('Y-m-d H:i:s'),
        'status'       => 'KELUAR',
        'total_bayar'  => $total_bayar
    ]);

    return redirect()->back()->with('message', 'Kendaraan keluar. Total bayar: Rp ' . number_format($total_bayar, 0, ',', '.'));
}
 else {
        // Kendaraan masuk
        $parkirModel->insert([
            'no_polisi'       => $no_polisi,
            'jenis_kendaraan' => $jenis_kendaraan,
            'harga_per_jam'   => $harga_per_jam,
            'waktu'           => date('Y-m-d H:i:s'),
            'status'          => 'MASUK'
        ]);

        return redirect()->back()->with('message', 'Kendaraan masuk berhasil dicatat.');
    }
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

        $model->save([
    'id' => $dataMasuk['id'],
    'status' => 'KELUAR',
    'waktu_keluar' => $waktu_keluar->format('Y-m-d H:i:s'),
    'total_bayar' => $total_bayar
]);

// Simpan ke penghasilan_parkir
$db = \Config\Database::connect();
$db->table('penghasilan_parkir')->insert([
    'parkir_id' => $dataMasuk['id'],
    'no_polisi' => $dataMasuk['no_polisi'],
    'jenis_kendaraan' => $dataMasuk['jenis_kendaraan'],
    'waktu_masuk' => $dataMasuk['waktu'],
    'waktu_keluar' => $waktu_keluar->format('Y-m-d H:i:s'),
    'durasi_jam' => $durasi_jam,
    'total_bayar' => $total_bayar
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
