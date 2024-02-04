<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:role-list', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['store']]);
        $this->middleware('permission:role-edit', ['only' => ['update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $item = Role::query()->with('permissions');
            return DataTables::of($item)->make();
        }
        $permission = Permission::get();
        $populatePermission = [];
        foreach ($permission as $key => $val) {
            $permissionArr = explode('-', $val->name);
            array_pop($permissionArr);
            $permissionName = implode(' ', $permissionArr);
            $populatePermission[$permissionName][] = ['id'=>$permission[$key]->id, 'name' => $permission[$key]->name];
        }
        return view('role.index', compact('populatePermission'));
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
            'name' => 'required|unique:roles,name',
        ],
        [
            'name.unique' => 'Nama sudah digunakan',
        ]);
        try {
            DB::beginTransaction();
            $role = Role::create(['name' => ucwords(strtolower($request->name))]);
            $role->syncPermissions($request->permission);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json([
                'status' => true,
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
            'name' => "required|unique:roles,name,$id,id",
        ],
        [
            'name.unique' => 'Nama sudah digunakan',
        ]);
        try {
            DB::beginTransaction();
                Role::where('id', $id)->update(['name' => ucwords(strtolower($request->name))]);
                Role::find($id)->syncPermissions($request->permission);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json([
                'status' => true,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if ($id == null) {
                return response()->json([
                    'status' => false,
                ], 500);
            }
            DB::beginTransaction();
                Role::find($id)->syncPermissions([]);
                Role::find($id)->delete();
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json([
                'status' => true,
            ], 500);
        }
    }
}
