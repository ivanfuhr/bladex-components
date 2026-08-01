@php
    $separator = ($state['separator'] ?? 'chevron') === 'slash' ? 'slash' : null;
@endphp

<x-stencil::breadcrumb>
    <x-stencil::breadcrumb.list>
        <x-stencil::breadcrumb.item href="#">Home</x-stencil::breadcrumb.item>
        <x-stencil::breadcrumb.separator :type="$separator" />
        <x-stencil::breadcrumb.item href="#">Settings</x-stencil::breadcrumb.item>
        <x-stencil::breadcrumb.separator :type="$separator" />
        <x-stencil::breadcrumb.item>
            <x-stencil::breadcrumb.page>Profile</x-stencil::breadcrumb.page>
        </x-stencil::breadcrumb.item>
    </x-stencil::breadcrumb.list>
</x-stencil::breadcrumb>
