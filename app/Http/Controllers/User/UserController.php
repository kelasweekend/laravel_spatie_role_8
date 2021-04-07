<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-view', ['only' => ['index', 'edit']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $roles = Role::pluck('name', 'name')->all();
        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('role', function ($user) {
                    // $role = DB::table('model_has_roles')->get();
                    $permissions = Permission::join("role_has_permissions", "role_has_permissions.permission_id", "=", "permissions.id")
                        ->get();
                    foreach ($user->getRoleNames() as $v) {
                        $role = '<span class="badge badge-success">' . $v . '</span>';
                    }

                    return $role;
                })
                ->addColumn('akses', function ($user) {
                    $role = DB::table('model_has_roles')->where('model_id', $user->id)->first();
                    $permissions = DB::table('permissions')
                        ->select('role_has_permissions.*', 'permissions.*')
                        ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                        ->get();
                    $options = '';
                    // here we prepare the options
                    foreach ($permissions as $color) {
                        if ($color->role_id == $role->role_id) {
                            $options .= '<span class="badge badge-info mr-1">' . $color->name . '</span>';
                        }
                    }
                    $return = $options;

                    return $return;
                })
                ->addColumn('action', function ($row) {
                    if (Auth::user()->hasPermissionTo('view-only')) {
                        $btn = '<button type="button" class="btn btn-secondary col-12">View Only</button>';
                    } else {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-url="' . route('users.destroy', $row->id) . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fas fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['akses', 'role', 'action'])
                ->make(true);
        }
        return view('users.index', compact('roles'));
    }

    public function edit($id)
    {
        $item = User::find($id);
        return response()->json($item);
    }
    public function store(Request $request)
    {
        if ($request->Item_id == '') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|same:confirm-password',
                'roles' => 'required'
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'Item_id' => 'required',
                'name' => 'required',
                'email' => 'email',
                'password' => 'same:confirm-password',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 200);
        }
        $user = User::updateOrCreate(
            ['id' => $request->Item_id],
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]
        );
        if ($request->Item_id != '' && $request->roles != '') {
            DB::table('model_has_roles')->where('model_id', $request->Item_id)->delete();
            $user->assignRole($request->roles);
        } else {
            $user->assignRole($request->roles);
        }
        return response()->json(['success' => 'Item deleted successfully.']);
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success' => 'Item deleted successfully.']);
    }
}
