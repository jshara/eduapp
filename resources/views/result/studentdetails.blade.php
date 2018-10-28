@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-2  nopadding">
        <a href="/perform/{{$cat_id}}" class="btn btn-danger">BACK</a>
    </div>
    <div class="col-md-6 offset-md-2">
        {{-- <h2><b> <php echo DB::table('categories')->where('cat_id',$cat_id)->value('cat_name'); ?></b></h2> --}}
    </div>
</div><br>

<?php dd ($data);?>

@endsection