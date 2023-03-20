<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    /**
     * @var string
     */
    protected $table = 'sectors';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $incrementing = true;

    public function parent(){
        return $this->belongsTo('App\Models\Sector', 'id', 'parent_id')->with('parent');
    }

    public function parent_recursive(){
        return $this->parent()->with('parent_recursive');
    }

    public function children(){
        return $this->hasMany('App\Models\Sector', 'parent_id', 'id')->with('children');
    }

    public function children_recursive(){
        return $this->children()->with('children_recursive');
    }
}
