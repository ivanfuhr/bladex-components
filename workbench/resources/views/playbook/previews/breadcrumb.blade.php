@php
    $separator = ($state['separator'] ?? 'chevron') === 'slash' ? 'slash' : null;
@endphp

<x-ui::breadcrumb>
    <x-ui::breadcrumb.list>
        <x-ui::breadcrumb.item href="#">Home</x-ui::breadcrumb.item>
        <x-ui::breadcrumb.separator :type="$separator" />
        <x-ui::breadcrumb.item href="#">Settings</x-ui::breadcrumb.item>
        <x-ui::breadcrumb.separator :type="$separator" />
        <x-ui::breadcrumb.item>
            <x-ui::breadcrumb.page>Profile</x-ui::breadcrumb.page>
        </x-ui::breadcrumb.item>
    </x-ui::breadcrumb.list>
</x-ui::breadcrumb>
