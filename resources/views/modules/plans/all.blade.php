@if( count($plans) > 0 )
  <div class="row text-center">
  <div class="col-md-12">
  @foreach($plans as $plan)
    @include('modules.plans.plan')
  @endforeach
  </div>
  </div>
@else
  <p>You haven't imported any plans yet! You can do that from the admin panel.</p>
@endif