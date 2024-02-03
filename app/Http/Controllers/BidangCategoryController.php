<?php

namespace App\Http\Controllers;

use App\Models\BidangCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BidangCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $bidang = BidangCategory::query();
            return DataTables::of($bidang)->make(); 
        }
        return view('bidang-category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'bidang_category_name' => 'required',
            'bidang_category_singkatan' => 'required',
        ]);
        BidangCategory::create($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'bidang_category_name' => 'required',
            'bidang_category_singkatan' => 'required',
        ]);
        BidangCategory::where('bidang_category_id', $id)->update($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BidangCategory::where('bidang_category_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }
}

