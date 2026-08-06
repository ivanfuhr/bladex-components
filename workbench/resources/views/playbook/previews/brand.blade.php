@php
    $name = (string) ($state['name'] ?? 'Std Components Inc.');
    $href = (string) ($state['href'] ?? '/');
    $useLogoUrl = (bool) ($state['use_logo_url'] ?? false);
@endphp

<div class="w-full rounded-xl border border-zinc-200 bg-zinc-50 px-4 dark:border-zinc-800 dark:bg-zinc-900/40">
    <x-std::header :border="false" class="bg-transparent dark:bg-transparent">
        @if ($useLogoUrl)
            <x-std::brand :href="$href" :name="$name" logo="/logo.svg" alt="Std Components" />
        @else
            <x-std::brand :href="$href" :name="$name">
                <x-slot:logo>
                    <span class="text-xs font-bold">S</span>
                </x-slot:logo>
            </x-std::brand>
        @endif
    </x-std::header>
</div>
