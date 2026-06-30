<?php

namespace App\Models\Keuangan;

use Illuminate\Database\Eloquent\Model;

class TransaksiHarian extends Model
{
    protected $table = 'vw_transaksi_harian';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;
}