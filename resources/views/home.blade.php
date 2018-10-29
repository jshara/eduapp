@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center" style="background:#a0aaba!important;">
        <font size="10">EDUTAINMENT APP</font>
        <h4>The App That Makes Learning Fun</h4>
    </div>
    @guest
    <div class="jumbotron text-center" style="background:#a0aaba!important">
        <h2>Please login to use this website !</h2>
    </div>
    @else
        @if(Auth::user()->role == 'coordinator')
            <div class="row">
                <div class="col-md-4">
                    <div class="joseph card" style="width: 18rem; margin-right:10px; border:none">
                        <a style="text-decoration:none; color:black; border:none" href="/categories">
                            <img class="card-img-top" src="/img/circle_plus.png" alt="Category Button">
                            <div class="card-body">
                                <h2 class="card-text text-center">Create Game</h2>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="joseph card" style="width: 18rem; margin-right:10px; border:none">
                        <a style="text-decoration:none; color:black; border:none" href="/courses">
                            <img class="card-img-top" src="/img/books.png" alt="Courses Button">
                            <div class="card-body">
                                <h2 class="card-text text-center">Manage Courses</h2>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-md-4">  
                    <div class="joseph card" style="width: 18rem; border:none">
                        <a style="text-decoration:none; color:black; border:none" href="/results">
                            <img class="card-img-top" src="/img/results.png" alt="Results Button">
                            <div class="card-body">
                                <h2 class="card-text text-center">View Results</h2>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @else
        
        @endif
    @endguest

    <script>
   $(document).ready(function(){
    $(".joseph").hover(function(){
        $(this).css("background-color", "#87CEFA");
        }, function(){
        $(this).css("background-color", "white");
    });
});
    </script>
@endsection
