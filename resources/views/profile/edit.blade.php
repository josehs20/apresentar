@extends('layouts.admin')
@section('title', 'Perfil')

@section('content')
<div class="page-header">
    <div>
        <h3>Meu Perfil</h3>
        <p>Gerencie suas informações pessoais.</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        {{-- Profile Information --}}
        <div class="card card-custom mb-4">
            <div class="card-header">
                <i class="bi bi-person me-2"></i>Informações do Perfil
            </div>
            <div class="card-body p-5">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <x-form.input name="name" label="Nome" required value="{{ old('name', $user->name ?? '') }}" placeholder="Seu nome" />
                    <x-form.input name="email" label="Email" type="email" required value="{{ old('email', $user->email ?? '') }}" placeholder="seu@email.com" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="alert alert-warning">
                            {{ __('Seu email não foi verificado.') }}
                            <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-link text-warning text-decoration-underline">
                                    {{ __('Clique aqui para reenviar.') }}
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-4 d-flex gap-2 align-items-center">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i>Salvar
                        </button>
                        @if (session('status') === 'profile-updated')
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>{{ __('Salvo.') }}</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="card card-custom mb-4">
            <div class="card-header">
                <i class="bi bi-lock me-2"></i>Alterar Senha
            </div>
            <div class="card-body p-5">
                <p class="text-muted" style="font-size:13px;">Deixe em branco para manter a senha atual.</p>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <x-form.input name="current_password" label="Senha Atual" type="password" placeholder="••••••••" />
                    <x-form.input name="password" label="Nova Senha" type="password" placeholder="••••••••" />
                    <x-form.input name="password_confirmation" label="Confirmar Senha" type="password" placeholder="••••••••" />

                    <div class="mt-4 d-flex gap-2 align-items-center">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i>Atualizar Senha
                        </button>
                        @if (session('status') === 'password-updated')
                            <span class="text-success"><i class="bi bi-check-circle me-1"></i>{{ __('Senha atualizada.') }}</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        {{-- Delete Account --}}
        <!-- <div class="card card-custom border-danger">
            <div class="card-header bg-danger bg-opacity-10 text-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>Excluir Conta
            </div>
            <div class="card-body p-5">
                <p class="text-muted mb-4">Uma vez excluída, sua conta e todos os dados serão permanentemente deletados. Baixe qualquer informação que deseja manter antes.</p>
                <button type="button" class="btn btn-danger-custom" data-bs-toggle="modal" data-bs-target="#modalDeleteAccount">
                    <i class="bi bi-trash me-1"></i>Excluir Conta
                </button>
            </div>
        </div> -->

        {{-- Delete Confirmation Modal --}}
        <div class="modal fade modal-custom" id="modalDeleteAccount" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir sua conta? Esta ação é <strong>irreversível</strong>.</p>
                        <form method="post" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')
                            <x-form.input name="password" label="Confirme com sua senha" type="password" placeholder="••••••••" />
                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="btn btn-outline-custom" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger-custom">
                                    <i class="bi bi-trash me-1"></i>Excluir Permanentemente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection