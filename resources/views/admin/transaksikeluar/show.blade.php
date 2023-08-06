@extends('layouts.app')

@section('content')
@section('judul', 'Transaksi Keluar')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-1">
                    <a href="{{ route('tkeluar.create')}}" class="btn btn-primary">Tambah</a>
                </div>
                <table class="table table-bordered table-hover table-transaksi">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Type Barang</th>
                            <th>No MR</th>
                            <th>Dept</th>
                            <th>PIC</th>
                            <th>Tgl Transaksi</th>
                            <th>Keterangan</th>
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
        <div class="modal-dialog modal-xl">
        <div class="modal-content">
         <div class="modal-header">
        <h4 class="modal-title">Detail List Transaksi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                    <img src="{{ asset('/images/logo.png')}}" alt="" width="10%">
                    <img src="{{ asset('/images/sugar.png')}}" alt="" width="10%">
                    <small class="float-right" id="tgl_transaksi_keluar"></small>
                    </h2>
                    </div>
                    
                    </div>
                    
                    <div class="row invoice-info">
                        <div class="col invoice-col">
                                <strong>Type Barang :</strong>
                                <p id="type_barang"></p>
                        </div>
                    
                        <div class="col invoice-col">
                                <strong>No MR :</strong>
                                <p id="no_mr"></p>
                        </div>
                    
                        <div class="col invoice-col">
                            <strong>Departemen :</strong>
                            <p id="dept"></p>
                        </div>
                        <div class="col invoice-col">
                            <strong>PIC :</strong>
                            <p id="pic"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped" id="list">
                                <thead>
                                    <tr>
                                        <th>No</th>
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
                        <div class="col-12">
                            <strong>Keterangan :</strong>
                            <p id="keterangan"></p>
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
            $('body').on('click', '.view-transaksi', function () {
                var id = $(this).attr("id");
                var no = 1;
                $('#list-data').empty();
                $.ajax({
                    type: 'GET',
                    url: '{{ route('tkeluar.index')}}' + '/show/' + id,
                    success: function (params) {
                        $('#tgl_transaksi_keluar').html(params.tgl_transaksi_keluar);
                        $('#type_barang').html(params.type_barang);
                        $('#no_mr').html(params.no_mr);
                        $('#dept').html(params.dept);
                        $('#pic').html(params.pic);
                        $('#keterangan').html(params.keterangan);
                       $.each(params.barangkeluar, function (index, value) {
                            $('#list').append('<tr><td>'+ no++ +'</td><td>'+ value.kode_item +'</td><td>'+ value.nama_barang +'</td><td>'+ value.eom +'</td><td>'+ value.qty +'</td></tr>')
                       })
                    }
                })
            })

            $('body').on('click', '.btn-remove', function() {
                var result = confirm("Apakah Anda Yakin Ingin Menghapus Transaksi ini ?");
                if (result) {
                    var id = $(this).attr("id");
                $.ajax({
                    type: "GET",
                    url: "{{ route('tkeluar.index') }}" + '/destroy/' + id,
                    success: function(data) {
                        table.draw();
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });        
                }
            });

            var table = $('.table-transaksi').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('tkeluar.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'type_barang',
                        name: 'type_barang'
                    },
                    {
                        data: 'no_mr',
                        name: 'no_mr'
                    },
                    {
                        data: 'dept',
                        name: 'dept'
                    },
                    {
                        data: 'pic',
                        name: 'pic'
                    },
                    {
                        data: 'tgl_transaksi_keluar',
                        name: 'tgl_transaksi_keluar'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
