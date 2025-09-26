@extends('layouts.app')

@section('title', 'Dashboard')

{{-- @section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card text-white rounded-2xl shadow-lg" style="background-color: #011e47">
      <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Overview</h5>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="display-5 fw-bold">{{$itemCount}}</h2>
            <p class="mb-0 opacity-75">Total Barang</p>
          </div>
          <i class="fas fa-box fa-3x"></i>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="display-5 fw-bold">{{$stockCount}}</h2>
            <p class="mb-0 opacity-75">Total Stok Barang</p>
          </div>
          <i class="fas fa-clipboard-list fa-3x"></i>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="display-5 fw-bold">{{$inboundCount}}</h2>
            <p class="mb-0 opacity-75">Total Barang Masuk</p>
          </div>
          <i class="fas fa-truck fa-flip-horizontal fa-3x"></i>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h2 class="display-5 fw-bold">{{$outboundCount}}</h2>
            <p class="mb-0 opacity-75">Total Barang Keluar</p>
          </div>
          <i class="fas fa-truck fa-3x"></i>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection --}}

@section('content')
  <div class="row">
    <!-- Total Barang -->

    <div class="col-md-3 col-sm-6">
      <a href="{{ route('items.index') }}" style="text-decoration: none;">
        <div class="card text-white rounded-2xl shadow-lg" style="background-color: #011e47;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold">Total Barang</h5>
              <h2 class="display-6">{{$itemCount}}</h2>
            </div>
            <i class="fas fa-box fa-2x"></i>
          </div>
        </div>
      </a>
    </div>

    <!-- Total Stok Barang -->
    <div class="col-md-3 col-sm-6">
      <a href="{{ route('items.index') }}" style="text-decoration: none;">
        <div class="card text-white rounded-2xl shadow-lg" style="background-color: #1a237e;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold">Total Stok</h5>
              <h2 class="display-6">{{$stockCount}}</h2>
            </div>
            <i class="fas fa-clipboard-list fa-2x"></i>
          </div>
        </div>
      </a>
    </div>

    <!-- Total Barang Masuk -->
    <div class="col-md-3 col-sm-6">
      <a href="{{ route('inbound.index') }}" style="text-decoration: none;">
        <div class="card text-white rounded-2xl shadow-lg" style="background-color: #00695c;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold">Barang Masuk</h5>
              <h2 class="display-6">{{$inboundCount}}</h2>
            </div>
            <i class="fas fa-truck fa-flip-horizontal fa-2x"></i>
          </div>
        </div>
      </a>
    </div>

    <!-- Total Barang Keluar -->
    <div class="col-md-3 col-sm-6">
      <a href="{{ route('outbound.index') }}" style="text-decoration: none;">
        <div class="card text-white rounded-2xl shadow-lg" style="background-color: #c62828;">
          <div class="card-body d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold">Barang Keluar</h5>
              <h2 class="display-6">{{$outboundCount}}</h2>
            </div>
            <i class="fas fa-truck fa-2x"></i>
          </div>
        </div>
    </div>
  </div>
@endsection