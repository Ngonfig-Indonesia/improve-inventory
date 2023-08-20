<?php

namespace App\Http\Controllers;

use App\Models\barang_masuk;
use App\Models\transaksi_masuk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanTransaksiMasuk extends Controller
{
    public function index()
    {
        $data = barang_masuk::with('transaksimasuk')->latest()->get();
        return view('/admin/laporan/transaksi_masuk', compact('data'));
    }

    public function pertanggal(Request $request)
    {
        if (request()->start_date || request()->end_date) {
            $start_date = request()->start_date;
            $end_date = request()->end_date;
            $data = barang_masuk::with('transaksimasuk')->whereHas('transaksimasuk', function ($query) use ($start_date, $end_date) {
                $query->whereBetween('tgl_transaksi_masuk', [$start_date, $end_date]);
            })->get();
        } else {
            $data = barang_masuk::with('transaksimasuk')->latest()->get();
        }
        return view('/admin/laporan/transaksi_masuk', compact('data'));
    }

    // public function bulan(Request $request)
    // {
    //     if (request()->start_date) {
    //         $start_date = date('m', request()->start_date);
    //         $data = barang_masuk::with('transaksimasuk')->whereHas('transaksimasuk', function ($query) use ($start_date) {
    //             $query->whereBetween('tgl_transaksi_masuk', [$start_date]);
    //         })->get();
    //     } else {
    //         $data = barang_masuk::with('transaksimasuk')->latest()->get();
    //     }
    //     return view('/admin/laporan/transaksi_masuk', compact('data'));
    // }
}
