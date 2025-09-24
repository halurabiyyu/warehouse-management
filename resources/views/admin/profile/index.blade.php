@extends('layouts.app')

@section('content')
<div>
    <h3>User Profile</h3>
    <div class="mt-3">
        <div>
            <label for="">Nama</label>
            <input type="text" class="form-control" value="{{ $user->name }}" disabled>
            <label for="">Email</label>
            <input type="text" class="form-control" value="{{ $user->email }}" disabled>
        </div>
        <div class="text-end">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger rounded px-2 mt-2">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection