<div class="radio flex items-start gap-2" data-radio>
    <input {{ $controlAttributes }} />

    @if ($hasSlotLabel)
        <x-std::label :for="$controlId" class="!font-normal"> {{ $slot }} </x-std::label>
    @elseif (filled($label))
        <x-std::label :for="$controlId" class="!font-normal"> {{ $label }} </x-std::label>
    @endif
</div>
