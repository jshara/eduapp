@extends('layouts.app')

@section('content')
        {!! Form::open(['action' => ['LevelsController@store',$cat_id],'method'=>'POST']) !!}
            <div class="row">
                <div class="form-group col-md-6">
                    {{Form::label('location', 'Location of the level')}}
                    {{Form::text('location','',['class' => 'form-control','placeholder' => 'Location Point'])}}
                </div>
                <div class="form-group col-md-6">
                    {{Form::label('position', 'Position of the level')}}
                    {{ Form::selectRange('position',1,$newLevel,['class' => 'form-control',$newLevel]) }}
                </div>            
            </div>    
            {{Form::submit('Add',['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
@endsection