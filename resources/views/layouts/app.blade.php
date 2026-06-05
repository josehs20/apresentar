<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('meta_title', config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Descubra nossos produtos naturais.')">
    <meta property="og:title" content="@yield('meta_title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', 'Descubra nossos produtos naturais.')">
    <meta property="og:image" content="@yield('meta_image', '')">
    <meta property="og:type" content="website">

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
        body { color: var(--dark); overflow-x: hidden; }

        /* ===== HEADER ===== */
        .site-header {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
            background: rgba(245,241,235,0.95); backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(43,43,43,0.06); transition: all var(--transition);
        }
        .site-header.scrolled {
            background: rgba(255,255,255,0.97); box-shadow: 0 2px 20px rgba(43,43,43,0.08);
        }
        .site-brand {
            font-weight: 700; font-size: 20px; color: var(--primary); text-decoration: none; letter-spacing: -0.02em;
        }
        .site-nav .nav-link {
            color: var(--dark); font-weight: 500; font-size: 14px; padding: 8px 16px;
            border-radius: var(--radius-sm); transition: all var(--transition);
        }
        .site-nav .nav-link:hover, .site-nav .nav-link.active {
            color: var(--primary); background: rgba(107,79,58,0.06);
        }
        .btn-whatsapp {
            background: #25D366; border: none; color: #fff; font-weight: 600; font-size: 14px;
            padding: 10px 20px; border-radius: var(--radius-sm); transition: all var(--transition);
            display: inline-flex; align-items: center; gap: 8px; text-decoration: none;
        }
        .btn-whatsapp:hover { background: #20BD5A; color: #fff; transform: translateY(-1px); box-shadow: 0 4px 15px rgba(37,211,102,0.3); }

        /* ===== HERO ===== */
        .hero-section {
            min-height: 90vh; display: flex; align-items: center; padding-top: 80px;
            background: linear-gradient(135deg, var(--light) 0%, #EDE7DE 50%, var(--light) 100%);
            position: relative; overflow: hidden;
        }
        .hero-section::before {
            content: ''; position: absolute; top: -50%; right: -10%; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(166,124,82,0.1) 0%, transparent 70%); border-radius: 50%;
        }
        .hero-title {
            font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 700; line-height: 1.1;
            color: var(--dark); letter-spacing: -0.03em;
        }
        .hero-title span { color: var(--primary); }
        .hero-subtitle { font-size: 1.125rem; color: #6b6b6b; line-height: 1.7; max-width: 500px; }
        .btn-primary-custom {
            background: var(--primary); border: 2px solid var(--primary); color: #fff; font-weight: 600;
            padding: 14px 32px; border-radius: var(--radius-sm); transition: all var(--transition); font-size: 15px;
            text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary-custom:hover {
            background: var(--primary-light); border-color: var(--primary-light); color: #fff;
            transform: translateY(-2px); box-shadow: 0 6px 20px rgba(107,79,58,0.25);
        }
        .btn-outline-custom {
            background: transparent; border: 2px solid rgba(43,43,43,0.15); color: var(--dark);
            font-weight: 600; padding: 14px 32px; border-radius: var(--radius-sm); transition: all var(--transition);
            font-size: 15px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-outline-custom:hover {
            border-color: var(--primary); color: var(--primary); transform: translateY(-2px);
        }

        /* ===== CARDS ===== */
        .product-card {
            border: none; border-radius: var(--radius); overflow: hidden; background: #fff;
            box-shadow: 0 2px 12px rgba(43,43,43,0.05); transition: all var(--transition); cursor: pointer;
        }
        .product-card:hover {
            transform: translateY(-6px); box-shadow: 0 12px 30px rgba(43,43,43,0.1);
        }
        .product-card .card-img-wrapper { overflow: hidden; aspect-ratio: 4/3; background: var(--light); }
        .product-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .product-card:hover img { transform: scale(1.08); }

        .blog-card {
            border: none; border-radius: var(--radius); overflow: hidden; background: #fff;
            box-shadow: 0 2px 12px rgba(43,43,43,0.05); transition: all var(--transition);
        }
        .blog-card:hover { transform: translateY(-4px); box-shadow: 0 10px 25px rgba(43,43,43,0.1); }
        .blog-card .card-img-wrapper { overflow: hidden; aspect-ratio: 16/9; background: var(--light); }
        .blog-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .blog-card:hover img { transform: scale(1.05); }

        /* ===== CTA ===== */
        .cta-section {
            background: linear-gradient(135deg, var(--accent) 0%, #1a3d32 100%);
            color: #fff; padding: 80px 0;
        }

        /* ===== ABOUT ===== */
        .about-section { background: #fff; padding: 80px 0; }

        /* ===== FOOTER ===== */
        .site-footer {
            background: var(--dark); color: rgba(255,255,255,0.6); padding: 60px 0 24px;
        }
        .site-footer h6 { color: #fff; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 16px; }
        .site-footer a { color: rgba(255,255,255,0.6); text-decoration: none; transition: color var(--transition); font-size: 14px; }
        .site-footer a:hover { color: #fff; }
        .footer-divider { border-color: rgba(255,255,255,0.08); }

        /* ===== SCROLL TO TOP ===== */
        .scroll-top {
            position: fixed; bottom: 30px; right: 30px; width: 44px; height: 44px; border-radius: 50%;
            background: var(--primary); color: #fff; border: none; display: flex; align-items: center;
            justify-content: center; font-size: 18px; opacity: 0; pointer-events: none; transition: all var(--transition);
            box-shadow: 0 4px 12px rgba(107,79,58,0.3); z-index: 99;
        }
        .scroll-top.visible { opacity: 1; pointer-events: auto; }
        .scroll-top:hover { transform: translateY(-3px); background: var(--primary-light); }

        /* ===== UTILITIES ===== */
        .text-primary-custom { color: var(--primary); }
        .text-secondary-custom { color: var(--secondary); }
        .bg-primary-custom { background-color: var(--primary); }
        .bg-light-custom { background-color: var(--light); }

        /* ===== WHATSAPP FLOAT ===== */
        .whatsapp-float {
            position: fixed; bottom: 30px; left: 30px; width: 56px; height: 56px; border-radius: 50%;
            background: #25D366; color: #fff; border: none; font-size: 24px; display: flex;
            align-items: center; justify-content: center; z-index: 99; transition: all var(--transition);
            box-shadow: 0 4px 15px rgba(37,211,102,0.4); text-decoration: none;
        }
        .whatsapp-float:hover { transform: scale(1.1); color: #fff; box-shadow: 0 6px 20px rgba(37,211,102,0.5); }

        @media (max-width: 768px) {
            .hero-section { min-height: auto; padding: 100px 0 60px; }
            .btn-whatsapp { padding: 12px 16px; font-size: 13px; }
        }
    </style>
    @stack('styles')
</head>
<body>
    {{-- HEADER --}}
    <header class="site-header" id="siteHeader">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between py-3">
                <a href="{{ route('home') }}" class="site-brand">
                    <i class="bi bi-leaf-fill me-2" style="color:var(--accent)"></i>{{ config('app.name') }}
                </a>
                <nav class="d-none d-md-flex align-items-center gap-1 site-nav">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('catalog.index') }}" class="nav-link {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Catálogo</a>
                    <a href="{{ route('blog.index') }}" class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
                    <a href="{{ route('interacao.redirect', ['tipo' => 'whatsapp', 'produto' => 1]) }}" class="btn-whatsapp ms-3" target="_blank">
                        <svg class="d-inline-block" width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        WhatsApp
                    </a>
                </nav>
                {{-- Mobile --}}
                <div class="d-flex align-items-center gap-2 d-md-none">
                    <a href="{{ route('interacao.redirect', ['tipo' => 'whatsapp', 'produto' => 1]) }}" class="btn-whatsapp btn-sm" target="_blank">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <button class="btn p-1" onclick="document.getElementById('mobileMenu').classList.toggle('show')">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                </div>
            </div>
            {{-- Mobile Menu --}}
            <div id="mobileMenu" class="d-md-none pb-3 d-none">
                <nav class="d-flex flex-column gap-1">
                    <a href="{{ route('home') }}" class="nav-link px-3 py-2 {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('catalog.index') }}" class="nav-link px-3 py-2 {{ request()->routeIs('catalog.*') ? 'active' : '' }}">Catálogo</a>
                    <a href="{{ route('blog.index') }}" class="nav-link px-3 py-2 {{ request()->routeIs('blog.*') ? 'active' : '' }}">Blog</a>
                </nav>
            </div>
        </div>
    </header>

    {{-- MAIN --}}
    <main style="margin-top: 64px;">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h6>{{ config('app.name') }}</h6>
                    <p class="small">Produtos naturais feitos com carinho e ingredientes selecionados para cuidar de você.</p>
                </div>
                <div class="col-lg-2">
                    <h6>Links</h6>
                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('catalog.index') }}">Catálogo</a>
                        <a href="{{ route('blog.index') }}">Blog</a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h6>Contato</h6>
                    <div class="d-flex flex-column gap-2">
                        <span class="small"><i class="bi bi-geo-alt me-2"></i>Sua cidade, Brasil</span>
                        <span class="small"><i class="bi bi-envelope me-2"></i>contato@{{ config('app.name') }}.com.br</span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <h6>Redes Sociais</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('interacao.redirect', ['tipo' => 'instagram', 'produto' => 1]) }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px;height:36px;"><i class="bi bi-instagram"></i></a>
                        <a href="{{ route('interacao.redirect', ['tipo' => 'whatsapp', 'produto' => 1]) }}" target="_blank" class="btn btn-sm btn-success rounded-circle" style="width:36px;height:36px;"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <hr class="footer-divider mt-4 mb-3">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <p class="small mb-0">&copy; {{ date('Y') }} {{ config('app.name') }}. Todos os direitos reservados.</p>
                <p class="small mb-0">Feito com <i class="bi bi-heart-fill text-danger"></i></p>
            </div>
        </div>
    </footer>

    {{-- WhatsApp Float --}}
    <a href="{{ route('interacao.redirect', ['tipo' => 'whatsapp', 'produto' => 1]) }}" class="whatsapp-float" target="_blank" title="Fale no WhatsApp">
        <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
    </a>

    {{-- Scroll to Top --}}
    <button class="scroll-top" id="scrollTop" onclick="window.scrollTo({top:0,behavior:'smooth'})">
        <i class="bi bi-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('siteHeader');
            const scrollTop = document.getElementById('scrollTop');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
                scrollTop.classList.add('visible');
            } else {
                header.classList.remove('scrolled');
                scrollTop.classList.remove('visible');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>