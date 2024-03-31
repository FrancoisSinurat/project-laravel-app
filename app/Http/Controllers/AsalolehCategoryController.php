<?php

namespace App\Http\Controllers;

use App\Models\AsalolehCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class AsalolehCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:asal-oleh-list', ['only' => ['index']]);
        $this->middleware('permission:asal-oleh-create', ['only' => ['store']]);
        $this->middleware('permission:asal-oleh-edit', ['only' => ['update']]);
        $this->middleware('permission:asal-oleh-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $asaloleh = AsalolehCategory::query();
            return DataTables::of($asaloleh)->make();
        }
        return view('asaloleh-category.index');
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
            'asaloleh_category_name' => 'required|unique:asaloleh_categories,asaloleh_category_name,NULL,NULL,deleted_at,NULL',
        ],
        [
            'asaloleh_category_name.unique' => 'Nama sudah digunakan',
        ]);
        AsalolehCategory::create($request->all());
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
            'asaloleh_category_name' => "required|unique:asaloleh_categories,asaloleh_category_name,$id,asaloleh_category_id,deleted_at,NULL",
        ],
        [
            'asaloleh_category_name.unique' => 'Nama sudah digunakan',
        ]);
        AsalolehCategory::where('asaloleh_category_id', $id)->update($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        AsalolehCategory::where('asaloleh_category_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function ajax(Request $request)
    {
        try {
            $asalOleh = AsalolehCategory::select('asaloleh_category_id', 'asaloleh_category_name')
                ->when($request->search, function($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(`asaloleh_category_name`) LIKE ? ',['%'.$keyword.'%']);
                })
                ->limit(10)
                ->get();
            if($asalOleh->isNotEmpty()) {

                return response()->json([
                    'results' => $asalOleh
                ], 200);
            }


            return response()->json([], 200);

        } catch (\Exception $e) {

            Log::error($e->getMessage());
        }
    }
}

