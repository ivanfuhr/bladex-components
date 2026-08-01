@php
    use Workbench\App\Playbook\PlaybookCode;

    $showFooter = (bool) ($state['show_footer'] ?? true);

    $card = PlaybookCode::component('card');
    $header = PlaybookCode::component('card.header');
    $title = PlaybookCode::component('card.title');
    $description = PlaybookCode::component('card.description');
    $content = PlaybookCode::component('card.content');
    $footer = PlaybookCode::component('card.footer');
    $button = PlaybookCode::component('button');

    $code = '<'.$card.'>'."\n";
    $code .= '    <'.$header.'>'."\n";
    $code .= '        <'.$title.'>Account</'.$title.'>'."\n";
    $code .= '        <'.$description.'>Manage your profile.</'.$description.'>'."\n";
    $code .= '    </'.$header.'>'."\n";
    $code .= '    <'.$content.'>…</'.$content.'>'."\n";

    if ($showFooter) {
        $code .= '    <'.$footer.'>'."\n";
        $code .= '        '.PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'primary')]).'Save'.PlaybookCode::closingTag($button)."\n";
        $code .= '    </'.$footer.'>'."\n";
    }

    $code .= PlaybookCode::closingTag($card);

    echo $code;
@endphp
