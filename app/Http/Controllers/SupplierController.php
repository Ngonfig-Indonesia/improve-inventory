<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supplier::with('barangmasuk')->latest()->get();
            return DataTables::of($data)->addColumn('action', function ($row) {
                $actionBtn = "<a href='/admin/supplier/edit/" . $row->id . "' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></> <a href='#' class='btn btn-sm btn-danger btn-remove' id='" . $row->id . " '><i class='fa fa-trash'></i></> <a class='btn btn-sm btn-primary view-transaksi' data-toggle='modal' data-target='#modal-xl' id='" . $row->id . " '><i class='fa fa-eye'></i></>";
                return $actionBtn;
            })->rawColumns(['action'])->addIndexColumn()->removeColumn('id')->make(true);
        }

        return view('/admin/supplier/show');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
