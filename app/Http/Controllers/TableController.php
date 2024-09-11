<?php

namespace App\Http\Controllers;

use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;


class TableController extends Controller
{
    public function all(){
        $admin = auth()->user();
        $url = '/all-table';

        if (request()->ajax()) {
            $table = Tables::withTrashed()->orderBy('updated_at', 'desc')->get();
            return DataTables::of($table)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $action = '
                        <div>
                    ';

                    if (!$item->deleted_at) {
                        $action .= '
                            <a href="'.route('all-table.update', $item->id).'" class="btn btn-warning btn-sm text-white">
                                <i class="bi bi-pencil-fill" style="margin-right:unset!important;"></i>
                            </button>
                         <a onclick="deleteTable(event,this)" href="'.route('all-table.delete', $item->id).'"
                            class="btn btn-danger btn-sm text-white" data-toggle="tooltip" data-placement="top" title="Delete This Item">
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
                            <a onclick="restoreTable(event,this)" href="' . route('all-table.restore', $item->id) . '"
                            class="btn btn-danger btn-sm"
                            data-toggle="tooltip" data-placement="top"
                            title="Click to Restore This Item">Inactive</a>
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

        return view('admin.table-all', compact(['admin', 'url']));
    }

    public function add(){
        $admin = auth()->user();
        $url = '/all-table/add';

        return view('admin.table-add', compact(['admin', 'url']));
    }

    public function create(Request $request){
        $logged_admin = auth()->user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:tables',
        ]);


        $new_table = new Tables();
        $new_table->name = $request->name;
        $new_table->code = $request->code;
        $new_table->created_by = $logged_admin->username;
        $new_table->updated_by = $logged_admin->username;
        $new_table->save();

        return redirect('all-table')->with([
            'success_flash' => 'New Table Created Successfully!',
        ]);
    }

    public function update($id_table){
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('Super Admin')) {
            return redirect('all-table')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }
        
        $admin = auth()->user();
        $url = '/all-table';

        $data_table = Tables::findOrFail($id_table);

        return view('admin.table-update', compact(['admin', 'url', 'data_table']));
    }

    public function edit(Request $request, $id){
        $admin = auth()->user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'code' => ['required', 'string','max:255',Rule::unique('tables', 'code')->ignore($id),],
        ]);

        $update_table = Tables::findOrFail($id);
        $update_table->name = $request->name;
        $update_table->code = $request->code;
        $update_table->updated_by = $admin->username;
        $update_table->save();

        return redirect('all-table')->with([
            'success_flash' => 'Table Updated Successfully!',
        ]);
    }

    public function delete($id){
        $table = Tables::find($id);

        if ($table) {
            $table->delete();
            return redirect()->back()->with('success_flash', 'Table Deleted!');
        } else {
            return redirect()->back()->with('error_flash', 'Table Not Found.');
        }
    }

    public function restore($id){
        $table = Tables::withTrashed()->find($id);
        if ($table) {
            $table->restore();
            return redirect()->back()->with('success', 'Table Restored Successfully.');
        } else {
            return redirect()->back()->with('error', 'Table Not Found.');
        }
    }
}
