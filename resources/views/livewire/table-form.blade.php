<div>
    {{-- Shows a table form --}}
    <form wire:submit.prevent="{{ $formId ? 'edit' : 'store' }}">
        @csrf
        <input type="hidden" name="id" wire:model="formId">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" wire:model.debounce.2000ms="name">
            @error('name') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" wire:model.debounce.2000ms="email">
            @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
        </div>
        <button type="submit">Save</button>
    </form>
</div>
