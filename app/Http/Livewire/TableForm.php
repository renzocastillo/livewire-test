<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Str;


class TableForm extends Component
{
    public ?int $formId = null;
    protected $listeners = [ 'formOpened' => 'fillFormData' ];

    public string $name;
    public string $email;

    protected array $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email|unique:users,email',
    ];

    public function fillFormData($data): void {
        $this->formId = $data['id'];

        if ($this->formId) {
            $user = User::find($this->formId);
            $this->name = $user->name;
            $this->email = $user->email;
        } else {
            // If it's a new entry, initialize the properties
            $this->name = '';
            $this->email = '';
        }
    }

    /**
     * Renders the table form component.
     *
     * @return Factory|View|Application
     */
    public function render() {
        return view( 'livewire.table-form');
    }

    /**
     * Edits a record.
     *
     * @return void
     */
    public function edit() {
        $id = $this->formId;
        // Create a copy of the rule array and update the 'email' rule with the 'ignore' parameter
        $editRules = $this->rules;
        $editRules['email'] = [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($id),
        ];
        $this->validate($editRules);


        $user = User::find($id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->save();

        $this->emit('formClosed');
    }

    /**
     * Creates a new record.
     *
     * @return void
     */
    public function store() {
        // Validate the form data
        $this->validate();

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Hash::make(Str::random(8));
        $user->save();

        $this->emit('formClosed');
    }
}
