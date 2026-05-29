@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="row justify-content-center animate-fade-in-up">
    <div class="col-md-6 col-lg-5">
        <div class="card border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <div class="position-relative d-inline-block">
                        @if (auth()->user()->avatar)
                            <img src="{{ storage_asset(auth()->user()->avatar) }}" alt="Avatar"
                                class="rounded-circle" style="width:100px;height:100px;object-fit:cover;border:3px solid var(--ghibli-gold);">
                        @else
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                style="width:100px;height:100px;font-size:2.5rem;background:linear-gradient(135deg,var(--ghibli-gold),var(--ghibli-accent));color:var(--ghibli-dark);font-weight:600;border:3px solid var(--ghibli-gold);">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        @endif
                    </div>
                    <h4 class="fw-bold mt-3 mb-0" style="color:#fff;">{{ auth()->user()->name }}</h4>
                    <p class="small" style="color:rgba(255,255,255,0.5);">{{ auth()->user()->email }}</p>
                </div>

                <hr style="border-color:rgba(255,255,255,0.1);opacity:1;">

                <h5 class="fw-semibold mb-3" style="color:#fff;">Edit Profile</h5>

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', auth()->user()->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', auth()->user()->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror"
                            accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                        <div class="form-text small">Optional. Accepted: jpeg, png, jpg, gif, webp. Max 2MB.</div>
                        @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
