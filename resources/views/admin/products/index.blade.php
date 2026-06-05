@extends('layouts.admin')
@section('title', 'Produtos')

@section('content')
<div class="page-header">
    <div>
        <h3>Produtos</h3>
        <p>Gerencie o catálogo de produtos.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg me-1"></i>Novo Produto
    </a>
</div>

{{-- Filtros --}}
<div class="card card-custom mb-4">
    <div class="card-body">
        <form id="formFiltros" class="row g-3 align-items-end" method="GET" action="{{ route('admin.products.index') }}">
            <div class="col-md-4">
                <label class="form-label form-label-custom">Buscar</label>
                <input type="text" name="search" class="form-control form-custom" placeholder="Nome ou descrição..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label form-label-custom">Categoria</label>
                <select name="categoria_id" class="form-select form-custom">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" {{ request('categoria_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label form-label-custom">Status</label>
                <select name="ativo" class="form-select form-custom">
                    <option value="">Todos</option>
                    <option value="1" {{ request('ativo') === '1' ? 'selected' : '' }}>Ativos</option>
                    <option value="0" {{ request('ativo') === '0' ? 'selected' : '' }}>Inativos</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom flex-grow-1"><i class="bi bi-search me-1"></i>Filtrar</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-custom"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

{{-- Tabela --}}
<div class="card card-custom">
    <div class="card-body p-0">
        <div id="tableProdutosContainer">
            @include('admin.products.table', ['produtos' => $produtos])
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() { $('#tabelaProdutos').DataTable({ order: [] }); });

    function deletarProduto(id) {
        if (!confirm('Tem certeza que deseja excluir este produto?')) return;
        axios.delete(`/admin/products/${id}`)
            .then(response => {
                toastr.success(response.data.message);
                reloadTable('tableProdutosContainer', '{{ route("admin.products.table") }}', 'tabelaProdutos');
            })
            .catch(error => toastr.error(error.response?.data?.message || 'Erro ao excluir produto.'));
    }
</script>
@endpush