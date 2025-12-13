<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalan extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan';
    protected $primaryKey = 'do_no';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'do_no',
        'po_no',
        'tanggal',
        'prepared_by',
        'checked_by',
        'security',
        'driver',
        'received',
        'no_kendaraan',
    ];

    // Relasi ke PurchaseOrder
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_no', 'po_no');
    }

    // Relasi ke Pegawai
    public function preparedBy()
    {
        return $this->belongsTo(Pegawai::class, 'prepared_by', 'id_pegawai');
    }

    public function checkedBy()
    {
        return $this->belongsTo(Pegawai::class, 'checked_by', 'id_pegawai');
    }

    public function securityPegawai()
    {
        return $this->belongsTo(Pegawai::class, 'security', 'id_pegawai');
    }

    public function driverPegawai()
    {
        return $this->belongsTo(Pegawai::class, 'driver', 'id_pegawai');
    }

    // Relasi ke Detail
    public function details()
    {
        return $this->hasMany(SuratJalanDetail::class, 'do_no', 'do_no');
    }
}
