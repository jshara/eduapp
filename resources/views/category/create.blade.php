@extends('layouts.app')

@section('content')
        {!! Form::open(['action' => 'CategorysController@store','method'=>'POST']) !!}
            <div class="form-group">
                {{form::label('cat_name', 'Category Name')}}
                {{Form::text('cat_name','',['class' => 'form-control','placeholder' => 'Name'])}}
            </div>
            {{Form::submit('Create',['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
@endsection