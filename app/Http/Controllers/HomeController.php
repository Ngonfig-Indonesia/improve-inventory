<?php

namespace App\Http\Controllers;

use App\Models\barang_masuk;
use App\Models\Barangkeluar;
use App\Models\item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $item = item::count();
        $bgmasuk = barang_masuk::count();
        $bgkeluar = Barangkeluar::count();
        return view('/admin/home', compact('item', 'bgmasuk', 'bgkeluar'));
    }
}
