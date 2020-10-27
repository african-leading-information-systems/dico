<div>
    <select class="{{ $class }}" @if($wire) wire:model="{{ $name }}" @else name="{{ $name }}" @endif id="">
        <option value="">{{ count($dictionaries) ? $placeholder : __('dicoLang::messages.forms.selectNoData') }}</option>
        @foreach($dictionaries as $dictionary)
            <option @if(! is_null($value) && $value == $dictionary->id) selected @endif value="{{ $dictionary->id }}">
                {{ $dictionary->description }}
            </option>
        @endforeach
    </select>
</div>
