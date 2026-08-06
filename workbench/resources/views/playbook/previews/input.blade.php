@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $readonly = (bool) ($state['readonly'] ?? false);
    $showAffixes = (bool) ($state['show_affixes'] ?? false);
    $showPrefixSuffix = (bool) ($state['show_prefix_suffix'] ?? false);
    $prefix = $showPrefixSuffix ? 'https://' : null;
    $suffix = $showPrefixSuffix ? '.com' : null;
@endphp

<x-std::input
    name="email"
    type="email"
    placeholder="you@example.com"
    :invalid="$invalid"
    :disabled="$disabled"
    :readonly="$readonly"
    :prefix="$prefix"
    :suffix="$suffix"
>
    @if ($showAffixes)
        <x-slot:leading>
            <x-std::icon.loading />
        </x-slot:leading>
        <x-slot:trailing>
            <x-std::text inline size="sm" variant="subtle">Clear</x-std::text>
        </x-slot:trailing>
    @endif
</x-std::input>
