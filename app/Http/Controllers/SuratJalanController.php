<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratJalan;
use App\Models\SuratJalanDetail;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Pegawai;
use App\Models\Barang;
use Illuminate\Support\Facades\DB;

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
        // Kembalikan stok untuk semua detail sebelum hapus
        $suratJalan = SuratJalan::where('do_no', $do_no)->firstOrFail();
        $details = SuratJalanDetail::where('do_no', $do_no)->get();
        
        foreach ($details as $detail) {
            Barang::where('no_part', $detail->no_part)
                ->increment('qty', $detail->qty_pengiriman);
        }
        
        SuratJalanDetail::where('do_no', $do_no)->delete();
        $suratJalan->delete();
        
        return redirect('/surat-jalan');
    }

    public function detail($do_no)
    {
        $suratJalan = SuratJalan::with(['purchaseOrder.customer', 'purchaseOrder.details', 'details.barang'])->where('do_no', $do_no)->firstOrFail();
        
        // Ambil barang dari PO yang terkait dengan sisa qty
        $po_no = $suratJalan->po_no;
        $barangs = DB::table('detail_purchase_order as dp')
            ->join('barang as b', 'dp.no_part', '=', 'b.no_part')
            ->leftJoin(DB::raw("(SELECT sjd.no_part, SUM(sjd.qty_pengiriman) as total_terkirim 
                FROM surat_jalan_detail sjd 
                JOIN surat_jalan sj ON sjd.do_no = sj.do_no 
                WHERE sj.po_no = '{$po_no}' 
                GROUP BY sjd.no_part) as terkirim"), 'dp.no_part', '=', 'terkirim.no_part')
            ->where('dp.po_no', $po_no)
            ->select('dp.no_part', 'b.nama_barang', 'b.harga', 'b.qty as stok', 'dp.qty_pemesanan', 
                DB::raw('COALESCE(terkirim.total_terkirim, 0) as total_terkirim'),
                DB::raw('(dp.qty_pemesanan - COALESCE(terkirim.total_terkirim, 0)) as sisa'))
            ->having('sisa', '>', 0)
            ->get();
        
        return view('surat_jalan.detail', compact('suratJalan', 'barangs'));
    }

    public function detailAddForm($do_no)
    {
        $suratJalan = SuratJalan::with('purchaseOrder')->where('do_no', $do_no)->firstOrFail();
        $po_no = $suratJalan->po_no;
        
        // Ambil barang dari PO yang terkait dengan sisa qty
        $barangs = DB::table('detail_purchase_order as dp')
            ->join('barang as b', 'dp.no_part', '=', 'b.no_part')
            ->leftJoin(DB::raw("(SELECT sjd.no_part, SUM(sjd.qty_pengiriman) as total_terkirim 
                FROM surat_jalan_detail sjd 
                JOIN surat_jalan sj ON sjd.do_no = sj.do_no 
                WHERE sj.po_no = '{$po_no}' 
                GROUP BY sjd.no_part) as terkirim"), 'dp.no_part', '=', 'terkirim.no_part')
            ->where('dp.po_no', $po_no)
            ->select('dp.no_part', 'b.nama_barang', 'b.harga', 'b.qty as stok', 'dp.qty_pemesanan', 
                DB::raw('COALESCE(terkirim.total_terkirim, 0) as total_terkirim'),
                DB::raw('(dp.qty_pemesanan - COALESCE(terkirim.total_terkirim, 0)) as sisa'))
            ->having('sisa', '>', 0)
            ->get();
        
        return view('surat_jalan.detail_add', compact('suratJalan', 'barangs'));
    }

    public function addDetail(Request $request, $do_no)
    {
        $request->validate([
            'no_part'         => 'required',
            'qty_pengiriman'  => 'required|numeric|min:1',
        ]);

        $suratJalan = SuratJalan::where('do_no', $do_no)->firstOrFail();
        $po_no = $suratJalan->po_no;
        $no_part = $request->no_part;
        $qty_pengiriman = (int) $request->qty_pengiriman;

        // Cek apakah barang ada di PO
        $poDetail = PurchaseOrderDetail::where('po_no', $po_no)
            ->where('no_part', $no_part)
            ->first();
        
        if (!$poDetail) {
            return back()->withErrors(['no_part' => 'Barang tidak termasuk dalam Purchase Order ini.']);
        }

        // Hitung total terkirim untuk part ini di semua SJ terkait PO
        $totalTerkirim = DB::table('surat_jalan_detail as sjd')
            ->join('surat_jalan as sj', 'sjd.do_no', '=', 'sj.do_no')
            ->where('sj.po_no', $po_no)
            ->where('sjd.no_part', $no_part)
            ->sum('sjd.qty_pengiriman');

        $sisaPemesanan = $poDetail->qty_pemesanan - $totalTerkirim;
        
        if ($qty_pengiriman > $sisaPemesanan) {
            return back()->withErrors(['qty_pengiriman' => "Jumlah pengiriman melebihi sisa pemesanan. Sisa: $sisaPemesanan"]);
        }

        // Cek stok barang
        $barang = Barang::where('no_part', $no_part)->first();
        if ($qty_pengiriman > $barang->qty) {
            return back()->withErrors(['qty_pengiriman' => "Jumlah pengiriman melebihi stok barang. Stok: {$barang->qty}"]);
        }

        DB::beginTransaction();
        try {
            // Cek apakah sudah ada detail dengan no_part yang sama di DO ini
            $existingDetail = SuratJalanDetail::where('do_no', $do_no)
                ->where('no_part', $no_part)
                ->first();

            if ($existingDetail) {
                // Update qty jika sudah ada
                $existingDetail->update([
                    'qty_pengiriman' => $existingDetail->qty_pengiriman + $qty_pengiriman,
                    'keterangan' => $request->keterangan,
                ]);
            } else {
                // Insert baru
                SuratJalanDetail::create([
                    'do_no'           => $do_no,
                    'no_part'         => $no_part,
                    'qty_pengiriman'  => $qty_pengiriman,
                    'keterangan'      => $request->keterangan,
                ]);
            }

            // Kurangi stok barang
            $barang->decrement('qty', $qty_pengiriman);

            // Cek apakah semua barang di PO sudah terkirim semua
            $this->updatePOStatus($po_no);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }

        return redirect('/surat-jalan/detail/' . $do_no);
    }

    public function deleteDetail($do_no, $no_part)
    {
        $suratJalan = SuratJalan::where('do_no', $do_no)->firstOrFail();
        $po_no = $suratJalan->po_no;

        $detail = SuratJalanDetail::where('do_no', $do_no)
            ->where('no_part', $no_part)
            ->first();

        if ($detail) {
            DB::beginTransaction();
            try {
                // Kembalikan stok barang
                Barang::where('no_part', $no_part)
                    ->increment('qty', $detail->qty_pengiriman);

                // Hapus detail
                $detail->delete();

                // Update status PO
                $this->updatePOStatus($po_no);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
            }
        }

        return redirect('/surat-jalan/detail/' . $do_no);
    }

    /**
     * Update status Purchase Order berdasarkan pengiriman
     */
    private function updatePOStatus($po_no)
    {
        // Ambil semua detail PO
        $poDetails = PurchaseOrderDetail::where('po_no', $po_no)->get();
        
        $semuaTerkirim = true;
        
        foreach ($poDetails as $poDetail) {
            // Hitung total terkirim untuk part ini
            $totalTerkirim = DB::table('surat_jalan_detail as sjd')
                ->join('surat_jalan as sj', 'sjd.do_no', '=', 'sj.do_no')
                ->where('sj.po_no', $po_no)
                ->where('sjd.no_part', $poDetail->no_part)
                ->sum('sjd.qty_pengiriman');

            if ($totalTerkirim < $poDetail->qty_pemesanan) {
                $semuaTerkirim = false;
                break;
            }
        }

        // Update status PO
        $status = $semuaTerkirim ? 'Selesai' : 'Proses';
        PurchaseOrder::where('po_no', $po_no)->update(['status' => $status]);
    }

    public function cetak($do_no)
    {
        $suratJalan = SuratJalan::with(['purchaseOrder.customer', 'details.barang', 'preparedBy', 'checkedBy', 'securityPegawai', 'driverPegawai'])->where('do_no', $do_no)->firstOrFail();
        return view('surat_jalan.cetak', compact('suratJalan'));
    }
}
