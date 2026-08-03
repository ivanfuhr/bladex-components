<div class="radio flex items-start gap-2" data-radio>
    <input {{ $controlAttributes }} />

    @if ($hasSlotLabel)
        <x-ui::label :for="$controlId" class="!font-normal"> {{ $slot }} </x-ui::label>
    @elseif (filled($label))
        <x-ui::label :for="$controlId" class="!font-normal"> {{ $label }} </x-ui::label>
    @endif
</div>
