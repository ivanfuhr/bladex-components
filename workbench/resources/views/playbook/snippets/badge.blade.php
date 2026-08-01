@php
    use Workbench\App\Playbook\PlaybookCode;

    $variant = ($state['variant'] ?? 'secondary') === 'secondary' ? null : (string) $state['variant'];
    $color = filled($state['color'] ?? '') ? (string) $state['color'] : null;
    $rounded = (bool) ($state['rounded'] ?? false);
    $dismissible = (bool) ($state['dismissible'] ?? false);

    $badge = PlaybookCode::component('badge');
    $close = PlaybookCode::component('badge.close');

    $open = PlaybookCode::openingTag($badge, array_filter([
        PlaybookCode::attribute('variant', $variant),
        PlaybookCode::attribute('color', $color),
        PlaybookCode::boolean('rounded', $rounded),
    ]));

    if ($dismissible) {
        $code = $open.'Admin <'.$close.' />'.PlaybookCode::closingTag($badge);
    } else {
        $label = $color === 'lime' ? 'New' : ($variant === 'destructive' ? 'Failed' : 'Badge');
        $code = $open.$label.PlaybookCode::closingTag($badge);
    }

    echo $code;
@endphp
