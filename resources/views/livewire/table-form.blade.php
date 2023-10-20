{{-- Shows a table form --}}
<div class="table-form">
    <form wire:submit.prevent="{{ $action }}">
        <x-input-group label="Name" for="name" :error="$errors->first('user.name')">
            <x-input.text wire:model.lazy="user.name" id="name"/>
        </x-input-group>
        <x-input-group label="Email" for="email" :error="$errors->first('user.email')">
            <x-input.text wire:model.lazy="user.email" id="email"/>
        </x-input-group>
        <x-input-group label="Birthday" for="birthday" :error="$errors->first('user.birthday')">
            <x-input.date wire:model="user.birthday" id="birthday" placeholder="MM/DD/YYYY"/>
        </x-input-group>
        <button type="submit">Save</button>
        <button wire:click="$emit('formClosed')">Cancel</button>
    </form>
</div>
