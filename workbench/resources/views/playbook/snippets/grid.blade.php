@php
    use Workbench\App\Playbook\PlaybookCode;

    $md = (string) ($state['md'] ?? '3');
    $sm = filled($state['sm'] ?? null) ? (string) $state['sm'] : null;
    $container = (bool) ($state['container'] ?? true);
    $showSpan = (bool) ($state['show_span'] ?? true);

    $grid = PlaybookCode::component('grid');
    $gridItem = PlaybookCode::component('grid.item');
    $stat = PlaybookCode::component('stat');

    echo PlaybookCode::openingTag($grid, array_filter([
        PlaybookCode::attribute('md', $md),
        PlaybookCode::attribute('sm', $sm),
        PlaybookCode::attribute('gap', '4'),
        PlaybookCode::boolean('container', $container, true),
    ]));

    echo PlaybookCode::selfClosingTag($stat, [
        PlaybookCode::attribute('label', 'Registrations'),
        PlaybookCode::attribute('value', '248'),
        PlaybookCode::attribute('trend', '+12.4%'),
        PlaybookCode::attribute('trend-direction', 'up'),
        PlaybookCode::attribute('description', 'vs last 7 days'),
        PlaybookCode::attribute('icon', 'file'),
    ]);

    if ($showSpan) {
        echo PlaybookCode::openingTag($gridItem, [
            PlaybookCode::attribute('span', 'full'),
        ]);
        echo PlaybookCode::selfClosingTag($stat, [
            PlaybookCode::attribute('label', 'Check-in rate'),
            PlaybookCode::attribute('value', '64%'),
        ]);
        echo PlaybookCode::closingTag($gridItem);
    }

    echo PlaybookCode::closingTag($grid);
@endphp
