@props(['field'])

@error($field)
    <p class="text-xs text-center text-red-600 my-2 font-medium">{{ $message }}</p>
@enderror