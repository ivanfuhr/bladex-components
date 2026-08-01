@php
    use Workbench\App\Playbook\PlaybookCode;

    $side = $state['side'] ?? 'top';

    $tooltip = PlaybookCode::component('tooltip');
    $trigger = PlaybookCode::component('tooltip.trigger');
    $content = PlaybookCode::component('tooltip.content');
    $button = PlaybookCode::component('button');

    $code = PlaybookCode::openingTag($tooltip, array_filter([
        PlaybookCode::attribute('side', $side, 'top'),
    ]))."\n";
    $code .= '    <'.$trigger.'>'."\n";
    $code .= '        '.PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'outline')]).'Hover'.PlaybookCode::closingTag($button)."\n";
    $code .= '    </'.$trigger.'>'."\n";
    $code .= '    <'.$content.'>Add to library</'.$content.'>'."\n";
    $code .= PlaybookCode::closingTag($tooltip);

    echo $code;
@endphp
