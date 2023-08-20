@extends('layouts.app')

@section('content')
@section('judul', 'Laporan Transaksi Keluar')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="input-group">
                            <form action="{{ route('laporan.pertanggal.keluar')}}" method="get">
                                <div class="row">
                                    <div class="col-4 mb-2">
                                        <input type="date" class="form-control" name="start_date">
                                    </div>
                                    <div class="col-4 mb-2">
                                        <input type="date" class="form-control" name="end_date">
                                    </div>
                                    <div class="col-sm-3 mb-2">
                                        <button class="btn btn-success btn-cari"><i class="fa fa-filter"></i> Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No MR</th>
                            <th>Nama Barang</th>
                            <th>Qty</th>
                            <th>Tgl Keluar</th>
                        </tr>
                    </thead>
                    <tbody class="table-logs">
                        @php
                            $no = 1;
                        @endphp
                       @foreach ($data as $item)
                           <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->transaksikeluar->no_mr }}</td>
                                <td>{{ $item->nama_barang }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->transaksikeluar->tgl_transaksi_keluar }}</td>
                           </tr>
                       @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
