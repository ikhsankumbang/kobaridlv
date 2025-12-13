<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use App\Models\PurchaseOrder;
use App\Models\Pegawai;
use App\Models\Barang;

class SuratJalanController extends Controller
{
    public function index()
    {
        $suratJalans = SuratJalan::with(['purchaseOrder', 'preparedBy', 'checkedBy', 'securityPegawai', 'driverPegawai'])->orderBy('tanggal', 'desc')->get();
        return view('surat_jalan.index', compact('suratJalans'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::all();
        $pegawais = Pegawai::all();
        return view('surat_jalan.create', compact('purchaseOrders', 'pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'do_no'   => 'required|max:50|unique:surat_jalan,do_no',
            'po_no'   => 'required',
            'tanggal' => 'required|date',
        ]);

        SuratJalan::create([
            'do_no'        => $request->do_no,
            'po_no'        => $request->po_no,
            'tanggal'      => $request->tanggal,
            'prepared_by'  => $request->prepared_by,
            'checked_by'   => $request->checked_by,
            'security'     => $request->security,
            'driver'       => $request->driver,
            'received'     => $request->received,
            'no_kendaraan' => $request->no_kendaraan,
        ]);

        return redirect('/surat-jalan/detail/' . $request->do_no);
    }

    public function edit($do_no)
    {
        $suratJalan = SuratJalan::where('do_no', $do_no)->firstOrFail();
        $purchaseOrders = PurchaseOrder::all();
        $pegawais = Pegawai::all();
        return view('surat_jalan.edit', compact('suratJalan', 'purchaseOrders', 'pegawais'));
    }

    public function update(Request $request, $do_no)
    {
        $request->validate([
            'po_no'   => 'required',
            'tanggal' => 'required|date',
        ]);

        $suratJalan = SuratJalan::where('do_no', $do_no)->firstOrFail();
        $suratJalan->update([
            'po_no'        => $request->po_no,
            'tanggal'      => $request->tanggal,
            'prepared_by'  => $request->prepared_by,
            'checked_by'   => $request->checked_by,
            'security'     => $request->security,
            'driver'       => $request->driver,
            'received'     => $request->received,
            'no_kendaraan' => $request->no_kendaraan,
        ]);

        return redirect('/surat-jalan');
    }

    public function delete($do_no)
    {
        SuratJalanDetail::where('do_no', $do_no)->delete();
        $suratJalan = SuratJalan::where('do_no', $do_no)->firstOrFail();
        $suratJalan->delete();
        return redirect('/surat-jalan');
    }

    public function detail($do_no)
    {
        $suratJalan = SuratJalan::with(['purchaseOrder.customer', 'details.barang'])->where('do_no', $do_no)->firstOrFail();
        $barangs = Barang::all();
        return view('surat_jalan.detail', compact('suratJalan', 'barangs'));
    }

    public function detailAddForm($do_no)
    {
        $suratJalan = SuratJalan::where('do_no', $do_no)->firstOrFail();
        $barangs = Barang::all();
        return view('surat_jalan.detail_add', compact('suratJalan', 'barangs'));
    }

    public function addDetail(Request $request, $do_no)
    {
        $request->validate([
            'no_part' => 'required',
            'qty'     => 'required|numeric|min:1',
        ]);

        SuratJalanDetail::create([
            'do_no'   => $do_no,
            'no_part' => $request->no_part,
            'qty'     => $request->qty,
        ]);

        return redirect('/surat-jalan/detail/' . $do_no);
    }

    public function deleteDetail($do_no, $no_part)
    {
        SuratJalanDetail::where('do_no', $do_no)->where('no_part', $no_part)->delete();
        return redirect('/surat-jalan/detail/' . $do_no);
    }

    public function cetak($do_no)
    {
        $suratJalan = SuratJalan::with(['purchaseOrder.customer', 'details.barang', 'preparedBy', 'checkedBy', 'securityPegawai', 'driverPegawai'])->where('do_no', $do_no)->firstOrFail();
        return view('surat_jalan.cetak', compact('suratJalan'));
    }
}
