@extends('app')

@section('content')
    @if( $is_subscribed )
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Billing Settings</div>

                    <div class="panel-body text-center">

                        @include('modules.forms.account.change-plan')
                        @include('modules.forms.account.update-credit-card')
                        @include('modules.forms.account.cancel')


                    </div>
                </div>
            </div>
        </div>
    </div>
@else
            <small>Nothing here.</small>

    @endif
@endsection

@section('additional-scripts')
    @include('services.stripe')
@endsection