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

<div class="relative min-h-48 w-full space-y-3">
    <x-std::toast.provider :position="$position" class="!relative !inset-auto !max-w-sm !translate-x-0">
        <x-std::toast
            :variant="$variant"
            :title="$titles[$key]"
            :description="$descriptions[$key]"
            :duration="999999"
        />
    </x-std::toast.provider>
    <x-std::text size="sm" variant="subtle">
        Position is simulated inside this relative stage — not a viewport corner.
    </x-std::text>
</div>
