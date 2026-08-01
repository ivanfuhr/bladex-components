@php
    use Workbench\App\Playbook\PlaybookCode;

    $withToday = (bool) ($state['withToday'] ?? true);
    $clearable = (bool) ($state['clearable'] ?? false);
    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);

    $tag = PlaybookCode::component('datetime-picker');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'kickoff_at'),
        PlaybookCode::attribute('value', '2026-09-18T09:15'),
        PlaybookCode::boolean('with-today', $withToday),
        PlaybookCode::boolean('clearable', $clearable),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
