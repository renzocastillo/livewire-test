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
                @foreach($indexLabels as $index => $label)
                    <th>
                        <a href="#" wire:click="sort('{{ $indexColumns[$index] }}')">
                            <span class="{{ $sortBy === $indexColumns[$index] ? 'sorted' : '' }}">
                                {{ $label }}
                            </span>
                            @if ($sortBy === $indexColumns[$index])
                                <span class="{{ $sortDirection === 'asc' ? 'sorted' : '' }}">&#9650;</span>
                                <!-- Upward arrow for ascending -->
                                <span class="{{ $sortDirection === 'desc' ? 'sorted' : '' }}">&#9660;</span>
                                <!-- Downward arrow for descending -->
                            @else
                                <span>&#9650;&#9660;</span> <!-- Both arrows (not sorted) -->
                            @endif
                        </a>
                    </th>
                @endforeach
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


@push('styles')
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

        .sorted {
            color: green;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
@endpush
@push('scripts')
    <script src="https://unpkg.com/moment/moment.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
@endpush
