  <h4>Your plan</h4>
  <p>You are on the <strong>
      {{ $subscription->stripe_plan }}
  </strong> plan.</p>
  
    <h3>Change your plan</h3>
      @foreach($plans as $plan)
          <div class="col-md-6">
              <div class="panel {{ ( $is_subscribed && $subscription->stripe_plan ==  $plan->id ) ? 'panel-success' :  'panel-primary' }}">
                  <div class="panel-heading text-uppercase">{{ $plan->id }}</div>
                  <div class="panel-body text-center">
                      <h3 class="modal-title">
                          {{ $plan->name }}
                      </h3>

                      <p>{{ $plan->currency }} {{ $plan->amount / 100 }} / {{ $plan->interval }}</p>
                  </div>
                  <div class="panel-footer">
                      @if( $is_subscribed &&  ( $subscription->stripe_plan ==  $plan->id ) )
                          <a href="#" class="btn btn-default btn-block">
                              Current Plan
                          </a>
                      @else
                          <a href="{{ route('plan', $plan->id) }}" class="btn btn-success btn-block" onclick="event.preventDefault();
                                                     document.getElementById('swap-form').submit();">
                              Change
                          </a>
                          <form id="swap-form" action="{{ route('swapPlans') }}" method="POST" style="display: none;">
                              <input type="hidden" name="plan_to_swap_to" id="plan_to_swap_to" value="{{ $plan->id }}">
                              {{ csrf_field() }}
                          </form>
                      @endif
                  </div>
              </div>
          </div>
          @endforeach
  </div>