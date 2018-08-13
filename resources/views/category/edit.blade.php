@extends('layouts.app')

@section('content')
<h1>Edit Category Name</h1>
        {!! Form::open(['action' => ['CategorysController@update',$cat->cat_id],'method'=>'POST']) !!}
            <div class="form-group">
                {{form::label('cat_name', 'Category Name')}}
                {{Form::text('cat_name',$cat->cat_name,['class' => 'form-control','placeholder' => 'Name'])}}
            </div>
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Save',['class'=>'btn btn-primary'])}}
        {!! Form::close() !!}
@endsection