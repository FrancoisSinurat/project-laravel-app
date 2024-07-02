<?php

namespace App\Http\Controllers;

use App\Models\AssetTemporary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class AssetTemporaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:aset-list', ['only' => ['index']]);
        $this->middleware('permission:aset-create', ['only' => ['store']]);
        $this->middleware('permission:aset-edit', ['only' => ['update']]);
        $this->middleware('permission:aset-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $user = Auth::user();
            $data = AssetTemporary::query()->where('asset_temporary_user_id', $user->user_id);
            return DataTables::of($data)->make();
        }
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
            'asset_temporary_bpad_code' => [
                'required',
                Rule::unique('asset_temporaries', 'asset_temporary_bpad_code')
                    ->whereNull('deleted_at'),
                Rule::unique('assets', 'asset_bpad_code')
                    ->whereNull('deleted_at')
                    ->whereNotIn('asset_bpad_code', function ($query) {
                        $query->select('asset_temporary_bpad_code')
                            ->from('asset_temporaries')
                            ->whereNull('deleted_at');
                    }),
            ],
            'asset_temporary_serial_number' => [
                'nullable',
                Rule::unique('asset_temporaries', 'asset_temporary_serial_number')
                    ->whereNull('deleted_at'),
                Rule::unique('assets', 'asset_serial_number')
                    ->whereNull('deleted_at')
                    ->whereNotIn('asset_serial_number', function ($query) {
                        $query->select('asset_temporary_serial_number')
                            ->from('asset_temporaries')
                            ->whereNull('deleted_at');
                    }),
            ],
            'asset_temporary_frame_number' => [
                'nullable',
                Rule::unique('asset_temporaries', 'asset_temporary_frame_number')
                    ->whereNull('deleted_at'),
                Rule::unique('assets', 'asset_frame_number')
                    ->whereNull('deleted_at')
                    ->whereNotIn('asset_frame_number', function ($query) {
                        $query->select('asset_temporary_frame_number')
                            ->from('asset_temporaries')
                            ->whereNull('deleted_at');
                    }),
            ],
            'asset_temporary_machine_number' => [
                'nullable',
                Rule::unique('asset_temporaries', 'asset_temporary_machine_number')
                    ->whereNull('deleted_at'),
                Rule::unique('assets', 'asset_machine_number')
                    ->whereNull('deleted_at')
                    ->whereNotIn('asset_machine_number', function ($query) {
                        $query->select('asset_temporary_machine_number')
                            ->from('asset_temporaries')
                            ->whereNull('deleted_at');
                    }),
            ],
            'asset_temporary_police_number' => [
                'nullable',
                Rule::unique('asset_temporaries', 'asset_temporary_police_number')
                    ->whereNull('deleted_at'),
                Rule::unique('assets', 'asset_police_number')
                    ->whereNull('deleted_at')
                    ->whereNotIn('asset_police_number', function ($query) {
                        $query->select('asset_temporary_police_number')
                            ->from('asset_temporaries')
                            ->whereNull('deleted_at');
                    }),
            ],
        ],
        [
            'asset_temporary_serial_number.unique' => 'Serial number sudah digunakan',
            'asset_temporary_frame_number.unique' => 'Nomor Rangka sudah digunakan',
            'asset_temporary_machine_number.unique' => 'Nomor Mesin sudah digunakan',
            'asset_temporary_police_number.unique' => 'Nomor Plat sudah digunakan',
            'asset_temporary_bpad_code.unique' => 'Kode BPAD sudah digunakan',
            'asset_temporary_bpad_code.required' => 'Kode BPAD wajib diisi',
        ]);
        $input = $request->all();
        $input['asset_temporary_user_id'] = Auth::user()->user_id;
        AssetTemporary::create($input);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if($request->ajax()) {
            $user = Auth::user();
            AssetTemporary::where('asset_temporary_id', $id)->delete();
        }
        return response()->json([
            'status' => true,
        ], 200);
    }

    public function destroyAll(Request $request)
    {
        if($request->ajax()) {
            $user = Auth::user();
            AssetTemporary::where('asset_temporary_user_id', $user->user_id)->delete();
        }
        return response()->json([
            'status' => true,
        ], 200);
    }
}
