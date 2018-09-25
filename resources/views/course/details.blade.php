@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="form-inline">
            <div class="form-group">
                <div style="margin:5px;">
                    <button id ="newcatbtn" class=" newcatbtn btn btn-success">MANAGE </button>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row">   
        <table id="table" class ="table table-striped table-border table-hover text-center">
            <thead>
                <tr>
                    <th> Course Code</th>
                    <th> Status</th>                    
                </tr>
            </thead>
            <body>
            @if(count($courses) > 0)
                @foreach($courses as $course)
                <tr>
                    <td>
                        <li class="form-control">{{$course->course_code}}</li>
                    </td>                   
                    <td>
                        <a href="/categories" class="btn btn-info">DETAILS</a>
                    </td> 
                </tr>
                @endforeach
            @else
                <tr>
                    <td>Create you first Courses</td>
                </tr>
            @endif
            </body>
        </table>
    </div>
@endsection