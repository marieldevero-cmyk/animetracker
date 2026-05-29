@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4 animate-fade-in-up">
    <h2 class="fw-bold" style="color:#fff;">Welcome back, {{ auth()->user()->name }}!</h2>
    <p style="font-size:0.9rem;color:rgba(255,255,255,0.45) !important;">Here's your Ghibli collection overview.</p>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="stat-card" style="border-left:3px solid var(--ghibli-gold);background:rgba(48,44,58,0.92);">
            <div class="stat-icon" style="background:rgba(243,194,107,0.15);color:var(--ghibli-gold);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color:rgba(255,255,255,0.7);">Total Users</span>
                <span class="stat-value" style="color:#fff;">{{ $totalUsers }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-left:3px solid var(--ghibli-teal);background:rgba(48,44,58,0.92);">
            <div class="stat-icon" style="background:rgba(46,196,182,0.15);color:var(--ghibli-teal);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color:rgba(255,255,255,0.7);">Total Anime</span>
                <span class="stat-value" style="color:#fff;">{{ $totalAnime }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card" style="border-left:3px solid var(--ghibli-accent);background:rgba(48,44,58,0.92);">
            <div class="stat-icon" style="background:rgba(232,168,124,0.15);color:var(--ghibli-accent);">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="stat-body">
                <span class="stat-label" style="color:rgba(255,255,255,0.7);">Favorites</span>
                <span class="stat-value" style="color:#fff;">{{ $animeByStatus->get('Favorite', 0) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <div class="col-md-6">
        <div class="card dashboard-card border-0 h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span style="width:4px;height:18px;border-radius:3px;background:var(--ghibli-gold);"></span>
                    <h5 class="fw-semibold mb-0" style="color:#fff;font-size:0.95rem;">Total Users</h5>
                </div>
                <p class="small mb-3" style="color:rgba(255,255,255,0.5);font-family:'Instrument Sans',sans-serif;">Registered accounts on the platform</p>
                <div style="max-width: 220px; margin: 0 auto; height: 220px;">
                    <canvas id="usersChart"
                        data-with-anime="{{ $usersWithAnime }}"
                        data-without-anime="{{ $usersWithoutAnime }}">
                    </canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card dashboard-card border-0 h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span style="width:4px;height:18px;border-radius:3px;background:#2ec4b6;"></span>
                    <h5 class="fw-semibold mb-0" style="color:#fff;font-size:0.95rem;">Anime by Status</h5>
                </div>
                <p class="small mb-3" style="color:rgba(255,255,255,0.5);font-family:'Instrument Sans',sans-serif;">Breakdown of your collection</p>
                @if ($totalAnime > 0)
                <div style="max-width: 220px; margin: 0 auto; height: 220px;">
                    <canvas id="animeStatusChart"
                        data-labels='{{ json_encode($animeByStatus->keys()) }}'
                        data-counts='{{ json_encode($animeByStatus->values()) }}'>
                    </canvas>
                </div>
                @else
                <div class="text-center py-4" style="color:rgba(0,0,0,0.25);">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="mb-2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    <p class="small mb-0">No anime entries yet</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($totalAnime > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card dashboard-card border-0">
            <div class="card-body p-4">
                <h5 class="fw-semibold mb-3" style="color:#fff;font-size:0.95rem;">
                    <span style="display:inline-block;width:4px;height:16px;border-radius:3px;background:var(--ghibli-gold);margin-right:8px;vertical-align:middle;"></span>
                    Quick Overview
                </h5>
                <div class="row g-3">
                    <div class="col-4">
                        <div class="mini-stat">
                            <span class="mini-stat-value" style="color:#f3c26b;">{{ $animeByStatus->get('Watch List', 0) }}</span>
                            <span class="mini-stat-label" style="color:rgba(255,255,255,0.7) !important;">Watch List</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mini-stat">
                            <span class="mini-stat-value" style="color:#2ec4b6;">{{ $animeByStatus->get('Watched', 0) }}</span>
                            <span class="mini-stat-label" style="color:rgba(255,255,255,0.7) !important;">Watched</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="mini-stat">
                            <span class="mini-stat-value" style="color:#e8a87c;">{{ $animeByStatus->get('Favorite', 0) }}</span>
                            <span class="mini-stat-label" style="color:rgba(255,255,255,0.7) !important;">Favorites</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
