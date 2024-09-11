<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function all()
    {
        $admin = auth()->user();
        $url = '/all-administrator';

        if (request()->ajax()) {
            $administrator = (!$admin->hasRole('Super Admin')) ? Administrator::orderBy('updated_at', 'desc')->get() : Administrator::withTrashed()->orderBy('updated_at', 'desc')->get();
            return DataTables::of($administrator)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $action = '
                        <div>
                    ';

                    if (!$item->deleted_at) {
                        $action .= '
                            <a href="'.route('all-administrator.update', $item->id).'" class="btn btn-warning btn-sm text-white">
                                <i class="bi bi-pencil-fill" style="margin-right:unset!important;"></i>
                            </button>
                         <a onclick="deleteAdmin(event,this)" href="'.route('all-administrator.delete', $item->id).'"
                            class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Delete This Account">
                            <i class="bi bi-trash-fill" style="margin-right:unset!important;"></i>
                        </a>';
                    }else{
                        $action .= '-';
                    }

                    $action .= '</div>';

                    return $action;
                })
                ->addColumn('status', function ($item) {
                    if ($item->deleted_at) {
                        $status = '
                            <a onclick="restoreAdmin(event,this)" href="' . route('all-administrator.restore', $item->id) . '"
                            class="btn btn-danger btn-sm"
                            data-toggle="tooltip" data-placement="top"
                            title="Click to Restore This Account">Inactive</a>
                        ';
                    } else {
                        $status = '
                            <a href="javascript:void(0)"
                            class="btn btn-secondary btn-sm">Active</a>
                        ';
                    }
                    return $status;
                })
                ->make();
        }

        return view('admin.admin-all', compact(['admin', 'url']));
    }

    public function add(){
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('Super Admin')) {
            return redirect('all-administrator')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $admin = auth()->user();
        $url = '/all-administrator/add';

        return view('admin.admin-add', compact(['admin', 'url']));
    }

    public function create(Request $request)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('Super Admin')) {
            return redirect('all-administrator')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:administrators',
            'type' => 'required',
            'password' => 'required|confirmed|string|min:8',
        ]);


        $new_admin = new Administrator();
        $new_admin->name = $request->name;
        $new_admin->username = $request->username;
        $new_admin->type = $request->type;
        $new_admin->password = Hash::make($request->password);
        $new_admin->created_by = $logged_admin->username;
        $new_admin->save();

        return redirect('all-administrator')->with([
            'success_flash' => 'New Admin Created Successfully!',
        ]);
    }

    public function update($id_admin){
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('Super Admin')) {
            return redirect('all-administrator')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }
        
        $admin = auth()->user();
        $url = '/all-administrator';

        $data_admin = Administrator::findOrFail($id_admin);

        return view('admin.admin-update', compact(['admin', 'url', 'data_admin']));
    }

    public function edit(Request $request, $id)
    {
        $admin = auth()->user();
        if (!$admin->hasRole('Super Admin')) {
            return redirect('all-administrator')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }
        

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => ['required', 'string','max:255',Rule::unique('administrators', 'username')->ignore($id),],
            'type' => 'required',
            'password' => 'nullable|string|min:8',
        ]);

        $update_admin = Administrator::findOrFail($id);
        $update_admin->name = $request->name;
        $update_admin->username = $request->username;
        if ($request->filled('password')) {
            $update_admin->password = Hash::make($request->password);
        }
        $update_admin->type = $request->type;
        $update_admin->save();

        return redirect('all-administrator')->with([
            'success_flash' => 'Admin Updated Successfully!',
        ]);
    }

    public function delete($id)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('Super Admin')) {
            return redirect('all-administrator')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $admin = Administrator::find($id);

        if ($admin) {
            $admin->delete();
            return redirect()->back()->with('success_flash', 'Admin Deleted!');
        } else {
            return redirect()->back()->with('error_flash', 'Admin Not Found.');
        }
    }

    public function restore($id)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('Super Admin')) {
            return redirect('all-administrator')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $admin = Administrator::withTrashed()->find($id);
        if ($admin) {
            $admin->restore();
            return redirect()->back()->with('success', 'Admin Restored Successfully.');
        } else {
            return redirect()->back()->with('error', 'Admin Not Found.');
        }
    }

    public function update_profile(Request $request, $id)
    {
        $logged_admin = auth()->user();
        if ($logged_admin->id != $id) {
            return redirect('all-administrator')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $this->validate($request, [
            'name_my' => 'required|string|max:255',
            'username_my' => ['required','string','max:255',Rule::unique('administrator', 'username')->ignore($id),],
            'type_my' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        $my_profile = Administrator::findOrFail($id);
        $my_profile->name = $request->name_my;
        $my_profile->username = $request->username_my;
        if ($request->filled('password')) {
            $my_profile->password = Hash::make($request->password);
        }
        if ($request->filled('type_my')) {
            $my_profile->type = $request->type_my;
        }
        $my_profile->save();

        return redirect()->back()->with([
            'success_flash' => 'My Profile Updated Successfully!',
        ]);
    }
}
