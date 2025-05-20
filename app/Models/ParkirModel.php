<?php

namespace App\Models;

use CodeIgniter\Model;

class ParkirModel extends Model
{
    protected $table = 'parkir';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'no_polisi',
        'jenis_kendaraan',
        'harga_per_jam',
        'waktu',
        'status',
        'total_bayar'
    ];

    protected $useTimestamps = false;
}
