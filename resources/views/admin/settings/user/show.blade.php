@extends('layouts.app')

@section('content')
@section('judul', 'Users Management')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-1">
                    <a href="{{ route('users.create')}}" class="btn btn-primary">Tambah</a>
                </div>
                <table class="table table-bordered table-hover table-item">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->name}}</td>
                            <td>{{ $item->email}}</td>
                            <td>
                                @if(!empty($item->getRoleNames()))
                                    @foreach($item->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                {{-- <a class="btn btn-info" href="{{ route('users.show',$item->id) }}">Show</a> --}}
                                <a class="btn btn-sm btn-success" href="{{ route('users.edit',$item->id) }}"><i class="fas fa-edit"></i></a>
                                <a href="{{ route('users.destroy', $item->id )}}" onclick="confirm('Yakin Anda Ingin Menghapus?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                             </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
