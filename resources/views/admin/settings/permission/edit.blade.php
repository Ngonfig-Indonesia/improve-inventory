@extends('layouts.app')

@section('content')
@section('judul', 'Update Role')
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
                <form action="{{ route('permission.update', $permission->id)}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Role</label>
                                <input type="hidden" name="id" value="{{ old('id', $permission->id)}}" id="">
                                <input type="text" name="name" value="{{ old('name', $permission->name)}}" autocomplete="off" placeholder="Example : Operator" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <label for="">List Role :</label>
                    <div class="row">
                        @foreach ($item as $items)
                        <div class="col-2">
                            <div class="custom-control custom-checkbox">
                                 <input type="checkbox" 
                                name="permission[{{ $items->name }}]"
                                value="{{ $items->name }}"
                                class='permission'
                                {{ in_array($items->name, $rolePermissions) 
                                    ? 'checked'
                                    : '' }}>
                                {{-- <input type="checkbox" id="customCheckbox2" name="permission[]" value="{{ $items->id}}"> --}}
                                <label>{{ $items->name}}</label>
                            </div>
                        </div>
                         @endforeach
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('permission.index')}}" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
            <!-- /.row -->
        @endsection