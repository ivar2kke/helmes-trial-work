<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Integer;

class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var array
     */
    protected $fillable = ['name', 'agree_to_terms'];

    public function sectors()
    {
        return $this->belongsToMany(Sector::class, 'user_sectors');
    }

    public static function getLastInsertId(): int
    {
        return $last_insert_id = DB::getPdo()->lastInsertId();
    }
}
