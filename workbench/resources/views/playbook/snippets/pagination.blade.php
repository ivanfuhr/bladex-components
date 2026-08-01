@php
    use Workbench\App\Playbook\PlaybookCode;

    $showEllipsis = (bool) ($state['show_ellipsis'] ?? true);

    $pagination = PlaybookCode::component('pagination');
    $content = PlaybookCode::component('pagination.content');
    $item = PlaybookCode::component('pagination.item');
    $previous = PlaybookCode::component('pagination.previous');
    $next = PlaybookCode::component('pagination.next');
    $link = PlaybookCode::component('pagination.link');
    $ellipsis = PlaybookCode::component('pagination.ellipsis');

    $code = '<'.$pagination.'>'."\n";
    $code .= '    <'.$content.'>'."\n";
    $code .= '        <'.$item.'>'."\n";
    $code .= '            '.PlaybookCode::selfClosingTag($previous, [PlaybookCode::attribute('href', '?page=1')])."\n";
    $code .= '        </'.$item.'>'."\n";
    $code .= '        <'.$item.'>'."\n";
    $code .= '            '.PlaybookCode::openingTag($link, [PlaybookCode::attribute('href', '?page=2'), ':is-active="true"']).'2'.PlaybookCode::closingTag($link)."\n";
    $code .= '        </'.$item.'>'."\n";

    if ($showEllipsis) {
        $code .= '        <'.$item.'>'."\n";
        $code .= '            <'.$ellipsis.' />'."\n";
        $code .= '        </'.$item.'>'."\n";
    }

    $code .= '        <'.$item.'>'."\n";
    $code .= '            '.PlaybookCode::selfClosingTag($next, [PlaybookCode::attribute('href', '?page=3')])."\n";
    $code .= '        </'.$item.'>'."\n";
    $code .= '    </'.$content.'>'."\n";
    $code .= PlaybookCode::closingTag($pagination);

    echo $code;
@endphp
