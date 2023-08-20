@extends('layouts.app')

@section('content')
@section('judul', 'Transaksi Masuk')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-1">
                    <a href="{{ route('tmasuk.create')}}" class="btn btn-primary">Tambah</a>
                </div>
                <table class="table table-bordered table-hover table-transaksi">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Type Barang</th>
                            <th>No GRN</th>
                            <th>Supplier</th>
                            <th>Jenis</th>
                            <th>Tgl Transaksi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="modal fade" tabindex="-1" id="modal-xl">
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
                        <small class="float-right" id="tgl_transaksi_masuk"></small>
                        </h2>
                        <div class="row invoice-info">
                            <div class="col-sm invoice-col">
                                    <strong>Type Barang :</strong>
                                    <p id="type_barang"></p>
                            </div>
                            <div class="col-sm invoice-col">
                                <strong>No GRN :</strong>
                                <p id="no_grn"></p>
                            </div>
                            <div class="col-sm invoice-col">
                                <strong>Supplier :</strong>
                                <p id="supplier"></p>
                            </div>
                            <div class="col-sm invoice-col">
                                <strong>Jenis :</strong>
                                <p id="jenis"></p>
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
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
            </div>
          </div>
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
                    url: '{{ route('tmasuk.index')}}' + '/show/' + id,
                    success: function (params) {
                        console.log(params);
                        $('#tgl_transaksi_masuk').html(params.tgl_transaksi_masuk);
                        $('#type_barang').html(params.type_barang);
                        $('#no_grn').html(params.no_grn);
                        $('#supplier').html(params.supplier);
                        $('#jenis').html(params.jenis);
                        $('#keterangan').html(params.keterangan);
                       $.each(params.barangmasuk, function (index, value) {
                            $('#list').append('<tr><td>'+ no++ +'</td><td>'+ value.kode_item +'</td><td>'+ value.nama_barang +'</td><td>'+ value.eom +'</td><td>'+ value.qty +'</td></tr>')
                       })
                    }
                })
            });


            var table = $('.table-transaksi').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('tmasuk.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'type_barang',
                        name: 'type_barang'
                    },
                    {
                        data: 'no_grn',
                        name: 'no_grn'
                    },
                    {
                        data: 'supplier',
                        name: 'supplier'
                    },
                    {
                        data: 'jenis',
                        name: 'jenis'
                    },
                    {
                        data: 'tgl_transaksi_masuk',
                        name: 'tgl_transaksi_masuk'
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
                var result = confirm("Apakah Anda Yakin Ingin Menghapus Transaksi ini ?");
                if (result) {
                    var id = $(this).attr("id");
                    $.ajax({
                        type: "GET",
                        url: "{{ route('tmasuk.index') }}" + '/destroy/' + id,
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
