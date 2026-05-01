@extends('layouts.app')

@section('content')

<div style="padding:30px;">

    <!-- 🔥 HEADER -->
    <div style="
        background:#065f46;
        color:white;
        padding:20px;
        border-radius:12px;
        margin-bottom:20px;
        display:flex;
        justify-content:space-between;
        align-items:center;
    ">
        <input type="text" placeholder="Search..."
            style="padding:10px; border-radius:8px; border:none; width:250px;">

        <div>
            {{ now()->format('l, d F Y') }}
        </div>
    </div>

    <!-- 🔥 PROFILE CARD -->
    <div style="
        background:white;
        padding:20px;
        border-radius:16px;
        margin-bottom:20px;
        display:flex;
        align-items:center;
        gap:20px;
    ">

        <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : 'https://i.pravatar.cc/100' }}"
             style="width:80px; height:80px; border-radius:50%; object-fit:cover;">

        <div>
            <h3 style="margin:0;">{{ auth()->user()->name }}</h3>
            <p style="margin:5px 0; color:#6b7280;">Admin</p>
            <small>{{ auth()->user()->email }}</small>
        </div>

    </div>

    <!-- 🔥 PERSONAL INFO -->
    <div style="background:white; padding:20px; border-radius:16px; margin-bottom:20px;">

        <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
            <h4>Personal Information</h4>
        </div>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

                <div>
                    <label>Name</label>
                    <input type="text" name="name"
                        value="{{ auth()->user()->name }}"
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>

                <div>
                    <label>Email</label>
                    <input type="email" name="email"
                        value="{{ auth()->user()->email }}"
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>

                <div>
                    <label>Phone</label>
                    <input type="text" name="phone"
                        value="{{ auth()->user()->phone ?? '' }}"
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>

                <div>
                    <label>Avatar</label>
                    <input type="file" name="avatar"
                        style="width:100%;">
                </div>

            </div>

            <button style="
                margin-top:20px;
                background:#f97316;
                color:white;
                padding:10px 20px;
                border-radius:8px;
                border:none;
            ">
                Save Changes
            </button>

        </form>

    </div>

    <!-- 🔥 ADDRESS -->
    <div style="background:white; padding:20px; border-radius:16px;">

        <h4>Address</h4>

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px;">

                <div>
                    <label>Country</label>
                    <input type="text" name="country"
                        value="{{ auth()->user()->country ?? '' }}"
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>

                <div>
                    <label>City</label>
                    <input type="text" name="city"
                        value="{{ auth()->user()->city ?? '' }}"
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>

                <div>
                    <label>Postal Code</label>
                    <input type="text" name="postal_code"
                        value="{{ auth()->user()->postal_code ?? '' }}"
                        style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                </div>

            </div>

        </form>

    </div>

</div>

@endsection