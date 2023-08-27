<?php

namespace App\Http\Controllers\Exam;

use App\Http\Controllers\Controller;
use App\Models\SubjectiveQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['quiz_list'] = SubjectiveQuiz::join('college_subject', 'college_subject.college_sub_id', '=', 'subjective_quiz_table.subjective_sub_id')->get();
        // echo '<pre>';
        // print_r($data['quiz_list']);
        // die;
        return view('layouts.pages.Exam.Exam', $data);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tab = SubjectiveQuiz::where('subjective_quiz_id', $id)->join('college_subject', 'college_subject.college_sub_id', '=', 'subjective_quiz_table.subjective_sub_id')->first();
        $tab_get = $tab->question_table;
        $data['exam_name'] = $tab->subjective_quiz_name;
        $data['subject'] = $tab->college_subject_name;
        $data['type'] = $tab->quiz_type;

        $data['code'] = $tab->quiz_code;
        $data['quiz_time'] = $tab->quiz_time;
        $data['subjective_quiz_id'] = $tab->subjective_quiz_id;
        $data['question_first'] = DB::table($tab_get)->first();
        $data['question_last'] = DB::table($tab_get)->orderBy('quiz_id', 'desc')->first();
        $data['questions'] = DB::table($tab_get)->get();
        $data['count'] = DB::table($tab_get)->count();



        return view('layouts.pages.Exam.view_exam', $data);
    }


    public function quizPost(Request $request)
    {
        // countquiztime
        $user_answer = $request->all();
        // echo '<pre>';
        // print_r($user_answer);
        // die;
        $subjective_quiz_id = $request->get_subjective_id;

        $table_info = DB::table('subjective_quiz_table')->where('subjective_quiz_id', $subjective_quiz_id)->get();
        $question_table = $table_info[0]->question_table;
        $answer_table = $table_info[0]->answer_table;
        $get_type     = $table_info[0]->quiz_type;
        $quiz_time     = $table_info[0]->quiz_time;
        $row_count = DB::table($question_table)->count();

        $range = range(1, $row_count);

        $get_number = (object)$range;







        $i = $get_number;

        foreach ($i as $icount) {
            $em = 'quiz_' . $icount;
            $dem = 'ans_' . $icount;
            $data[$dem] = $request->$em;
        }

        $answers = DB::table($question_table)->select('quiz_answer')->get();
        $json = json_encode($answers);
        $array = json_decode($json, true);

        $user_answer = $request->all();


        $user_answer_slice = array_slice($user_answer, 1);
        unset($user_answer_slice['get_subjective_id']);
        unset($user_answer_slice['countquiztime']);

        // echo '<pre>';
        // print_r($user_answer_slice);die;

        $data['answerd_by'] = Auth::user()->id;

        $array_user = array_values($user_answer_slice);
        $array_quiz = array_column($array, 'quiz_answer');
        $wrong_answers = count(array_diff($array_user, $array_quiz));
        $answerd = count($user_answer_slice);



        $data['skipped_ans'] = $row_count - $answerd;
        $data['right_ans'] = $answerd - $wrong_answers;
        $data['wrong_ans'] = $wrong_answers;
        $data['total_marks'] = $data['right_ans'] * 1;

        if ($request->countquiztime == null) {
            $data['takentime'] = $quiz_time * 60;
        } elseif ($request->countquiztime != null) {
            $data['takentime'] = $request->countquiztime;
        }

        $existingRecord = DB::table($answer_table)
            ->where('answerd_by', Auth::user()->id)
            ->first();

        if ($existingRecord) {
            // Handle the duplicate entry (optional)
            // For example, you can update the existing record here if needed

            // Alternatively, you may choose to skip the insertion to prevent duplicates
            // return or exit the function, or show an error message to the user
        } else {
            // The data doesn't exist, insert the new record into the table


            DB::table($answer_table)->insert($data);
        }


        return redirect()->back();
    }
}
