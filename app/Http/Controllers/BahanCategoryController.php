<?php

namespace App\Http\Controllers;

use App\Models\BahanCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;


class BahanCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:bahan-list', ['only' => ['index']]);
        $this->middleware('permission:bahan-create', ['only' => ['store']]);
        $this->middleware('permission:bahan-edit', ['only' => ['update']]);
        $this->middleware('permission:bahan-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $bahan = BahanCategory::query();
            return DataTables::of($bahan)->make();
        }
        return view('bahan-category.index');
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
            'bahan_category_name' => 'required|unique:bahan_categories,bahan_category_name,NULL,NULL,deleted_at,NULL',
        ],
        [
            'bahan_category_name.unique' => 'Nama bahan sudah digunakan',
        ]);
        BahanCategory::create($request->all());
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
            'bahan_category_name' => "required|unique:bahan_categories,bahan_category_name,$id,bahan_category_id,deleted_at,NULL",
        ],
        [
            'bahan_category_name.unique' => 'Nama bahan sudah digunakan',
        ]);
        BahanCategory::where('bahan_category_id', $id)->update($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        BahanCategory::where('bahan_category_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function ajax(Request $request)
    {
        try {
            $bahan = BahanCategory::select('bahan_category_id', 'bahan_category_name')
                ->when($request->search, function($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(bahan_category_name) LIKE ? ',['%'.$keyword.'%']);

                })
                ->limit(10)
                ->get();
            if($bahan->isNotEmpty()) {

                return response()->json([
                    'results' => $bahan
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}
