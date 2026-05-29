@extends('layouts.app')

@section('title', 'Watched')

@section('content')
<div class="page-hero">
    <svg viewBox="0 0 1200 240" fill="none" xmlns="http://www.w3.org/2000/svg" class="hero-svg">
        <defs>
            <linearGradient id="wtSky" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#1a0a0a"/>
                <stop offset="40%" stop-color="#2a1a10"/>
                <stop offset="100%" stop-color="#3a2a1a"/>
            </linearGradient>
            <radialGradient id="sunsetGlow" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="rgba(232,168,124,0.2)"/>
                <stop offset="50%" stop-color="rgba(243,194,107,0.1)"/>
                <stop offset="100%" stop-color="transparent"/>
            </radialGradient>
        </defs>
        <rect width="1200" height="240" fill="url(#wtSky)"/>
        <circle cx="600" cy="120" r="140" fill="url(#sunsetGlow)"/>
        <circle cx="600" cy="140" r="50" fill="#e8a87c" opacity="0.15"/>
        <circle cx="600" cy="150" r="35" fill="#f3c26b" opacity="0.1"/>
        <g stroke="rgba(232,168,124,0.08)" stroke-width="2">
            <line x1="600" y1="90" x2="600" y2="60"/>
            <line x1="640" y1="140" x2="680" y2="140"/>
            <line x1="560" y1="140" x2="520" y2="140"/>
            <line x1="635" y1="105" x2="660" y2="82"/>
            <line x1="565" y1="105" x2="540" y2="82"/>
        </g>
        <path d="M0 180 Q200 155 400 170 Q600 150 800 165 Q1000 155 1200 175 L1200 240 L0 240Z" fill="#2a1a10" opacity="0.6"/>
        <path d="M0 205 Q300 185 600 195 Q900 180 1200 195 L1200 240 L0 240Z" fill="#3a2a1a" opacity="0.4"/>
        <g transform="translate(300,160)">
            <ellipse cx="0" cy="0" rx="40" ry="30" fill="#3a2a1a" opacity="0.5"/>
            <ellipse cx="-30" cy="5" rx="25" ry="18" fill="#4a3a2a" opacity="0.4"/>
        </g>
        <g transform="translate(850,155)">
            <ellipse cx="0" cy="0" rx="35" ry="25" fill="#3a2a1a" opacity="0.5"/>
            <ellipse cx="25" cy="5" rx="20" ry="15" fill="#4a3a2a" opacity="0.4"/>
        </g>
        <g>
            <circle cx="200" cy="180" r="8" fill="url(#firefly)" opacity="0.3">
                <animate attributeName="opacity" values="0.2;0.5;0.2" dur="3s" repeatCount="indefinite"/>
            </circle>
            <circle cx="200" cy="180" r="1.5" fill="#f3c26b" opacity="0.4"/>
        </g>
        <text x="600" y="110" text-anchor="middle" fill="#fff" font-family="Fredoka, system-ui, sans-serif" font-size="32" font-weight="700" letter-spacing="2">Watched</text>
        <text x="600" y="142" text-anchor="middle" fill="rgba(255,255,255,0.4)" font-family="Instrument Sans, system-ui, sans-serif" font-size="14">Anime you've already seen</text>
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
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.15)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            <p>No watched anime yet.</p>
            <a href="{{ route('anime.watch-list') }}" class="btn btn-gold mt-2">Go to Watch List</a>
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
        text: `Remove "${title}" from your watched list?`,
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
