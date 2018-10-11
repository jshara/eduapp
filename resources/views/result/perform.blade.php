@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-2  nopadding">
            <a href="/results" class="btn btn-danger">BACK</a>
    </div>
    <div class="col-md-6 offset-md-2">
        <h2><b> <?php echo DB::table('categories')->where('cat_id',$id)->value('cat_name'); ?></b></h2>
    </div>
</div><br>

<div class="row">
    <table id="table" class ="table table-striped table-hover text-center" {{-- style="height:50%; overflow-y: scroll;" --}}>
        <thead>
            <tr>
                <th> Student</th>
                <th> Level</th>
                <th> Course</th>
                <th> Status</th>
            </tr>
        </thead>
        <body>
        @if(count($student_ids) > 0)
            @foreach($student_ids as $student_id)
            <tr>                 
                <td>
                    <li class="form-control">{{$student_id->student_id}}</li>
                </td>   
                <td>	
                    2nd
                </td>  
                <td>
                    3rd
                </td>               
                <td>
                    4th
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td>There are no students Enrolled in the Associated Course</td>
            </tr>
        @endif
        </body>
    </table>
</div>


@endsection