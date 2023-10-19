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
    public string $name = '';
    public string $email = '';
    public $birthday = null;
    public string $action = 'store';

    protected array $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email|unique:users,email',
        'birthday'=> 'nullable'
    ];

    /**
     * Renders the table form component.
     *
     * @param array $data
     *
     * @return Factory|View|Application
     */
    public function render( array $data =[]): View|Factory|Application {
        if ( ! empty( $data ) && isset( $data['id'] )) {
            $id = $data['id'];
            if ($id >0) {
                $this->action = 'edit';
                $user        = User::find( $id );
                $this->form_id = $user->id;
                $this->name  = $user->name;
                $this->email = $user->email;
                $this->birthday = optional($user->birthday)->format('d/m/y');
            }else{
                $this->form_id = 0;
            }
        }
        return view( 'livewire.table-form');
    }

    /**
     * Edits a record.
     *
     * @return void
     */
    public function edit(): void {
        $id= $this->form_id;
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
    public function store(): void {
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
