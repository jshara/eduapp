@extends('layouts.app')

@section('content')
        {!! $map['js'] !!}

    <body>
        <div class="row">
            <div class="col-md-2">
                <a href="/categories" class="btn btn-danger">BACK</a>
            </div>
            <div class="col-md-6 offset-md-2">
                <h2><b> Map for: {{$cat_name}}</b></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1">
                <p>This map shows all the levels located in for this category. Each marker represents its respective Level.</p>    
            </div>
        </div>          
        
        <div class="container">{!! $map['html'] !!}</div>
    </body>
@endsection