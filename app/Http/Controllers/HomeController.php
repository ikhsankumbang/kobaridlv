<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Barang;
use App\Models\Pegawai;
use App\Models\PurchaseOrder;
use App\Models\SuratJalan;
use App\Models\Invoice;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'customers'       => Customer::count(),
            'barangs'         => Barang::count(),
            'pegawais'        => Pegawai::count(),
            'purchaseOrders'  => PurchaseOrder::count(),
            'suratJalans'     => SuratJalan::count(),
            'invoices'        => Invoice::count(),
        ];

        return view('home.index', compact('stats'));
    }
}
