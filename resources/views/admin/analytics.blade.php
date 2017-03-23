@extends('admin.layout')

@section('content')
  
  <div class="row">
    @include(
      'admin.modules.analytics.widget', [
      'widget' => 'new-paying-customers', 
      'title' => 'New Paying Customers (Last 2 months)'
    ])  
    @include(
      'admin.modules.analytics.widget', [
      'widget' => 'revenue-over-time',
      'title' => 'Revenue over time (Last 2 months)'
    ])
  </div>

  <div class="row">
    @include(
      'admin.modules.analytics.widget', [
      'widget' => 'todays-revenue',
      'title' => 'Todays\' revenue',
      'col' => '3'
    ])
    @include(
      'admin.modules.analytics.widget', [
      'widget' => 'last-months-revenue',
      'title' => 'Last 30 days\' revenue',
      'col' => '3'
    ])

    @include(
      'admin.modules.analytics.widget', [
      'widget' => 'growth-rate',
      'title' => 'Weekly Revenue Growth rate',
      'col' => '3'
    ])

    @include(
      'admin.modules.analytics.widget', [
      'widget' => 'total-customers',
      'title' => 'Total Subscribed Customers',
      'col' => '3'
    ])    
  </div>

@endsection

@section('keen')
@if( isset($settings) and $settings->service_keen_io_project_id and $settings->service_keen_io_read_key )
<script>
  
  var client = new Keen({
    projectId: "{{ $service_keen_io_project_id or '58bdf87e8db53dfda8a8abc2' }}",
    readKey: "{{ $service_keen_io_read_key or 'FB4786BF0750F03F8A52B993335334C5262BDA6687CFE956EFEF9FE2A3F9BF1ACAD02C72E058A3297D2969152DFF2AE1CE05C32C429B27E506A03E2259B3E39EA533E2038450693423477B5CA428A0A93184B88AA2D3173C8ABB6441D636DBED' }}"
  });

</script>
@endif
@endsection