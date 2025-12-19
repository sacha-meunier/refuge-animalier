<?php

use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public array $columns = [];
    public array $data = [];
    public bool $showCheckbox = true;
    public bool $showActions = true;
    public bool $enablePagination = false;
};
?>

<div>
    <table class="w-full h-14 border-b border-border">
        <thead class="h-14 border-b border-border">
        <tr>
            @if($showCheckbox)
                <livewire:cell
                    tag="th"
                    type="checkbox"
                    class="w-12 pl-6 pr-4"
                />
            @endif

            @foreach($columns as $column)
                <livewire:cell
                    tag="th"
                    type="text"
                    :content="$column['label'] ?? ''"
                    :class="$column['class'] ?? ''"
                />
            @endforeach

            @if($showActions)
                <livewire:cell
                    tag="th"
                    type="text"
                    content=""
                    class="w-12 pl-4 pr-1"
                />
            @endif
        </tr>
        </thead>
        <tbody class="divide-y divide-border">
        @forelse($data as $row)
            <tr class="h-14 hover:bg-muted/50 transition-colors">
                @if($showCheckbox)
                    <livewire:cell
                        type="checkbox"
                        class="w-12 pl-6 pr-4"
                    />
                @endif

                @foreach($columns as $column)
                    @php
                        $key = $column['key'] ?? '';
                        $type = $column['type'] ?? 'text';
                        $value = data_get($row, $key);
                        $muted = $column['muted'] ?? false;
                    @endphp

                    <livewire:cell
                        :type="$type"
                        :content="$value"
                        :muted="$muted"
                        :avatar="$type === 'avatar-text' ? data_get($row, $column['avatarKey'] ?? 'avatar') : null"
                        :badgeVariant="$column['badgeVariant'] ?? 'default'"
                    />
                @endforeach

                @if($showActions)
                    <livewire:cell type="button"/>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columns) + ($showCheckbox ? 1 : 0) + ($showActions ? 1 : 0) }}"
                    class="h-32 text-center text-sm text-muted-foreground">
                    {{ __('No data available') }}
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @if($enablePagination)
        {{-- Placeholder for pagination component --}}
         {{--{{ $data->links() }}--}}
    @endif
</div>

