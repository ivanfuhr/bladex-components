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

<x-ui::card size="sm" aria-labelledby="playbook-properties-heading">
    <x-ui::card.header class="flex-row! items-center justify-between gap-3 space-y-0!">
        <x-ui::card.title id="playbook-properties-heading">Properties</x-ui::card.title>
        <x-ui::button variant="ghost" size="sm" type="button" @click="resetControls()">
            Reset
        </x-ui::button>
    </x-ui::card.header>

    <x-ui::card.content class="space-y-4">
        <form class="space-y-4" @submit.prevent @change="handleControlChange($event)">
            @if ($selectControls->isNotEmpty() || $textControls->isNotEmpty())
                <div class="space-y-4">
                    @foreach ($selectControls as $control)
                        @php
                            $optionCount = count($control->options);
                            $useToggleGroup = $optionCount > 0 && $optionCount <= 4;
                            $controlValue = $defaultState[$control->key] ?? $control->default;
                        @endphp

                        <x-ui::field>
                            <x-ui::field.label>{{ $control->label }}</x-ui::field.label>

                            @if ($useToggleGroup)
                                <x-ui::toggle-group
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
                                        <x-ui::toggle-group.item :value="$value">
                                            {{ $label }}
                                        </x-ui::toggle-group.item>
                                    @endforeach
                                </x-ui::toggle-group>
                            @else
                                <x-ui::select
                                    size="sm"
                                    :value="$controlValue"
                                    placeholder="Choose…"
                                    data-playbook-control
                                    data-playbook-control-key="{{ $control->key }}"
                                >
                                    @foreach ($control->options as $value => $label)
                                        <x-ui::select.item :value="$value">{{ $label }}</x-ui::select.item>
                                    @endforeach
                                </x-ui::select>
                            @endif
                        </x-ui::field>
                    @endforeach

                    @foreach ($textControls as $control)
                        <x-ui::field>
                            <x-ui::field.label for="control-{{ $control->key }}">
                                {{ $control->label }}
                            </x-ui::field.label>
                            <x-ui::input
                                id="control-{{ $control->key }}"
                                size="sm"
                                x-model="state.{{ $control->key }}"
                                @input="queuePreview()"
                            />
                        </x-ui::field>
                    @endforeach
                </div>
            @endif

            @if ($checkboxControls->isNotEmpty() && ($selectControls->isNotEmpty() || $textControls->isNotEmpty()))
                <x-ui::separator />
            @endif

            @if ($checkboxControls->isNotEmpty())
                <div class="space-y-2">
                    @foreach ($checkboxControls as $control)
                        <x-ui::field orientation="inline">
                            <x-ui::field.label class="flex-1">
                                {{ $control->label }}
                            </x-ui::field.label>
                            <x-ui::switch
                                size="sm"
                                x-model.boolean="state.{{ $control->key }}"
                                @change="queuePreview()"
                                :aria-label="$control->label"
                            />
                        </x-ui::field>
                    @endforeach
                </div>
            @endif
        </form>
    </x-ui::card.content>
</x-ui::card>
