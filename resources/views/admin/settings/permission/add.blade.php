@extends('layouts.app')

@section('content')
@section('judul', 'Tambah Role')
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
                <form action="{{ route('permission.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="text" name="name" autocomplete="off" placeholder="Example : Operator" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">List Role :</label>
                            @foreach ($permission as $item)
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" id="customCheckbox2" name="permission[]" value="{{ $item->id}}">
                                <label>{{ $item->name}}</label>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('permission.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->
        @endsection
