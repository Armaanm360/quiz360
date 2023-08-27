<?php

namespace App\Http\Controllers\CreateQuestion;

use App\Http\Controllers\Controller;
use App\Models\SubjectiveQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use DataTables;

class CreateQuestionController extends Controller
{
    function createQuestionView($id)
    {

        $data['quiz_info'] =  SubjectiveQuiz::where('subjective_quiz_id', $id)->first();
        $question = $data['quiz_info']['question_table'];
        $projects = DB::table($question)->get();


        if (request()->ajax()) {
            return  DataTables::of($projects)
                ->addIndexColumn()
                ->addColumn('action', function ($project) {

                    $editBtn =  '<button ' .
                        ' class="btn btn-outline-success" ' .
                        ' onclick="editProject(' . $project->quiz_id  . ')">Edit' .
                        '</button> ';

                    $deleteBtn =  '<button ' .
                        ' class="btn btn-outline-danger" ' .
                        ' onclick="destroyProject(' . $project->quiz_id . ')">Delete' .
                        '</button> ';

                    return  $editBtn . $deleteBtn;
                })
                ->rawColumns(
                    [
                        'action',
                    ]
                )
                ->make(true);
        }
        return view('admin.pages.question.question_view', $data);
    }


    public function createSubjectiveQuestionStore(Request $request)
    {
        $subjective_quiz_id = $request->quiz_question_id;
        $table_info = DB::table('subjective_quiz_table')->where('subjective_quiz_id', $subjective_quiz_id)->first();
        $question_table = $table_info->question_table;


        $question = DB::table($question_table)->insert([
            'quiz_question' => $request->quiz_question,
            'quiz_option_1' => $request->quiz_option_1,
            'quiz_option_2' => $request->quiz_option_2,
            'quiz_option_3' => $request->quiz_option_3,
            'quiz_option_4' => $request->quiz_option_4,
            'quiz_answer'   => $request->quiz_answer
        ]);
    }

    function deleteQuiz($quiz_id, $question_id)
    {

        $question_table = SubjectiveQuiz::where('subjective_quiz_id', $quiz_id)->first();

        DB::table($question_table)->where('quiz_id', $question_id)->delete();

        return response()->json(['status' => "success"]);
    }
}
