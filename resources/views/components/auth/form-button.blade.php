@props(['value' => ''])

<x-auth.form-input 
type="submit"
value='{{ $value }}'
name="submit"
{{ $attributes->merge(['class' => 'w-full text-base bg-[#004BA4] text-white font-semibold py-2 rounded-3xl'])}}></x-auth.form-input>