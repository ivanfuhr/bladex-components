@php
    use Workbench\App\Playbook\PlaybookCode;

    $open = (bool) ($state['open'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);

    $collapsible = PlaybookCode::component('collapsible');
    $trigger = PlaybookCode::component('collapsible.trigger');
    $content = PlaybookCode::component('collapsible.content');

    $code = PlaybookCode::openingTag($collapsible, array_filter([
        PlaybookCode::boolean('open', $open, false),
        PlaybookCode::boolean('transition', $transition, false),
    ]))."\n";
    $code .= '    <'.$trigger.'>Toggle details</'.$trigger.'>'."\n";
    $code .= '    <'.$content.'>'."\n";
    $code .= '        Extra product information lives here.'."\n";
    $code .= '    </'.$content.'>'."\n";
    $code .= PlaybookCode::closingTag($collapsible);

    echo $code;
@endphp
