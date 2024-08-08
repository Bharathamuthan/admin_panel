<?php

namespace App\Http\Controllers\Backend\Admin;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use App\Models\Blog;
use App\Models\Import;
use App\Exports\ExportUser;
use View;
use DB;
use pdf;

class BlogController extends Controller
{
   /**
    * Display a listing of the resource.
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $products = Import::all();
        return view('backend.admin.blog.index', compact('products'))->with('i', 0);

    }
   public function create(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('blog-create');
         if ($haspermision) {
            $view = View::make('backend.admin.blog.create')->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new ProductsImport, $request->file('file'));

        return redirect()->route('admin.blogs.create')->with('success', 'File imported successfully.');
    }

    public function toggleProductStatus(Request $request)
{
    $ids = $request->ids; 
    $status = $request->status;

    if (!empty($ids)) {
        Import::whereIn('id', $ids)->update(['status' => $status]);
        return response()->json(['success' => true]);
    }
    return response()->json(['success' => false]);
}

    

    public function export()
    {
        $imports = Import::where('status', 1)->get();
        return Excel::download(new ExportUser($imports), 'import.xlsx');
    }

}
