<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #6B4F3A;
            --primary-light: #8B6F5A;
            --secondary: #A67C52;
            --accent: #2E5E4E;
            --accent-light: #3A7A66;
            --light: #F5F1EB;
            --dark: #2B2B2B;
            --radius: 12px;
            --radius-sm: 8px;
            --transition: 0.3s ease;
        }
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, var(--light) 0%, #EDE7DE 50%, var(--light) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }
        body::before {
            content: '';
            position: fixed;
            top: -30%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(166,124,82,0.12) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(46,94,78,0.10) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .auth-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(107,79,58,0.08);
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(43,43,43,0.08);
            width: 100%;
            max-width: 440px;
            padding: 40px 36px;
            position: relative;
            z-index: 1;
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 32px;
        }
        .auth-brand .brand-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
        }
        .auth-brand .brand-icon i {
            font-size: 24px;
            color: #fff;
        }
        .auth-brand h1 {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 4px;
        }
        .auth-brand p {
            font-size: 14px;
            color: #888;
            margin-bottom: 0;
        }

        /* Nature decorative leaf */
        .auth-leaf {
            position: absolute;
            opacity: 0.06;
            pointer-events: none;
        }
        .auth-leaf-1 {
            top: -20px;
            right: -10px;
            font-size: 80px;
            color: var(--accent);
            transform: rotate(30deg);
        }
        .auth-leaf-2 {
            bottom: -15px;
            left: -10px;
            font-size: 60px;
            color: var(--primary);
            transform: rotate(-20deg);
        }

        @media (max-width: 480px) {
            .auth-card {
                padding: 28px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-leaf auth-leaf-1">
            <i class="bi bi-flower2"></i>
        </div>
        <div class="auth-leaf auth-leaf-2">
            <i class="bi bi-leaf"></i>
        </div>

        <div class="auth-brand">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <div class="brand-icon">
                    <i class="bi bi-leaf-fill"></i>
                </div>
                <h1>{{ config('app.name') }}</h1>
                <p>Produtos Naturais</p>
            </a>
        </div>

        {{ $slot }}
    </div>
</body>
</html>