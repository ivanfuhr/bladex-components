@php
    use Workbench\App\Playbook\PlaybookCode;

    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : 'horizontal';
    $showSeparator = (bool) ($state['show_separator'] ?? false);
    $showText = (bool) ($state['show_text'] ?? false);

    $group = PlaybookCode::component('button-group');
    $button = PlaybookCode::component('button');
    $separator = PlaybookCode::component('button-group.separator');
    $text = PlaybookCode::component('button-group.text');

    $open = PlaybookCode::openingTag($group, array_filter([
        PlaybookCode::attribute('orientation', $orientation === 'horizontal' ? null : $orientation),
        'aria-label="Document actions"',
    ]));

    $inner = '';

    if ($showText) {
        $inner .= PlaybookCode::openingTag($text).'Export'.PlaybookCode::closingTag($text)."\n";
    }

    $inner .= PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'outline')]).'Archive'.PlaybookCode::closingTag($button)."\n";

    if ($showSeparator) {
        $inner .= '<'.$separator." />\n";
    }

    $inner .= PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'outline')]).'Report'.PlaybookCode::closingTag($button)."\n";
    $inner .= PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'outline')]).'Snooze'.PlaybookCode::closingTag($button);

    echo $open."\n".$inner."\n".PlaybookCode::closingTag($group);
@endphp
