@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="col nopadding">
                <a href="/courses" class="btn btn-danger">BACK</a>
        </div>
        <div class="col text-center">
            <h2>Add Students</h2>
        </div>
    </div>
    <div class="row">
        <h3>CSV FILE</h3>

    </div>

    <div class="row justify-content-end">
        <div class="form-inline">
            <div class="form-group" style="margin:5px;">
                <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">  
                <input type="hidden" id="cid" value="{{$c_id}}">
                <input type="text" name="newstudent" id="newstudent" placeholder ="New Student ID" style="width:300px;"class="form-control" for="newstudentbtn">
                <button id ="newstudentbtn" class=" newstudentbtn btn btn-success">ADD </button>
            </div>
        </div>        
    </div>
    <div class="row">   
            <table id="table" class ="table table-striped table-border table-hover text-center ">
                <body>
                @if(count($s_ids) > 0)
                {{-- <php 
                    foreach($s_ids as $s_id){
                        echo $s_id->s_id."this is sids"; 
                    }
                    
                ?> --}}
                    @foreach($s_ids as $s_id)
                    <?php $student = DB::table('students')->select('student_id')->where('s_id',$s_id->s_id)->get(); ?>
                    <tr class="student{{$s_id->s_id}}">
                        <td>  
                            <div class="input-group">                        
                                <li class="form-control">{{$student[0]->student_id}}</li>
                                <button class="delete-modal btn btn-danger" data-id="{{$s_id->s_id}}" >
                                    <span class="fa fa-trash-o fa-lg"></span>
                                </button>
                            </div>
                        </td>                               
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Add Students to Course</td>
                    </tr>
                @endif
                </body>
            </table>
        </div>

        <script>
            $(document).on('click', '.delete-modal', function() {
                $('#footer_action_button').text(" Delete");
                $('#footer_action_button').removeClass('glyphicon-check');
                $('#footer_action_button').addClass('glyphicon-trash');
                $('.actionBtn').removeClass('btn-success');
                $('.actionBtn').addClass('btn-danger');
                $('.actionBtn').addClass('delete');
                $('.actionBtn').removeClass('edit');
                $('.modal-title').text('Delete');
                $('.did').text($(this).data('id'));
                $('.deleteContent').show();
                $('.form-horizontal').hide();
                $('.dname').html($(this).data('name'));
                $('#myModal').modal('show');
            });

            $(document).on('click', '.newstudentbtn', function() {
                $.ajax({
                    type: 'post',
                    url: '/student/ajaxcreate',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'student_id': $('#newstudent').val(),
                        'c_id': $('#cid').val()
                    },
                    success: function(data) {
                        if ((data.errors)){
                            $('.error').removeClass('hidden');
                            $('.error').text(data.errors.name);
                        }
                        else {
                            $('.error').addClass('hidden');
                        }
                    },

                });
                $('#newstudent').val('');
            });
            </script>
@endsection