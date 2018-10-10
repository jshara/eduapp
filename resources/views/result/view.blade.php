@extends('layouts.app')

@section('content')
<style type="text/css">
.table tr:hover td{
    background-color:#b3d9ff;
}
.table1 tr:hover td{
    background-color:#e6f2ff;
}
</style>

<?php use App\Category;
      use App\Student;?>

<div class="row justify-content-center">
    <h2><b> RESULTS</b></h2>
</div>
<div class="row">
<table id="resultstable" class ="table table-bordered border-dark table-hover text-center"{{--  style="border:1px solid black" --}}>
    {{-- <thead>
        <th>

        </th>
    </thead> --}}
    <tbody>
        @if(count($courses)>0)
            @foreach($courses as $course)
                <tr>
                    <td>
                        {{$course->course_code}}
                    </td>
                    <td>
                        <table class ="table1 table-hover text-center">
                            <?php $cats = $course->categories;?>
                            @if(count($cats)>0)                            
                                @foreach($cats as $cat)
                                    <tr>
                                        <td style = "width:20em;">
                                            {{$cat->cat_name}}
                                        </td>
                                        <td>                                            
                                            @if($cat->c_id =="1")
                                                <?php $total = Student::count(); ?>
                                            @else
                                                <?php $total = DB::table('enrolments')->where('c_id',$course->c_id)->count(); ?>
                                            @endif 
                                            <li class="form-control">{{DB::table('sessions')->where('cat_id',$cat->cat_id)->count()}}/                                                   
                                            {{$total}}    
                                            </li>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <a class="btn btn-info"  href="/stats/{{$cat->cat_id}}" style="margin:0 5px 0 5px;">
                                                    Statistics
                                                </a>
                                                <a class="btn btn-info" href="/perform/{{$cat->cat_id}}">
                                                    Student Preformance
                                                </a>
                                            </div>
                                        </td>
                                        <td>
                                            <?php $completed = DB::table('categories')->where('cat_id',$cat->cat_id)->value('completed'); ?>
                                            @if($completed)
                                                <span style="color:red;"> Completed </span>
                                            @else
                                                <span style="color:green;"> In Progess</span>
                                            @endif

                                        </td>
                                    </tr>                        
                                @endforeach                            
                            @else                                
                                There are no categories                                   
                            @endif
                        </table>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</div>
{{-- @if(count($courses)>0)
    @foreach($courses as $course)
        <div class="row">
            <div class="col-md-2">
                {{$course->course_code}}
            </div>
            <div class="col-md-10">
                <php $cats = $course->categories;?>
                @if(count($cats)>0)
                    @foreach($cats as $cat)
                        <table class ="table table-striped table-border table-hover text-center">
                            <tr>
                                <td style = "width:20em;">
                                    {{$cat->cat_name}}
                                </td>
                                <td>
                                    <li class="form-control">{{DB::table('sessions')->where('cat_id',$cat->cat_id)->count()}}
                                        /{{DB::table('enrolments')->where('c_id',$course->c_id)->count()}}</li>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <a class="btn btn-info" data-id="{{$cat->c_id}}" data-name="{{$course->course_code}}" style="margin:0 5px 0 5px;">
                                            Statistics
                                        </a>
                                        <a class="btn btn-info" data-id="{{$cat->c_id}}" data-name="{{$course->course_code}}" >
                                            Student Preformance
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
@endif --}}
    {{-- <div class="row">            
        <table class ="table table-striped table-border table-hover text-center">
            <thead>
                <tr>
                    <th> Courses</th>
                    <th> Categories</th>
                    <th> Attempts</th>
                    <th> Analysis</th>                    
                </tr>
            </thead>
            <body>
            @if(count($courses) > 0)
                @foreach($courses as $course)
                <tr class="course{{$course->c_id}}">
                    <td id = "ccode{{$course->c_id}}">
                        <div class="input-group">
                            <li class="form-control" >{{$course->course_code}}</li>
                            <button class="edit-modal btn btn-info" data-id="{{$course->c_id}}" data-name="{{$course->course_code}}" style="margin:0 5px 0 5px;">
                                <span class="fa fa-pencil fa-lg"></span>
                            </button>
                            <button class="delete-modal btn btn-danger" data-id="{{$course->c_id}}" data-name="{{$course->course_code}}" >
                                <span class="fa fa-trash-o fa-lg"></span>
                            </button>
                        </div>
                    </td>                   
                    <td>
                        <li class="form-control">{{DB::table('enrolments')->where('c_id',$course->c_id)->count()}}</li>
                    </td> 
                    <td>	
                        <a href="/student/{{$course->c_id}}" class="btn btn-info">Manage Students</a>
                    </td>
                </tr>
                @endforeach
            @else {{-- this is where the open course section will go -}}
                <tr>
                    <td>Open courses</td>
                </tr>
            @endif
            </body>
        </table>
    </div> --}}
{{-- <script>
$(document).ready(function(){
    console.log("Yo i am not working");
    $('#resultstable').DataTable();   
});
</script> --}}

@endsection