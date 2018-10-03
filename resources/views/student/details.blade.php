@extends('layouts.app')

@section('content')
    <div class="row ">
        <div class="col nopadding">
                <a href="/courses" class="btn btn-danger">BACK</a>
        </div>
        <div class="col">
            <h2>Add Students</h2>
        </div>
    </div>

    <div class="row">
        <h3>CSV FILE</h3>
        {!! Form::open(['action' => 'StudentsController@fileupload','method'=>'post', 'enctype'=> 'multipart/form-data']) !!}
            <div class="row">
                {{ Form::hidden('c_id', $c_id) }}
                {{Form::label('csvfile', 'Add students by CSV',['class'=> 'form-control', 'for'=>'jo'])}}  
                {{Form::file('csvfile',['class'=> 'form-control', 'id'=>'jo'])}}
                {{Form::submit('Add',['class'=>'btn btn-primary'])}}
            </div>
        {!! Form::close() !!}
 
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
                    @foreach($s_ids as $s_id)
                    <?php $student_id = DB::table('students')->where('s_id',$s_id->s_id)->value('student_id'); ?>
                    <tr class="student{{$s_id->s_id}}">
                        <td>  
                            <div class="input-group">                        
                                <li class="form-control">{{$student_id}}</li>
                                <button class="delete-modal btn btn-danger" data-id="{{$s_id->s_id}}" data-cid="{{$c_id}}" data-name="{{$student_id}}" >
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
        @include('layouts.modal')
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
                $('.cid').text($(this).data('cid'));
                $('.deleteContent').show();
                $('.form-horizontal').hide();
                $('.dname').html($(this).data('name'));
                $('#myModal').modal('show');
            });
            $(document).on('click', '.delete', function() {
                $.ajax({
                    type: 'post',
                    url: '/student/ajaxdelete',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'sid': $('.did').text(),
                        'cid': $('.cid').text()
                    },
                    success: function(data) {
                        $('.student' + $('.did').text()).remove();
                    }
                });
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
                            $('#table').append("<tr class='student"+ data.student.s_id +"'><td><div class='input-group'><li class='form-control'>"+ data.student.student_id +
                            "</li><button class='delete-modal btn btn-danger' data-id='"+  data.student.s_id +"'  data-cid='"+ data.enrolment.c_id +"' data-name='"+ data.student.student_id +"'><span class='fa fa-trash-o fa-lg'></span></button></div></td></tr>");
                        }
                    },

                });
                $('#newstudent').val('');
            });
            </script>
@endsection