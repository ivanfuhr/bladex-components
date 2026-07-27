@php
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $readonly = (bool) ($state['readonly'] ?? false);
    $showAffixes = (bool) ($state['show_affixes'] ?? false);
    $showPrefixSuffix = (bool) ($state['show_prefix_suffix'] ?? false);
    $prefix = $showPrefixSuffix ? 'https://' : null;
    $suffix = $showPrefixSuffix ? '.com' : null;
@endphp

<x-stencil::input
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
            <x-stencil::icon.loading />
        </x-slot:leading>
        <x-slot:trailing>
            <x-stencil::text inline size="sm" variant="subtle">Clear</x-stencil::text>
        </x-slot:trailing>
    @endif
</x-stencil::input>
