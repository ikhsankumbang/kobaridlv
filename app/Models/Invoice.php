<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $primaryKey = 'no_invoice';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'no_invoice',
        'tanggal',
        'nsfp',
        'subtotal',
        'ppn',
        'total_harga',
    ];

    // Relasi ke Surat Jalan melalui tabel pivot
    public function suratJalans()
    {
        return $this->belongsToMany(SuratJalan::class, 'invoice_suratjalan', 'no_invoice', 'do_no');
    }
}
