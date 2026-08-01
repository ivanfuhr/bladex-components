@php
    use Workbench\App\Playbook\PlaybookCode;

    $showIcon = (bool) ($state['show_icon'] ?? true);
    $outline = (bool) ($state['outline'] ?? false);
    $showActions = (bool) ($state['show_actions'] ?? true);

    $empty = PlaybookCode::component('empty');
    $header = PlaybookCode::component('empty.header');
    $media = PlaybookCode::component('empty.media');
    $title = PlaybookCode::component('empty.title');
    $description = PlaybookCode::component('empty.description');
    $content = PlaybookCode::component('empty.content');
    $button = PlaybookCode::component('button');

    $rootAttrs = $outline
        ? [PlaybookCode::attribute('class', 'border')]
        : [];

    $code = PlaybookCode::openingTag($empty, $rootAttrs)."\n";
    $code .= '    <'.$header.'>'."\n";

    if ($showIcon) {
        $code .= '        '.PlaybookCode::openingTag($media, [
            PlaybookCode::attribute('variant', 'icon'),
            PlaybookCode::attribute('icon', 'file'),
        ]).PlaybookCode::closingTag($media)."\n";
    }

    $code .= '        <'.$title.'>No projects yet</'.$title.'>'."\n";
    $code .= '        <'.$description.'>You haven\'t created any projects yet.</'.$description.'>'."\n";
    $code .= '    </'.$header.'>'."\n";

    if ($showActions) {
        $code .= '    <'.$content.'>'."\n";
        $code .= '        '.PlaybookCode::openingTag($button, [PlaybookCode::attribute('variant', 'primary')]).'Create project'.PlaybookCode::closingTag($button)."\n";
        $code .= '    </'.$content.'>'."\n";
    }

    $code .= PlaybookCode::closingTag($empty);

    echo $code;
@endphp
