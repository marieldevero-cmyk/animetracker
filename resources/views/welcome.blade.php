<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Anime Ghibli Tracker') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|fredoka:400,500,600,700" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                *{margin:0;padding:0;box-sizing:border-box}
                body{font-family:'Fredoka','Instrument Sans',system-ui,sans-serif;background:linear-gradient(135deg,#0f0e17,#1a1a2e,#16213e);color:#fff;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2rem;position:relative;overflow-x:hidden}
                body::before{content:'';position:fixed;inset:0;background:radial-gradient(ellipse at 20% 50%,rgba(232,168,124,0.08) 0%,transparent 60%),radial-gradient(ellipse at 80% 20%,rgba(243,194,107,0.06) 0%,transparent 50%);pointer-events:none}
                .container{max-width:480px;width:100%;text-align:center;position:relative;z-index:1}
                .logo{display:inline-flex;align-items:center;gap:12px;margin-bottom:24px}
                .logo svg{width:40px;height:40px;color:#f3c26b}
                .logo span{font-family:'Fredoka',system-ui,sans-serif;font-size:1.5rem;font-weight:600;letter-spacing:-0.02em}
                h1{font-family:'Fredoka',system-ui,sans-serif;font-size:2.5rem;font-weight:700;margin-bottom:8px;background:linear-gradient(135deg,#f3c26b,#e8a87c);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
                p{color:rgba(255,255,255,0.6);font-size:1rem;margin-bottom:32px;line-height:1.6}
                .actions{display:flex;gap:12px;justify-content:center;flex-wrap:wrap}
                .btn{display:inline-flex;align-items:center;gap:8px;padding:12px 28px;border-radius:12px;font-weight:600;font-size:0.95rem;text-decoration:none;transition:all .25s ease;cursor:pointer}
                .btn-primary{display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border:none;border-radius:50px;font-family:'Fredoka',system-ui,sans-serif;font-weight:600;font-size:1.05rem;color:var(--ghibli-dark);background:linear-gradient(135deg,#f3c26b,#e8a87c);box-shadow:0 4px 20px rgba(243,194,107,0.3),0 2px 0 0 rgba(0,0,0,0.08);cursor:pointer;text-decoration:none;transition:all .25s cubic-bezier(0.34,1.56,0.64,1);position:relative;overflow:hidden}
                .btn-primary::after{content:'';position:absolute;top:0;left:0;right:0;height:50%;background:linear-gradient(180deg,rgba(255,255,255,0.3) 0%,transparent 100%);border-radius:50px 50px 0 0;pointer-events:none}
                .btn-primary:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 8px 28px rgba(243,194,107,0.4)}
                .btn-outline{display:inline-flex;align-items:center;gap:8px;padding:14px 32px;border:2px solid rgba(255,255,255,0.15);border-radius:50px;font-family:'Fredoka',system-ui,sans-serif;font-weight:600;font-size:1.05rem;color:#fff;background:rgba(255,255,255,0.04);cursor:pointer;text-decoration:none;transition:all .25s cubic-bezier(0.34,1.56,0.64,1)}
                .btn-outline:hover{background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.3);transform:translateY(-2px)}
                .footer{margin-top:48px;color:rgba(255,255,255,0.3);font-size:0.85rem}
            </style>
        @endif
    </head>
    <body>
        <div class="container">
            <div class="logo">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18"/><path d="M3 7h18"/><path d="M7 3v12"/><path d="M17 3v12"/><path d="M5 15h14"/><path d="M9 15v6"/><path d="M15 15v6"/></svg>
                <span>Anime Ghibli Tracker</span>
            </div>
            <h1>Your Ghibli Journey Begins</h1>
            <p>Track every Studio Ghibli film you've watched,<br>discover new favorites, and build your collection.</p>
            <div class="actions">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline">Create Account</a>
                        @endif
                    @endauth
                @endif
            </div>
            <div class="footer">
                Anime Ghibli Tracker &mdash; Track your Studio Ghibli collection
            </div>
        </div>
    </body>
</html>
