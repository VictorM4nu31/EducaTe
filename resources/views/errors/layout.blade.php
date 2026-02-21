<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('code', 'Error') — EducaTe</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800|outfit:400,500,600,700,800|space-grotesk:700"
        rel="stylesheet">

    <style>
        :root {
            --blue: #3b82f6;
            --blue-dark: #2563eb;
            --blue-glow: rgba(59, 130, 246, 0.4);
            --green: #22c55e;
            --bg: #0b1120;
            --surface: rgba(30, 41, 59, 0.7);
            --border: rgba(255, 255, 255, 0.1);
            --text: #f8fafc;
            --muted: #cbd5e1;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
            font-family: 'Outfit', system-ui, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        /* ── Background ──────────────────────────────────── */
        .bg-blobs {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .bg-blobs::before,
        .bg-blobs::after {
            content: '';
            position: absolute;
            border-radius: 9999px;
            filter: blur(140px);
            animation: blobPulse 10s ease-in-out infinite alternate;
        }

        .bg-blobs::before {
            width: 70%;
            height: 70%;
            top: -25%;
            left: -15%;
            background: rgba(59, 130, 246, 0.15);
        }

        .bg-blobs::after {
            width: 65%;
            height: 65%;
            bottom: -25%;
            right: -15%;
            background: rgba(34, 197, 94, 0.12);
            animation-delay: 5s;
        }

        @keyframes blobPulse {
            from {
                opacity: 0.6;
                transform: scale(0.9) translate(0px, 0px);
            }

            to {
                opacity: 1;
                transform: scale(1.1) translate(20px, 20px);
            }
        }

        /* ── Layout ──────────────────────────────────── */
        .error-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            text-align: center;
        }

        /* ── Logo ──────────────────────────────────── */
        .logo {
            position: fixed;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -0.02em;
            color: var(--text);
            display: flex;
            align-items: center;
            gap: 0.4rem;
            z-index: 50;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        }

        .logo-dot {
            color: var(--blue);
            text-shadow: 0 0 15px var(--blue-glow);
        }

        /* ── Glassmorphism Card ────────────────────────── */
        .card {
            background: var(--surface);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--border);
            border-radius: 2rem;
            padding: 4rem 3rem;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            animation: cardAppear 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px) scale(0.95);
        }

        @keyframes cardAppear {
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.5), transparent);
        }

        /* ── Error code ──────────────────────────────────── */
        .error-code-wrap {
            position: relative;
            margin-bottom: 2rem;
            line-height: 1;
            display: inline-block;
        }

        .error-code-bg {
            font-size: clamp(8rem, 25vw, 15rem);
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            color: var(--blue);
            opacity: 0.04;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
        }

        .error-code {
            font-size: clamp(4.5rem, 15vw, 8.5rem);
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #22c55e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
            letter-spacing: -0.05em;
            text-shadow: 0 10px 30px rgba(59, 130, 246, 0.3);
            filter: drop-shadow(0px 4px 15px rgba(59, 130, 246, 0.4));
        }

        /* ── Text ──────────────────────────────────── */
        .error-title {
            font-size: clamp(1.8rem, 5vw, 2.5rem);
            font-weight: 800;
            color: var(--text);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .error-subtitle {
            font-size: 1.1rem;
            color: #93c5fd;
            font-weight: 500;
            margin-bottom: 1.5rem;
            letter-spacing: 0.01em;
        }

        .error-description {
            font-size: 1.05rem;
            color: var(--muted);
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        /* ── Buttons ──────────────────────────────────── */
        .btn-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.8rem 1.8rem;
            border-radius: 9999px;
            /* Pill shape */
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
            color: #fff;
            box-shadow: 0 4px 15px var(--blue-glow), inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--blue-glow), inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text);
            border: 1px solid var(--border);
            backdrop-filter: blur(10px);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        /* ── Badge ──────────────────────────────────── */
        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .badge-red {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
            text-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
        }

        .badge-orange {
            background: rgba(249, 115, 22, 0.15);
            color: #fdba74;
            border: 1px solid rgba(249, 115, 22, 0.3);
            text-shadow: 0 0 10px rgba(249, 115, 22, 0.5);
        }

        .badge-yellow {
            background: rgba(234, 179, 8, 0.15);
            color: #fde047;
            border: 1px solid rgba(234, 179, 8, 0.3);
            text-shadow: 0 0 10px rgba(234, 179, 8, 0.5);
        }

        .badge-blue {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
            border: 1px solid rgba(59, 130, 246, 0.3);
            text-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
        }

        .badge-green {
            background: rgba(34, 197, 94, 0.15);
            color: #86efac;
            border: 1px solid rgba(34, 197, 94, 0.3);
            text-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
        }

        .badge-dot {
            width: 0.5rem;
            height: 0.5rem;
            border-radius: 9999px;
            background: currentColor;
            box-shadow: 0 0 8px currentColor;
        }

        @media (max-width: 640px) {
            .card {
                padding: 3rem 1.5rem;
                border-radius: 1.5rem;
            }

            .btn-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <div class="bg-blobs"></div>

    <a href="{{ url('/') }}" class="logo">
        Educa<span class="logo-dot">Te</span>
    </a>

    <main class="error-page">
        <div class="card">
            {{-- Badge ──────────────────────────────────── --}}
            @hasSection('badge')
                @yield('badge')
            @endif

            {{-- Code ──────────────────────────────────── --}}
            <div class="error-code-wrap">
                <span class="error-code-bg">@yield('code')</span>
                <span class="error-code">@yield('code')</span>
            </div>

            {{-- Title ──────────────────────────────────── --}}
            <h1 class="error-title">@yield('title')</h1>

            {{-- Subtitle ──────────────────────────────────── --}}
            @hasSection('subtitle')
                <p class="error-subtitle">@yield('subtitle')</p>
            @endif

            {{-- Description ──────────────────────────────────── --}}
            <p class="error-description">@yield('description')</p>

            {{-- Actions ──────────────────────────────────── --}}
            <div class="btn-group">
                @hasSection('extra_action')
                    @yield('extra_action')
                @endif
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12L12 2.25 21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Ir al Inicio
                </a>
                <button
                    onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'"
                    class="btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Regresar
                </button>
            </div>
        </div>
    </main>
</body>

</html>