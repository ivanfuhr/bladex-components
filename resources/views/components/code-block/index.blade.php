@if ($inline)
    <code {{ $inlineAttributes }}>{!! $highlighted !!}</code>
@else
    <div {{ $wrapperAttributes }}>
        @if ($copyable)
            <div class="code-block__toolbar">
                @if ($languageLabel)
                    <span class="code-block__language">{{ $languageLabel }}</span>
                @else
                    <span></span>
                @endif

                <button type="button" class="code-block__copy" data-code-block-copy aria-label="{{ __('Copy code') }}">
                    {{ __('Copy') }}
                </button>
            </div>
        @endif

        <pre {{ $preAttributes }}>
            <code class="{{ $codeClass }}" data-code-block-content>{!! $highlighted !!}</code>
        </pre>

        @if ($copyable)
            <template data-code-block-source>{{ $rawCode }}</template>
        @endif
    </div>
@endif
