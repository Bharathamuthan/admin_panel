<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use View;
use DB;

class UserController extends Controller
{
   public function index()
   {
      return view('backend.admin.user.index');
   }

   public function getAll()
   {
      $can_edit = '';
      $can_delete = '';

      if (!auth()->user()->can('user-edit')) {
         $can_edit = "style='display:none;'";
      }
      if (!auth()->user()->can('user-delete')) {
         $can_delete = "style='display:none;'";
      }

      $users = User::all();
      return Datatables::of($users)
         ->addColumn('status', function ($users) {
            return $users->status ? '<label class="badge badge-success">Active</label>' : '<label class="badge badge-danger">Inactive</label>';
         })
         ->addColumn('edit', function ($user) use ($can_edit, $can_delete) {
            $html = '<div class="btn-group">';
            $html .= '<a data-toggle="tooltip" ' . $can_edit . '  id="' . $user->id . '" class="btn btn-xs btn-info mr-1 edit" title="Edit"><i class="fa fa-edit"></i> </a>';
            $html .= '<a data-toggle="tooltip" ' . $can_delete . ' id="' . $user->id . '" class="btn btn-xs btn-danger mr-1 delete" title="Delete"><i class="fa fa-trash"></i> </a>';
            $html .= '</div>';
            return $html;
         })
         ->rawColumns(['edit', 'status'])
         ->addIndexColumn()
         ->make(true);
   }

   public function updateStatus(Request $request)
   {
      $user = User::find($request->id);
      $adminId = auth('admin')->id();

      // Update the status
      $user->status = $request->status;
      $user->updated_by = $adminId;
      $user->updated_role = env('ROLE_ADMIN');

      $user->save();
      return response()->json(['type' => 'success', 'message' => 'Status updated successfully']);
   }

   public function create(Request $request)
   {
      if ($request->ajax()) {
         $hasPermission = auth()->user()->can('user-create');
         if ($hasPermission) {
            $roles = Role::all();
            $view = View::make('backend.admin.user.create', compact('roles'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function getUsers()
   {
      $users = User::select(['id', 'name', 'email', 'status']);
      return Datatables::of($users)
         ->addColumn('action', function ($user) {
            $viewButton = '<button class="btn btn-sm btn-primary view" id="'.$user->id.'">View</button>';
            $deleteButton = '<button class="btn btn-sm btn-danger delete" id="'.$user->id.'">Delete</button>';
            return $approveButton . ' ' . $rejectButton . ' ' . $viewButton . ' ' . $deleteButton;
         })
         ->make(true);
   }

   public function store(Request $request)
   {
      if ($request->ajax()) {
         $rules = [
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|unique:users,phone_number',
            'password' => 'required|same:confirm-password',
         ];

         $messages = [
            'name.unique' => 'This name has already been taken.',
            'email.unique' => 'This email has already been taken.',
            'phone_number.unique' => 'This phone number has already been taken.',
         ];

         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
            return response()->json([
               'type' => 'error',
               'errors' => $validator->getMessageBag()->toArray()
            ]);
         }

         DB::beginTransaction();
         try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            DB::commit();
            return response()->json(['type' => 'success', 'message' => "Successfully Created"]);

         } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function show($id, Request $request)
   {
      if ($request->ajax()) {
         $user = User::findOrFail($id);
         $view = View::make('backend.admin.user.view', compact('user'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function edit($id, Request $request)
   {
      if ($request->ajax()) {
         $hasPermission = auth()->user()->can('user-edit');
         if ($hasPermission) {
            $user = User::with('roles')->where('id', $id)->first();
            $roles = Role::all();
            $view = View::make('backend.admin.user.edit', compact('user', 'roles'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function update(Request $request, User $user)
   {
      if ($request->ajax()) {

         User::findOrFail($user->id);

         $rules = [
            'name' => 'required|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|unique:users,phone_number,' . $user->id,
         ];

         $messages = [
            'name.unique' => 'The name has already been taken.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.unique' => 'The phone number has already been taken.',
         ];

         $validator = Validator::make($request->all(), $rules, $messages);

         if ($validator->fails()) {
            return response()->json([
               'type' => 'error',
               'errors' => $validator->getMessageBag()->toArray()
            ]);
         }

         DB::beginTransaction();
         try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone_number = $request->input('phone_number');
            if ($request->filled('password')) {
               $user->password = Hash::make($request->password);
            }
            $user->status = $request->input('status');
            $user->save();

            $roles = $request->input('roles');
            if (isset($roles)) {
               $user->roles()->sync($roles);  // If one or more role is selected associate user to roles
            } else {
               $user->roles()->detach(); // If no role is selected remove existing role associated with a user
            }

            DB::commit();
            return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

         } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['type' => 'error', 'message' => $e->getMessage()]);
         }

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function destroy($id, Request $request)
   {
      if ($request->ajax()) {
         $hasPermission = auth()->user()->can('user-delete');
         if ($hasPermission) {
            $user = User::findOrFail($id); //Get user with specified id
            $user->delete();
            return response()->json(['type' => 'success', 'message' => "Successfully Deleted"]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }
}
