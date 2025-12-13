@extends('layouts.layout')

@section('title', 'purchase_order-ubah')

@section('content')
<form action="{{ url('/purchase-order/update/' . $purchaseOrder->po_no) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form">
        <label for="ubahPO" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">UBAH PURCHASE ORDER</label>
        <hr>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">PO NO</label>
            <input type="text" name="po_no" value="{{ $purchaseOrder->po_no }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);" readonly>
        </div>
        
        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">CUSTOMER</label>
            <select class="form-control" name="id_customer" style="display: inline-block; width: calc(100% - 110px);">
                @foreach($customers as $customer)
                <option value="{{ $customer->id_customer }}" {{ $purchaseOrder->id_customer == $customer->id_customer ? 'selected' : '' }}>{{ $customer->nama_customer }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
            <input type="date" name="tanggal" value="{{ $purchaseOrder->tanggal }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">DELIVERY</label>
            <input type="date" name="schedule_delivery" value="{{ $purchaseOrder->schedule_delivery }}" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
            <label class="form-label" style="display: inline-block; width: 100px;">STATUS</label>
            <select class="form-control" name="status" style="display: inline-block; width: calc(100% - 110px);">
                <option value="Pending" {{ $purchaseOrder->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Diproses" {{ $purchaseOrder->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ $purchaseOrder->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>

        <br>
        <div class="tombol" style="text-align: right;">
            <button type="submit" class="btn btn-success">Ubah</button>
            <a href="{{ url('/purchase-order') }}" class="btn btn-danger">kembali</a>
        </div>
    </div>
</form>
@endsection
