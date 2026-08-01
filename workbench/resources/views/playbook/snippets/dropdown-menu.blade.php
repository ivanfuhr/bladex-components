@php
    use Workbench\App\Playbook\PlaybookCode;

    $align = $state['align'] ?? 'start';

    $menu = PlaybookCode::component('dropdown-menu');
    $trigger = PlaybookCode::component('dropdown-menu.trigger');
    $content = PlaybookCode::component('dropdown-menu.content');
    $label = PlaybookCode::component('dropdown-menu.label');
    $item = PlaybookCode::component('dropdown-menu.item');
    $separator = PlaybookCode::component('dropdown-menu.separator');
    $button = PlaybookCode::component('button');

    $code = PlaybookCode::openingTag($menu, array_filter([
        PlaybookCode::attribute('align', $align, 'start'),
    ]))."\n";
    $code .= '    <'.$trigger.'>'."\n";
    $code .= '        '.PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'outline')]).'Open'.PlaybookCode::closingTag($button)."\n";
    $code .= '    </'.$trigger.'>'."\n";
    $code .= '    <'.$content.'>'."\n";
    $code .= '        <'.$label.'>Account</'.$label.'>'."\n";
    $code .= '        <'.$item.'>Profile</'.$item.'>'."\n";
    $code .= '        <'.$separator.' />'."\n";
    $code .= '        '.PlaybookCode::openingTag($item, [
        PlaybookCode::attribute('variant', 'danger'),
        PlaybookCode::attribute('kbd', '⌘⌫'),
    ]).'Delete'.PlaybookCode::closingTag($item)."\n";
    $code .= '    </'.$content.'>'."\n";
    $code .= PlaybookCode::closingTag($menu);

    echo $code;
@endphp
