@extends('layouts.app')

@section('content')
        {!! $map['js'] !!}

    <body>
        <h1>Category Map for: {{$cat_name}}</h1>
        <p>This map shows all the levels located in for this category. Each marker represents its respective Level.</p>
        <div class="container">{!! $map['html'] !!}</div>
    </body>
@endsection