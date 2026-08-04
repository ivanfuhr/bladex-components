@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $linear = (bool) ($state['linear'] ?? true);
@endphp

<div @class(['w-full', $orientation === 'vertical' ? 'max-w-2xl' : 'max-w-3xl'])>
    <x-ui::stepper default-value="account" :orientation="$orientation" :linear="$linear" stepper-id="playbook-stepper">
        <x-ui::stepper.list>
            <x-ui::stepper.item value="account" :step="1">
                <x-ui::stepper.trigger>
                    <x-ui::stepper.indicator />
                    <x-ui::stepper.label>
                        <x-ui::stepper.title>Account</x-ui::stepper.title>
                        <x-ui::stepper.description>Profile details</x-ui::stepper.description>
                    </x-ui::stepper.label>
                </x-ui::stepper.trigger>
                <x-ui::stepper.separator />
            </x-ui::stepper.item>
            <x-ui::stepper.item value="workspace" :step="2">
                <x-ui::stepper.trigger>
                    <x-ui::stepper.indicator />
                    <x-ui::stepper.label>
                        <x-ui::stepper.title>Workspace</x-ui::stepper.title>
                        <x-ui::stepper.description>Name and region</x-ui::stepper.description>
                    </x-ui::stepper.label>
                </x-ui::stepper.trigger>
                <x-ui::stepper.separator />
            </x-ui::stepper.item>
            <x-ui::stepper.item value="review" :step="3">
                <x-ui::stepper.trigger>
                    <x-ui::stepper.indicator />
                    <x-ui::stepper.label>
                        <x-ui::stepper.title>Review</x-ui::stepper.title>
                        <x-ui::stepper.description>Confirm setup</x-ui::stepper.description>
                    </x-ui::stepper.label>
                </x-ui::stepper.trigger>
            </x-ui::stepper.item>
        </x-ui::stepper.list>

        <div @class(['min-w-0 flex-1 space-y-4', $orientation === 'vertical' ? '' : 'w-full'])>
            <x-ui::stepper.content value="account">
                Enter the account owner name and email used for billing notices.
            </x-ui::stepper.content>
            <x-ui::stepper.content value="workspace">
                Choose a workspace name and the region where data will live.
            </x-ui::stepper.content>
            <x-ui::stepper.content value="review">
                Review the details, then finish to create the workspace.
            </x-ui::stepper.content>

            <x-ui::stepper.navigation>
                <x-ui::stepper.previous />
                <x-ui::stepper.next />
            </x-ui::stepper.navigation>
        </div>
    </x-ui::stepper>
</div>
