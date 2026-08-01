<div
    class="color-picker__area relative h-36 w-full cursor-crosshair overflow-hidden rounded-md"
    data-color-picker-area
    role="group"
    aria-label="{{ __('stencil::messages.color_picker_saturation_value') }}"
>
    <div class="pointer-events-none absolute inset-0" data-color-picker-area-base></div>
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-r from-white to-transparent"></div>
    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-black to-transparent"></div>
    <div
        class="color-picker__area-thumb pointer-events-none absolute size-4 -translate-x-1/2 -translate-y-1/2 rounded-full border-2 border-white shadow-md ring-1 ring-zinc-950/20 dark:border-zinc-950 dark:ring-white/20"
        data-color-picker-area-thumb
    ></div>
</div>
