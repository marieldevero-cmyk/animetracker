<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Anime Ghibli Tracker')) - Anime Ghibli Tracker</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700|fredoka:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body>
    <div class="auth-split">
        <div class="auth-scene-panel" style="position:relative;">
            <div class="auth-scene-content">
                @yield('scene')
            </div>
        </div>
        <div class="auth-form-panel">
            <div class="auth-form-container">
                @yield('content')
            </div>
        </div>
    </div>

    <div id="toastContainer" class="toast-container"></div>

    @stack('scripts')

    @if (session('success'))
        <script>document.addEventListener('DOMContentLoaded', () => showGhibliToast('{{ session('success') }}', 'success'));</script>
    @endif

    <script>
    function showGhibliToast(message, type) {
        const container = document.getElementById('toastContainer');
        if (!container) return;

        const toast = document.createElement('div');
        toast.className = 'ghibli-toast ghibli-toast-' + type;

        toast.innerHTML =
            '<div class="toast-icon">' +
                '<svg width="20" height="20" viewBox="0 0 40 40" fill="none" stroke="var(--ghibli-gold)" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">' +
                    '<path d="M12 13 L10 4 L17 10.5"/><path d="M28 13 L30 4 L23 10.5"/>' +
                    '<ellipse cx="20" cy="24" rx="11" ry="12"/>' +
                    '<ellipse cx="20" cy="28" rx="5.5" ry="4.5" stroke="rgba(243,194,107,0.3)"/>' +
                    '<circle cx="15" cy="20" r="3" fill="var(--ghibli-gold)" stroke="none"/>' +
                    '<circle cx="25" cy="20" r="3" fill="var(--ghibli-gold)" stroke="none"/>' +
                    '<circle cx="14" cy="19" r="1.2" fill="#1a1a2e" stroke="none"/>' +
                    '<circle cx="24" cy="19" r="1.2" fill="#1a1a2e" stroke="none"/>' +
                    '<circle cx="20" cy="23.5" r="1.2" fill="var(--ghibli-gold)" stroke="none"/>' +
                '</svg>' +
            '</div>' +
            '<div class="toast-body">' +
                '<div class="toast-message">' + message + '</div>' +
            '</div>' +
            '<button class="toast-close" onclick="this.parentElement.remove()">' +
                '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>' +
            '</button>';

        container.appendChild(toast);

        requestAnimationFrame(() => toast.classList.add('show'));
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    }
    </script>
</body>
</html>
