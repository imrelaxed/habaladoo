@extends('app')

@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-12 col-sm-offset-0">
    @include('modules.plans.all')
    </div>
    </div>
    </div>
@endsection