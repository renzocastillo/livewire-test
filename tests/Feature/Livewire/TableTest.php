<?php

namespace Tests\Feature\Livewire;

use App\Http\Livewire\Table;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TableTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_render_table_component()
    {
        Livewire::test(Table::class)->assertStatus(200);
    }

    public function test_it_can_open_form()
    {
        Livewire::test(Table::class)
                ->call('create')
                ->assertSet('isFormOpen', true);
    }

    public function test_it_can_close_form()
    {
        Livewire::test(Table::class)
                ->call('create')
                ->call('closeForm')
                ->assertSet('isFormOpen', false);
    }

    public function test_it_can_delete_user()
    {
        $user = User::factory()->create();

        Livewire::test(Table::class)
                ->call('delete', $user->id)
                ->assertDontSee($user->name);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_it_can_search_users()
    {
        $user1 = User::factory()->create(['name' => 'John', 'email' => 'john@example.com']);
        $user2 = User::factory()->create(['name' => 'Jane', 'email' => 'jane@example.com']);

        Livewire::test(Table::class)
                ->set('search', 'John')
                ->assertSee($user1->name)
                ->assertDontSee($user2->name);
    }

    public function test_it_can_sort_users_by_name()
    {
        $user1 = User::factory()->create(['name' => 'John']);
        $user2 = User::factory()->create(['name' => 'Alice']);

        Livewire::test(Table::class)
                ->set('sortBy', 'name')
                ->set('sortDirection', 'asc')
                ->assertSeeInOrder([$user2->name, $user1->name]);

        Livewire::test(Table::class)
                ->set('sortBy', 'name')
                ->set('sortDirection', 'desc')
                ->assertSeeInOrder([$user1->name, $user2->name]);
    }
}
