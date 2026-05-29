@extends('layouts.app')

@section('title', 'Watch List')

@section('content')
<div class="page-hero">
    <svg viewBox="0 0 1200 240" fill="none" xmlns="http://www.w3.org/2000/svg" class="hero-svg">
        <defs>
            <linearGradient id="wlSky" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#0a2a1a"/>
                <stop offset="50%" stop-color="#1a3a2a"/>
                <stop offset="100%" stop-color="#2a4a3a"/>
            </linearGradient>
            <radialGradient id="wlSun" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="rgba(232,168,124,0.15)"/>
                <stop offset="100%" stop-color="transparent"/>
            </radialGradient>
        </defs>
        <rect width="1200" height="240" fill="url(#wlSky)"/>
        <circle cx="950" cy="80" r="80" fill="url(#wlSun)"/>
        <circle cx="950" cy="80" r="30" fill="#e8a87c" opacity="0.3"/>
        <path d="M0 180 Q200 150 400 170 Q600 140 800 165 Q1000 145 1200 170 L1200 240 L0 240Z" fill="#1a3a2a" opacity="0.6"/>
        <path d="M0 210 Q300 185 600 200 Q900 180 1200 200 L1200 240 L0 240Z" fill="#2a4a3a" opacity="0.4"/>
        <g transform="translate(200,110)">
            <ellipse cx="0" cy="0" rx="60" ry="45" fill="#2d5a2d" opacity="0.5"/>
            <ellipse cx="50" cy="5" rx="40" ry="30" fill="#3a6a3a" opacity="0.4"/>
        </g>
        <g stroke="#5a8a5a" stroke-width="1.5" stroke-linecap="round" opacity="0.4">
            <line x1="180" y1="175" x2="180" y2="160"/>
            <line x1="185" y1="168" x2="175" y2="168"/>
            <line x1="220" y1="172" x2="220" y2="158"/>
            <line x1="225" y1="165" x2="215" y2="165"/>
        </g>
        <g>
            <circle cx="160" cy="200" r="8" fill="url(#firefly)" opacity="0.4">
                <animate attributeName="opacity" values="0.2;0.6;0.2" dur="3s" repeatCount="indefinite"/>
            </circle>
            <circle cx="160" cy="200" r="1.5" fill="#f3c26b" opacity="0.5"/>
        </g>
        <text x="600" y="110" text-anchor="middle" fill="#fff" font-family="Fredoka, system-ui, sans-serif" font-size="32" font-weight="700" letter-spacing="2">Watch List</text>
        <text x="600" y="142" text-anchor="middle" fill="rgba(255,255,255,0.4)" font-family="Instrument Sans, system-ui, sans-serif" font-size="14">Anime you plan to watch next</text>
    </svg>
</div>

<div class="anime-grid-page">
    @forelse ($animes as $anime)
        <div class="anime-card" onclick="window.location='{{ route('anime.show', $anime) }}'" style="cursor:pointer;">
            <div class="anime-card-poster">
                @if ($anime->poster)
                    <img src="{{ storage_asset($anime->poster) }}" alt="{{ $anime->title }}">
                @else
                    <div class="poster-placeholder">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="rgba(243,194,107,0.4)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
            </div>
            <div class="anime-card-body">
                <h3 class="anime-card-title">{{ $anime->title }}</h3>
                <div class="anime-card-details">
                    @if ($anime->movie_year)
                        <span class="anime-card-badge">{{ $anime->movie_year }}</span>
                    @endif
                    @if ($anime->director)
                        <span class="anime-card-badge">{{ $anime->director }}</span>
                    @endif
                </div>
                <div class="anime-card-meta">
                    @if ($anime->genre)
                        <span class="anime-card-tag">{{ $anime->genre }}</span>
                    @endif
                    @if ($anime->duration)
                        <span class="anime-card-tag">{{ $anime->duration }}</span>
                    @endif
                </div>
            </div>
            <div class="anime-card-actions">
                <form method="POST" action="{{ route('anime.update', $anime) }}" style="display:inline;">
                    @csrf @method('PUT')
                    <input type="hidden" name="title" value="{{ $anime->title }}">
                    <input type="hidden" name="movie_year" value="{{ $anime->movie_year }}">
                    <input type="hidden" name="genre" value="{{ $anime->genre }}">
                    <input type="hidden" name="duration" value="{{ $anime->duration }}">
                    <input type="hidden" name="current_status" value="Watched">
                    <button type="submit" class="btn btn-sm btn-gold">Mark Watched</button>
                </form>
                <a href="{{ route('anime.edit', $anime) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation();confirmDelete({{ $anime->id }}, '{{ addslashes($anime->title) }}')">Delete</button>
                <form id="delete-form-{{ $anime->id }}" action="{{ route('anime.destroy', $anime) }}" method="POST" class="d-none">
                    @csrf @method('DELETE')
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            <p>Your watch list is empty.</p>
            <a href="{{ route('anime.index') }}" class="btn btn-gold mt-2">Add Anime</a>
        </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, title) {
    event.stopPropagation();
    Swal.fire({
        title: 'Remove',
        text: `Remove "${title}" from your watch list?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c1663e',
        cancelButtonColor: '#a7a9be',
        confirmButtonText: 'Yes, remove',
        cancelButtonText: 'Cancel',
        background: '#fefcf3',
        color: '#1a1a2e',
        customClass: { popup: 'rounded-4 shadow-lg border-0', confirmButton: 'btn btn-danger rounded-3 px-4', cancelButton: 'btn btn-secondary rounded-3 px-4' },
        buttonsStyling: false,
    }).then((result) => { if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); } });
}
</script>
@endpush
