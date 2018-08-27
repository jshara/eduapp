@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <a href="/categories/create" class="btn btn-success">CREATE NEW</a>
    </div>
    <div class="row">     
            <table class ="table table-striped table-border table-hover text-center">
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
                                    {{-- <a href="/categories/{{$c->cat_id}}/edit" class="btn"><i class="fa fa-pencil fa-lg"></i></a> --}}
                                    <button class="btn" data-toggle="modal" data-target="#myModal" data-id="{{$c->cat_id}}" data-name="{{$c->cat_name}}"><i class="fa fa-pencil fa-lg"></i></button>
                                </span>
                                {!!Form::open(['action'=>['CategorysController@destroy', $c->cat_id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                    {{Form::hidden('_method','DELETE')}}
                                    {{-- {{Form::submit('Delete',['class'=> 'fa fa-trash-o fa-lg'])}} --}}
                                    {!! Form::button( '<i class="fa fa-trash-o fa-lg" style="color:#FF0000;"></i>', ['type' => 'submit'] ) !!}
                                {!!Form::close()!!}
                            </div>
                        </td>
                        <td>	
                            <a href="/levels/{{$c->cat_id}}" class="btn btn-info">DETAILS</a>
                            <a href="#" class="btn btn-info">MAP</a>
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
        <div id="myModal" class="modal fade" tabindex ="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                {{-- Modal Content --}}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="id">ID:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="fid" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="name">Name: </label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="n">
                                </div>
                            </div>
                        </form>
                        <div class="deleteContent">
                            Are you sure you want to delete <span class="dname"></span> ? <span
                            class="hidden did"></span>                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn actionBtn" data-dismiss="modal">
                                <span id="footer_action_button" class="glyphicon"> </span>
                            </button>
                            <button type="button"  class="btn btn-danger" data-dismiss="modal">
                                <span class="glyphicon glyphicon-remove"></span>Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <script>
            $('#myModal').on('show.bs.modal', function(event){
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var name =  button.data('name')

                var model = $(this)
                modal.find('.modal-title').text('New message to ' + id)

                console.log(event.relatedTarget)

                $('#footer_action_button').text("update");
                $('#footer_action_button').addClass("glyphicon-check");
                $('#footer_action_button').removeClass("glyphicon-trash");
                $('.actionBtn').addClass('btn-success');
                $('.actionBtn').removeClass('btn-danger');
                $('.actionBtn').addClass('edit');
                $('.modal-title').text('Edit');
                $('.deleteContent').hide();
                $('.form-horizontal').show();
                // $('#fid').val($(this).data('id'));
                model.find('#fid').val(id);
                // $('#n').val($(this).data('name'));
                model.find("#n").val(name);
                $('#mymodal').modal('show');
            })
            
            $(.modal-footer).on('click','.edit',function(){
                $.ajax({
                    type: 'post',
                    url: '/category',
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': $("#fid").val(),
                        'name': $('#n').val()
                    },
                    success: function(data){
                        $('.item' + data.id).replaceWith("<tr class='cat"+data.id+"'><td><div class='input-group'><li class='form-control'>"+data.name+"</li> <span class='input-group-addon'> <button class='edit-modal btn' data-id='"+data.id+"' data-name='"+data.id+"'><i class='fa fa-pencil fa-lg'></i></button></span></div></td><td><a href='/levels/"+data.id+"' class='btn btn-info'>DETAILS</a></td></tr>")
                    }
                });
            });
            </script>
        
@endsection