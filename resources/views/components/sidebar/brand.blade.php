@php
    $hasSlotLogo = isset($logo) && $logo instanceof \Illuminate\View\ComponentSlot;
    $hasUrlLogo = filled($logo) && ! $hasSlotLogo;
    $hasDarkLogo = filled($resolvedLogoDark ?? null);
    $showLogo = $hasSlotLogo || $hasUrlLogo || $hasDarkLogo;
@endphp

@if ($useLink)
    <a
        href="{{ $href }}"
        {{
            $attributes->class($classes)->merge([
                'data-sidebar-brand' => true,
            ])
        }}
    >
        @if ($showLogo)
            @if ($hasSlotLogo)
                @include('std-components::components.brand.logo-media', [
                    'logo' => $logo,
                    'logoDark' => $resolvedLogoDark,
                    'alt' => $alt,
                    'logoWrapperClasses' => $slotLogoWrapperClasses,
                    'imageClasses' => $imageClasses,
                ])
            @else
                @include('std-components::components.brand.logo-media', [
                    'logo' => $logo,
                    'logoDark' => $resolvedLogoDark,
                    'alt' => $alt,
                    'logoWrapperClasses' => $urlLogoWrapperClasses,
                    'imageClasses' => $imageClasses,
                ])
            @endif
        @endif
        @if (filled($name))
            <span class="truncate text-sm font-semibold tracking-tight text-zinc-950 group-data-[collapsible=icon]:hidden dark:text-zinc-50">
                {{ $name }}
            </span>
        @endif
        {{ $slot }}
    </a>
@else
    <div {{
        $attributes->class($classes)->merge([
            'data-sidebar-brand' => true,
        ])
    }}>
        @if ($showLogo)
            @if ($hasSlotLogo)
                @include('std-components::components.brand.logo-media', [
                    'logo' => $logo,
                    'logoDark' => $resolvedLogoDark,
                    'alt' => $alt,
                    'logoWrapperClasses' => $slotLogoWrapperClasses,
                    'imageClasses' => $imageClasses,
                ])
            @else
                @include('std-components::components.brand.logo-media', [
                    'logo' => $logo,
                    'logoDark' => $resolvedLogoDark,
                    'alt' => $alt,
                    'logoWrapperClasses' => $urlLogoWrapperClasses,
                    'imageClasses' => $imageClasses,
                ])
            @endif
        @endif
        @if (filled($name))
            <span class="truncate text-sm font-semibold tracking-tight text-zinc-950 group-data-[collapsible=icon]:hidden dark:text-zinc-50">
                {{ $name }}
            </span>
        @endif
        {{ $slot }}
    </div>
@endif
