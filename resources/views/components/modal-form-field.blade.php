@props([
'type' => 'text',
'label',
'name',
'value' => '',
'placeholder' => '',
'editable' => true,
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-xs font-regular text-black">{{ $label }}</label>

    @if ($type === 'textarea')
    <textarea id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder }}" {{ $editable ? '' : 'readonly' }} {{
        $attributes->merge([
                'class' => 'text-xs p-2 mt-1 block w-full rounded-lg border-gray-300 border-1 shadow-xs focus:border-indigo-500 focus:ring-indigo-500 ' .
                           (!$editable ? 'bg-gray-100 cursor-not-allowed' : '')
            ]) }}
        >{{ old($name, $value) }}</textarea>
    @else
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" {{ $editable ? '' : 'readonly' }} {{ $attributes->merge([
    'class' => 'text-xs p-2 mt-1 block w-full rounded-lg border-gray-300 border-1 shadow-xs focus:border-indigo-500
    focus:ring-indigo-500 ' .
    (!$editable ? 'bg-gray-100 cursor-not-allowed' : '')
    ]) }}
    >
    @endif
</div>