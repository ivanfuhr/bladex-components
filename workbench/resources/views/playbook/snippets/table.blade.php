@php
    use Workbench\App\Playbook\PlaybookCode;

    $showCaption = (bool) ($state['show_caption'] ?? true);

    $table = PlaybookCode::component('table');
    $caption = PlaybookCode::component('table.caption');
    $header = PlaybookCode::component('table.header');
    $body = PlaybookCode::component('table.body');
    $row = PlaybookCode::component('table.row');
    $head = PlaybookCode::component('table.head');
    $cell = PlaybookCode::component('table.cell');

    $code = '<'.$table.'>'."\n";

    if ($showCaption) {
        $code .= '    <'.$caption.'>Recent invoices</'.$caption.'>'."\n";
    }

    $code .= '    <'.$header.'>'."\n";
    $code .= '        <'.$row.'>'."\n";
    $code .= '            <'.$head.'>Invoice</'.$head.'>'."\n";
    $code .= '            <'.$head.'>Amount</'.$head.'>'."\n";
    $code .= '        </'.$row.'>'."\n";
    $code .= '    </'.$header.'>'."\n";
    $code .= '    <'.$body.'>'."\n";
    $code .= '        <'.$row.'>'."\n";
    $code .= '            '.PlaybookCode::openingTag($cell, [PlaybookCode::attribute('variant', 'strong')]).'INV001'.PlaybookCode::closingTag($cell)."\n";
    $code .= '            <'.$cell.'>$250.00</'.$cell.'>'."\n";
    $code .= '        </'.$row.'>'."\n";
    $code .= '    </'.$body.'>'."\n";
    $code .= PlaybookCode::closingTag($table);

    echo $code;
@endphp
