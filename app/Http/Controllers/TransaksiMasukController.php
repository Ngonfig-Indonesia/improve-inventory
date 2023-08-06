<?php

namespace App\Http\Controllers;

use App\Models\barang_masuk;
use App\Models\item;
use App\Models\item_detail;
use App\Models\transaksi_masuk;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Events\TransactionBeginning;

class TransaksiMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:tmasuk-list|tmasuk-create|tmasuk-edit|tmasuk-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:tmasuk-create', ['only' => ['create', 'store', 'select2']]);
        $this->middleware('permission:tmasuk-edit', ['only' => ['edit', 'update', 'select2']]);
        $this->middleware('permission:tmasuk-delete', ['only' => ['destroy', 'delete']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = transaksi_masuk::with('barangmasuk')->latest()->get();
            return DataTables::of($data)->addColumn('action', function ($row) {
                $actionBtn = "<a href='/admin/transaksimasuk/edit/" . $row->id . "' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></> <a href='#' class='btn btn-sm btn-danger btn-remove' id='" . $row->id . " '><i class='fa fa-trash'></i></> <a class='btn btn-sm btn-primary view-transaksi' data-toggle='modal' data-target='#modal-xl' id='" . $row->id . " '><i class='fa fa-eye'></i></>";
                return $actionBtn;
            })->rawColumns(['action'])->addIndexColumn()->removeColumn('id')->make(true);
        }

        return view('/admin/transaksimasuk/show');
    }

    public function select2(Request $request)
    {
        $data = [];
        if ($request->has('q')) {
            $search = $request->q;
            $data = item::select("id", "kode_item", "nama_barang", "eom")->where('nama_barang', 'LIKE', "%$search%")->get();
        }
        return response()->json($data);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/admin/transaksimasuk/add');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $item_id = $request->item_id;
            foreach ($item_id as $key => $value) {
                $item = Item::find($value);
                $max = item_detail::find($value);
                if ($item->qty > $max->max_qty) {
                    return redirect()->back();
                } else {
                    $data = new transaksi_masuk;
                    $data->type_barang = $request->type_barang;
                    $data->no_po = $request->no_po;
                    $data->no_pr = $request->no_pr;
                    $data->no_grn = $request->no_grn;
                    $data->supplier = $request->supplier;
                    $data->jenis = $request->jenis;
                    $data->tgl_transaksi_masuk = $request->tgl_transaksi_masuk;
                    $data->keterangan = $request->keterangan;
                    $data->save();

                    $item->qty = $item->qty + $request->qty[$key];
                    $item->save();

                    foreach ($item_id as $key => $value) {
                        $tmasuk = new barang_masuk;
                        $tmasuk->transaksi_id = $data->id;
                        $tmasuk->item_id = $request->item_id[$key];
                        $tmasuk->kode_item = $request->kode_item[$key];
                        $tmasuk->nama_barang = $request->nama_barang[$key];
                        $tmasuk->eom = $request->eom[$key];
                        $tmasuk->qty = $request->qty[$key];
                        $tmasuk->save();
                    }
                }
            }
            return back()->with('success', 'Tambah Transaksi Berhasil !');
        } catch (\Exception $e) {
            return back()->with('failed', 'Tambah Transaksi Gagal !');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = transaksi_masuk::with('barangmasuk')->find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = transaksi_masuk::with('barangmasuk')->findOrFail($id);
        return view('/admin/transaksimasuk/edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = transaksi_masuk::findOrFail($id);
            $data->update([
                'id' => $request->id,
                'type_barang' => $request->type_barang,
                'no_po' => $request->no_po,
                'no_pr' => $request->no_pr,
                'no_grn' => $request->no_grn,
                'supplier' => $request->supplier,
                'jenis' => $request->jenis,
                'tgl_transaksi_masuk' => $request->tgl_transaksi_masuk,
                'keterangan' => $request->keterangan
            ]);

            $item_id = $request->item_id;
            if (isset($item_id)) {
                foreach ($item_id as $key => $value) {
                    $item = Item::find($value);
                    $max = item_detail::find($value);
                    if ($item->qty > $max->max_qty) {
                        return redirect()->back();
                    } else {
                        $item->qty = $item->qty + $request->qty[$key];
                        $item->save();

                        foreach ($item_id as $key => $value) {
                            $tmasuk = new barang_masuk;
                            $tmasuk->transaksi_id = $data->id;
                            $tmasuk->item_id = $request->item_id[$key];
                            $tmasuk->kode_item = $request->kode_item[$key];
                            $tmasuk->nama_barang = $request->nama_barang[$key];
                            $tmasuk->eom = $request->eom[$key];
                            $tmasuk->qty = $request->qty[$key];
                            $tmasuk->save();
                        }
                    }
                }
            }
            return back()->with('success', 'Update Transaksi Berhasil !');
        } catch (\Exception $e) {
            return back()->with('failed', 'Update Transaksi Gagal !');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function delete($id)
    {
        try {
            $data = barang_masuk::findOrFail($id);
            $item = item::findOrFail($data->item_id);
            $item->qty = $data->qty - $item->qty;
            $item->save();
            $data->delete();
            return back()->with('success', 'Delete Item Berhasil !');
        } catch (\Exception $e) {
            return back()->with('failed', 'Delete Item Gagal !');
        }
    }

    public function destroy($id)
    {
        try {
            $data = transaksi_masuk::with('barangmasuk')->findOrFail($id);
            $item_id = $data->barangmasuk;
            foreach ($item_id as $key => $value) {
                $item = Item::find($value->item_id);
                $item->qty = $item->qty - $value->qty;
                $item->save();
                // return response()->json($item);
            }
            $data->delete();
            return back()->with('success', 'Delete Transaksi Berhasil !');
        } catch (\Exception $e) {
            return back()->with('failed', 'Delete Transaksi Gagal !');
        }
        // return response()->json($data);
    }
}
