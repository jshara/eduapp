@extends('layouts.app')

@section('content')
<span class="hidden message" style="visibility:hidden;">
    <div class='alert alert-success'>
        <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="fa fa-close"></span></a>
        
    </div>
</span>
    <div class="row justify-content-end">
        <div class="col nopadding">
                <a href="/categories" class="btn btn-danger">BACK</a>
        </div>
        <div class="col text-right nopadding">
            <button class="btn btn-success disabled" data-toggle="tooltip" title="Unpublish Category to Add Level">ADD LEVEL</button>
        </div>
    </div>
    <div class="row">     
            {{-- <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">     --}}
            <table id="table" class ="table table-striped table-border table-hover text-center">
                <thead>
                    <tr>                        
                        <th><?php echo DB::table('categories')->where('cat_id',$cat_id)->value('cat_name'); ?></th>
                        <th> Questions to Show(Max 5)</th>
                        <th> Possible Questions</th>
                        <th> All Questions</th>
                        <th> Details </th>
                    </tr>
                </thead>
                <body>
                @if(count($levels) > 0)
                    @foreach($levels as $level)
                <tr class="lev{{$level->lev_id}}">
                        <td>  
                            <div class="input-group">                        
                                <li class="form-control">Level #{{$level->lev_num}}</li>
                                 <button class="btn btn-info disabled"  style="margin:0 5px 0 5px;" data-toggle="tooltip" title="Unpublish Category to Edit">
                                    <span class="fa fa-pencil fa-lg"></span>
                                </button>
                                <span class="input-group-addon">                                       
                                <button class="delete-modal btn btn-danger disabled" data-toggle="tooltip" title="Unpublish Category to Delete">
                                        <span class="fa fa-trash-o fa-lg"></span>
                                    </button>
                                </span>
                            </div>
                        </td>
                        <td>   
                            <input name="_token" value="eRYFMqxeGXyGy7Kn1AU7af7qbGlt4uEp8RtYb4Vx" type="hidden">     
                            <?php $unhide = DB::table('questions')->where('lev_id',$level->lev_id)->where('ques_hide', '0')->count();?>                     
                            <select id="number" data-id="{{$level->lev_id}}" data-toggle="tooltip" title="Unpublish Category to Select" disabled>
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
                            <a href="/questionsd/{{$level->lev_id}}" class="btn btn-info">Question[s]</a>
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
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
@endsection