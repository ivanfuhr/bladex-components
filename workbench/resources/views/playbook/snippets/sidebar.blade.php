@php
    use Workbench\App\Playbook\PlaybookCode;

    $collapsible = (string) ($state['collapsible'] ?? 'icon');
    $variant = (string) ($state['variant'] ?? 'sidebar');
    $defaultOpen = (bool) ($state['default_open'] ?? true);

    $provider = PlaybookCode::component('sidebar.provider');
    $sidebar = PlaybookCode::component('sidebar');
    $header = PlaybookCode::component('sidebar.header');
    $content = PlaybookCode::component('sidebar.content');
    $footer = PlaybookCode::component('sidebar.footer');
    $group = PlaybookCode::component('sidebar.group');
    $groupLabel = PlaybookCode::component('sidebar.group-label');
    $groupContent = PlaybookCode::component('sidebar.group-content');
    $menu = PlaybookCode::component('sidebar.menu');
    $menuItem = PlaybookCode::component('sidebar.menu-item');
    $menuButton = PlaybookCode::component('sidebar.menu-button');
    $inset = PlaybookCode::component('sidebar.inset');
    $trigger = PlaybookCode::component('sidebar.trigger');
    $rail = PlaybookCode::component('sidebar.rail');

    $code = PlaybookCode::openingTag($provider, array_filter([
        PlaybookCode::boolean('default-open', $defaultOpen, true),
    ]))."\n";
    $code .= '    '.PlaybookCode::openingTag($sidebar, array_filter([
        PlaybookCode::attribute('collapsible', $collapsible, 'offcanvas'),
        PlaybookCode::attribute('variant', $variant, 'sidebar'),
    ]))."\n";
    $code .= '        <'.$header.'>'."\n";
    $code .= '            <'.$menu.'>'."\n";
    $code .= '                <'.$menuItem.'>'."\n";
    $code .= '                    <'.$menuButton.' href="/" class="font-semibold">Stencil</'.$menuButton.'>'."\n";
    $code .= '                </'.$menuItem.'>'."\n";
    $code .= '            </'.$menu.'>'."\n";
    $code .= '        </'.$header.'>'."\n";
    $code .= '        <'.$content.'>'."\n";
    $code .= '            <'.$group.'>'."\n";
    $code .= '                <'.$groupLabel.'>Platform</'.$groupLabel.'>'."\n";
    $code .= '                <'.$groupContent.'>'."\n";
    $code .= '                    <'.$menu.'>'."\n";
    $code .= '                        <'.$menuItem.'>'."\n";
    $code .= '                            <'.$menuButton.' href="/" active>Home</'.$menuButton.'>'."\n";
    $code .= '                        </'.$menuItem.'>'."\n";
    $code .= '                    </'.$menu.'>'."\n";
    $code .= '                </'.$groupContent.'>'."\n";
    $code .= '            </'.$group.'>'."\n";
    $code .= '        </'.$content.'>'."\n";
    $code .= '        <'.$footer.'>...</'.$footer.'>'."\n";
    $code .= '        <'.$rail.' />'."\n";
    $code .= '    '.PlaybookCode::closingTag($sidebar)."\n";
    $code .= '    <'.$inset.'>'."\n";
    $code .= '        <'.$trigger.' />'."\n";
    $code .= '        {{ $slot }}'."\n";
    $code .= '    </'.$inset.'>'."\n";
    $code .= PlaybookCode::closingTag($provider);

    echo $code;
@endphp
