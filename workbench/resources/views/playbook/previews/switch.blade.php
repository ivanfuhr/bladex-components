@php
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $checked = (bool) ($state['checked'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
@endphp

<x-stencil::field name="notifications" orientation="inline" class="max-w-md">
    <div class="flex flex-1 flex-col gap-1">
        <x-stencil::field.label>Notifications</x-stencil::field.label>
        <x-stencil::field.description>Email alerts for account activity.</x-stencil::field.description>
    </div>
    <x-stencil::switch
        name="notifications"
        :size="$size"
        :checked="$checked"
        :invalid="$invalid"
        :disabled="$disabled"
    />
</x-stencil::field>
