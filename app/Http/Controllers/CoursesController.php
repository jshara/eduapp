<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Course;
use App\User;
use DB;

class CoursesController extends Controller
{
    /**
     * Display all the courses belonging to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        return view('course.details')->with('courses',$user->courses);
    }

    /**
     * Create a new course and send back the information in json format 
     * to be displayed on the page without reload
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function ajaxcreate(Request $request){
        $course = new Course();
        $course->course_code = $request->course_code;
        $userid = auth()->user()->id;
        $course->user_id = $userid;
        $course->save();
                
        return response()->json($course);
    }

    /**
     * Deleting the Course: this is to delete the selected course
     * and return a response to indicate success
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function ajaxdelete(Request $request){
        $course = Course::find($request->id);
        $course->delete();
                
        return response()->json($course);
    }

     /**
     * Editing the Course name: this is to save the new name 
     * and return the instance without page reload
     *
     * @param  \Illuminate\Http\Request  $req
     * @return \Illuminate\Http\Response
     */
    public function ajaxedit(Request $request){
        $course = Course::find($request->id);
        $course->course_code = $request->course_code;
        $course->save();
                
        return response()->json($course);
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
