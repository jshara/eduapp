<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Enrolment;
use Illuminate\Support\Facades\Storage;
use DB;
use File;   

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
        $message = $request->student_id." successfully enrolled";
        $type = "success";

        if(DB::table('students')->where('student_id',$request->student_id)->Exists()){                   //If students Exists
            $sid = Student::where('student_id',$request->student_id)->value('s_id');
            if(DB::table('enrolments')->where('s_id',$sid)->where('c_id', $request->c_id)->Exists()){    //If enrolment Exists
                $message = "The Student ".$request->student_id." is already enrolled";
                $type = "error";
            }
            else{                                                                                       //Enrol Student
                $e->s_id = $sid;
                $e->c_id = $request->c_id;
                $e->save();
            }
        }else{                                                                                          //Add student then Enrol
            $s->student_id = $request->student_id;
            $s->save();
           
            $e->s_id = $s->s_id;
            $e->c_id = $request->c_id;
            $e->save();

            $enrolOpen = new Enrolment();                                                           // Enrol in Open course (default)
            $enrolOpen->s_id = $s->s_id;
            $enrolOpen->c_id = 1;
            $enrolOpen->save();
        } 
     
        return response()->json(['student' => $s, 'enrolment' => $e, 'message' => $message, 'type' => $type]);
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

    public function fileupload(Request $request){
        $this->validate($request,[
            'csvfile'=> 'required|mimes:csv,txt' 
        ]);
        $message = "Successfully Imported! ";
        $type = "success";
        $list ="";
        $ending ="";


        if($request->hasFile('csvfile')){
            $filenameWithExt = $request->file('csvfile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt,PATHINFO_FILENAME);
            $extension = $request->file('csvfile')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('csvfile')->storeAs('public/studentid',$fileNameToStore);
            $openfile = fopen('storage/studentid/'.$fileNameToStore,"r");
            // $openfile = fopen($path,"r");
            
            while( ($data = fgetcsv($openfile, 1000, ",")) != FALSE){
                foreach ($data as $student){
                //    echo "id: ". $student ;
                    $e = new Enrolment();
                    $s = new Student();

                    if(DB::table('students')->where('student_id',$student)->Exists()){                            //If students Exists
                        $sid = Student::where('student_id',$student)->value('s_id');
                        if(DB::table('enrolments')->where('s_id',$sid)->where('c_id', $request->c_id)->Exists()){ //If enrolment Exists
                            $except = "Except ";
                            $list .= $student.", ";
                            $ending ="Already existed in course";
                        }
                        else{                                                                                       //Enrol Student
                            $e->s_id = $sid;
                            $e->c_id = $request->c_id;
                            $e->save();
                        }
                    }else{                                                                                          //Add student then Enrol
                        $s->student_id = $student;
                        $s->save();
                       
                        $e->s_id = $s->s_id;
                        $e->c_id = $request->c_id;
                        $e->save();

                        $enrolOpen = new Enrolment();                                                           // Enrol in Open course (default)
                        $enrolOpen->s_id = $s->s_id;
                        $enrolOpen->c_id = 1;
                        $enrolOpen->save();
                    }  
                }
            }
        }else{
            $type ="error";
            $message ="Something went wrong, Please try again";
        }
        Storage::delete('storage/studentid/'.$filename);
        return redirect('/student/'.$request->c_id)->with($type, $message.$list.$ending);
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
