<div {{ $rootAttributes }}>
    <div data-repeater-list class="repeater__list flex flex-col gap-3"></div>

    <div data-repeater-actions class="repeater__actions flex flex-col gap-3">{{ $slot }}</div>

    <template data-repeater-item-template>
        @stack($stackName)
    </template>
</div>
