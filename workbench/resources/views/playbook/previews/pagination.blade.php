@php
    $showEllipsis = (bool) ($state['show_ellipsis'] ?? true);
@endphp

<x-stencil::pagination>
    <x-stencil::pagination.content>
        <x-stencil::pagination.item>
            <x-stencil::pagination.previous href="#" />
        </x-stencil::pagination.item>
        <x-stencil::pagination.item>
            <x-stencil::pagination.link href="#">1</x-stencil::pagination.link>
        </x-stencil::pagination.item>
        <x-stencil::pagination.item>
            <x-stencil::pagination.link href="#" :is-active="true">2</x-stencil::pagination.link>
        </x-stencil::pagination.item>
        <x-stencil::pagination.item>
            <x-stencil::pagination.link href="#">3</x-stencil::pagination.link>
        </x-stencil::pagination.item>
        @if ($showEllipsis)
            <x-stencil::pagination.item>
                <x-stencil::pagination.ellipsis />
            </x-stencil::pagination.item>
            <x-stencil::pagination.item>
                <x-stencil::pagination.link href="#">12</x-stencil::pagination.link>
            </x-stencil::pagination.item>
        @endif
        <x-stencil::pagination.item>
            <x-stencil::pagination.next href="#" />
        </x-stencil::pagination.item>
    </x-stencil::pagination.content>
</x-stencil::pagination>
