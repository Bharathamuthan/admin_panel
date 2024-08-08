<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\DB;

class Import extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    protected $fillable = [
        'unique_code', 'name', 'contact_number', 'address', 'location_1', 'location_2', 'location_3', 'pin_code', 'status', 'changed_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public static function getHistoryWithUserNames()
    {
        return DB::table('imports')
            ->join('users', 'imports.changed_by', '=', 'users.id')
            ->select('imports.*', 'users.name as user_name')
            ->get();
    }
}
