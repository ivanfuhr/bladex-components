@php
    echo '<x-ui::field name="email" class="max-w-md">
        <x-ui::field.label>Email</x-ui::field.label>
        <x-ui::input name="email" type="email" placeholder="you@example.com" />
        <x-ui::field.description>We will never share your email.</x-ui::field.description>
        <x-ui::field.errors name="email" />
    </x-ui::field>';
@endphp
