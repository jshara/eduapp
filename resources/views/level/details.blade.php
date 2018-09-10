@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="col nopadding">
                <a href="/categories" class="btn btn-danger">BACK</a>
        </div>
        <div class="col text-right nopadding">
                <a href="/levels/create/{{$cat_id}}" class="btn btn-success">ADD LEVEL</a>
        </div>
    </div>
    <div class="row">     
            <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">    
            <table id="table" class ="table table-striped table-border table-hover text-center">
                <thead>
                    <tr>                        
                        <th><?php echo DB::table('categories')->where('cat_id',$cat_id)->value('cat_name'); ?></th>
                        <th> Questions </th>
                    </tr>
                </thead>
                <body>
                @if(count($levels) > 0)
                    @foreach($levels as $level)
                <tr class="lev{{$level->lev_id}} text-center">
                        <td>  
                            {{-- <div class="input-group">                        
                                <li class="form-control">Level #{{$level->lev_num}}</li>
                                <span class="input-group-addon">                                       
                                    <button class="edit-modal btn btn-info" style="margin:0 5px 0 5px;" data-id="{{$level->lev_id}}" data-name="{{$level->lev_num}}">
                                        <span >MAP</span>
                                    </button>
                                </span>
                                <span class="input-group-addon">                                       
                                    <button class="delete-modal btn btn-danger" data-id="{{$level->lev_id}}" data-name="{{$level->lev_num}}">
                                        <span class="fa fa-trash-o fa-lg"></span>
                                    </button>
                                </span>
                            </div> --}}
                            <div class="input-group">  
                                <span class="input-group-addon">Level #{{$level->lev_num}}  {{$level->lev_location}}</span>
                                <span class="input-group-addon"><a href="/mapslevel/{{$level->lev_id}}" class="btn"><i class="fa fa-pencil fa-lg"></i></a></span>
                                {!!Form::open(['action'=>['LevelsController@destroy', $level->lev_id,$level->lev_num, $cat_id], 'method'=>'POST', 'class'=>'pull-right'])!!}
                                    {{Form::hidden('_method','DELETE')}}
                                    {!! Form::button( '<i class="fa fa-trash-o fa-lg" style="color:#FF0000;"></i>', ['type' => 'submit'] ) !!}
                                {!!Form::close()!!}
                            </div>
                        </td>
                        <td>                           
                            <a href="/questions/{{$level->lev_id}}" class="btn btn-info">Question[s]</a>
                        </td>                                
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Add your first level</td>
                    </tr>
                @endif
                </body>
            </table>
        </div>

{{-- @include('layouts.modal')
    
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
            // $('.lnum').text($(this).data('level'));
            // $('.cid').text($(this).data('cid'));            
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
                    $('.cat' + data.cat_id).replaceWith("<tr class='cat" + data.cat_id + "'><td><div class='input-group'><li class='form-control'>" + data.cat_name + "</li><span class='input-group-addon'><button class='edit-modal btn btn-info' style='margin:0 5px 0 5px;' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-pencil fa-lg'></span></button></span><span class='input-group-addon'><button class='delete-modal btn btn-danger' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-trash fa-lg'></span></button></span></div></td><td><a href='/levels/" + data.cat_id +"' class='btn btn-info'>DETAILS</a> <a href='/maps/" + data.cat_id + "' class='btn btn-info'>MAP</a> </td></tr>");
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
                        $('#table').append("<tr class='cat" + data.cat_id + "'><td><div class='input-group'><li class='form-control'>" + data.cat_name + "</li><span class='input-group-addon'><button class='edit-modal btn btn-info' style='margin:0 5px 0 5px;' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-pencil fa-lg'></span></button></span><span class='input-group-addon'><button class='delete-modal btn btn-danger' data-id='" + data.cat_id + "' data-name='" + data.cat_name + "'><span class='fa fa-trash fa-lg'></span></button></span></div></td><td><a href='/levels/" + data.cat_id +"' class='btn btn-info'>DETAILS</a> <a href='/maps/" + data.cat_id + "' class='btn btn-info'>MAP</a> </td></tr>");
                    }
                },

            });
            $('#name').val('');
        });
        $(document).on('click', '.delete', function() {
            $.ajax({
                type: 'post',
                url: '/levels/adelete',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id':  $('.did').text()
                    // 'lnum': $('.lnum').text(),
                    // 'cid':$('.cid').text()
                },
                success: function(data) {
                    $('.lev' + $('.did').text()).remove();
                }
            });
        });
    </script> --}}
@endsection