@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $length = (int) ($state['length'] ?? 6);
    $mode = ($state['mode'] ?? 'numeric') === 'alphanumeric' ? 'alphanumeric' : 'numeric';
    $separated = (bool) ($state['separated'] ?? true);

    $tag = PlaybookCode::component('input-otp');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'code'),
        PlaybookCode::bound('length', $length, 6),
        PlaybookCode::attribute('mode', $mode, 'numeric'),
        PlaybookCode::boolean('separated', $separated, true),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('size', $size),
    ]));

    $code = $open."\n".PlaybookCode::closingTag($tag);

    echo $code;
@endphp
