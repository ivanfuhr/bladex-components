@php
    $rounded = ($state['rounded'] ?? 'default') === 'full' ? 'full' : null;
@endphp

<div class="max-w-md space-y-6">
    <div class="flex items-center gap-4">
        <x-stencil::skeleton
            :rounded="$rounded"
            class="{{ $rounded === 'full' ? 'size-12' : 'size-12 rounded-full' }}"
        />
        <div class="flex-1 space-y-2">
            <x-stencil::skeleton class="h-4 w-40" />
            <x-stencil::skeleton class="h-3 w-56" />
        </div>
    </div>
    <div class="space-y-2">
        <x-stencil::skeleton class="h-4 w-full" />
        <x-stencil::skeleton class="h-4 w-5/6" />
        <x-stencil::skeleton class="h-4 w-2/3" />
    </div>
</div>
