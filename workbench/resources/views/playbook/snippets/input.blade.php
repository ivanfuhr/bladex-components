@php
    use Workbench\App\Playbook\PlaybookCode;

    $invalid = (bool) ($state['invalid'] ?? false);
    $disabled = (bool) ($state['disabled'] ?? false);
    $readonly = (bool) ($state['readonly'] ?? false);
    $showAffixes = (bool) ($state['show_affixes'] ?? false);
    $showPrefixSuffix = (bool) ($state['show_prefix_suffix'] ?? false);
    $prefix = $showPrefixSuffix ? 'https://' : null;
    $suffix = $showPrefixSuffix ? '.com' : null;

    $tag = PlaybookCode::component('input');

    $open = PlaybookCode::openingTag($tag, array_filter([
        PlaybookCode::attribute('name', 'email'),
        PlaybookCode::attribute('type', 'email'),
        PlaybookCode::attribute('placeholder', 'you@example.com'),
        PlaybookCode::boolean('invalid', $invalid),
        PlaybookCode::boolean('disabled', $disabled),
        PlaybookCode::boolean('readonly', $readonly),
        PlaybookCode::bound('prefix', $prefix),
        PlaybookCode::bound('suffix', $suffix),
    ]));

    $body = '';
    if ($showAffixes) {
        $body .= "    <x-slot:leading>\n";
        $body .= '        <'.PlaybookCode::component('icons.loading').' />'."\n";
        $body .= "    </x-slot:leading>\n";
        $body .= "    <x-slot:trailing>\n";
        $body .= "        <span class=\"text-xs font-medium text-zinc-500\">Clear</span>\n";
        $body .= "    </x-slot:trailing>\n";
    }

    $code = $open."\n".$body.PlaybookCode::closingTag($tag);

    echo $code;
@endphp
