@php
    use Workbench\App\Playbook\PlaybookCode;

    $size = ($state['size'] ?? 'default') === 'sm' ? 'sm' : 'default';
    $flyout = (bool) ($state['flyout'] ?? false);
    $alert = (bool) ($state['alert'] ?? false);
    $dismissible = (bool) ($state['dismissible'] ?? true);
    $closable = (bool) ($state['closable'] ?? true);

    $dialog = PlaybookCode::component('dialog');
    $trigger = PlaybookCode::component('dialog.trigger');
    $content = PlaybookCode::component('dialog.content');
    $header = PlaybookCode::component('dialog.header');
    $title = PlaybookCode::component('dialog.title');
    $description = PlaybookCode::component('dialog.description');
    $footer = PlaybookCode::component('dialog.footer');
    $cancel = PlaybookCode::component('dialog.cancel');
    $action = PlaybookCode::component('dialog.action');
    $button = PlaybookCode::component('button');

    $contentOpen = PlaybookCode::openingTag($content, array_filter([
        PlaybookCode::attribute('size', $size, 'default'),
        PlaybookCode::boolean('flyout', $flyout),
        PlaybookCode::boolean('alert', $alert),
        PlaybookCode::boolean('dismissible', $dismissible, true),
        PlaybookCode::boolean('closable', $closable, true),
    ]));

    $code = PlaybookCode::openingTag($dialog, [])."\n";
    $code .= '    <'.$trigger.'>'."\n";
    $code .= '        <'.$button.' variant="outline">Open dialog</'.$button.'>'."\n";
    $code .= '    </'.$trigger.'>'."\n\n";
    $code .= '    '.$contentOpen."\n";
    $code .= '        <'.$header.'>'."\n";
    $code .= '            <'.$title.'>Title</'.$title.'>'."\n";
    $code .= '            <'.$description.'>Description copy.</'.$description.'>'."\n";
    $code .= '        </'.$header.'>'."\n\n";
    $code .= '        <'.$footer.'>'."\n";
    $code .= '            <'.$cancel.'>Cancel</'.$cancel.'>'."\n";
    $code .= '            <'.$action.'>Continue</'.$action.'>'."\n";
    $code .= '        </'.$footer.'>'."\n";
    $code .= '    </'.$content.'>'."\n";
    $code .= PlaybookCode::closingTag($dialog);

    echo $code;
@endphp
