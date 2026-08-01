@props([
    'name' => null,
    'value' => null,
    'length' => 6,
    'mode' => 'numeric',
    'invalid' => false,
    'disabled' => false,
    'size' => null,
    'separated' => null,
    'inputOtpId' => null,
    'shortcut' => true,
])

@aware([
    'fieldInvalid' => false,
    'controlId' => null,
])

@php
    $invalid = $invalid || $fieldInvalid;

    $length = max(1, (int) $length);
    $mode = in_array($mode, ['numeric', 'alphanumeric'], true) ? $mode : 'numeric';

    $inputOtpId = filled($inputOtpId)
        ? $inputOtpId
        : (filled($name) ? $name : 'input-otp-'.str_replace('.', '', uniqid('', true)));
    $controlId = filled($controlId) ? $controlId : $inputOtpId;

    $scalarValue = filled($value) ? (string) $value : '';
    $scalarValue = mb_substr($scalarValue, 0, $length);

    $useSeparator = $separated === null
        ? ($length >= 4 && $length % 2 === 0)
        : (bool) $separated;

    $half = (int) floor($length / 2);

    $rootAttributes = $attributes
        ->except(['shortcut', 'separated', 'mode', 'length', 'value', 'name'])
        ->class([
            'input-otp flex min-w-0 items-center gap-2',
            'w-full' => ! filled($attributes->get('class')),
        ])
        ->merge([
            'data-input-otp' => true,
            'data-input-otp-id' => $inputOtpId,
            'data-input-otp-length' => (string) $length,
            'data-input-otp-mode' => $mode,
            'role' => 'group',
        ]);

    if ($disabled) {
        $rootAttributes = $rootAttributes->merge(['data-disabled' => 'true']);
    }

    if ($invalid) {
        $rootAttributes = $rootAttributes->merge(['data-invalid' => 'true']);
    }

    if (mb_strlen($scalarValue) === $length) {
        $rootAttributes = $rootAttributes->merge(['data-complete' => 'true']);
    }
@endphp

<div {{ $rootAttributes }}>
    @if (filled($name))
        <input type="hidden" name="{{ $name }}" value="{{ $scalarValue }}" data-input-otp-hidden-input />
    @else
        <input type="hidden" value="{{ $scalarValue }}" data-input-otp-hidden-input />
    @endif

    @if ($shortcut)
        @if ($useSeparator)
            <x-stencil::input-otp.group>
                @for ($i = 0; $i < $half; $i++)
                    <x-stencil::input-otp.slot :index="$i" :value="$scalarValue" />
                @endfor
            </x-stencil::input-otp.group>

            <x-stencil::input-otp.separator />

            <x-stencil::input-otp.group>
                @for ($i = $half; $i < $length; $i++)
                    <x-stencil::input-otp.slot :index="$i" :value="$scalarValue" />
                @endfor
            </x-stencil::input-otp.group>
        @else
            <x-stencil::input-otp.group>
                @for ($i = 0; $i < $length; $i++)
                    <x-stencil::input-otp.slot :index="$i" :value="$scalarValue" />
                @endfor
            </x-stencil::input-otp.group>
        @endif
    @else
        {{ $slot }}
    @endif
</div>
