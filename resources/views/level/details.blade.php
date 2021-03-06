@extends('layouts.app')

@section('content')
    <div class="row justify-content-end">
        <div class="col nopadding">
                <a href="/categories" class="btn btn-danger">BACK</a>
        </div>
        <div class="col text-center">
            <h2> <?php echo DB::table('categories')->where('cat_id',$cat_id)->value('cat_name'); ?></h2>
        </div>
        <div class="col text-right nopadding">
                <a href="/levels/create/{{$cat_id}}" class="btn btn-success">ADD LEVEL</a>
        </div>
    </div>
    <div class="row">     
            {{-- <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">     --}}
            <table id="table" class ="table table-striped table-border table-hover text-center">
                <thead>
                    <tr>                        
                        <th></th>
                        <th> Questions to Show (Max 5)</th>
                        <th> Possible Questions</th>
                        <th> All Questions</th>
                        <th></th>
                    </tr>
                </thead>
                <body>
                @if(count($levels) > 0)
                    @foreach($levels as $level)
                <tr class="lev{{$level->lev_id}}">
                        <td>  
                            <div class="input-group">                        
                                <li class="form-control">Level #{{$level->lev_num}}</li>
                                 <button class="edit-modal btn btn-info" onclick="location.href = '/mapslevel/{{$level->lev_id}}'" style="margin:0 5px 0 5px;">
                                    <span class="fa fa-pencil fa-lg"></span>
                                </button>
                                <span class="input-group-addon">                                       
                                <button class="delete-modal btn btn-danger" data-id="{{$level->lev_id}}" data-name="Level #{{$level->lev_num}}" data-lnum="{{$level->lev_num}}" data-cid="{{$cat_id}}">
                                        <span class="fa fa-trash-o fa-lg"></span>
                                    </button>
                                </span>
                            </div>
                            {{-- <div class="input-group">  
                                <li class="form-control">Level #{{$level->lev_num}}</li>
                                 <span class="input-group-addon">                                       
                                    <button class="edit-modal btn btn-info" style="margin:0 5px 0 5px;" data-id="{{$level->lev_id}}" data-name="{{$level->lev_num}}">
                                        <span >MAP</span>
                                    </button>
                                </span>
                            </div> --}}
                        </td>
                        <td>   
                            <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">     
                            <?php $unhide = DB::table('questions')->where('lev_id',$level->lev_id)->where('ques_hide', '0')->count();?>                     
                            <select id="number" data-id="{{$level->lev_id}}">
                                @for($i = 1; $i <= $unhide; $i++)
                                    @if($i == $level->numOfQues)
                                        <option value="{{$i}}" selected="selected">{{$i}}</option>
                                    @else
                                        <option value="{{$i}}">{{$i}}</option>
                                    @endif

                                    @if($i == 5)
                                        @break
                                    @endif                                    
                                @endfor
                            </select>
                        </td> 
                        <td>                                                      
                            <li class="form-control" style="width:50px;"><?php echo $unhide; ?></li>
                        </td> 
                        <td>                                                      
                            <li class="form-control" style="width:50px;"><?php echo DB::table('questions')->where('lev_id',$level->lev_id)->count(); ?></li>
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

    <script>
        $(document).on("change", "#number", function () {
            var select = $("#number").val();
            $.ajax({
                url:"/level/questions",
                type: 'post',
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: $(this).data('id'), 
                    number: select
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
    </script>
@include('layouts.modal')
{{-- @include('layouts.levelmodal') --}}
    
    <script>
        $(document).on('click', '.edit-modal', function() {
            $('#mapModal').modal('show');

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
            $('.lnum').text($(this).data('lnum'));
            $('.cid').text($(this).data('cid'));            
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
                url: '/level/adelete',
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id':  $('.did').text(),
                    'lnum': $('.lnum').text(),
                    'cid':$('.cid').text()
                },
                success: function(data) {
                    location.reload();
                }
            });
        });
    </script>
@endsection