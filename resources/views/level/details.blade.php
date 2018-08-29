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
            <table class ="table table-striped table-border table-hover text-center">
                <thead>
                    <tr>                        
                        <th><?php echo DB::table('categories')->where('cat_id',$cat_id)->value('cat_name'); ?></th>
                        <th>Coordinates</th>
                        <th> </th>
                    </tr>
                </thead>
                <body>
                @if(count($levels) > 0)
                    @foreach($levels as $level)
                    <tr>
                        <td>                           
                            <p class="text-center">Level #{{$level->lev_num}}</p>                            
                        </td>
                        <td>
                            <div class="input-group">  
                                <li class="form-control">{{$level->lev_location}}</li>
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
@endsection