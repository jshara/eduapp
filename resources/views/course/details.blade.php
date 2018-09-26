@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="form-inline">
            <div class="form-group" style="margin:5px;">
                    <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden"> 
                    <input type="text" name="newcourse" id="newcourse" placeholder ="New Course Name" style="width:300px;"class="form-control" for="newcoursebtn">
                    <button id ="newcoursebtn" class=" newcoursebtn btn btn-success">CREATE </button>
            </div>
        </div>        
    </div>
    <div class="row"> 
           
        <table id="table" class ="table table-striped table-border table-hover text-center">
            <thead>
                <tr>
                    <th> Course Name</th>
                    <th> Number of Students</th>
                    <th> </th>
                    
                </tr>
            </thead>
            <body>
            @if(count($courses) > 0)
                @foreach($courses as $course)
                <tr class="cat{{$course->c_id}}">
                    <td>
                        <div class="input-group">
                            <li class="form-control">{{$course->course_code}}</li>
                            <button class="edit-modal btn btn-info" style="margin:0 5px 0 5px;">
                                <span class="fa fa-pencil fa-lg"></span>
                            </button>
                            <button class="delete-modal btn btn-danger" data-id="" >
                                <span class="fa fa-trash-o fa-lg"></span>
                            </button>
                        </div>
                    </td>                   
                    <td>
                        <?php 
                            $students = DB::table('enrolments')->where('c_id',$course->c_id)->count();
                        ?>
                        <li class="form-control">{{$students}}</li>
                    </td> 
                    <td>	
                        <a href="/student/{{$course->c_id}}" class="btn btn-info">Manage Students</a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td>Enter Your First Course</td>
                </tr>
            @endif
            </body>
        </table>
    </div>

    {{-- @include('layouts.modal') --}}
		
		<script>
            // $(document).on('click', '.edit-modal', function() {
            //     $('#footer_action_button').text(" Update");
            //     $('#footer_action_button').addClass('glyphicon-check');
            //     $('#footer_action_button').removeClass('glyphicon-trash');
            //     $('.actionBtn').addClass('btn-success');
            //     $('.actionBtn').removeClass('btn-danger');
            //     $('.actionBtn').addClass('edit');
            //     $('.actionBtn').removeClass('delete');
            //     $('.modal-title').text('Edit');
            //     $('.deleteContent').hide();
            //     $('.form-horizontal').show();
            //     $('#fid').val($(this).data('id'));
            //     $('#n').val($(this).data('name'));
            //     $('#myModal').modal('show');
            //     //console.log($("#fid").val());
            //     //console.log($("#n").val());
            // });
            // $(document).on('click', '.delete-modal', function() {
            //     $('#footer_action_button').text(" Delete");
            //     $('#footer_action_button').removeClass('glyphicon-check');
            //     $('#footer_action_button').addClass('glyphicon-trash');
            //     $('.actionBtn').removeClass('btn-success');
            //     $('.actionBtn').addClass('btn-danger');
            //     $('.actionBtn').addClass('delete');
            //     $('.actionBtn').removeClass('edit');
            //     $('.modal-title').text('Delete');
            //     $('.did').text($(this).data('id'));
            //     $('.deleteContent').show();
            //     $('.form-horizontal').hide();
            //     $('.dname').html($(this).data('name'));
            //     $('#myModal').modal('show');
            // });

            // $(document).on('click', '.edit', function() {
            //     $.ajax({
            //         type: 'post',
            //         url: '/categories/ajax',
            //         data: {
            //             '_token': $('input[name=_token]').val(),
            //             'id': $("#fid").val(),
            //             'name': $('#n').val()
            //         },
            //         success: function(data) {                       
            //             $('.cat' + data.cat_id).replaceWith("<tr class='cat" + data.cat_id + "'><td><div class='input-group'><li class='form-control'>" + data.cat_name + "</li><span class='input-group-addon'><button class='edit-modal btn btn-info' style='margin:0 5px 0 5px;' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-pencil fa-lg'></span></button></span><span class='input-group-addon'><button class='delete-modal btn btn-danger' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-trash fa-lg'></span></button></span></div></td><td><a href='/levels/" + data.cat_id +"' class='btn btn-info'>DETAILS</a> <a href='/maps/" + data.cat_id + "' class='btn btn-info'>MAP</a> </td></tr>");
            //         }
            //     });
            // });
            $(document).on('click', '.newcoursebtn', function() {
                $.ajax({
                    type: 'post',
                    url: '/course/ajaxcreate',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'course_code': $('#newcourse').val()
                    },
                    success: function(data) {
                        if ((data.errors)){
                            $('.error').removeClass('hidden');
                            $('.error').text(data.errors.name);
                        }
                        else {
                            $('.error').addClass('hidden');
                            $('#newcourse').val("");
                            //$('#table').append("<tr class='cat" + data.cat_id + "'><td><div class='input-group'><li class='form-control'>" + data.cat_name + "</li><span class='input-group-addon'><button class='edit-modal btn btn-info' style='margin:0 5px 0 5px;' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-pencil fa-lg'></span></button></span><span class='input-group-addon'><button class='delete-modal btn btn-danger' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-trash fa-lg'></span></button></span></div></td><td><a href='/levels/" + data.cat_id +"' class='btn btn-info'>DETAILS</a> <a href='/maps/" + data.cat_id + "' class='btn btn-info'>MAP</a> </td><td><a href='/categories/publish/" + data.cat_id + "' class='btn btn-default'><span style='color:green;'> PUBLISH </span></a></td></tr>");
                        }
                    },

                });
                // $('#name').val('');
            });
            // $(document).on('click', '.delete', function() {
            //     $.ajax({
            //         type: 'post',
            //         url: '/categories/ajaxdelete',
            //         data: {
            //             '_token': $('input[name=_token]').val(),
            //             'id': $('.did').text()
            //         },
            //         success: function(data) {
            //             $('.cat' + $('.did').text()).remove();
            //         }
            //     });
            // });

            // $(document).on('click','.publish', function() {
            //     console.log('I am here');
            // });
         </script>


@endsection