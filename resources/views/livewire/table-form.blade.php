{{-- Shows a table form --}}
<div class="table-form">
    <form wire:submit.prevent="{{ $action }}">
        <x-input-group label="Name" for="name" :error="$errors->first('name')">
            <x-input.text wire:model.lazy="name" id="name"/>
        </x-input-group>
        <x-input-group label="Email" for="email" :error="$errors->first('email')">
            <x-input.text wire:model.lazy="email" id="email"/>
        </x-input-group>
        <x-input-group label="Birthday" for="birthday" :error="$errors->first('birthday')">
            <x-input.date wire:model="birthday" id="birthday" placeholder="MM/DD/YYYY"/>
        </x-input-group>
        <button type="submit">Save</button>
        <button wire:click="$emit('formClosed')">Cancel</button>
    </form>
</div>
