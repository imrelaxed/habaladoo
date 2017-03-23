@if( count($users) )

<table class="table table-striped">
  
  <caption>Total users: {{ $total_users }}. Plan subscribers: {{ $total_active_subscribers }}. Non-subscribers: {{ $total_non_subscribers }}.</caption>
  
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Plan</th>
      <th class="text-center">Tester?</th>
    </tr>
  </thead>
  <tbody>
    
  @foreach( $users as $user )
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>
      @if( $user->subscription_active )
        Active - {{ ucfirst($user->subscription('main')->stripe_plan) }} Plan
        @else
        Not Active
        @endif
      </td>
      <td class="text-center">
        @if( !$user->hasStripeId() && $user->subscribed('main') )

          <input 
           type="checkbox" 
           class="cb-tester-access" 
           name="cb-tester-access"

           data-type="post"
           data-uri="api/v1/users/{{ $user->id }}/toggleTesterStatus"
           checked
           >

        @else
        
          <input 
           type="checkbox" 
           class="cb-tester-access" 
           name="cb-tester-access"

           data-type="post"
           data-uri="api/v1/users/{{ $user->id }}/toggleTesterStatus"
           >
  
        @endif
      </td>
    </tr>
  @endforeach

  </tbody>
</table>

{!! $users->render() !!}

@else
<p>You currently don't have any users. Get out and get 'em!</p>

@endif