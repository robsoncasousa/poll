<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;

class Poll extends Model
{
    use SoftDeletes, SoftCascadeTrait;
    
    protected $softCascade = ['options'];
    protected $fillable = [ 'description', 'views' ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function options()
    {
        return $this->hasMany('App\Models\Option');
    }
}
