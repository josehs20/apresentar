@props([
    'headers' => [],
    'rows' => null,
    'empty' => 'Nenhum registro encontrado.',
    'class' => '',
    'id' => null,
])

<div class="table-responsive {{ $class }}">
    <table class="table table-admin mb-0" @if($id) id="{{ $id }}" @endif>
        @if(count($headers) > 0)
        <thead>
            <tr>
                @foreach($headers as $header)
                <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        @endif
        <tbody>
            @php
                $hasRows = $rows !== null ? count($rows) > 0 : !empty(trim($slot ?? ''));
            @endphp
            @if($hasRows)
                {{ $slot ?? '' }}
            @else
                <tr>
                    <td colspan="{{ count($headers) }}" class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        <em>{{ $empty }}</em>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
