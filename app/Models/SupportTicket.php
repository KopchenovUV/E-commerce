<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    protected $fillable = ['user_id', 'problem', 'status'];

    // Добавляем отношение к модели User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}