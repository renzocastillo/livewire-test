<?php

namespace App\Http\Livewire;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;


class TableForm extends Component
{
    protected $listeners = [ 'formOpened' => 'render' ];

    public $form_id = 0;
    public string $action = 'store';
    public User $user;

    protected array $rules = [
        'user.name' => "required|min:6",
        'user.email' => "required|email|unique:users,email",
        'user.birthday'=> "sometimes"
    ];

    /**
     * @return void
     */
    public function mount()
    {
        $this->user = new User();
    }

    /**
     * Renders the table form component.
     *
     * @param array $data
     *
     * @return Factory|View|Application
     */
    public function render( array $data =[]): View|Factory|Application {
        if ( ! empty( $data ) && !empty( $data['id'] )) {
            $id = $data['id'];
            $this->action = 'edit';
            $this->user        = User::find( $id );
        }
        return view( 'livewire.table-form');
    }

    /**
     * Edits a record.
     *
     * @return void
     */
    public function edit(): void {
        // Create a copy of the rule array and update the 'email' rule with the 'ignore' parameter
        $editRules = $this->rules;
        $editRules['user.email'] = [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($this->user->id),
        ];
        $this->validate($editRules);
        $this->user->save();

        $this->emit('formClosed');
    }

    /**
     * Creates a new record.
     *
     * @return void
     */
    public function store(): void {
        // Validate the form data
        $this->validate();

        $user = $this->user;
        $user->password = Hash::make(Str::random(8));
        $user->save();

        $this->emit('formClosed');
    }

}
