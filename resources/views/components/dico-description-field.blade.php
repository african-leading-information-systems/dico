<div>
    @foreach($lang as $l)
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <div class="input-group-text">{{ strtoupper($l) }}</div>
            </div>
            <input type="text" wire:model="description.{{ $l }}" class="form-control"
                   placeholder="@lang('dicoLang::messages.forms.description_'.$l)" autocomplete="off"
            >
        </div>
        @error('description.'.$l) <span class="text-danger ml-3">{{ $message }}</span> @enderror
    @endforeach
    @error('description') <span class="text-danger ml-3">{{ $message }}</span> @enderror
</div>
