<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $table = 'sms';
    public $timestamps = false;
    public $fillable = array(
        'username','user_id','sms_type',  'code', 'type', 'status', 'created_at'
    );
}
