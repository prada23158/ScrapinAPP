<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
{{-- <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script> --}}


@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

{{-- debut du css de la page agents.blade.php  --}}
<style>
    .fullscreen-bg {
        min-height: 100vh;
        background: linear-gradient(90deg, #E1A624 0%, #82CEF9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .activateagents {
        background: linear-gradient(90deg, #E1A624 0%, #82CEF9 100%);
        border: none;
        color: white;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .nav-agents {
        background: #5FACD3;
        border: 1px dotted darkcyan;
        color: white;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 20px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .nav-agents a:hover {
        background: #335F8A;
        color: white;
    }

    .card {
        position: relative;
        overflow: hidden;
        border: 1px solid #71717A;
        border-radius: 16px;
        padding: 48px;
        background: #335F8A;
        box-shadow: 0 4px 16px rgba(44, 44, 44, 0.10);
        transition: background 0.3s;
    }

    .card:hover {
        background: #2E3244;
    }

    .container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 24px;
    }

    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border-radius: 24px;
        border: 1px solid #335F8A;
        color: #F59E42;
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 24px;
        backdrop-filter: blur(2px);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.30);
    }

    .main-title {
        font-size: 48px;
        font-weight: bold;
        color: white;
        margin-bottom: 0;
        letter-spacing: -2px;
    }

    @media (max-width: 600px) {
        .header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .main-title {
            font-size: 32px;
            text-align: left;
        }

        .badge {
            font-size: 15px;
            padding: 6px 12px;
        }
    }

    .subtitle {
        display: block;
        font-size: 20px;
        font-weight: 500;
        background: linear-gradient(90deg, #FDEA96 0%, #FB7185 100%);
        color: transparent;
        -webkit-background-clip: text;
        background-clip: text;
        margin-top: 20px;
    }
</style>
{{-- fin du css de la page agents.blade.php  --}}
