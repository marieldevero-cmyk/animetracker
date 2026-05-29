<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $usersWithAnime = User::has('animes')->count();
        $usersWithoutAnime = $totalUsers - $usersWithAnime;

        $animeByStatus = Anime::where('user_id', auth()->id())
            ->selectRaw("current_status, COUNT(*) as count")
            ->groupBy('current_status')
            ->pluck('count', 'current_status');

        $totalAnime = $animeByStatus->sum();

        return view('dashboard.index', compact('totalUsers', 'usersWithAnime', 'usersWithoutAnime', 'animeByStatus', 'totalAnime'));
    }
}
