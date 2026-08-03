<div {{ $rootAttributes }}>
    @if (filled($name))
        <input type="hidden" name="{{ $name }}" value="{{ $scalarValue }}" data-input-otp-hidden-input />
    @else
        <input type="hidden" value="{{ $scalarValue }}" data-input-otp-hidden-input />
    @endif

    @if ($shortcut)
        @if ($useSeparator)
            <x-ui::input-otp.group>
                @for ($i = 0; $i < $half; $i++)
                    <x-ui::input-otp.slot
                        :index="$i"
                        :value="$scalarValue"
                        :invalid="$invalid"
                        :disabled="$disabled"
                        :size="$size"
                        :mode="$mode"
                        :length="$length"
                        :control-id="$controlId"
                    />
                @endfor
            </x-ui::input-otp.group>

            <x-ui::input-otp.separator />

            <x-ui::input-otp.group>
                @for ($i = $half; $i < $length; $i++)
                    <x-ui::input-otp.slot
                        :index="$i"
                        :value="$scalarValue"
                        :invalid="$invalid"
                        :disabled="$disabled"
                        :size="$size"
                        :mode="$mode"
                        :length="$length"
                        :control-id="$controlId"
                    />
                @endfor
            </x-ui::input-otp.group>
        @else
            <x-ui::input-otp.group>
                @for ($i = 0; $i < $length; $i++)
                    <x-ui::input-otp.slot
                        :index="$i"
                        :value="$scalarValue"
                        :invalid="$invalid"
                        :disabled="$disabled"
                        :size="$size"
                        :mode="$mode"
                        :length="$length"
                        :control-id="$controlId"
                    />
                @endfor
            </x-ui::input-otp.group>
        @endif
    @else
        {{ $slot }}
    @endif
</div>
