<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission-view', ['only' => ['index', 'edit']]);
        $this->middleware('permission:permission-store', ['only' => ['store']]);
        $this->middleware('permission:permission-delete', ['only' => ['destoy']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::all();
            return Datatables::of($data)
            ->addColumn('action', function ($row) {
                    if (Auth::user()->hasPermissionTo('view-only')) {
                        $btn = '<button type="button" class="btn btn-secondary col-12">View Only</button>';
                    } else {
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm editItem"><i class="fas fa-edit"></i></a>';
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-url="' . route('permissions.destroy',$row->id) . '" data-original-title="Delete" class="btn btn-danger btn-sm deleteItem"><i class="fas fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('permissions.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions',
            'guard_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 200);
        }

        Permission::updateOrCreate(
            ['id' => $request->Item_id],
            ['name' => str_replace(' ','-', $request->name),
            'guard_name' => $request->guard_name]
        );
        return response()->json(['success' => 'Item deleted successfully.']);
    }

    public function edit($id)
    {
        $item = Permission::find($id);
        return response()->json($item);
    }

    public function destroy($id)
    {
        Permission::find($id)->delete();
        return response()->json(['success' => 'Item deleted successfully.']);
    }
}
