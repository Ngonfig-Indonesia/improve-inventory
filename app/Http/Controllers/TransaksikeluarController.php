<?php

namespace App\Http\Controllers;

use App\Models\Barangkeluar;
use App\Models\item;
use App\Models\item_detail;
use App\Models\Transaksikeluar;
use Illuminate\Http\Request;
use DataTables;

class TransaksikeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:tkeluar-list|tkeluar-create|tkeluar-edit|tkeluar-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:tkeluar-create', ['only' => ['create', 'store', 'select2']]);
        $this->middleware('permission:tkeluar-edit', ['only' => ['edit', 'update', 'select2']]);
        $this->middleware('permission:tkeluar-delete', ['only' => ['destroy', 'delete']]);
    }


    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Transaksikeluar::with('barangkeluar')->latest()->get();
            return DataTables::of($data)->addColumn('action', function ($row) {
                $actionBtn = "<a href='/admin/transaksikeluar/edit/" . $row->id . "' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></> <a href='#' class='btn btn-sm btn-danger btn-remove' id='" . $row->id . " '><i class='fa fa-trash'></i></> <a class='btn btn-sm btn-primary view-transaksi' data-toggle='modal' data-target='#modal-xl' id='" . $row->id . " '><i class='fa fa-eye'></i></>";
                return $actionBtn;
            })->rawColumns(['action'])->addIndexColumn()->removeColumn('id')->make(true);
        }

        return view('/admin/transaksikeluar/show');
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
        return view('/admin/transaksikeluar/add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $item_id = $request->item_id;
        foreach ($item_id as $key => $value) {
            $item = Item::find($value);
            $min = item_detail::find($value);
            if ($item->qty < $min->min_qty) {
                return redirect()->back();
            } else {
                $data = new Transaksikeluar;
                $data->type_barang = $request->type_barang;
                $data->no_mr = $request->no_mr;
                $data->dept = $request->dept;
                $data->pic = $request->pic;
                $data->tgl_transaksi_keluar = $request->tgl_transaksi_keluar;
                $data->keterangan = $request->keterangan;
                $data->save();

                $item->qty = $item->qty - $request->qty[$key];
                $item->save();
                foreach ($item_id as $key => $value) {
                    $tmasuk = new Barangkeluar;
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
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = Transaksikeluar::with('barangkeluar')->find($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Transaksikeluar::with('barangkeluar')->findOrFail($id);
        return view('/admin/transaksikeluar/edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $item_id = $request->item_id;
        foreach ($item_id as $key => $value) {
            $item = Item::find($value);
            $min = item_detail::find($value);
            if ($item->qty < $min->min_qty) {
                return redirect()->back();
            } else {
                try {
                    $data = Transaksikeluar::findOrFail($id);
                    $data->update([
                        'id' => $request->id,
                        'type_barang' => $request->type_barang,
                        'no_mr' => $request->no_mr,
                        'dept' => $request->dept,
                        'pic' => $request->pic,
                        'tgl_transaksi_keluar' => $request->tgl_transaksi_keluar,
                        'keterangan' => $request->keterangan
                    ]);

                    $item->qty = $item->qty - $request->qty[$key];
                    $item->save();

                    foreach ($item_id as $key => $value) {
                        $tmasuk = new Barangkeluar;
                        $tmasuk->transaksi_id = $data->id;
                        $tmasuk->item_id = $request->item_id[$key];
                        $tmasuk->kode_item = $request->kode_item[$key];
                        $tmasuk->nama_barang = $request->nama_barang[$key];
                        $tmasuk->eom = $request->eom[$key];
                        $tmasuk->qty = $request->qty[$key];
                        $tmasuk->save();
                    }
                    return back()->with('success', 'Update Transaksi Berhasil !');
                } catch (\Exception $e) {
                    return back()->with('failed', 'Update Transaksi Error !');
                }
            }
        }
    }

    public function delete($id)
    {
        try {
            $data = Barangkeluar::findOrFail($id);
            $item = item::findOrFail($data->item_id);
            $item->qty = $data->qty + $item->qty;
            $item->save();
            $data->delete();
            return redirect()->back()
                ->with('success', 'Delete Item Berhasil!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Delete Item Error!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Transaksikeluar::with('barangkeluar')->findOrFail($id);
        $item_id = $data->barangkeluar;
        foreach ($item_id as $key => $value) {
            $item = Item::find($value->item_id);
            $item->qty = $item->qty + $value->qty;
            $item->save();
            // return response()->json($item);
        }
        $data->delete();
        // return response()->json($data);
    }
}
