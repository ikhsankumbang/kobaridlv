<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $table = 'purchase_order';
    protected $primaryKey = 'po_no';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'po_no',
        'id_customer',
        'tanggal',
        'schedule_delivery',
        'status',
    ];

    // Relasi ke Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    // Relasi ke Detail
    public function details()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'po_no', 'po_no');
    }
}
