@extends('layouts.app')

@section('content')
@section('judul', 'Logs')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Action</th>
                            <th>Tanggal Logs</th>
                        </tr>
                    </thead>
                    <tbody class="table-logs">
                        @php
                            $no = 1;
                        @endphp
                        @foreach (auth()->user()->readNotifications as $notification)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{$notification->data['data']}}</td>
                            <td>{{$notification->read_at}}</td>
                        </tr> 
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.row -->
@endsection
