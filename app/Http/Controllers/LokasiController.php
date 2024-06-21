<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class LokasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:lokasi-list', ['only' => ['index']]);
        $this->middleware('permission:lokasi-create', ['only' => ['store']]);
        $this->middleware('permission:lokasi-edit', ['only' => ['update']]);
        $this->middleware('permission:lokasi-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $lokasi = Lokasi::query();
            return DataTables::of($lokasi)->make();
        }
        return view('lokasi.index');
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
            'nama_lokasi' => 'required|unique:lokasi,nama_lokasi,NULL,NULL,deleted_at,NULL',
        ],
        [
            'nama_lokasi.unique' => 'Nama Lokasi sudah digunakan',
        ]);
        Lokasi::create($request->all());
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
            'nama_lokasi' => "required|unique:lokasi,nama_lokasi,$id,id_lokasi,deleted_at,NULL",
        ],
        [
            'nama_lokasi.unique' => 'Nama Lokasi sudah digunakan',
        ]);
        Lokasi::where('id_lokasi', $id)->update($request->all());
        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Lokasi::where('id_lokasi', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function ajax(Request $request)
    {
        try {
            $bahan = Lokasi::select('id_lokasi', 'nama_lokasi')
                ->when($request->search, function($query, $keyword) {
                    $keyword = strtolower($keyword);
                    $query->whereRaw('LOWER(nama_lokasi) LIKE ? ',['%'.$keyword.'%']);

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
