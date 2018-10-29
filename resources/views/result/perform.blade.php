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
        <h2><b> <?php echo DB::table('categories')->where('cat_id',$cat_id)->value('cat_name'); ?></b></h2>
    </div>
</div><br>

<div class="row">
    <table id="table" class ="table table-striped table-hover text-center" {{-- style="height:50%; overflow-y: scroll;" --}}>
        <thead>
            <tr>
                <th>Position</th>
                <th> Student</th>
                @for($i = 0; $i < $numLevel; $i++)
                    <th style="width:10em;"> Level {{$i + 1}}</th>
                @endfor
                <th> Total</th>
            </tr>
        </thead>
        <tbody>
        @if(count($student_ids) > 0)
        <?php $jo =1; ?>
            @foreach($student_ids as $student_id)
            <tr>   
                <?php                 
                $s_id = Student::where('student_id',$student_id)->value('s_id');
                $check = Session::where('s_id',$s_id)->where('cat_id',$cat_id)->exists();
                $total =0; ?>    
                <td id="pos{{$jo}}"> </td> 
                <td>
                    <a href="/resultsstudents/{{$student_id}}/{{$cat_id}}">{{$student_id}}</a>
                </td> 
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
                <td id="try{{$jo}}">
                    {{$total}}  
                </td><?php $jo++; ?> 
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

        var joseph = $('table').DataTable().rows().count();

        for(i=0; i<joseph; i++){
        $('.table').find("tr:eq("+ (i+1) +")").find("td:eq(0)").html(i+1);
        }
        // $('#table').DataTable({
        //     "order": [[ 5, "desc" ]] // Order on init. # is the column, starting at 0
        // });
    });
    

</script>

@endsection