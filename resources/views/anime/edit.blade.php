@extends('layouts.app')

@section('title', 'Edit Anime')

@section('content')
<div class="row justify-content-center animate-fade-in-up">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-3 btn-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    </a>
                    <div>
                        <h5 class="fw-bold mb-0" style="color:#fff;">Edit Anime</h5>
                        <p class="text-muted small mb-0">Update anime details</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('anime.update', $anime) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', $anime->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Year</label>
                            <input type="number" name="movie_year" class="form-control @error('movie_year') is-invalid @enderror"
                                value="{{ old('movie_year', $anime->movie_year) }}" min="1900" max="{{ date('Y') + 5 }}">
                            @error('movie_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Genre</label>
                            <select name="genre" class="form-select @error('genre') is-invalid @enderror">
                                <option value="">—</option>
                                @foreach (['Adventure','Fantasy','Drama','Romance','Slice of Life','Supernatural','Historical','Comedy'] as $g)
                                    <option value="{{ $g }}" {{ old('genre', $anime->genre) === $g ? 'selected' : '' }}>{{ $g }}</option>
                                @endforeach
                            </select>
                            @error('genre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-control @error('duration') is-invalid @enderror"
                                value="{{ old('duration', $anime->duration) }}" placeholder="e.g. 125 min">
                            @error('duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Director</label>
                            <input type="text" name="director" class="form-control @error('director') is-invalid @enderror"
                                value="{{ old('director', $anime->director) }}" placeholder="Hayao Miyazaki">
                            @error('director') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Japanese Name</label>
                            <input type="text" name="japanese_name" class="form-control @error('japanese_name') is-invalid @enderror"
                                value="{{ old('japanese_name', $anime->japanese_name) }}" placeholder="Japanese title">
                            @error('japanese_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Rating (0-10)</label>
                            <input type="number" step="0.1" min="0" max="10" name="rating"
                                class="form-control @error('rating') is-invalid @enderror"
                                value="{{ old('rating', $anime->rating) }}">
                            @error('rating') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Synopsis</label>
                            <textarea name="synopsis" rows="4" class="form-control @error('synopsis') is-invalid @enderror"
                                placeholder="Brief description...">{{ old('synopsis', $anime->synopsis) }}</textarea>
                            @error('synopsis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Poster Image</label>
                            <input type="file" name="poster" class="form-control @error('poster') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/jpg,image/gif,image/webp">
                            @if ($anime->poster)
                                <div class="mt-2">
                                    <img src="{{ storage_asset($anime->poster) }}" alt="Current poster"
                                        style="width:80px;height:120px;object-fit:cover;border-radius:8px;">
                                </div>
                            @endif
                            @error('poster') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label">Status</label>
                            <select name="current_status" class="form-select @error('current_status') is-invalid @enderror" required>
                                @foreach (['Watch List','Watched','Favorite'] as $s)
                                    <option value="{{ $s }}" {{ old('current_status', $anime->current_status) === $s ? 'selected' : '' }}>{{ $s }}</option>
                                @endforeach
                            </select>
                            @error('current_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">Update Anime</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
