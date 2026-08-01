@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $linear = (bool) ($state['linear'] ?? true);
@endphp

<div @class(['w-full', $orientation === 'vertical' ? 'max-w-2xl' : 'max-w-3xl'])>
    <x-stencil::stepper default-value="account" :orientation="$orientation" :linear="$linear" stepper-id="playbook-stepper">
        <x-stencil::stepper.list>
            <x-stencil::stepper.item value="account" :step="1">
                <x-stencil::stepper.trigger>
                    <x-stencil::stepper.indicator />
                    <span class="space-y-0.5">
                        <x-stencil::stepper.title>Account</x-stencil::stepper.title>
                        <x-stencil::stepper.description>Profile details</x-stencil::stepper.description>
                    </span>
                </x-stencil::stepper.trigger>
                <x-stencil::stepper.separator />
            </x-stencil::stepper.item>
            <x-stencil::stepper.item value="workspace" :step="2">
                <x-stencil::stepper.trigger>
                    <x-stencil::stepper.indicator />
                    <span class="space-y-0.5">
                        <x-stencil::stepper.title>Workspace</x-stencil::stepper.title>
                        <x-stencil::stepper.description>Name and region</x-stencil::stepper.description>
                    </span>
                </x-stencil::stepper.trigger>
                <x-stencil::stepper.separator />
            </x-stencil::stepper.item>
            <x-stencil::stepper.item value="review" :step="3">
                <x-stencil::stepper.trigger>
                    <x-stencil::stepper.indicator />
                    <span class="space-y-0.5">
                        <x-stencil::stepper.title>Review</x-stencil::stepper.title>
                        <x-stencil::stepper.description>Confirm setup</x-stencil::stepper.description>
                    </span>
                </x-stencil::stepper.trigger>
            </x-stencil::stepper.item>
        </x-stencil::stepper.list>

        <div @class(['min-w-0 flex-1 space-y-4', $orientation === 'vertical' ? '' : 'w-full'])>
            <x-stencil::stepper.content value="account">
                Enter the account owner name and email used for billing notices.
            </x-stencil::stepper.content>
            <x-stencil::stepper.content value="workspace">
                Choose a workspace name and the region where data will live.
            </x-stencil::stepper.content>
            <x-stencil::stepper.content value="review">
                Review the details, then finish to create the workspace.
            </x-stencil::stepper.content>

            <x-stencil::stepper.navigation>
                <x-stencil::stepper.previous />
                <x-stencil::stepper.next />
            </x-stencil::stepper.navigation>
        </div>
    </x-stencil::stepper>
</div>
