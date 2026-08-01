@php
    use Workbench\App\Playbook\PlaybookCode;

    $command = PlaybookCode::component('command');
    $dialog = PlaybookCode::component('command.dialog');
    $group = PlaybookCode::component('command.group');
    $item = PlaybookCode::component('command.item');
    $separator = PlaybookCode::component('command.separator');
    $trigger = PlaybookCode::component('dialog.trigger');
    $button = PlaybookCode::component('button');

    $code = PlaybookCode::openingTag($trigger, [PlaybookCode::attribute('name', 'palette')])."\n";
    $code .= '    '.PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'outline')]).'Search…'.PlaybookCode::closingTag($button)."\n";
    $code .= PlaybookCode::closingTag($trigger)."\n\n";
    $code .= PlaybookCode::openingTag($dialog, [
        PlaybookCode::attribute('name', 'palette'),
        PlaybookCode::attribute('shortcut', 'meta.k'),
    ])."\n";
    $code .= '    '.PlaybookCode::openingTag($command, [
        PlaybookCode::attribute('placeholder', 'Type a command or search…'),
    ])."\n";
    $code .= '        '.PlaybookCode::openingTag($group, [PlaybookCode::attribute('heading', 'Suggestions')])."\n";
    $code .= '            '.PlaybookCode::openingTag($item, [
        PlaybookCode::attribute('value', 'calendar'),
        PlaybookCode::attribute('kbd', '⌘C'),
    ]).'Calendar'.PlaybookCode::closingTag($item)."\n";
    $code .= '        '.PlaybookCode::closingTag($group)."\n";
    $code .= '        <'.$separator.' />'."\n";
    $code .= '        '.PlaybookCode::openingTag($group, [PlaybookCode::attribute('heading', 'Settings')])."\n";
    $code .= '            '.PlaybookCode::openingTag($item, [
        PlaybookCode::attribute('value', 'profile'),
        PlaybookCode::attribute('kbd', '⌘P'),
    ]).'Profile'.PlaybookCode::closingTag($item)."\n";
    $code .= '        '.PlaybookCode::closingTag($group)."\n";
    $code .= '    '.PlaybookCode::closingTag($command)."\n";
    $code .= PlaybookCode::closingTag($dialog);

    echo $code;
@endphp
