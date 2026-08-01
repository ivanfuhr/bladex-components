@php
    use Workbench\App\Playbook\PlaybookCode;

    $align = $state['align'] ?? 'start';
    $side = $state['side'] ?? 'bottom';

    $popover = PlaybookCode::component('popover');
    $trigger = PlaybookCode::component('popover.trigger');
    $content = PlaybookCode::component('popover.content');
    $button = PlaybookCode::component('button');

    $code = PlaybookCode::openingTag($popover, array_filter([
        PlaybookCode::attribute('align', $align, 'start'),
        PlaybookCode::attribute('side', $side, 'bottom'),
    ]))."\n";
    $code .= '    <'.$trigger.'>'."\n";
    $code .= '        '.PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'outline')]).'Open'.PlaybookCode::closingTag($button)."\n";
    $code .= '    </'.$trigger.'>'."\n";
    $code .= '    <'.$content.'>'."\n";
    $code .= '        Place any focusable content here.'."\n";
    $code .= '    </'.$content.'>'."\n";
    $code .= PlaybookCode::closingTag($popover);

    echo $code;
@endphp
