@php
    $variant = $state['variant'];
    $size = $state['size'] === 'default' ? null : $state['size'];
    $href = ($state['as_link'] ?? false) ? 'https://example.com' : null;
    $square = (bool) ($state['square'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $type = $state['type'];
    $showAffixes = (bool) ($state['show_affixes'] ?? false);
@endphp

<x-std::button :variant="$variant" :size="$size" :type="$type" :href="$href" :square="$square" :disabled="$disabled">
    @if ($showAffixes)
        <x-slot:leading>
            <x-std::icon.loading class="animate-spin" />
        </x-slot:leading>
    @endif
    @if ($square && ! $showAffixes)
        <x-std::icon.loading />
    @else
        Save changes
    @endif
    @if ($showAffixes)
        <x-slot:trailing>
            <span aria-hidden="true">→</span>
        </x-slot:trailing>
    @endif
</x-std::button>
