<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customer';        // nama tabel lama
    protected $primaryKey = 'id_customer';// sesuaikan PK tabel lama
    public $timestamps = false;           // DB lama biasanya tidak pakai created_at/updated_at

    // isi kolom sesuai tabel kamu
    protected $fillable = [
        'nama_customer',
        'alamat',
        'kontak',
    ];
}