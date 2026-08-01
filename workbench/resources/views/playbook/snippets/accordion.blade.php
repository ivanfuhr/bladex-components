@php
    use Workbench\App\Playbook\PlaybookCode;

    $exclusive = (bool) ($state['exclusive'] ?? true);
    $bordered = (bool) ($state['bordered'] ?? true);
    $transition = (bool) ($state['transition'] ?? true);

    $accordion = PlaybookCode::component('accordion');
    $item = PlaybookCode::component('accordion.item');
    $trigger = PlaybookCode::component('accordion.trigger');
    $content = PlaybookCode::component('accordion.content');

    $open = PlaybookCode::openingTag($accordion, array_filter([
        PlaybookCode::boolean('exclusive', $exclusive, false),
        PlaybookCode::boolean('bordered', $bordered, false),
        PlaybookCode::boolean('transition', $transition, false),
    ]));

    $code = $open."\n";
    $code .= '    '.PlaybookCode::openingTag($item, array_filter([
        PlaybookCode::attribute('value', 'shipping'),
        ':expanded="true"',
    ]))."\n";
    $code .= '        <'.$trigger.'>What are your shipping options?</'.$trigger.'>'."\n";
    $code .= '        <'.$content.'>'."\n";
    $code .= '            Standard (5–7 days), express (2–3 days), and overnight.'."\n";
    $code .= '        </'.$content.'>'."\n";
    $code .= '    </'.$item.'>'."\n\n";
    $code .= '    '.PlaybookCode::openingTag($item, [
        PlaybookCode::attribute('heading', 'What is your return policy?'),
    ])."\n";
    $code .= '        30-day money-back guarantee on unused items.'."\n";
    $code .= '    </'.$item.'>'."\n";
    $code .= PlaybookCode::closingTag($accordion);

    echo $code;
@endphp
