<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Import;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('backend.user.profile', compact('user'));
    }

    public function excelList()
    {
        $users = Import::all();
        return view('backend.user.excel',compact('users'));
    }

    public function toggleUserStatus(Request $request)
{
    // Validate request
    $request->validate([
        'id' => 'required|exists:imports,id',
        'status' => 'required|boolean',
    ]);

    try {
        // Retrieve logged-in user
        $loggedInUser = Auth::user();

        // Ensure user is authenticated
        if (!$loggedInUser) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Fetch the import record to update
        $import = Import::findOrFail($request->id);

        // Update import status and changed_by field
        $import->status = $request->status;
        $import->changed_by = $loggedInUser->id;
        $import->save();

        // Fetch or create a history record for the logged-in user
        $history = History::firstOrNew(['changed_by' => $loggedInUser->id]);
        $history->name = $loggedInUser->name;
        $history->contact_number = $loggedInUser->phone_number;
        $history->imports_updated_at = now();

        // Increment the count field only if the status is active and the ID hasn't been counted yet
        $existingIds = explode(',', $history->count_id);
        if ($request->status && !in_array($import->id, $existingIds)) {
            $history->count = $history->count ? $history->count + 1 : 1;
            $existingIds[] = $import->id;
        }

        // Update the count_id field
        $history->count_id = implode(',', $existingIds);
        $history->save();

        // Fetch count of status changes for the logged-in user
        $activeCount = Import::where('changed_by', $loggedInUser->id)->where('status', 1)->count();
        $inactiveCount = Import::where('changed_by', $loggedInUser->id)->where('status', 0)->count();

        // Return success response with counts
        return response()->json([
            'success' => true,
            'active_count' => $activeCount,
            'inactive_count' => $inactiveCount,
        ]);

    } catch (\Exception $e) {
        // Handle errors
        \Log::error('Error in toggleUserStatus: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
    }
}   

    public function edit($id)
{
    $user = User::find($id);
    if (Gate::denies('edit-user', $user)) {
        abort(403, 'You are not authorized to edit this user');
    }

    return view('backend.user.edit', compact('user'));
}


    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(['id', 'name', 'email', 'phone_number', 'address', 'pin_code', 'location', 'status']);
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('edit', function ($row) {
                    return '<button class="btn btn-primary edit" id="' . $row->id . '">Edit</button>';
                })
                ->rawColumns(['edit'])
                ->make(true);
        }
        return view('backend.user.edit', compact('user'));
    }


    public function profile()
    {
        $user = Auth::user();
        return view('backend.user.profile', compact('user'));
    }



    public function getAll()
    {
       $can_edit = '';
       if (!auth()->user()->can('user-edit')) {
          $can_edit = "style='display:none;'";
       }
    //    if (!auth()->user()->can('user-delete')) {
    //       $can_delete = "style='display:none;'";
    //    }
       $users = User::all();
       return Datatables::of($users)
         ->addColumn('file_path', function ($users) {
            return "<img src='" . asset($users->file_path) . "' class='img-thumbnail' width='50px'>";
         })
         ->addColumn('status', function ($users) {
             return $users->status ? '<label class="badge badge-success">Active</label>' : '<label class="badge badge-danger">Inactive</label>';
          })


         ->rawColumns(['edit', 'file_path', 'status', 'role'])
         ->addIndexColumn()
         ->make(true);
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {

            $user = User::findOrFail(Auth::user()->id);

            $rules = [
                'name' => 'required',
                'photo' => 'image|max:2024|mimes:jpeg,jpg,png'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {

                $file_path = $request->input('SelectedFileName');;

                if ($request->hasFile('photo')) {
                    if ($request->file('photo')->isValid()) {
                        $destinationPath = public_path('assets/images/users/');
                        $extension = $request->file('photo')->getClientOriginalExtension(); // getting image extension
                        $fileName = time() . '.' . $extension;
                        $file_path = 'assets/images/users/' . $fileName;
                        $request->file('photo')->move($destinationPath, $fileName);
                    } else {
                        return response()->json([
                            'type' => 'error',
                            'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                        ]);
                    }
                }

                DB::beginTransaction();
                try {
                    $user->name = $request->input('name');
                    $user->file_path = $file_path;
                    $user->save();

                    DB::commit();
                    return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

                } catch (\Exception $e) {
                    DB::rollback();
                    return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
                }

            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }

    public function change_password()
    {
        return view('backend.user.change_password');
    }

    public function update_password(Request $request)
    {
        if ($request->ajax()) {

            $user = User::findOrFail(Auth::user()->id);

            $rules = [
                'password' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => $validator->getMessageBag()->toArray()
                ]);
            } else {
                $user->password = Hash::make($request->input('password'));
                $user->save(); //
                return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
            }
        } else {
            return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
        }
    }


}
