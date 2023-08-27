<?php

namespace App\Models\Subject;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = "college_subject";
    protected $primaryKey = 'college_sub_id';
    protected $guarded = [];
}
