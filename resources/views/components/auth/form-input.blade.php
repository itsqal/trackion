@props(['type' => 'text', 'name', 'value' => ''])

<input 
type="{{ $type }}"
name="{{ $name }}"
value="{{ old($name, $value) }}"
{{ $attributes->merge(['class' => 'w-full rounded-3xl border-[#EFF0F6] border-1 text-base .placeholder-[#AFAFAF] py-2 px-2'])}}>