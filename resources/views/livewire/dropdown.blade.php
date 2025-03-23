<div>
    <select wire:model="selectedItems" name="{{ $name }}" id="{{ $name }}" class="form-select" multiple>
        @foreach ($items as $item)
            <option value="{{ $item->id }}" {{ in_array($item->id, $selectedItems) ? 'selected' : '' }}>
                {{ $item->name }}
            </option>
        @endforeach
    </select>
</div>