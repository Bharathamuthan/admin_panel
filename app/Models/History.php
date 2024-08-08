<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;

class History extends Model
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'user_id', 'changed_by', 'name', 'count', 'count_id', 'contact_number', 'imports_updated_at'
    ];

    public function import()
    {
        return $this->belongsTo(Import::class, 'count_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    protected $table = 'history';

    public static function getImportsWithUserNames()
    {
        return DB::table('history')
            ->join('users', 'history.user_id', '=', 'users.id')
            ->select('history.*', 'users.name', 'users.phone_number')
            ->get();
    }

    public static function getHistoryWithImportDetails()
    {
        return DB::table('history')
            ->join('imports', 'history.user_id', '=', 'imports.id')
            ->select('history.*', 'imports.updated_at')
            ->get();
    }

    public static function getHistoryByChangedBy()
    {
        return DB::table('history')
            ->join('imports', 'history.count_id', '=', 'imports.id')
            ->select('history.*', 'imports.name')
            ->get();
    }
}
