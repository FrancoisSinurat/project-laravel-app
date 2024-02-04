<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            $item = User::query()->with('roles');
            return DataTables::of($item)->make();
        }
        $role = Role::select('id', 'name')->get();
        return view('user.index', compact('role'));
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
            'user_nrk' => 'nullable|size:6|unique:users,user_nrk,NULL,NULL,deleted_at,NULL',
            'user_email' => 'required|unique:users,user_email,NULL,NULL,deleted_at,NULL',
            'user_phone' => 'nullable|unique:users,user_phone,NULL,NULL,deleted_at,NULL',
            'user_password' => 'required|min:6',
            'user_confirm_password' => 'required|same:user_password',
            'role_id' => 'required',
        ],
        [
            'user_nrk.unique' => 'NRK sudah digunakan',
            'user_nrk.size' => 'NRK harus 6 angka',
            'user_password.min' => 'Password harus 6 angka',
            'user_confirm_password.same' => 'Konfirmasi password salah',
            'user_email.unique' => 'Email sudah digunakan',
            'user_phone.unique' => 'Telepon sudah digunakan'
        ]);
        try {
            DB::beginTransaction();
                $input = $request->all();
                $input['user_nrk'] != null && $input['user_nrk'] != '' ? $input['user_name'] = $input['user_nrk'] : $input['user_name'] = $input['user_email'];
                $user = User::create($input);
                $user->assignRole([$input['role_id']]);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json([
                'status' => false,
                'data' => $th,
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
        $this->validate($request, [
            'user_nrk' => "nullable|size:6|unique:users,user_nrk,$id,user_id,deleted_at,NULL",
            'user_email' => "required|unique:users,user_email,$id,user_id,deleted_at,NULL",
            'user_phone' => "nullable|unique:users,user_phone,$id,user_id,deleted_at,NULL",
            'user_password' => 'nullable|min:6',
            'user_confirm_password' => 'nullable|same:user_password',
            'role_id' => 'required',
        ],
        [
            'user_nrk.unique' => 'NRK sudah digunakan',
            'user_nrk.size' => 'NRK harus 6 angka',
            'user_password.min' => 'Password harus 6 angka',
            'user_confirm_password.same' => 'Konfirmasi password salah',
            'user_email.unique' => 'Email sudah digunakan',
            'user_phone.unique' => 'Telepon sudah digunakan'
        ]);

        try {
            DB::beginTransaction();
                $input = $request->all();
                if ($input['user_password'] == null) unset($input['user_password']);
                $input['user_nrk'] != null && $input['user_nrk'] != '' ? $input['user_name'] = $input['user_nrk'] : $input['user_name'] = $input['user_email'];
                $user = User::find($id);
                $user->syncRoles($input['role_id']);
                $user->update($input);
            DB::commit();
            return response()->json([
                'status' => true,
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th->getMessage());
            return response()->json([
                'status' => false,
                'data' => $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
