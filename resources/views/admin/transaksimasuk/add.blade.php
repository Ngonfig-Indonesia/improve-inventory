@extends('layouts.app')

@section('content')
@section('judul', 'Tambah Transaksi Masuk')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('tmasuk.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type Barang</label>
                                <input type="text" name="type_barang" class="form-control" id="" autocomplete="off" required>
                            </div>
                            <!-- /.form-group -->
                            <div class="row">
                                <div class="col">
                                    <label>Supplier</label>
                                    <input type="text" class="form-control" name="supplier" autocomplete="off" required>
                                </div>
                                <div class="col">
                                    <label>Jenis</label>
                                    <select name="jenis" id="" class="form-control">
                                        <option value="comsumable">comsumable</option>
                                        <option value="project">Project</option>
                                    </select>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor GRN</label>
                                <input type="text" name="no_grn" class="form-control" id="" autocomplete="off" required>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label>Tanggal Masuk</label>
                                    <input type="date" class="form-control" name="tgl_transaksi_masuk" required>
                                </div>
                            </div>
                        </div>

                        <div class="col" id="item-list">
                            <!-- /.form-group -->
                            <div class="row">
                                <div class="col">
                                    <label>Pilih Barang</label>
                                    <select class="form-control cekbarang" id="caribarang"></select>
                                </div>
                                <div class="col">
                                    <label>Kode Item</label>
                                    <input type="text" class="form-control" id="kode_item" readonly>
                                </div>
                                <div class="col">
                                    <label>Nama Barang</label>
                                    <input type="text" class="form-control" id="nama_barang" readonly>
                                </div>
                                <div class="col-1">
                                    <label>Qty</label>
                                    <input type="number" class="form-control" id="qty" min="1" max="10000">
                                </div>
                                <div class="col-1">
                                    <label>Eom</label>
                                    <input type="text" class="form-control" id="eom" readonly>
                                </div>
                                <div class="mt-auto">
                                    <button type="button" class="btn btn-success add"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <br>
                    <div class="list-item">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Item</th>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Eom</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="listransaksi">
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <label for="">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="" cols="30" rows="5" placeholder="Ketik Keterangan disini.." ></textarea>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('tmasuk.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->
        @endsection

        @push('script')
            <script type="text/javascript">
                var no = 0;
                
                $('body').on('click', '.add', function () {
                        no++
                        var id = $('#caribarang').val();
                        var kode_item = document.querySelector('#kode_item').value;
                        var nama_barang = document.querySelector('#nama_barang').value;
                        var qty = document.querySelector('#qty').value;
                        var eom = document.querySelector('#eom').value;
                    if (!kode_item == "" || !nama_barang == "" || !qty == "" || !eom == "") {
                        $('#listransaksi').append(`<tr id="test"><td><input name="item_id[]" value="${id}" type="hidden"><input class="form-control" name="kode_item[]" type="text" readonly value="${kode_item}"></td><td><input class="form-control" name="nama_barang[]" type="text" readonly value="${nama_barang}"></td><td class="col-1"><input type="number" class="form-control" required name="qty[]" min="1" max="10000" value="${qty}"></td><td class="col-1"><input class="form-control" type="text" readonly name="eom[]" value="${eom}"></td><td class="col-1"><bottom class="btn btn-sm btn-danger hapus-list"><i class="fa fa-trash"></i></bottom></td></tr>`);
                    }else{
                        alert('Form Tidak Boleh Kosong');
                    }
                    $('#kode_item').val("");
                    $('#nama_barang').val("");
                    $('#eom').val("");
                    $('#qty').val("");

                })

                $('body').on('click', '.hapus-list',function(){
                    $(this).parents("#test").remove();
                });

                $('#caribarang').select2({
                    height: 'resolve',
                    placeholder: 'Pilih Kode Item',
                    ajax: {
                        url: '{{ route('tmasuk.select2')}}',
                        dataType: 'JSON',
                        delay: 250,
                        processResults: function (data) {
                            return {
                                results: $.map(data, function (params) {
                                    return {
                                        text: params.nama_barang,
                                        id: params.id,
                                        kode: params.kode_item,
                                        eom: params.eom
                                    }
                                })
                            }
                        }
                    },
                    cache: true
                });

                $('#caribarang').on('select2:select', function (e) {                        
                        $('#kode_item').val(e.params.data.kode);
                        $('#nama_barang').val(e.params.data.text);
                        $('#eom').val(e.params.data.eom);
                        // console.log(data);
                });

            </script>
        @endpush
