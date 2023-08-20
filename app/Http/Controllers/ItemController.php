<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Models\item_detail;
use Illuminate\Http\Request;
use DataTables;
use Alert;
use App\Models\User;
use App\Notifications\ItemSuccessful;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
        $this->middleware('permission:item-list|item-create|item-edit|item-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:item-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:item-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:item-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = item::with('item_details')->latest()->get();
            return DataTables::of($data)->addColumn('status', function (item $daftaritem) {
                foreach ($daftaritem->item_details as $key) {
                    if ($daftaritem->qty > $key->max_qty) {
                        $result = '<a class="badge badge-primary">Stock Max!</>';
                    } elseif ($daftaritem->qty <= $key->min_qty) {
                        $result = '<a class="badge badge-warning">Stock Limit!</>';
                    } else {
                        $result = '<a class="badge badge-success">Stock Aman</>';
                    }
                    if ($daftaritem->qty === '0') {
                        $result = '<a class="badge badge-danger">Habis!</>';;
                    }
                    return $result;
                }
            })->addColumn('min_qty', function (item $daftaritem) {
                foreach ($daftaritem->item_details as $key) {
                    return $key->min_qty;
                }
            })->addColumn('max_qty', function (item $daftaritem) {
                foreach ($daftaritem->item_details as $key) {
                    return $key->max_qty;
                }
            })->addColumn('action', function ($row) {
                $actionBtn = "<a href='/admin/daftaritem/edit/" . $row->id . "' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></> <a href='#' class='btn btn-sm btn-danger btn-remove' id='" . $row->id . " '><i class='fa fa-trash'></i><a class='btn btn-sm btn-primary view-kartu-stok' data-toggle='modal' data-target='#modal-xl' id='" . $row->id . " '><i class='fa fa-eye'></i></>";
                return $actionBtn;
            })->rawColumns(['status', 'action'])->addIndexColumn()->removeColumn('id')->make(true);
        }

        return view('/admin/daftaritem/show');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/admin/daftaritem/add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = Item::updateOrCreate([
                'id' => $request->id,
                'kode_item' => $request->kode_item,
                'nama_barang' => $request->nama_barang,
                'eom' => $request->eom,
                'rak' => $request->rak
            ]);
            $detail = new item_detail;
            $detail->min_qty = $request->min_qty;
            $detail->max_qty = $request->max_qty;
            $data->item_details()->save($detail);

            $user = User::all();
            Notification::send($user, new ItemSuccessful('Create Item ' . $data->kode_item . ' Success'));
            return back()->with('success', 'Tambah Item Berhasil !');
        } catch (\Exception $e) {
            return back()->with('failed', $e);
        }
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->route('logs');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = item::with('barangmasuk', 'barangkeluar')->findOrFail($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Item::with('item_details')->findOrFail($id);
        foreach ($data->item_details as $key) {
            $key = '';
        }
        $cek = $key;
        return view('/admin/daftaritem/edit', compact('data', 'cek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $data = Item::with('item_details')->findOrFail($id);
            $data->update([
                'id' => $request->id,
                'kode_item' => $request->kode_item,
                'nama_barang' => $request->nama_barang,
                'eom' => $request->eom,
                'rak' => $request->rak
            ]);

            $detail = item_detail::findOrFail($id);
            $detail->update([
                'item_detail_id' => $request->item_detail_id,
                'min_qty' => $request->min_qty,
                'max_qty' => $request->max_qty
            ]);
            $user = User::all();
            Notification::send($user, new ItemSuccessful('Update Item ' . $data->kode_item . ' Success'));
            return back()->with('success', 'Update Item Berhasil !');
        } catch (\Exception $e) {
            return back()->with('failed', 'Update Item Error !');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $data = Item::where('id', $id);
            $data->delete();
            $user = User::all();
            Notification::send($user, new ItemSuccessful('Delete Item ' . $data->kode_item . ' Success'));
            return back()->with('success', 'Delete Item Berhasil !');
        } catch (\Exception $e) {
            return back()->with('failed', 'Delete Item Error !');
        }
    }
}
