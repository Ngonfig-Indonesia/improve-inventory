@extends('layouts.app')

@section('content')
@section('judul', 'Tambah Item')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('item.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kode Item</label>
                                <input type="text" name="kode_item" class="form-control" id="">
                            </div>
                            <!-- /.form-group -->
                            <div class="row">
                                <div class="col">
                                    <label>Eom</label>
                                    <input type="text" class="form-control" name="eom">
                                </div>
                                <div class="col">
                                    <label>Rak</label>
                                    <input type="text" class="form-control" name="rak">
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" name="nama_barang" class="form-control" id="">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Min Qty</label>
                                    <input type="number" min="1" class="form-control" name="min_qty">
                                </div>
                                <div class="col">
                                    <label>Max Qty</label>
                                    <input type="number" max="100000" class="form-control" name="max_qty">
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('item.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->

        @endsection
