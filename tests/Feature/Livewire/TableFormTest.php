<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\TableForm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TableFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_create_a_new_user()
    {
        Livewire::test(TableForm::class)
                ->set('name', 'John Doe')
                ->set('email', 'john@example.com')
                ->call('store')
                ->assertEmitted('formClosed');

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function test_it_can_edit_an_existing_user()
    {
        $user = User::factory()->create();

        Livewire::test(TableForm::class)
                ->set('formId', $user->id)
                ->set('name', 'Updated Name')
                ->set('email', 'updated@example.com')
                ->call('edit')
                ->assertEmitted('formClosed');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_it_validates_required_fields()
    {
        Livewire::test(TableForm::class)
                ->set('name', '')
                ->set('email', '')
                ->call('store')
                ->assertHasErrors(['name', 'email']);
    }

    public function test_it_validates_email_uniqueness()
    {
        $existingUser = User::factory()->create();

        Livewire::test(TableForm::class)
                ->set('name', 'New User')
                ->set('email', $existingUser->email)
                ->call('store')
                ->assertHasErrors(['email']);
    }

    public function test_it_validates_email_uniqueness_when_editing()
    {
        $existingUser = User::factory()->create();
        $userToEdit = User::factory()->create();

        Livewire::test(TableForm::class)
                ->set('formId', $userToEdit->id)
                ->set('name', 'Updated User')
                ->set('email', $existingUser->email)
                ->call('edit')
                ->assertHasErrors(['email']);
    }
}
