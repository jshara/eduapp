<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Enrolment;
use DB;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cid)
    {
        $s_ids = DB::table('enrolments')->select('s_id')->where('c_id',$cid)->get();
        return view('student.details')->with('s_ids',$s_ids)->with('c_id',$cid);
    }

    public function ajaxcreate(Request $request){
        $e = new Enrolment();
        $s = new Student();

        if(DB::table('students')->where('student_id',$request->student_id)->doesntExist()){
            $s->student_id = $request->student_id;
            $s->save();
           
            $e->s_id = $s->s_id;
            $e->c_id = $request->c_id;
            $e->save();
        }else{
            $sid = Student::where('student_id',$request->student_id)->value('s_id');
            $e->s_id = $sid;
            $e->c_id = $request->c_id;
            $e->save();
        }      
        return response()->json(['student' => $s, 'enrolment' => $e]);
        // return response()->json($s);
    }

    public function ajaxdelete(Request $request){
        $number = DB::table('enrolments')->where('s_id',$request->sid)->count();
        if($number == '1'){
            $student = Student::find($request->sid);
            // dd($student);
            $student->delete();
        }else{
            $eid = DB::table('enrolments')->where('c_id',$request->cid)->where('s_id',$request->sid)->value('e_id');
            $enrolment = Enrolment::find($eid);
            // dd($enrolment);
            $enrolment->delete();
        }
        return response()->json($number);
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
        //
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
