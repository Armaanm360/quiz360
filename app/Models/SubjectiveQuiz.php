<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectiveQuiz extends Model
{
    protected $table = "subjective_quiz_table";
    protected $primaryKey = 'subjective_quiz_id';
    protected $guarded = [];
}
