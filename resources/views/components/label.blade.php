@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 bg-gray-200 pt-3 pb-2 px-3 rounded']) }}>
    {{ $value ?? $slot }}
</label>
