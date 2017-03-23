<div class="col-sm-6">
  <div class="panel panel-primary">
    <div class="panel-heading text-uppercase">{{ $plan->name }}</div>
  <div class="panel-body text-center">
    <h3 class="modal-title">{{ number_format($plan->amount / 100, 2) }} {{ strtoupper($plan->currency) }}
    <small class="per">
    / {{ $plan->interval }}  
    </small></h3>
  </div>
    <div class="text-muted">
    @if( $plan->description !== "" )
      <p class="plan__description">{!! $plan->description !!}</p>
    @endif 
    
    @if( $plan->features !== "" )
      <ul class="plan__features">
          @foreach( explode(',', $plan->features) as $feature )
            <li>{!! $feature !!}</li>
          @endforeach
      </ul>
    @endif
  </div>
    <div class="panel-footer">

      <a href="{{ route('plan', $plan->plan_id) }}" class="btn btn-success btn-block">
        Subscribe
      </a>

    </div>

</div>
</div>