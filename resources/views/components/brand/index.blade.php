<a href="{{ $href }}" {{
    $attributes->class($classes)->merge([
        'data-brand' => true,
    ])
}}>
    @include('stencil::components.brand.logo-media', [
        'logo' => $logo,
        'logoDark' => $resolvedLogoDark,
        'alt' => $alt,
        'logoWrapperClasses' => $logoWrapperClasses,
        'imageClasses' => $imageClasses,
    ])

    @if (filled($name))
        <div @class($nameClasses)>{{ $name }}</div>
    @endif
</a>
