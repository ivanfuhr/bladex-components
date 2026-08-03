<template data-chart-template="svg" @if (filled($gutter)) data-gutter="{{ $gutter }}" @endif>
    {{ $slot }}
    <svg {{ $attributes->class('absolute inset-0 size-full') }} xmlns="http://www.w3.org/2000/svg" version="1.1"></svg>
</template>
