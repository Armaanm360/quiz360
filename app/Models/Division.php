<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = "college_division";
    protected $primaryKey = 'college_div_id';
    protected $guarded = [];
}
