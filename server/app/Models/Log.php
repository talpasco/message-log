<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['log_id', 'usr_id', 'num_id', 'log_message', 'log_success', 'log_created'];
}
