@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <a href="/categories/create" class="btn btn-success">CREATE NEW</a>
    </div>
    <div class="row"> 
            <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">    
        <table id="table" class ="table table-striped table-border table-hover text-center">
            <thead>
                <tr>
                    <th> Category Name</th>
                    <th> </th>
                </tr>
            </thead>
            <body>
            @if(count($category) > 0)
                @foreach($category as $c)
                <tr class="cat{{$c->cat_id}}">
                    
                    <td>
                        <div class="input-group">
                            <li class="form-control">{{$c->cat_name}}</li>
                            <span class="input-group-addon">                                       
                                {{-- <button type="button" class="btn" data-toggle="modal" onclick="edit({{$c}})"  data-target="#editModal"><i class="fa fa-pencil fa-lg"></i></button>                                        --}}
                                <button class="edit-modal btn btn-info" data-id="{{$c->cat_id}}" data-name="{{$c->cat_name}}">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </span>

                            {!!Form::open(['action'=>['CategorysController@destroy', $c->cat_id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                {{Form::hidden('_method','DELETE')}}
                                {{-- {{Form::submit('Delete',['class'=> 'fa fa-trash-o fa-lg'])}} --}}
                                {!! Form::button( '<i class="btn fa fa-trash-o fa-lg" style="color:#FF0000;"></i>', ['type' => 'submit'] ) !!}
                            {!!Form::close()!!}
                        </div>
                    </td>
                    <td>	
                        <a href="/levels/{{$c->cat_id}}" class="btn btn-info">DETAILS</a>
                        <a href="/maps/{{$c->cat_id}}" class="btn btn-info">MAP</a>
                    </td>
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

    <div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="control-label col-sm-2" for="id">ID:</label>
							<div class="col-sm-10">
								<input class="form-control" id="fid" disabled="" type="text">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="name">Name:</label>
							<div class="col-sm-10">
								<input class="form-control" id="n" type="name">
							</div>
						</div>
					</form>
					<div class="deleteContent">
						Are you Sure you want to delete <span class="dname"></span> ? <span class="hidden did"></span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn actionBtn" data-dismiss="modal">
							<span id="footer_action_button" class="glyphicon"> </span>
						</button>
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class="glyphicon glyphicon-remove"></span> Close
						</button>
					</div>
				</div>
			</div>
		</div>
		
		<script>
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

                console.log($("#fid").val());
                console.log($("#n").val());
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

            // $('.modal-footer').on('click', '.edit1', function() {
            //     console.log('I am in update button');
            //     $.ajax({
            //         type: 'post',
            //         url: '/ajax-crud-operations-laravel/editItem',
            //         data: {
            //             '_token': $('input[name=_token]').val(),
            //             'id': $("#fid").val(),
            //             'name': $('#n').val()
            //         },
            //         // success: function(data) {
            //         //      $('.cat' + data.id).replaceWith("<tr class='cat" + data.id + "'><td><div class='input-group'><li class='form-control'>" + data.name + "</li><span class='input-group-addon'><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button></span></div></td><td><a href='/levels/" + data.id +"' class='btn btn-info'>DETAILS</a><a href='/maps/" + data.id + "' class='btn btn-info'>MAP</a> </td></tr>");
            //         // }
            //         success: function(data) { alert("succsess") },
            //         error: function(ts) { alert(ts.responseText) }
            //     });
            // });
            $('.modal-footer').on('click', '.edit1', function() {
                 console.log("I am in update button");
                $.ajax({
                    type: 'post',
                    url: '/ajax-crud-operations-laravel/editItem',
                    data: {
                        // '_token': $('input[name=_token]').val(),
                        // 'id': $("#fid").val(),
                        // 'name': $('#n').val()
                    }
                });
            });
            $('.modal-footer').on('click', '.edit', function() {
                console.log('I am in update button');
                $.ajax({
                    type: 'post',
                    url: '/ajax-crud-operations-laravel/editItem',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $("#fid").val(),
                        'name': $('#n').val()
                    },
                    success: function(data) {
                        $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                    }
                });
            });
            $("#add").click(function() {

                $.ajax({
                    type: 'post',
                    url: '/ajax-crud-operations-laravel/addItem',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'name': $('input[name=name]').val()
                    },
                    success: function(data) {
                        if ((data.errors)){
                            $('.error').removeClass('hidden');
                            $('.error').text(data.errors.name);
                            console.log("asd");
                        }
                        else {
                            $('.error').addClass('hidden');
                            $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                        }
                    },

                });
                $('#name').val('');
            });
            $('.modal-footer').on('click', '.delete', function() {
                $.ajax({
                    type: 'post',
                    url: '/ajax-crud-operations-laravel/deleteItem',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $('.did').text()
                    },
                    success: function(data) {
                        $('.item' + $('.did').text()).remove();
                    }
                });
            });
         </script>

</div>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                    <div class="form-group">
                        <label for="cat_id" class="col-form-label">Category ID:</label>
                        <input type="text" class="form-control" id="cat_id" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cat_name" class="col-form-label">Category Name:</label>
                        <input type="text" class="form-control" id="cat_name">
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="update()" class="btn btn-primary">Update Name</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
            // $('#editModal').on('show.bs.modal', function (event) {
            //     console.log("name=");
            //     var button = $(event.relatedTarget) // Button that triggered the modal
            //     var id = button.data('id') // Extract info from data-* attributes
            //     var name = button.data('name')
            //     console.log("name=");

            //     var modal = $(this)
            //     modal.find('#cat_id').text('Edit ' + id);
            //     modal.find('.modal-body input').val(name);
            // })

            // function edit(category){
            //     console.log(category);
            //     console.log("id=" + category['cat_id']);
            //     console.log("name=" + category['cat_name']);

            //     $('#cat_id').val(category['cat_id']);
            //     $('#cat_name').val(category['cat_name']);
            // }

            // function update(){
            //     console.log("this is printing");
            //     $.ajax({
            //         type:'post',
            //         url: '/categories/' + $('#cat_id').val(),
            //         data:{
            //             // '_token': $('input[name=token]').val(),
            //             "_token": "{{ csrf_token() }}",
            //             'id':$('#cat_id').val(),
            //             'name':$('#cat_name').val()                      
            //         },
                    
            //         success: function(){
            //             console.log("We have updated the cat name");
            //         }
            //     });
            // }

            </script>
@endsection