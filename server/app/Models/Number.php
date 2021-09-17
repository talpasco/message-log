<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['num_id', 'cnt_id', 'num_number', 'num_created'];
}
