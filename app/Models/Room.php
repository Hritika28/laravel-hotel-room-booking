<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model {
    protected $fillable = ['floor','room_number','index_on_floor','is_available'];
}
