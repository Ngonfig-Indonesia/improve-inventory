@extends('layouts.app')

@section('content')
@section('judul', 'Tambah User')
<div>
    @if (count($errors) > 0)
    <div class="alert alert-danger">
      <strong>Whoops!</strong> Silahkan Untuk Cek Lagi !<br><br>
      <ul>
         @foreach ($errors->all() as $error)
           <li>{{ $error }}</li>
         @endforeach
      </ul>
    </div>
  @endif
</div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('users.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" autocomplete="off" placeholder="Masukan Nama Anda" class="form-control" >
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" autocomplete="off" placeholder="Masukan Email Anda" class="form-control" >
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col">
                            <label>Password</label>
                            <input type="password" class="form-control" placeholder="Masukan Password" name="password" >
                        </div>
                        <div class="col">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Konfirmasi Password" name="confirm-password" >
                        </div>
                        <div class="col">
                            <label>Role</label>
                            <select name="roles" id="" class="form-control">
                                @foreach ($role as $item)
                                    <option value="{{ $item}}">{{ $item}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('users.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->

        @endsection
