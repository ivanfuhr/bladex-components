@php
    use Workbench\App\Playbook\PlaybookCode;

    $variant = ($state['variant'] ?? 'default') === 'default' ? null : (string) $state['variant'];

    $tabs = PlaybookCode::component('tabs');
    $list = PlaybookCode::component('tabs.list');
    $trigger = PlaybookCode::component('tabs.trigger');
    $content = PlaybookCode::component('tabs.content');

    $code = PlaybookCode::openingTag($tabs, array_filter([
        PlaybookCode::attribute('default-value', 'account'),
        PlaybookCode::attribute('variant', $variant),
    ]))."\n";
    $code .= '    <'.$list.'>'."\n";
    $code .= '        '.PlaybookCode::openingTag($trigger, [PlaybookCode::attribute('value', 'account')]).'Account'.PlaybookCode::closingTag($trigger)."\n";
    $code .= '        '.PlaybookCode::openingTag($trigger, [PlaybookCode::attribute('value', 'password')]).'Password'.PlaybookCode::closingTag($trigger)."\n";
    $code .= '    </'.$list.'>'."\n";
    $code .= '    '.PlaybookCode::openingTag($content, [PlaybookCode::attribute('value', 'account')]).'Account settings'.PlaybookCode::closingTag($content)."\n";
    $code .= '    '.PlaybookCode::openingTag($content, [PlaybookCode::attribute('value', 'password')]).'Password settings'.PlaybookCode::closingTag($content)."\n";
    $code .= PlaybookCode::closingTag($tabs);

    echo $code;
@endphp
