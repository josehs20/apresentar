@props(['rows' => 0])

@if($rows === 0)
    <div class="text-center text-muted py-4">
        <em>Nenhum registro encontrado.</em>
    </div>
@endif