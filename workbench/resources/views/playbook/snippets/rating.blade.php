@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $max = max(1, min(10, (int) ($state['max'] ?? 5)));

    $tag = PlaybookCode::component('rating');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'score'),
        PlaybookCode::bound('value', 3),
        PlaybookCode::bound('max', $max, 5),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
