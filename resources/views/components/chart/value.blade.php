<span {{ $attributes }}>
    <span
        data-chart-slot
        @if (filled($field)) data-field="{{ $field }}" @endif
        @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif
    ></span>
</span>
