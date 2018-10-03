@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="form-inline">
            <div class="form-group">
                <div style="margin:5px;">
                    <input type="text" name="newcat" id="newcat" placeholder ="New Category Name" style="width:300px;"class="form-control" for="newcatbtn">
                    <button id ="newcatbtn" class=" newcatbtn btn btn-success">CREATE </button>
                </div>
            </div>
        </div>
        
    </div>
    <div class="row"> 
        <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">    
        <table id="table" class ="table table-striped table-border table-hover text-center">
            <thead>
                <tr>
                    <th> Category Name</th>
                    <th> Level</th>
                    <th> Course</th>
                    <th> Status</th>                    
                </tr>
            </thead>
            <body>
            @if(count($category) > 0)
                @foreach($category as $c)
                <tr class="cat{{$c->cat_id}}">                 
                    @if($c->published == '0')
                        <td id ="column{{$c->cat_id}}">
                            <div class="input-group">
                                <li class="form-control">{{$c->cat_name}}</li>
                                <button class="edit-modal btn btn-info" style="margin:0 5px 0 5px;" data-id="{{$c->cat_id}}" data-name="{{$c->cat_name}}">
                                    <span class="fa fa-pencil fa-lg"></span>
                                </button>
                                <button class="delete-modal btn btn-danger" data-id="{{$c->cat_id}}" data-name="{{$c->cat_name}}">
                                    <span class="fa fa-trash-o fa-lg"></span>
                                </button>
                            </div>
                        </td>   
                        <td>	
                            <a href="/levels/{{$c->cat_id}}" class="btn btn-info">DETAILS</a>
                            <a href="/maps/{{$c->cat_id}}" class="btn btn-info">MAP</a>
                        </td>  
                        <td>
                            <?php $courses = DB::table('courses')->where('user_id',$c->user_id)->orWhere('user_id', NULL)->get();?>
                            <select class="form-control text-center" id="course" data-id="{{$c->cat_id}}" style="width:150px;">                                
                                @foreach($courses as $course)                                
                                    @if($course->c_id == $c->c_id)
                                        <option value="{{$course->c_id}}" selected="selected">{{$course->course_code}}</option>
                                    @else
                                        <option value="{{$course->c_id}}">{{$course->course_code}}</option>
                                    @endif                             
                                @endforeach
                            </select>    
                        </td>               
                        <td>
                            <a href="/categories/publish/{{$c->cat_id}}" class="btn btn-default">
                                <span style="color:green;"> PUBLISH </span>
                            </a>
                        </td>
                    @else
                        <td>
                            <div class="input-group">
                                <li class="form-control">{{$c->cat_name}}</li>
                                <button class="btn btn-info disabled" data-toggle="tooltip" title="Unpublish to Edit" style="margin:0 5px 0 5px;">
                                    <span class="fa fa-pencil fa-lg"></span>
                                </button>
                                <button class="btn btn-danger disabled" data-toggle="tooltip" title="Unpublish to Delete">
                                    <span class="fa fa-trash-o fa-lg"></span>
                                </button>
                            </div>
                        </td>   
                        <td>	
                            <a href="/levels/{{$c->cat_id}}" class="btn btn-info">DETAILS</a>
                            <a href="/maps/{{$c->cat_id}}" class="btn btn-info">MAP</a>
                        </td>
                        <td>
                            <?php $courses = DB::table('courses')->where('user_id',$c->user_id)->orWhere('user_id', NULL)->get();?>
                            <select class="form-control text-center" data-toggle="tooltip" title="Unpublish to Select" style="width:150px;" disabled>                                
                                @foreach($courses as $course)                                
                                    @if($course->c_id == $c->c_id)
                                        <option value="{{$course->c_id}}" selected="selected">{{$course->course_code}}</option>
                                    @else
                                        <option value="{{$course->c_id}}">{{$course->course_code}}</option>
                                    @endif                             
                                @endforeach
                            </select>    
                        </td>                  
                        <td>
                            <a href="/categories/publish/{{$c->cat_id}}" class="btn btn-default">
                                <span style="color:red;"> UNPUBLISH </span>
                            </a>
                        </td>
                    @endif
                </tr>
                @endforeach
            @else
                <tr>
                    <td>Create your first category</td>
                </tr>
            @endif
            </body>
        </table>
    </div>

    @include('layouts.modal')
		
		<script>
            $(document).on("change", "#course", function () {
                var select = $(this).val();
                console.log( "selected course with ID: " +select);
                $.ajax({
                    url:"/category/course",
                    type: 'post',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        id: $(this).data('id'), 
                        course: select
                    },
                    success: function(data) {
                        //alert(data);
                    },
                    error: function(data) {
                        // alert(data);
                        // Revert
                    }
                });
            });
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });

            $(document).on('click', '.edit-modal', function() {
                $('#footer_action_button').text(" Update");
                $('#footer_action_button').addClass('glyphicon-check');
                $('#footer_action_button').removeClass('glyphicon-trash');
                $('.actionBtn').addClass('btn-success');
                $('.actionBtn').removeClass('btn-danger');
                $('.actionBtn').addClass('edit');
                $('.actionBtn').removeClass('delete');
                $('.modal-title').text('Edit');
                $('.deleteContent').hide();
                $('.form-horizontal').show();
                $('#fid').val($(this).data('id'));
                $('#n').val($(this).data('name'));
                $('#myModal').modal('show');
                //console.log($("#fid").val());
                //console.log($("#n").val());
            });
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

            $(document).on('click', '.edit', function() {
                $.ajax({
                    type: 'post',
                    url: '/categories/ajax',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $("#fid").val(),
                        'name': $('#n').val()
                    },
                    success: function(data) { 
                        $('#column' + data.cat_id).replaceWith("<td id ='column"+ data.cat_id + "'><div class='input-group'><li class='form-control'>"+ data.cat_name + "</li><button class='edit-modal btn btn-info' style='margin:0 5px 0 5px;' data-id='"+ data.cat_id + "' data-name='"+ data.cat_name + "'><span class='fa fa-pencil fa-lg'></span></button><button class='delete-modal btn btn-danger' data-id='"+ data.cat_id + "' data-name='"+ data.cat_name + "'><span class='fa fa-trash-o fa-lg'></span></button></div></td>");
                        // swal("Awesome!", "Successfully updated!", "success");
                    }   
                });
            });
            $(document).on('click', '.newcatbtn', function() {
                $.ajax({
                    type: 'post',
                    url: 'categories/ajaxcreate',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'name': $('#newcat').val()
                    },
                    success: function(data) {
                        if ((data.errors)){
                            $('.error').removeClass('hidden');
                            $('.error').text(data.errors.name);
                        }
                        else {
                            $('.error').addClass('hidden');
                            $('#newcat').val("");
                            $('#table').append("<tr class='cat" + data.cat_id + "'><td id ='column"+ data.cat_id + "'><div class='input-group'><li class='form-control'>" + data.cat_name + 
                            "</li><span class='input-group-addon'><button class='edit-modal btn btn-info' style='margin:0 5px 0 5px;' data-id='" + data.cat_id + 
                            "' data-name='" + data.cat_name + "'><span class='fa fa-pencil fa-lg'></span></button></span><span class='input-group-addon'><button class='delete-modal btn btn-danger' data-id='" + data.cat_id + 
                            "' data-name='" + data.cat_name + "'><span class='fa fa-trash fa-lg'></span></button></span></div></td><td><a href='/levels/" + data.cat_id +
                            "' class='btn btn-info'>DETAILS</a> <a href='/maps/" + data.cat_id + 
                            "' class='btn btn-info'>MAP</a> </td><td><?php $courses = DB::table('courses')->where('user_id',$c->user_id)->orWhere('user_id', NULL)->get();?><select class='form-control text-center' id='course' data-id='"+ data.cat_id +
                            "'style='width:150px;'> @foreach($courses as $course)@if($course->c_id ==" + data.c_id +")<option value='{{$course->c_id}}' selected='selected'>{{$course->course_code}}</option> @else<option value='{{$course->c_id}}'>{{$course->course_code}}</option> @endif @endforeach </select></td><td><a href='/categories/publish/" + data.cat_id + 
                            "' class='btn btn-default'><span style='color:green;'> PUBLISH </span></a></td></tr>");
                        }
                    },

                });
                $('#name').val('');
            });
            $(document).on('click', '.delete', function() {
                $.ajax({
                    type: 'post',
                    url: '/categories/ajaxdelete',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $('.did').text()
                    },
                    success: function(data) {
                        $('.cat' + $('.did').text()).remove();
                    }
                });
            });

            $(document).on('click','.publish', function() {
                console.log('I am here');
            });
         </script>


@endsection