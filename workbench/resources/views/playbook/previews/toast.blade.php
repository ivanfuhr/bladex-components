@php
    $variant = ($state['variant'] ?? 'success') === 'default' ? null : $state['variant'];
    $position = $state['position'] ?? 'bottom-right';

    $titles = [
        'default' => 'Saved',
        'success' => 'Invite sent',
        'warning' => 'Heads up',
        'danger' => 'Upload failed',
    ];
    $descriptions = [
        'default' => 'Your changes were saved.',
        'success' => 'Taylor can now join the workspace.',
        'warning' => 'Your trial ends in 3 days.',
        'danger' => 'The file was too large. Try again.',
    ];
    $key = $variant ?? 'default';
@endphp

<div class="relative min-h-48">
    <x-stencil::toast.provider :position="$position" class="!relative !inset-auto !translate-x-0 !max-w-sm">
        <x-stencil::toast
            :variant="$variant"
            :title="$titles[$key]"
            :description="$descriptions[$key]"
            :duration="999999"
        />
    </x-stencil::toast.provider>
</div>
