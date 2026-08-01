@php
    use Workbench\App\Playbook\PlaybookCode;

    $separator = ($state['separator'] ?? 'chevron') === 'slash' ? 'slash' : null;

    $breadcrumb = PlaybookCode::component('breadcrumb');
    $list = PlaybookCode::component('breadcrumb.list');
    $item = PlaybookCode::component('breadcrumb.item');
    $sep = PlaybookCode::component('breadcrumb.separator');
    $page = PlaybookCode::component('breadcrumb.page');

    $sepAttrs = $separator ? [PlaybookCode::attribute('type', $separator)] : [];

    $code = '<'.$breadcrumb.'>'."\n";
    $code .= '    <'.$list.'>'."\n";
    $code .= '        '.PlaybookCode::openingTag($item, [PlaybookCode::attribute('href', '/')]).'Home'.PlaybookCode::closingTag($item)."\n";
    $code .= '        '.PlaybookCode::selfClosingTag($sep, $sepAttrs)."\n";
    $code .= '        '.PlaybookCode::openingTag($item, [PlaybookCode::attribute('href', '/settings')]).'Settings'.PlaybookCode::closingTag($item)."\n";
    $code .= '        '.PlaybookCode::selfClosingTag($sep, $sepAttrs)."\n";
    $code .= '        <'.$item.'>'."\n";
    $code .= '            <'.$page.'>Profile</'.$page.'>'."\n";
    $code .= '        </'.$item.'>'."\n";
    $code .= '    </'.$list.'>'."\n";
    $code .= PlaybookCode::closingTag($breadcrumb);

    echo $code;
@endphp
