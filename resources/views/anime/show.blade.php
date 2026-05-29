@extends('layouts.app')

@section('title', $anime->title)

@section('content')
<div class="detail-hero" style="background: linear-gradient(135deg, #1a1040 0%, #2a1a4e 50%, #1a2a3a 100%);">
    <svg viewBox="0 0 1200 200" fill="none" class="detail-hero-svg">
        <defs>
            <radialGradient id="dhGlow" cx="50%" cy="50%" r="50%">
                <stop offset="0%" stop-color="rgba(243,194,107,0.08)"/>
                <stop offset="100%" stop-color="transparent"/>
            </radialGradient>
        </defs>
        <circle cx="600" cy="100" r="120" fill="url(#dhGlow)"/>
        <g fill="#fff" opacity="0.3">
            <circle cx="100" cy="40" r="1"/><circle cx="300" cy="60" r="1.5"/><circle cx="500" cy="30" r="1"/>
            <circle cx="700" cy="50" r="1.5"/><circle cx="900" cy="35" r="1"/><circle cx="1100" cy="55" r="1.5"/>
        </g>
        <path d="M0 170 Q300 145 600 160 Q900 140 1200 165 L1200 200 L0 200Z" fill="rgba(42,26,78,0.4)"/>
    </svg>
    <div class="detail-hero-content">
        <a href="{{ url()->previous() }}" class="detail-back">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back
        </a>
        <div class="detail-title-section">
            <h1 class="detail-title">{{ $anime->title }}</h1>
            @if ($anime->japanese_name)
                <p class="detail-jp-name">{{ $anime->japanese_name }}</p>
            @endif
        </div>
    </div>
</div>

<div class="detail-content">
    <div class="detail-layout">
        <div class="detail-sidebar">
            <div class="detail-poster">
                @if ($anime->poster)
                    <img src="{{ storage_asset($anime->poster) }}" alt="{{ $anime->title }}">
                @else
                    <div class="poster-placeholder-lg">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(243,194,107,0.3)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    </div>
                @endif
            </div>

            <div class="detail-status-box">
                @php
                    $statusColors = [
                        'Watch List' => ['bg' => 'rgba(232,168,124,0.15)', 'text' => '#c1663e'],
                        'Watched' => ['bg' => 'rgba(46,196,182,0.12)', 'text' => '#1a6b63'],
                        'Favorite' => ['bg' => 'rgba(243,194,107,0.15)', 'text' => '#8a7020'],
                    ];
                    $sc = $statusColors[$anime->current_status] ?? ['bg' => '#eee', 'text' => '#666'];
                @endphp
                <span class="badge w-100 py-2" style="background-color:{{ $sc['bg'] }};color:{{ $sc['text'] }};font-size:0.9rem;">
                    {{ $anime->current_status }}
                </span>
            </div>

            <div class="detail-actions">
                <a href="{{ route('anime.edit', $anime) }}" class="btn btn-gold w-100">Edit Anime</a>
                <button type="button" class="btn btn-outline-danger w-100 mt-2" onclick="confirmDelete({{ $anime->id }}, '{{ addslashes($anime->title) }}')">Delete</button>
                <form id="delete-form-{{ $anime->id }}" action="{{ route('anime.destroy', $anime) }}" method="POST" class="d-none">
                    @csrf @method('DELETE')
                </form>
            </div>
        </div>

        <div class="detail-main">
            <div class="detail-info-grid">
                @if ($anime->movie_year)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Year</span>
                        <span class="detail-info-value">{{ $anime->movie_year }}</span>
                    </div>
                @endif
                @if ($anime->director)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Director</span>
                        <span class="detail-info-value">{{ $anime->director }}</span>
                    </div>
                @endif
                @if ($anime->genre)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Genre</span>
                        <span class="detail-info-value">{{ $anime->genre }}</span>
                    </div>
                @endif
                @if ($anime->duration)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Duration</span>
                        <span class="detail-info-value">{{ $anime->duration }}</span>
                    </div>
                @endif
                @if ($anime->rating)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Rating</span>
                        <span class="detail-info-value">{{ $anime->rating }}/10</span>
                    </div>
                @endif
                @if ($anime->japanese_name)
                    <div class="detail-info-item">
                        <span class="detail-info-label">Japanese Name</span>
                        <span class="detail-info-value" style="font-style:italic;">{{ $anime->japanese_name }}</span>
                    </div>
                @endif
            </div>

            @if ($anime->synopsis)
                <div class="detail-section">
                    <h3 class="detail-section-title">Synopsis</h3>
                    <p class="detail-synopsis">{{ $anime->synopsis }}</p>
                </div>
            @endif

            <div class="detail-timeline">
                <div class="detail-timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-date">Added {{ $anime->created_at->format('M d, Y') }}</span>
                        <span class="timeline-desc">Added to your collection</span>
                    </div>
                </div>
                <div class="detail-timeline-item">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <span class="timeline-date">Last updated {{ $anime->updated_at->format('M d, Y') }}</span>
                        <span class="timeline-desc">Most recent change</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Delete Anime',
        text: `Are you sure you want to delete "${title}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#c1663e',
        cancelButtonColor: '#a7a9be',
        confirmButtonText: 'Yes, delete',
        cancelButtonText: 'Cancel',
        background: '#fefcf3',
        color: '#1a1a2e',
        customClass: { popup: 'rounded-4 shadow-lg border-0', confirmButton: 'btn btn-danger rounded-3 px-4', cancelButton: 'btn btn-secondary rounded-3 px-4' },
        buttonsStyling: false,
    }).then((result) => { if (result.isConfirmed) { document.getElementById('delete-form-' + id).submit(); } });
}
</script>
@endpush
