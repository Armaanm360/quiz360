<?php

namespace App\Http\Controllers\Subject;

use App\Http\Controllers\Controller;
use App\Models\Division;
use App\Models\Subject\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Subject::where('college_subject_created_by', Auth::user()->id)
            ->join('college_division', 'college_division.college_div_id', '=', 'college_subject.college_subject_div')
            ->select('college_subject.college_sub_id', 'college_subject.college_subject_name', 'college_subject.college_subject_div', 'college_subject.college_subject_desc', 'college_subject.college_subject_code', 'college_subject.college_subject_created_by', 'college_subject.status', 'college_division.college_division')
            ->get();

        if (request()->ajax()) {
            return  DataTables::of($projects)
                ->addColumn('action', function ($project) {

                    $editBtn =  '<button ' .
                        ' class="btn btn-outline-success" ' .
                        ' onclick="editProject(' . $project->college_sub_id  . ')">Edit' .
                        '</button> ';

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


        $data['college_division'] = Division::where('college_div_created_by', Auth::user()->id)->get();


        return view('admin.pages.subject.list_subject', $data);
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
        request()->validate([
            'college_subject_name' => 'required|max:255',
            'college_subject_div' => 'required',
            'college_subject_code' => 'required',
        ]);

        $subject = new Subject();
        $subject->college_subject_name = $request->college_subject_name;
        $subject->college_subject_div = $request->college_subject_div;
        $subject->college_subject_desc = $request->college_subject_desc;
        $subject->college_subject_code = $request->college_subject_code;
        $subject->college_subject_created_by = Auth::user()->id;
        $subject->save();
        return response()->json(['status' => "success"]);
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
        $project = Subject::find($id);
        return response()->json(['project' => $project]);
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
        request()->validate([
            'college_subject_name' => 'required|max:255',
            'college_subject_div' => 'required',
            'college_subject_code' => 'required',
        ]);

        $subject = Subject::find($id);
        $subject->college_subject_name = $request->college_subject_name;
        $subject->college_subject_div = $request->college_subject_div;
        $subject->college_subject_desc = $request->college_subject_desc;
        $subject->college_subject_code = $request->college_subject_code;
        $subject->save();
        return response()->json(['status' => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Subject::destroy($id);
        return response()->json(['status' => "success"]);
    }
}
