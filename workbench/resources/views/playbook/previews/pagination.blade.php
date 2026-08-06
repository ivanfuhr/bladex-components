@php
    $showEllipsis = (bool) ($state['show_ellipsis'] ?? true);
@endphp

<x-std::pagination>
    <x-std::pagination.content>
        <x-std::pagination.item>
            <x-std::pagination.previous href="#" />
        </x-std::pagination.item>
        <x-std::pagination.item>
            <x-std::pagination.link href="#">1</x-std::pagination.link>
        </x-std::pagination.item>
        <x-std::pagination.item>
            <x-std::pagination.link href="#" :is-active="true">2</x-std::pagination.link>
        </x-std::pagination.item>
        <x-std::pagination.item>
            <x-std::pagination.link href="#">3</x-std::pagination.link>
        </x-std::pagination.item>
        @if ($showEllipsis)
            <x-std::pagination.item>
                <x-std::pagination.ellipsis />
            </x-std::pagination.item>
            <x-std::pagination.item>
                <x-std::pagination.link href="#">12</x-std::pagination.link>
            </x-std::pagination.item>
        @endif
        <x-std::pagination.item>
            <x-std::pagination.next href="#" />
        </x-std::pagination.item>
    </x-std::pagination.content>
</x-std::pagination>
