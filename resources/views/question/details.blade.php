@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="col nopadding">
            <?php $cid = DB::table('levels')->where('lev_id', $lev_id)->value('cat_id'); ?>
            <a href="/levels/{{$cid}}" class="btn btn-danger">BACK</a>
        </div>
        <div class="col text-center">
            
            <a class="btn btn-lg"><h2> Level <?php echo DB::table('levels')->where('lev_id', $lev_id)->value('lev_num'); ?></h2></a>
    </div>
        <div class="col text-right nopadding">
            {{-- <a href="/levels/create/{{$lev_id}}" class="btn btn-success">ADD LEVEL</a> --}}
            <button name="add" id="add" class="btn btn-success">ADD QUESTION</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-lg">Question 1 </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <textarea class="form-control" id="question" name="question" placeholder="Enter Question"></textarea><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <textarea style="border-color:green; background-color:lightgreen; width:100%;"  
            type="text" name="ans_1" id="ans_1" placeholder="Enter Correct Answer" class="form-control" required></textarea><br>
        </div>
        <div class="col-md-6">
                <textarea style="border-color:red; background-color:lightpink; width:100%;"  
                type="text" name="ans_2" id="ans_2" placeholder="Other Answers" class="form-control" required></textarea><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
                <textarea style="border-color:red; background-color:lightpink; width:100%;"  
                type="text" name="ans_3" id="ans_3" placeholder="Other Answers" class="form-control"></textarea><br>
        </div>
        <div class="col-md-6">
                <textarea style="border-color:red; background-color:lightpink; width:100%;"  
                type="text" name="ans_4" id="ans_4" placeholder="Other Answers" class="form-control"></textarea><br>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <input type="button" name="submit" id="submit" value="SUBMIT">
        </div>
    </div>

    {{-- <script>
    $(document).ready(function(){
        
        var i=1;
        $('#add').click(function(e){
            e.preventDefault();
            i++;
            $('#dynamic_field').append('<tr id="row'+i+'"><td><p>'+i+'</p><td><input type="text" name="name[]" id="name" placeholder="Enter name" class="form-control name_list"></td><td><button name="add" id="'+i+'" class="btn btn-danger btn-remove">X</button> </td></tr>')
        });
        
        $(document).on('click','.btn_remove',function(e){
            e.preventDefault();
            var button_id = $(this).attr("id");
            $("#row"+button_id+' ').remove();
        });
        $('#submit').click(function(){
            $.ajax({
                url:"/questions",
                method:"POST",
                data:$('add_name').serialize(),
                success:function(data)
                {
                    alert(data);
                    $('#add_name')[0].reset();
                }
            });
        });
    });
    </script> --}}
@endsection