@php
    use Workbench\App\Playbook\PlaybookCode;

    $variant = ($state['variant'] ?? 'default') === 'default' ? null : (string) $state['variant'];
    $trendDirection = (string) ($state['trend_direction'] ?? 'up');
    $showIcon = (bool) ($state['show_icon'] ?? true);

    $trend = match ($trendDirection) {
        'down' => '−4.1%',
        'neutral' => '0.0%',
        default => '+12.4%',
    };

    $stat = PlaybookCode::component('stat');

    echo PlaybookCode::selfClosingTag($stat, array_filter([
        PlaybookCode::attribute('variant', $variant),
        PlaybookCode::attribute('label', 'Open tickets'),
        PlaybookCode::attribute('value', '128'),
        PlaybookCode::attribute('trend', $trend),
        PlaybookCode::attribute('trend-direction', $trendDirection),
        PlaybookCode::attribute('description', 'vs last 7 days'),
        $showIcon ? PlaybookCode::attribute('icon', 'file') : null,
    ]));
@endphp
