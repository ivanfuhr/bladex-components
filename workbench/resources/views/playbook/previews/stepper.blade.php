@php
    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $linear = (bool) ($state['linear'] ?? true);
@endphp

<div @class(['w-full', $orientation === 'vertical' ? 'max-w-2xl' : 'max-w-3xl'])>
    <x-std::stepper default-value="account" :orientation="$orientation" :linear="$linear" stepper-id="playbook-stepper">
        <x-std::stepper.list>
            <x-std::stepper.item value="account" :step="1">
                <x-std::stepper.trigger>
                    <x-std::stepper.indicator />
                    <x-std::stepper.label>
                        <x-std::stepper.title>Account</x-std::stepper.title>
                        <x-std::stepper.description>Profile details</x-std::stepper.description>
                    </x-std::stepper.label>
                </x-std::stepper.trigger>
                <x-std::stepper.separator />
            </x-std::stepper.item>
            <x-std::stepper.item value="workspace" :step="2">
                <x-std::stepper.trigger>
                    <x-std::stepper.indicator />
                    <x-std::stepper.label>
                        <x-std::stepper.title>Workspace</x-std::stepper.title>
                        <x-std::stepper.description>Name and region</x-std::stepper.description>
                    </x-std::stepper.label>
                </x-std::stepper.trigger>
                <x-std::stepper.separator />
            </x-std::stepper.item>
            <x-std::stepper.item value="review" :step="3">
                <x-std::stepper.trigger>
                    <x-std::stepper.indicator />
                    <x-std::stepper.label>
                        <x-std::stepper.title>Review</x-std::stepper.title>
                        <x-std::stepper.description>Confirm setup</x-std::stepper.description>
                    </x-std::stepper.label>
                </x-std::stepper.trigger>
            </x-std::stepper.item>
        </x-std::stepper.list>

        <div @class(['min-w-0 flex-1 space-y-4', $orientation === 'vertical' ? '' : 'w-full'])>
            <x-std::stepper.content value="account">
                Enter the account owner name and email used for billing notices.
            </x-std::stepper.content>
            <x-std::stepper.content value="workspace">
                Choose a workspace name and the region where data will live.
            </x-std::stepper.content>
            <x-std::stepper.content value="review">
                Review the details, then finish to create the workspace.
            </x-std::stepper.content>

            <x-std::stepper.navigation>
                <x-std::stepper.previous />
                <x-std::stepper.next />
            </x-std::stepper.navigation>
        </div>
    </x-std::stepper>
</div>
