<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // 1. Beritahu Laravel nama tabelmu
    protected $table = 'barang';

    // 2. Beritahu Laravel primary key-nya bukan 'id', tapi 'no_part'
    protected $primaryKey = 'no_part';

    // 3. PENTING: Jika 'no_part' isinya huruf (misal: BRG-001), aktifkan ini. 
    // Jika isinya angka saja, hapus baris ini.
    protected $keyType = 'string'; 

    // 4. Matikan timestamps jika tabelmu tidak punya kolom created_at & updated_at
    public $timestamps = false;

    // 5. Kolom yang boleh diisi
    protected $fillable = ['no_part', 'nama_barang', 'qty', 'harga'];
}