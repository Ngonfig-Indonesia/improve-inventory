@extends('layouts.app')

@section('content')
@section('judul', 'Daftar Item')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-1">
                    <a href="{{ route('item.create') }}" class="btn btn-primary">Tambah</a>
                </div>
                <table class="table table-bordered table-hover table-item">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Item</th>
                            <th>Nama Barang</th>
                            <th>Eom</th>
                            <th>Qty</th>
                            <th>Rak</th>
                            <th>Min Qty</th>
                            <th>Max Qty</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-xl">
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
    <!-- /.row -->
@endsection
@push('script')
    <script type="text/javascript">
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.view-kartu-stok', function () {
                var id = $(this).attr("id");
                var no = 1;
                $('#list-data').empty();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('item.index')}}' + '/show/' + id,
                    success: function (params) {
                        console.log(params);
                        $('#kode_item').val(params.kode_item);
                        $('#nama_barang').val(params.nama_barang);
                       $.each(params.barangmasuk, function (index, value) {
                            $('#list').append('<tr><td>'+ no++ +'</td><td>Transaksi Masuk</td><td>'+ value.kode_item +'</td><td>'+ value.nama_barang +'</td><td>'+ value.eom +'</td><td>'+ value.qty +'</td></tr>')
                       })
                       $.each(params.barangkeluar, function (index, value) {
                            $('#list').append('<tr><td>'+ no++ +'</td><td>Transaksi Keluar</td><td>'+ value.kode_item +'</td><td>'+ value.nama_barang +'</td><td>'+ value.eom +'</td><td>'+ value.qty +'</td></tr>')
                       })
                    }
                })
            })

            var table = $('.table-item').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('item.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_item',
                        name: 'kode_item'
                    },
                    {
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'eom',
                        name: 'eom'
                    },
                    {
                        data: 'qty',
                        name: 'qty'
                    },
                    {
                        data: 'rak',
                        name: 'rak'
                    },
                    {
                        data: 'min_qty',
                        name: 'min_qty'
                    },
                    {
                        data: 'max_qty',
                        name: 'max_qty'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('body').on('click', '.btn-remove', function() {
                var result = confirm("Apakah Anda Yakin Ingin Menghapus Item ini ?");
                if (result) {
                    var id = $(this).attr("id");
                $.ajax({
                    type: "GET",
                    url: "{{ route('item.index') }}" + '/delete/' + id,
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });        
                }
            });

        });
    </script>
@endpush
