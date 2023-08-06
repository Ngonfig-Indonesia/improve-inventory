@extends('layouts.app')

@section('content')
<section class="content">
    <div class="error-page">
        <h2 class="headline text-danger">403</h2>
    <div class="error-content">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>
        <p>
        Anda tidak memiliki akses untuk halaman ini
        sepertinya, Kamu bisa <a href="{{ route('home')}}">kembali ke menu utama</a> atau bisa menghubungi Administrator
        </p>
    <form class="search-form">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search">
                <div class="input-group-append">
                <button type="submit" name="submit" class="btn btn-danger"><i class="fas fa-search"></i>
                </button>
        </div>
    </div>
    
    </form>
    </div>
    </div>
    
    </section>
@endsection