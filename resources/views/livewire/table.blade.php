<div>
    <div class="table-actions">
        <button wire:click="create">Create</button>
        <input type="text" wire:model="search" placeholder="Search...">
        <div class="table-pagination-options">
            <span>Per Page:</span>
            <select wire:model="perPage">
                @foreach($perPageOptions as $option)
                    <option value="{{ $option }}" wire:click="paginateTable({{$option}})">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="table-content">
        <table>
            <thead>
            <tr>
                @foreach($indexLabels as $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody wire:loading.class="table-loading">
            @forelse ($results as $row)
                <tr>
                    @foreach($indexColumns as $col)
                        <td>{{ $row->$col }}</td>
                    @endforeach
                    <td>
                        <button wire:click="edit({{ $row->id }})">Edit</button>
                        <button wire:click="delete({{ $row->id }})">Delete</button>
                    </td>
                </tr>
            @empty
                <td>No results found</td>
            @endforelse
            </tbody>
        </table>
        @if($isFormOpen)
            @livewire('table-form')
        @endif

    </div>
    <div class="table-pagination-links">
        {{ $results->links() }}
    </div>
</div>

<style scoped>
    .table-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-loading {
        opacity: 0.5;
        color: blue;
    }
</style>
