@props([
    'controls' => [],
    'defaultState' => [],
])

@php
    $controlCollection = collect($controls);
    $selectControls = $controlCollection->where('type', 'select')->values();
    $textControls = $controlCollection->where('type', 'text')->values();
    $checkboxControls = $controlCollection->where('type', 'checkbox')->values();
@endphp

<x-std::card size="sm" aria-labelledby="playbook-properties-heading">
    <x-std::card.header class="flex-row! items-center justify-between gap-3 space-y-0!">
        <x-std::card.title id="playbook-properties-heading">Properties</x-std::card.title>
        <x-std::button variant="ghost" size="sm" type="button" @click="resetControls()"> Reset </x-std::button>
    </x-std::card.header>

    <x-std::card.content class="space-y-4">
        <form class="space-y-4" @submit.prevent @change="handleControlChange($event)">
            @if ($selectControls->isNotEmpty() || $textControls->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($selectControls as $control)
                        @php
                            $optionCount = count($control->options);
                            $useToggleGroup = $optionCount > 0 && $optionCount <= 4;
                            $controlValue = $defaultState[$control->key] ?? $control->default;
                        @endphp

                        <x-std::field>
                            <x-std::field.label>{{ $control->label }}</x-std::field.label>

                            @if ($useToggleGroup)
                                <x-std::toggle-group
                                    type="single"
                                    variant="outline"
                                    size="sm"
                                    spacing="2"
                                    :default-value="$controlValue"
                                    :aria-label="$control->label"
                                    class="w-full max-w-full flex-wrap"
                                    data-playbook-control
                                    data-playbook-control-key="{{ $control->key }}"
                                >
                                    @foreach ($control->options as $value => $label)
                                        <x-std::toggle-group.item :value="$value">
                                            {{ $label }}
                                        </x-std::toggle-group.item>
                                    @endforeach
                                </x-std::toggle-group>
                            @else
                                <x-std::select
                                    size="sm"
                                    :value="$controlValue"
                                    placeholder="Choose…"
                                    data-playbook-control
                                    data-playbook-control-key="{{ $control->key }}"
                                >
                                    @foreach ($control->options as $value => $label)
                                        <x-std::select.item :value="$value">{{ $label }}</x-std::select.item>
                                    @endforeach
                                </x-std::select>
                            @endif
                        </x-std::field>
                    @endforeach

                    @foreach ($textControls as $control)
                        <x-std::field>
                            <x-std::field.label for="control-{{ $control->key }}">
                                {{ $control->label }}
                            </x-std::field.label>
                            <x-std::input
                                id="control-{{ $control->key }}"
                                size="sm"
                                x-model="state.{{ $control->key }}"
                                @input="queuePreview()"
                            />
                        </x-std::field>
                    @endforeach
                </div>
            @endif

            @if ($checkboxControls->isNotEmpty() && ($selectControls->isNotEmpty() || $textControls->isNotEmpty()))
                <x-std::separator />
            @endif

            @if ($checkboxControls->isNotEmpty())
                <div class="space-y-2">
                    @foreach ($checkboxControls as $control)
                        <x-std::field orientation="inline">
                            <x-std::field.label class="flex-1"> {{ $control->label }} </x-std::field.label>
                            <x-std::switch
                                size="sm"
                                x-model.boolean="state.{{ $control->key }}"
                                @change="queuePreview()"
                                :aria-label="$control->label"
                            />
                        </x-std::field>
                    @endforeach
                </div>
            @endif
        </form>
    </x-std::card.content>
</x-std::card>
