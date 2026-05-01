@extends('layouts.app')

@section('content')

<h2 style="margin-bottom:20px;">Settings</h2>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    {{-- PROFILE --}}
    <div style="background:white; padding:20px; border-radius:12px;">
        <h4>Profile</h4>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <label>Name</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control">

            <label style="margin-top:10px;">Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control">

            <button style="margin-top:15px;" class="btn btn-primary">Update</button>
        </form>
    </div>

    {{-- PASSWORD --}}
    <div style="background:white; padding:20px; border-radius:12px;">
        <h4>Password</h4>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <label>New Password</label>
            <input type="password" name="password" class="form-control">

            <button style="margin-top:15px;" class="btn btn-danger">Change Password</button>
        </form>
    </div>

</div>

@endsection