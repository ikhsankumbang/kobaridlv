<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratJalanDetail extends Model
{
    use HasFactory;

    protected $table = 'surat_jalan_detail';
    public $timestamps = false;

    protected $fillable = [
        'do_no',
        'no_part',
        'qty_pengiriman',
        'keterangan',
    ];

    // Relasi ke SuratJalan
    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class, 'do_no', 'do_no');
    }

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'no_part', 'no_part');
    }

    // Accessor untuk qty (backward compatibility)
    public function getQtyAttribute()
    {
        return $this->qty_pengiriman;
    }
}
