@php
    use Workbench\App\Playbook\PlaybookCode;

    $mode = ($state['mode'] ?? 'single') === 'range' ? 'range' : 'single';
    $withPresets = (bool) ($state['withPresets'] ?? false);
    $withToday = (bool) ($state['withToday'] ?? true);

    $tag = PlaybookCode::component('date-picker');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'published_at'),
        PlaybookCode::attribute('value', $mode === 'range' ? '2026-07-01/2026-07-15' : '2026-07-29'),
        PlaybookCode::attribute('mode', $mode, 'single'),
        PlaybookCode::boolean('with-presets', $withPresets),
        PlaybookCode::boolean('with-today', $withToday),
    ]));

    echo $open."\n".PlaybookCode::closingTag($tag);
@endphp
