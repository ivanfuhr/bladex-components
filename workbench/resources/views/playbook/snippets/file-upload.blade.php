@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $multiple = (bool) ($state['multiple'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $accept = filled($state['accept'] ?? null) ? (string) $state['accept'] : null;

    $tag = PlaybookCode::component('file-upload');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'attachments'),
        PlaybookCode::attribute('accept', $accept),
        PlaybookCode::boolean('multiple', $multiple),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('size', $size),
        PlaybookCode::attribute('text', 'PNG, JPG, or PDF up to 10MB'),
        PlaybookCode::attribute('class', 'max-w-md w-full'),
    ]));

    $code = $open."\n".PlaybookCode::closingTag($tag);

    echo $code;
@endphp
