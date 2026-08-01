@php
    use Workbench\App\Playbook\PlaybookCode;

    $orientation = ($state['orientation'] ?? 'horizontal') === 'vertical' ? 'vertical' : null;
    $linear = (bool) ($state['linear'] ?? true);

    $stepper = PlaybookCode::component('stepper');
    $list = PlaybookCode::component('stepper.list');
    $item = PlaybookCode::component('stepper.item');
    $trigger = PlaybookCode::component('stepper.trigger');
    $indicator = PlaybookCode::component('stepper.indicator');
    $title = PlaybookCode::component('stepper.title');
    $description = PlaybookCode::component('stepper.description');
    $separator = PlaybookCode::component('stepper.separator');
    $content = PlaybookCode::component('stepper.content');
    $navigation = PlaybookCode::component('stepper.navigation');
    $previous = PlaybookCode::component('stepper.previous');
    $next = PlaybookCode::component('stepper.next');

    $code = PlaybookCode::openingTag($stepper, array_filter([
        PlaybookCode::attribute('default-value', 'account'),
        PlaybookCode::attribute('orientation', $orientation),
        $linear ? null : PlaybookCode::boolean('linear', false, true),
    ]))."\n";
    $code .= '    <'.$list.'>'."\n";
    $code .= '        '.PlaybookCode::openingTag($item, [
        PlaybookCode::attribute('value', 'account'),
        PlaybookCode::attribute('step', 1),
    ])."\n";
    $code .= '            <'.$trigger.'>'."\n";
    $code .= '                <'.$indicator.' />'."\n";
    $code .= '                <'.$title.'>Account'.PlaybookCode::closingTag($title)."\n";
    $code .= '            </'.$trigger.'>'."\n";
    $code .= '            <'.$separator.' />'."\n";
    $code .= '        </'.$item.'>'."\n";
    $code .= '        '.PlaybookCode::openingTag($item, [
        PlaybookCode::attribute('value', 'workspace'),
        PlaybookCode::attribute('step', 2),
    ])."\n";
    $code .= '            <'.$trigger.'>'."\n";
    $code .= '                <'.$indicator.' />'."\n";
    $code .= '                <'.$title.'>Workspace'.PlaybookCode::closingTag($title)."\n";
    $code .= '            </'.$trigger.'>'."\n";
    $code .= '        </'.$item.'>'."\n";
    $code .= '    </'.$list.'>'."\n";
    $code .= '    '.PlaybookCode::openingTag($content, [PlaybookCode::attribute('value', 'account')]).'Account details'.PlaybookCode::closingTag($content)."\n";
    $code .= '    <'.$navigation.'>'."\n";
    $code .= '        <'.$previous.' />'."\n";
    $code .= '        <'.$next.' />'."\n";
    $code .= '    </'.$navigation.'>'."\n";
    $code .= PlaybookCode::closingTag($stepper);

    echo $code;
@endphp
