@extends('layouts.app')

@section('content')
@section('judul', 'Update User')
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
                <form action="{{ route('users.update', $data->id)}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="hidden" name="id" value="{{old('id', $data->id)}}" id="">
                                <input type="text" name="name" autocomplete="off" value="{{ old('name', $data->name)}}" placeholder="Masukan Nama Anda" class="form-control" >
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" autocomplete="off" value="{{ old('email', $data->email)}}" placeholder="Masukan Email Anda" class="form-control" >
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
                                    <option value="{{ $item->id}}">{{ $item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('users.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->

        @endsection
