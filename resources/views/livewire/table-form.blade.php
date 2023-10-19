{{-- Shows a table form --}}
<div>
    <form wire:submit.prevent="{{ $action }}">
        <x-input-group label="Name" for="name" :error="$errors->first('name')">
            <x-input.text wire:model.lazy="name" id="name" ></x-input.text>
        </x-input-group>
        <x-input-group label="Email" for="email" :error="$errors->first('email')">
            <x-input.text wire:model.lazy="email" id="email" ></x-input.text>
        </x-input-group>
        <x-input-group label="Birthday" for="birthday" :error="$errors->first('birthday')">
            <x-input.date wire:model.lazy="birthday" id="birthday" placeholder="MM/DD/YY"></x-input.date>
        </x-input-group>
        <button type="submit">Save</button>
        <button wire:click="$emit('formClosed')">Cancel</button>
    </form>
</div>
