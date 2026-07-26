@php
    use Workbench\App\Playbook\PlaybookCode;

    $variant = (string) $state['variant'];
    $size = $state['size'] === 'default' ? null : (string) $state['size'];
    $type = (string) $state['type'];
    $href = ($state['as_link'] ?? false) ? 'https://example.com' : null;
    $square = (bool) ($state['square'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $showAffixes = (bool) ($state['show_affixes'] ?? false);

    $tag = PlaybookCode::component('button');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('variant', $variant, 'outline'),
        PlaybookCode::bound('size', $size),
        PlaybookCode::attribute('type', $type, 'button'),
        PlaybookCode::attribute('href', $href),
        PlaybookCode::boolean('square', $square),
        PlaybookCode::boolean('disabled', $disabled),
    ]));

    $body = '';
    if ($showAffixes) {
        $body .= "    <x-slot:leading>\n";
        $body .= '        <'.PlaybookCode::component('icons.loading').' class="animate-spin" />'."\n";
        $body .= "    </x-slot:leading>\n";
    }

    if ($square && ! $showAffixes) {
        $body .= '    <'.PlaybookCode::component('icons.loading').' />'."\n";
    } else {
        $body .= "    Save changes\n";
    }

    if ($showAffixes) {
        $body .= "    <x-slot:trailing>\n";
        $body .= "        <span aria-hidden=\"true\">→</span>\n";
        $body .= "    </x-slot:trailing>\n";
    }

    $code = $open."\n".$body.PlaybookCode::closingTag($tag);

    echo $code;
@endphp
