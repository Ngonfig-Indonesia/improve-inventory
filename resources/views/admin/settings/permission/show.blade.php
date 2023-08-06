@extends('layouts.app')

@section('content')
@section('judul', 'Roler Management')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-1">
                    <a href="{{ route('permission.create')}}" class="btn btn-primary">Tambah</a>
                </div>
                <table class="table table-bordered table-hover table-item">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $key => $role)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $role->name}}</td>
                                <td>
                                    <a href="{{ route('permission.destroy', $role->id)}}" id="{{ $role->id }}" onclick="confirm('Yakin Anda Ingin Menghapus?')" class="btn btn-sm btn-danger btn-role"><i class="fas fa-trash"></i></a>
                                    {{-- <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}">Show</a>
                                    @can('role-edit')
                                        <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                    @endcan
                                    @can('role-delete')
                                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    @endcan --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
         <div class="modal-header">
        <h4 class="modal-title">Kartu Stock Barang</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    </div>
                    </div>
                    
                    <div class="row invoice-info">
                        <div class="col invoice-col">
                            <label for="">Kode Item</label>
                            <input type="text" class="form-control" id="kode_item" readonly>
                        </div>
                        <div class="col invoice-col">
                            <label for="">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="list">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Type Transaksi</th>
                                        <th>Kode Item</th>
                                        <th>Nama Barang</th>
                                        <th>Eom</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody id="list-data">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                    <div class="col-6">
                    
                    </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
        </div>
        </div>
    <!-- /.row --> --}}
@endsection
