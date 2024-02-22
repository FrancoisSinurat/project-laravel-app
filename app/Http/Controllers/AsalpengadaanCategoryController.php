<?php

namespace App\Http\Controllers;

use App\Models\AsalpengadaanCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;


class AsalpengadaanCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:asal-pengadaan-list', ['only' => ['index']]);
        $this->middleware('permission:asal-pengadaan-create', ['only' => ['store']]);
        $this->middleware('permission:asal-pengadaan-edit', ['only' => ['update']]);
        $this->middleware('permission:asal-pengadaan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $asalpengadaan = AsalpengadaanCategory::query();
            return DataTables::of($asalpengadaan)->make();
        }
        return view('asalpengadaan-category.index');
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
            'asalpengadaan_category_name' => 'required|unique:asalpengadaan_categories,asalpengadaan_category_name,NULL,NULL,deleted_at,NULL',
            'asalpengadaan_category_code' => 'required|unique:asalpengadaan_categories,asalpengadaan_category_code,NULL,NULL,deleted_at,NULL',
        ],
        [
            'asalpengadaan_category_name.unique' => 'Nama Asal Pengadaan sudah digunakan',
            'asalpengadaan_category_code.unique' => 'Singkatan Asal Pengadaan sudah digunakan'
        ]);
        AsalpengadaanCategory::create($request->all());
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
            'asalpengadaan_category_name' => "required|unique:asalpengadaan_categories,asalpengadaan_category_name,$id,asalpengadaan_category_id,deleted_at,NULL",
            'asalpengadaan_category_singkatan' => "required|unique:asalpengadaan_categories,asalpengadaan_category_singkatan,$id,asalpengadaan_category_id,deleted_at,NULL",
        ],
        [
            'asalpengadaan_category_name.unique' => 'Nama Asal Pengadaan sudah digunakan',
            'asalpengadaan_category_singkatan.unique' => 'Singkatan Asal Pengadaan sudah digunakan'
        ]);
        AsalpengadaanCategory::where('asalpengadaan_category_id', $id)->update($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AsalpengadaanCategory::where('asalpengadaan_category_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }


    public function ajax(Request $request)
    {
        try {
            $asalpengadaan = AsalpengadaanCategory::select('asalpengadaan_category_id', 'asalpengadaan_category_name')
                ->when($request->search, function($query, $keyword) {
                    $query->where("asalpengadaan_category_name", "like", "%$keyword%");
                })
                ->get();
            if($asalpengadaan->isNotEmpty()) {

                return response()->json([
                    'results' => $asalpengadaan
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}

