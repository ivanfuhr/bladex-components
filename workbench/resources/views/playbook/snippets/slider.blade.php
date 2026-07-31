@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $range = (bool) ($state['range'] ?? false);
    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : null;
    $step = (int) ($state['step'] ?? 1);
    $value = $range ? [25, 75] : 40;

    $tag = PlaybookCode::component('slider');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'volume'),
        $range ? ':value="[25, 75]"' : PlaybookCode::bound('value', $value, 0),
        PlaybookCode::boolean('range', $range),
        PlaybookCode::bound('step', $step, 1),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::attribute('size', $size),
    ]));

    $code = $open."\n".PlaybookCode::closingTag($tag);

    echo $code;
@endphp
