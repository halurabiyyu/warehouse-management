@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-8">
        <div class="card bg-default">
            <div class="card-header bg-transparent">
                <h5 class="text-white mb-0">Sales Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="chart-sales-dark" class="chart-canvas"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  var ctx = document.getElementById('chart-sales-dark').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug'],
      datasets: [{
        label: 'Sales',
        data: [10, 20, 15, 40, 30, 50, 60, 80],
        borderColor: '#5e72e4',
        backgroundColor: 'rgba(94,114,228,.1)',
      }]
    }
  });
</script>
@endpush
