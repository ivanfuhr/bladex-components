Native scrolling with themed overlay scrollbars ([shadcn Scroll Area](https://ui.shadcn.com/docs/components/scroll-area), [Radix Scroll Area](https://www.radix-ui.com/primitives/docs/components/scroll-area)). Included in `@stdScripts`. The viewport keeps browser wheel, touch, and keyboard scrolling; scrollbar chrome is presentational (`aria-hidden`). Give the root an accessible name (`aria-label` / `aria-labelledby`) when it is a primary region.

Subcomponents: `viewport`, `scrollbar`, `thumb`, and `corner`. Shortcut mode wraps the slot in a viewport and adds a vertical scrollbar. Pass `horizontal` to also compose the horizontal bar and corner. Set `:shortcut="false"` for full composition.

`type` controls chrome visibility: `hover` (default), `always`, `scroll`, or `auto`. `scroll-hide-delay` (ms, default `600`) controls how long bars stay visible after scrolling.

```blade
<x-std::scroll-area class="h-72 w-48 rounded-md border" aria-label="Tags">
    <div class="p-4">
        {{-- tall content --}}
    </div>
</x-std::scroll-area>

<x-std::scroll-area class="h-48 w-96" horizontal type="always" aria-label="Gallery">
    <div class="flex w-max gap-2 p-4">
        {{-- wide content --}}
    </div>
</x-std::scroll-area>

{{-- Full composition --}}
<x-std::scroll-area class="h-72" :shortcut="false" type="hover">
    <x-std::scroll-area.viewport>
        {{-- content --}}
    </x-std::scroll-area.viewport>
    <x-std::scroll-area.scrollbar orientation="vertical" />
    <x-std::scroll-area.scrollbar orientation="horizontal" />
    <x-std::scroll-area.corner />
</x-std::scroll-area>
```

<br>
