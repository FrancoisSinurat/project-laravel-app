<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:peminjaman-list', ['only' => ['index']]);
        $this->middleware('permission:peminjaman-create', ['only' => ['store']]);
        $this->middleware('permission:peminjaman-edit', ['only' => ['update']]);
        $this->middleware('permission:peminjaman-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        if($request->ajax()) {
            $peminjaman = Peminjaman::query()->with('asset','user', 'peminjamanApproval', 'peminjamanApproval.user');
            $user = Auth::user();
            if (!$user->hasPermissionTo('aset-persetujuan_peminjaman') && !$user->hasRole('Super Admin')) {
                $peminjaman = $peminjaman->where('user_id', $user->user_id);
            }
            return DataTables::of($peminjaman)->make();
        }
        $asset = Asset::get();
        return view('peminjaman.index', compact('asset'));
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
        $input = $request->all();
        try {
            DB::beginTransaction();
                $data = Peminjaman::normalize($input);
                Peminjaman::createPeminjaman($data);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
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
        $input = $request->all();
        try {
            DB::beginTransaction();
                $input['asset_peminjaman_id'] = $id;
                Peminjaman::updatePeminjaman($input);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Peminjaman::where('asset_peminjaman_id', $id)->delete();
        return response()->json([
            'status' => true,
        ], 200);
    }
}
