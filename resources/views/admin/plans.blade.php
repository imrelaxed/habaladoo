@extends('admin.layout')

@section('content')
@if( count($cachedPlans) )
    <p>File cached plans for settings. <a href="{{ url('admin/flush-cached-plans') }}">Re-import now</a>.</p>
    <div class="row text-center">
        <div class="col-md-12">
    @foreach( $cachedPlans as $cachedPlan )
        <div class="col-sm-4">
            <div class="panel-heading text-uppercase">ID: {{ $cachedPlan->id }}</div>
            <div class="panel-body text-center">
                <h3 class="modal-title">
                  <small>Plan Name</small><br> {{ $cachedPlan->name }}
                </h3>
                <p>{{ $cachedPlan->currency }} {{ $cachedPlan->amount / 100 }} / {{ $cachedPlan->interval }}</p>
            </div>
        </div>
    @endforeach
        </div>
    </div>

@endif
  <hr> <br>
  @if( count($plans) )
    <p>Database cached plans for front page. <a href="{{ url('admin/import-subscription-plans') }}">Re-import now</a>.</p>
    <div class="row">
    @foreach( $plans as $plan )
      <div class="col-sm-4">
      @include('admin.modules.plans.plan')
      </div>
    @endforeach
    </div>
  @else

    @if( env('STRIPE_SECRET') == null )
    <p>You haven't set your <strong>secret Stripe API key</strong> yet... Open you <em>.env</em> file and set it first.</p>
    @else
    <p>You haven't imported your Stripe plans yet... <a href="{{ url('admin/import-subscription-plans') }}">Import now</a>.</p>    
    @endif
    
  @endif

@endsection