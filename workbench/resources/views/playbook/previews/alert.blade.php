@php
    $variant = ($state['variant'] ?? 'info') === 'default' ? null : $state['variant'];
    $showIcon = (bool) ($state['show_icon'] ?? true);

    $titles = [
        'default' => 'Note',
        'info' => 'Tip',
        'success' => 'Payment received',
        'warning' => 'Heads up',
        'danger' => 'Action required',
    ];
    $descriptions = [
        'default' => 'This is a neutral status message.',
        'info' => 'You can copy this invite link anytime.',
        'success' => 'Invoice INV-204 was marked as paid.',
        'warning' => 'Check your billing details before renewing.',
        'danger' => 'Your API key was revoked. Generate a new one.',
    ];
    $icons = [
        'default' => 'clipboard',
        'info' => 'clipboard',
        'success' => 'check',
        'warning' => 'clipboard',
        'danger' => 'x',
    ];
    $key = $variant ?? 'default';
@endphp

<div class="max-w-xl">
    <x-stencil::alert :variant="$variant" :title="$titles[$key]" :icon="$showIcon ? $icons[$key] : null">
        <x-stencil::alert.description>{{ $descriptions[$key] }}</x-stencil::alert.description>
    </x-stencil::alert>
</div>
