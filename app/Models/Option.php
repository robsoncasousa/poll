<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description', 'votes', 'poll_id'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function poll()
    {
        return $this->belongsTo('App\Models\Poll');
    }
}
