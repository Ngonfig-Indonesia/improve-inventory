<?php

namespace App\Http\Controllers;

use App\Models\Barangkeluar;
use Illuminate\Http\Request;

class LaporanTransaksiKeluar extends Controller
{
    public function index()
    {
        $data = Barangkeluar::with('transaksikeluar')->latest()->get();
        return view('/admin/laporan/transaksi_keluar', compact('data'));
    }

    public function pertanggal(Request $request)
    {
        if (request()->start_date || request()->end_date) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $data = Barangkeluar::with('transaksikeluar')->whereHas('transaksikeluar', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('tgl_transaksi_keluar', [$start_date, $end_date]);
            })->get();
        } else {
            $data = Barangkeluar::with('transaksikeluar')->latest()->get();
        }
        return view('/admin/laporan/transaksi_keluar', compact('data'));
    }
}
