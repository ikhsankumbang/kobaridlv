<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Customer;
use App\Models\Barang;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('customer')->get();
        return view('purchase_order.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('purchase_order.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'po_no'             => 'required|max:50|unique:purchase_order,po_no',
            'id_customer'       => 'required',
            'tanggal'           => 'required|date',
            'schedule_delivery' => 'required|date',
        ]);

        PurchaseOrder::create([
            'po_no'             => $request->po_no,
            'id_customer'       => $request->id_customer,
            'tanggal'           => $request->tanggal,
            'schedule_delivery' => $request->schedule_delivery,
        ]);

        return redirect('/purchase-order/detail/' . $request->po_no);
    }

    public function edit($po_no)
    {
        $purchaseOrder = PurchaseOrder::where('po_no', $po_no)->firstOrFail();
        $customers = Customer::all();
        return view('purchase_order.edit', compact('purchaseOrder', 'customers'));
    }

    public function update(Request $request, $po_no)
    {
        $request->validate([
            'id_customer'       => 'required',
            'tanggal'           => 'required|date',
            'schedule_delivery' => 'required|date',
            'status'            => 'required',
        ]);

        $purchaseOrder = PurchaseOrder::where('po_no', $po_no)->firstOrFail();
        $purchaseOrder->update([
            'id_customer'       => $request->id_customer,
            'tanggal'           => $request->tanggal,
            'schedule_delivery' => $request->schedule_delivery,
            'status'            => $request->status,
        ]);

        return redirect('/purchase-order');
    }

    public function delete($po_no)
    {
        // Hapus detail dulu
        PurchaseOrderDetail::where('po_no', $po_no)->delete();
        // Hapus master
        $purchaseOrder = PurchaseOrder::where('po_no', $po_no)->firstOrFail();
        $purchaseOrder->delete();
        return redirect('/purchase-order');
    }

    public function detail($po_no)
    {
        $purchaseOrder = PurchaseOrder::with(['customer', 'details.barang'])->where('po_no', $po_no)->firstOrFail();
        $barangs = Barang::all();
        return view('purchase_order.detail', compact('purchaseOrder', 'barangs'));
    }

    public function detailAddForm($po_no)
    {
        $purchaseOrder = PurchaseOrder::where('po_no', $po_no)->firstOrFail();
        $barangs = Barang::all();
        return view('purchase_order.detail_add', compact('purchaseOrder', 'barangs'));
    }

    public function addDetail(Request $request, $po_no)
    {
        $request->validate([
            'no_part' => 'required',
            'qty'     => 'required|numeric|min:1',
        ]);

        $barang = Barang::where('no_part', $request->no_part)->firstOrFail();
        $subtotal = $request->qty * $barang->harga;

        PurchaseOrderDetail::create([
            'po_no'         => $po_no,
            'no_part'       => $request->no_part,
            'qty_pemesanan' => $request->qty,
        ]);

        return redirect('/purchase-order/detail/' . $po_no);
    }

    public function deleteDetail($po_no, $no_part)
    {
        PurchaseOrderDetail::where('po_no', $po_no)->where('no_part', $no_part)->delete();
        return redirect('/purchase-order/detail/' . $po_no);
    }

    public function cetak($po_no)
    {
        $purchaseOrder = PurchaseOrder::with(['customer', 'details.barang'])->where('po_no', $po_no)->firstOrFail();
        return view('purchase_order.cetak', compact('purchaseOrder'));
    }
}
