@extends('layouts.admin')
@section('title', 'Blog')

@section('content')
<div class="page-header">
    <div>
        <h3>Blog</h3>
        <p>Gerencie as postagens do blog.</p>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-1"></i>Nova Postagem
    </a>
</div>

{{-- Filtro --}}
<div class="card card-custom mb-4">
    <div class="card-body">
        <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.posts.index') }}">
            <div class="col-md-8">
                <label class="form-label form-label-custom">Buscar</label>
                <input type="text" name="search" class="form-control form-custom" placeholder="Título ou resumo..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom flex-grow-1"><i class="bi bi-search me-1"></i>Filtrar</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-custom"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom">
    <div class="card-body p-0">
        <div id="tablePostsContainer">
            @include('admin.posts.table', ['postagens' => $postagens])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() { $('#tabelaPosts').DataTable({ order: [] }); });

    function deletarPost(id) {
        if (!confirm('Tem certeza que deseja excluir esta postagem?')) return;
        axios.delete(`/admin/posts/${id}`)
            .then(response => {
                toastr.success(response.data.message);
                reloadTable('tablePostsContainer', '{{ route("admin.posts.table") }}', 'tabelaPosts');
            })
            .catch(error => toastr.error(error.response?.data?.message || 'Erro ao excluir.'));
    }
    
</script>
@if(session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif
@endpush