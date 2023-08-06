@extends('layouts.app')

@section('content')
@section('judul', 'Update item')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('item.update', $data->id) }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Item</label>
                                <input type="hidden" name="id" id="" value="{{ old('id', $data->id) }}">

                                <input type="text" name="kode_item" class="form-control" id=""
                                    value="{{ old('kode_item', $data->kode_item) }}">
                            </div>
                            <!-- /.form-group -->
                            <div class="row">
                                <div class="col">
                                    <label>Eom</label>
                                    <input type="text" class="form-control" name="eom"
                                        value="{{ old('eom', $data->eom) }}">
                                </div>
                                <div class="col">
                                    <label>Rak</label>
                                    <input type="text" class="form-control" name="rak"
                                        value="{{ old('rak', $data->rak) }}">
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" id=""
                                    value="{{ old('nama_barang', $data->nama_barang) }}">
                            </div>
                            <div class="row">
                                @foreach ($data->item_details as $item)
                                    <div class="col">
                                        <label>Min Qty</label>
                                        <input type="hidden" name="item_detail_id"
                                            value="{{ old('id', $item->item_detail_id) }}">
                                        <input type="number" class="form-control" name="min_qty" min="1"
                                            value="{{ old('min_qty', $item->min_qty) }}">
                                    </div>
                                    <div class="col">
                                        <label>Max Qty</label>
                                        <input type="number" class="form-control" max="100000" name="max_qty"
                                            value="{{ old('max_qty', $item->max_qty) }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('item.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->

        @endsection
