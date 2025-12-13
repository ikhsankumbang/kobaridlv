<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'detail_purchase_order';
    public $timestamps = false;

    protected $fillable = [
        'po_no',
        'no_part',
        'qty_pemesanan',
    ];

    // Accessor untuk qty (supaya compatible dengan view)
    public function getQtyAttribute()
    {
        return $this->qty_pemesanan;
    }

    // Relasi ke PurchaseOrder
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_no', 'po_no');
    }

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'no_part', 'no_part');
    }
}
