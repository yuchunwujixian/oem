<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginBand extends Model
{
    public $fillable = [
        'user_id', 'open_id', 'created_at', 'updated_at', 'type'
    ];

    public function userInfo()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
