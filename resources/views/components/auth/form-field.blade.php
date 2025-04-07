@props(['label', 'name', 'type' => 'text', 'placeholder' => ''])

<div class="mb-4">
    <x-auth.form-label for="{{ $name }}" value="{{ $label }}"></x-auth.form-label>
    <x-auth.form-input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" class="mt-1" {{ $attributes }} required/>
</div>