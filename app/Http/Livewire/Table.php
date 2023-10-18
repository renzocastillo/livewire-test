<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Table extends Component
{
    use WithPagination;

    protected $listeners = [ 'formClosed' => 'closeForm' ];

    public int $perPage = 10;

    public bool $isFormOpen = false;

    public string $sortBy = 'id';

    public string $sortDirection = 'desc';

    public array $perPageOptions = [
        10,
        20,
        50
    ];

    public array $indexColumns = [
        'id',
        'name',
        'email'
    ];

    public array $indexLabels = [
        'ID',
        'Name',
        'Email'
    ];

    public string $search = '';

    public array $searchableColumns = [
        'name',
        'email',
    ];


    /**
     * Sorts the table by a given column.
     *
     * @param string $column
     * @return void
     */
    public function sort($column)
    {
        if ($column === $this->sortBy) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }


    /**
     * Renders the table component.
     *
     * @return Application|Factory|View
     */
    public function render() {
        $results = User::search( $this->search, $this->searchableColumns )
                       ->orderBy( $this->sortBy, $this->sortDirection )
                       ->paginate( $this->perPage );

        return view( 'livewire.table', [
            'results' => $results,
        ] );
    }

    /**
     * Updates the pagination property
     *
     * @param int $value
     * @return void
     */
    public function updatedPerPage(int $value){
        $this->resetPage();
    }

    /**
     * Creates a user.
     */
    public function create(){
        // We emit an event to open the form
        $this->emit('formOpened', [
            'id' => null,
        ]);
        $this->isFormOpen = true;
    }

    /**
     * Edit a user
     */
    public function edit(int $id): void {
        $this->emit('formOpened', [
            'id' => $id,
        ]);
        $this->isFormOpen = true;
    }

    /**
     * Delete a user
     */
    public function delete(int $id): void {
        User::destroy( $id );
    }

    /**
     * Closes the form
     */
    public function closeForm(): void {
        $this->isFormOpen = false;
    }

}
