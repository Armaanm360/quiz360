<?php

namespace App\Http\Controllers\Division;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Division::where('college_div_created_by', Auth::user()->id)->latest()->get();

        if (request()->ajax()) {
            return  DataTables::of($projects)
                ->addColumn('action', function ($project) {

                    $editBtn =  '<button ' .
                        ' class="btn btn-outline-success" ' .
                        ' onclick="editProject(' . $project->college_div_id  . ')">Edit' .
                        '</button> ';

                    $deleteBtn =  '<button ' .
                        ' class="btn btn-outline-danger" ' .
                        ' onclick="destroyProject(' . $project->college_div_id  . ')">Delete' .
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


        return view('admin.pages.division.list_division');
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
            'college_division' => 'required|max:255',
            'division_unique_code' => 'required',
        ]);

        $division = new Division();
        $division->college_division = $request->college_division;
        $division->division_unique_code = $request->division_unique_code;
        $division->college_div_created_by = Auth::user()->id;
        $division->save();
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
        $project = Division::find($id);
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
            'college_division' => 'required|max:255',
            'division_unique_code' => 'required',
        ]);

        $division = Division::find($id);
        $division->college_division = $request->college_division;
        $division->division_unique_code = $request->division_unique_code;
        $division->college_div_created_by = Auth::user()->id;
        $division->save();
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
        Division::destroy($id);
        return response()->json(['status' => "success"]);
    }
}
