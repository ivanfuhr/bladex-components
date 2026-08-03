@if ($hasGroupAffix)
    <x-ui::input.group @class([$userClass])>
        @if ($prefixText !== null)
            <x-ui::input.group.prefix>{{ $prefixText }}</x-ui::input.group.prefix>
        @endif

        <div {{ $wrapperTagAttributes }}>
            @if ($hasLeading)
                <div @class([$leadingAffixClasses])>
                    @if ($leadingContent instanceof \Illuminate\View\ComponentSlot)
                        {{ $leadingContent }}
                    @else
                        <x-ui::text
                            inline
                            size="sm"
                            variant="subtle"
                            class="input__leading-text"
                        >{{ $leadingContent }}</x-ui::text>
                    @endif
                </div>
            @endif

            <input {{ $controlAttributes }} />

            @if ($hasTrailing)
                <div @class([$trailingAffixClasses])>
                    @if ($trailingContent instanceof \Illuminate\View\ComponentSlot)
                        {{ $trailingContent }}
                    @else
                        <x-ui::text
                            inline
                            size="sm"
                            variant="subtle"
                            class="input__trailing-text"
                        >{{ $trailingContent }}</x-ui::text>
                    @endif
                </div>
            @endif

            @if ($hasViewable || $hasCopyable)
                <div class="input__actions absolute inset-y-0 right-0 z-10 flex items-center gap-0.5 pr-1">
                    @if ($hasViewable)
                        <button
                            type="button"
                            class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                            data-input-view-toggle
                            aria-label="{{ __('Toggle password visibility') }}"
                            aria-pressed="false"
                        >
                            <x-ui::icon name="eye" class="size-4" />
                        </button>
                    @endif

                    @if ($hasCopyable)
                        <button
                            type="button"
                            class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                            data-input-copy
                            aria-label="{{ __('Copy to clipboard') }}"
                        >
                            <x-ui::icon name="clipboard" class="size-4" />
                        </button>
                    @endif
                </div>
            @endif

            @if ($hasCounter)
                <div
                    class="input__counter mt-1 w-full basis-full text-right text-xs text-zinc-500 dark:text-zinc-400"
                    data-input-counter-display
                ></div>
            @endif
        </div>

        @if ($suffixText !== null)
            <x-ui::input.group.suffix>{{ $suffixText }}</x-ui::input.group.suffix>
        @endif
    </x-ui::input.group>
@else
    <div {{ $wrapperTagAttributes }}>
        @if ($hasLeading)
            <div @class([$leadingAffixClasses])>
                @if ($leadingContent instanceof \Illuminate\View\ComponentSlot)
                    {{ $leadingContent }}
                @else
                    <x-ui::text
                        inline
                        size="sm"
                        variant="subtle"
                        class="input__leading-text"
                    >{{ $leadingContent }}</x-ui::text>
                @endif
            </div>
        @endif

        <input {{ $controlAttributes }} />

        @if ($hasTrailing)
            <div @class([$trailingAffixClasses])>
                @if ($trailingContent instanceof \Illuminate\View\ComponentSlot)
                    {{ $trailingContent }}
                @else
                    <x-ui::text
                        inline
                        size="sm"
                        variant="subtle"
                        class="input__trailing-text"
                    >{{ $trailingContent }}</x-ui::text>
                @endif
            </div>
        @endif

        @if ($hasViewable || $hasCopyable)
            <div class="input__actions absolute inset-y-0 right-0 z-10 flex items-center gap-0.5 pr-1">
                @if ($hasViewable)
                    <button
                        type="button"
                        class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                        data-input-view-toggle
                        aria-label="{{ __('Toggle password visibility') }}"
                        aria-pressed="false"
                    >
                        <x-ui::icon name="eye" class="size-4" />
                    </button>
                @endif

                @if ($hasCopyable)
                    <button
                        type="button"
                        class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                        data-input-copy
                        aria-label="{{ __('Copy to clipboard') }}"
                    >
                        <x-ui::icon name="clipboard" class="size-4" />
                    </button>
                @endif
            </div>
        @endif

        @if ($hasCounter)
            <div
                class="input__counter mt-1 w-full basis-full text-right text-xs text-zinc-500 dark:text-zinc-400"
                data-input-counter-display
            ></div>
        @endif
    </div>
@endif
