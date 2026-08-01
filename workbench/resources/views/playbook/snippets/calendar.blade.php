@php
    use Workbench\App\Playbook\PlaybookCode;

    $mode = ($state['mode'] ?? 'single') === 'range' ? 'range' : 'single';
    $withToday = (bool) ($state['withToday'] ?? true);
    $weekNumbers = (bool) ($state['weekNumbers'] ?? false);
    $value = $mode === 'range' ? '2026-09-14/2026-09-18' : '2026-09-18';

    $tag = PlaybookCode::component('calendar');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'hold_date'),
        PlaybookCode::attribute('value', $value),
        PlaybookCode::attribute('mode', $mode, 'single'),
        PlaybookCode::boolean('with-today', $withToday),
        PlaybookCode::boolean('week-numbers', $weekNumbers),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
