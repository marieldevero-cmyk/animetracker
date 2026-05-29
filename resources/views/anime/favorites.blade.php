@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')
<div class="page-hero">
    <svg viewBox="0 0 1200 240" fill="none" xmlns="http://www.w3.org/2000/svg" class="hero-svg">
        <defs>
            <linearGradient id="favSky" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#1a1040"/>
                <stop offset="100%" stop-color="#2a1a4e"/>
            </linearGradient>
            <radialGradient id="starGlow" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="rgba(243,194,107,0.12)"/>
                <stop offset="100%" stop-color="transparent"/>
            </radialGradient>
        </defs>
        <rect width="1200" height="240" fill="url(#favSky)"/>
        <circle cx="200" cy="60" r="80" fill="url(#starGlow)"/>
        <circle cx="800" cy="40" r="60" fill="url(#starGlow)"/>
        <g fill="#fff">
            <circle cx="100" cy="50" r="1.5"/><circle cx="250" cy="30" r="1"/><circle cx="350" cy="70" r="1.8"/>
            <circle cx="500" cy="25" r="1.2"/><circle cx="650" cy="55" r="1.5"/><circle cx="750" cy="20" r="1"/>
            <circle cx="900" cy="45" r="1.8"/><circle cx="1050" cy="35" r="1.2"/><circle cx="1150" cy="65" r="1"/>
            <circle cx="150" cy="90" r="0.8"/><circle cx="450" cy="80" r="1"/><circle cx="850" cy="90" r="0.8"/>
        </g>
        <path d="M0 200 Q100 170 200 185 Q300 160 400 180 Q500 155 600 175 Q700 150 800 170 Q900 160 1000 180 Q1100 165 1200 185 L1200 240 L0 240Z" fill="#2a1a4e" opacity="0.6"/>
        <path d="M0 220 Q150 200 300 215 Q450 195 600 210 Q750 190 900 205 Q1050 195 1200 210 L1200 240 L0 240Z" fill="#3a2a5e" opacity="0.4"/>
        <g transform="translate(200,150)">
            <ellipse cx="0" cy="0" rx="50" ry="45" fill="#4a4a5a" opacity="0.5"/>
            <ellipse cx="0" cy="5" rx="28" ry="30" fill="#c8c8d0" opacity="0.3"/>
            <circle cx="-12" cy="-12" r="12" fill="#fff" opacity="0.3"/>
            <circle cx="12" cy="-12" r="12" fill="#fff" opacity="0.3"/>
            <circle cx="-12" cy="-12" r="6" fill="#2a2a3e" opacity="0.3"/>
            <circle cx="12" cy="-12" r="6" fill="#2a2a3e" opacity="0.3"/>
        </g>
        <g>
            <circle cx="160" cy="180" r="10" fill="url(#firefly)" opacity="0.4">
                <animate attributeName="opacity" values="0.2;0.6;0.2" dur="3s" repeatCount="indefinite"/>
            </circle>
            <circle cx="160" cy="180" r="2" fill="#f3c26b" opacity="0.5"/>
            <circle cx="380" cy="170" r="8" fill="url(#firefly)" opacity="0.3">
                <animate attributeName="opacity" values="0.3;0.5;0.3" dur="4s" repeatCount="indefinite"/>
            </circle>
            <circle cx="380" cy="170" r="1.5" fill="#f3c26b" opacity="0.5"/>
            <circle cx="720" cy="160" r="9" fill="url(#firefly)" opacity="0.4">
                <animate attributeName="opacity" values="0.2;0.7;0.2" dur="3.5s" repeatCount="indefinite"/>
            </circle>
            <circle cx="720" cy="160" r="1.8" fill="#f3c26b" opacity="0.5"/>
        </g>
        <text x="600" y="110" text-anchor="middle" fill="#fff" font-family="Fredoka, system-ui, sans-serif" font-size="32" font-weight="700" letter-spacing="2">My Favorites</text>
        <text x="600" y="142" text-anchor="middle" fill="rgba(255,255,255,0.4)" font-family="Instrument Sans, system-ui, sans-serif" font-size="14">Your most beloved anime collection</text>
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
                <a href="{{ route('anime.edit', $anime) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="event.stopPropagation();confirmDelete({{ $anime->id }}, '{{ addslashes($anime->title) }}')">Delete</button>
                <form id="delete-form-{{ $anime->id }}" action="{{ route('anime.destroy', $anime) }}" method="POST" class="d-none">
                    @csrf @method('DELETE')
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            <p>No favorites yet. Add some from the anime list!</p>
            <a href="{{ route('anime.index') }}" class="btn btn-gold mt-2">Browse Anime</a>
        </div>
    @endforelse
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id, title) {
    event.stopPropagation();
    Swal.fire({
        title: 'Remove Favorite',
        text: `Remove "${title}" from your favorites?`,
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
