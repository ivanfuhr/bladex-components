<button {{ $buttonAttributes }}>
    <x-std::icon name="plus" class="size-4" />
    <span>{{ $slot->isEmpty() ? __('Add item') : $slot }}</span>
</button>
