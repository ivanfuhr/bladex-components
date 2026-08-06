@php
    echo '<x-std::field name="email" class="max-w-md">
        <x-std::field.label>Email</x-std::field.label>
        <x-std::input name="email" type="email" placeholder="you@example.com" />
        <x-std::field.description>We will never share your email.</x-std::field.description>
        <x-std::field.errors name="email" />
    </x-std::field>';
@endphp
