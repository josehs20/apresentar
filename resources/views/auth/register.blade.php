<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nome --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold" style="font-size:14px;color:var(--dark);">
                <i class="bi bi-person me-1" style="color:var(--secondary);"></i>Nome
            </label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="background:var(--light);border-color:rgba(107,79,58,0.15);color:var(--secondary);">
                    <i class="bi bi-person"></i>
                </span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="form-control border-start-0 @error('name') is-invalid @enderror"
                    style="background:var(--light);border-color:rgba(107,79,58,0.15);padding:12px 16px;font-size:14px;"
                    placeholder="Seu nome completo">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold" style="font-size:14px;color:var(--dark);">
                <i class="bi bi-envelope me-1" style="color:var(--secondary);"></i>Email
            </label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="background:var(--light);border-color:rgba(107,79,58,0.15);color:var(--secondary);">
                    <i class="bi bi-envelope"></i>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
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
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="form-control border-start-0 @error('password') is-invalid @enderror"
                    style="background:var(--light);border-color:rgba(107,79,58,0.15);padding:12px 16px;font-size:14px;"
                    placeholder="No mínimo 8 caracteres">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        {{-- Confirmar Senha --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold" style="font-size:14px;color:var(--dark);">
                <i class="bi bi-lock-fill me-1" style="color:var(--secondary);"></i>Confirmar Senha
            </label>
            <div class="input-group">
                <span class="input-group-text border-end-0" style="background:var(--light);border-color:rgba(107,79,58,0.15);color:var(--secondary);">
                    <i class="bi bi-lock-fill"></i>
                </span>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="form-control border-start-0 @error('password_confirmation') is-invalid @enderror"
                    style="background:var(--light);border-color:rgba(107,79,58,0.15);padding:12px 16px;font-size:14px;"
                    placeholder="Repita a senha">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        {{-- Ações --}}
        <div class="d-flex flex-column gap-3">
            <button type="submit" class="btn w-100 fw-semibold" style="background:var(--accent);color:#fff;padding:12px;border-radius:var(--radius-sm);font-size:15px;transition:all var(--transition);border:none;">
                <i class="bi bi-person-plus me-2"></i>Criar Conta
            </button>

            <hr style="border-color:rgba(107,79,58,0.1);margin:4px 0;">

            <p class="text-center mb-0" style="font-size:14px;color:#888;">
                Já tem conta?
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none" style="color:var(--accent);transition:color var(--transition);">
                    Faça login <i class="bi bi-arrow-right"></i>
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>