<template
    data-chart-template="axis"
    data-axis="{{ $axis }}"
    data-field="{{ $resolvedField }}"
    @if (filled($encodedFormat)) data-format="{{ $encodedFormat }}" @endif
    @if (filled($position)) data-position="{{ $position }}" @endif
    @if (filled($encodedTickValues)) data-tick-values="{{ $encodedTickValues }}" @endif
    @if (filled($tickPrefix)) data-tick-prefix="{{ $tickPrefix }}" @endif
    @if (filled($tickSuffix)) data-tick-suffix="{{ $tickSuffix }}" @endif
    @if (filled($tickCount)) data-tick-count="{{ $tickCount }}" @endif
    @if (filled($tickStart)) data-tick-start="{{ $tickStart }}" @endif
    @if (filled($tickEnd)) data-tick-end="{{ $tickEnd }}" @endif
    {{ $attributes->except(['axis', 'field', 'format', 'position', 'tickValues', 'tickPrefix', 'tickSuffix', 'tickCount', 'tickStart', 'tickEnd']) }}
>
    {{ $slot }}
</template>
