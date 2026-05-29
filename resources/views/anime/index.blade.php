@extends('layouts.app')

@section('title', 'Anime')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color:#fff;">Anime</h3>
        <p class="small mb-0" style="color:rgba(255,255,255,0.5);">Track your collection</p>
    </div>
    <button type="button" class="btn btn-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createAnimeModal">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="me-1"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Anime
    </button>
</div>

<div class="card border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Title</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($animes as $anime)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $anime->title }}</td>
                            <td class="text-muted">{{ $anime->movie_year ?? '—' }}</td>
                            <td>
                                @if ($anime->genre)
                                    <span style="background-color:rgba(255,255,255,0.1);color:rgba(255,255,255,0.7);" class="badge">
                                        {{ $anime->genre }}
                                    </span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $anime->duration ?? '—' }}</td>
                            <td>
                                @php
                                    $statusColors = [
                                        'Watch List' => ['bg' => 'rgba(232,168,124,0.2)', 'text' => '#f5c9a8'],
                                        'Watched' => ['bg' => 'rgba(46,196,182,0.18)', 'text' => '#7edcd2'],
                                        'Favorite' => ['bg' => 'rgba(243,194,107,0.2)', 'text' => '#f5dba0'],
                                    ];
                                    $sc = $statusColors[$anime->current_status] ?? ['bg' => '#eee', 'text' => '#666'];
                                @endphp
                                <span class="badge" style="background-color:{{ $sc['bg'] }};color:{{ $sc['text'] }};">
                                    {{ $anime->current_status }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('anime.edit', $anime) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $anime->id }}, '{{ addslashes($anime->title) }}')">Delete</button>
                                <form id="delete-form-{{ $anime->id }}" action="{{ route('anime.destroy', $anime) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                No anime entries yet. Add your first one!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    {{ $animes->links() }}
</div>

<div class="modal fade" id="createAnimeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <h5 class="fw-bold mb-1" style="color:var(--ghibli-sidebar);">Add Anime</h5>
                <p class="text-muted small mb-4">Choose a Ghibli classic or type your own</p>
                <form method="POST" action="{{ route('anime.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Quick Pick</label>
                        <select class="form-select" id="ghibliQuickPick" onchange="fillTitle(this.value)">
                            <option value="">— Select a Ghibli film —</option>
                            <option value="Spirited Away">Spirited Away (2001)</option>
                            <option value="My Neighbor Totoro">My Neighbor Totoro (1988)</option>
                            <option value="Howl's Moving Castle">Howl's Moving Castle (2004)</option>
                            <option value="Princess Mononoke">Princess Mononoke (1997)</option>
                            <option value="Kiki's Delivery Service">Kiki's Delivery Service (1989)</option>
                            <option value="Castle in the Sky">Castle in the Sky (1986)</option>
                            <option value="The Wind Rises">The Wind Rises (2013)</option>
                            <option value="Ponyo">Ponyo (2008)</option>
                            <option value="Grave of the Fireflies">Grave of the Fireflies (1988)</option>
                            <option value="The Tale of the Princess Kaguya">The Tale of the Princess Kaguya (2013)</option>
                            <option value="Nausicaä of the Valley of the Wind">Nausicaä of the Valley of the Wind (1984)</option>
                            <option value="Whisper of the Heart">Whisper of the Heart (1995)</option>
                            <option value="Arrietty">Arrietty (2010)</option>
                            <option value="From Up on Poppy Hill">From Up on Poppy Hill (2011)</option>
                            <option value="Only Yesterday">Only Yesterday (1991)</option>
                            <option value="When Marnie Was There">When Marnie Was There (2014)</option>
                            <option value="The Cat Returns">The Cat Returns (2002)</option>
                            <option value="Porco Rosso">Porco Rosso (1992)</option>
                            <option value="Ocean Waves">Ocean Waves (1993)</option>
                            <option value="Tales from Earthsea">Tales from Earthsea (2006)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="animeTitle" class="form-control @error('title') is-invalid @enderror" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-4">
                            <label class="form-label">Year</label>
                            <input type="number" name="movie_year" class="form-control" min="1900" max="{{ date('Y') + 5 }}" placeholder="2001">
                        </div>
                        <div class="col-4">
                            <label class="form-label">Genre</label>
                            <select name="genre" class="form-select">
                                <option value="">—</option>
                                <option value="Adventure">Adventure</option>
                                <option value="Fantasy">Fantasy</option>
                                <option value="Drama">Drama</option>
                                <option value="Romance">Romance</option>
                                <option value="Slice of Life">Slice of Life</option>
                                <option value="Supernatural">Supernatural</option>
                                <option value="Historical">Historical</option>
                                <option value="Comedy">Comedy</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <label class="form-label">Duration</label>
                            <input type="text" name="duration" class="form-control" placeholder="e.g. 125 min">
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label">Director</label>
                            <input type="text" name="director" class="form-control" placeholder="Hayao Miyazaki">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Rating (0-10)</label>
                            <input type="number" step="0.1" min="0" max="10" name="rating" class="form-control" placeholder="8.5">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="current_status" class="form-select" required>
                            <option value="Watch List">Watch List</option>
                            <option value="Watched">Watched</option>
                            <option value="Favorite">Favorite</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Add Anime</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function fillTitle(value) {
    document.getElementById('animeTitle').value = value;
}

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
        customClass: {
            popup: 'rounded-4 shadow-lg border-0',
            confirmButton: 'btn btn-danger rounded-3 px-4',
            cancelButton: 'btn btn-secondary rounded-3 px-4',
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endpush
