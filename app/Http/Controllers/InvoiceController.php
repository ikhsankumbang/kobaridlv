<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\SuratJalan;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('suratJalans.purchaseOrder')->get();
        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $suratJalans = SuratJalan::with('purchaseOrder.customer')->get();
        return view('invoice.create', compact('suratJalans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_invoice' => 'required|max:50|unique:invoice,no_invoice',
            'tanggal'    => 'required|date',
            'do_no'      => 'required|array|min:1',
        ]);

        $subtotal = 0;
        foreach ($request->do_no as $do_no) {
            $sj = SuratJalan::with('details.barang')->where('do_no', $do_no)->first();
            if ($sj) {
                foreach ($sj->details as $detail) {
                    $subtotal += ($detail->barang->harga ?? 0) * $detail->qty;
                }
            }
        }

        $ppn = $subtotal * 0.11;
        $total = $subtotal + $ppn;

        $invoice = Invoice::create([
            'no_invoice'  => $request->no_invoice,
            'tanggal'     => $request->tanggal,
            'nsfp'        => $request->nsfp,
            'subtotal'    => $subtotal,
            'ppn'         => $ppn,
            'total_harga' => $total,
        ]);

        $invoice->suratJalans()->attach($request->do_no);

        return redirect('/invoice');
    }

    public function edit($no_invoice)
    {
        $invoice = Invoice::with('suratJalans')->where('no_invoice', $no_invoice)->firstOrFail();
        $suratJalans = SuratJalan::with('purchaseOrder.customer')->get();
        return view('invoice.edit', compact('invoice', 'suratJalans'));
    }

    public function update(Request $request, $no_invoice)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'do_no'   => 'required|array|min:1',
        ]);

        $invoice = Invoice::where('no_invoice', $no_invoice)->firstOrFail();

        $subtotal = 0;
        foreach ($request->do_no as $do_no) {
            $sj = SuratJalan::with('details.barang')->where('do_no', $do_no)->first();
            if ($sj) {
                foreach ($sj->details as $detail) {
                    $subtotal += ($detail->barang->harga ?? 0) * $detail->qty;
                }
            }
        }

        $ppn = $subtotal * 0.11;
        $total = $subtotal + $ppn;

        $invoice->update([
            'tanggal'     => $request->tanggal,
            'nsfp'        => $request->nsfp,
            'subtotal'    => $subtotal,
            'ppn'         => $ppn,
            'total_harga' => $total,
        ]);

        $invoice->suratJalans()->sync($request->do_no);

        return redirect('/invoice');
    }

    public function delete($no_invoice)
    {
        $invoice = Invoice::where('no_invoice', $no_invoice)->firstOrFail();
        $invoice->suratJalans()->detach();
        $invoice->delete();
        return redirect('/invoice');
    }

    public function detail($no_invoice)
    {
        $invoice = Invoice::with('suratJalans.details.barang', 'suratJalans.purchaseOrder.customer')->where('no_invoice', $no_invoice)->firstOrFail();
        return view('invoice.detail', compact('invoice'));
    }

    public function cetak($no_invoice)
    {
        $invoice = Invoice::with('suratJalans.details.barang', 'suratJalans.purchaseOrder.customer')->where('no_invoice', $no_invoice)->firstOrFail();
        return view('invoice.cetak', compact('invoice'));
    }
}
