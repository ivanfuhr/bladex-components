@if ($hasGroupAffix)
    <x-std::input.group @class([$userClass])>
        @if ($prefixText !== null)
            <x-std::input.group.prefix>{{ $prefixText }}</x-std::input.group.prefix>
        @endif

        <div {{ $wrapperTagAttributes }}>
            @if ($hasLeading)
                <div @class([$leadingAffixClasses])>
                    @if ($leadingContent instanceof \Illuminate\View\ComponentSlot)
                        {{ $leadingContent }}
                    @else
                        <x-std::text
                            inline
                            size="sm"
                            variant="subtle"
                            class="input__leading-text"
                        >{{ $leadingContent }}</x-std::text>
                    @endif
                </div>
            @endif

            <input {{ $controlAttributes }} />

            @if ($hasTrailing)
                <div @class([$trailingAffixClasses])>
                    @if ($trailingContent instanceof \Illuminate\View\ComponentSlot)
                        {{ $trailingContent }}
                    @else
                        <x-std::text
                            inline
                            size="sm"
                            variant="subtle"
                            class="input__trailing-text"
                        >{{ $trailingContent }}</x-std::text>
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
                            <x-std::icon name="eye" class="size-4" />
                        </button>
                    @endif

                    @if ($hasCopyable)
                        <button
                            type="button"
                            class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                            data-input-copy
                            aria-label="{{ __('Copy to clipboard') }}"
                        >
                            <x-std::icon name="clipboard" class="size-4" />
                        </button>
                    @endif
                </div>
            @endif

            @if ($hasCounter)
                <div
                    class="input__counter mt-1 w-full basis-full text-right text-xs text-zinc-500 dark:text-zinc-400"
                    data-input-counter-display
                    aria-live="polite"
                    aria-atomic="true"
                ></div>
            @endif
        </div>

        @if ($suffixText !== null)
            <x-std::input.group.suffix>{{ $suffixText }}</x-std::input.group.suffix>
        @endif
    </x-std::input.group>
@else
    <div {{ $wrapperTagAttributes }}>
        @if ($hasLeading)
            <div @class([$leadingAffixClasses])>
                @if ($leadingContent instanceof \Illuminate\View\ComponentSlot)
                    {{ $leadingContent }}
                @else
                    <x-std::text
                        inline
                        size="sm"
                        variant="subtle"
                        class="input__leading-text"
                    >{{ $leadingContent }}</x-std::text>
                @endif
            </div>
        @endif

        <input {{ $controlAttributes }} />

        @if ($hasTrailing)
            <div @class([$trailingAffixClasses])>
                @if ($trailingContent instanceof \Illuminate\View\ComponentSlot)
                    {{ $trailingContent }}
                @else
                    <x-std::text
                        inline
                        size="sm"
                        variant="subtle"
                        class="input__trailing-text"
                    >{{ $trailingContent }}</x-std::text>
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
                        <x-std::icon name="eye" class="size-4" />
                    </button>
                @endif

                @if ($hasCopyable)
                    <button
                        type="button"
                        class="inline-flex size-8 items-center justify-center rounded-md text-zinc-500 hover:text-zinc-900 focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:text-zinc-400 dark:hover:text-zinc-50 dark:focus-visible:ring-zinc-300/20"
                        data-input-copy
                        aria-label="{{ __('Copy to clipboard') }}"
                    >
                        <x-std::icon name="clipboard" class="size-4" />
                    </button>
                @endif
            </div>
        @endif

        @if ($hasCounter)
            <div
                class="input__counter mt-1 w-full basis-full text-right text-xs text-zinc-500 dark:text-zinc-400"
                data-input-counter-display
                aria-live="polite"
                aria-atomic="true"
            ></div>
        @endif
    </div>
@endif
