<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportChat extends Model
{
    protected $fillable = ['user_id', 'message', 'sender'];
}