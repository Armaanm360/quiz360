<?php

namespace App\Http\Controllers\SubjectQuiz;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Subject\Subject;
use App\Models\SubjectiveQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\DB;

class SubjectiveQuizZController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $projects = Subject::where('college_subject_created_by', Auth::user()->id)
        //     ->join('college_division', 'college_division.college_div_id', '=', 'college_subject.college_subject_div')
        //     ->select('college_subject.college_sub_id', 'college_subject.college_subject_name', 'college_subject.college_subject_div', 'college_subject.college_subject_desc', 'college_subject.college_subject_code', 'college_subject.college_subject_created_by', 'college_subject.status', 'college_division.college_division')
        $projects = SubjectiveQuiz::where('quiz_creator_id', Auth::user()->id)->join('college_subject', 'college_subject.college_sub_id', '=', 'subjective_quiz_table.subjective_sub_id')->select(
            'college_subject.college_subject_name',
            'subjective_quiz_table.subjective_quiz_id',
            'subjective_quiz_table.subjective_sub_id',
            'subjective_quiz_table.subjective_quiz_name',
            'subjective_quiz_table.quiz_code',
            'subjective_quiz_table.quiz_type',
            'subjective_quiz_table.quiz_number',
            'subjective_quiz_table.quiz_time'
        )->get();


        if (request()->ajax()) {
            return  DataTables::of($projects)
                ->addColumn('action', function ($project) {

                    $editBtn =  '<a ' .
                        ' class="btn btn-outline-success" ' .
                        ' href="create-subjective-question/' . $project->subjective_quiz_id . '">Add Question' .
                        '</a> ';

                    $deleteBtn =  '<button ' .
                        ' class="btn btn-outline-danger" ' .
                        ' onclick="destroyProject(' . $project->college_sub_id  . ')">Delete' .
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


        $data['college_subject'] = Subject::where('college_subject_created_by', Auth::user()->id)->get();


        return view('admin.pages.subjective_quiz.list_subjective_quiz', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $subjective_sub_id = $request->subjective_sub_id;
        $subjective_quiz_name = $request->subjective_quiz_name;
        $qz_name = substr($request->subjective_quiz_name, 0, 3);
        $sub_name = $request->subjectname;
        $quiz_creator_id = $request->quiz_creator_id;
        $quiz_code = $request->quiz_code;
        $quiz_type = $request->quiz_type;
        $quiz_number = $request->quiz_number;
        $quiz_time = $request->quiz_time;
        $question_table = strtolower($qz_name . '_' . $sub_name . '_' . $quiz_code . '_' . $quiz_number . '_' . 'question');
        $answer_table = strtolower($qz_name . '_' . $sub_name . '_' . $quiz_code . '_' . $quiz_number . '_' .  'answer');



        $createTableSqlString = "CREATE TABLE $question_table (
              quiz_id INT AUTO_INCREMENT primary key NOT NULL,
              quiz_code varchar(255),
              quiz_sub_name varchar(255),
              quiz_sub_id varchar(255),
              quiz_question LONGTEXT,
              quiz_option_1 LONGTEXT,
              quiz_option_2 LONGTEXT,
              quiz_option_3 LONGTEXT,
              quiz_option_4 LONGTEXT,
              quiz_answer LONGTEXT,
              quiz_remarks LONGTEXT)";



        $createTableSqlStringAnswer = "CREATE TABLE $answer_table (quiz_ans_id INT AUTO_INCREMENT primary key NOT NULL,";

        for ($i = 1; $i <= $quiz_number; $i++) {
            $createTableSqlStringAnswer .= " ans_$i LONGTEXT,";
        }

        $createTableSqlStringAnswer .= "takentime FLOAT,answerd_by int(11),right_ans int(11),wrong_ans int(11),skipped_ans int(11),total_marks int(11))";

        DB::statement($createTableSqlString);
        DB::statement($createTableSqlStringAnswer);



        $subjectiveQuiz = new SubjectiveQuiz();
        $subjectiveQuiz->subjective_quiz_name = $request->subjective_quiz_name;
        $subjectiveQuiz->subjective_sub_id = $request->subjective_sub_id;
        $subjectiveQuiz->quiz_creator_id = Auth::user()->id;
        $subjectiveQuiz->quiz_code = $request->quiz_code;
        $subjectiveQuiz->quiz_number = $request->quiz_number;
        $subjectiveQuiz->quiz_time = $request->quiz_time;
        $subjectiveQuiz->quiz_type = $request->quiz_type;
        $subjectiveQuiz->question_table    = $question_table;
        $subjectiveQuiz->answer_table    = $answer_table;
        $subjectiveQuiz->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
