<x-guest-layout>
    {{-- Status da sessão --}}
    <x-auth-session-status class="alert alert-success mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold" style="font-size:14px;color:var(--dark);">
                <i class="bi bi-envelope me-1" style="color:var(--secondary);"></i>Email
            </label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="background:var(--light);border-color:rgba(107,79,58,0.15);color:var(--secondary);">
                    <i class="bi bi-envelope"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="form-control border-start-0 @error('email') is-invalid @enderror"
                    style="background:var(--light);border-color:rgba(107,79,58,0.15);padding:12px 16px;font-size:14px;"
                    placeholder="seu@email.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        {{-- Senha --}}
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold" style="font-size:14px;color:var(--dark);">
                <i class="bi bi-lock me-1" style="color:var(--secondary);"></i>Senha
            </label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="background:var(--light);border-color:rgba(107,79,58,0.15);color:var(--secondary);">
                    <i class="bi bi-lock"></i>
                </span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="form-control border-start-0 @error('password') is-invalid @enderror"
                    style="background:var(--light);border-color:rgba(107,79,58,0.15);padding:12px 16px;font-size:14px;"
                    placeholder="Sua senha">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        {{-- Lembrar-me --}}
        <div class="mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember" class="form-check-input"
                    style="border-color:rgba(107,79,58,0.25);border-radius:4px;cursor:pointer;">
                <label for="remember_me" class="form-check-label" style="font-size:14px;color:#666;cursor:pointer;">
                    Lembrar de mim
                </label>
            </div>
        </div>

        {{-- Ações --}}
        <div class="d-flex flex-column gap-3">
            <button type="submit" class="btn w-100 fw-semibold" style="background:var(--primary);color:#fff;padding:12px;border-radius:var(--radius-sm);font-size:15px;transition:all var(--transition);border:none;">
                <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
            </button>

            <div class="text-center">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none" style="font-size:13px;color:var(--secondary);transition:color var(--transition);">
                        <i class="bi bi-question-circle me-1"></i>Esqueceu sua senha?
                    </a>
                @endif
            </div>

            <hr style="border-color:rgba(107,79,58,0.1);margin:4px 0;">

            <p class="text-center mb-0" style="font-size:14px;color:#888;">
                Ainda não tem conta?
                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none" style="color:var(--accent);transition:color var(--transition);">
                    Cadastre-se <i class="bi bi-arrow-right"></i>
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>