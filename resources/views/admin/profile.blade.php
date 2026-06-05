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
        <div class="card card-custom">
            <div class="card-body p-5">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="text-center mb-5">
                        <div class="position-relative d-inline-block">
                            <div class="topbar-avatar" style="width:80px;height:80px;font-size:32px;">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </div>
                            <div class="position-absolute bottom-0 end-0">
                                <label for="photo" class="btn btn-sm btn-primary-custom rounded-circle p-1" style="width:28px;height:28px;cursor:pointer;">
                                    <i class="bi bi-camera"></i>
                                </label>
                                <input type="file" name="photo" id="photo" class="d-none" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <x-form.input
                                name="name"
                                label="Nome"
                                value="{{ Auth::user()->name ?? '' }}"
                                required
                            />
                        </div>
                        <div class="col-md-6">
                            <x-form.input
                                name="email"
                                label="Email"
                                type="email"
                                value="{{ Auth::user()->email ?? '' }}"
                                required
                            />
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-semibold mb-3">Alterar Senha</h6>
                    <p class="text-muted" style="font-size:13px;">Deixe em branco para manter a senha atual.</p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <x-form.input
                                name="current_password"
                                label="Senha Atual"
                                type="password"
                                placeholder="••••••••"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input
                                name="password"
                                label="Nova Senha"
                                type="password"
                                placeholder="••••••••"
                            />
                        </div>
                        <div class="col-md-4">
                            <x-form.input
                                name="password_confirmation"
                                label="Confirmar Senha"
                                type="password"
                                placeholder="••••••••"
                            />
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary-custom">
                            <i class="bi bi-check-lg me-1"></i>Salvar Alterações
                        </button>
                        <button type="reset" class="btn btn-outline-custom">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection