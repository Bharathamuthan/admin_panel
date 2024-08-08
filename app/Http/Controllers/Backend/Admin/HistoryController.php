<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Admin;
use App\Models\Users;
use App\Models\Import;
use App\Models\History;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\ExportUser;
use View;
use DB;

class HistoryController extends Controller
{
    public function index()
    {
        $historys = History::all();

        return view('backend.admin.history.index', compact('historys'));
    }

    public function show($id)
    {
        $history = History::findOrFail($id);
        $importIds = explode(',', $history->count_id);
        $imports = Import::whereIn('id', $importIds)->get();
        $history->imports = $imports;
    
        return view('backend.admin.history.show', compact('history'));
    }
    


    public function export($id)
    {
        $history = History::findOrFail($id);
        return Excel::download(new ExportUser($history), 'history-' . $history->id . '.xlsx');
    }
    // public function export()
    // {
    //     return Excel::download(new ExportUser, 'users.xlsx');
    // }
    // public function export($id)
    // {
    //     $history = History::findOrFail($id);
    //     return Excel::download(new ExportUser($history), 'history-' . $history->id . '.xlsx');
    // }
}
