@php
    $separator = ($state['separator'] ?? 'chevron') === 'slash' ? 'slash' : null;
@endphp

<x-std::breadcrumb>
    <x-std::breadcrumb.list>
        <x-std::breadcrumb.item href="#">Home</x-std::breadcrumb.item>
        <x-std::breadcrumb.separator :type="$separator" />
        <x-std::breadcrumb.item href="#">Settings</x-std::breadcrumb.item>
        <x-std::breadcrumb.separator :type="$separator" />
        <x-std::breadcrumb.item>
            <x-std::breadcrumb.page>Profile</x-std::breadcrumb.page>
        </x-std::breadcrumb.item>
    </x-std::breadcrumb.list>
</x-std::breadcrumb>
