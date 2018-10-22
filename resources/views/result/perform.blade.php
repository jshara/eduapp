@extends('layouts.app')

@section('content')
<?php
    use App\Student;
use App\Level;
use App\Session;
?>
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
                @for($i = 0; $i < $numLevel; $i++)
                    <th style="width:10em;"> Level {{$i + 1}}</th>
                @endfor
                <th> Total</th>
            </tr>
        </thead>
        <tbody>
        @if(count($student_ids) > 0)
            @foreach($student_ids as $student_id)
            <tr>                 
                <td>
                    <li class="form-control">{{$student_id}}</li>
                </td> 
                <?php                 
                $s_id = Student::where('student_id',$student_id)->value('s_id');
                $check = Session::where('s_id',$s_id)->where('cat_id',$id)->exists();
                $total =0;?>
                @if($check)
                   <?php $scores = Session::where('s_id',$s_id)->value('scoreString'); 
                    $score= explode(',',$scores);?>
                    @foreach($score as $levelscore)
                        <td>{{$levelscore}}</td>
                        <?php $total += $levelscore; ?>
                    @endforeach
                    @for($i =0; $i < $numLevel-count($score); $i++)
                        <td> 0 </td>
                    @endfor                   
                @else
                    @for($i = 0; $i < $numLevel; $i++)                    
                        <td> 0 </td>
                    @endfor 
                @endif              
                <td>
                    {{$total}}
                </td>
            </tr>
            @endforeach
        @else
            <tr>
                <td>There are no students Enrolled in the Associated Course</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function(){
        // $('#table').DataTable(); 
        $('.table').DataTable().columns(-1).order('desc').draw();  
        // $('#table').DataTable({
        //     "order": [[ 5, "desc" ]] // Order on init. # is the column, starting at 0
        // });
    });
    

</script>

@endsection