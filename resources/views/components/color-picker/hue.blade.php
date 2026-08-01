@aware([
    'disabled' => false,
])

<input
    type="range"
    min="0"
    max="360"
    step="1"
    value="0"
    class="color-picker__hue-slider [&::-webkit-slider-thumb]:size-4 [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:border-2 [&::-webkit-slider-thumb]:border-white [&::-webkit-slider-thumb]:bg-white [&::-webkit-slider-thumb]:shadow-md [&::-moz-range-thumb]:size-4 [&::-moz-range-thumb]:rounded-full [&::-moz-range-thumb]:border-2 [&::-moz-range-thumb]:border-white [&::-moz-range-thumb]:bg-white [&::-moz-range-thumb]:shadow-md h-3 w-full cursor-pointer appearance-none rounded-full bg-transparent focus-visible:ring-2 focus-visible:ring-zinc-950/10 focus-visible:outline-none dark:focus-visible:ring-zinc-300/20"
    style="background: linear-gradient(to right, #ff0000, #ffff00, #00ff00, #00ffff, #0000ff, #ff00ff, #ff0000)"
    data-color-picker-hue
    aria-label="{{ __('stencil::messages.color_picker_hue') }}"
    @if ($disabled) disabled @endif
/>
